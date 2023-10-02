<?php
// 配置Line登录信息
$CLIENT_ID = '2000736711';
$CLIENT_SECRET = '0b8dd34c3c9d089ef9afacf3d7a2c9ae';
$REDIRECT_URI = 'https://hongteagoose.lionfree.net/test.php';

// 检查是否有回调代码
if (isset($_GET['code'])) {
    // 获取回调代码
    $code = $_GET['code'];

    // 使用回调代码来获取访问令牌
    $url = 'https://api.line.me/oauth2/v2.1/token';
    $data = array(
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => $REDIRECT_URI,
        'client_id' => $CLIENT_ID,
        'client_secret' => $CLIENT_SECRET,
    );

    $options = array(
        'http' => array(
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'method' => 'POST',
            'content' => http_build_query($data),
        ),
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result, true);

    if (isset($response['access_token'])) {
        $access_token = $response['access_token'];

        // 使用访问令牌来获取用户ID
        $url = 'https://api.line.me/v2/profile';
        $options = array(
            'http' => array(
                'header' => "Authorization: Bearer $access_token",
                'method' => 'GET',
            ),
        );

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $profile = json_decode($result, true);

        if (isset($profile['userId'])) {
            $line = $profile['userId'];
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Line登录示例</title>
    <script src="https://static.line-scdn.net/liff/edge/2.13/sdk.js"></script>
</head>
<body>
    <div class="form-row">
        <label for="line" class="col-sm col-form-label">LINE:</label>
        <div class="row">
            <div class="col-sm-5">
                <input type="text" class="form-control" id="line" name="line" required value="<?php echo htmlspecialchars($line); ?>" readonly>
            </div>
            <div class="col-sm-5">
                <button class="btn btn-success" type="button" id="login-button">綁定LINE帳號</button>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            liff.init({ liffId: '2000736711-n70zajGR' }, () => {}, err => console.error(err.code, err.message));
        };

        document.getElementById('login-button').addEventListener('click', function() {
            const state = Math.random().toString(36).substring(7);
            const lineAuthUrl = `https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=<?php echo $CLIENT_ID; ?>&redirect_uri=${encodeURIComponent('<?php echo $REDIRECT_URI; ?>')}&state=${state}&scope=openid%20profile&nonce=${state}`;
            window.location.href = lineAuthUrl;
        });
    </script>
</body>
</html>
