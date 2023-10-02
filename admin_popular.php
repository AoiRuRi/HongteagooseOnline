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

// 執行 SQL 查詢語句
$sql = "SELECT id, product_name, image_path, description, price FROM popular_products";
$result = $conn->query($sql);

// 編輯表單提交後的處理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $productName = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // 檢查是否上傳了圖片
    if (!empty($_FILES['image']['name'])) {
        $imagePath = $_FILES['image']['name'];
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageDestination = 'images/' . $imagePath;

        // 將圖片移動到目標位置
        if (move_uploaded_file($imageTmpPath, __DIR__ . '/' . $imageDestination)) {
            // 更新資料庫中的資料
            $updateSql = "UPDATE popular_products SET image_path='$imageDestination' WHERE id='$id'";
            $conn->query($updateSql);
        }
    }

    // 更新資料庫中的資料
    $updateSql = "UPDATE popular_products SET product_name='$productName', description='$description', price='$price' WHERE id='$id'";
    $conn->query($updateSql);

    // 重新導向到當前頁面，避免重新提交表單
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin.css">
    <style>
        .thumbnail {
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="navbar navbar-expand-lg p-3" style="background-color: #fede00">
        <div class="container">
            <a href="index_nologin.php"><img style="width: 300px;" src="images/logo.png"></a>
        </div>
    </div>
    <div>
    <table id="left">
            <tr>
            <th><a href="#">首頁</a></th>
            </tr>
            <tr>
            <td><a href="admin_carousel.php">輪播圖圖片</a></td>
            </tr>
            <tr>
            <td><a href="admin_news.php">最新消息</a></td>
            </tr>
            <tr>
            <td><a href="admin_popular.php">熱門品項</a></td>
            </tr>
            <tr>
            <th>商品頁</th>
            </tr>
            <tr>
            <td><a href="admin_product.php">商品管理</a></td>
            </tr>
            <tr>
            <th>訂單</th>
            </tr>
            <tr>
            <td><a href="admin_order_nopay.php">未付款</a></td>
            </tr>
            <tr>
            <td><a href="admin_order_confirmed.php">待確認款項</a></td>
            </tr>
            <tr>
            <td><a href="admin_order_havepay.php">待出貨</a></td>
            </tr>
            <tr>
            <td><a href="admin_order_ship.php">已出貨</a></td>
            </tr>
            <tr>
            <th>使用者管理</th>
            </tr>
            <tr>
            <td><a href="admin_user.php">使用者管理</a></td>
            </tr>        
        </table>
    </div>
    <div>
        <table id="popular-table">
            <tr>
                <th>熱門品項</th>
                <th>品項說明</th>
                <th>品項圖片</th>
                <th>縮圖</th>
                <th>價格</th>
                <th>操作</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                        <td>
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="text" name="product_name" value="<?php echo $row['product_name']; ?>">
                        </td>
                        <td>
                            <input type="text" name="description" value="<?php echo $row['description']; ?>">
                        </td>
                        <td>
                            <input type="file" name="image">
                            <input type="hidden" name="image_path" value="<?php echo $row['image_path']; ?>">
                        </td>
                        <td>
                            <?php if (!empty($row['image_path'])) { ?>
                                <img class="thumbnail" src="<?php echo $row['image_path']; ?>" alt="Thumbnail">
                            <?php } ?>
                        </td>
                        <td>
                            <input type="text" name="price" value="<?php echo $row['price']; ?>">
                        </td>
                        <td>
                            <button type="submit">儲存</button>
                        </td>
                    </form>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
