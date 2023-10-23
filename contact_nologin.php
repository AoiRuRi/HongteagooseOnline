<!DOCTYPE html>
<html lang="zh-Hant-Tw">
<?php session_start(); 
// 檢查使用者是否已登入
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
    header("Location: contact_login.php"); // 重定向到已登入頁面
    exit(); // 確保腳本結束執行，避免後續代碼執行
    $username = $_SESSION['username']; // 獲取使用者名稱
    $loginText =  "會員：$username"; // 將登入文字設置為使用者名稱
} else {
    $loginText = "會員登入"; // 預設為 "會員登入"
}
?>  
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
		<!-- <meta name="viewport" content="width=1024"> -->
		<link href="images/logoicon.ico" rel="shortcut icon"/>
		<title>台南下營鋐茶鵝</title>
		<link href="css/novecento-font.css" rel="stylesheet" type="text/css">
		<link href="css/font-awesome.min.css" rel="stylesheet" >
		<link href="css/main.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="css/contact.css">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/emailjs-com@3/dist/email.min.js"></script>
	</head>


<body>
		
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

<div id="logo" class="container">
	<i class="fa-solid fa-house" style="color: #8f8f8f;"></i>&nbsp;<a href="index_nologin.php">首頁</a> — <a href="contact_nologin.php">聯絡我們</a>
</div>

<div id="page" class="container">
	<h2>聯絡我們</h2>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <ul class="nav nav-tabs ">
                <li class="nav-item">
                    <a class="nav-link active" id="guangfu-tab" data-toggle="tab" href="#guangfu-map">光復市場</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="yongchun-tab" data-toggle="tab" href="#yongchun-map">永春市場</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="shulin-tab" data-toggle="tab" href="#shulin-map">樹林市場</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="fuhe-tab" data-toggle="tab" href="#fuhe-map">福和市場</a>
                </li>
            </ul>
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="guangfu-map">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14459.733004300899!2d121.5604944!3d25.0363392!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3442abb7dca04e17%3A0x345b3c3b05eac042!2zM5YWJ5b6p5biC5aC0!5e0!3m2!1szh-TW!2stw!4v1687073889333!5m2!1szh-TW!2stw" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="tab-pane fade" id="yongchun-map">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14458.939604366496!2d121.5775774!3d25.0430691!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3442aba18d3f715d%3A0x5e0ee08ff88eadaf!2zM5rC45pil5biC5aC0!5e0!3m2!1szh-TW!2stw!4v1687073750580!5m2!1szh-TW!2stw" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="tab-pane fade" id="shulin-map">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3616.2084774884975!2d121.42505837359963!3d24.993031019828237!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x34681d774b5abc4d%3A0x1070dec92693e90b!2zM5qi55p6X5biC5aC0!5e0!3m2!1szh-TW!2stw!4v1689430198959!5m2!1szh-TW!2stw" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="tab-pane fade" id="fuhe-map">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3615.88689901743!2d121.50302627359984!3d25.003958818509666!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3442a9c5f27904f1%3A0x1f66a23594a2506f!2zM56aP5ZKM5biC5aC0KOeyvuS4gOmkiui6q-mjn-WTgSk!5e0!3m2!1szh-TW!2stw!4v1689430527599!5m2!1szh-TW!2stw" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-flex flex-column justify-content-center" style="height: calc(86%);">
                <form action="#" class="contact-form" id="cform">
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">姓名：</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" id="inputName" placeholder="">
                        </div>
                    </div>
        
                    <div class="form-group row">
                        <label for="inputPhone" class="col-sm-2 col-form-label">電話：</label>
                        <div class="col-sm-10">
                            <input type="tel" name="phone" class="form-control" id="inputPhone" placeholder="">
                        </div>
                    </div>
        
                    <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">信箱：</label>
                        <div class="col-sm-10">
                            <input type="email" name="mail" class="form-control" id="inputEmail" placeholder="">
                        </div>
                    </div>
        
                    <div class="form-group row">
                        <label for="inputMessage" class="col-sm-2 col-form-label">意見：</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="message" id="inputMessage" rows="4" placeholder="請輸入內容"></textarea>
                        </div>
                    </div>
                    <div class="d-grid gap-2 mt-3">
                        <button class="btn btn-warning" type="submit">送出</button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
	</div>
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

<!--側邊攔-->
<div class="sidebar">
    <a href="https://www.facebook.com/profile.php?id=100091698824828&mibextid=ZbWKwL"target="_blank"><img src="images/facebook.png" style="width: 35px;height:35px;" ></a>
    <a href="https://www.instagram.com/"><img src="images/Instagram.png" style="width: 35px;height:35px;"></a>
    <a href="https://lin.ee/xkDBL1w"><img src="images/line.png" style="width: 35px;height:35px;"></a>
    <a href="#" class="back-to-top"><img src="images/up-arrows.png" style="width: 35px;height:35px;"></a>
</div>


    <script>
        //會員登入彈窗關閉按鈕
        $(document).ready(function() {

            $(".btn-close").click(function() {
                $("#login-modal").modal("hide");
            });
        });
        //回到最頂按鈕
        $(document).ready(function() {

        $(".back-to-top").click(function(event) {
            event.preventDefault();
            $("html, body").animate({ scrollTop: 0 }, "500");
        });
    });

	// $(document).ready(function() {
    //         // 隱藏除了 guangfu-iframe 以外的所有 iframe
    //         $('.map-iframe:not(#guangfu-iframe)').hide();

    //         // 切換地圖 iframe
    //         $('.market').click(function() {
    //             var market = $(this).data('market');
    //             $('.map-iframe').hide(); // 隱藏所有的 iframe
    //             $('#' + market + '-iframe').show(); // 顯示選定的 iframe
    //         });
    //     });

	var app = angular.module('myApp', []);

app.controller('MapController', function($scope) {
	$scope.currentMap = 'guangfu'; // 預設顯示 guangfu-iframe

	$scope.toggleMap = function(market) {
		$scope.currentMap = market; // 切換 currentMap 值來控制顯示的 iframe
	};
});
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
	<!-- <script src="JS/jquery-1.11.1.min.js"></script> -->
	
	<!-- <script src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script> -->
	<!-- <script src="JS/plugins.js"></script> -->
	<!-- <script src="JS/app.js"></script> -->
<!-- 寄信js -->
<script type="text/javascript">
   (function(){
      emailjs.init("kF1wpOaPE9hWPzxzA");
   })();

   document.getElementById('cform').addEventListener('submit', function(event) {
    event.preventDefault(); // 防止表單預設的提交行為
   emailjs.sendForm('service_s2ktpfm', 'template_feokwlb', this)
    .then(function(response) {
       console.log('SUCCESS!', response.status, response.text);
       alert("意見送出成功，我們會盡快與您聯繫");
    }, function(error) {
       console.log('FAILED...', error);
       alert("意見送出時發生問題，請稍後再試");
    });
});
</script>
</body>
</html>