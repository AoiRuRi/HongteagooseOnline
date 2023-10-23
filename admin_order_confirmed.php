<!DOCTYPE html>
<html lang="zh-Hant-Tw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  
    <link href="images/logoicon.ico" rel="shortcut icon"/>  
    <!-- <link rel="stylesheet" href="css/admin.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="css/main.css?version=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/index.css?version=<?php echo time(); ?>"> -->
    <!-- <link rel="stylesheet" href="css/main.css" /> -->
    <!-- <link rel="stylesheet" href="css/index.css" /> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Yusei+Magic&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>
<body>

    <nav>
        <div class="navbar navbar-expand-lg p-3 " style="background-color: #fede00">
            <div class = "container">
                <a href="index_nologin.php"><img style="width: 200px;" src="images/logo.png"></a>
            </div>
        </div>
    </nav>

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
    $sql = "SELECT Purchase_OrderID, Purchase_Quantity, Purchase_Price, Status, Transfer, Date, Account, Address 
    FROM purchase_order WHERE Status = '待確認款項'";
    $result = $conn->query($sql);
    
    // 儲存所有訂單資料的數組
    $orders = array();
    $seenOrderIDs = array(); // 用於跟蹤已經讀取過的訂單編號

    // 建立一個陣列來存儲每個帳號的總 Purchase_Price
    $accountTotalPurchasePrice = array();

    while ($row = $result->fetch_assoc()) {
        $account = $row["Account"];
        $purchasePrice = $row["Purchase_Price"];

        // 檢查帳號是否已經在陣列中，如果沒有，就初始化它
        if (!isset($accountTotalPurchasePrice[$account])) {
            $accountTotalPurchasePrice[$account] = 0;
        }

        // 將 Purchase_Price 累加到相應的帳號總金額中
        $accountTotalPurchasePrice[$account] += $purchasePrice;

        $orderID = $row["Purchase_OrderID"];

        // 檢查訂單ID是否已經被處理，如果沒有，就將該訂單添加到 $orders 陣列中
        if (!in_array($orderID, $seenOrderIDs)) {
            $row["Total_Purchase_Price"] = $accountTotalPurchasePrice[$account]; // 將帳號的總金額添加到訂單數據中
            $orders[] = $row;
            $seenOrderIDs[] = $orderID; // 將訂單ID添加到已經處理過的陣列中
        }
    }

    // 現在 $orders 陣列包含了每個訂單以及相應帳號的總 Purchase_Price
?>

    <div style="margin: 20px;">
        <div class="row">
            <div class="col-md-2">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action disabled bg-light">首頁</a>
                    <a href="admin_carousel.php" class="list-group-item list-group-item-action">輪播圖圖片</a>
                    <a href="admin_news.php" class="list-group-item list-group-item-action">最新消息</a>
                    <a href="admin_popular.php" class="list-group-item list-group-item-action">熱門品項</a>
                    <div class="list-group-item list-group-item-action disabled bg-light">商品頁</div>
                    <a href="admin_product.php" class="list-group-item list-group-item-action">商品管理</a>
                    <div class="list-group-item list-group-item-action disabled bg-light">訂單</div>
                    <a href="admin_order_nopay.php" class="list-group-item list-group-item-action">未付款</a>
                    <a href="admin_order_confirmed.php" class="list-group-item list-group-item-action bg-warning">待確認款項</a>
                    <a href="admin_order_havepay.php" class="list-group-item list-group-item-action">待出貨</a>
                    <a href="admin_order_ship.php" class="list-group-item list-group-item-action">已出貨</a>
                    <div class="list-group-item list-group-item-action disabled bg-light">使用者管理</div>
                    <a href="admin_user.php" class="list-group-item list-group-item-action">使用者管理</a>
                    <div class="list-group-item list-group-item-action disabled bg-light">LINE官方帳號</div>
                    <a href="admin_linebot_admin.php" class="list-group-item list-group-item-action"><i class="fab fa-line"></i> 管理者管理</a>
                    <a href="admin_linebot_user.php" class="list-group-item list-group-item-action"><i class="fab fa-line"></i> 使用者管理</a>
                </div>
            </div>
            <div class="col-md-10">
            <div class="card">
                <div class="section-heading">
                    <div class="search-input-container text-center">
                        <div class="input-group">
                        <input type="text" id="searchInput" class="form-control"  onkeyup="searchorder()" placeholder="搜尋單號、訂購人、收貨地址或轉帳後五碼">
                        <div class="input-group-append">
                            <button class="btn btn-warning" onclick="searchorder()">訂單搜尋</button>
                                <div id="noResultsMessage" style="display: none;">查無此訂單</div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-header">
                    未付款管理
                </div>
                <div class="card-body">
                    <?php foreach ($orders as $order) : ?>
                        <div class="order-card" data-order-id="<?= $order["Purchase_OrderID"] ?>" data-username="<?= $order["Account"] ?>" data-address="<?= $order["Address"] ?>" data-transfer="<?= $order["Transfer"] ?>">
                        <div class="card mb-2">
                            <div class="row">
                                <div class="card-body col-md-1 d-flex justify-content-center align-items-center"><?= $order["Date"] ?></div>
                                <div class="card-body col-md-1 d-flex justify-content-center align-items-center" id="pid"><?= $order["Purchase_OrderID"] ?></div>
                                <div class="card-body col-md-1 d-flex justify-content-center align-items-center"><?= $order["Account"] ?></div>
                                <div class="card-body col-md-2 d-flex  align-items-center">
                                <?php
                               // 取得目前帳號的總購買金額
                               $currentAccountTotalPrice = $accountTotalPurchasePrice[$order["Account"]] ?? 0;
                               echo '總購買金額：' . $currentAccountTotalPrice . '元';
                               ?></div>
                                <div class="card-body col-md-1 d-flex justify-content-center align-items-center">
                                    <div class="form-group">
                                        <select class="form-control status-select" data-order-id="<?= $order["Purchase_OrderID"] ?>">
                                            <option value="未付款" <?= ($order["Status"] == '未付款' ? 'selected' : '') ?>>未付款</option>
                                            <option value="待確認款項" <?= ($order["Status"] == '待確認款項' ? 'selected' : '') ?>>待確認款項</option>
                                            <option value="待出貨" <?= ($order["Status"] == '待出貨' ? 'selected' : '') ?>>待出貨</option>
                                            <option value="已出貨" <?= ($order["Status"] == '已出貨' ? 'selected' : '') ?>>已出貨</option>
                                        </select>
                                    </div>
                               
                                </div>
                                <div class="card-body col-md-1 d-flex justify-content-center align-items-center"><button class="btn btn-warning status-save-btn">儲存</button></div>
                                <div class="card-body col-md-1 d-flex justify-content-center align-items-center"><?= $order["Transfer"] ?></div>
                                <!-- <div class="card-body col-md-1 d-flex justify-content-center align-items-center"><?= $order["Status"] ?></div> -->
                                <div class="card-body col-md-1 d-flex justify-content-center align-items-center">
                                    <button class="btn btn-warning" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $order["Purchase_OrderID"] ?>" aria-expanded="false" aria-controls="collapse<?= $order["Purchase_OrderID"] ?>">
                                        展開
                                    </button>
                                </div>
                            </div>
                            <div class="collapse" id="collapse<?= $order["Purchase_OrderID"] ?>">
                                <div class="card card-body" style="margin: 10px;">
                                    <!-- 子表格 -->
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>購買商品</th>
                                                <th>數量</th>
                                                <th>價格</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $totalPrice = 0;
                                            // 在这里查询数据库并插入子表格数据
                                            $order_id = $order["Purchase_OrderID"];
                                            $subSql = "SELECT ProductName, Purchase_Quantity, Purchase_Price FROM purchase_order WHERE Purchase_OrderID = ?";
                                            $subStmt = $conn->prepare($subSql);

                                            if ($subStmt) {
                                                $subStmt->bind_param("i", $order_id);
                                                $subStmt->execute();
                                                $subResult = $subStmt->get_result();

                                                while ($subRow = $subResult->fetch_assoc()) {
                                                    echo '<tr>';
                                                    echo '<td>' . $subRow["ProductName"] . '</td>';
                                                    echo '<td>' . $subRow["Purchase_Quantity"] . '</td>';
                                                    echo '<td>' . $subRow["Purchase_Price"] . '</td>';
                                                    echo '</tr>';
                                                    $totalPrice += $subRow["Purchase_Price"];
                                                }

                                                $subStmt->close();
                                            }
                                            ?>                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            </div>
        </div>
    </div>
    



<script>
    document.addEventListener('DOMContentLoaded', function() {
    const statusSelects = document.querySelectorAll('.status-select');
    const statusSaveButtons = document.querySelectorAll('.status-save-btn');

    statusSaveButtons.forEach(function(button, index) {
        button.addEventListener('click', function() {
        const selectedStatus = statusSelects[index].value;
        const orderID = statusSelects[index].getAttribute('data-order-id');

        // Make an Ajax request to update the status
        $.ajax({
            type: 'POST',
            url: 'php/order_update_status.php', // Ensure this is the correct path
            data: { orderID: orderID, status: selectedStatus },
            success: function(response) {
            // Handle the response as needed
            console.log('Status updated successfully');
            
            // Reload the page to reflect the changes
            location.reload();
            },
            error: function() {
            console.error('Status update failed');
            }
        });
        });
    });
    });
</script>




<script>
// 用于筛选卡片的搜索功能
function searchorder() {
  var input = document.getElementById("searchInput");
  var filter = input.value.toUpperCase();
  var cards = document.querySelectorAll(".order-card");
  var noResultsMessage = document.getElementById("noResultsMessage");
  var hasResults = false;

  cards.forEach(function(card) {
    var orderId = card.getAttribute("data-order-id");
    var username = card.getAttribute("data-username");
    var address = card.getAttribute("data-address");
    var transfer = card.getAttribute("data-transfer");
    var noResultsMessage = card.querySelector(".no-results-message"); // 查找消息元素

    if (orderId && username && address ) {
      if (orderId.indexOf(filter) > -1 || username.toUpperCase().indexOf(filter) > -1 || address.toUpperCase().indexOf(filter) > -1 || transfer.toUpperCase().indexOf(filter) > -1)  {
        card.style.display = "block"; // 显示卡片
        hasResults = true;
      } else {
        card.style.display = "none"; // 隐藏卡片
      }
    }
  });

  if (!hasResults) {
    noResultsMessage.style.display = "block"; // 显示 "没有结果" 消息
  } else {
    noResultsMessage.style.display = "none"; // 隐藏消息
  }
}
</script>




</body>
</html