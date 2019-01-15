<?php include './inc/conn.php'; ?>
<?php


$id = $_GET['id'];

$sql = "SELECT name FROM categories WHERE id = $id";

$stmt = $pdo->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$name = $row['name'];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Categories: <?php echo $name ?></title>
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
        <h1>Categories: <?php echo $name ?></h1>
    </header>
    <div class="admin__articles col-sm-10 col-md-10 mx-auto p-3">
        <ul class="list-group list-group-flush">
            <?php

                    // 撈出 分類的名稱、id、id 總數(使用過幾次這個分類) 
                $sql = "SELECT a.id, a.title, t.category_id FROM articles a LEFT JOIN taxonomy t ON a.id = t.article_id WHERE t.category_id = ? AND a.draft=0 ORDER BY a.created_at ASC";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);

                if($stmt->rowCount() > 0) {
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $id = $row['id'];
                        $title = $row['title'];

                        print "
                        <li class='list-group-item list-group-item-action d-flex justify-content-between'>
                            <div class='d-flex flex-row'>
                            <h3><a href='./article.php?id=$id' class='text-dark post__link'>$title
                            </a></h3>
                            </div>
                        </li>";
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