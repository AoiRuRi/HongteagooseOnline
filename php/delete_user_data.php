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

// 接收AJAX發送的資料
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Account = $_POST["Account"]; // 從前端獲取要刪除的Account
    // 創建SQL刪除語句
    $sql = "DELETE FROM users WHERE Account = ?";
    
    // 使用準備語句，避免SQL注入攻擊
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $Account);
    
    // 執行SQL刪除語句
    if ($stmt->execute()) {
        // 刪除成功，返回成功的回應
        echo "success";
    } else {
        // 刪除失敗，返回錯誤信息
        echo "刪除資料時出錯: " . $stmt->error;
    }
    
    // 關閉準備語句和資料庫連線
    $stmt->close();
    $conn->close();
} else {
    // 如果不是POST請求，返回錯誤信息
    echo "發生錯誤";
}
?>
