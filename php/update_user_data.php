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

$Account = $_POST['Account'];
$Name = $_POST['Name'];
$Email = $_POST['Email'];
$Phone = $_POST['Phone'];
$Address = $_POST['Address'];

// 構建 SQL 更新語句
$sql = "UPDATE users SET Name='$Name', Email='$Email', Phone='$Phone', Address='$Address' WHERE Account='$Account'";

// 執行 SQL 語句
if ($conn->query($sql) === TRUE) {
    echo "數據已成功更新";
} else {
    echo "錯誤: " . $sql . "<br>" . $conn->error;
}

// 關閉資料庫連線
$conn->close();
?>