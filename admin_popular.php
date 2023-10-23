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
<html lang="zh-Hant-Tw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  
    <link href="images/logoicon.ico" rel="shortcut icon"/>  
    <link rel="stylesheet" href="css/admin.css">
    <!-- <link rel="stylesheet" type="text/css" href="css/main.css?version=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/index.css?version=<?php echo time(); ?>"> -->
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/index.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Yusei+Magic&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>
<body>

    <nav>
        <div class="navbar navbar-expand-lg p-3 " style="background-color: #fede00">
            <div class = "container">
                <a href="index_nologin.php"><img style="width: 200px;" src="images/logo.png"></a>
                <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button> -->

            <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
                <!-- <ul class="navbar-nav ms-auto">
                    <li class="nav-item">管理者設定頁面</li> -->
                    <!-- <li class="nav-item"><a href="about_nologin.php" class="text-black">關於我們</a></li> -->
                    <!-- <li><a href="#">商品總覽</a></li> -->
                    <!-- <li class="nav-item"><a href="shoppage.php" class="text-black">線上訂購</a></li>
                    <li class="nav-item"><a href="common_quest_nologin.php" class="text-black">常見問題</a></li>
                    <li class="nav-item"><a href="contact_nologin.php" class="text-black">聯絡我們</a></li> -->
                <!-- </ul> -->
            <!-- </div> -->
            </div>
        </div>
    </nav>

    <div style="margin: 20px;">
        <div class="row">
            <div class="col-md-2">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action disabled bg-light">首頁</a>
                    <a href="admin_carousel.php" class="list-group-item list-group-item-action">輪播圖圖片</a>
                    <a href="admin_news.php" class="list-group-item list-group-item-action">最新消息</a>
                    <a href="admin_popular.php" class="list-group-item list-group-item-action bg-warning">熱門品項</a>
                    <div class="list-group-item list-group-item-action disabled bg-light">商品頁</div>
                    <a href="admin_product.php" class="list-group-item list-group-item-action">商品管理</a>
                    <div class="list-group-item list-group-item-action disabled bg-light">訂單</div>
                    <a href="admin_order_nopay.php" class="list-group-item list-group-item-action">未付款</a>
                    <a href="admin_order_confirmed.php" class="list-group-item list-group-item-action">待確認款項</a>
                    <a href="admin_order_havepay.php" class="list-group-item list-group-item-action">待出貨</a>
                    <a href="admin_order_ship.php" class="list-group-item list-group-item-action">已出貨</a>
                    <div class="list-group-item list-group-item-action disabled bg-light">使用者管理</div>
                    <a href="admin_user.php" class="list-group-item list-group-item-action">使用者管理</a>
                    <div class="list-group-item list-group-item-action disabled bg-light">LINE官方帳號</div>
                    <a href="admin_linebot_admin.php" class="list-group-item list-group-item-action"><i class="fab fa-line"></i> 管理者管理</a>
                    <a href="admin_linebot_user.php" class="list-group-item list-group-item-action"><i class="fab fa-line"></i> 使用者管理</a>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        熱門商品管理  
                    </div>
                    <div class="card-body">
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                                <div class="card mb-2">
                                    <div class="row no-gutters">
                                        <div class="col-md-1 d-flex justify-content-center align-items-center">
                                            排行：<?php echo $row['id']; ?>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <input type="text" name="product_name" class="form-control mb-2" value="<?php echo $row['product_name']; ?>">
                                            <input type="text" name="description" class="form-control" value="<?php echo $row['description']; ?>">
                                        </div>
                                        <div class="col-md-2 d-flex justify-content-center align-items-center">
                                            <?php if (!empty($row['image_path'])) { ?>
                                                <img class="card-img mx-auto" src="<?php echo $row['image_path']; ?>" style="max-height: 80px; width: auto; object-fit: contain;">
                                            <?php } ?>
                                        </div>
                                        <div class="col-md-2 d-flex justify-content-center align-items-center">
                                            <input type="file" name="image" class="form-control-file">
                                            <input type="hidden" name="image_path" value="<?php echo $row['image_path']; ?>">
                                        </div>                                       
                                        <div class="col-md-1 d-flex justify-content-center align-items-center">
                                            <input type="text" name="price" class="form-control" value="<?php echo $row['price']; ?>">
                                        </div>
                                        <div class="col-md-2 d-flex justify-content-center align-items-center">
                                            <button type="submit" class="btn btn-warning">儲存</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
