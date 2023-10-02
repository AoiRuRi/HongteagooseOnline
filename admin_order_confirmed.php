
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin.css?version=<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<body>
    <div class="navbar navbar-expand-lg p-3" style="background-color: #fede00">
        <div class = "container">
            <a href="index_nologin.php"><img style="width: 300px;" src="images/logo.png"></a>
        </div>
    </div>
    <div>
    <table id="left">
            <tr>
            <th><a href="#">首頁</a></th>
            </tr>
            <tr>
            <td><a href="admin_carousel.php">輪播圖圖片</a></td>
            </tr>
            <tr>
            <td><a href="admin_news.php">最新消息</a></td>
            </tr>
            <tr>
            <td><a href="admin_popular.php">熱門品項</a></td>
            </tr>
            <tr>
            <th>商品頁</th>
            </tr>
            <tr>
            <td><a href="admin_product.php">商品管理</a></td>
            </tr>
            <tr>
            <th>訂單</th>
            </tr>
            <tr>
            <td><a href="admin_order_nopay.php">未付款</a></td>
            </tr>
            <tr>
            <td><a href="admin_order_confirmed.php">待確認款項</a></td>
            </tr>
            <tr>
            <td><a href="admin_order_havepay.php">待出貨</a></td>
            </tr>
            <tr>
            <td><a href="admin_order_ship.php">已出貨</a></td>
            </tr>
            <tr>
            <th>使用者管理</th>
            </tr>
            <tr>
            <td><a href="admin_user.php">使用者管理</a></td>
            </tr>        
        </table>
    </div>
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

while($row = $result->fetch_assoc()) {
    $orderID = $row["Purchase_OrderID"];
    
    // 檢查訂單編號是否已經讀取過，如果沒有，則將該訂單添加到$orders陣列中
    if (!in_array($orderID, $seenOrderIDs)) {
        $orders[] = $row;
        $seenOrderIDs[] = $orderID; // 將訂單編號添加到已經讀取過的陣列中
    }
}
?>
<!-- My Orders content -->
<div class="mt-4">
    <h1>訂單管理</h1>
    <h1>待確認款項</h1>
    <table class="table" id="ordertable1">
        <thead>
            <tr>
                <th>訂購日期</th>
                <th>訂單編號</th>
                <th>價格</th>
                <th>購買者帳號</th>
                <th>寄送地址</th>
                <th>狀態</th>
                <th>轉帳代碼後五碼</th>
            </tr>
        </thead>
        <tbody>
            <!-- Add your code to fetch and display the order details here -->
            <?php foreach ($orders as $order) : ?>
                <tr data-order-id="<?= $order["Purchase_OrderID"] ?>">
                    <td><?= $order["Date"] ?></td>
                    <td><?= $order["Purchase_OrderID"] ?></td>
                    
                    <td><?= $order["Account"] ?></td>
                    <td><?= $order["Address"] ?></td>
                    <td class="status">
                        <select class="status-select">
                            <option value="未付款" <?= ($order["Status"] == '未付款' ? 'selected' : '') ?>>未付款</option>
                            <option value="待確認款項" <?= ($order["Status"] == '待確認款項' ? 'selected' : '') ?>>待確認款項</option>
                            <option value="待出貨" <?= ($order["Status"] == '待出貨' ? 'selected' : '') ?>>待出貨</option>
                            <option value="已出貨" <?= ($order["Status"] == '已出貨' ? 'selected' : '') ?>>已出貨</option>
                        </select>
                        <button class="status-save-btn">儲存</button>
                    </td>
                    <td class="status-view" style="display:none">
                        <span class="status-text"><?= $order["Status"] ?></span>
                    </td>
                    <td><?= $order["Transfer"] ?></td>
                    <td><button class="toggle-btn">展開/收起</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
// 關閉資料庫連線
$conn->close();
?> 

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
<script>
document.addEventListener('DOMContentLoaded', function() {
  <?php foreach ($orders as $order) : ?>
    const currentOrderID<?php echo $order["Purchase_OrderID"]; ?> = <?php echo json_encode($order["Purchase_OrderID"]); ?>;
    const statusCell<?php echo $order["Purchase_OrderID"]; ?> = $('[data-order-id="<?php echo $order["Purchase_OrderID"]; ?>"]');
    const statusSelect<?php echo $order["Purchase_OrderID"]; ?> = statusCell<?php echo $order["Purchase_OrderID"]; ?>.find('.status-select').val();
    const statusText<?php echo $order["Purchase_OrderID"]; ?> = statusCell<?php echo $order["Purchase_OrderID"]; ?>.find('.status-text');
    const saveButton<?php echo $order["Purchase_OrderID"]; ?> = statusCell<?php echo $order["Purchase_OrderID"]; ?>.find('.status-save-btn');

    // 添加以下 console.log 语句
    console.log('statusSelect<?php echo $order["Purchase_OrderID"]; ?>:', statusSelect<?php echo $order["Purchase_OrderID"]; ?>);
    console.log('statusText<?php echo $order["Purchase_OrderID"]; ?>:', statusText<?php echo $order["Purchase_OrderID"]; ?>);
    console.log('saveButton<?php echo $order["Purchase_OrderID"]; ?>:', saveButton<?php echo $order["Purchase_OrderID"]; ?>);

    saveButton<?php echo $order["Purchase_OrderID"]; ?>.click(function() {
       // 在点击按钮时获取所选选项的值
  const newStatus = statusCell<?php echo $order["Purchase_OrderID"]; ?>.find('.status-select option:selected').val();

      // 在这里添加 AJAX 请求以更新状态到后端
      const orderID = <?php echo json_encode($order["Purchase_OrderID"]); ?>;
      const statusUpdate = newStatus;

      $.ajax({
        type: 'POST',
        url: 'php/order_update_status.php',
        data: { orderID: orderID, status: statusUpdate },
        success: function(response) {
             // 更新成功后，将新状态设置到statusText
  statusText<?php echo $order["Purchase_OrderID"]; ?>.text(newStatus);
          console.log('狀態更新成功');
          location.reload(); // 重整頁面
        },
        error: function() {
          console.error('狀態更新失敗');
        }
      });
    });
  <?php endforeach; ?>
});
</script>


</body>
</html>
