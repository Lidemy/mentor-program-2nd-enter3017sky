<?php include './inc/conn.php'; ?>
<?php include './inc/bootstrap.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>新增分類</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
    <script src="main.js"></script>
</head>
<body>
<?php include './inc/navbar.php' ; ?>
<div class="container">
    <header class="jumbotron text-center bg-white">
        <h1>新增分類</h1>
    </header>
    <!-- <div class="admin__articles col-md- col-md-8 mx-auto p-4 mb-5"> -->
    <div class="admin__articles col-sm-8 col-md-6 mx-auto p-3">
        <form method="POST" action="./handle_add_category.php">
            <div class="form-group">
                <label for="name"><h4>分類名稱:</h4></label>
                <input type="text" class="form-control" name="name" id="name" placeholder="添加一個感興趣的事物吧！" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-outline-dark" value="Create New Tag">
            </div>
        </form>
        <hr>
        <div class='form-group'>
            <ul class="list-group list-group-flush">
                <li class='list-group-item list-group-item-action'>
                    <h5>現有的分類</h5>
                <!-- </li>
                <li class='list-group-item list-group-item-action'> -->
                    <?php
                        $sql = "SELECT * FROM categories ORDER BY name";
                        $result = $pdo->query($sql);
                        if($result->rowCount() > 0) {
                            while($row = $result->fetch()) {
                                $category_name = $row['name'];
                                print "
                                <button type='button' class='btn btn-sm btn-outline-info mr-2 mb-1'>$category_name</button>";
                            }
                        }
                    ?>
                </li>
            </ul>
        </div>
    </div>
    <footer class="blog__footer text-center m-3">
        <p>Copyright © 2019 - enter3017sky</p>
    </footer>
</div>
<!--  -->
</body>
</html>