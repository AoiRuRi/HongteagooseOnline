<?php
// 設定資料庫連線參數
$host = '192.168.2.200'; // 或 '127.0.0.1'
$user = 'hongteag_goose'; // 使用者帳號
$password = 'ab7777xy'; // 使用者密碼
$dbname = 'hongteag_goose'; // 資料庫名稱
$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset("utf8");
// 檢查連線是否成功
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}
// 從GET請求中獲取訂單編號
$order_id = $_GET['order_id'];

// 在子表格中擷取資料
$subSql = "SELECT ProductName, Purchase_Quantity, Purchase_Price FROM purchase_order WHERE Purchase_OrderID = ?";
$subStmt = $conn->prepare($subSql);

if ($subStmt) {
    $subStmt->bind_param("i", $order_id); // 使用訂單編號關聯子表格和母表格
    $subStmt->execute();
    $subResult = $subStmt->get_result();

    
    
    if ($subResult->num_rows > 0) {
        $subTotalPrice = 0; // 用於計算子表格的總價格

        echo '<table class="sub-table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>購買商品</th>';
        echo '<th>數量</th>';
        echo '<th>價格</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        while ($subRow = $subResult->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $subRow["ProductName"] . '</td>';
            echo '<td>' . $subRow["Purchase_Quantity"] . '</td>';
            echo '<td>' . $subRow["Purchase_Price"] . '</td>';
            echo '</tr>';
            // 在子表格處理過程中，將子表格中的每列 Purchase_Price 加入子表格總價格
            $subTotalPrice += $subRow["Purchase_Price"];
        }

        
        
        echo '</tbody>';
        echo '</table>';
         // 在子表格處理結束後，將子表格的總價格回傳到前端
         echo '<script>';
         echo 'const totalPriceCell = document.createElement("td");';
         echo 'totalPriceCell.textContent = "Total Price: $' . $subTotalPrice . '";';
         echo 'const rows = document.querySelectorAll("tbody tr");';
         echo 'rows.forEach(row => {';
         echo 'row.appendChild(totalPriceCell.cloneNode(true));';
         echo '});';
         echo '</script>';
    } else {
        echo 'No sub-table data found';
    }

    $subStmt->close();
} else {
    echo 'Sub-query preparation failed';
}
?>
