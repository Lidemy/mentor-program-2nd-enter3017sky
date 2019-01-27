<?php include './inc/conn.php'; ?>
<?php require_once './check_login.php'; ?>
<?php require_once './inc/utils.php'; ?>
<?php require_once './inc/Parsedown.php'; ?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">
    <?php 
        $web_title = 'enter3017sky Blog';
        include_once './inc/head.php'; 
    ?>
    <!-- highlight code - tomorrow_night -->
    <link rel="stylesheet" href="./inc/prism-tomorrow_night/prism.css">
<body>
<!-- 首頁的效果 -->
<div class="container-fluid">
    <?php include './inc/navbar.php' ; ?>
    <header class="jumbotron text-center bg-white">
        <h1>enter3017sky Blog</h1>
        <?php 
        if($user) 
            print "
            <button type='button' class='badge btn-outline-secondary mr-1'>
                $user 登入中
            </button>"
        ?>
    </header>
    <?php
        // 把 articles 這個 table 的內容都撈出來，DESC 降冪排序，
        $sql = "SELECT * FROM articles WHERE draft=0 ORDER BY created_at DESC";

        // $result = $pdo->query($sql);
        // if($result->rowCount() > 0) {

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            while($row = $stmt->fetch()) {
                $id = $row['id'];
                $created_at = new DateTime($row['created_at']);
                $time = $created_at->format('l, M d Y');
                $title = escape($row['title']);

                $md = new Parsedown(); // 文字轉成 markdown 格式
                $md->setSafeMode(true); // 使用 Parsedown() 的安全模式來跳脫

                $content = $row['content'];
                // $content = escape($row['content']);
                // $content_part = substr($content, 0, 400); // 中文會亂碼
                $content_part = mb_substr($content, 0, 200, 'UTF-8'); // 從第1個字元開始擷取到200個字元
                $text = $md->text($content_part);

                print"
                <div class='post__container'>
                    <article class='card-body col-md-7 mx-auto'>
                        <div class='mb-3'><span class='post__time'>$time</span></div>
                        <div class='post__title'>
                            <h2><a href='./article.php?id=$id' class='text-dark post__link'>$title</a></h2>
                        </div>
                        <div class='post__content'>$text</div>
                        
                        <footer class='mt-4'>
                            <p>
                                <a href='./article.php?id=$id' class='more__link'>
                                    READ MORE
                                </a>
                            </p>
                        </footer>
                    </article>
                </div>";
            }
        }
    ?>
    <!--  -->
    <?php

    if($user) {
        echo '$user: ' . $user;
    } else {
        echo 'no $user';
    }
    
    ?>
    <footer class="blog__footer text-center m-3">
        <p>Copyright © 2019 - enter3017sky</p>
    </footer>
</div>
<!-- High Light -->
<script src="./inc/prism-tomorrow_night/prism.js"></script>
<!--  -->
</body>
</html>