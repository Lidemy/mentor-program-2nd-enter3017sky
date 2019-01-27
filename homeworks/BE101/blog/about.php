<?php 
    include './inc/conn.php';
    require_once './inc/Parsedown.php'; 

    $sql = "SELECT introduction FROM about WHERE id = 1";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetch();

    $about_text = $row['introduction'];

    $md = new Parsedown(); // 文字轉成 markdown 格式
    $md_text = $md->text($about_text);
?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">
<?php 
    $web_title = 'About Me « enter3017sky Blog';
    include_once './inc/head.php'; 
?>
<body>
<div class="container-fluid">
    <?php include './inc/navbar.php' ; ?>
    <header class="jumbotron text-center bg-white">
        <h1>About Me</h1>
    </header>
    <div class="post__container">
        <article class="card-body col-md-7 mx-auto">
            <!-- <h2><a>About Me</a></h2> -->
            <div class="content">
                <p class="about__text">
                    <?php echo $md_text; ?>
                </p>
            </div>
        </div>
    <footer class="blog__footer text-center m-3">
        <p>Copyright © 2019 - enter3017sky</p>
    </footer>
</div>
</body>
</html>