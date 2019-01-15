<?php include './inc/conn.php'; ?>
<?php include './inc/bootstrap.php'; ?>
<?php require_once './inc/Parsedown.php'; ?>

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
<div class="container-fluid">
    <?php include './inc/navbar.php' ; ?>
    <?php
        // 用 GET 方法取得文章 id
        $id = $_GET['id'];

        $sql = "SELECT A.title, A.content, A.created_at, A.draft FROM articles A WHERE A.id = $id";

        $result = $pdo->query($sql);
        $row = $result->fetch(PDO::FETCH_ASSOC);

        // 撈出文章的 title, content, created_at, draft(是否為草稿的狀態)
        $title = $row['title'];
        $time = $row['created_at'];
        $content = $row['content'];
        $draft = $row['draft'];

        // 每篇文章的狀態用三元運算子判斷
        $status = $draft?"<span class='badge badge-secondary draft ml-4'>Draft</span>":'';

        $md = new Parsedown();
        $text = $md->text($content); // 把內文轉成 markdown 格式

    ?>

    <header class="jumbotron text-center bg-white">
        <h1>
            <!-- 文章標題 -->
            <?php echo $title; ?>
        </h1>
        <div>
            <span>
                <!-- 處理分類 -->
                <?php 
                    // 選取 name 把名字關聯起來。
                    $tag_sql = "SELECT c.name FROM categories c LEFT JOIN taxonomy t ON c.id=t.category_id WHERE t.article_id= $id";
                    $result = $pdo->query($tag_sql);

                    // 變成一維陣列
                    $tag_row = $result->fetchAll(PDO::FETCH_COLUMN);

                    // 印出分類
                    foreach ($tag_row as $key => $value) {
                        print "
                            <button type='button' class='badge btn-outline-info mr-1'>$value</button>
                        ";
                    }
                ?>
            </span>
        </div>
    </header>
    <div class='post__container'>
        <article class='card-body col-md-7 mx-auto'>
            <div class='mb-3'>
                <span class='post__time'>
                    <?php echo $time; ?> <!-- 顯示時間 -->
                </span>
                <?php echo $status; ?>
            </div>
            <div class='post__content'>
                <?php echo $text; ?> <!-- 顯示文章內容 -->
            </div>
            <!--  -->
            <div class="card mt-5">

            <?php

                $result = $pdo->query("SELECT * FROM comments WHERE article_id = $id");
                if($result->rowCount()> 0){
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        print"
                    <div class='card m-2'>
                        <div class='card-header d-flex'>
                            <h5 class='card-title'>{$row['name']}</h5>
                            <span class='post__time ml-4 pt-1'>{$row['created_at']}</span>
                        </div>
                        <div class='card-body'>
                            <p class='card-text'>{$row['content']}</p>
                        </div>
                    </div>";
                    }
                }
            ?>
                <!-- <div class="card-header" id="headingThree"> -->
                <div class="" id="headingThree">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed text-dark btn-block" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <strong>Comments</strong>
                        </button>
                    </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body">
                        <!--  -->
                        <form method="POST" action="./comments.php">
                            <div class="form-group">
                                <label for="username">暱稱</label>
                                <input type="text" class="form-control" name="name" id="username" placeholder="訪客名稱" />
                            </div>
                            <div class="form-group">
                                <label for="content">留言內容</label>
                                <textarea class="form-control" id="content" name="content" rows="5" placeholder="想說些什麼呢？"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="article_id" value="<?php echo $id ?>">
                                <input type="submit" class="btn btn-outline-dark" />
                            </div>
                        </form>
                        <!--  -->
                    </div>
                </div>
            </div>
        </article>
    </div> 
    <!--  -->
    <footer class="blog__footer text-center m-3">
        <p>Copyright © 2019 - enter3017sky</p>
    </footer>
</div>
</body>
</html>