<?php
session_start();

// 清除會話資料
session_unset();
session_destroy();

// 重新導向到登出後的頁面
header("Location: ../index_nologin.php");
exit();
?>
