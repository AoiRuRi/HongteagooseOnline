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

// 檢查查詢結果是否有資料
if ($result->num_rows > 0) {
    echo '<div id="table-container">';
    echo '<table id="product-table">';
    echo '<tr>';
    echo '<th>產品編號</th>';
    echo '<th>產品名稱</th>';
    echo '<th>產品圖片</th>';
    echo '<th>產品說明</th>';
    echo '<th>產品價格</th>';
    echo '<th id="product-add-button-th"><span id="product-add-button" class="button add-button">增加</span></th>';
    echo '<th><input type="text" id="searchInput" class="form-control" placeholder="搜尋產名或產編">';
    echo '<button id="searchbutton" class="btn btn-primary" onclick="searchOrders()">搜尋</button></th>';
    echo '<div id="noResultsMessage" style="display: none;">查無此產品</div>';
    echo '</tr>';

    // 逐列讀取資料
    while ($row = $result->fetch_assoc()) {
        $productID = $row["Product_ID"];
        $productName = $row["Product_name"];
        $productImage = $row["Product_image"];
        $productDescription = $row["Product_description"];
        $productPrice = $row["Product_price"];

        echo '<tr>';
        echo '<td>' . $productID . '</td>';
        echo '<td>' . $productName . '</td>';
        echo '<td><img class="commoditypic" src="' . $productImage . '" alt="pic"></td>';
        echo '<td>' . $productDescription . '</td>';
        echo '<td>' . $productPrice . '</td>';
        echo '<td>';
        echo '<span id="product-edit-image-button' . $productID . '" class="product-edit-image-button">更換圖片</span>';
        echo '<span id="product-edit-button' . $productID . '" class="product-edit-button">編輯</span>';
        echo '<span id="product-delete-button' . $productID . '" class="product-delete-button">刪除</span>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</table>';
    echo '</div>';
} else {
    echo "沒有找到相應的資料";
}

// 關閉資料庫連線
$conn->close();
?>