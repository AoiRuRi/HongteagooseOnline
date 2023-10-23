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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cartItems"],$_POST["cartId"], $_POST["productName"], $_POST["quantity"], $_POST["productPrice"], $_POST["totalPrice"],$_POST["account"])) {
    // 購物車的商品資訊
    $cartItems = $_POST["cartItems"];
    $cartId = $_POST["cartId"];
    $productName = $_POST["productName"];
    $quantity = $_POST["quantity"];
    $productPrice = $_POST["productPrice"];
    $totalPrice = $_POST["totalPrice"];
    $account = $_POST["account"];
    

    // 產生隨機的Cart_ID
    //$cartId = generateRandomCartId(); // 自行實作生成隨機Cart_ID的方法

     // 呼叫寫入資料庫的函式
     writeToDatabase($cartItems,$cartId, $productName, $quantity, $productPrice, $totalPrice,$account);
    } else {
        // 處理未正確傳遞參數或非AJAX POST請求的情況
        echo json_encode(array("status" => "error"));
    }

   
    function writeToDatabase($cartItems,$cartId,  $productName, $quantity, $productPrice, $totalPrice,$account)
{   
    global $conn; // 使用全局的 $conn 變數

    if (!is_array($cartItems) || empty($cartItems)) {
        echo json_encode(array("status" => "error", "message" => "購物車內沒有商品"));
        return;
    }

     // 使用 prepared statement 防止 SQL Injection
     $stmt = $conn->prepare("INSERT INTO shoppingcart (Purchase_OrderID	, Product_ID, Sales_Quantity, Price, TotalPrice, Account) VALUES (?, ?, ?, ?, ?, ?)");
        
   
     // 將資料綁定到 prepared statement 的參數中
    foreach ($cartItems as $item) {
        $productName = $item["productName"];
        $quantity = $item["quantity"];
        $productPrice = $item["productPrice"];
        $totalPrice = $item["totalPrice"];
        $account = $item["account"];
        $productId = getProductIDFromDatabase($conn, $productName); // 自行實作取得 Product_ID 的方法

        $stmt->bind_param("siidds", $cartId, $productId, $quantity, $productPrice, $totalPrice, $account);

        // 在写入数据库之前
error_log("Trying to insert data into database. Account: " . $account . ", CartID: " . $cartId);

        // 執行 prepared statement
        if ($stmt->execute()) {
            // 成功寫入資料庫
            error_log("Data successfully inserted into database. Account:" . $account . ", CartID: " . $cartId);
            echo json_encode(array("status" => "success"));
        } else {
            // 寫入資料庫失敗
            error_log("Error while inserting data into database. Account: " . $account . ", CartID: " . $cartId . ", Error: " . $stmt->error);
            echo json_encode(array("status" => "error"));
        }
    }
    // 關閉 prepared statement
    $stmt->close();
    // 關閉資料庫連線
$conn->close();
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

    // 重定向到下個頁面
    header("Location:../Payment.php");
    exit();
}
?>
