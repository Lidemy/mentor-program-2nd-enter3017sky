<?php
    // 登入的提示訊息都做在同一個頁面上了，這個就不需要了
    // 使用者在 register.php 輸入的 username 
    // 用這個 $_POST['username']可以取得資料
    session_start();
    require_once('./conn.php');
    require_once('./utils.php');
    
    if (
        isset($_POST['username']) && 
        isset($_POST['password']) && 
        isset($_POST['nickname']) &&
        !empty($_POST['username'])&& 
        !empty($_POST['password'])&&
        !empty($_POST['nickname'])
    ){
        $nickname = $_POST['nickname'];
        $username = $_POST['username'];
        // 註冊時，使用者輸入的密碼 hash 後存入資料庫。
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO enter3017sky_user(nickname, username, password) VALUES(?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nickname, $username, $password);

        if($stmt->execute()) {
            // setToken($conn, $username);
            $_SESSION['username'] = $username;

            $_SESSION['nickname'] = $nickname;

            printMessage('註冊成功', './index.php');
        } else {
            // printMessage($conn->error, './register.php');
            printMessage('使用者帳號已經存在了~', './register.php');
        }
    } else {
        printMessage('帳號或密碼錯誤!!', './register.php');
    }
?>

