<?php
session_start();

require './inc/conn.php';
require './inc/utils.php';

/** 判斷是否有提交，再判斷提交的方式去執行不同的操作 */
if(isset($_POST['submit'])) {
    $submit = $_POST['submit'];

    /** 註冊 */
    if($submit === 'register') {

        if(!empty($_POST['username']) 
        && !empty($_POST['password']) 
        && !empty($_POST['email'])) {
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $email = $_POST['email'];

            $query = "INSERT INTO blog_user(username, password, email)VALUES(?, ?, ?)";
            $statement = $pdo->prepare($query);
            // $statement->bindParam(1, $username,PDO::PARAM_STR);
            // $statement->bindParam(2, $password,PDO::PARAM_STR);
            // $statement->bindParam(3, $email,PDO::PARAM_STR);

            // $result = $statement->execute([$username, $password, $email]);
            // $result = $statement->rowCount();

            /** username 是 UNIQUE，當重複註冊的時候 MySQL 會跳錯誤訊息，所以要用 try/catch 才可以顯示要給使用者的訊息。 */
            try {
                $statement->execute([$username, $password, $email]);
                $result = $statement->rowCount();
                if($result) {
                    $_SESSION['username'] = $username;
                    // $token = $_COOKIE['PHPSESID'];
                    // setcookie($user, $_SESSION['username'], time()+3600*24*7, '/blog');
                    printMessage('註冊成功！', 'index.php');
                } else {
                    printMessage('註冊失敗');
                }
            } catch (\Throwable $th) {
                printMessage('Username 已存在！');
                // echo $pdo->errorInfo();
            }

        } else {
            echo "empty data";
        }

    /** 登入 */
    } else if($submit === 'login') {
        if(!empty($_POST['username']) && !empty($_POST['password'])) {

            $username = $_POST['username'];
            $password = $_POST['password'];

            // password_hash() 每次的結果都不一樣? 以下不會成功
            // $query = "SELECT username, password FROM blog_user WHERE username = ? AND password = ?";

            $query = "SELECT username, password FROM blog_user WHERE username = ?";
            $statement = $pdo->prepare($query);
            $statement->execute([$username]);
            $result = $statement->rowCount();

            if($result) { // 如果有找到使用者資料的話，撈出來並且核對密碼
                $row = $statement->fetch();
                if (password_verify($password, $row['password'])) {
                    $_SESSION['username'] = $username;
                    // setcookie( , , '/blog/',time()+3600*24*30);
                    printMessage('登入成功', 'index.php');
                } else {
                    // username 正確、password 錯誤時
                    echo '帳號或密碼錯誤！';
                }
            } else {
                // username、password 錯誤時
                echo 'fail!!!';
            }

        } else {
            echo "empty data";
        }


    } else {
        echo 'submit fail!!';
    }

}






?>