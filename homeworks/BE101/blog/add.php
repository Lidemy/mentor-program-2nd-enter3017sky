<?php include './inc/conn.php'; ?>
<?php include './inc/bootstrap.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>新增文章</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
    <script src="main.js"></script>
</head>
<body>
<?php include './inc/navbar.php' ; ?>
<div class="container">
    <header class="jumbotron text-center bg-white">
        <h1>新增文章</h1>
    </header>
    <div class="admin__articles col-md-4 col-md-8 mx-auto p-4 mb-5">
        <form method="POST" action="./handle_add.php">
            <div class="form-group">
                <label for="title">文章標題：</label>
                <input type="text" class="form-control" name="title" id="title" placeholder="取個好標題吧！" />
            </div>
            <div class="form-group">
                <label for="content">文章內容：</label>
                <textarea class="form-control" id="content" name="content" rows="8"  placeholder="想說些什麼呢？" ></textarea>
            </div>
            <div class='form-group'>文章分類：
                <?php
                    $sql_category = "SELECT * FROM categories ORDER BY id ASC";
                    $result_category = $pdo->query($sql_category);
                    if($result_category->rowCount() > 0) {
                        while($row_category = $result_category->fetch()) {
                            $id = $row_category['id'];
                            $name = $row_category['name'];
                            print "
                            <div class='form-check'>
                                <input name='category_id[]' class='form-check-input' type='checkbox' value='$id' id='check_$id'/>
                                <label class='form-check-label' for='check_$id'>$name</label>
                            </div>";
                        }
                    }
                ?>
            </div>
            <div class="btn-toolbar justify-content-between">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-secondary btn__draft">
                        <input type="radio" name="draft" value="0">發佈
                    </label>
                    <label class="btn btn-outline-secondary btn__draft active">
                        <input type="radio" name="draft" value="1" checked>草稿
                    </label>
                </div>
                <div class="btn-group">
                    <input type="submit" class="btn btn-outline-dark" />
                </div>
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