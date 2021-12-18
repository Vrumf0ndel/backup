OC.L10N.register(
    "backup",
    {
    "Scan Backup Folder" : "掃描備份資料夾",
    "Backup" : "備份",
    "Update on all Backup's event" : "更新所有備份事件",
    "complete" : "完成",
    "partial" : "部份",
    "seconds" : "秒",
    "minutes" : "分鐘",
    "hours" : "小時",
    "days" : "天",
    "A new restoring point ({type}) has been generated, requiring maintenance mode for {downtime}." : "已產生新還原點 ({type})，需要 {downtime} 的維護模式。",
    "Your system have been fully restored based on a restoring point from {date} (estimated rewind: {rewind})" : "您的系統已根據 {date} 的還原點完全還原（預估回溯：{rewind}）",
    "The file {file} have been restored based on a restoring point from {date} (estimated rewind: {rewind})" : "檔案 {file} 已根據 {date} 的還原點還原（預估回溯：{rewind}）",
    "Backup now. Restore later." : "立刻備份。稍後還原。",
    "The Backup App creates and stores backup images of your Nextcloud:\n\n- Backup the instance, its apps, your data and your database,\n- Administrator can configure the time slots for automated backup,\n- Full and Partial backup, with different frequencies,\n- 2-pass to limit downtime (maintenance mode) of your instance,\n- Compression and encryption,\n- Upload your encrypted backup on an external filesystem,\n- Download and search for your data,\n- Restore single file or the entire instance." : "備份應用程式建立並儲存您 Nextcloud 的備份映像檔：\n\n- 備份站台、應用程式、您的資料與您的資料庫，\n- 管理員可以設定自動備份的時段，\n- 完整與差異備份，可設定不同的頻率，\n- 2-pass 限制站台的停機（維護模式）時間，\n- 壓縮並加密，\n- 將您的加密備份上傳到外部檔案系統，\n- 下載並搜尋您的資料，\n- 還原單個檔案或整個站台。",
    "App Data" : "應用程式資料",
    "Choose where the backup app will initially store the restoring points." : "選擇備份應用程式還原點ㄧ開始儲存還原點的位置。",
    "Path in which to store the data. (ex: app_data)" : "儲存資料的路徑。（例如：app_data）",
    "Set as App Data" : "設定為應用程式資料",
    "Error" : "錯誤",
    "Changing the App Data will delete the data stored in the previous one including restoring points." : "變更應用程式資料將會刪除先前儲存的資料，包含還原點。",
    "I understand some data will be deleted." : "我了解部份資料將被刪除。",
    "Change the App Data" : "變更應用程式資料",
    "Local storage" : "本機儲存空間",
    "Unable to fetch app data" : "無法擷取應用程式資料",
    "App data has been set" : "應用程式資料已設定",
    "Unable to set app data" : "無法設定應用程式資料",
    "Restoring points locations" : "還原點位置",
    "Manage available storage locations for storing restoring points" : "管理用於儲存還原點的可用儲存位置",
    "Path in which to store the restoring points. (ex: backups)" : "儲存還原點的路徑。（例如：backups）",
    "Add new external location" : "新增外部位置",
    "External storage" : "外部儲存空間",
    "Restoring point location" : "還原點位置",
    "Actions" : "動作",
    "Delete" : "刪除",
    "No external storage available" : "無外部儲存空間可用",
    "If you want to store your restoring points on an external location, configure an external storage in the \"External storage\" app." : "若您想要將您的還原點儲存在外部位置，請在「外部儲存空間」應用程式中設定外部儲存空間。",
    "No external locations set" : "未設定外部位置",
    "You can add a new location with the above form." : "您可以使用上述表單新增位置。",
    "Unable to fetch external locations" : "無法擷取外部位置",
    "New external location added" : "已新增外部位置",
    "Unable to save new external location" : "無法儲存新外部位置",
    "External location deleted" : "已刪除外部位置",
    "Unable to delete the external location" : "無法刪除外部位置",
    "Backups configuration" : "備份設定",
    "General configuration on how and when your restoring points are created." : "關於如何與何時建立還原點的一般設定。",
    "Enable background tasks" : "啟用背景工作",
    "You can enable background task for backups. This means that the creation, maintenance and purges of backups will be done automatically." : "您可以為備份啟用背景工作。這代表了備份建立、維護與清除都會自動完成。",
    "Creation: New restoring points will be created according to the schedule." : "建立：將會根據計畫建立新的還原點。",
    "Maintenance: Restoring points will be packed and copied to potential external storages." : "維護：還原點將會被打包並複製到潛在的外部儲存空間。",
    "Purge: Old restoring points will be deleted automatically according to the retention policy." : "清除：舊的還原點將會根據保留策略自動刪除。",
    "Enable background tasks to automatically manage creation, maintenance and purge." : "啟用背景工作以自動管理建立、維護與清除。",
    "Backup schedule" : "備份計畫",
    "A full restoring point will be created {delayFullRestoringPoint} days after the last one between {timeSlotsStart}:00 and {timeSlotsEnd}:00 any day of the week." : "完整還原點將會在一週間的任何一天的 {timeSlotsStart}:00 到 {timeSlotsEnd}:00 間的最會一個還原點之後的 {delayFullRestoringPoint} 天建立。",
    "A full restoring point will be created {delayFullRestoringPoint} days after the last one between {timeSlotsStart}:00 and {timeSlotsEnd}:00 during weekends." : "將在周末 {timeSlotsStart}:00 和 {timeSlotsEnd}:00 之間的最後一個還原點之後 {delayFullRestoringPoint} 天建立一個完整還原點。",
    "A partial restoring point will be created {delayPartialRestoringPoint} days after the last one between {timeSlotsStart}:00 and {timeSlotsEnd}:00 any day of the week." : "將在一星期中的任何一天 {timeSlotsStart}:00 和 {timeSlotsEnd}:00 之間的最後一個還原點之後的 {delayPartialRestoringPoint} 天建立部分還原點。",
    "Limit restoring points creation to the following hours interval:" : "將還原點建立限制在以下小時間隔內：",
    "and" : "與",
    "Allow the creation of full restoring points during week day" : "允許在工作日建立完整還原點",
    "Time interval between two full restoring points" : "兩個完整還原點的時間間隔",
    "Time interval between two partial restoring points" : "兩個部份還原點的時間間隔",
    "Packing processing" : "打包處理",
    "Processing that will be done on the restoring points during the packing step." : "將在打包步驟期間在還原點上進行的處理。",
    "Encrypt restoring points" : "加密還原點",
    "Compress restoring points" : "壓縮還原點",
    "Retention policy" : "保留策略",
    "You can specify the number of restoring points to keep during a purge." : "您可以指定在清除期間要保留的還原點數量。",
    "Policy for the local app data" : "本機應用程式資料策略",
    "Policy for external storages" : "外部儲存空間策略",
    "Export backup configuration" : "匯出備份設定",
    "You can export your settings with the below button. The exported file is important as it allows you to restore your backup in case of full data lost. Keep it in a safe place!" : "您可以使用下方的按鈕匯出您的設定。匯出的檔案很重要，因為其讓您可以在遺失完整資料的情況下還原備份。請將其放在安全的地方！",
    "Export configuration" : "匯出設定",
    "Your settings export as been downloaded encrypted. To be able to decrypt it later, please keep the following private key in a safe place:" : "您的設定匯出已下載並加密。要在之後可以解密，請將以下私鑰放在安全的地方：",
    "Request the creation of a new restoring point now" : "立刻請求建立一個新的還原點",
    "The creation of a restoring point as been requested and will be initiated soon." : "已請求建立還原點，並將很快就會啟動。",
    "Create full restoring point" : "建立完整還原點",
    "Requesting a backup will put the server in maintenance mode." : "請求備份將會讓伺服器進入維護模式。",
    "I understand that the server will be put in maintenance mode." : "我了解伺服器將會進入維護模式。",
    "Cancel" : "取消",
    "Request {mode} restoring point" : "請求 {mode} 還原點",
    "Unable to fetch the settings" : "無法擷取設定",
    "Settings saved" : "設定已儲存",
    "Unable to save the settings" : "無法儲存設定",
    "Unable to request restoring point" : "無法請求還原點",
    "Unable to export settings" : "無法匯出設定",
    "_day_::_days_" : ["天"],
    "Scheduled" : "已安排",
    "Pending" : "擱置中",
    "Not completed" : "未完成",
    "Orphan" : "孤立",
    "Completed" : "已完成",
    "Not packed yet" : "尚未打包",
    "Packed" : "已打包",
    "Encrypted" : "已加密",
    "Compressed" : "已壓縮",
    "Restoring points history" : "還原點歷史",
    "List of the past and future restoring points" : "過去與未來的還原點清單",
    "Issue" : "問題",
    "Health" : "健康",
    "Status" : "狀態",
    "Date" : "日期",
    "ID" : "ID",
    "No issue" : "沒有問題",
    "Local" : "本機",
    "local" : "本機",
    "Next full restoring point" : "下一個完整還原點",
    "Next partial restoring point" : "下一個部份還原點",
    "Unable to fetch restoring points" : "無法擷取還原點"
},
"nplurals=1; plural=0;");