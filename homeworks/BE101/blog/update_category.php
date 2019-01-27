<?php

require './inc/conn.php';
require './inc/utils.php';
include_once './check_login.php';
checkLoginAndPrintMsg($user, '你沒有登入齁！');

$id = $_GET['id'];
$sql = "SELECT * FROM categories WHERE id = $id";
$result = $pdo->query($sql);
$row = $result->fetch();

$name = $row['name'];
$cat_id = $row['id'];

?>

<!DOCTYPE html>
<html lang="zh-Hant-TW">
    <?php 
        $web_title = '編輯分類 « enter3017sky Blog';
        include_once './inc/head.php'; 
    ?>
<body>
<?php include './inc/navbar.php' ; ?>
<div class="container">
    <header class="jumbotron text-center bg-white">
        <h1>編輯分類</h1>
        <a href="./add.php">新增文章</a> 
        <a href="./admin_category.php">管理分類</a>
    </header>

    <div class="box_shadow col-md-4 col-md-8 mx-auto p-4 mb-5">
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