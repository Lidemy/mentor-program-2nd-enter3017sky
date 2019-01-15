<?php

require './inc/conn.php';


$sql = "SELECT about.introduction FROM about";
$result = $pdo->query($sql);
$row = $result->fetch();

// 把 <br> 再轉回去 \n，再 textarea 的時候就不會顯示出來了。
$introduction = str_replace("<br/>", "\n", $row['introduction']);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Editing "about me"</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
    <script src="main.js"></script>
</head>
<body>
<div class="container-fluid">
    <?php include './inc/navbar.php' ; ?>
    <header class="jumbotron text-center bg-white">
        <h1>Editing "about me"</h1>
    </header>

    <div class="admin__articles col-md-4 col-md-8 mx-auto p-4 mb-5">
        <form method="POST" action="./handle_edit_about.php">
            <div class="form-group">
                <label for="content">我想說：</label>
                <textarea class="form-control" id="content" name="introduction" rows="8"><?php echo $introduction ?></textarea>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-outline-dark">
            </div>
        </form>
    </div>


    <footer class="blog__footer text-center m-3">
        <p>Copyright © 2019 - enter3017sky</p>
    </footer>
</div>
<!--  -->
</body>
</html>




