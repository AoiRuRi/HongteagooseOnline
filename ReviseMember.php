<!DOCTYPE html>
<?php
// 啟動或恢復現有的 session
session_start();
// 檢查使用者是否已登入
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
    $account = $_SESSION['account']; // 獲取使用者名稱
    $username = $_SESSION['username']; // 獲取使用者名稱
    $loginText =  "會員：$username"; // 將登入文字設置為使用者名稱
} else {
    echo '<script>';
    echo 'alert("無法獲取登入數據，請重新登入");';
    echo 'window.location.href = "index_nologin.php";';
    echo '</script>';
    exit();
}
?>
<?php
// 確認帳號是否存在於 $_SESSION 中
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // 若帳號不存在，進行適當的錯誤處理
    echo "無法獲取使用者帳號";
    exit();
}


// 獲取目前登入使用者的使用者名稱
$username = $_SESSION['username'];

// 設定資料庫連線參數
$host = '192.168.2.200'; // 或 '127.0.0.1'
$user = 'hongteag_goose'; // 使用者帳號
$password = 'ab7777xy'; // 使用者密碼
$dbname = 'hongteag_goose'; // 資料庫名稱

// 建立與 MySQL 資料庫的連線
$mysqli = new mysqli($host, $user, $password, $dbname);
$mysqli->set_charset("utf8");
// 檢查連線是否成功
if ($mysqli->connect_error) {
    die('連線失敗: ' . $mysqli->connect_error);
}

// 使用使用者名稱從資料庫中檢索使用者資訊
$query = "SELECT * FROM users WHERE Name = ?";
$stmt = $mysqli->prepare($query);

// 綁定使用者名稱參數
$stmt->bind_param('s', $username);

// 執行查詢
$result = $stmt->execute();

if ($result === false) {
    die('查詢時發生錯誤: ' . $stmt->error);
}

// 取得查詢結果
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // 在此處讀取資料庫中的其他欄位，例如 name、email、phone、address 等
    $account = $row['Account'];
    $name = $row['Name'];
    $email = $row['Email'];
    $phone = $row['Phone'];
    $address = $row['Address'];
    $password = $row['Password'];
    $line_ID = $row['Line_ID'];
} 
else {
    // 使用者不存在，進行適當的錯誤處理
    echo "使用者不存在";
    exit();
}

// 關閉資料庫連線
$mysqli->close();
?>

<html lang="zh-Hant-Tw">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="image/logoicon.ico" rel="shortcut icon"/>  
    <title>台南下營鋐茶鵝</title>
    <!-- <link rel="stylesheet" href="css/main.css"> -->
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

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
              <!-- 左側固定欄位 -->
              <div class="list-group">
                <a href="ReviseMember.php" class="list-group-item list-group-item-action">會員中心</a>
                <a href="orders.php" class="list-group-item list-group-item-action">我的訂單</a>
                <a href="revise.php" class="list-group-item list-group-item-action">修改資料</a>
                <a href="revisepassword.php" class="list-group-item list-group-item-action">更改密碼</a>
            </div>
        </div>

<!-- 會員資料 -->
<div class="col-md-9" id="main-section">
<div class="p-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1>會員中心</h1><br>
                <form>
                    <div class="form-row">
                        <label for="account" class="col-sm col-form-label">使用者暱稱:</label>
                        <div class="col-sm-5">
                        <input type="text" class="form-control" id="account" name="account" required value="<?php echo htmlspecialchars($account); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="name" class="col-sm col-form-label">姓名:</label>
                        <div class="col-sm-5">
                        <input type="text" class="form-control" id="name" name="name" required value="<?php echo htmlspecialchars($name); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="email" class="col-sm col-form-label">電子郵件:</label>
                        <div class="col-sm-5">
                            <input type="email" class="form-control" id="email" name="email" required value="<?php echo htmlspecialchars($email); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="phone" class="col-sm col-form-label">電話號碼:</label>
                        <div class="col-sm-5">
                            <input type="tel" class="form-control" id="phone" name="phone" required value="<?php echo htmlspecialchars($phone); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="line" class="col-sm col-form-label">LINE:</label>
                        <div class="row">
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="line" name="line" required placeholder="可進入修改資料中新增" value="<?php echo htmlspecialchars($line_ID); ?>" readonly>
                        </div>
                    
                    </div>
                    <div class="form-row">
                        <label for="address" class="col-sm col-form-label">地址:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="address" name="address" required value="<?php echo htmlspecialchars($address); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="password" class="col-sm col-form-label">密碼:</label>
                        <div class="col-sm-5">
                            <input type="password" class="form-control" id="password" name="password" required value="<?php echo htmlspecialchars($password); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="row mt-3">
                            <div class="col-sm-3">
                                <a href="revisepassword.php" class="btn btn-warning">修改密碼</a>                        
                            </div>
                            <div class="col-sm-3">
                                <a href="revise.php" class="btn btn-warning">修改資料</a>
                                <!-- <button class="btn btn-warning" type="submit" id="confirm-button" style="display: none;">確認修改</button> -->
                            </div>
                        </div>
                    </div>
                </form>
                <br>
            </div>
            <div class="col-md-4">
                <div class="ad">
                </div>
            </div>
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

<script>
// JavaScript事件處理程序
document.addEventListener("DOMContentLoaded", function() {
    var editButton = document.querySelector(".edit-button");
    var confirmButton = document.querySelector(".confirm-button");
    var readOnlyFields = document.querySelectorAll("input[readonly]");

    // 編輯按鈕點擊事件處理程序
    editButton.addEventListener("click", function() {
        // 解除readonly屬性
        readOnlyFields.forEach(function(field) {
            field.removeAttribute("readonly");
        });

        // 切換按鈕可見性
        editButton.style.display = "none";
        confirmButton.style.display = "block";
    });

    // 確認修改按鈕點擊事件處理程序
    confirmButton.addEventListener("click", function() {
        // 执行修改后的数据提交操作，可以使用AJAX或者表单提交方式

        // 设置readonly属性
        readOnlyFields.forEach(function(field) {
            field.setAttribute("readonly", "readonly");
        });

        // 切換按鈕可見性
        editButton.style.display = "block";
        confirmButton.style.display = "none";
    });
});


</script>



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

    </script>
    
</body>
<script>   
// <?php
// // 啟動或恢復現有的 session
// session_start();

// // 檢查使用者是否已登入
// if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
//     // 如果用戶未登入，將其重定向到登入頁面
//     header("Location: login.php");
//     exit();
// }

// // 獲取使用者ID
// $userID = $_SESSION['userID'];

// // 連接到資料庫（假設您已經設置了資料庫連線）
// $host = 'localhost'; // 或 '127.0.0.1'
// $user = 'root'; // 使用者帳號
// $password = ''; // 使用者密碼
// $dbname = 'your_database'; // 資料庫名稱

// // 建立與 MySQL 資料庫的連線
// $mysqli = new mysqli($host, $user, $password, $dbname);

// // 檢查連線是否成功
// if ($mysqli->connect_error) {
//     die('連線失敗: ' . $mysqli->connect_error);
// }

// // 接收來自表單的數據
// $newAccount = $_POST['newAccount'];
// $newName = $_POST['newName'];
// $newEmail = $_POST['newEmail'];
// // 繼續接收其他數據...

// // 創建 UPDATE 語句
// $updateQuery = "UPDATE users SET Account=?, Name=?, Email=? WHERE ID=?";

// $stmt = $mysqli->prepare($updateQuery);
// if ($stmt === false) {
//     die('準備更新語句時發生錯誤: ' . $mysqli->error);
// }

// // 綁定參數
// $stmt->bind_param('sssi', $newAccount, $newName, $newEmail, $userID);

// // 執行更新
// $result = $stmt->execute();

// if ($result === false) {
//     die('更新數據庫時發生錯誤: ' . $stmt->error);
// }

// // 更新成功，可以顯示成功消息
// echo "資料已成功更新！";

// // 關閉資料庫連線
// $mysqli->close();
?>
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
</html>