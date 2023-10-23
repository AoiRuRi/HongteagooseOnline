<?php
// 設定資料庫連線參數
$host = '192.168.2.200'; // 或 '127.0.0.1'
$user = 'hongteag_goose'; // 使用者帳號
$password = 'ab7777xy'; // 使用者密碼
$dbname = 'hongteag_goose'; // 資料庫名稱

// 建立資料庫連線
$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset("utf8");
// 檢查連線是否成功
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

// 確認是否有 POST 請求
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 獲取 POST 請求中的數據
    $newsID = $_POST['newsID'];
    $newsDate = $_POST['newsDate'];
    $newsContent = $_POST['newsContent'];

    // 更新資料庫中的紀錄之前加入 echo 語句
echo $newsDate . ' ' . $newsContent;

       // 更新資料庫中的紀錄
       if (!empty($newsID)) {
        $sql = "UPDATE news SET newsDate = '$newsDate', newsContent = '$newsContent' WHERE newsID = '$newsID'";

        $result = $conn->query($sql);

        if ($result) {
            // 更新成功
            echo "資料已成功更新！";
        } else {
            // 更新失敗
            echo "更新資料時發生錯誤：" . $conn->error;
        }
    } else {
        // newsID 為空，表示沒有正確接收到該值
        echo "錯誤：未接收到 newsID。";
    }
}
// 關閉資料庫連線
$conn->close();
?>
