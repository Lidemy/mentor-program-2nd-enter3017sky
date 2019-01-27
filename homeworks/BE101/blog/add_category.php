<?php include './inc/conn.php'; ?>
<?php require_once './inc/utils.php'; ?>
<?php include_once './check_login.php'; ?>
<?php
    // 按鈕不能按，input 不能輸入，也可以成功新增！handle 的地方也要驗證
    if(!isset($user) && empty($user)) {
        printMessage('你沒有登入喔！', './index.php');
    }
    $checkLogin = (!isset($user) && empty($user)) ? 'disabled' : '';
?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">
    <?php 
        $web_title = '新增分類 « enter3017sky Blog';
        include_once './inc/head.php'; 
    ?>
<body>
<?php include './inc/navbar.php' ; ?>
<div class="container">
    <header class="jumbotron text-center bg-white">
        <h1>新增分類</h1>
    </header>
    <!-- <div class="box_shadow col-md- col-md-8 mx-auto p-4 mb-5"> -->
    <div class="box_shadow col-sm-8 col-md-6 mx-auto p-3">
        <form method="POST" action="./handle_add_category.php">
            <div class="form-group">
                <label for="name"><h4>分類名稱:</h4></label>
                <input type="text" class="form-control" name="name" id="name" placeholder="添加一個感興趣的事物吧！" <?=$checkLogin?>/>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-outline-dark" value="Create New Tag" <?=$checkLogin?>>
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
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        if($stmt->rowCount() > 0) {
                            while($row = $stmt->fetch()) {
                                $category_name = escape($row['name']);
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