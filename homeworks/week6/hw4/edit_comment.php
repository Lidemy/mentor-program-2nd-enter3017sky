<?php
    include_once('./check_login.php');
    include_once('./conn.php');
    include_once('./utils.php')
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>編輯留言</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <header>
            <!-- 引入 navbar -->
        <?php include_once 'templates/navbar.php' ?>
    </header>
    <div class="container">
        <div class="wrapper__form">
            <form class="meg__form" method="POST" action="./handle_edit_comment.php">
        <div class='form-row'><h1>編輯留言</h1></div>
    <!-- 這個隱藏的 input ，會把主留言新增的留言，設定aprent_id=0 ，以辨別這是主留言 -->
            <input type="hidden" name="id" value="<?= $_GET['id'] ?>" />
            <div class='form-row'>
                <textarea name='content' placeholder="留言內容"></textarea>
            </div>
            <div class='form-row'>
            <!-- 以下這樣寫辨識度不好 -->
                <?php if ($user) { ?>
                    <div class="sub__btn">
                        <input type="submit" class="submit__btn">
                    </div>
                <?php } else { ?>
                    <div>請註冊或登入！</div>
                <?php }?>
            </div>
        </form>
    </div>
</body>
</html>