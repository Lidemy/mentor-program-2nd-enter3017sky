<?php
    session_start(); // 1.可以從 cookie 拿到 PHPSESSID
    include_once('./conn.php');
    include_once('./utils.php');

    // 2. 拿 PHPSESSID 去查
    if (isset($_SESSION['username'])) {
        $user = $_SESSION['username'];
        $nick = $_SESSION['nickname'];
    }

    // 從 $_SESSION['nickname'] 拿資料給 $nickname 這個變數
    // $nickname = $_SESSION['nickname'];




    // $user = getUserByToken($conn, $_COOKIE['token']);


    // if(isset($_COOKIE['token']) && !empty($_COOKIE['token'])) {
    //     $token = $_COOKIE['token'];
    //     // $sql = "SELECT * FROM enter3017sky_certificates WHERE token = '$token'
    //     // ";

    //         // 驗證 token 也把 nickname 撈出來用
    //     $sql = "SELECT c.username, c.token, u.nickname
    //     FROM enter3017sky_certificates AS c
    //     LEFT JOIN enter3017sky_user AS u
    //     ON c.username = u.username
    //     WHERE token = '$token'";

    //     $result = $conn->query($sql);
    //     if(!$result || $result->num_rows <= 0){
    //         $user = null;
    //     } else {
    //         $row = $result->fetch_assoc();
    //         $user = $row['username'];
    //         $nick = $row['nickname'];
    //     }
    // } else {
    //     $user = null;
    // }
?>