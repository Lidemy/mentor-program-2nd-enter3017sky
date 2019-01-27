<?php require_once './inc/conn.php'; ?>
<?php require_once './inc/utils.php'; ?>
<?php require_once './check_login.php'; ?>
<?php require_once './inc/Parsedown.php'; ?>
<?php
    // 用 GET 方法取得文章 id
    $id = $_GET['id'];

    $sql = "SELECT A.title, A.content, A.created_at, A.draft FROM articles A WHERE A.id = $id";

    try {
        $stmt = $pdo->prepare($sql);
        if($stmt) {
            $stmt->execute();
            $result = $stmt->rowCount();
            if($result) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $time = $row['created_at'];
                $draft = $row['draft'];

                /** 
                 * 目前的測試的結果，先 escape 在轉成 markdown 最正常。
                 * 直接打 html 標籤會直接顯示出來，沒有作用。
                 * 用 markdown 會有效果。
                 */

                $title = escape($row['title']);

                // $content = escape($row['content']);
                $content = $row['content'];

                $md = new Parsedown();

                // 使用 Parsedown() 的安全模式來跳脫，如此一來，所有的 html 標籤也能正常顯示，不會只顯示 html Encode。
                $md->setSafeMode(true); 
                $text = $md->text($content); // 把內文轉成 markdown 格式

                    // 每篇文章的狀態用三元運算子判斷
                $status = $draft ? "<span class='badge badge-secondary draft ml-4'>Draft</span>":'';

            } else {
                // 當 id 錯誤時，顯示訊息導回文章區。
                printMessage('找不到該文章，帶你去看所有文章吧！', './archives.php');
            }
        }
    } catch (\Throwable $th) {

        // 本來要做一些錯誤處理，發現導回首頁比較乾脆。
        // 當 id 輸入數字以外時，顯示訊息導回首頁。
        echo "<br/>";
        echo '<pre>';
        echo "ERROR: ".$th->getMessage().'<br>';
        echo "Line: ".$th->getLine().'<br>';
        echo "Code: ".$th->getCode().'<br>';
        echo '</pre>';
        printMessage('不確定你想幹嘛耶！', './index.php');

    }
?>

<!DOCTYPE html>
<html lang="zh-Hant-TW">
    <?php 
        $web_title = "$title « enter3017sky Blog";
        include_once './inc/head.php'; 
    ?>
    <!-- <link rel="stylesheet" href="./inc/prism-default/prism.css">
    <script src="./inc/prism-default/prism.js"></script> -->

    <!-- highlight code - tomorrow_night -->
    <link rel="stylesheet" href="./inc/prism-tomorrow_night/prism.css">
<body>
<div class="container-fluid">
    <?php include './inc/navbar.php' ; ?>
    <header class="jumbotron text-center bg-white">
        <h1>
            <!-- 文章標題 -->
            <?php echo $title; ?>
        </h1>
        <div>
            <span>
                <!-- 處理分類 -->
                <?php 
                    // 選取 name 把名字關聯起來。
                    $tag_sql = "SELECT c.name FROM categories c LEFT JOIN taxonomy t ON c.id=t.category_id WHERE t.article_id= $id";

                    try {
                        $stmt = $pdo->prepare($tag_sql);
                        $stmt->execute();
                        // 變成一維陣列
                        $tag_row = $stmt->fetchAll(PDO::FETCH_COLUMN);
                        // 印出分類
                        foreach ($tag_row as $key => $value) {
                            $draft = escape($value);
                            print "
                                <button type='button' class='badge btn-outline-secondary mr-1'>$draft</button>
                            ";
                        }
                    } catch (\Throwable $th) {
                        echo "<br/>";
                        echo '<pre>';
                        echo "ERROR: ".$th->getMessage().'<br>';
                        echo "Line: ".$th->getLine().'<br>';
                        echo "Code: ".$th->getCode().'<br>';
                        echo '</pre>';
                    }
                ?>
            </span>
        </div>
    </header>
    <div class='post__container'>
        <article class='card-body col-md-7 mx-auto'>
            <div class='mb-3'>
                <span class='post__time'>
                    <!-- 顯示時間 -->
                    <?php echo $time; 
                    
                    if(isset($user)) {
                        print "<a href='update.php?id=$id' class='btn btn-outline-success btn-sm ml-3' role='button'>Edit</a>";
                    }
                    
                    ?>
                </span>
                <?php echo $status; ?>
            </div>
            <div class='post__content'>
                <?php echo $text; ?> <!-- 顯示文章內容 -->
            </div>
            <!--  -->
            <div class="card mt-5">
                <?php
                    $stmt = $pdo->prepare("SELECT * FROM comments WHERE article_id = $id");
                    $stmt->execute();
                    if($stmt->rowCount() > 0){
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $name = escape($row['name']);
                            $content = escape($row['content']);
                            $comment_id = $row['id'];
                            print"
                                <div class='card m-2'>
                                    <div class='card-header d-flex'>
                                        <h5 class='card-title'>{$name}</h5>
                                        <span class='post__time ml-4 pt-1'>{$row['created_at']}</span>
                                    </div>
                                    <input type='hidden' name='comment_id' value='$id'>
                                    <div class='card-body'>
                                        <p class='card-text'>{$content}</p>
                                    </div>
                                </div>";
                        }
                    }
                ?>
                <!-- <div class="card-header" id="headingThree"> -->
                <div class="" id="headingThree">
                    <button class="btn btn-link collapsed text-dark btn-block" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <!-- <h5 class="mb-0"> -->
                            <strong>Comments</strong>
                        <!-- </h5> -->
                    </button>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <!-- <div class='card-body'> -->
                        <!--  -->
                        <form method="POST" action="./comments.php">
                            <?php 
                                /** 假如是使用者登入的話，留言名稱就是使用者的名稱 */
                                if(isset($user)) {
                                    $_SESSION['commenter'] = $user;
                                }
                                if(isset($_SESSION['commenter'])) {
                                    $nickname = $_SESSION['commenter'];
                                    $logout = empty($user) ?"<a role='button' href='logout_comment.php' class='btn btn-outline-secondary'>Log out</a>":'';
                                    print"
                                    <div class='card m-3'>
                                        <div class='card-header d-flex justify-content-between'>
                                            <h5 class='card-title'>{$nickname}</h5>
                                            <input type='hidden' name='name' value='{$nickname}' />
                                            {$logout}
                                        </div>
                                        <div class='card-body'>
                                            <label for='content'>留言內容</label>
                                            <textarea class='form-control' id='content' name='content' rows='5' placeholder='想說些什麼呢？'></textarea>
                                            <input type='hidden' name='article_id' value='{$id}' />
                                            <input type='submit' class='btn btn-outline-dark mt-3' />
                                        </div>
                                    </div>";
                                } else {
                                    print"
                                <div class='card-body'>
                                    <div class='form-group'>
                                        <label for='name'>暱稱</label>
                                        <input type='text' class='form-control' name='name' id='name' placeholder='訪客名稱' />
                                    </div>
                                    <div class='form-group'>
                                        <label for='content'>留言內容</label>
                                        <textarea class='form-control' id='content' name='content' rows='5' placeholder='想說些什麼呢？'></textarea>
                                    </div>
                                    <div class='form-group'>
                                        <input type='hidden' name='article_id' value='{$id}' />
                                        <input type='submit' class='btn btn-outline-dark' />
                                    </div>
                                </div>";
                                }
                            ?> 
                            
                        </form>
                        <!--  -->
                    </div>
                </div>
            </div>
        </article>
    </div> 
    <!--  -->
    <footer class="blog__footer text-center m-3">
        <p>Copyright © 2019 - enter3017sky</p>
    </footer>
</div>
<!-- High Light -->
<script src="./inc/prism-tomorrow_night/prism.js"></script>
<!--  -->
</body>
</html>