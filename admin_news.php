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
$sql = "SELECT newsID, newsDate, newsContent FROM news";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin.css">
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
            <td><a href="admin_product.php">熱門品項</a></td>
            </tr>
            <tr>
            <th>商品頁</th>
            </tr>
            <tr>
            <td><a href="admin_product.php">商品管理</a></td>
            </tr>
            <tr>
            <th>員工</th>
            </tr>
            <tr>
            <td><a href="admin_employee.html">員工管理</a></td>
            </tr>    
        </table>
    </div>
    <div>
      <table id="news-table">
        <tr>
          <!-- <th>序號</th> -->
          <th>更新日期</th>
          <th>更新內容</th>
          <th>操作</th> 
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td class="newsID-input" style="display: none;"><?php echo $row['newsID']; ?></td>
            <td class="news-newsDate" data-newsID="<?php echo $row['newsID']; ?>"><?php echo $row['newsDate']; ?></td>
            <td class="news-Content" data-newsID="<?php echo $row['newsID']; ?>">
              <?php echo $row['newsContent']; ?>
            </td>
            <td>
              <button class="edit-button" data-newsID="<?php echo $row['newsID']; ?>">編輯</button>
              <button class="save-button" data-newsID="<?php echo $row['newsID']; ?>" style="display: none;">保存</button>
            </td>
          </tr>
        <?php } ?>
      </table>
      <div id="edit-form-container" style="display: none;"></div>

      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script>
        // 編輯按鈕點擊事件
        $(document).on('click', '.edit-button', function() {
            // var newsID = $(this).data('newsID');
            var row = $(this).closest('tr');
          // 獲取隱藏欄位中的 newsID 值
            var hiddenNewsID = row.find('.newsID-input').html();


            // 將欄位內容轉換成可編輯的輸入框
            row.find('.news-newsDate').html('<input type="text" name="newsDate" value="' + row.find('.news-newsDate').text() + '">');
            row.find('.news-Content').html('<input type="text" name="newsContent" value="' + row.find('.news-Content').text() + '">');

            // 設置編輯表單的元素為可編輯狀態
            row.find('input').prop('disabled', false);

            // 切換按鈕為保存按鈕
            $(this).hide();
            row.find('.save-button').show();
        });

        $(document).on('click', '.save-button', function() {
          var newsID = $(this).data('newsID');
          var row = $(this).closest('tr');
          var hiddenNewsID = row.find('.newsID-input').html();
          // 獲取編輯後的欄位內容
          var newsDate = row.find('input[name="newsDate"]').val().trim();
          var newsContent = row.find('input[name="newsContent"]').val().trim();


          // 使用 AJAX 發送 POST 請求到後端處理
          $.ajax({
              url: '../php/news_update.php', // 請根據你的實際情況修改 URL
              method: 'POST',
              data: {
                newsID: hiddenNewsID, // 使用隱藏欄位中的值
                newsDate: row.find('input[name="newsDate"]').val().trim(),
                newsContent: row.find('input[name="newsContent"]').val().trim()
              },
              success: function(response) {
        if (response === "success") {
            // 更新成功
            console.log("資料已成功更新！");
        } else {
            // 更新失敗
            console.log(response); // 顯示錯誤訊息
        }
    },
    error: function(xhr, status, error) {
        // 處理錯誤
        console.log("AJAX 發生錯誤：" + error);
    }
          });

          // 更新表格顯示的欄位內容
          // 更新表格顯示的欄位內容
          row.find('.news-newsDate input').text(newsDate);
          row.find('.news-Content input').text(newsContent);


          // 設置編輯表單的元素為不可編輯狀態
          row.find('input').prop('disabled', true);

          // 切換按鈕為編輯按鈕
          $(this).hide();
          row.find('.edit-button').show();
      });
    </script>
</body>
</html>
