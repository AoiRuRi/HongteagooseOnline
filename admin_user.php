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
            <th>LINE管理</th>
            </tr>
            <tr>
            <td><a href="admin_Linebot.php">LINEBOT管理</a></td>
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
$sql = "SELECT Account, Name, Email, Phone, Address, Member_ID FROM users";
$result = $conn->query($sql);

?>
<!-- My Orders content -->
<div class="mt-4">
    <h1>使用者管理</h1>
    <table class="table">
        <thead>
            <tr>
                <th>使用者帳號</th>
                <th>姓名</th>
                <th>信箱</th>
                <th>電話</th>
                <th>地址</th>
                <th>會員ID</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // 迭代查詢結果，並將每行數據添加到表格中
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo '<td data-field="Account">' . $row["Account"] . "</td>";
                echo '<td class="editable" data-field="Name">' . $row["Name"] . "</td>";
                echo '<td class="editable" data-field="Email">' . $row["Email"] . "</td>";
                echo '<td class="editable" data-field="Phone">' . $row["Phone"] . "</td>";
                echo '<td class="editable" data-field="Address">' . $row["Address"] . "</td>";
                echo '<td data-field="Member_ID">' . $row["Member_ID"] . "</td>";
                echo "<td>";
                echo '<button class="edit-btn" data-id="' . $row["Account"] . '">編輯</button>';
                echo ' <button class="delete-btn" data-id="' . $row["Account"] . '">刪除</button>';
                echo ' <button class="save-btn" data-id="' . $row["Account"] . '">保存</button>';
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php
// 關閉資料庫連線
$conn->close();
?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 編輯按鈕點擊事件
    $(document).on("click", ".edit-btn", function() {
        var Accountid = $(this).data("id");
        // 將該行的可編輯字段設為可編輯（添加輸入字段）
        $(this).closest("tr").find(".editable").attr("contenteditable", "true");
    });

    // 保存按鈕點擊事件
    $(document).on("click", ".save-btn", function() {
        var Accountid = $(this).data("id");
        var row = $(this).closest("tr");
        var data = {
            Account: Accountid,
            Name: row.find("[data-field='Name']").text(),
            Email: row.find("[data-field='Email']").text(),
            Phone: row.find("[data-field='Phone']").text(),
            Address: row.find("[data-field='Address']").text(),
        };
        // 使用AJAX將數據提交到後端PHP進行更新
        $.ajax({
            type: "POST",
            url: "php/update_user_data.php", // 更新數據的後端處理文件
            data: data,
            success: function(response) {
                // 在成功回調中處理任何必要的操作
                console.log("資料已更新");
                alert("使用者資料更新成功");
                location.reload(); // 重整頁面
            },
            error: function() {
                console.error("更新資料時出錯");
                alert("使用者資料更新失敗");
                location.reload(); // 重整頁面
            }
        });
        // 將可編輯字段設為不可編輯（移除輸入字段）
        row.find(".editable").removeAttr("contenteditable");
    });


    // 刪除按鈕點擊事件
    $(document).on("click", ".delete-btn", function() {
        var Accountid = $(this).data("id");
        // 使用AJAX將要刪除的資料的識別信息發送到後端
    $.ajax({
        type: "POST",
        url: "php/delete_user_data.php", // 處理刪除操作的後端腳本
        data: { Account: Accountid },
        success: function(response) {
            if (response === "success") {
                // 刪除成功
                console.log("資料已刪除");
                alert("刪除使用者成功");
                location.reload(); // 重整頁面
                // 刪除失敗相關訊息處理
            } else {
                console.error("刪除資料時出錯");
                alert("執行刪除操作時出錯")
                location.reload(); // 重整頁面
            }
        },
        error: function() {
            console.error("執行刪除操作時出錯");
            alert("執行刪除操作時出錯")
            location.reload(); // 重整頁面
        }
    });
});
});
</script>

