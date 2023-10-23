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
    $productID = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productDescription = $_POST['product_description'];
    $productPrice = $_POST['product_price'];

    // 获取新上传的图片文件
    $newImage = $_FILES['image'];

    // 检查是否有新图片上传
if (!empty($newImage['tmp_name'])) {
    // 处理文件上传
    $uploadDir = '../images/';
    $newImageName = $productID . '_' . $newImage['name']; // 你可以使用不同的命名方案
    $newImagePath = $uploadDir . $newImageName;

    if (move_uploaded_file($newImage['tmp_name'], $newImagePath)) {
        // 图片成功移动到服务器上的 images 文件夹
        // 更新資料庫中的紀錄
    $sql = "UPDATE product SET Product_name = '$productName', Product_image = '$newImagePath',Product_description = '$productDescription', Product_price = '$productPrice' WHERE Product_ID = $productID";
    $result = $conn->query($sql);

    if ($result) {
        // 更新成功
        echo "資料已成功更新！";
    } else {
        // 更新失敗
        echo "更新資料時發生錯誤：" . $conn->error;
    }
    } else {
        echo "文件上传失败";
        // 此时不应该执行数据库更新操作
        exit; // 终止脚本执行
    }
}
    // 更新資料庫中的紀錄
    $sql = "UPDATE product SET Product_name = '$productName',  Product_description = '$productDescription', Product_price = '$productPrice' WHERE Product_ID = $productID";
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
