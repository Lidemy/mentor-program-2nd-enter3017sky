<?php
// 第一件事情，引入連線資料庫的檔案
require './inc/conn.php';
require_once './inc/utils.php';
require_once './check_login.php';

/** 防止惡意行為，沒有登入不能用。 */
checkLoginAndPrintMsg($user, '你沒有登入齁！', './handle_update.php');
// if(!isset($user) && empty($user)) {
//     $_POST['title'] = null;
//     $_POST['content'] = null;
//     $_POST['category_id'] = null;
//     $_POST['draft'] = null;
//     $_POST['name'] = null;
//     printMessage('嘿嘿嘿，想幹嘛？', './index.php');
// }

// 未完成之前，先把刪除作廢
// printMessage('\n\n\n你已經編輯了你已經編輯了你已經編輯了...\n\n\n(模擬編輯)', './admin.php');
// exit;

// 第二件事情，拿資料

    $id = $_POST['id'];

    $title = $_POST['title'];
    $content = $_POST['content'];
    $draft = @$_POST['draft'];

    $category_id = @$_POST['category_id'];

if(empty($title) || empty($content) || empty($id) || empty($category_id)) {
    printMessage('有東西忘記填了唷！');
    die('empty data');
} else {

        // articles(table) 更新文章
    $sql = "UPDATE articles SET title = ?, content = ?, draft = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $content, $draft, $id]);

    // 做判斷的話，沒更新會出錯，再研究。
    // if(!$result) {
    //     echo "<pre>";
    //     print_r($pdo->errorInfo());
    //     die("failed.");
    // } else {
        // 先刪除舊的資料
        $sql = "DELETE FROM taxonomy where article_id = $id";
        $stmt = $pdo->exec($sql);

        // 資料插入
        for ($i=0; $i < count($category_id) ; $i++) {
        // 直接新增新的資料
            $sqlInsert = "INSERT INTO taxonomy(article_id, category_id)VALUES(?, ?)";
            $stmtInsert = $pdo->prepare($sqlInsert);
            $stmtInsert->execute([$id, $category_id[$i]]);
        }
        header("location: admin.php");
    // }
}

?>