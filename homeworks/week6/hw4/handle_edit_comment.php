<?php
    include_once('./check_login.php');
    require_once('./conn.php');
    require_once('./utils.php');

    if (
        isset($_POST['content']) && 
        !empty($_POST['content'])
    ){
        $content = $_POST['content'];
        $id = $_POST['id'];
        // $username = $_COOKIE['username'];

            // 新增留言
        $sql = "UPDATE enter3017sky_comments
                SET content = ?
                WHERE id = ?
                AND username = ?"; // 判斷條件，是使用者才可編輯
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sis", $content, $id , $user);
        if ($stmt->execute()) {
            // server redirect ，PHP的重新導向
            header('location:./index.php');
        } else {
        // $_SERVER['HTTP_REFERER'] 導回原本的地方
            printMessage($conn->error, $_SERVER['HTTP_REFERER']);
        }
    } else {
        printMessage('請輸入內容!!', $_SERVER['HTTP_REFERER']);
    }
?>