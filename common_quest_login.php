<!DOCTYPE html>  
<?php session_start(); 
// 檢查使用者是否已登入
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
    $username = $_SESSION['username']; // 獲取使用者名稱
    $loginText =  "會員：$username"; // 將登入文字設置為使用者名稱
} else {
    header("Location: common_quest_nologin.php"); // 重定向到未登入頁面
    exit(); // 確保腳本結束執行，避免後續代碼執行
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
	
<div id="logo" class="container">
	<i class="fa-solid fa-house" style="color: #8f8f8f;"></i>&nbsp;<a href="index_nologin.php">首頁</a> — <a href="common_quest_nologin.php">常見問題</a>
</div>
			<main class="main-content">
<div id="page" class="container"> 	
				<div class="fullwidth-block inner-content ">
						<div class="fullwidth-content">
							<h2 class="section-title"><i class="icon-calendar-lg"></i>常見問題&nbsp; Q&A</h2>
							<div class="quest-btn">
								<h3 class="section-second-title">訂購及出貨</h3>
							</div>
							<div class="accordion" id="faqAccordion">
								<div class="accordion-item">
									<h2 class="accordion-header" id="q1">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q1a" aria-expanded="false" aria-controls="q1a">
											購物流程
										</button>
									</h2>
									<div id="q1a" class="accordion-collapse collapse" aria-labelledby="q1" data-bs-parent="#faqAccordion">
										<div class="accordion-body">
											註冊/登入會員→將商品加入購物車→確認訂單內容及收貨人資訊→結帳並匯款→寄出宅配商品→收到/確認商品
										</div>
									</div>
									
									
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="q2">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q2a" aria-expanded="false" aria-controls="q2a">
											請問有哪些運送方式？
										</button>
									</h2>
									<div id="q2a" class="accordion-collapse collapse" aria-labelledby="q2" data-bs-parent="#faqAccordion">
										<div class="accordion-body">
											黑貓宅急便冷凍宅配。為保商品品質，離島區域恕不寄送，請見諒！
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="q3">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q3a" aria-expanded="false" aria-controls="q3a">
											請問運費如何計算？
										</button>
									</h2>
									<div id="q3a" class="accordion-collapse collapse" aria-labelledby="q3" data-bs-parent="#faqAccordion">
										<div class="accordion-body">
											<!-- 運費表格 -->
											<h5 class="text-center">消費滿 <span style="color: red;">$2000</span> 即可享免運費。</h5>
											<br>
											<div class="table-responsive">
												<table class="table table-bordered fee-table text-center">
													<thead class="table table-warning">
														<tr>
															<th>寄件種類</th>
															<th>包裝尺寸</th>
															<th>運費價格</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td data-title="本島寄件">本島互寄</td>
															<td data-title="包裝尺寸">60公分(cm)以下</td>
															<td data-title="運費價格">160元</td>
														</tr>
														<tr>
															<td data-title="本島寄件">本島互寄</td>
															<td data-title="包裝尺寸">60～90公分(cm)</td>
															<td data-title="運費價格">225元</td>
														</tr>
														<tr>
															<td data-title="本島寄件">本島互寄</td>
															<td data-title="包裝尺寸">91～120公分(cm)</td>
															<td data-title="運費價格">290元</td>
														</tr>
													</tbody>												  
												</table>
												
											</div>
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="q4">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q4a" aria-expanded="false" aria-controls="q4a">
											請問有哪些付款方式？
										</button>
									</h2>
									<div id="q4a" class="accordion-collapse collapse" aria-labelledby="q4" data-bs-parent="#faqAccordion">
										<div class="accordion-body">
											目前僅有ATM匯款方式，請加入Line ID：@XXX索取匯款帳號，並請於轉帳後傳訊息告知訂單編號及帳號末五碼，亦可翻拍轉帳收據使用LINE傳送即可，謝謝！
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="q5">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q5a" aria-expanded="false" aria-controls="q5a">
											如何更改訂購內容及送貨地址？
										</button>
									</h2>
									<div id="q5a" class="accordion-collapse collapse" aria-labelledby="q5" data-bs-parent="#faqAccordion">
										<div class="accordion-body">
											訂單送出後即無法修改訂單內容，如需修改，您可由「會員登入」登入帳號，取消訂單後再重新下單。
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="q6">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q6a" aria-expanded="false" aria-controls="q6a">
											請問如何取消訂單？
										</button>
									</h2>
									<div id="q6a" class="accordion-collapse collapse" aria-labelledby="q6" data-bs-parent="#faqAccordion">
										<div class="accordion-body">
											訂單尚未進入包裝作業前您可由「會員登入」登入帳號，自行取消訂單。<br><br>
											※ 訂單取消後即無法復原。<br>
											※ 若訂單商品已進入包裝作業，請恕無法為您取消訂單。<br>
											※ 提醒您，若您取消訂單後重新訂購，商品庫存請依當時頁面為主！
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="q7">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q7a" aria-expanded="false" aria-controls="q7a">
											請問商品出貨時間?
										</button>
									</h2>
									<div id="q7a" class="accordion-collapse collapse" aria-labelledby="q7" data-bs-parent="#faqAccordion">
										<div class="accordion-body">
											每週二~日的下午1點前訂購並匯款完成，商品將於當日寄出，超過下午1點訂購或匯款，則於隔日出貨。<br>
											<span style="color: red;">每週一公休不出貨</span>，因此星期日下午1點後之訂單，將於星期二寄出。
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="q8">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q8a" aria-expanded="false" aria-controls="q8a">
											請問商品出貨後多久可以收到?
										</button>
									</h2>
									<div id="q8a" class="accordion-collapse collapse" aria-labelledby="q8" data-bs-parent="#faqAccordion">
										<div class="accordion-body">
											一般隔日即可送達，週六、日出貨之訂單，將於週一送達。實際出貨狀況以宅配公司作業為準，遇重大節日可能配達時間會有延遲，敬請提早訂購。
										</div>
									</div>
								</div>
							</div>
							
							<div class="quest-btn">
								<h3 class="section-second-title">商品問題</h3>
							</div>
							<div class="accordion" id="productAccordion">
								<div class="accordion-item">
									<h2 class="accordion-header" id="q9">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q9a" aria-expanded="false" aria-controls="q9a">
											請問所有商品均可宅配嗎?
										</button>
									</h2>
									<div id="q9a" class="accordion-collapse collapse" aria-labelledby="q9" data-bs-parent="#productAccordion">
										<div class="accordion-body">
											除鹹水鵝之外，其餘商品均可宅配。另「醉鵝」因製作時程較久，若需宅配請提前2天以上訂購。
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="q10">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q10a" aria-expanded="false" aria-controls="q10a">
											請問商品可以保存多久?
										</button>
									</h2>
									<div id="q10a" class="accordion-collapse collapse" aria-labelledby="q10" data-bs-parent="#productAccordion">
										<div class="accordion-body">
											茶鵝1天內食用完畢，真空包冷凍商品3天內食用完畢。為保產品新鮮美味，拆封後請儘速食用完畢。
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="q11">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q11a" aria-expanded="false" aria-controls="q11a">
											請問商品要如何食用？
										</button>
									</h2>
									<div id="q11a" class="accordion-collapse collapse" aria-labelledby="q11" data-bs-parent="#productAccordion">
										<div class="accordion-body">
											建議食用前1天連同包裝先冷藏退冰，並於食用前30分鐘室溫退冰。切勿使用微波爐或電鍋加熱，會導致肉汁流失而口感變差。
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="q12">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q12a" aria-expanded="false" aria-controls="q12a">
											請問可以退換貨嗎？
										</button>
									</h2>
									<div id="q12a" class="accordion-collapse collapse" aria-labelledby="q12" data-bs-parent="#productAccordion">
										<div class="accordion-body">
											因商品屬於生鮮產品，保存期限較短，並不適用消費者保護法第19條，亦即不享有7天鑑賞期，故商品寄出後不提供退換貨服務，請訂購前謹慎考慮。
										</div>
									</div>
								</div>
							</div>
							<div class="quest-btn">
								<h3 class="section-second-title">關於實體店</h3>
							</div>
							<div class="accordion" id="conAccordion">
								<div class="accordion-item">
									<h2 class="accordion-header" id="q13">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q13a" aria-expanded="false" aria-controls="q13a">
											請問實體店攤位在哪？
										</button>
									</h2>
									<div id="q13a" class="accordion-collapse collapse" aria-labelledby="q13" data-bs-parent="#conAccordion">
										<div class="accordion-body">
											台北市：光復市場、永春市場。<br>
											新北市：樹林市場、福和市場。 <br>
											<br>
											請見Line官方帳號公告之當日設攤地點。
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="q14">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q14a" aria-expanded="false" aria-controls="q14a">
											請問實體店舖營業時間？
										</button>
									</h2>
									<div id="q14a" class="accordion-collapse collapse" aria-labelledby="q14" data-bs-parent="#conAccordion">
										<div class="accordion-body">
											每週二～日，中午12點前，當日現貨若售完將提前收攤。
										</div>
									</div>
								</div>
							</div>
							
						
					</div>
					<style>
						
					</style>
					
					
				</div> <!-- .fullwidth-block -->
</div>
			</main> <!-- .main-content -->
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
</body>

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

	<script src="JS/jquery-1.11.1.min.js"></script>
	<!-- <script src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script> -->
	<script src="JS/plugins.js"></script>
	<script src="JS/app.js"></script>
		

</html>