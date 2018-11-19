
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Message board</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <header>
            <!-- 引入 navbar -->
        <?php include 'templates/navbar.php' ?>
    </header>
    <div class="container">
        <!-- 用 POST 方法，submit 之後傳送給 handle_register.php -->
        <form class="register__form" method="POST" action="./handle_register.php">
            <div class='form-row'>
                <label>帳號：<input type="text" name="username" autofocus></label>
            </div>
            <div class='form-row'>
                <label>密碼：<input type="password" name="password"></label>
            </div>
            <div class='form-row'>
                <label>暱稱：<input type="text" name="nickname"></label>
            </div>
            <div class='form-row'>
                <input type="submit" class="submit__btn">
            </div>
        </form>
    </div>
  
    
</body>
</html>