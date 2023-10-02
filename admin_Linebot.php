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

<head>
    <title>管理頁面</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"] {
            padding: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"] {
            padding: 8px 16px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }

        ul {
            list-style: none;
            padding-left: 0;
        }

        li {
            margin-bottom: 5px;
        }

    </style>
</head>
<body id=right>
    <h2>管理者</h2>
    <h2>新增ID</h2>
    <form action="linebot/add.php" method="post">
        <label for="ID">ID：</label>
        <input type="text" id="ID" name="ID"><br>
        <input type="submit" value="新增">
    </form>
    <h2>刪除ID</h2>
    <form action="linebot/delete.php" method="post">
        <label for="ID">ID：</label>
        <input type="text" id="ID" name="ID"><br>
        <input type="submit" value="刪除">
    </form>
    
    <h2>管理職現有的ID</h2>
    
    <?php
      $mysqli = new mysqli("192.168.2.200", "hongteag_linebot", "1234", "hongteag_linebot");

      // 檢查連線是否成功
      if ($mysqli->connect_error) {
          die("資料庫連接失敗: " . $mysqli->connect_error);
      }

      $sql = "SELECT display_name,user_id FROM linedata WHERE level = 2";
      $result = $mysqli->query($sql);

      // 檢查查詢是否成功執行
      if ($result === false) {
          die("查詢失敗: " . $mysqli->error);
      }

      if ($result->num_rows > 0) {
          echo "<ul>";
          while ($row = $result->fetch_assoc()) {
              echo "<li>" . $row["display_name"] ."<br>". $row["user_id"]. "</li>";
          }
          echo "</ul>";
      } else {
          echo "<p>目前沒有資料</p>";
      }

      $result->close();
      $mysqli->close();
    ?>

    
    <h2>綁定個人化服務的用戶</h2>
  
    <?php
    $mysqli = new mysqli("192.168.2.200", "hongteag_linebot", "1234", "hongteag_linebot");
	
    // 檢查連接是否成功
    if ($mysqli->connect_error) {
        die("資料庫連接失敗: " . $mysqli->connect_error);
    }

    $sql = "SELECT display_name,user_id FROM linedata";
    $result = $mysqli->query($sql);

    // 檢查查詢是否成功執行
    if ($result === false) {
        die("查詢失敗: " . $mysqli->error);
    }
  	$count = $result->num_rows;

	echo "<p>目前共有 " . $count . " 人</p>";

    if ($result->num_rows > 0) {
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            if (!empty($row["display_name"]) && !empty($row["user_id"])) {
                echo "<li>" . $row["display_name"] ."<br>". $row["user_id"]. "</li>";
            }
        }
        echo "</ul>";
        echo "<br><br>";
    } else {
        echo "<p>目前沒有資料</p>";
}


    $result->close();
    $mysqli->close();
    ?>
