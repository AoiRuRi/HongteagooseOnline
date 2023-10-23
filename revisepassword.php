<?php
session_start();

if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
    $username = $_SESSION['username'];
    $loginText =  "會員：$username"; // 將登入文字設置為使用者名稱
} else {
    echo "無法獲取用戶帳號";
    echo '<script>';
    echo 'alert("無法獲取登入數據，請重新登入");';
    echo 'window.location.href = "index_nologin.php";';
    echo '</script>';
    exit();
}

// 設定資料庫連線參數
$host = '192.168.2.200'; // 或 '127.0.0.1'
$user = 'hongteag_goose'; // 使用者帳號
$password = 'ab7777xy'; // 使用者密碼
$dbname = 'hongteag_goose'; // 資料庫名稱

$mysqli = new mysqli($host, $user, $password, $dbname);
$mysqli->set_charset("utf8");
if ($mysqli->connect_error) {
    die('連線失敗: ' . $mysqli->connect_error);
}

$query = "SELECT * FROM users WHERE Name = ?";
$stmt = $mysqli->prepare($query);

$stmt->bind_param('s', $username);

$result = $stmt->execute();

if ($result === false) {
    die('查詢時發生錯誤: ' . $stmt->error);
}

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $account = $row['Account'];
    $name = $row['Name'];
    $email = $row['Email'];
    $phone = $row['Phone'];
    $address = $row['Address'];
    $hashedPassword = $row['Password']; // 獲取哈希碼
    $line_ID = isset($_POST['line']) ? $_POST['line'] : '';
} else {
    echo "用户不存在";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the old password matches the stored hashed password
    $oldPassword = isset($_POST['old_password']) ? $_POST['old_password'] : '';

    if (!empty($oldPassword)) {
        if (password_verify($oldPassword, $hashedPassword)) {
            // Old password matches, proceed with updates
            $newAccount = isset($_POST['account']) ? mysqli_real_escape_string($mysqli, $_POST['account']) : $account;
            $newName = isset($_POST['name']) ? mysqli_real_escape_string($mysqli, $_POST['name']) : $name;
            $newEmail = isset($_POST['email']) ? mysqli_real_escape_string($mysqli, $_POST['email']) : $email;
            $newPhone = isset($_POST['phone']) ? mysqli_real_escape_string($mysqli, $_POST['phone']) : $phone;
            $newLineID = isset($_POST['line']) ? mysqli_real_escape_string($mysqli, $_POST['line']) : $line_ID;
            $newAddress = isset($_POST['address']) ? mysqli_real_escape_string($mysqli, $_POST['address']) : $address;

            // Hash the new password before updating
            $newPassword = isset($_POST['new_password']) ? $_POST['new_password'] : '';
            if (!empty($newPassword)) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            }

            $updateQuery = "UPDATE users SET Account=?, Name=?, Email=?, Phone=?, Line_ID=?, Address=?, Password=? WHERE Name=?";
            
            $stmt = $mysqli->prepare($updateQuery);
            if ($stmt === false) {
                die('準備更新語句發生錯誤: ' . $mysqli->error);
            }

            $stmt->bind_param('ssssssss', $newAccount, $newName, $newEmail, $newPhone, $newLineID, $newAddress, $hashedPassword, $username);

            $result = $stmt->execute();

            if ($result === false) {
                die('更新數據失敗: ' . $stmt->error);
            }

            echo "資料已成功更新！";

            // If the password field was not empty, the user has changed their password.
            // Log the user out and redirect to the logout page.
            if (!empty($newPassword)) {
                session_unset();
                session_destroy();
                echo '<script>';
                echo 'alert("密碼修改成功，請重新登入");';
                echo 'window.location.href = "index_nologin.php";';
                echo '</script>';
                exit();
            }
        } else {
            echo '<script>';
            echo 'alert("舊密碼輸入錯誤，請再次確認");';
            echo '</script>';
        }
    } else {
        echo "請輸入原先密碼以確認更改。";
    }
}

$mysqli->close();
?>


<html lang="zh-Hant-Tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="image/logoicon.ico" rel="shortcut icon" />
    <title>台南下營鋐茶鵝</title>
    <link rel="stylesheet" type="text/css" href="css/main.css?version=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/index.css?version=<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="JS/main.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Yusei+Magic&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
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
<div class="col-md-9" id="main-section">
    <!-- The HTML form with added old_password, new_password, and confirm_password fields -->
    <!-- 變更密碼 -->
    <div class="p-5" style="height:66%">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1>修改密碼</h1><br>
                    <form method="post" action="">
                        <!-- ... (previous form fields) ... -->

                        <div class="form-row">
                            <label for="old_password" class="col-sm col-form-label">舊密碼:</label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" id="old_password" name="old_password"
                                    required>
                            </div>
                        </div>

                        <div class="form-row">
                            <label for="new_password" class="col-sm col-form-label">新密碼:</label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" id="new_password" name="new_password">
                            </div>
                        </div>

                        <div class="form-row">
                            <label for="confirm_password" class="col-sm col-form-label">確認新密碼:</label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" id="confirm_password"
                                    name="confirm_password">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3 btn-warning">修改密碼</button>
                    </form>
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
        <a href="https://www.facebook.com/profile.php?id=100091698824828&mibextid=ZbWKwL" target="_blank"><img
                src="images/facebook.png" style="width: 35px;height:35px;"></a>
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
    function redirectTorevise() {
        window.location.href = "ReviseMember.php";
    }
</script>

</html>