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

// 接收 AJAX 傳遞過來的訂單ID和新的狀態
$orderID = $_POST['orderID'];
$newStatus = $_POST['status'];

// 使用预处理语句来执行更新操作，防止 SQL 注入攻击
$sql = "UPDATE purchase_order SET Status = ? WHERE Purchase_OrderID = ?";
$stmt = $conn->prepare($sql);

if ($stmt === FALSE) {
    echo "狀態更新失敗: 預備語句準備失敗";
} else {
    // 绑定参数
    $stmt->bind_param("si", $newStatus, $orderID);

    // 执行预处理语句
    if ($stmt->execute()) {
        // 更新成功
        echo "狀態更新成功" . $stmt->error;
    } else {
        // 更新失败
        echo "狀態更新失敗: " . $stmt->error;
    }

    // 关闭预处理语句
    $stmt->close();
}

// 關閉資料庫連線
$conn->close();
?>
