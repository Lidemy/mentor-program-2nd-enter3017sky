<?php include './inc/conn.php'; ?>
<?php require_once './inc/Parsedown.php'; ?>
<?php include './inc/bootstrap.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>enter3017sky Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
    <script src="main.js"></script>
</head>
<body>
<!-- 首頁的效果 -->
<div class="container-fluid">
    <?php include './inc/navbar.php' ; ?>
    <header class="jumbotron text-center bg-white">
        <h1>enter3017sky Blog</h1>
    </header>
    <?php
        // 把 articles 這個 table 的內容都撈出來，DESC 降冪排序，
        $sql = "SELECT * FROM articles WHERE draft=0 ORDER BY created_at DESC";
        $result = $pdo->query($sql);
        if($result->rowCount() > 0) {
            while($row = $result->fetch()) {
                $id = $row['id'];
                $title = $row['title'];
                $created_at = new DateTime($row['created_at']);
                $time = $created_at->format('l, M d Y');


                $md = new Parsedown(); // 文字轉成 markdown 格式
                
                $content = $row['content'];
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
    <footer class="blog__footer text-center m-3">
        <p>Copyright © 2019 - enter3017sky</p>
    </footer>
</div>
</body>
</html>