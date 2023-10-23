<?php
// 配置Line登入訊息
$CLIENT_ID = '2000852558';
$CLIENT_SECRET = '108bbcfb4d436381b3f1447a8aae221e';
$REDIRECT_URI = 'https://hongteagoose.lionfree.net/register.php';
if (isset($_GET['ID'])) {
    $line = $_GET['ID'];
}
if (isset($_GET['Name'])) {
    $lineName = $_GET['Name'];
}
// 檢查是否有回呼代碼
if (isset($_GET['code'])) {
     // 取得回呼代碼
     $code = $_GET['code'];

     // 使用回呼代碼來取得存取令牌
     $url = 'https://api.line.me/oauth2/v2.1/token';
     $data = array(
         'grant_type' => 'authorization_code',
         'code' => $code,
         'redirect_uri' => $REDIRECT_URI,
         'client_id' => $CLIENT_ID,
         'client_secret' => $CLIENT_SECRET,
         'scope' => 'openid profile', // 请求ID令牌和个人资料信息
     );

     $options = array(
         'http' => array(
             'header' => 'Content-Type: application/x-www-form-urlencoded',
             'method' => 'POST',
             'content' => http_build_query($data),
         ),
     );

     $context = stream_context_create($options);
     $result = file_get_contents($url, false, $context);
     if ($result === false) {           
     }    
     $response = json_decode($result, true);

     if (isset($response['access_token'])) {
         $access_token = $response['access_token'];

         // 使用存取令牌來取得使用者ID
         $url = 'https://api.line.me/v2/profile';
         $options = array(
             'http' => array(
                 'header' => "Authorization: Bearer $access_token",
                 'method' => 'GET',
             ),
         );

         $context = stream_context_create($options);
         $result = file_get_contents($url, false, $context);
         $profile = json_decode($result, true);
         
         
         if (isset($profile['displayName'])) {
            $lineName = $profile['displayName'];
        }
        
         if (isset($profile['userId'])) {
             $line = $profile['userId'];
         }
     }
}
?>

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
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/register.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://static.line-scdn.net/liff/edge/2.13/sdk.js"></script>
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

<!-- 註冊內容 -->
<div class="p-5">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <h1>註冊</h1><br>
          <form action="php/submit_form.php" method="post">
          <div class="form-row">
                <label for="line" class="col-sm col-form-label">LINE:</label>
                <div class="row">
                    <div class="col-sm-8">
                        <input type="hidden" id="lineName" name="lineName" value="<?php echo isset($lineName) ? htmlspecialchars($lineName) : ''; ?>">
                        <input type="text" class="form-control" id="line" name="line" placeholder="請按下旁綁定鍵" value="<?php echo isset($line) ? htmlspecialchars($line) : ''; ?>" readonly>
                    </div>
                    <div class="col-sm-4">
                        <button class="btn btn-success" type="button" id="login-button">綁定LINE帳號</button>
                        <button class="btn btn-danger" type="button" id="delete-button">移除</button>
                    </div>
                </div>
            </div>
            <div class="form-row">
              <label for="account" class="col-sm col-form-label">使用者暱稱:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="account" name="account" placeholder="中英文皆可" required>
              </div>
            </div>
            <div class="form-row">
              <label for="name" class="col-sm col-form-label">姓名:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" placeholder="請輸入姓名" required>
              </div>
            </div>
            <div class="form-row">
              <label for="email" class="col-sm col-form-label">電子郵件:</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email@gmail.com" required>
              </div>
            </div>
            <div class="form-row">
              <label for="phone" class="col-sm col-form-label">電話號碼:</label>
              <div class="col-sm-10">
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="請輸入電話號碼" required>
              </div>
            </div>


            <div class="form-row">
              <label for="address" class="col-sm col-form-label">地址:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="address" name="address" placeholder="請輸入地址，並勿填寫郵政信箱" required>
              </div>
            </div>
            <div class="form-row">
              <label for="password" class="col-sm col-form-label">密碼:</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password" placeholder="請輸入6-15碼英數混合密碼，英文字母區分大小寫" required>
              </div>
            </div>

            <br>
            <div class="form-row">
              <div class="col-sm-12">
                <button class="btn btn-warning" type="submit">提交</button>
                <button class="btn btn-warning" type="button" id="reset-button">重新填寫</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- LINE綁定 -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
        var lineInput = document.getElementById('line');
        var loginButton = document.getElementById('login-button');
        var deleteButton = document.getElementById('delete-button');

        deleteButton.addEventListener('click', function() {
            lineInput.value = ''; // 清空输入框的值
            loginButton.disabled = false; // 启用登录按钮
        });

        if (lineInput.value) {
            loginButton.disabled = true; // userid框有值，禁用按钮
        } else {
            loginButton.disabled = false; // userid框空值，啟動按钮
        }
    });
  </script>
  
  <script>
        

        document.getElementById('login-button').addEventListener('click', function() {
            const state = Math.random().toString(36).substring(7);
            const lineAuthUrl = `https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=<?php echo $CLIENT_ID; ?>&redirect_uri=${encodeURIComponent('<?php echo $REDIRECT_URI; ?>')}&state=${state}&scope=openid%20profile&nonce=${state}`;
            window.location.href = lineAuthUrl;
        });
    </script>

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
    <script>
        $(document).ready(function() {
      var imagePaths = [
     "images/slide2.png",
     "images/slide3.png",
      ];

        currentIndex = 0;
      var imageElement = $("#image");
      
      setInterval(function() {
     currentIndex = (currentIndex + 1) % imagePaths.length;
     
     // 淡出圖片
     imageElement.fadeOut(1000, function() {
       // 切換圖片
       imageElement.attr("src", imagePaths[currentIndex]);
       
       // 淡入圖片
       imageElement.fadeIn(1000);
     });
      }, 5000); // 切換圖片的間隔時間，這裡設置為3秒
    });

    // 重新填寫清除輸入框文字功能
    document.getElementById('reset-button').addEventListener('click', function() {
        var inputElements = document.querySelectorAll('.forminput');
        inputElements.forEach(function(element) {
            element.value = ''; // 清除輸入框文字
        });
    });

    function redirectToRegister() {
        window.location.href = "register.php";
    }

    </script>
    
</body>

</html>