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
        


        // LINE 訂單訊息傳送
        
        // 設定資料庫連線參數
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
        $linesql = "SELECT Line_ID FROM users WHERE Account = '$account'";
        $result = $conn->query($linesql);

        if ($result) {
            if ($result->num_rows > 0) {  // 此處使用 $result->num_rows
                $row = $result->fetch_assoc();  // 此處使用 $result->fetch_assoc()
                $lineid = $row['Line_ID'];  // 此處使用正確的欄位名稱

                $access_token = 'PmAFKuI7Q0plDHacuMsqdqLqUBmjM7g3jKNvyZFxlxUU60ws60gFln3DOsqg83+P6roow5o6fqL1toSBNTJO/vqdqT2XdVZXR2amIjWvPre+SAQR3Tu89T4EeER9XQ+IMkbDd6sjTW60JO0vU2HyUgdB04t89/1O/w1cDnyilFU=';
                $to_user_id = $lineid; 
                
                $message = "您已下單成功 ( 單號：".$orderID." ) \n請使用選單中訂單查詢，查看訂單狀態";

                $data = [
                    'to' => $to_user_id,
                    'messages' => [
                        [
                            'type' => 'text',
                            'text' => $message,
                        ],
                    ],
                ];

                $ch = curl_init('https://api.line.me/v2/bot/message/push');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $access_token,
                ]);

                $result = curl_exec($ch);

                if ($result === false) {
                    echo 'Curl error: ' . curl_error($ch);
                } else {
                    echo 'Message sent!';
                }

                curl_close($ch);
                // 這裡您可以使用 $lineid 來進一步的處理
            } else {
                echo "找不到符合的資料。";
            }
        } else {
            echo "SQL 查詢出現錯誤：" . $conn->error;  // 此處使用 $conn->error
        }
        $conn->close();


        // 重定向到订单完成页面或其他页面
        header("Location:../orders.php");
        exit();
    }
    
}
?>
