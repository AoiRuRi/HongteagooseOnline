<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 獲取表單數據
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // 郵件收件者的電子郵件地址
    $to = "htgtest001@gmail.com"; // 將其替換為實際的收件者電子郵件地址

    // 郵件主題
    $subject = "表單提交";

    // 郵件內容
    $message_body = "姓名: $name\n";
    $message_body .= "電話: $phone\n";
    $message_body .= "信箱: $email\n";
    $message_body .= "意見: $message\n";

    // 郵件標頭
    $headers = "From: $email";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    require 'vendor/autoload.php'; // 請根據您的實際設置引入 PHPMailer
    
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->Username = 'htgtest001@gmail.com'; // 您的 Gmail 電子郵件地址
    $mail->Password = 'veal onmr pngk fbdt'; // 您的 Gmail 應用程式密碼
    
    $mail->setFrom('htgtest001@gmail.com', '您的名字');
    $mail->addAddress('htgtest001@gmail.com', '收件人名字');
    $mail->Subject = '表單提交';
    // 郵件內容
    $message_body = "姓名: $name\n";
    $message_body .= "電話: $phone\n";
    $message_body .= "信箱: $email\n";
    $message_body .= "意見: $message\n";
    
    if ($mail->send()) {
        echo '郵件已成功發送！';
    } else {
        echo '郵件發送失敗。錯誤訊息：' . $mail->ErrorInfo;
    }
    
}
?>
