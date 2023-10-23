<!DOCTYPE html>
<?php session_start(); 
// 檢查使用者是否已登入
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
    header("Location: about_login.php"); // 重定向到已登入頁面
    exit(); // 確保腳本結束執行，避免後續代碼執行
    $username = $_SESSION['username']; // 獲取使用者名稱
    $loginText =  "會員：$username"; // 將登入文字設置為使用者名稱
} else {
    $loginText = "會員登入"; // 預設為 "會員登入"
}
?>   
<html lang="zh-Hant-Tw"> 
<head>
<meta charset="UTF-8"> <!-- 設置字符編碼為 UTF-8 -->
<meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- 設置 IE 瀏覽器的相容性模式 -->
<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- 設置響應式視窗大小 -->
<link href="images/logoicon.ico" rel="shortcut icon"/> <!-- 網頁快捷列圖示 -->

<title>台南下營鋐茶鵝</title> <!-- 網頁的標題 -->

<!-- CSS 樣式表 -->
<link href="css/about.css" rel="stylesheet" type="text/css" media="all" /> 
<link href="css/about_fonts.css" rel="stylesheet" type="text/css" media="all" /> <!-- 連結另一個外部 CSS 檔案用於字型設定 -->
<link rel="stylesheet" href="css/main.css">

<!-- JavaScript 和 Font Awesome -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- 連結 jQuery 函式庫 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> <!-- 連結 Font Awesome 圖示 -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous"> <!-- 連結另一個版本的 Font Awesome 圖示 -->

<!-- Bootstrap CSS 和 JavaScript -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> <!-- 連結 Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css"> <!-- 連結另一個版本的 Bootstrap CSS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script> <!-- 連結 Bootstrap JavaScript 包 -->

<!--[if IE 6]><link href="default_ie6.css" rel="stylesheet" type="text/css" /><![endif]-->
<!-- 針對 Internet Explorer 6 的樣式進行條件性註解 -->

</head> 
</html> 

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

<!-- 每頁開頭頁籤區塊 -->
<div id="logo" class="container">
	<i class="fa-solid fa-house" style="color: #8f8f8f;"></i>&nbsp;<a href="index_nologin.php">首頁</a> — <a href="about_nologin.php">關於我們</a>
</div>

<div id="page" class="container">
        <div class="row">
            <div class="col-lg-6 px-3"><!-- 內容區域 -->
                <div class="title"><!-- 標題區域 -->
                    <h2><span style="color:#000080">關於鋐茶鵝</span></h2><br>
                </div>
                <p><span style="font-size:18px">在餐飲業服務多年的一位廚師，對於中式菜餚有著無盡的熱情和創造力，也有著創業的夢想，
                    希望能讓更多人吃到親手製作的菜餚，同時也能面對面服務客人。<br><br>
                    某次因緣際會參觀養鵝場，喚醒了他對家族特製茶鵝配方的記憶。
                    這個茶鵝配方帶著香甜和煙燻香味的鵝肉，曾在他的童年時代留下了深刻的印象。為了還原這份美味，結合了他過去在餐飲製作方面的經驗，投入了大量的時間和精力進行研究和實驗。
                    從研究調製香料到火侯的控制，都經過不斷的努力嘗試與改良，終於製作出美味的燻茶鵝，再加上與優良養鵝場合作，使用新鮮、優質的鵝肉，
                    讓消費者在品嚐美食的同時，更能夠吃得安心、健康。
                    <br><br>
                    本店嚴選飼養90至100天的鵝，每日新鮮現宰製作，經人工除毛、清洗、川燙等步驟後，再加入蜂蜜、特製香料灌注在鵝肉中，
                    並使用特級紅糖煙燻，讓鵝肉表皮呈現茶褐色，入口鮮嫩肥美，甘甜不膩口，歡迎您來品嚐。</span></p><br>
            </div>
            
            <div class="col-lg-6 d-flex align-items-center"">
                <img src="images/goosemeat.jpg" class="img-fluid">
            </div><!-- 文字介紹右邊的圖片 -->
        </div>  
</div>

<!-- 三大特點區塊 -->
<div id="featured-wrapper"> 
    <div id="featured" class="container"> 
        <div class="major"> <!-- 主要標題區域 -->
            <h2><span style="color:#000080">三大特點</span></h2> 
            <span class="byline">嚴格把關</span>
        </div>
        <div class="three"> <!-- 三個特點的區域 -->
            <div class="column1"> <!-- 第一個特點區域 -->
                <div class="pointicon"> <!-- 特點圖標區域 -->
                    <i class="fas fa-clock"></i> <!-- 圖標 -->
                </div>
                <div class="title"> 
                    <h2>當日現宰<br>新鮮真空包裝<br></h2> 
                </div>
            </div>
            <div class="column2"> <!-- 第二個特點區域 -->
                <div class="pointicon"> <!-- 特點圖標區域 -->
                    <i class="fa-solid fa-mortar-pestle"></i> <!-- 圖標 -->
                    <!-- <span class="icon icon-planet-moon"><i class="fa-regular fa-calendar-clock"></i></span> -->
                </div>
                <div class="title"> 
                    <h2>紅糖、蜂蜜、<br>香料燻製<br>天然食材無負擔<br></h2> 
                </div>
            </div>
            <div class="column3"> <!-- 第三個特點區域 -->
                <div class="pointicon"> <!-- 特點圖標區域 -->
                    <i class="fa-solid fa-utensils"></i> <!-- 圖標 -->
                    <!-- <i class="fa-solid fa-face-smile-tongue"></i> -->
                    <!-- <span class="icon icon-building"></span> -->
                </div>
                <div class="title"> 
                    <h2>富含營養<br>肉質鮮甜<br>煙燻鹹水真美味<br></h2>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 我們的信念區塊 -->
<div id="contact" class="container">
	<div class="major">
		<h2><span style="color:#000080">我們的信念</span></h2>
		<span class="byline">堅持品質與熱忱的服務<br>以真誠的心提供客戶優質美食<br>您的滿意是我們最大的肯定</span>
	</div>
	<!-- <ul class="contact">
		<li><a href="#" class="icon icon-twitter"><span>Twitter</span></a></li>
		<li><a href="#" class="icon icon-facebook"><span></span></a></li>
		<li><a href="#" class="icon icon-dribbble"><span>Pinterest</span></a></li>
		<li><a href="#" class="icon icon-tumblr"><span>Google+</span></a></li>
		<li><a href="#" class="icon icon-rss"><span>Pinterest</span></a></li>
	</ul> -->
</div>

<!-- 製作過程區塊 -->
<div id="portfolio-wrapper"> 
    <div id="portfolio" class="container">
        <div class="major"> <!-- 主要標題區域 -->
            <h2><span style="color:#000080">製作過程</span></h2> <!-- 主要標題 -->
        </div>
        <div class="make"> <!-- 製作過程區域 -->
            <div class="column5"> <!-- 切塊步驟區域 -->
                <a href="#" class="image image-full"><img src="images/abtest1.jpg" height="150" alt="" /></a> <!-- 切塊圖片 -->
                <div class="box"> <!-- 切塊說明區域 -->
                    <p>切塊</p>
                    <!-- <a href="#" class="button">Read More</a> -->
                </div>
            </div>		
            <div class="column5"> <!-- 醃製步驟區域 -->
                <a href="#" class="image image-full"><img src="images/abtest2.jpg" height="150" alt="" /></a> <!-- 醃製圖片 -->
                <div class="box"> <!-- 醃製說明區域 -->
                    <p>醃製</p> 
                    <!-- <a href="#" class="button">Read More</a> -->
                </div>
            </div>		
            <div class="column5"> <!-- 煙燻步驟區域 -->
                <a href="#" class="image image-full"><img src="images/abtest3.jpg" height="150" alt="" /></a> <!-- 煙燻圖片 -->
                <div class="box"> <!-- 煙燻說明區域 -->
                    <p>煙燻</p>
                    <!-- <a href="#" class="button">Read More</a> -->
                </div>	
            </div>	
            <div class="column5"> <!-- 真空包裝步驟區域 -->
                <a href="#" class="image image-full"><img src="images/abtest4.jpg" height="150" alt="" /></a> <!-- 真空包裝圖片 -->
                <div class="box"> <!-- 真空包裝說明區域 -->
                    <p>真空包裝</p>
                    <!-- <a href="#" class="button">Read More</a> -->
                </div>
            </div>	
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


<!-- <div id="copyright" class="container">
	<p>&copy; Untitled. All rights reserved. | Photos by <a href="http://fotogrph.com/">Fotogrph</a> | Design by <a href="http://templated.co" rel="nofollow">TEMPLATED</a>.</p>
</div> -->

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
</body>
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
</html>
