<?php include_once './inc/conn.php'; ?>
<?php include_once './inc/utils.php'; ?>
<?php include_once './check_login.php'; ?>
<?php checkLoginAndPrintMsg($user, '你沒有登入齁！'); ?>

<!DOCTYPE html>
<html lang="zh-Hant-TW">
    <?php 
        $web_title = 'Admin « enter3017sky Blog';
        include_once './inc/head.php'; 
    ?>
<body>
    <?php include './inc/navbar.php' ; ?>
<div class="container">
    <header class="jumbotron text-center bg-white">
        <h1>文章管理</h1>
        <div>
            <a href="./add.php">新增文章</a>
            <a href="./admin_category.php">管理分類</a>
        </div>
        <?php
            if($user) {
                print "
                <button type='button' class='badge btn-outline-secondary mr-1'>
                    $user 登入中
                </button>";
            } else {
                exit;
            }
        ?>
    </header>
    <div class="box_shadow col-md-10 mx-auto p-3">
        <!-- <ul class="list-group list-group-flush"> -->
        <div class='list-group list-group-flush'>
            <?php
                $sql = "SELECT * FROM articles ORDER BY created_at DESC";
                $result = $pdo->query($sql);
                if($result->rowCount() > 0) {
                    while($row = $result->fetch()) {
                        $created_at = new DateTime($row['created_at']);
                        $year = $created_at->format('l, M d Y');
                        $date = $created_at->format('M d');

                        $message = "確定 真的 要刪除？？？？";
                        $title = escape($row['title']);
                        $draft = $row['draft'];
                        $id = $row['id'];

                        $display = $draft?"<span class='badge badge-secondary draft'>Draft</span>":'';

                        print "
                        <div class='list-group-item  list-group-item-action d-flex justify-content-between'>
                            <a href='./article.php?id=$id' class='text-dark truncate'>
                                <div class='d-flex flex-row'>
                                    <time class='datetime mr-3'>$date</time>
                                    $display
                                    <h3 class='truncate'>$title</h3>
                                </div>
                            </a>
                            <div class='text-right btn_group'>
                                <a href='update.php?id=$id' class='badge btn btn-outline-success' role='button'>編輯</a>
                                <a href='delete.php?id=$id' class='badge btn btn-outline-danger' role='button'>刪除</a>
                            </div>
                        </div>";
                    }
                }
            ?>
        </div>
    </div>
    <footer class="blog__footer text-center m-3">
        <p>Copyright © 2019 - enter3017sky</p>
    </footer>
</div>
</body>
</html>