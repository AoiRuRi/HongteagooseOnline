<?php
session_start();

// 检查用户是否已登录
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
    $username = $_SESSION['username'];
    $account = $_SESSION['account'];

    // 连接数据库
    $host = '192.168.2.200';
    $user = 'hongteag_goose';
    $password = 'ab7777xy';
    $dbname = 'hongteag_goose';
    $conn = new mysqli($host, $user, $password, $dbname);
    $conn->set_charset("utf8");

    // 检查连接是否成功
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }

    if (isset($_POST['complete_order'])) {
        // 从购物车中读取相关商品信息
        $sql = "SELECT Purchase_OrderID, Product_ID, Sales_Quantity, TotalPrice FROM shoppingcart WHERE Account = '$account' AND TotalPrice IS NOT NULL AND TotalPrice <> 0";
        $shippingAddress = $_POST['shipping-address'];
        $shippingFee = 100;
        $result = $conn->query($sql);
         // 从查询结果中获取 Purchase_OrderID
         $row = $result->fetch_assoc();
         $purchaseOrderID = $row['Purchase_OrderID'];
         $orderID = $purchaseOrderID;
        
        // 检查查询结果
        if ($result) {
           
    
            // 插入运费信息到 purchase_order 表
            $insertShippingFeeSql = "INSERT INTO purchase_order (Product_ID, ProductName, Purchase_OrderID, Purchase_Price
            , status, Account, Address, Date) 
            VALUES (10, '運費', '$orderID', '$shippingFee', '未付款', '$account', '$shippingAddress', NOW())";
            $conn->query($insertShippingFeeSql);
    
            // 复制结果集到新变量
            $resultCopy = $conn->query($sql);
    
            // 将商品信息插入到 purchase_order 表中
            while ($row = $resultCopy->fetch_assoc()) {
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
        }
        
        //寫入訂單後將對應資訊從shoppingcart清除
        $deleteSql = "UPDATE shoppingcart SET Product_ID = NULL, Sales_Quantity = NULL, Price = NULL, TotalPrice = NULL WHERE Purchase_OrderID = '$orderID'";
$conn->query($deleteSql);

$deleteSql = "DELETE FROM shoppingcart  WHERE Account = '$account' AND TotalPrice IS NOT NULL AND TotalPrice <> 0";
$conn->query($deleteSql);

        
    
        // 关闭数据库连接
        $conn->close();
        
        // 重定向到订单完成页面或其他页面
        header("Location:../orders.php");
        exit();
    }
    
}
?>
