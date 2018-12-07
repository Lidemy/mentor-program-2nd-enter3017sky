
<?php
    include_once('./check_login.php');
    include_once('./conn.php');
    include_once('./utils.php');
    $timestamp = date('Y-m-d H:i:s');
    // echo $timestamp;
    // phpinfo();
    // $nick = null;
    // $user = null
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Message board</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://bootswatch.com/4/lumen/bootstrap.min.css">

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->

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
    <header class="header">

<!-- 引入 navbar -->
<?php include_once 'templates/navbar.php' ?> 

    </header>
    <div class="container">
        <?php 
            if(isset($user)) {      // 顯示使用者有登入的畫面
                include_once 'templates/show_login.php';
            } else {                // 顯示使用者未登入的畫面
                $user = null;
                include_once 'templates/show_unlogin.php';
            } 
        ?>

        <!-- 計算頁數 & 撈主留言 -->
        <?php 
            
            $page = 1;
            if(isset($_GET['page']) && !empty($_GET['page'])) {
                $page = (int) $_GET['page'];
            }
            $size = 10;
            $start = $size * ($page - 1);

                // 主留言
            $sql_comments =
                "SELECT comments.id, comments.content,comments.username, comments.created_at, users.nickname 
                FROM enter3017sky_comments AS comments 
                LEFT JOIN enter3017sky_user AS users 
                ON comments.username = users.username 
                WHERE comments.parent_id = 0
                ORDER BY comments.id DESC
                LIMIT ?, ?
                ";

            $stmt = $conn->prepare($sql_comments);
            $stmt->bind_param("ii", $start, $size);
            $is_success = $stmt->execute();
            $result = $stmt->get_result();
            
            if($is_success) {
                while($row = $result->fetch_assoc()) {
        ?>  
                <!-- 主留言開始 -->
            <div class='comments__wrapper'>
                <div class="meg__wrap card border-dark mb-2"> 
                    <div class="comment__header card-header">
                        <div class="comment__header__left">
                            <div class="comment__author nick">
                                <?= escape($row['nickname']) ?>
                            </div> 
                            <div class="comment__timestamp">
                                <?= $row['created_at']?>
                            </div>
                        </div>
                        <div class="comment__header__right">
                            <?php
                                if ($user === $row['username']) {
                                    echo renderDelAndEditBtn($row['id']);
                                }
                            ?>
                        </div>
                    </div>
                    <div class="comment__content ">
                        <?= escape($row['content']) ?>
                    </div>
                    <!-- 主留言結束 -->

                        <?php
                            // 設定使用者在自己的主留言底下留言顯示不同顏色
                            // 子留言
                            // sql 語法裡面不能放 $row['id']; 所以給它一個變數
                            $parent_id = $row['id'];
                            $sql_sub_comments = 
                                "SELECT c.id, c.content, c.created_at,c.username, u.nickname
                                FROM enter3017sky_comments AS c
                                LEFT JOIN enter3017sky_user AS u
                                ON c.username = u.username 
                                WHERE c.parent_id = ?
                                ORDER BY c.id DESC";

                            $stmt_sub = $conn->prepare($sql_sub_comments);
                            $stmt_sub->bind_param("i", $parent_id);
                            $stmt_sub->execute();
                            $result_sub = $stmt_sub->get_result();

                            if($result_sub){
                                while($row_sub = $result_sub->fetch_assoc()){
                        ?>
                        <?php if ($nick === $row['nickname']) { ?>
                            <div class="sub-meg__user alert alert-light mb-2"> 
                        <?php } else { ?>
                            <div class="sub-meg__wrap card border-dark mb-2">
                        <?php } ?>
                            <div class="comment__header card-header">
                                <div class="comment__header__left">
                                    <div class="sub-comment__author"><?= escape($row_sub['nickname']) ?></div> 
                                    <div class="sub-comment__timestamp"><?= $row_sub['created_at']?></div>
                                </div>
                                <div class="comment__header__right">
                                    <?php // 判斷是否為使用者，才有刪除編輯按鈕
                                        if (isset($_SESSION['username']) && $_SESSION['username'] === $row_sub['username']) {
                                            echo renderDelAndEditBtn($row_sub['id']);
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="sub-comment__content card-body">
                                <?= escape($row_sub['content']) ?>
                            </div>
                        </div>
                        <?php
                                }
                            }
                        ?>
                <div class="wrapper__form rounded-bottom w-100">
                    <form class="meg__form createSubMsg" method="POST" action="./add_comment.php">
                        <input type="hidden" class="hidden" name="parent_id" value="<?= $parent_id; ?>">
                        <input type="hidden" class="hidden" name="nickname" value="<?php if(isset($nick)) echo $nick; ?>" /><!-- 如果有使用者(登入)的話，才印出 -->
                        <div class='form-row'>
                            <textarea class="content form-control" name='content' type='textarea' placeholder="留言內容"></textarea>
                        </div>
                        <div class='form-row'>
                            <?php if(isset($nick)) { ?><!-- 如果有使用者(登入)的話，才顯示 -->
                                <div class="sub__btn">
                                    <input type="submit" class="submit__btn btn btn-primary">
                                </div>
                            <?php } else { ?>
                                <div class="alert alert-danger mb-0" role="alert">
                                    請註冊或登入！
                                </div>
                            <?php }?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            <?php
                    }
                }   
            ?>
        <div class="filler"></div>
    </div>

    <?php
        include_once 'templates/footer.php'
    ?>
</body>
</html>