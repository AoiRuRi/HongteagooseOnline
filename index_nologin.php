<!DOCTYPE html>
<?php session_start(); 
// 檢查使用者是否已登入
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
    header("Location: index_login.php"); // 重定向到已登入頁面
    exit(); // 確保腳本結束執行，避免後續代碼執行
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
    <link href="images/logoicon.ico" rel="shortcut icon"/>  
    <title>台南下營鋐茶鵝</title>
    <!-- <link rel="stylesheet" href="css/main.css"> -->
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
</head>
<body>
    <!-- 進度條動態區塊 -->
    <div id="progress-bar-container">
        <div id="progress-bar"></div>
      </div>

      <!--navbar區塊-->
    <nav>
        <div class="navbar navbar-expand-lg p-3" style="background-color: #fede00">
            <div class = "container">
                <a href="index_nologin.php"><img style="width: 200px;" src="images/logo.png"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="about_nologin.php" class="text-black">關於我們</a></li>
                    <!-- <li><a href="#">商品總覽</a></li> -->
                    <li class="nav-item"><a href="shoppage.php" class="text-black">線上訂購</a></li>
                    <li class="nav-item"><a href="common_quest_nologin.php" class="text-black">常見問題</a></li>
                    <li class="nav-item"><a href="contact_nologin.php" class="text-black">聯絡我們</a></li>
                    <li class="nav-item"><a href="#" data-bs-toggle="modal" data-bs-target="#login-modal" class="text-black"><?php echo $loginText; ?></a></li>
                    <li class="nav-item">
                        <a href="Payment.php" class="d-flex align-items-center text-black">
                            <img src="images/shopping-cart.png" width="20" height="20" class="me-2">購物車
                        </a>
                    </li>

                </ul>
            </div>
            </div>
        </div>
    </nav>

<!--幻燈片區塊-->
<?php
// 設定資料庫連線參數
$host = '192.168.2.200'; // 或 '127.0.0.1'
$user = 'hongteag_goose'; // 使用者帳號
$password = 'ab7777xy'; // 使用者密碼
$dbname = 'hongteag_goose'; // 資料庫名稱
$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset("utf8");
// 檢查連線是否成功
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

// 從資料庫中檢索幻燈片圖片路徑
$sql = "SELECT path FROM banner";
$result = $conn->query($sql);

// 檢查是否有結果
if ($result->num_rows > 0) {
    $images = array();
    while ($row = $result->fetch_assoc()) {
        $images[] = $row['path'];
    }
?>

<!-- 幻燈片區塊 -->
<div class="container">
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <ol class="carousel-indicators">
            <?php for ($i = 0; $i < count($images); $i++) { ?>
                <li data-bs-target="#carouselExample" data-bs-slide-to="<?php echo $i; ?>" <?php echo ($i === 0) ? 'class="active"' : ''; ?>></li>
            <?php } ?>
        </ol>
        <div class="carousel-inner">
            <?php foreach ($images as $index => $image) { ?>
                <div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>">
                    <img src="<?php echo $image; ?>" class="d-block w-100" alt="Slide <?php echo $index + 1; ?>">
                    <!-- 您可以根據需要添加其他幻燈片內容 -->
                </div>
            <?php } ?>
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
</div>

<?php
} else {
    echo "沒有可顯示的幻燈片圖片。";
}

// 關閉資料庫連線
$conn->close();
?>

    <!-- 最新消息區塊 -->

    <?php
// 設定資料庫連線參數
$host = '192.168.2.200'; // 或 '127.0.0.1'
$user = 'hongteag_goose'; // 使用者帳號
$password = 'ab7777xy'; // 使用者密碼
$dbname = 'hongteag_goose'; // 資料庫名稱
$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset("utf8");
// 檢查連線是否成功
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

// 從資料庫中檢索最新消息
$sql = "SELECT newsContent, newsDate FROM news ORDER BY newsDate DESC LIMIT 5"; // 假設希望顯示最新的5條消息
$result = $conn->query($sql);

// 檢查是否有結果
if ($result->num_rows > 0) {
?>

<div class="container">
    <h1 class="text-center mt-4 mb-4">最新消息</h1>
    <div class="card border-warning border-2">
        <ul class="list-group list-group-flush">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <li class="list-group-item" style="background-color: #ffffff46;">
                    <div class="d-flex justify-content-between">
                        <span><?php echo $row['newsContent']; ?></span>
                        <span class="float-right text-black"><?php echo $row['newsDate']; ?></span>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

<?php
} else {
    echo "目前沒有最新消息。";
}

// 關閉資料庫連線
$conn->close();
?>


      
<!--熱門品項區塊-->
<?php
// 設定資料庫連線參數
$host = '192.168.2.200'; // 或 '127.0.0.1'
$user = 'hongteag_goose'; // 使用者帳號
$password = 'ab7777xy'; // 使用者密碼
$dbname = 'hongteag_goose'; // 資料庫名稱
$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset("utf8");
// 檢查連線是否成功
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

// 從資料庫中檢索熱門品項數據
$sql = "SELECT image_path, product_name, description FROM popular_products"; 
$result = $conn->query($sql);

// 檢查是否有結果
if ($result->num_rows > 0) {
?>

<div class="p-5 text-center">
    <div class="container">
        <h1>熱門品項</h1>
        <br>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="col-lg">
                    <div class="card lg">
                        <img src="<?php echo $row['image_path']; ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['product_name']; ?></h5>
                            <p class="card-text"><?php echo $row['description']; ?></p>
                            <a href="shoppage.php" class="btn btn-warning">前往商品</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="container mt-5">
            <button type="button" class="btn btn-warning btn-lg" style="font-size: 2rem;margin-top: 10px;" onclick="redirectToshoppage()">立即下單</button>
            <button type="button" class="btn btn-outline-warning btn-lg disabled" style="font-size: 2rem; margin-top: 10px;">提供宅配服務 <img src="images/delivery.png" style="width: 40px; height: 40px;"></button>
        </div>
    </div>
</div>

<?php
} else {
    echo "目前沒有熱門品項。";
}

// 關閉資料庫連線
$conn->close();
?>




<!-- 新三大特點 -->
<div class="container text-center mt-10 p-5">
    <h1 class="mb-5">三大特點</h1>
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="card mb-4">
                <img src="" alt="">
                <div class="card-body">
                    <i class="fas fa-clock fa-8x mb-5"></i>
                    <h2 class="card-title">當日現宰<br>新鮮<br>真空包裝</h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card mb-4">
                <img src="" alt="">
                <div class="card-body">
                    <i class="fa-solid fa-mortar-pestle fa-8x mb-5"></i> 
                    <h2 class="card-title">紅糖、蜂蜜<br>香料燻製<br>天然食材無負擔</h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card mb-4">
                <img src="" alt="">
                <div class="card-body">
                    <i class="fa-solid fa-utensils fa-8x mb-5"></i> 
                    <h2 class="card-title">富含營養<br>肉質鮮甜<br>煙燻鹹水真美味</h2>
                </div>
            </div>
        </div>
    </div>
</div>



<!--營業時間區塊-->
<div class="p-5 text-center_time bg-light" id="營業資訊">
    <h1>營業資訊</h1>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-2">
                <div class="image-container ">
                    <img src="images/Guangfu.jpg" alt="光復市場圖片" class="img-fluid rounded">
                    <div class="caption d-flex justify-content-center align-items-center rounded">光復市場</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="image-container">
                    <img src="images/Yongchun.jpg" alt="永春市場圖片" class="img-fluid rounded">
                    <div class="caption d-flex justify-content-center align-items-center rounded">永春市場</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="image-container ">
                    <img src="images/Guangfu.jpg" alt="光復市場圖片" class="img-fluid rounded">
                    <a href="common-quest_nologin.html" class="text-black"><div class="caption d-flex justify-content-center align-items-center rounded">更多<br>市場資訊</div></a>
                </div>
            </div>
            <div class="col-md-6 d-flex flex-column align-items-center mt-4">
                <div class="my-auto">
                    <h4 class="text-center_time " >營業時間：早上6:00 - 售完為止</h4>
                    <div class="container d-flex align-items-center">
                        <h5 class="p-3">台南下營 &nbsp;鋐茶鵝</h5>
                        <a href="https://www.facebook.com/profile.php?id=100091698824828&mibextid=ZbWKwL"target="_blank"><i class="fa-brands fa-square-facebook fa-7x" style="color: #4267B2;"></i></a>
                        <h5 class="p-3"> 官方Line帳號 </h5>
                        <!-- 官方ＱＲ code 尚未補上 用icon暫替 -->
                        <!-- <a href="#"><i class="fa-brands fa-line fa-9x" style="color: #1fd656;"></i></a> -->
                        <a href="#"><i class="fa-sharp fa-solid fa-qrcode fa-7x" style="color:#555555"></i></a>
                    </div>
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
                <h5 class="modal-title">會員登入</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Login form -->
            <?php include 'php/login.php'; ?>

            <form class="form1" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" id="member-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="account">帳號:</label>
                        <input type="text" id="account" name="account" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password">密碼:</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <?php if ($isLoggedIn) { ?>
                        <!-- 若已登入，顯示使用者名稱 -->
                        <span>歡迎，<?php echo $_SESSION['username']; ?></span>
                        <a href="logout.php" class="btn btn-outline-warning">登出</a>
                    <?php } else { ?>
                        <!-- 若未登入，顯示登入按鈕 -->
                        <button type="button" class="btn btn-outline-success" onclick="window.location.href='https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=2000860319&redirect_uri=https%3A%2F%2Fhongteagoose.lionfree.net%2Flinebot%2Flogin_web.php&state=YOUR_STATE&scope=profile';"><i class="fab fa-line"></i> 快速登入</button>
                        <button type="submit" class="btn btn-outline-warning" name="action" value="login">會員登入</button>
                        <button type="button" class="btn btn-warning" name="action" value="register" onclick="redirectToRegister()">註冊會員</button>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>
<!--側邊攔-->
<div class="sidebar">
    <a href="https://www.facebook.com/profile.php?id=100091698824828&mibextid=ZbWKwL"target="_blank"><img src="images/facebook.png" style="width: 35px;height:35px;" ></a>
    <a href="https://www.instagram.com/"><img src="images/Instagram.png" style="width: 35px;height:35px;"></a>
    <a href="https://lin.ee/xkDBL1w"><img src="images/line.png" style="width: 35px;height:35px;"></a>
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
                    <li><a href="about_nologin.php" class="text-decoration">關於鋐茶鵝</a></li>
                    <li><a href="index_nologin.php#營業資訊" class="text-decoration">營業資訊</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>購物須知</h5>
                <ul class="list-unstyled">
                   <!--<li><a href="#" class="text-decoration-none text-warning">付款方式</a></li>
                    <li><a href="#" class="text-decoration-none text-warning">運送方式</a></li>-->
                    <li><a href="common_quest_nologin.php" class="text-decoration">常見問題</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>聯絡資訊</h5>
                <ul class="list-unstyled">
                    <li><a href="https://lin.ee/xkDBL1w" class="text-decoration">LINE：官方LINE帳號</a></li>
                    <li><a href="https://www.facebook.com/profile.php?id=100091698824828&mibextid=ZbWKwL"target="_blank" class="text-decoration">FACEBOOK：台南下營 鋐茶鵝</a></li>
					<li><a href="mailto:angel19971314@gmail.com" class="text-decoration">E-mail：angel19971314@gmail.com</a></li>
					<li><span style="color:#FEC107">電話：0966218624</span></li>
                </ul>
            </div>
        </div>
    </div>
    </footer>
    <div class="bg-warning text-center">台南下營 鋐茶鵝 © 2023</div>
    
<script>// 進度條
    
var progressBar = document.getElementById('progress-bar');// 取得進度條元素

function updateProgressBar() {  // 更新進度條的函式
  // 計算網頁的總高度
  var pageHeight = document.documentElement.scrollHeight - window.innerHeight;
  
  // 取得目前捲動的位置
  var scrollPosition = window.pageYOffset;
  
  // 計算捲動進度百分比
  var progress = (scrollPosition / pageHeight) * 100;
  
  // 設定進度條的寬度
  progressBar.style.width = progress + '%';
}

// 監聽捲動事件，當捲動時更新進度條
window.addEventListener('scroll', updateProgressBar);

// 監聽視窗大小改變事件，當視窗大小改變時更新進度條
window.addEventListener('resize', updateProgressBar);




// 營業資訊圖片hover
$(".image-container").hover(
    function() {
        $(this).find(".caption").css("opacity", 0.7);
    },
    function() {
        $(this).find(".caption").css("opacity", 0);
    }
);


</script>
<script>
    document.getElementById("member-form").addEventListener("submit", function(event) {
        var action = event.submitter.value;

        if (action === "login") {
            // 登入操作，檢查帳號和密碼是否已填寫
            var account = document.getElementById("account").value;
            var password = document.getElementById("password").value;

            if (account.trim() === "" || password.trim() === "") {
                event.preventDefault(); // 阻止表單提交
                alert("請填寫帳號和密碼！");
            }
        }
    });

    function redirectToRegister() {
        window.location.href = "register.php";
    }

    function redirectToshoppage() {
        window.location.href = "shoppage.php";
    }
</script>
</body>

</html>