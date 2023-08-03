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

// 檢查是否有AJAX POST請求
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["productName"], $_POST["quantity"], $_POST["productPrice"], $_POST["totalPrice"])) {
    // 購物車的商品資訊
    $productName = $_POST["productName"];
    $quantity = $_POST["quantity"];
    $productPrice = $_POST["productPrice"];
    $totalPrice = $_POST["totalPrice"];

    // 產生隨機的Cart_ID
    $cartId = generateRandomCartId(); // 自行實作生成隨機Cart_ID的方法

    // 使用 prepared statement 防止 SQL Injection
    $stmt = $conn->prepare("INSERT INTO shoppingcart (Cart_ID, Product_ID, Sales_Quantity, Coupon_ID, TotalPrice) VALUES (?, ?, ?, ?, ?)");
    $productId = getProductIDFromDatabase($conn, $productName); // 自行實作取得 Product_ID 的方法

    // 將資料綁定到 prepared statement 的參數中
    $stmt->bind_param("siiid", $cartId, $productId, $quantity, $productPrice, $totalPrice);

    // 執行 prepared statement
    if ($stmt->execute()) {
        // 成功寫入資料庫
        echo json_encode(array("status" => "success"));
    } else {
        // 寫入資料庫失敗
        echo json_encode(array("status" => "error"));
    }

    // 關閉 prepared statement
    $stmt->close();
} else {
    // 處理未正確傳遞參數或非AJAX POST請求的情況
    echo json_encode(array("status" => "error"));
}

// 關閉資料庫連線
$conn->close();

// 自行實作生成隨機Cart_ID的方法
function generateRandomCartId()
{
     // 定義可能的字元，用於生成Cart_ID
     $characters = '0123456789';
     $cartId = '';
 
     // 定義Cart_ID的長度，這裡假設是10個字元長度
     $length = 4;
 
     // 生成隨機的Cart_ID
     for ($i = 0; $i < $length; $i++) {
         $cartId .= $characters[rand(0, strlen($characters) - 1)];
     }
 
     // 返回生成的Cart_ID
     return $cartId;
}

// 自行實作取得 Product_ID 的方法
function getProductIDFromDatabase($conn, $productName)
{
    // 使用 prepared statement 防止 SQL Injection
    $stmt = $conn->prepare("SELECT Product_ID FROM product WHERE Product_Name = ?");
    $stmt->bind_param("s", $productName);
    $stmt->execute();
    $result = $stmt->get_result();

    // 檢查查詢結果是否存在
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $productId = $row["Product_ID"];
    } else {
        // 若查詢結果不存在，可以根據需求進行處理，這裡假設返回-1表示未找到相應的Product_ID
        $productId = -1;
    }

    // 關閉 prepared statement
    $stmt->close();

    // 返回 Product_ID
    return $productId;
}
?>
