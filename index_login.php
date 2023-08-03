<!DOCTYPE html>
<?php session_start(); 
// 檢查使用者是否已登入
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
    $username = $_SESSION['username']; // 獲取使用者名稱
    $loginText =  "會員：$username"; // 將登入文字設置為使用者名稱
} else {
    $loginText = "會員登入"; // 預設為 "會員登入"
}
?>  
<html lang="zh-Hant-Tw">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="image/logoicon.ico" rel="shortcut icon"/>  
    <title>台南下營鋐茶鵝</title>
    <link rel="stylesheet" type="text/css" href="css/main.css?version=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/index.css?version=<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="JS/main.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Yusei+Magic&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>
<body>
    <nav>
        <div class="navbar navbar-expand-lg p-3" style="background-color: #fede00">
            <div class = "container">
                <a href="index_nologin.php"><img style="width: 200px;" src="images/logo.png"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="#" class="text-black">關於我們</a></li>
                    <li class="nav-item"><a href="shoppage.php" class="text-black">線上訂購</a></li>
                    <li class="nav-item"><a href="common-quest_nologin.php" class="text-black">常見問題</a></li>
                    <li class="nav-item"><a href="#" class="text-black">聯絡我們</a></li>
                    <li class="nav-item"><a href="#" data-bs-toggle="modal" data-bs-target="#login-modal" class="text-black"><?php echo $loginText; ?></a></li>
                    <li class="nav-item">
                        <a href="register.html" class="d-flex align-items-center text-black">
                            <img src="images/shopping-cart.png" width="20" height="20" class="me-2">購物車
                        </a>
                    </li>
                </ul>
            </div>
            </div>
        </div>
    </nav>

    <?php
    // 資料庫連線設定
    $host = '192.168.2.200';
    $user = 'hongteag_goose';
    $password = 'ab7777xy';
    $dbname = 'hongteag_goose';

    // 建立資料庫連線
    $conn = new mysqli($host, $user, $password, $dbname);
    $conn->set_charset("utf8");
    // 檢查連線是否成功
    if ($conn->connect_error) {
        die("連線失敗: " . $conn->connect_error);
    }

    // 執行 SQL 查詢語句，獲取幻燈片圖片的資料
    $sql = "SELECT * FROM banner";
    $result = $conn->query($sql);

    // 檢查結果集是否有資料
    if ($result->num_rows > 0) {
        $slideIndex = 0;
        $indicatorIndex = 0;
        ?>
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <li data-bs-target="#carouselExample" data-bs-slide-to="<?php echo $indicatorIndex; ?>" <?php if ($indicatorIndex === 0) echo 'class="active"'; ?>></li>
                    <?php $indicatorIndex++;
                } ?>
            </ol>
            <div class="carousel-inner">
                <?php
                mysqli_data_seek($result, 0); // 將指標設回第一筆資料
                while ($row = $result->fetch_assoc()) {
                    $slideClass = ($slideIndex === 0) ? 'active' : '';
                    ?>
                    <div class="carousel-item <?php echo $slideClass; ?>">
                        <img src="<?php echo $row['path']; ?>" class="d-block w-100" alt="<?php echo $row['filename']; ?>">
                    </div>
                    <?php
                    $slideIndex++;
                }
                ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExample" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExample" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <?php
    } else {
        echo "資料庫中沒有幻燈片圖片資料。";
    }

    // 釋放資源並關閉資料庫連線
    $result->free_result();
    $conn->close();
    ?>

<?php
// 設定資料庫連線參數
$host = '192.168.2.200';
$user = 'hongteag_goose';
$password = 'ab7777xy';
$dbname = 'hongteag_goose';

// 建立資料庫連線
$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset("utf8");
// 檢查連線是否成功
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

// 執行 SQL 查詢語句
$sql = "SELECT newsID, newsDate, newsContent FROM news";
$result = $conn->query($sql);
?>

<div class="newsdiv1">
    <h1 class="newstitle">最新消息</h1>
    <div class="newsdiv2">
        <div class="news">
            <div class="newstext">
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <p class="newsdate"><?php echo $row['newsDate']; ?></p>
                    <p class="newsdata"><?php echo $row['newsContent']; ?></p><br>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php
// 關閉資料庫連線
$conn->close();
?>

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
    $sql = "SELECT product_name, description, image_path, price FROM popular_products";
    $result = $conn->query($sql);
    ?>

    <div class="p-5 text-center_hot">
        <div class="container">
            <h1>熱門品項</h1>
            <br>
            <div class="row g-1">
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <div class="col-lg">
                        <div class="card lg">
                            <img src="<?php echo $row['image_path']; ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['product_name']; ?></h5>
                                <p class="card-text"><?php echo $row['description']; ?></p>
                                <p class="card-text">價格：<?php echo $row['price']; ?></p>
                                <a href="shoppage.html" class="btn btn-warning">前往商品</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>



<!--三大堅持區塊-->
<div class="p-5 text-center_3">
    <h1>三大堅持</h1>
        <br>
        <img src="images/intro.png" class="img-fluid">
</div>

<!--營業時間區塊-->
<div class="p-5 text-center_time bg-light">
    <h1>營業資訊</h1>
    <div class="container">
    <div class="row">
    <div class="col-md-3">
    <h3>光復市場</h3>
    <img src="images/Guangfu.jpg" alt="光復市場圖片" class="img-fluid rounded-circle">
    </div>
    <div class="col-md-3">
    <h3>永春市場</h3>
    <img src="images/Yongchun.jpg" alt="永春市場圖片" class="img-fluid rounded-circle">
    </div>
        <div class="col-md-6 d-flex flex-column align-items-center">
        <div class="my-auto">
            <h4 class="text-center_time">營業時間：早上6:00 - 售完為止</h4>
            <br>
            <a href="#" class="btn btn-warning">立即下單</a>
            <a href="#" class="btn btn-outline-warning disabled">提供宅配服務 <img src="images/delivery.png" style="width: 20px;height:20px;"></a>
        </div>
        </div>

    </div>
    </div>
</div>

<!-- 登入彈窗區塊，有與JS配合 -->
<div id="login-modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Close button -->
            <div class="modal-header">
                <h5 class="modal-title">會員</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Logout form -->
            <form class="form1" action="php/logout.php" method="post" id="logout-form">
                <div class="modal-footer">
                    <!-- 顯示使用者名稱 -->
                    <span>歡迎，<?php echo $_SESSION['username']; ?></span>
                    <!-- 登出按鈕 -->
                    <button type="submit" class="btn btn-outline-warning" name="action" value="logout">登出</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!--側邊攔-->
<div class="sidebar">
    <a href="https://www.facebook.com.tw/"><img src="images/facebook.png" style="width: 35px;height:35px;" ></a>
    <a href="https://www.instagram.com/"><img src="images/Instagram.png" style="width: 35px;height:35px;"></a>
    <a href="https://line.me/zh-hant/"><img src="images/line.png" style="width: 35px;height:35px;"></a>
    <a href="#" class="back-to-top"><img src="images/up-arrows.png" style="width: 35px;height:35px;"></a>
</div>

    <!--底部欄 -->
    <footer class="p-4 border-top">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h3>台南下營 鋐茶鵝</h3>
            </div>
            <div class="col-md-3">
            <h5>關於我們</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-decoration-none text-warning">關於紘茶鵝</a></li>
                    <li><a href="#" class="text-decoration-none text-warning">營業資訊</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>購物須知</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-decoration-none text-warning">付款方式</a></li>
                    <li><a href="#" class="text-decoration-none text-warning">運送方式</a></li>
                    <li><a href="#" class="text-decoration-none text-warning">常見問題</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>聯絡資訊</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-decoration-none text-warning">LINE：官方LINE帳號</a></li>
                    <li><a href="#" class="text-decoration-none text-warning">FACEBOOK：台南下營 鋐茶鵝</a></li>
                </ul>
            </div>
        </div>
    </div>
    </footer>
    <div class="bg-warning text-center">台南下營 鋐茶鵝 © 2023</div>    
</body>

<script>

    document.addEventListener("DOMContentLoaded", function() {
    var memberLoginButton = document.querySelector(".nav-item a[data-bs-target='#login-modal']");

    // 檢查使用者是否已登入
    if (<?php echo isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true ? 'true' : 'false'; ?>) {
        var username = <?php echo isset($_SESSION['username']) ? json_encode($_SESSION['username']) : '""'; ?>;
        memberLoginButton.textContent = "會員:"+username; // 修改按鈕文字為使用者名稱
        memberLoginButton.href = "member.html?username=" + encodeURIComponent(username); // 設定跳轉連結到會員中心
    }
});
</script>

</html>
