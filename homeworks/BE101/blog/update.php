<?php
require './inc/conn.php';
require_once './inc/utils.php';
include_once './check_login.php';

/** 防止惡意行為，沒有登入不能用。 */
checkLoginAndPrintMsg($user, '你沒有登入齁！');

$id = $_GET['id']; // articles 的 id(文章 id)
// $sql = "SELECT * FROM articles WHERE id = $id;

// $sql = "SELECT a.id, a.title, a.content, c.name, t.category_id FROM articles AS a 
// LEFT JOIN taxonomy AS t ON a.id=t.article_id
// LEFT JOIN categories AS c ON t.category_id=c.id 
// WHERE a.id = $id";

$sql ="SELECT a.id, a.title, a.content, a.draft, c.name, GROUP_CONCAT(t.category_id) FROM articles AS a 
LEFT JOIN taxonomy AS t ON a.id=t.article_id
LEFT JOIN categories AS c ON t.category_id=c.id 
WHERE a.id = $id";

$result = $pdo->query($sql);
$row = $result->fetch();

$title = $row['title'];
$content = $row['content'];

$draft = $row['draft'];

$dis_draft = $draft?'編輯草稿':'編輯文章';

// GROUP_CONCAT 取得並把重複的 column 的值用 , 接起來。
$category_list = $row['GROUP_CONCAT(t.category_id)'];

// 移除分隔符變成陣列 explode($delimiter ,$string)
$checked_arr = explode(',', $category_list);


?>

<!DOCTYPE html>
<html lang="zh-Hant-TW">
    <?php 
        $web_title = '新增文章 « enter3017sky Blog';
        include_once './inc/head.php'; 
    ?>
<body>
    <?php include './inc/navbar.php' ; ?>
<div class="container">
    <header class="jumbotron text-center bg-white">
        <h1><?php echo $dis_draft; ?></h1>
        <a href="./add.php">新增文章</a> 
        <a href="./admin_category.php">管理分類</a>
    </header>

    <div class="box_shadow col-md-4 col-md-8 mx-auto p-4 mb-5">
        <form method="POST" action="./handle_update.php">
            <div class="form-group">
                <label for="title">文章標題：</label>
                <input type="text" class="form-control" name="title" id="title" value="<?php echo $title ?>" />
            </div>
            <div class="form-group">
                <label for="content">文章內容：</label>
                <textarea class="form-control" id="content" name="content" rows="8"><?php echo $content ?></textarea>
            </div>
            <div class="form-group">文章分類：
                <?php

                    // 這裡要顯示分類的選項，撈出所有分類的資料。
                    $sql_category = "SELECT * FROM categories ORDER BY id ASC";
                    $result_category = $pdo->query($sql_category);
                    if($result_category->rowCount() > 0) {

                        // 用 fetchAll(PDO::FETCH_KEY_PAIR) 取得鍵值的配對
                        $cat_option_arr = $result_category->fetchAll(PDO::FETCH_KEY_PAIR);

                            // echo "<pre>";
                            // print_r($cat_option_arr);
                            // echo "</pre>";

                                // 確定印出的結果是我們要的。
                                // Array
                                // (
                                //     [3] => JavaScript
                                //     [16] => PHP
                                //     [17] => 心情記事
                                //     [18] => 感情交流
                                //     (略)...
                                // )
/** 參考來源 https://makitweb.com/get-checked-checkboxes-value-with-php/ */

                        foreach ($cat_option_arr as $id => $name) {
                            $checked = '';
                            $category_name = escape($name);
                            if(in_array($id, $checked_arr)) {
                                $checked = "checked";
                            }
                            print "
                            <div class='form-check'>
                                <input name='category_id[]' class='form-check-input' type='checkbox' value='$id' id='check_$id' $checked/>
                                <label class='form-check-label' for='check_$id'>$category_name</label>
                            </div>";
                        }

                        /**   本來的寫法，但是思考不出來   */
                        // foreach ($category_arr as $key => $category_id) {
                        // }
                        // while($row_category = $result_category->fetch()) {
                        //     $id = $row_category['id'];
                        //     $is_checked = $category_id == $id ? 'checked' : '123123';
                        //     $name = $row_category['name'];
                        //     print "
                        //     <div class='form-check'>
                        //         <input name='category_id[]' class='form-check-input' type='checkbox' value='$id' id='check_$id' $category_id/>
                        //         <label class='form-check-label' for='check_$id'>$name</label>
                        //     </div>";
                        // }

                    }
                ?>

            </div>

                <!-- 第一版：分類單選 -->
            <!-- <div class="form-group">
                <select name="category_id">
                    <?php
                        $sql_category = "SELECT * FROM categories ORDER BY id ASC";
                        $result_category = $pdo->query($sql_category);
                        if($result_category->rowCount() > 0) {
                            while($row_category = $result_category->fetch()) {
                                $id = $row_category['id'];
                                $name = $row_category['name'];
                                // 用三元運算子判斷，讓編輯時顯示原本的選項
                                $is_checked = $row['category_id'] === $id ? 'selected' : '';
                                print "
                                <option value='" . $id . "' ". $is_checked .">" . $name . "</option>";
                            }    
                        }
                    ?>
                </select>
            </div> -->

            <input type="hidden" name="id" value="<?php echo $row['id']?>">
            <div class="btn-toolbar justify-content-between">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-secondary btn__draft <?php echo $draft?'':'active'; ?>">
                        <input type="radio" name="draft" autocomplete="off" value="0" <?php echo $draft?'':'checked'; ?> />發佈
                    </label>
                    <label class="btn btn-outline-secondary btn__draft <?php echo $draft?'active':''; ?>">
                        <input type="radio" name="draft" autocomplete="off" value="1" <?php echo $draft?'checked':''; ?> />草稿
                    </label>
                </div>
                <div class="btn-group">
                    <input type="submit" class="btn btn-outline-dark" />
                </div>
            </div>
        </form>
    </div>
    <!--  -->
    <footer class="blog__footer text-center m-3">
        <p>Copyright © 2019 - enter3017sky</p>
    </footer>
</div>
<!--  -->
</body>
</html>




