<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 獲取來自AJAX請求的資料
    $orderID = $_POST['orderID'];
    $transferCode = $_POST['transferCode'];

    // 設定資料庫連線參數
$host = '192.168.2.200'; // 或 '127.0.0.1'
$user = 'hongteag_goose'; // 使用者帳號
$password = 'ab7777xy'; // 使用者密碼
$dbname = 'hongteag_goose'; // 資料庫名稱
    $conn = new mysqli($host, $user, $password, $dbname);
    $conn->set_charset("utf8");
    // 檢查連接是否成功
    if ($conn->connect_error) {
        die("連接失敗: " . $conn->connect_error);
    }

    // 更新資料庫中的transfer欄位
    $updateSql = "UPDATE purchase_order SET Transfer = '$transferCode', Status = '待確認款項' WHERE Purchase_OrderID = $orderID";
    if ($conn->query($updateSql) === TRUE) {
        echo '更新成功';
    } else {
        echo '更新失敗: ' . $conn->error;
    }

    // 關閉資料庫連接
    $conn->close();
}
?>
