<?php
// 設定資料庫連線參數
$host = '192.168.2.200'; // 或 '127.0.0.1'
$user = 'hongteag_goose'; // 使用者帳號
$password = 'ab7777xy'; // 使用者密碼
$dbname = 'hongteag_goose'; // 資料庫名稱
// 建立與 MySQL 資料庫的連線
$mysqli = new mysqli($host, $user, $password, $dbname);
$mysqli->set_charset("utf8");
// 檢查連線是否成功
if ($mysqli->connect_errno) {
    die('連線失敗: ' . $mysqli->connect_error);
}

$username = ""; // 初始化使用者名稱
$isLoggedIn = false; // 初始化登入狀態

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"]; // 從表單中獲取操作類型

    if ($action === "login") {
        $account = $_POST["account"];
        $password = $_POST["password"];

        // 登入操作，進行必要的驗證和處理
        if (empty($account) || empty($password)) {
            echo "請填寫所有必填字段！";
        } else {
            // 執行登入操作
            $query = "SELECT * FROM users WHERE Account = ?";//參數化運算
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("s", $account);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                // 使用者存在，進行密碼比對
                $row = $result->fetch_assoc();
                $hashedPassword = $row['Password'];//哈希運算

                if (password_verify($password, $hashedPassword)) {
                    // 登入成功
                    session_start();
                    $_SESSION['isLoggedIn'] = true;
                    $_SESSION['username'] = $row['Name']; // 存儲使用者名稱
                    $_SESSION['account'] = $row['Account']; // 存儲使用者名稱
                    $isLoggedIn = true; // 設置登入狀態為 true
                    echo '<script>alert("登入成功！"); window.location.href = "../orders.php";</script>'; // 重導向到首頁
                    exit();
                } else {
                    // 登入失敗
                    echo '<script>alert("帳號或密碼錯誤！");</script>';
                }
            } else {
                // 使用者不存在
                echo '<script>alert("帳號或密碼錯誤！");</script>';
            }

            $stmt->close();
        }
    }
}

// 關閉連線
$mysqli->close();
?>
