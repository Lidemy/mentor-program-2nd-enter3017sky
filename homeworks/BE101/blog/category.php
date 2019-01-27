<?php include './inc/conn.php'; ?>
<?php require_once './inc/utils.php'; ?>
<?php

    $id = $_GET['id'];
    $sql = "SELECT name FROM categories WHERE id = $id";
    // $stmt = $pdo->query($sql);
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $name = escape($row['name']);
    $tag = "<button type='button' class='btn btn-outline-secondary btn-sm mr-1'>$name</button>";
?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">
    <?php 
        $web_title = "$name « enter3017sky Blog";
        include_once './inc/head.php'; 
    ?>
<html>
<body>
    <?php include './inc/navbar.php' ; ?>
<div class="container">
    <header class="jumbotron text-center bg-white">
        <h3>Categories:  <?php echo $tag ?></h3>
    </header>
    <div class="box_shadow col-sm-10 col-md-10 mx-auto p-3">
        <ul class="list-group list-group-flush">
            <?php

                    // 撈出 分類的名稱、id、id 總數(使用過幾次這個分類) 
                $sql = "SELECT a.id, a.title, a.created_at , t.category_id FROM articles a LEFT JOIN taxonomy t ON a.id = t.article_id WHERE t.category_id = ? AND a.draft=0 ORDER BY a.created_at ASC";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);

                if($stmt->rowCount() > 0) {
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $id = $row['id'];
                        $created_at = new DateTime($row['created_at']);
                        $year = $created_at->format('l, M d Y');
                        $date = $created_at->format('M d');

                        $title = escape($row['title']);
                        $id = $row['id'];

                        print "
                            <a href='./article.php?id=$id' class='list-group-item list-group-item-action'>
                                <div class='d-flex flex-row'>
                                    <time class='datetime mr-3'>$date</time>
                                    <h4 class='truncate'>$title</h4>
                                </div>
                            </a>";
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