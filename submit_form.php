<?php
// 取得表單提交的資料
$account = $_POST["account"];
$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$lineName = $_POST["lineName"];
$line = $_POST["line"];
$address = $_POST["address"];
$password = $_POST["password"];
// 設定資料庫連線參數
$host = '192.168.2.200'; // 或 '127.0.0.1'
$user = 'hongteag_goose'; // 使用者帳號
$dbpassword = 'ab7777xy'; // 使用者密碼
$dbname = 'hongteag_goose'; // 資料庫名稱

$mysqli = new mysqli($host, $user, $dbpassword, $dbname);
$mysqli->set_charset("utf8");
// 檢查連線是否成功
if ($mysqli->connect_errno) {
    die('連線失敗: ' . $mysqli->connect_error);
}

// 先檢查帳號是否已存在
$checkQuery = "SELECT COUNT(*) FROM users WHERE Account = ?";
$checkParams = ["s", &$account];

// 檢查Line_ID是否存在並且不為空
if (!empty($line)) {
    $checkQuery .= " OR Line_ID = ?";
    $checkParams[0] .= "s"; // 添加一個s，表示Line_ID是一個字符串
    $checkParams[] = &$line; // 添加Line_ID到參數數組
}

$checkStmt = $mysqli->prepare($checkQuery);

// 將參數動態綁定到語句
call_user_func_array([$checkStmt, 'bind_param'], $checkParams);
$checkStmt->execute();
$checkStmt->bind_result($count);
$checkStmt->fetch();
$checkStmt->close();

// 如果帳號已存在，顯示提示訊息
if ($count > 0) {
    echo "<script>alert('此帳號已有人註冊！'); history.go(-1);</script>";
    exit();
}

// 建立預備語句 (Prepared Statement) 插入資料
$query = "INSERT INTO users (Account, Name, Email, Phone, Line_ID , Address, Password) VALUES (?, ?, ? ,? , ?, ?, ?)";
$stmt = $mysqli->prepare($query);

// 對密碼進行哈希運算
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// 綁定參數並執行預備語句
$stmt->bind_param("sssssss", $account, $name, $email, $phone, $line, $address, $hashedPassword);
$stmt->execute();



// 檢查是否成功插入資料
if ($stmt->affected_rows > 0) {
    $conn = new mysqli("192.168.2.200", "hongteag_linebot", "1234", "hongteag_linebot");
    // 檢查連線是否成功
    if ($conn->connect_error) {
        die("連線失敗: " . $conn->connect_error);
    }
    if (!empty($lineName) && !empty($line)) {
        $sql = "INSERT INTO linedata (display_name, user_id) VALUES ('$lineName', '$line')";
        if ($conn->query($sql) === TRUE) {
            $file="register";
            header("Location: https://hongteagoose.lionfree.net/linebot/automenu.php?ID=$line&file=register");
            exit();    
        } else {
            echo '<script>alert("註冊成功！"); 
            window.location.href = "https://hongteagoose.lionfree.net/index_nologin.php";</script>';
            exit();
        }
    }
} else {
    echo '<script>alert("註冊失敗！"); history.go(-1);</script>';
}

// 關閉連線和預備語句
$stmt->close();
$mysqli->close();

?>
