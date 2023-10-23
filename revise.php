<?php
session_start();

if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
    $account = $_SESSION['account']; // 獲取使用者名稱
    $username = $_SESSION['username'];
    $loginText =  "會員：$username"; // 將登入文字設置為使用者名稱
} else {
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
    die('連接失敗: ' . $mysqli->connect_error);
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
    $hashedPassword = $row['Password']; // 获取哈希密码
    $line_ID = $row['Line_ID'];
} else {
    echo "用户不存在，請重新登入。";
    echo '<br><a href="index_nologin.php">返回登入頁面</a>';
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 獲取和清理表單中的用戶數據
    $newAccount = isset($_POST['account']) ? mysqli_real_escape_string($mysqli, $_POST['account']) : $account;
    $newName = isset($_POST['name']) ? mysqli_real_escape_string($mysqli, $_POST['name']) : $name;
    $newEmail = isset($_POST['email']) ? mysqli_real_escape_string($mysqli, $_POST['email']) : $email;
    $newPhone = isset($_POST['phone']) ? mysqli_real_escape_string($mysqli, $_POST['phone']) : $phone;
    $newLineID = isset($_POST['line']) ? mysqli_real_escape_string($mysqli, $_POST['line']) : $line_ID;
    $newlineName = isset($_POST['lineName']) ? mysqli_real_escape_string($mysqli, $_POST['lineName']) : $lineName;
    $newAddress = isset($_POST['address']) ? mysqli_real_escape_string($mysqli, $_POST['address']) : $address;
    $currentPassword = isset($_POST['current_password']) ? mysqli_real_escape_string($mysqli, $_POST['current_password']) : '';

    // 建立與 MySQL 資料庫的連線
    $host = '192.168.2.200'; // 或 '127.0.0.1'
    $user = 'hongteag_goose'; // 使用者帳號
    $password = 'ab7777xy'; // 使用者密碼
    $dbname = 'hongteag_goose'; // 資料庫名稱
    
    $mysqli = new mysqli($host, $user, $password, $dbname);
    $mysqli->set_charset("utf8");

    // 檢查連線是否成功
    if ($mysqli->connect_errno) {
        die('連線失敗: ' . $mysqli->connect_error);
    }

    // 先檢查帳號是否已存在
    $checkQuery = "SELECT COUNT(*) FROM users WHERE Account = ?";
    $checkParams = ["s", &$newaccount];

    // 檢查Line_ID是否存在並且不為空
    if (!empty($newLineID)) {
        $checkQuery .= " OR Line_ID = ?";
        $checkParams[0] .= "s"; // 添加一個s，表示Line_ID是一個字符串
        $checkParams[] = &$newLineID; // 添加Line_ID到參數數組
    }

    $checkStmt = $mysqli->prepare($checkQuery);

    // 將參數動態綁定到語句
    call_user_func_array([$checkStmt, 'bind_param'], $checkParams);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    // 如果帳號已存在，顯示提示訊息
    if ($count > 0&&$newAccount==$account|| $line_ID==$newLineID&&!empty($newLineID)) {
        echo "<script>alert('此帳號已有人重複！'); history.go(-1);</script>";
        exit();
    }


    // Verify the current password before making any changes
    if (!empty($currentPassword) && password_verify($currentPassword, $hashedPassword)) {
        $updateQuery = "UPDATE users SET Account=?, Name=?, Email=?, Phone=?, Line_ID=?, Address=? WHERE Name=?";
        
        $stmt = $mysqli->prepare($updateQuery);
        if ($stmt === false) {
            die('準備更新語句時發生錯誤: ' . $mysqli->error);
        }

        $stmt->bind_param('sssssss', $newAccount, $newName, $newEmail, $newPhone, $newLineID, $newAddress, $username);

        $result = $stmt->execute();

        if ($result === false) {
            die('更新數據庫時發生錯誤: ' . $stmt->error);
        }

        // Redirect to ReviseMember.php upon successful update
            // 更新 session 中的 username
            $_SESSION['username'] = $newName;
            echo '<script>';
            if(empty($newLineID)){
                $conn = new mysqli("192.168.2.200", "hongteag_linebot", "1234", "hongteag_linebot");
                // 檢查連線是否成功
                if ($conn->connect_error) {
                    die("連線失敗: " . $conn->connect_error);
                }
                $sql = "DELETE FROM `linedata` WHERE user_id = '$line_ID'";
                if ($conn->query($sql) === TRUE) {
                    
                    $file="revise";
                    header("Location: https://hongteagoose.lionfree.net/linebot/automenu.php?ID=$line_ID&file=$file"); // 重定向到automenu.php，將userid傳至自動更新選單    
                    exit();
                }
                
            }
            if ($line_ID!=$newLineID&&!empty($newLineID)) {
                $conn = new mysqli("192.168.2.200", "hongteag_linebot", "1234", "hongteag_linebot");
                // 檢查連線是否成功
                if ($conn->connect_error) {
                    die("連線失敗: " . $conn->connect_error);
                }
                $query = "SELECT * FROM linedata WHERE user_id = '$newLineID'";
                $result = $conn->query($query);
                if ($result->num_rows == 0) {
                    $sql = "INSERT INTO linedata (display_name, user_id) VALUES ('$newlineName', '$newLineID')";
                    if ($conn->query($sql) === TRUE) {
                        $file="revise";
                        header("Location: https://hongteagoose.lionfree.net/linebot/automenu.php?ID=$newLineID&file=$file"); // 重定向到automenu.php，將userid傳至自動更新選單    
                        exit();   
                    }
                }
            }
            echo 'alert("資料修改成功");';
            echo 'window.location.href = "ReviseMember.php";';
            echo '</script>';
        
        exit(); // Make sure to exit to prevent further code execution
    } else {
        echo "當前密碼不正確。";
    }
}

$mysqli->close();
?>

<?php
// 配置Line登入訊息
$CLIENT_ID = '2000736711';
$CLIENT_SECRET = '0b8dd34c3c9d089ef9afacf3d7a2c9ae';
$REDIRECT_URI = 'https://hongteagoose.lionfree.net/revise.php';

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
            $line_ID = $profile['userId'];
         }
     }
}
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
    <!-- 修改會員資料 -->
    <div class="p-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1>修改會員資料</h1><br>
                    <form method="post" action="">

                        <div class="form-row">
                            <label for="name" class="col-sm col-form-label">姓名:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="name" name="name" required
                                    value="<?php echo htmlspecialchars($name); ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="email" class="col-sm col-form-label">電子郵件:</label>
                            <div class="col-sm-5">
                                <input type="email" class="form-control" id="email" name="email" required
                                    value="<?php echo htmlspecialchars($email); ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="phone" class="col-sm col-form-label">電話號碼:</label>
                            <div class="col-sm-5">
                                <input type="tel" class="form-control" id="phone" name="phone" required
                                    value="<?php echo htmlspecialchars($phone); ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="line" class="col-sm col-form-label">LINE:</label>
                            <div class="row">
                                <div class="col-sm-7">
                                    <input type="hidden" id="lineName" name="lineName" value="<?php echo isset($lineName) ? htmlspecialchars($lineName) : ''; ?>">
                                    <input type="text" class="form-control" id="line" name="line" placeholder="請按下旁綁定鍵，無法自行輸入" required value="<?php echo isset($line_ID) ? htmlspecialchars($line_ID) : ''; ?>" readonly>
                                </div>
                                <div class="col-sm-5">
                                    <button class="btn btn-success" type="button" id="login-button">綁定</button>
                                    <button class="btn btn-danger" type="button" id="delete-button">移除</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="address" class="col-sm col-form-label">地址:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="address" name="address" required
                                    value="<?php echo htmlspecialchars($address); ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="current_password" class="col-sm col-form-label">請輸入密碼:</label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" id="current_password"
                                    name="current_password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 btn-warning">確定修改</button>
                    </form>
                </div>
            </div>
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
                loginButton.disabled = false; // 開啟按钮
            });

            if (lineInput.value) {
                loginButton.disabled = true; // 输入框有值，禁用按钮
            } else {
                loginButton.disabled = false; // 输入框为空，启用按钮
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