<!DOCTYPE html>
<html lang="zh-Hant-Tw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  
    <link href="images/logoicon.ico" rel="shortcut icon"/>  
    <link rel="stylesheet" href="css/admin.css">
    <!-- <link rel="stylesheet" type="text/css" href="css/main.css?version=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/index.css?version=<?php echo time(); ?>"> -->
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/index.css" />
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
                <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button> -->

            <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
                <!-- <ul class="navbar-nav ms-auto">
                    <li class="nav-item">管理者設定頁面</li> -->
                    <!-- <li class="nav-item"><a href="about_nologin.php" class="text-black">關於我們</a></li> -->
                    <!-- <li><a href="#">商品總覽</a></li> -->
                    <!-- <li class="nav-item"><a href="shoppage.php" class="text-black">線上訂購</a></li>
                    <li class="nav-item"><a href="common_quest_nologin.php" class="text-black">常見問題</a></li>
                    <li class="nav-item"><a href="contact_nologin.php" class="text-black">聯絡我們</a></li> -->
                <!-- </ul> -->
            <!-- </div> -->
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
                    <a href="admin_product.php" class="list-group-item list-group-item-action">商品管理</a>
                    <div class="list-group-item list-group-item-action disabled bg-light">訂單</div>
                    <a href="admin_order_nopay.php" class="list-group-item list-group-item-action">未付款</a>
                    <a href="admin_order_confirmed.php" class="list-group-item list-group-item-action">待確認款項</a>
                    <a href="admin_order_havepay.php" class="list-group-item list-group-item-action">待出貨</a>
                    <a href="admin_order_ship.php" class="list-group-item list-group-item-action">已出貨</a>
                    <div class="list-group-item list-group-item-action disabled bg-light">使用者管理</div>
                    <a href="admin_user.php" class="list-group-item list-group-item-action bg-warning">使用者管理</a>
                    <div class="list-group-item list-group-item-action disabled bg-light">LINE官方帳號</div>
                    <a href="admin_linebot_admin.php" class="list-group-item list-group-item-action"><i class="fab fa-line"></i> 管理者管理</a>
                    <a href="admin_linebot_user.php" class="list-group-item list-group-item-action"><i class="fab fa-line"></i> 使用者管理</a>
                </div>
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
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        使用者管理
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php
                            // 假设 $result 包含从数据库检索的使用者资讯
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="row-2">                                             
                                                    <div class="col-md"><strong>使用者帳號</strong>: 
                                                        <span class="editable" contenteditable="false"><?php echo $row["Account"]; ?></span>
                                                    </div>
                                                    <div class="col-md"><strong>姓名</strong>: 
                                                        <span class="editable" contenteditable="false" data-field="Name"><?php echo $row["Name"]; ?></span>
                                                    </div>
                                                    <div class="col-md"><strong>信箱</strong>: 
                                                        <span class="editable" contenteditable="false" data-field="Email"><?php echo $row["Email"]; ?></span>
                                                    </div>
                                                    <div class="col-md"><strong>電話</strong>: 
                                                        <span class="editable" contenteditable="false" data-field="Phone"><?php echo $row["Phone"]; ?></span>
                                                    </div>
                                                    <div class="col-md"><strong>地址</strong>: 
                                                        <span class="editable" contenteditable="false" data-field="Address"><?php echo $row["Address"]; ?></span>
                                                    </div>
                                                <div class="col-md">
                                                    <button class="edit-btn btn btn-primary" data-id="<?php echo $row["Account"]; ?>">編輯</button>
                                                    <button class="delete-btn btn btn-danger" data-id="<?php echo $row["Account"]; ?>">刪除</button>
                                                    <button class="save-btn btn btn-success" data-id="<?php echo $row["Account"]; ?>">保存</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php 
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
// 關閉資料庫連線
$conn->close();
?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 編輯按鈕點擊事件
    $(document).on("click", ".edit-btn", function() {
        // 找到最近的包含可编辑字段的父元素
        var editableParent = $(this).closest(".row-2");
        // 在找到的父元素中查找带有 ".editable" 类的元素
        var editableElements = editableParent.find(".editable");
        // 将找到的可编辑元素的 contenteditable 属性设置为 "true"
        editableElements.attr("contenteditable", "true");
    });

    // 保存按鈕點擊事件
    $(document).on("click", ".save-btn", function() {
        var Accountid = $(this).data("id");
        var row = $(this).closest(".row-2");
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




</body>
</html>
