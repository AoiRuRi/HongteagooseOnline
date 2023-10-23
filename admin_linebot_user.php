<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  
    <link href="images/logoicon.ico" rel="shortcut icon"/>  
    <link rel="stylesheet" href="css/admin.css?version=<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/main.css?version=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/index.css?version=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/index.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Yusei+Magic&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<body>
<nav>

<div class="navbar navbar-expand-lg p-3" style="background-color: #fede00">
    <div class = "container">
        <a href="index_nologin.php"><img style="width: 200px;" src="images/logo.png"></a>
        <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a href="about_nologin.php" class="text-black">關於我們</a></li> -->
            <!-- <li><a href="#">商品總覽</a></li> -->
            <!-- <li class="nav-item"><a href="shoppage.php" class="text-black">線上訂購</a></li>
            <li class="nav-item"><a href="common_quest_nologin.php" class="text-black">常見問題</a></li>
            <li class="nav-item"><a href="contact_nologin.php" class="text-black">聯絡我們</a></li>
            <li class="nav-item"><a href="#" data-bs-toggle="modal" data-bs-target="#login-modal" class="text-black"></a></li>
            <li class="nav-item">
                <a href="Payment.php" class="d-flex align-items-center text-black">
                    <img src="images/shopping-cart.png" width="20" height="20" class="me-2">購物車
                </a>
            </li>

        </ul>
    </div> -->
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
                <a href="admin_popular.php" class="list-group-item list-group-item-action">熱門品項</a>
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
                <a href="admin_linebot-user.php" class="list-group-item list-group-item-action bg-warning"><i class="fab fa-line"></i> 使用者管理</a>
            </div>
        </div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        綁定個人化服務的用戶的資料
                    </div>
                    <div class="card-body">
                        <?php
                            $mysqli = new mysqli("192.168.2.200", "hongteag_linebot", "1234", "hongteag_linebot");

                            if ($mysqli->connect_error) {
                                die("資料庫連接失敗: " . $mysqli->connect_error);
                            }

                            $sql = "SELECT display_name, user_id, level FROM linedata";
                            $result = $mysqli->query($sql);

                            if ($result === false) {
                                die("查詢失敗: " . $mysqli->error);
                            }
                            $count = $result->num_rows;

                            echo "<p>目前共有 " . $count . " 人</p>";

                            if ($result->num_rows > 0) {
                                echo "<ul class='list-group'>";
                                while ($row = $result->fetch_assoc()) {
                                    if (!empty($row["display_name"]) && !empty($row["user_id"])) {
                                        echo "<li class='list-group-item'>";
                                        echo "<strong>" . $row["display_name"] . "</strong> (" . $row["user_id"] . ")";
                                        if ($row["level"] == 2) {
                                            echo " - <span class='badge bg-danger'>管理者</span>";
                                        } elseif ($row["level"] == 1) {
                                            echo " - <span class='badge bg-secondary'>使用者</span>";
                                        }
                                        echo "</li>";
                                    }
                                }
                                echo "</ul>";
                            } else {
                                echo "<p>目前沒有資料</p>";
                            }

                            $result->close();
                            $mysqli->close();
                        ?>
                    </div>
                </div>
            </div>
    </div>
</div>