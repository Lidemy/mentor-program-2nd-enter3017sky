<?php

require './inc/conn.php';
require './check_login.php';
require_once './inc/utils.php';


/** 防止惡意行為，沒有登入不能用。 */
checkLoginAndPrintMsg($user, '你沒有登入齁！');
// if(!isset($user) && empty($user)) {
//     printMessage('你沒有登入喔！', './index.php');
// }

$sql = "SELECT about.introduction FROM about";
$result = $pdo->query($sql);
$row = $result->fetch();

// 把 <br> 再轉回去 \n，在 textarea 的時候就不會顯示出來了。
$introduction = str_replace("<br/>", "\n", $row['introduction']);

?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">
    <?php 
        $web_title = 'Editing about me « enter3017sky Blog';
        include_once './inc/head.php'; 
    ?>
<body>
<body>
<div class="container-fluid">
    <?php include './inc/navbar.php' ; ?>
    <header class="jumbotron text-center bg-white">
        <h1>Editing about me</h1>
    </header>
    <div class="box_shadow col-md-4 col-md-8 mx-auto p-4 mb-5">
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




