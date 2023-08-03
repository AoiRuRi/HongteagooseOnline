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
    $productID = $_POST['productID'];
    $productName = $_POST['productName'];
    $productImage = $_POST['productImage'];
    $productDescription = $_POST['productDescription'];
    $productPrice = $_POST['productPrice'];

    // 更新資料庫中的紀錄
    $sql = "UPDATE product SET Product_name = '$productName', Product_image = '$productImage', Product_description = '$productDescription', Product_price = '$productPrice' WHERE Product_ID = $productID";
    $result = $conn->query($sql);

    if ($result) {
        // 更新成功
        echo "資料已成功更新！";
    } else {
        // 更新失敗
        echo "更新資料時發生錯誤：" . $conn->error;
    }
}
// 關閉資料庫連線
$conn->close();
?>
