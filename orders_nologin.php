
<!DOCTYPE html>
<?php session_start(); 
// 檢查使用者是否已登入
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
    header("Location: orders.php"); // 重定向到已登入頁面
    exit(); // 確保腳本結束執行，避免後續代碼執行
    $username = $_SESSION['username']; // 獲取使用者名稱
    $account = $_SESSION['account']; // 獲取帳號資訊
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
    <link rel="stylesheet" href="css/meber.css?version=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/orders.css?version=<?php echo time(); ?>" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Yusei+Magic&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    
</head>
<body>
    <!--navbar區塊-->
    <nav>
        <div class="navbar navbar-expand-lg p-3" style="background-color: #fede00">
            <div class="container">
                <a href="index_login.php"><img style="width: 200px;" src="images/logo.png"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a href="#" class="text-black">關於我們</a></li>
                        <li class="nav-item"><a href="shoppage.php" class="text-black">線上訂購</a></li>
                        <!-- <li class="nav-item"><a href="#" data-bs-toggle="modal" data-bs-target="#login-modal" class="text-black">線上訂購</a></li> -->
                        <li class="nav-item"><a href="qanda_nologin.php" class="text-black">常見問題</a></li>
                        <li class="nav-item"><a href="#" class="text-black">聯絡我們</a></li>
                        <li class="nav-item"><a href="#" data-bs-toggle="modal" data-bs-target="#login-modal" class="text-black"><?php echo $loginText; ?></a></li>
                        <li class="nav-item">
                            <a href="Shopping Cart.html" class="d-flex align-items-center text-black">
                                <img src="images/shopping-cart.png" width="20" height="20" class="me-2">購物車
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

        <h3 a href="#" id="login-link" data-bs-toggle="modal" data-bs-target="#login-modal" class="text-black" text-align="center">點我登入</h3>
                   
        

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
            <?php include 'php/orders_login.php'; ?>

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
<!-- <div class="sidebar">
    <a href="https://www.facebook.com.tw/"><img src="images/facebook.png" style="width: 35px;height:35px;" ></a>
    <a href="https://www.instagram.com/"><img src="images/Instagram.png" style="width: 35px;height:35px;"></a>
    <a href="https://line.me/zh-hant/"><img src="images/line.png" style="width: 35px;height:35px;"></a>
    <a href="#" class="back-to-top"><img src="images/up-arrows.png" style="width: 35px;height:35px;"></a>
</div> -->
    </body>
    <script>
        
    function redirectToRegister() {
        window.location.href = "register.php";
    }

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
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 使用 JavaScript 選取元素並模擬點擊
    var loginLink = document.getElementById("login-link");
    if (loginLink) {
        loginLink.click(); // 模擬點擊
    }
});
</script>


    </html>
  
    
    
    
    
    
    