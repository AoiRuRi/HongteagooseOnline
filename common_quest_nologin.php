<!DOCTYPE html>
<?php session_start(); 
// 檢查使用者是否已登入
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
    header("Location: common_quest_login.php"); // 重定向到已登入頁面
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
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="css/quest.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
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
	<i class="fa-solid fa-house" style="color: #8f8f8f;"></i>&nbsp;<a href="index_nologin.php">首頁</a> — <a href="common_quest_nologin.php">常見問題</a>
</div>
			<main class="main-content">
<div id="page" class="container"> 	
				<div class="fullwidth-block inner-content">
						<div class="fullwidth-content">
							<h2 class="section-title"><i class="icon-calendar-lg"></i>常見問題&nbsp; Q&A</h2>
							<div class="quest-btn">
								<h3 class="section-second-title">訂購及出貨</h3>
							</div>
							<div class="accordion">
								<div class="accordion-toggle">
									<h3>Q：購物流程</h3>
									<span class="date"><i class="fa-solid fa-calendar-days fa-xs"></i> 2023.06.01</span>
								</div>
								<div class="accordion-content">
									<p>A：註冊/登入會員→將商品加入購物車→確認訂單內容及收貨人資訊→結帳並匯款→寄出宅
										配商品→收到/確認商品
									 </p>
								</div>
							</div>
							<div class="accordion">
								<div class="accordion-toggle">
									<h3>Q：請問有哪些運送方式？</h3>
									 <span class="date"><i class="fa-solid fa-calendar-days fa-xs"></i> 2023.06.01</span>
								</div>
								<div class="accordion-content">
									<p>A：黑貓宅急便冷凍宅配。為保商品品質，離島區域恕不寄送，請見諒!</p>
								</div>
							</div>
							<div class="accordion">
								<div class="accordion-toggle">
									<h3>Q：請問運費如何計算？</h3>
									<span class="date"><i class="fa-solid fa-calendar-days fa-xs"></i> 2023.06.01</span>
								</div>
								<div class="accordion-content">
									<!-- 運費表格 -->
									<div class="table-wrapper">
										<table class="fee-table ">
											<thead>
												<tr>
													<th>包裝尺寸</th>
													<th>本島寄件</th>
													<th>運費價格</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td data-title="包裝尺寸">60公分(cm)以下</td>
													<td data-title="本島寄件">本島互寄</td>
													<td data-title="運費價格">160元</td>
												</tr>
												<tr >
													<td data-title="包裝尺寸">60～90公分(cm)</td>
													<td data-title="本島寄件">本島互寄</td>
													<td data-title="運費價格">225元</td>
												</tr>
												<tr>
													<td data-title="包裝尺寸">91～120公分(cm)</td>
													<td data-title="本島寄件">本島互寄</td>
													<td data-title="運費價格">290元</td>
												</tr>
											</tbody>
										</table>
									</div>
									
									<h5>消費滿 <span style="color: red;">$2000</span> 即可享免運費。</h5>
								</div>
							</div>
							<div class="accordion">
								<div class="accordion-toggle">
									<h3>Q：請問有哪些付款方式？</h3>
									<span class="date"><i class="fa-solid fa-calendar-days fa-xs"></i> 2023.06.01</span>
								</div>
								<div class="accordion-content">
									<p>A：目前僅有ATM匯款方式，請加入Line ID：@XXX索取匯款帳號，並請於轉帳後傳訊息告
										知訂單編號及帳號末五碼，亦可翻拍轉帳收據使用LINE傳送即可，謝謝！
									 </p>
								</div>
							</div>
							<div class="accordion">
								<div class="accordion-toggle">
									<h3>Q：如何更改訂購內容及送貨地址？</h3>
									<span class="date"><i class="fa-solid fa-calendar-days fa-xs"></i> 2023.06.01</span>
								</div>
								<div class="accordion-content">
									<p>A：訂單送出後即無法修改訂單內容，如需修改，您可由「會員登入」登入帳號，取消訂單後再重新下單。
									 </p>
								</div>
							</div>
							<div class="accordion">
								<div class="accordion-toggle">
									<h3>Q：請問如何取消訂單？</h3>
									<span class="date"><i class="fa-solid fa-calendar-days fa-xs"></i> 2023.06.01</span>
								</div>
								<div class="accordion-content">
									 <p>A：訂單尚未進入包裝作業前您可由「會員登入」登入帳號，自行取消訂單。 <br>
										&emsp;※ 訂單取消後即無法復原。 <br>
										&emsp;※ 若訂單商品已進入包裝作業，請恕無法為您取消訂單。 <br>
										&emsp;※ 提醒您，若您取消訂單後重新訂購，商品庫存請依當時頁面為主！ <br>
										</p>
								</div>
							</div>
							<div class="accordion">
								<div class="accordion-toggle">
									<h3>Q：請問商品出貨時間?</h3>
									<span class="date"><i class="fa-solid fa-calendar-days fa-xs"></i> 2023.06.01</span>
								</div>
								<div class="accordion-content">
									 <p>A：每週二~日的下午1點前訂購並匯款完成，商品將於當日寄出，超過下午1點訂購或匯款，則於隔日出貨。<br> 
										&ensp;&ensp;&ensp;<span style="color: red;">每週一公休不出貨</span>，因此星期日下午1點後之訂單，將於星期二寄出。
									 </p>
								</div>
							</div>
							<div class="accordion">
								<div class="accordion-toggle">
									<h3>Q：請問商品出貨後多久可以收到?</h3>
									<span class="date"><i class="fa-solid fa-calendar-days fa-xs"></i> 2023.06.01</span>
								</div>
								<div class="accordion-content">
									 <p>
										A：一般隔日即可送達，週六、日出貨之訂單，將於週一送達。實際出貨狀況以宅配公司作
  										 業為準，遇重大節日可能配達時間會有延遲，敬請提早訂購。
									 </p>
								</div>
							</div>
						</div>
						<div class="quest-btn">
							<h3 class="section-second-title">商品問題</h3>
						</div>
							<div class="accordion">
								<div class="accordion-toggle">
									<h3>Q：請問所有商品均可宅配嗎?</h3>
									<span class="date"><i class="fa-solid fa-calendar-days fa-xs"></i> 2023.06.01</span>
								</div>
								<div class="accordion-content">
									 <p>A：除鹹水鵝之外，其餘商品均可宅配。另「醉鵝」因製作時程較久，若需宅配請提前2天以上訂購。
									 </p>
								</div>
							</div>
							<div class="accordion">
								<div class="accordion-toggle">
									<h3>Q：請問商品可以保存多久?</h3>
									<span class="date"><i class="fa-solid fa-calendar-days fa-xs"></i> 2023.06.01</span>
								</div>
								<div class="accordion-content">
									<p>A：茶鵝1天內食用完畢，真空包冷凍商品3天內食用完畢。為保產品新鮮美味，拆封後請儘速食用完畢。
									 </p>
								</div>
							</div>
							<div class="accordion">
								<div class="accordion-toggle">
									<h3>Q：請問商品要如何食用？</h3>
									<span class="date"><i class="fa-solid fa-calendar-days fa-xs"></i> 2023.06.01</span>
								</div>
								<div class="accordion-content">
									<p>A：建議食用前1天連同包裝先冷藏退冰，並於食用前30分鐘室溫退冰。切勿使用微波爐或電鍋加熱，會導致肉汁流失而口感變差。
									 </p>
								</div>
							</div>
							<div class="accordion">
								<div class="accordion-toggle">
									<h3>Q：請問可以退換貨嗎？</h3>
									<span class="date"><i class="fa-solid fa-calendar-days fa-xs"></i> 2023.06.01</span>
								</div>
								<div class="accordion-content">
									 <p>A：因商品屬於生鮮產品，保存期限較短，並不適用消費者保護法第19條，亦即不享有7天鑑賞期，
										故商品寄出後不提供退換貨服務，請訂購前謹慎考慮。
									 </p>
								</div>
							</div>
							<div class="quest-btn">
								<h3 class="section-second-title">關於實體店</h3>
							</div>
							<div class="accordion">
								<div class="accordion-toggle">
									<h3>Q：請問實體店攤位在哪？</h3>
									<span class="date"><i class="fa-solid fa-calendar-days fa-xs"></i> 2023.06.01</span>
								</div>
								<div class="accordion-content">
									<p>A：台北市：光復市場、永春市場。<br>
									 &ensp;&emsp;新北市：樹林市場、中和福和市場。 <br>
									 &ensp;&emsp;請見Line官方帳號公告之今日設攤地點。</p>
								</div>
							</div>
							<div class="accordion">
								<div class="accordion-toggle">
									<h3>Q：請問實體店舖營業時間？</h3>
									<span class="date"><i class="fa-solid fa-calendar-days fa-xs"></i> 2023.06.01</span>
								</div>
								<div class="accordion-content">
									<p>A：每週二～日，中午12點前，當日現貨若售完將提前收攤。</p>
								</div>
							</div>
						<div class="quest-btn">
							<h2 class="section-second-title">追蹤我們</h2>
						</div>
						<div class="link">
							<div class="left-picture">
								<h3>台南下營 &nbsp;鋐茶鵝</h3>
								<a href="https://www.facebook.com/profile.php?id=100091698824828&mibextid=ZbWKwL"target="_blank"><i class="fa-brands fa-square-facebook fa-9x" style="color: #4267B2;"></i></a>
							</div>
							<div class="right-picture">
								<h3> 官方Line帳號  </h3>
								<!-- 官方ＱＲ code 尚未補上 用icon暫替 -->
								<!-- <a href="#"><i class="fa-brands fa-line fa-9x" style="color: #1fd656;"></i></a> -->
								<a href="#"><i class="fa-sharp fa-solid fa-qrcode fa-9x" style="color:#555555"></i></a>

							</div>
						</div>
					</div>
				</div> <!-- .fullwidth-block -->
			</div>
			</main> <!-- .main-content -->

<!--側邊攔-->
<div class="sidebar">
    <a href="https://www.facebook.com/profile.php?id=100091698824828&mibextid=ZbWKwL"target="_blank"><img src="images/facebook.png" style="width: 35px;height:35px;" ></a>
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
</body>




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
    </script>

	<!-- // 切換地圖iframe
		// $(document).ready(function() {
		// 	$('.market').click(function() {
		// 	var market = $(this).data('market');
		// 	$('.map-iframe').hide(); // 隱藏所有的 iframe
		// 	$('#' + market + '-iframe').show(); // 顯示選定的 iframe
		// 	});
		// }); -->

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

	<script src="JS/jquery-1.11.1.min.js"></script>
	<!-- <script src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script> -->
	<script src="JS/plugins.js"></script>
	<script src="JS/app.js"></script>
		

</html>