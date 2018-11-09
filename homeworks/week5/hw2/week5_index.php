<?php

// ini_set('display_errors', '1');
// error_reporting(E_ALL);
// session_start;
// session_start();

// 登入機制
// require_once('week5_checklogin.php');
$is_login = false;
$user_id = '';

// 有時候 isset 的判斷可能會跟我們想像中的不一樣，所以在加上 !empty 的判斷
if (isset($_COOKIE["user_id"]) && !empty($_COOKIE["user_id"])) {
    $is_login = true;
    $user_id = $_COOKIE["user_id"];
} else {
}

?>
<!DOCTYPE html>
<html lang="zh-tw">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Message Board</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="week5_index.css" />
</head>
<body class='body__set'>
    <header class='head__main'>
        <div class='head__title'>Message Board</div>
<?php
    if (!$is_login) {  // 如果沒登入顯示註冊、登入的按鈕
?>   
    <a class='head__logout' href="week5_register.php" id="logout">註冊</a>
    <a class='head__logout' href="week5_login.php" id="logout">登入</a>
<?php
    } else {        // 如果有登入的話顯示登出的按鈕
?>
    <a class='head__logout' href="week5_logout.php" id="logout">登出</a>
<?php
    }
?>
    </header>
    <div class='main'>
        <div class='meg__form'>
            <form method="POST" action="/enter3017sky/week5/add_comment.php"> <!--負責插入留言-->
                <!--這個表單會以 POST 的方式送給 add_comment.php 這個檔案進行處理 -->
                <div class='meg__form-input'>
                </div>
                <label name="content">
                    <div class='meg__form-textarea'>
                        <textarea name='content' type='textarea' placeholder="留言內容"></textarea>
                    </div>
                </label>
                <!-- 小技巧 插入一個看不見的東西來拿到資料-->
                <input type='hidden' name='parent_id' value="0" />
        <?php
            if ($is_login) {
                echo "<input class='meg__form-submit' type='submit' value='提交' />";
            } else {
                echo "<input class='meg__form-submit' type='submit' value='請先登入' disabled />";
            }
        ?>
            </form>
        </div>
        <div class='meg__commnets'>
<?php


    require_once('conn.php');

             // 查詢主要頁數
    // $comments = '';
    // SELECT COUNT(Column_name) FROM table_name WHERE condition;
    $page_sql = "SELECT COUNT(parent_id) AS meg_data FROM enter3017sky_comments WHERE parent_id = 0";
    // var_dump($page_sql);
    // var_dump($conn->query($page_sql));
    // 加上 die($conn->error); 印出錯誤
    $page_result = $conn->query($page_sql);
    $page_row = $page_result->fetch_assoc();

        // 確認總頁數
    $pages_num = ceil($page_row['meg_data'] / 10);
    
    // 設定目前所在的頁數
    if(!isset($_GET['page'])) $page = 1;
    else $page = intval($_GET['page']);
    // var_dump($page);




    // 顯示所有留言
    // 選擇 comments資料表中的 id content created_id 以及 users 資料表的 nickname
    // 只要撈 parent_id 等於 0 的
    $sql = "SELECT enter3017sky_comments.id, enter3017sky_comments.content, enter3017sky_comments.created_at, enter3017sky_user.nickname FROM enter3017sky_comments 
    LEFT JOIN enter3017sky_user ON enter3017sky_comments.user_id = enter3017sky_user.id
    WHERE parent_id = 0 ORDER BY created_at DESC LIMIT " . ($page - 1)*10 . " ,10 ";
    $result = $conn->query($sql);
        // var_dump($result);
        // var_dump($result->fetch_assoc());
    while ($row = $result->fetch_assoc()) {
        require('template_comment.php'); // 插入留言、子留言
    }

?>
        </div>
    </div>
    <footer class='bottom__footer'>
        <ul class="meg__page-bar">
            <?php
                //設定頁碼
                for ( $i = 1; $i<=$pages_num; $i++ ){
                    //如果是目前頁面的頁碼不做連結
                    if ( $i  ===  $page ) echo " <li class='meg__page'><b>$i</b></li> " ;
                    else echo " <li class='meg__page'><a href='week5_index.php?page=".$i."'>".$i."</a></li> ";
                }
            ?>
        </ul>
        <div class='bottom__title'>enter3017sky MTR02 Homework Week5</div>
    </footer>
</body>
</html>