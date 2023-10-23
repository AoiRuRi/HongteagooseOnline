<?php session_start(); 
// 檢查使用者是否已登入
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
    $username = $_SESSION['username']; // 獲取使用者名稱
    $account = $_SESSION['account']; // 獲取使用者名稱
    $loginText =  "會員：$username"; // 將登入文字設置為使用者名稱
} else {
    $loginText = "會員登入"; // 預設為 "會員登入"
    echo '<script>';
    echo 'alert("無法獲取登入數據，請重新登入");';
    echo 'window.location.href = "index_nologin.php";';
    echo '</script>';
    exit();
}
?>  
<!DOCTYPE html>
<html lang="zh-Hant-Tw">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="images/logoicon.ico" rel="shortcut icon"/>  
    <title>台南下營鋐茶鵝</title>
    <!-- <link rel="stylesheet" href="css/main.css"> -->
    <link rel="stylesheet" href="css/Payment.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Yusei+Magic&display=swap" rel="stylesheet" />
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
    <!-- 購物車資訊 -->
    <div class="container mt-5">
    <h2>購物車</h2>
    <?php
// 在服务器端查询购物车数据和产品数据
// 假设您有获取购物车商品的代码，这里假设将购物车商品数据存储在 $cartItems 数组中

// 连接数据库，查询购物车商品信息
// ...

// 查询购物车商品对应的产品名称

 // 設定資料庫連線參數
 $host = '192.168.2.200';
 $user = 'hongteag_goose';
 $password = 'ab7777xy';
 $dbname = 'hongteag_goose';

 // 建立資料庫連線
 $conn = new mysqli($host, $user, $password, $dbname);
 $conn->set_charset("utf8");

 // 檢查連線是否成功
 if ($conn->connect_error) {
     die("連線失敗: " . $conn->connect_error);
 }
// 執行 SQL 查詢語句
$sql = "SELECT s.Product_ID, p.Product_name, s.TotalPrice, s.Account 
FROM shoppingcart s 
INNER JOIN product p ON s.Product_ID = p.Product_ID 
WHERE s.Account = '$account'";
$result = $conn->query($sql);

// 初始化 TotalPrice 的總和
$totalPriceSum = 0;
?>


<!-- 在前端頁面中，輸出商品列表部分 -->
<table class="table">
    <thead>
        <tr>
            <th>商品名稱</th>
            <th>價格</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['Product_name']; ?></td>
            <td><?php echo $row['TotalPrice']; ?></td>
        </tr>
        <?php
                // 累加 TotalPrice 到總和
                $totalPriceSum += $row['TotalPrice'];
            ?>
    <?php } ?>
    </tbody>
    <tfoot>
    <?php
// 假設您的運費計算邏輯在這裡
$shipping_fee = ($totalPriceSum > 0) ? 100 : 0;
?>
        <!-- 根據購物車商品是否為空設定運費 -->
        <?php if ($totalPriceSum > 0) { ?>
           <!-- 顯示運費 -->
    <tr>
        <td>運費小計(運費皆為100元)</td>
        <td><?php echo $shipping_fee; ?></td>
    </tr>
            
        <?php } else { ?>
            <tr>
                <td>運費小計(運費皆為100元)</td>
                <td>0</td>
            </tr>
        <?php } ?>
        <!-- 顯示總金額 -->
    <tr>
        <td><strong>總金額：</strong></td>
        <td><strong><?php echo $totalPriceSum + $shipping_fee; ?></strong></td>
    </tr>
    </tfoot>
</table>

<?php
// 關閉資料庫連線
$conn->close();
?>
    
</div>


 <!-- 付款頁面區塊 -->
<div class="p-5 text-center_payment bg-light">
    <h1>付款資訊</h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4">
                    <form action="php/addtoorder.php" method="post">
                        <!-- 運送方式相關欄位 -->
                        <div class="mb-3">
                            <label for="shipping-method" class="form-label">選擇運送方式</label>
                            <select class="form-select" id="shipping-method" required>
                                <option value="">請選擇運送方式</option>
                                <option value="宅配">宅配</option>
                            </select>
                        </div>
                        
                        <!-- 付款方式相關欄位 -->
                        <div class="mb-3">
                            <label for="payment-method" class="form-label">選擇付款方式</label>
                            <select class="form-select" id="payment-method" required>
                                <option value="">請選擇付款方式</option>
                                <option value="ATM轉帳(虛擬)">ATM轉帳(虛擬)</option>
                            </select>
                        </div>
                        
                        <!-- 顧客資訊相關欄位 -->
                        <div class="mb-3">
                            <label for="customer-name" class="form-label">姓名</label>
                            <input type="text" class="form-control" id="customer-name" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer-phone" class="form-label">電話</label>
                            <input type="text" class="form-control" id="customer-phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer-email" class="form-label">電子信箱</label>
                            <input type="email" class="form-control" id="customer-email" required>
                        </div>
                        
                        <!-- 收件人資料相關欄位 -->
                        <div class="mb-3">
                            <label for="recipient-name" class="form-label">收件人姓名</label>
                            <input type="text" class="form-control" id="recipient-name" required>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-phone" class="form-label">收件人手機</label>
                            <input type="text" class="form-control" id="recipient-phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="shipping-address" class="form-label">收件地址</label>
                            <input type="text" class="form-control" id="shipping-address" name="shipping-address" required>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="agreement" required>
                            <label class="form-check-label" for="agreement">我已詳閱購物須知</label>
                        </div>
                        <button type="submit" class="btn btn-primary" name="complete_order">完成訂購</button>
                    </form>
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
        function redirectTorevise() {
        window.location.href = "ReviseMember.php";
    }
    </script>

  
    
</body>
</html>
