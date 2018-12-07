<?php
    include_once('./check_login.php');
    require_once('./conn.php');
    require_once('./utils.php');

    if (
        isset($_POST['content']) && 
        !empty($_POST['content'])
    ){
        $content = $_POST['content'];
        $parent_id = $_POST['parent_id'];
        // $username = $_COOKIE['username'];

            // 新增留言
        $sql = "INSERT INTO enter3017sky_comments(username, content, parent_id) VALUES(?, ?, ?)";
        /* $parent_id 是數字，所以不用引號框起來 */

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $user, $content, $parent_id);

        if ($stmt->execute()) {
            // server redirect ，PHP的重新導向
            header('location:./index.php');
        } else {
            // JavaScript 的重新導向
            printMessage($conn->error, './index.php');
        }
    } else {
        printMessage('請輸入內容!!', './index.php');
    }



?>