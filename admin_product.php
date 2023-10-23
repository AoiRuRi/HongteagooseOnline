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
<html lang="zh-Hant-Tw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" type="text/css" href="css/main.css?version=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/index.css?version=<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Yusei+Magic&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<body>
<nav>
        <div class="navbar navbar-expand-lg p-3 " style="background-color: #fede00">
            <div class = "container">
                <a href="index_nologin.php"><img style="width: 200px;" src="images/logo.png"></a>
            </div>
        </div>
    </nav>
    <div style="margin: 20px;">
        <div class="row">
            <div class="col-md-2">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action disabled bg-light">首頁</a>
                    <a href="admin_carousel.php" class="list-group-item list-group-item-action">輪播圖圖片</a>
                    <a href="admin_news.php" class="list-group-item list-group-item-action">最新消息</a>
                    <a href="admin_popular.php" class="list-group-item list-group-item-action">熱門品項</a>
                    <div class="list-group-item list-group-item-action disabled bg-light">商品頁</div>
                    <a href="admin_product.php" class="list-group-item list-group-item-action bg-warning">商品管理</a>
                    <div class="list-group-item list-group-item-action disabled bg-light">訂單</div>
                    <a href="admin_order_nopay.php" class="list-group-item list-group-item-action">未付款</a>
                    <a href="admin_order_confirmed.php" class="list-group-item list-group-item-action">待確認款項</a>
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
        <div class="card-header">
            商品管理
        </div>
        <div class="card-body">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                    <div class="card mb-1">
                        <div class="row no-gutters">
                            <div class="col-md-1 d-flex justify-content-center align-items-center">
                                <?php echo $row['Product_ID']; ?>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center align-items-center">
                                <input type="text" name="product_name" class="form-control" value="<?php echo $row['Product_name']; ?>">
                            </div>

                            <div class="col-md-1">
                                <div class="card-body d-flex justify-content-center align-items-center">
                                    <input type="hidden" name="product_id" value="<?php echo $row['Product_ID']; ?>">
                                    <img id="product-image-<?php echo $row['Product_ID']; ?>" class="card-img mx-auto" 
                                    src="<?php echo $row['Product_image']; ?>" alt="<?php echo $row['Product_name']; ?>" style="max-height: 50px; width: auto; object-fit: contain;">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="card-body d-flex justify-content-center align-items-center mt-2">
                                    <input type="file" name="image" data-product-id="<?php echo $row['Product_ID']; ?>">
                                </div>
                            </div>
                            <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <textarea class="form-control" name="product_description"><?php echo $row['Product_description']; ?></textarea>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center align-items-center">
                                <input type="text" name="product_price" class="form-control" value="<?php echo $row['Product_price']; ?>">
                            </div>
                            <div class="col-md-2">
                                <div class="card-body d-flex justify-content-center align-items-center mt-2">
                                    <button type="submit" class="btn btn-warning save-button">保存</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</div>

      <div id="edit-form-container" style="display: none;"></div>

      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   
    <script>

    // 添加一個事件監聽器以監聽文件輸入的變化
$('input[name="image"]').on('change', function(e) {
    var input = $(this);
    var productID = input.data('product-id');
    var imageElement = $('#product-image-' + productID);
    var newImage = input[0].files[0];

    if (newImage) {
        var reader = new FileReader();
        reader.onload = function(e) {
            imageElement.attr('src', e.target.result);
        };
        reader.readAsDataURL(newImage);
    }
});
    // 保存按鈕點擊事件
$(document).on('click', '.save-button', function() {
    var row = $(this).closest('.card');
    var productID = row.find('input[name="product_id"]').val().trim();
    var productName = row.find('input[name="product_name"]').val().trim();
    var productDescription = row.find('textarea[name="product_description"]').val().trim();
    var productPrice = row.find('input[name="product_price"]').val().trim();

    // 構建一個 FormData 對象來處理文件上傳
    var formData = new FormData();
    formData.append('product_id', productID);
    formData.append('product_name', productName);
    formData.append('product_description', productDescription);
    formData.append('product_price', productPrice);
    

    // 獲取新上傳的圖片文件
    var newImage = row.find('input[name="image"]')[0].files[0];
    if (newImage) {
        formData.append('image', newImage);
    }

    // 使用 AJAX 請求發送數據到服務器進行更新
    $.ajax({
        url: '../php/update.php', // 根據你的實際情況修改 URL
        method: 'POST',
        data: formData,
        processData: false, // 不要處理數據
        contentType: false, // 不要設置內容類型
        success: function(response) {
            if (response === "success") 
                // 更新成功
                console.log(response);
                alert("資料更新成功");
        },
        error: function(xhr, status, error) {
            // 處理錯誤
            console.log("AJAX 發生錯誤：" + error);
            alert("AJAX 發生錯誤，請按F12查看詳細信息");
        }
       
    });
    
    // 設置編輯表單元素為不可編輯狀態
    row.find('input').prop('disabled', true);

    // 切換按鈕為編輯按鈕
    $(this).hide();
    row.find('.edit-button').show();

});


</script>

</body>
</html>