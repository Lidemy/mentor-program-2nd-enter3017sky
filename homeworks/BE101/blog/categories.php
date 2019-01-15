<?php include './inc/conn.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>分類管理</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
    <script src="main.js"></script>
</head>
<body>
    <?php include './inc/navbar.php' ; ?>
<div class="container">
    <header class="jumbotron text-center bg-white">
        <h1>Categories</h1>
        <!-- <a href="./add_category.php">新增分類</a> 
        <a href="./admin.php">管理文章</a>
        <a href="./edit_about.php">編輯 About Me</a> -->
    </header>
    <div class="admin__articles col-sm-10 col-md-10 mx-auto p-3">
        <ul class="list-group list-group-flush">
            <?php


                    // 撈出 分類的名稱、id、id 總數(使用過幾次這個分類) 
                $sql = "SELECT c.name, t.category_id, count(t.category_id) FROM categories c left join taxonomy t on c.id=t.category_id left join articles a on a.id=t.article_id  WHERE a.draft=0  group BY category_id desc";

                $result = $pdo->query($sql);
                if($result->rowCount() > 0) {
                    while($row = $result->fetch(PDO::FETCH_ASSOC)) {

                        $category_id = $row['category_id'];
                        $category_name = $row['name'];
                        $count = $row['count(t.category_id)'];

                        // 分類的項目裡面沒文章的話不帶連結
                        if(!$category_id) {
                            print "
                                <li class='list-group-item list-group-item-action d-flex justify-content-between'>
                                    <div class='d-flex flex-row'>
                                    <h3>$category_name</h3>
                                    </div>
                                    <div class='btn-group' role='group' aria-label='Third group'>
                                        <button type='button' class='btn btn-secondary'>$count</button>
                                    </div>
                                </li>";
                        } else {
                            print "
                                <li class='list-group-item list-group-item-action d-flex justify-content-between'>
                                    <div class='d-flex flex-row'>
                                    <h3><a href='./category.php?id=$category_id' class='text-dark post__link'>$category_name
                                    </a></h3>
                                    </div>
                                    <div class='btn-group' role='group' aria-label='Third group'>
                                        <button type='button' class='btn btn-secondary'>$count</button>
                                    </div>
                                </li>";
                        }
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