<?php include './inc/conn.php'; ?>
<?php require_once './inc/utils.php'; ?>
<?php include_once './check_login.php'; ?>
<?php checkLoginAndPrintMsg($user, '你沒有登入齁！'); ?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">
    <?php 
        $web_title = '分類管理 « enter3017sky Blog';
        include_once './inc/head.php'; 
    ?>
<body>
    <?php include './inc/navbar.php' ; ?>
<div class="container">
    <header class="jumbotron text-center bg-white">
        <h1>分類管理</h1>
        <a href="./add_category.php">新增分類</a> 
        <a href="./admin.php">管理文章</a>
        <a href="./edit_about.php">編輯 About Me</a>
    </header>
    <div class="box_shadow col-sm-10 col-md-10 mx-auto p-3">
        <ul class="list-group list-group-flush">
            <?php
                $sql = "SELECT * FROM categories ORDER BY id DESC";
                // $stmt = $pdo->query($sql);

                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $result = $stmt->rowCount();

                if($result > 0) {
                    while($row = $stmt->fetch()) {
                        
                        $category_name = escape($row['name']);
                        // $created_at = new DateTime($row['created_at']);
                        // $year = $created_at->format('l, M d Y');
                        // $date = $created_at->format('M d');
                        $id = $row['id'];
                        print "
                        <li class='list-group-item list-group-item-action d-flex justify-content-between'>
                            <div class='truncate'>
                                <h3>$category_name</h3>
                            </div>
                            <div>
                                <a href='update_category.php?id=$id' class='btn btn-outline-secondary'>編輯</a>
                                <a href='delete_category.php?id=$id' class='btn btn-outline-secondary'>刪除</a>
                            </div>
                        </li>";

                        // <a href='./category.php?id=$category_id' class='list-group-item list-group-item-action d-flex justify-content-between'>
                        //     <h3 class='truncate'>$category_name</h3>
                        //     <button class='btn btn-secondary' disabled>$count</button>
                        // </a>



                        // <a href='./category.php?id=$category_id' class='list-group-item list-group-item-action d-flex justify-content-between'>
                        //     <h3 class='truncate'>$category_name</h3>
                        //     <button class='btn btn-secondary' disabled>$count</button>
                        // </a>

                    }
                }
            ?>
        </ul>
    </div>
    <footer class="blog__footer text-center m-3">
        <p>Copyright © 2019 - enter3017sky</p>
    </footer>
</div>
<!--  -->
</body>
</html>