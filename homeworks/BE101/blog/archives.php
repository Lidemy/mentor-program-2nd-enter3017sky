<?php include './inc/conn.php'; ?>
<?php require_once './inc/utils.php'; ?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">
    <?php 
        $web_title = 'Archive « enter3017sky Blog';
        include_once './inc/head.php'; 
    ?>
<body>
    <?php include './inc/navbar.php' ; ?>
<div class="container">
    <header class="jumbotron text-center bg-white">
        <h1>Archive</h1>
    </header>
    <div class="box_shadow col-sm-10 col-md-10 mx-auto p-3">
        <ul class="list-group list-group-flush">
            <?php

                $sql = "SELECT * FROM articles WHERE draft=0 ORDER BY created_at DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();

                if($stmt->rowCount() > 0) {
                    while($row = $stmt->fetch()) {
                        // 顯示時間
                        $created_at = new DateTime($row['created_at']);
                        $year = $created_at->format('l, M d Y');
                        $date = $created_at->format('M d');

                        $title = escape($row['title']);
                        $id = $row['id'];

                        print "
                            <a href='./article.php?id=$id' class='list-group-item list-group-item-action'>
                                <div class='d-flex flex-row'>
                                    <time class='datetime mr-3'>$date</time>
                                    <h3 class='truncate'>$title</h3>
                                </div>
                            </a>";
                    }
                }
            ?>
        </ul>
    </div>
    <footer class="blog__footer text-center m-3 mt-5">
        <p>Copyright © 2019 - enter3017sky</p>
    </footer>
</div>
<!--  -->
</body>
</html>