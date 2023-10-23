<!DOCTYPE html>
<html lang="zh-Hant-Tw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  
    <link href="images/logoicon.ico" rel="shortcut icon"/>  
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
        $host = 'localhost'; // 或 '127.0.0.1'
        $user = 'root'; // 使用者帳號
        $password = ''; // 使用者密碼
        $dbname = 'hongteag_goose'; // 資料庫名稱

        // 建立資料庫連線
        $conn = new mysqli($host, $user, $password, $dbname);

        // 檢查連線是否成功
        if ($conn->connect_error) {
            die("連線失敗: " . $conn->connect_error);
        }

        // 執行 SQL 查詢語句
        $sql = "SELECT newsID, newsDate, newsContent FROM news";
        $result = $conn->query($sql);
    ?>

    <div style="margin: 20px;">
        <div class="row">
            <div class="col-md-2">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action disabled bg-light">首頁</a>
                    <a href="admin_carousel.php" class="list-group-item list-group-item-action">輪播圖圖片</a>
                    <a href="admin_news.php" class="list-group-item list-group-item-action bg-warning">最新消息</a>
                    <a href="admin_popular.php" class="list-group-item list-group-item-action">熱門品項</a>
                    <div class="list-group-item list-group-item-action disabled bg-light">商品頁</div>
                    <a href="admin_product.php" class="list-group-item list-group-item-action">商品管理</a>
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
                        最新消息管理
                    </div>
                    <div class="card-body">
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <div class="card mt-2">
                                <div class="row no-gutters"> 
                                    <div class="col-md-3 d-flex justify-content-center">
                                        <div class="card-body mt-2">
                                            <input class="news-newsDate form-control" type="text" value="<?php echo $row['newsDate']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-7 d-flex justify-content-center">
                                        <div class="card-body mt-2">
                                            <textarea class="news-Content form-control"><?php echo $row['newsContent']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card-body mt-2">
                                            <button class="btn btn-warning save-button" data-newsID="<?php echo $row['newsID']; ?>">儲存</button>
                                            <input type="hidden" class="newsID-input" value="<?php echo $row['newsID']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div id="edit-form-container" style="display: none;"></div>
                    </div>

                </div>
            </div>
    </div>

    

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('click', '.save-button', function() {
    var newsID = $(this).data('newsID');
    var row = $(this).closest('.card');
    var hiddenNewsID = row.find('.newsID-input').val();
    var newsDate = row.find('.news-newsDate').val().trim();
    var newsContent = row.find('.news-Content').val().trim();

    $.ajax({
        url: '../php/news_update.php',
        method: 'POST',
        data: {
            newsID: hiddenNewsID,
            newsDate: newsDate,
            newsContent: newsContent
        },
        success: function(response) {
            if (response === "success") 
                // 更新成功
                console.log("資料已成功更新！");
                alert("資料更新成功");
                location.reload();
            
        },
        error: function(xhr, status, error) {
            // 處理錯誤
            console.log("AJAX 發生錯誤：" + error);
        }
    });

    // 设置输入框为不可编辑状态
    row.find('.form-control').prop('disabled', true);

    // 隐藏保存按钮，显示编辑按钮
    row.find('.save-button').hide();
    row.find('.edit-button').show();
});

    </script>
</body>
</html>
