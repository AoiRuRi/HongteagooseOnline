<?php
session_start();

// 檢查用戶是否已登錄
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
    $username = $_SESSION['username'];
    $account = $_SESSION['account'];

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

    if (isset($_POST['complete_order'])) {
        // 從購物車中讀取相關商品資訊
        $sql = "SELECT Cart_ID, Product_ID, Sales_Quantity, TotalPrice FROM shoppingcart WHERE Account = '$account'";
        $shippingAddress = $_POST['shipping-address'];
        $shippingFee = 100;
        $result = $conn->query($sql);
         // 生成随机的 8 位数字订单 ID
    $orderID = mt_rand(10000000, 99999999);
        
        // 插入运费信息到 purchase_order 表
    $insertShippingFeeSql = "INSERT INTO purchase_order (Product_ID, ProductName, Purchase_OrderID, Purchase_Quantity, Purchase_Price
    , status, Account, Address, Date) 
    VALUES (10, '運費', '$orderID', 1, '$shippingFee', '未付款', '$account', '$shippingAddress', NOW())";
$conn->query($insertShippingFeeSql);

        // 将商品信息插入到 purchase_order 表中
        while ($row = $result->fetch_assoc()) {
            // $orderID=$row['Cart_ID'];
            $productId = $row['Product_ID'];
            $quantity = $row['Sales_Quantity'];
            $price = $row['TotalPrice'];

         // 查询 Product 表来获取对应的 Product_name
         $productSql = "SELECT Product_name FROM product WHERE Product_ID = '$productId'";
         $productResult = $conn->query($productSql);
         $productRow = $productResult->fetch_assoc();
         $productName = $productRow['Product_name'];

            // 将商品信息插入 purchase_order 表中
            $insertSql = "INSERT INTO purchase_order (Product_ID, ProductName, Purchase_OrderID, Purchase_Quantity, Purchase_Price
            , status, Account, Address, Date) 
            VALUES ('$productId', '$productName', '$orderID', '$quantity', '$price', '未付款', '$account', '$shippingAddress', NOW())";
            $conn->query($insertSql);
        }

        //寫入訂單後將對應資訊從shoppingcart清除
         $deleteSql = "DELETE FROM shoppingcart WHERE Account = '$account'";
         $conn->query($deleteSql);

        // 关闭数据库连接
        $conn->close();
        // 重定向到订单完成页面或其他页面
        header("Location:../orders.php");
        exit();
    }
}
?>
