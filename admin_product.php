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
$sql = "SELECT Product_ID, Product_name, Product_image, Product_description, Product_price FROM product";
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
    <div>
  <table id="product-table">
    <tr>
      <th>產品編號</th>
      <th>產品名稱</th>
      <th>產品圖片</th>
      <th>產品說明</th>
      <th>產品價格</th>
      <th>操作</th> 
    </tr>
      <td>
      <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['Product_ID']; ?></td>
                    <td class="product-name" data-product-id="<?php echo $row['Product_ID']; ?>">
                        <?php echo $row['Product_name']; ?>
                    </td>
                    <td class="product-image" data-product-id="<?php echo $row['Product_ID']; ?>">
                        <img src="<?php echo $row['Product_image']; ?>" alt="">
                    </td>
                    <td class="product-description" data-product-id="<?php echo $row['Product_ID']; ?>">
                        <?php echo $row['Product_description']; ?>
                    </td>
                    <td class="product-price" data-product-id="<?php echo $row['Product_ID']; ?>">
                        <?php echo $row['Product_price']; ?>
                    </td>
                    <td>
                        <button class="edit-button" data-product-id="<?php echo $row['Product_ID']; ?>">編輯</button>
                        <button class="save-button" data-product-id="<?php echo $row['Product_ID']; ?>" style="display: none;">保存</button>
                    </td>
                </tr>
            <?php } ?>
      </table>
      <div id="edit-form-container" style="display: none;"></div>

      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // 編輯按鈕點擊事件
        $(document).on('click', '.edit-button', function() {
            var productID = $(this).data('product-id');
            var row = $(this).closest('tr');

            // 將欄位內容轉換成可編輯的輸入框
            row.find('.product-name').html('<input type="text" name="product_name" value="' + row.find('.product-name').text() + '">');
            row.find('.product-image').html('<input type="text" name="product_image" value="' + row.find('.product-image img').attr('src') + '">');
            row.find('.product-description').html('<input type="text" name="product_description" value="' + row.find('.product-description').text() + '">');
            row.find('.product-price').html('<input type="text" name="product_price" value="' + row.find('.product-price').text() + '">');

            // 設置編輯表單的元素為可編輯狀態
            row.find('input').prop('disabled', false);

            // 切換按鈕為保存按鈕
            $(this).hide();
            row.find('.save-button').show();
        });

        $(document).on('click', '.save-button', function() {
          var productID = $(this).data('product-id');
          var row = $(this).closest('tr');

          // 獲取編輯後的欄位內容
          var productName = row.find('input[name="product_name"]').val().trim();
          var productImage = row.find('input[name="product_image"]').val().trim();
          var productDescription = row.find('input[name="product_description"]').val().trim();
          var productPrice = row.find('input[name="product_price"]').val().trim();

          // 使用 AJAX 發送 POST 請求到後端處理
          $.ajax({
              url: '../php/update.php', // 請根據你的實際情況修改 URL
              method: 'POST',
              data: {
                  productID: productID,
                  productName: productName,
                  productImage: productImage,
                  productDescription: productDescription,
                  productPrice: productPrice
              },
              success: function(response) {
                  // 更新成功後的處理
                  // ...
              },
              error: function(xhr, status, error) {
                  // 處理錯誤
                  // ...
              }
          });

          // 更新表格顯示的欄位內容
          row.find('.product-name').text(productName);
          row.find('.product-image').html('<img src="' + productImage + '" alt="">');
          row.find('.product-description').text(productDescription);
          row.find('.product-price').text(productPrice);

          // 設置編輯表單的元素為不可編輯狀態
          row.find('input').prop('disabled', true);

          // 切換按鈕為編輯按鈕
          $(this).hide();
          row.find('.edit-button').show();
      });
    </script>
</body>
</html>