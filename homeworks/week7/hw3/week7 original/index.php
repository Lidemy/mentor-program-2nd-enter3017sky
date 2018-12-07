<?php
    include_once('./check_login.php');
    include_once('./conn.php');
    include_once('./utils.php');

// date_default_timezone_set('Asia/Taipei');
// $script_tz = date_default_timezone_get();
// if (strcmp($script_tz, ini_get('date.timezone'))){
//     echo 'Script timezone differs from ini-set timezone.';
// } else {
//     echo 'Script timezone and ini-set timezone match.';
// }

    $timestamp = date('Y-m-d H:i:s');
    // echo $timestamp;
    // phpinfo();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Message board</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./style.css">

</head>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="./index.js"></script>

<body>
    <header>
            <!-- 引入 navbar -->
        <?php include_once 'templates/navbar.php' ?>
    </header>
    <div class="container">
        <div class="wrapper__form">
            <form class="meg__form createMsg" method="POST" action="./add_comment.php">
                <input type="hidden" class="hidden" name="parent_id" value="0" />
                <input type="hidden" class="hidden" name="nickname" value="<?= $nick ?>" />
                <div class="user__nick">
                    <?php
                        // var_dump($user);
                        if(isset($user)) {
                        // 顯示登入的暱稱 , 從 check_login.php 撈資料
                            echo 'Hello, ' . $nick ;
                        } else {
                            $user = null;
                            echo 'Please login or register';
                        }
                    ?>
                </div>
                <div class='form-row'>
                    <textarea class="content" name='content' placeholder="留言內容"></textarea>
                </div>
                <div class='form-row'>
                <!-- 以下這樣寫辨識度不好 -->
                    <?php if ($user) { ?>
                        <div class="sub__btn">
                            <input type="submit" class="submit__btn">
                        </div>
                    <?php } else {
                        $user = null;
                    ?>
                        <div>請註冊或登入！</div>
                    <?php }?>
                </div>
            </form>
        </div>
        <?php
            // 計算頁數
            $page = 1;
            if(isset($_GET['page']) && !empty($_GET['page'])) {
                $page = (int) $_GET['page'];
            }
            $size = 10;
            $start = $size * ($page - 1);

                // 主留言
            $sql_comments =
            "SELECT comments.id, comments.content,comments.username, comments.created_at, users.nickname 
            FROM enter3017sky_comments AS comments 
            LEFT JOIN enter3017sky_user AS users 
            ON comments.username = users.username 
            WHERE comments.parent_id = 0
            ORDER BY comments.id DESC
            LIMIT ?, ?
            ";

            $stmt = $conn->prepare($sql_comments);
            $stmt->bind_param("ii", $start, $size);
            $is_success = $stmt->execute();
            $result = $stmt->get_result();
            // $result = $conn->query($sql_comments);
            if($is_success) {
               
                // $row = $result->fetch_assoc() 先賦值才判斷
                while($row = $result->fetch_assoc()) {
        ?>
        <div class='comments__wrapper'>
            <div class="meg__wrap"> 
                <div class="comment__header">
                    <div class="comment__header__left">
                        <div class="comment__author">
                            <?= escape($row['nickname']) ?>
                        </div> 
                        <div class="comment__timestamp">
                            <?= $row['created_at']?>
                        </div>
                    </div>
                    <div class="comment__header__right">
                        <?php
                        // var_dump(($user === $row['username'])); 
                        // 如果有登入且使用者符合，才會顯示刪除按鈕
                            if ($user === $row['username']) {
                                echo renderDeleteBtn($row['id']);
                                echo renderEditBtn($row['id']);
                            } else {
                                $user = null;
                            }
                        ?>
                    </div>
                </div>
                <div class="comment__content">
                    <?= escape($row['content']) ?>
                </div>
                    <?php
                        // sql 語法裡面不能放 $row['id']; 所以給它一個變數
                        $parent_id = $row['id'];

                        $sql_sub_comments = 
                        "SELECT c.id, c.content, c.created_at,c.username, u.nickname
                        FROM enter3017sky_comments AS c
                        LEFT JOIN enter3017sky_user AS u
                        ON c.username = u.username 
                        WHERE c.parent_id = ?
                        ORDER BY c.id DESC";

                        $stmt_sub = $conn->prepare($sql_sub_comments);
                        $stmt_sub->bind_param("i", $parent_id);
                        $stmt_sub->execute();
                        $result_sub = $stmt_sub->get_result();

                        if($result_sub){
                            while($row_sub = $result_sub->fetch_assoc()){
                    ?>
                    
                        <!--  設定使用者在自己的主留言底下留言顯示不同顏色 -->
                    <?php if ($user === $row_sub['username']) { ?>
                        <div class="sub-meg__user"> 
                    <?php } else { ?>
                        <div class="sub-meg__wrap">
                    <?php } ?>
                        <div class="comment__header">
                            <div class="comment__header__left">
                                <div class="sub-comment__author">
                                    <?= escape($row_sub['nickname']) ?>
                                </div> 
                                <div class="sub-comment__timestamp">
                                <?= $row_sub['created_at']?>
                                </div>
                            </div>
                            <div class="comment__header__right">
                                <?php
                                // 判斷是否為使用者，才有刪除編輯按鈕
                                    if ($user === $row_sub['username']) {
                                        echo renderDeleteBtn($row_sub['id']);
                                        echo renderEditBtn($row_sub['id']);
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="sub-comment__content">
                            <?= escape($row_sub['content']) ?>
                        </div>
                    </div>
                    <?php
                            }
                        }
                    ?>
                <div class="wrapper__form">
                    <form class="meg__form createSubMsg" method="POST" action="./add_comment.php">
                    <input type="hidden" class="hidden" name="parent_id" value="<?= $parent_id; ?>">
                    
                    <input type="hidden" class="hidden" name="nickname" value="<?php if(isset($nick)) echo $nick; ?>" /><!-- 如果有使用者(登入)的話，才印出 -->
                        <div class='form-row'>
                            <textarea class="content" name='content' type='textarea' placeholder="留言內容"></textarea>
                        </div>
                        <div class='form-row'>
                            <?php if(isset($nick)) { ?><!-- 如果有使用者(登入)的話，才顯示 -->
                                <div class="sub__btn">
                                    <input type="submit" class="submit__btn">
                                </div>
                            <?php } else {
                                $user = null;
                            ?>
                                <div>請註冊或登入！</div>
                            <?php }?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            <?php
                    }
                }   
            ?>
        <div class="filler"></div>
    </div>
    
    <div class="form-row">
        <?php

        // 計算主留言的數量，來計算頁數
        $count_sql = "SELECT count(*) AS count 
        FROM enter3017sky_comments
        WHERE parent_id = 0";

        $stmt_count = $conn->prepare($count_sql);
        $is_count_success = $stmt_count->execute();
        $count_result = $stmt_count->get_result();
        
        if ($is_count_success && $count_result->num_rows > 0) {
            $count = $count_result->fetch_assoc()['count'];
            $size = 10;
            $total_page = ceil($count / $size);
        }

        // echo $total_page;
        
        ?>
    </div>
    <footer class='bottom__footer'>
        <ul class="page_bar">
            <?php
                for($i = 1; $i <= $total_page; $i++) {
                    if ($page === 1 && $i <= 5) {
                        if($page === $i) {
                            echo "
                            <li class='meg__page'><a>" . $i . "</a></li>" ;
                        } else {
                            echo "
                            <li class='meg__page'>
                            <a href='./index.php?page=$i'>" . $i . "</a></li>" ;
                        }
                    } else if ($page === 2 && $i <= 5) {
                        if($page === $i) {
                            echo "
                            <li class='meg__page'><a>" . $i . "</a></li>" ;
                        } else {
                            echo "
                            <li class='meg__page'>
                            <a href='./index.php?page=$i'>" . $i . "</a></li>" ;
                        }
                    } else if( $page-3 < $i && $page+3 > $i) {
                        if($page === $i) {
                            echo "
                            <li class='meg__page'><a>" . $i . "</a></li>" ;
                        } else {
                            echo "
                            <li class='meg__page'>
                            <a href='./index.php?page=$i'>" . $i . "</a></li>" ;
                        }
                    }
                }
            ?>
        </ul>
        <!-- <div class='bottom__title'>enter3017sky MTR02 Homework Week5</div> -->
    </footer>
</body>
</html>