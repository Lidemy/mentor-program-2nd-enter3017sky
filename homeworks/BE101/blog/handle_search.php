<?php
require './inc/conn.php';
require './inc/bootstrap.php';
require './inc/conn.php';

$q = $_GET['q'];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>enter3017sky Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />

</head>
<body>
<!-- 首頁的效果 -->
<div class="container-fluid">
    <?php include './inc/navbar.php' ; ?>
    <header class="jumbotron text-center bg-white">
        <h1>enter3017sky Blog</h1>
    </header>
    <?php
        // 把 articles 這個 table 的內容都撈出來，DESC 降冪排序，條件太多必須用括號表示優先級。
        $sql = "SELECT * FROM articles A WHERE draft=0 AND (title like ? OR content like ?) ORDER BY created_at DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["%$q%", "%$q%"]);

        if(!$stmt->rowCount()){
            print "
            <div class='post__container'>
                <div class='post__title text-center'>
                    <p class='search__result'>Your search for <strong>“ $q ”</strong> matches <strong>0</strong> results.</p>
                </div>
            </div>";

        } else {
            $count = $stmt->rowCount();

            print"
            <div class='post__container text-center'>
                <p class='search__result'>Your search for <strong>“ $q ”</strong> matches <strong>$count</strong> results:</p>
            </div>";

            while($row = $stmt->fetch()) {
                $id = $row['id'];
                $created_at = new DateTime($row['created_at']);
                $time = $created_at->format('l, M d Y');
                
                // $md = new Parsedown(); // 文字轉成 markdown 格式
                
                $title = $row['title'];
                $replace_title = str_ireplace($q, "<mark>$q</mark>", $title); // 把被搜尋的字串，用 <mark> 包起來。
                // echo $replace_title, $q, "<mark>$q</mark>";
                $result_title = mb_substr($replace_title, 0, 100, 'UTF-8');

                $content = $row['content']; // 資料庫撈出來的 content
                $replace_content = str_ireplace($q, "<mark>$q</mark>", $content); // 把被搜尋的字串，用 <mark> 包起來。

                $result_content = mb_substr($replace_content, 0, 100, 'UTF-8'); // 從第1個字元開始擷取到200個字元
                // $text = $md->text($content_part);

                // exit;

                print"
                <div class='post__container'>
                    <article class='card-body col-md-7 mx-auto'>
                        <div class='post__time'><span>$time</span></div>
                        <div class='post__title'>
                            <h2><a href='./article.php?id=$id' class='text-dark post__link'>$result_title</a></h2>
                        </div>
                        <div class='post__content'>
                            <p>$result_content</p>
                        </div>
                    </article>
                </div>";
            }
        }

    ?>

    <footer class="blog__footer text-center m-3">
        <p>Copyright © 2019 - enter3017sky</p>
    </footer>
</div>
</body>
</html>