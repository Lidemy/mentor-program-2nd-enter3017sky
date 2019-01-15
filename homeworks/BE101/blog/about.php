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
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>enter3017sky Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
</head>
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