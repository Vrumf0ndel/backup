<?php

declare(strict_types=1);


/**
 * Nextcloud - Backup
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Maxence Lange <maxence@artificial-owl.com>
 * @copyright 2021, Maxence Lange <maxence@artificial-owl.com>
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */


namespace OCA\Backup\Command;


use ArtificialOwl\MySmallPhpTools\Exceptions\RequestNetworkException;
use ArtificialOwl\MySmallPhpTools\Exceptions\SignatoryException;
use ArtificialOwl\MySmallPhpTools\Exceptions\SignatureException;
use ArtificialOwl\MySmallPhpTools\Exceptions\WellKnownLinkNotFoundException;
use ArtificialOwl\MySmallPhpTools\Model\SimpleDataStore;
use ArtificialOwl\MySmallPhpTools\Traits\Nextcloud\nc23\TNC23WellKnown;
use OC\Core\Command\Base;
use OCA\Backup\AppInfo\Application;
use OCA\Backup\Db\RemoteRequest;
use OCA\Backup\Exceptions\RemoteInstanceDuplicateException;
use OCA\Backup\Exceptions\RemoteInstanceNotFoundException;
use OCA\Backup\Exceptions\RemoteInstanceUidException;
use OCA\Backup\Model\RemoteInstance;
use OCA\Backup\Service\RemoteStreamService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;


/**
 * Class RemoteAdd
 *
 * @package OCA\Backup\Command
 */
class RemoteAdd extends Base {
	use TNC23WellKnown;


	/** @var RemoteRequest */
	private $remoteRequest;

	/** @var RemoteStreamService */
	private $remoteStreamService;


	/**
	 * RemoteAdd constructor.
	 *
	 * @param RemoteRequest $remoteRequest
	 * @param RemoteStreamService $remoteStreamService
	 */
	public function __construct(
		RemoteRequest $remoteRequest,
		RemoteStreamService $remoteStreamService
	) {
		parent::__construct();

		$this->remoteRequest = $remoteRequest;
		$this->remoteStreamService = $remoteStreamService;
	}


	/**
	 *
	 */
	protected function configure() {
		$this->setName('backup:remote:add')
			 ->setDescription('Add remote instances to store your backups')
			 ->addArgument('address', InputArgument::REQUIRED, 'address of the remote instance of Nextcloud');
	}


	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 *
	 * @return int
	 * @throws RequestNetworkException
	 * @throws SignatureException
	 * @throws WellKnownLinkNotFoundException
	 * @throws SignatoryException
	 * @throws RemoteInstanceUidException
	 * @throws RemoteInstanceDuplicateException
	 */
	protected function execute(InputInterface $input, OutputInterface $output): int {
		$address = $input->getArgument('address');

		$resource = $this->getCurrentResourceFromAddress($output, $address);

		$knownInstance = null;
		try {
			$knownInstance = $this->remoteRequest->getFromHref($resource->g('id'));
		} catch (RemoteInstanceNotFoundException $e) {
		}

		try {
			/** @var RemoteInstance $remoteSignatory */
			$remoteSignatory = $this->remoteStreamService->retrieveSignatory($resource->g('id'), true);
		} catch (SignatureException $e) {
			throw new SignatureException($address . ' cannot auth its identity: ' . $e->getMessage());
		}

		try {
			$duplicateInstance = $this->remoteRequest->getFromInstance($address);
			if ($duplicateInstance->getId() !== $remoteSignatory->getId()) {
				throw new RemoteInstanceDuplicateException(
					'There is already a known instance with same ADDRESS but different HREF. Please remove it first!'
				);
			}
		} catch (RemoteInstanceNotFoundException $e) {
		}

		$remoteSignatory->setInstance($address);
		if (!is_null($knownInstance)) {
			if ($remoteSignatory->getInstance() !== $knownInstance->getInstance()) {
				throw new RemoteInstanceDuplicateException(
					'There is already a known instance with same HREF but different ADDRESS ('
					. $knownInstance->getInstance() . '). Please remove it first!'
				);
			}

			if ($remoteSignatory->getUid(true) !== $knownInstance->getUid()) {
				$output->writeln('');
				$output->writeln('<error>This instance is already known under an other identity!</error>');
				$output->writeln(
					'<error>Please CONFIRM with the admin of the remote instance before updating this known instance.</error>'
				);
				$helper = $this->getHelper('question');
				$question = new ConfirmationQuestion(
					'Are you sure you want to continue with the process ? (y/N)',
					false,
					'/^(y|Y)/i'
				);

				if (!$helper->ask($input, $output, $question)) {
					return 0;
				}
			}
		}

		$this->configureRemoteInstance($input, $output, $remoteSignatory, $knownInstance);
		$this->saveRemoteInstance($input, $output, $remoteSignatory);

		return 0;
	}


	/**
	 * @param OutputInterface $output
	 * @param string $address
	 *
	 * @return SimpleDataStore
	 * @throws RequestNetworkException
	 * @throws WellKnownLinkNotFoundException
	 */
	private function getCurrentResourceFromAddress(
		OutputInterface $output,
		string $address
	): SimpleDataStore {
		try {
			$webfinger = $this->getWebfinger($address, Application::APP_SUBJECT);
		} catch (RequestNetworkException $e) {
			throw new RequestNetworkException(
				$address
				. ' is not reachable or is not a instance of Nextcloud or do not have the Backup App installed'
			);
		}
		try {
			$backupLink = $this->extractLink(Application::APP_REL, $webfinger);
		} catch (WellKnownLinkNotFoundException $e) {
			throw new WellKnownLinkNotFoundException(
				$address
				. ' is not a instance of Nextcloud or do not have the Backup App installed and configured'
			);
		}

		$output->writeln(
			'Remote instance <info>' . $address . '</info> is using <info>' . $backupLink->getProperty('name')
			. ' v' . $backupLink->getProperty('version') . '</info>'
		);

		$resource = $this->getResourceFromLink($backupLink);
		$output->writeln('Authentication key: <info>' . $resource->g('uid') . '</info>');

		return $resource;
	}


	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @param RemoteInstance $remoteInstance
	 */
	private function configureRemoteInstance(
		InputInterface $input,
		OutputInterface $output,
		RemoteInstance $remoteInstance,
		?RemoteInstance $knownInstance
	): void {
		$outgoing = !(is_null($knownInstance)) && $knownInstance->isOutgoing();
		$incoming = !(is_null($knownInstance)) && $knownInstance->isIncoming();

		$output->writeln('');
		$helper = $this->getHelper('question');
		$question = new ConfirmationQuestion(
			'Do you want to use <info>' . $remoteInstance->getInstance()
			. '</info> as a remote instance to store your backup files ? '
			. ($outgoing ? '(Y/n)' : '(y/N)'),
			$outgoing,
			'/^(y|Y)/i'
		);

		$remoteInstance->setOutgoing($helper->ask($input, $output, $question));

		$question = new ConfirmationQuestion(
			'Do you want to allow <info>' . $remoteInstance->getInstance()
			. '</info> to store its backup files on your own instance ? '
			. ($incoming ? '(Y/n)' : '(y/N)'),
			$incoming,
			'/^(y|Y)/i'
		);

		$remoteInstance->setIncoming($helper->ask($input, $output, $question));
	}


	/**
	 * @throws RemoteInstanceUidException
	 */
	private function saveRemoteInstance(
		InputInterface $input,
		OutputInterface $output,
		RemoteInstance $remoteInstance
	): void {
		$output->writeln('');
		$output->writeln(
			'Using remote instance to store local backups: ' . ($remoteInstance->isOutgoing(
			) ? '<info>yes</info>' : '<comment>no</comment>')
		);
		$output->writeln(
			'Locally storing backups from remote instance: ' . ($remoteInstance->isIncoming(
			) ? '<info>yes</info>' : '<comment>no</comment>')
		);

		$helper = $this->getHelper('question');
		$question = new ConfirmationQuestion(
			'Please confirm those settings <info>(y/N)</info> ',
			false,
			'/^(y|Y)/i'
		);

		if (!$helper->ask($input, $output, $question)) {
			return;
		}

		$this->remoteRequest->insertOrUpdate($remoteInstance);
	}

}

