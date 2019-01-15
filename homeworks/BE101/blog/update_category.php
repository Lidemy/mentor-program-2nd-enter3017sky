<?php

require './inc/conn.php';

$id = $_GET['id'];
$sql = "SELECT * FROM categories WHERE id = $id";
$result = $pdo->query($sql);
$row = $result->fetch();

$name = $row['name'];
$cat_id = $row['id'];

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
</head>
<body>
<?php include './inc/navbar.php' ; ?>
<div class="container">
    <header class="jumbotron text-center bg-white">
        <h1>編輯分類</h1>
        <a href="./add.php">新增文章</a> 
        <a href="./admin_category.php">管理分類</a>
    </header>

    <div class="admin__articles col-md-4 col-md-8 mx-auto p-4 mb-5">
        <form method="POST" action="./handle_update_category.php">
            <div class="form-group">
                <label for="name"><h4>編輯分類名稱:</h4></label>
                <input type="text" class="form-control" name="name" id="name" value="<?php echo $name; ?>" />
                <input type="hidden" name="id" value="<?php echo $cat_id; ?>">
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