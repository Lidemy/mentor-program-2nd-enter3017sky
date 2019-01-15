<?php include './inc/conn.php'; ?>
<?php include './inc/bootstrap.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>分類管理</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
    <script src="main.js"></script>

</head>
<body>
    <?php include './inc/navbar.php' ; ?>
<div class="container">
    <header class="jumbotron text-center bg-white">
        <h1>Blog Archive</h1>
    </header>
    <div class="admin__articles col-sm-10 col-md-10 mx-auto p-3">
        <ul class="list-group list-group-flush">
            <?php
                // $sql = "SELECT * FROM articles ORDER BY created_at DESC";

                $sql = "SELECT * FROM articles WHERE draft=0 ORDER BY created_at DESC";
                $result = $pdo->query($sql);
                if($result->rowCount() > 0) {
                    while($row = $result->fetch()) {
                        $created_at = new DateTime($row['created_at']);
                        $year = $created_at->format('l, M d Y');
                        $date = $created_at->format('M d');
                        $title = $row['title'];
                        $draft = $row['draft'];
                        $id = $row['id'];

                        $display = $draft?"<span class='badge badge-secondary draft'>Draft</span>":'';

                        print "
                        <li class='list-group-item list-group-item-action d-flex justify-content-between'>
                            <div class='d-flex flex-row'>
                                <time class='datetime mr-3'>$date</time>
                                $display
                                <h3 class='admin__title'>
                                    <a href='./article.php?id=$id' class='text-dark post__link'>$title</a>
                                </h3>
                            </div>
                        </li>";
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