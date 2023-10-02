<!DOCTYPE html>
<?php session_start(); 
// 檢查使用者是否已登入
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
    $username = $_SESSION['username']; // 獲取使用者名稱
    $loginText =  "會員：$username"; // 將登入文字設置為使用者名稱
} else {
    header("Location: contact_nologin.php"); // 重定向到未登入頁面
    exit(); // 確保腳本結束執行，避免後續代碼執行
}
?>  
<html lang="zh-Hant-Tw">
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
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/emailjs-com@3/dist/email.min.js">
</script>
	</head>


<body>
		
	  <!--navbar區塊-->
      <nav>
        <div class="navbar navbar-expand-lg p-3" style="background-color: #fede00">
            <div class = "container">
                <a href="index_login.php"><img style="width: 200px;" src="images/logo.png"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="about_login.php" class="text-black">關於我們</a></li>
                    <!-- <li><a href="#">商品總覽</a></li> -->
                    <li class="nav-item"><a href="shoppage.php" class="text-black">線上訂購</a></li>
                    <li class="nav-item"><a href="common_quest_login.php" class="text-black">常見問題</a></li>
                    <li class="nav-item"><a href="contact_login.php" class="text-black">聯絡我們</a></li>
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
                    <button type="button" class="btn btn-warning" onclick="redirectTorevise()">會員中心</button>
                    <!-- 登出按鈕 -->
                    <button type="submit" class="btn btn-outline-warning" name="action" value="logout">登出</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!--側邊攔-->
<div class="sidebar">
    <a href="https://www.facebook.com/profile.php?id=100091698824828&mibextid=ZbWKwL"target="_blank"><img src="images/facebook.png" style="width: 35px;height:35px;" ></a>
    <a href="https://www.instagram.com/"><img src="images/Instagram.png" style="width: 35px;height:35px;"></a>
    <a href="https://line.me/zh-hant/"><img src="images/line.png" style="width: 35px;height:35px;"></a>
    <a href="#" class="back-to-top"><img src="images/up-arrows.png" style="width: 35px;height:35px;"></a>
</div>

<div id="logo" class="container">
	<i class="fa-solid fa-house" style="color: #8f8f8f;"></i>&nbsp;<a href="index_login.php">首頁</a> — <a href="contact_login.php">聯絡我們</a>
</div>
<div id="page" class="container"> 
			<main class="main-content">
				
				<div class="fullwidth-block content">
					<div class="container">
						<h2 class="entry-title">聯絡我們</h2>

						<div class="row contact-info">
							<div class="col-md-6">
								<div class="map-container">
									<div class="map">
										<div class="map-iframe" ng-show="currentMap === 'guangfu'">
											<iframe id="guangfu-iframe" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14459.733004300899!2d121.5604944!3d25.0363392!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3442abb7dca04e17%3A0x345b3c3b05eac042!2z5YWJ5b6p5biC5aC0!5e0!3m2!1szh-TW!2stw!4v1687073889333!5m2!1szh-TW!2stw"  height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
										</div>
										<div class="map-iframe" ng-show="currentMap === 'yongchun'">
											<iframe id="yongchun-iframe" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14458.939604366496!2d121.5775774!3d25.0430691!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3442aba18d3f715d%3A0x5e0ee08ff88eadaf!2z5rC45pil5biC5aC0!5e0!3m2!1szh-TW!2stw!4v1687073750580!5m2!1szh-TW!2stw" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<address>
												<strong>聯絡資訊</strong>
												<p>手機：0966218624<br>Line ID:@625eoimq</p>
												<div class="linefb">
													<img src="images/line.png" alt="line">
													<img src="images/Facebook_icon.png" alt="fb">
												</div>
											</address>
										</div>
										<div class="col-md-8">
											<div class="contact">
												<strong>營業地點</strong>
												<p>
													<span class="market" ng-click="toggleMap('guangfu')">光復市場：台北市信義區仁愛路四段496巷19號</span><br>
													<span class="market" ng-click="toggleMap('yongchun')">永春市場：台北市信義區松山路294號</span><br>
													<span class="market" ng-click="toggleMap('yongchun')">樹林市場：新北市樹林區博愛街10號</span><br>
													<span class="market" ng-click="toggleMap('yongchun')">福和市場：新北市中和區中山路二段3巷22弄42號</span>
												</p>
												  
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-5 col-md-offset-1">
								<form action="#" method="post" class="contact-form" id="cform">
									<div class="form-group row">
										<label for="inputEmail3" class="col-sm-2 col-form-label">姓名：</label>
										<div class="col-sm-10">
										  <input type="name" name="name" class="form-control" id="inputEmail3" placeholder="">
										</div>
									</div>

									<div class="form-group row">
										<label for="inputEmail3" class="col-sm-2 col-form-label">電話：</label>
										<div class="col-sm-10">
										  <input type="phone_number" name="phone" class="form-control" id="inputEmail3" placeholder="">
										</div>
									</div>

									<div class="form-group row">
										<label for="inputEmail3" class="col-sm-2 col-form-label">信箱：</label>
										<div class="col-sm-10">
										  <input type="name" name="mail" class="form-control" id="inputEmail3" placeholder="">
										</div>
									</div>

									<div class="form-group row">
										<label for="inputEmail3" class="col-sm-2 col-form-label">意見：</label>
										<div class="col-sm-10">
											<textarea name="message" id="message" placeholder="請輸入內容"></textarea>
										</div>
									</div>
									<div class="text-right">
										<button class="btn btn-warning" type="submit" >送出</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			</main> 
			<!-- .main-content -->
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
                    <li><a href="about_login.php" class="text-decoration">關於鋐茶鵝</a></li>
                    <li><a href="index_login.php#營業資訊" class="text-decoration">營業資訊</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>購物須知</h5>
                <ul class="list-unstyled">
                   <!--<li><a href="#" class="text-decoration-none text-warning">付款方式</a></li>
                    <li><a href="#" class="text-decoration-none text-warning">運送方式</a></li>-->
                    <li><a href="common_quest_login.php" class="text-decoration">常見問題</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>聯絡資訊</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-decoration">LINE：官方LINE帳號</a></li>
                    <li><a href="https://www.facebook.com/profile.php?id=100091698824828&mibextid=ZbWKwL"target="_blank" class="text-decoration">FACEBOOK：台南下營 鋐茶鵝</a></li>
					<li><a href="mailto:angel19971314@gmail.com" class="text-decoration">E-mail：angel19971314@gmail.com</a></li>
					<li><span style="color:#FEC107">電話：0966218624</span></li>
                </ul>
            </div>
        </div>
    </div>
    </footer>
    <div class="bg-warning text-center">台南下營 鋐茶鵝 © 2023</div>




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

	var app = angular.module('myApp', []);

app.controller('MapController', function($scope) {
	$scope.currentMap = 'guangfu'; // 預設顯示 guangfu-iframe

	$scope.toggleMap = function(market) {
		$scope.currentMap = market; // 切換 currentMap 值來控制顯示的 iframe
	};
});
function redirectTorevise() {
        window.location.href = "ReviseMember.php";
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