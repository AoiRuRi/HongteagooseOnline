
<!DOCTYPE html>
<?php session_start(); 
// 檢查使用者是否已登入
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
    $username = $_SESSION['username']; // 獲取使用者名稱
    $account = $_SESSION['account']; // 獲取帳號資訊
    $loginText =  "會員：$username"; // 將登入文字設置為使用者名稱
} else {
    $loginText = "會員登入"; // 預設為 "會員登入"
    echo '<script>';
    echo 'alert("無法獲取登入數據，請先登入");';
    echo 'window.location.href = "orders_nologin.php";';
    echo '</script>';
    exit();
}
?>  
<html lang="zh-Hant-Tw">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="image/logoicon.ico" rel="shortcut icon"/>  
    <title>台南下營鋐茶鵝</title>
    <link rel="stylesheet" href="css/meber.css?version=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/main.css?version=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/orders.css?version=<?php echo time(); ?>" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <div class="col-md-9" id="main-section">
            <!-- 右側內容 -->
            <div class="col-md-9">
            <?php
 // 設定資料庫連線參數
$host = '192.168.2.200'; // 或 '127.0.0.1'
$user = 'hongteag_goose'; // 使用者帳號
$password = 'ab7777xy'; // 使用者密碼
$dbname = 'hongteag_goose'; // 資料庫名稱

 // 建立資料庫連線
 $conn = new mysqli($host, $user, $password, $dbname);
 $conn->set_charset("utf8");
 // 檢查連線是否成功
 if ($conn->connect_error) {
     die("連線失敗: " . $conn->connect_error);
 }
 // 執行 SQL 查詢語句

 // 只找符合目前已登入的帳戶資訊的資料
$currentAccount = $_SESSION['account'];
$sql = "SELECT Product_ID, ProductName, Purchase_OrderID, Purchase_Quantity, Purchase_Price, Status, Transfer, Date 
FROM purchase_order WHERE Account = '$currentAccount'";
$result = $conn->query($sql);
?>

                <!-- My Orders content -->
                <div class="mt-4">
                    <h3>我的訂單</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>訂購日期</th>
                                <th>訂單編號</th>
                                <th>價格</th>
                                <th>狀態</th>
                                <th>轉帳代碼後五碼</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Add your code to fetch and display the order details here -->
                            <?php

            $previousOrderID = null; // 用於跟蹤前一筆訂單編號
            
            // 在這裡遍歷資料庫中的每一筆訂單資料，填充到表格中
            while($row = $result->fetch_assoc()) {
                // 如果訂單編號不同於前一筆，則顯示該訂單的訂單資訊
                if ($row["Purchase_OrderID"] != $previousOrderID) {

                    
                    
                echo "<tr>";
                echo "<td>" . $row["Date"] . "</td>"; // 訂購日期
                echo "<td>" . $row["Purchase_OrderID"] . "</td>"; // 訂單編號
                // echo "<td>". $row["Purchase_Price"] ."</td>"; // 暫時以示範代碼取代
                echo "<td>" . $row["Status"] . "</td>"; // 暫時以示範代碼取代
                echo "<td>";
                echo "<input type='text' class='transfer-input' value='" . $row["Transfer"] . "'>";
                echo "<button class='save-btn' data-order-id='" . $row["Purchase_OrderID"] . "'>儲存</button>";
                echo "</td>";
                echo '<td><button class="toggle-btn">展開/收起</button></td>';
               
                echo "</tr>";
            }
            
            $previousOrderID = $row["Purchase_OrderID"]; // 更新前一筆訂單編號
        }
            ?>
                       
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        // 關閉資料庫連線
        $conn->close();
        ?>      
          
            
             
                <footer class="p-4 border-top mt-auto">
                    <!-- ...existing code... -->
                    <div class="p-5 text-center_time bg-light mt-4">
                        <h1>營業資訊</h1>
                        <div class="row">
                            <div class="col-md-3">
                                <h3>光復市場</h3>
                                <img src="images/Guangfu.jpg" alt="光復市場圖片" class="img-fluid rounded-circle">
                            </div>
                            <div class="col-md-3">
                                <h3>永春市場</h3>
                                <img src="images/Yongchun.jpg" alt="永春市場圖片" class="img-fluid rounded-circle">
                            </div>
                            <div class="col-md-6 mt-4 mt-md-0">
                                <div class="my-auto">
                                    <h4 class="text-center_time">營業時間：早上6:00 - 售完為止</h4>
                                    <br>
                                    <a href="#" class="btn btn-warning">立即下單</a>
                                    <a href="#" class="btn btn-outline-warning disabled">提供宅配服務 <img src="images/delivery.png" style="width: 20px;height:20px;"></a>
                                </div>
                            </div>
                        </div>
                    </div>
    </div>
    </div>
                </footer>
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
    <a href="https://line.me/zh-hant/"><img src="images/line.png" style="width: 35px;height:35px;"></a>
    <a href="#" class="back-to-top"><img src="images/up-arrows.png" style="width: 35px;height:35px;"></a>
</div>

    </body>
   
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
    }else {
        // 如果未登录，显示登录窗口并禁用关闭按钮
        var loginModal = document.getElementById('login-modal');
        loginModal.style.display = 'block';

        var loginCloseButton = document.getElementById('close-button');
        loginCloseButton.style.display = 'none';

        var mainpage = document.getElementById('main-section');
        mainpage.style.display = 'none';
    }
});
</script>

<script>
// 在頁面載入時執行，用於顯示所有子表格
document.addEventListener("DOMContentLoaded", () => {
    const toggleButtons = document.querySelectorAll('.toggle-btn');

    toggleButtons.forEach(button => {
        button.click(); // 模擬點擊按鈕，展開所有子表格
    });
});

const toggleButtons = document.querySelectorAll('.toggle-btn');

toggleButtons.forEach(button => {
    button.addEventListener('click', () => {
        const row = button.parentElement.parentElement;
        const subRow = row.nextElementSibling;

        if (subRow && subRow.classList.contains('sub-table-row')) {
            // 子表格已存在，切換可見性以實現展開/收起
            if (subRow.style.display === 'table-row') {
                subRow.style.display = 'none'; // 收起
            } else {
                subRow.style.display = 'table-row'; // 展開
            }
        } else {
            // 使用AJAX載入子表格資料
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'php/order_detail.php?order_id=' + row.cells[1].textContent, true);

            xhr.onload = () => {
                if (xhr.status === 200) {
                    const detailsRow = document.createElement('tr');
                    detailsRow.classList.add('sub-table-row');
                    detailsRow.innerHTML = `
                        <td colspan="6">
                            <!-- 將AJAX回傳的資料插入這裡 -->
                            ${xhr.responseText}
                        </td>
                    `;

                    row.parentNode.insertBefore(detailsRow, row.nextSibling);
                    // 在子表格中找到價格數據，這部分取決於您的子表格結構
                    const subTable = detailsRow.querySelector('.sub-table');
                    const subTablePriceCells = subTable.querySelectorAll('tbody td:nth-child(3)'); // 這裡假設價格是子表格中的第三列

                    let subTotalPrice = 0;

                    subTablePriceCells.forEach(priceCell => {
                        subTotalPrice += parseFloat(priceCell.textContent);
                    });

                    // 將總價格插入到母表格中
                    const totalPriceCell = document.createElement('td');
                    totalPriceCell.textContent = `${subTotalPrice.toFixed(0)}`; //tofixed後面的數字代表顯示到小數第幾位
                    row.insertBefore(totalPriceCell, row.querySelector('td:nth-child(3)')); // 插入到第四個 <td> 的前面
                    row.parentElement.insertBefore(detailsRow, row.nextSibling);
                } else {
                    console.error('AJAX request failed');
                }
            };

            xhr.send();
        }
    });
});
</script>
<script>//轉帳後五碼寫入資料庫
    $(document).ready(function () {
        $('.save-btn').click(function () {
            const orderID = $(this).data('order-id');
            const transferCode = $(this).prev('.transfer-input').val();

            // 發送AJAX請求到後端以更新資料庫中的transfer欄位
            $.ajax({
                type: 'POST',
                url: 'php/update_transfer.php', // 指向處理更新的後端腳本
                data: {
                    orderID: orderID,
                    transferCode: transferCode
                },
                success: function (response) {
                    // 在成功後執行的操作，可以是刷新頁面或其他處理
                    alert('轉帳號碼已更新');
                    location.reload(); // 重整頁面
                },
                error: function () {
                    alert('更新失敗，請重試');
                    location.reload(); // 重整頁面
                }
            });
        });
    });
</script>


    </html>
  
    
    
    
    
    
    