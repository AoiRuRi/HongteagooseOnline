<?php
// 建立與資料庫的連線，這部分需要您根據自己的資料庫設定進行修改
$host = '192.168.2.200';
$user = 'hongteag_goose';
$password = 'ab7777xy';
$dbname = 'hongteag_goose';
$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset("utf8");
// 檢查連線是否成功
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

// 取得商品價格的函式，根據您的資料庫結構進行修改
function getProductPriceFromDB($productName) {
    global $conn;
    $sql = "SELECT Product_price FROM product WHERE Product_name = '$productName'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['Product_price'];
    }
    return null;
}

// 處理前端送來的請求
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 取得前端送來的商品名稱
    $productName = $_POST['productName'];

    // 從資料庫取得商品價格
    $productPrice = getProductPriceFromDB($productName);

    // 回傳結果給前端
    if ($productPrice !== null) {
        echo json_encode(['status' => 'success', 'price' => $productPrice]);
    } else {
        echo json_encode(['status' => 'error', 'message' => '找不到商品價格']);
    }
}
?>
