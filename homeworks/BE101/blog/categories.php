<?php include './inc/conn.php'; ?>
<?php require_once './inc/utils.php'; ?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">
    <?php 
        $web_title = 'Categories « enter3017sky Blog';
        include_once './inc/head.php'; 
    ?>
<body>
    <?php include './inc/navbar.php' ; ?>
<div class="container">
    <header class="jumbotron text-center bg-white">
        <h1>Categories</h1>
        <!-- <a href="./add_category.php">新增分類</a> 
        <a href="./admin.php">管理文章</a>
        <a href="./edit_about.php">編輯 About Me</a> -->
    </header>
    <div class="box_shadow col-sm-10 col-md-10 mx-auto p-3">
        <ul class="list-group list-group-flush">
            <?php
                    // 撈出 分類的名稱、id、id 總數(使用過幾次這個分類) 
                $sql = "SELECT c.name, t.category_id, count(t.category_id) FROM categories c left join taxonomy t on c.id=t.category_id left join articles a on a.id=t.article_id  WHERE a.draft=0  group BY category_id desc";

                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $result = $stmt->rowCount();

                if($result) {
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                        $category_id = $row['category_id'];
                        $category_name = escape($row['name']);
                        $count = $row['count(t.category_id)'];

                        print "
                            <a href='./category.php?id=$category_id' class='list-group-item list-group-item-action d-flex justify-content-between'>
                                <h3 class='truncate'>$category_name</h3>
                                <button class='btn btn-secondary' disabled>$count</button>
                            </a>";

                        //** 後來發現不用顯示草稿，除非在 admin_category */
                        // 分類的項目裡面沒文章的話不帶連結
                        // if(!$category_id) {
                        //     print "
                        //         <li class='list-group-item list-group-item-action d-flex justify-content-between'>
                        //             <div class='d-flex flex-row'>
                        //             <h3>$category_name</h3>
                        //             </div>
                        //             <div class='btn-group' role='group' aria-label='Third group'>
                        //                 <button type='button' class='btn btn-secondary'>$count</button>
                        //             </div>
                        //         </li>";
                        // } else {
                        //     print "
                        //         <a href='./category.php?id=$category_id' class='list-group-item list-group-item-action d-flex justify-content-between'>
                        //             <h3 class='truncate'>$category_name</h3>
                        //             <button class='btn btn-secondary' disabled>$count</button>
                        //         </a>";
                        // }

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