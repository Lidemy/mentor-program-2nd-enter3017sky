
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Message board</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
      
   
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://bootswatch.com/4/lumen/bootstrap.min.css">

    <!-- 自己的 CSS -->
    <link rel="stylesheet" type="text/css" href="style.css">


    <!-- 這個跟官方的重複了，不確定要不要留著，看起來是沒什麼問題 -->
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <!-- 官方的 jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- 引入自己的 js -->
    <script src="./index.js"></script>
</head>
<body>
    <header>
            <!-- 引入 navbar -->
        <?php include 'templates/navbar.php' ?>
    </header>
    <div class="container">
        <!-- 用 POST 方法，submit 之後傳送給 handle_register.php -->
        <form class="register__form" method="POST" action="./handle_login.php">
            <div class='form-row form-inline'>
                <label>帳號：<input type="text" name="username" class="form-control" autofocus></label>
            </div>
            <div class='form-row form-inline'>
                <label>密碼：<input type="password" name="password" class="form-control"></label>
            </div>
            <div class='form-row form-inline'>
                <input type="submit" class="LR__btn btn btn-primary">
            </div>
        </form>
    </div>
</body>
</html>