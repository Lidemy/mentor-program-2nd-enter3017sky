<?php  // 登出，清空 cookie
setcookie("user_id", '');
session_destroy();
header('Location: week5_login.php');
