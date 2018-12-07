<?php
        // 印出訊息，導引至某處。
    function printMessage($msg, $redirect) {
        echo '<script>';
        echo "alert('" . htmlentities($msg, ENT_QUOTES) . "');";
        echo "window.location = '" . $redirect . "'";
        echo '</script>';
    }


    // escape function 跳脫字元
    function escape($str) {
        return htmlspecialchars($str, ENT_QUOTES);
    }

        // 實作 session 的機制
    function setToken($conn, $username) {
        // 使用 uniqid()函式 生成 id 給 token 用
        $token = uniqid();
        $sql = "DELETE FROM enter3017sky_certificates WHERE username='$username'";
        $conn->query($sql);
        
        $sql = "INSERT INTO enter3017sky_certificates(username, token)VALUES('$username', '$token')";
        $conn->query($sql);
        setcookie("token", $token, time()+3600*24);
    }
    
    function getUserByToken($conn, $token) {
        if(isset($token) && !empty($token)) {
            $sql = "SELECT c.username, c.token, u.nickname
            FROM enter3017sky_certificates AS c
            LEFT JOIN enter3017sky_users AS u
            ON c.username = u.username
            WHERE token = '$token'";
    
            $result = $conn->query($sql);
            if(!$result || $result->num_rows <= 0){
                return null;
            } else {
                $row = $result->fetch_assoc();
                return $row['username'];
                // return $row['nickname'];
            }
        } else {
            return null;
        }
    }
    

    // 用雙引號把return的範圍框起來，裡面要用單引號，變數才能使用
    function renderDeleteBtn($id) {
        return "
            <div class='delete__comment'>
                <form method='POST' action='./delete_comment.php'>
                    <input type='hidden' name='id' value='$id'>
                    <input type='submit' value='刪除' class='delete__btn'>
                </form>
            </div>
        ";
    }

        // 編輯用 GET ，按下之後帶你去編輯的頁面
    function renderEditBtn($id) {
        return "
            <div class='edit__comment'>
                <form method='GET' action='./edit_comment.php'>
                    <input type='hidden' name='id' value='$id'>
                    <input type='submit' value='編輯' class='edit__btn'>
                </form>
            </div>
        ";
    }
?>