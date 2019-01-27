<?php
require './inc/conn.php';
require_once './inc/utils.php';
require_once './inc/Parsedown.php';
$q = $_GET['q'];

?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">
    <?php 
        $web_title = 'Search « enter3017sky Blog';
        include_once './inc/head.php'; 
    ?>
<body>
<!-- 首頁的效果 -->
<div class="container-fluid">
    <?php include './inc/navbar.php' ; ?>
    <header class="jumbotron text-center bg-white">
        <h1>Search Blog</h1>
    </header>
    <?php
        // 把 articles 這個 table 的內容都撈出來，DESC 降冪排序，條件太多必須用括號表示優先級。
        $sql = "SELECT * FROM articles A WHERE draft=0 AND (title like ? OR content like ?) AND content NOT like ? ORDER BY created_at DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["%$q%", "%$q%", "%```$q%"]);

        if(!$stmt->rowCount()){
            print "
            <div class='post__container'>
                <div class='post__title text-center'>
                    <p class='search__result'>Sorry, no posts matched your criteria.</p>
                    <p class='search__result'>
                    Your search for <strong>“ $q ”</strong> matches <strong>0</strong> results.</p>
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
                // 將撈出的資料跳脫
                $title = escape($row['title']);
                $replace_title = str_ireplace($q, "<mark>$q</mark>", $title); // 把被搜尋的字串，用 <mark> 包起來。
                // echo $replace_title, $q, "<mark>$q</mark>";
                $result_title = mb_substr($replace_title, 0, 100, 'UTF-8');


                /** -> 取得 content 
                 *  -> 取代 $q 
                 *  -> (搜尋 content 中的 $q 並取得前後 150 字元) 
                 * -> 截短並輸出 
                */
                $md = new Parsedown(); // 文字轉成 markdown 格式
                $md->setSafeMode(true); // 使用 Parsedown() 的安全模式來跳脫
                
                // $content = $row['content']; // 資料庫撈出來的 content

                $content = escape($row['content']);
                // $md_text = $md->text($row['content']);
                $part_text = catchStr($content, $q); // 搜尋結果的一部分

                $replace_content = str_ireplace($q, "<mark>$q</mark>", $part_text); // 把被搜尋的字串，用 <mark> 包起來。

                // echo "stripos: 關鍵字在字串中第一次出現的位置 <br>".$start = stripos($content, $q)."<br>";
                // echo "mb_strlen: 字串的總長度 <br>".$length = mb_strlen($content, 'utf-8')."<br>";
                // $test1 = strchr($replace_content, "<mark>$q</mark>"); // 擷取目標字串之後的字
                // echo mb_substr($test1, 0, 200, 'utf-8'); // 擷取目標字串之後 從 0 開始到 200 的字
                // echo "<br><br>";


                $result_content = mb_substr($replace_content, 0, 400, 'UTF-8'); // 從第1個字元開始擷取到200個字元
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