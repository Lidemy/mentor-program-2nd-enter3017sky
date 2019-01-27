<?php

// 引入連線資料庫的檔案
require_once './inc/conn.php';
require_once './inc/utils.php';
require_once './check_login.php';

/** 防止惡意行為，沒有登入不能用。 */
checkLoginAndPrintMsg($user);

// var_dump($_GET);

// exit;
// 未完成之前，先把刪除作廢
// printMessage('\n\n\n你已經刪除了你已經刪除了你已經刪除了...\n\n\n(模擬刪除)', './admin.php');
// exit;

// GET 方法
$id = $_GET['id'];
// $sql = "DELETE FROM articles WHERE id = $id";
// $result = $pdo->exec($sql);

// 刪除文章時一併刪除留言以及選用的分類。
$sql = "DELETE a, c, t FROM articles a INNER JOIN comments c ON a.id=c.article_id INNER JOIN taxonomy t ON t.article_id=a.id WHERE a.id = ?";

$statement = $pdo->prepare($sql);
$statement->execute([$id]);
$del_CCT = $statement->rowCount();

// 執行成功的話，轉回原本的畫面
if($del_CCT > 0) {
    printMessage('你已經成功刪除文章與評論了！', './admin.php');
} else {
    // 沒有評論不能刪
    $sql = "DELETE a, t FROM articles a INNER JOIN taxonomy t ON t.article_id=a.id WHERE a.id = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$id]);
    $del_CT = $statement->rowCount();
    if($del_CT) {
        printMessage('你已經成功刪除文章了！', './admin.php');
    } else {
        $sql = "DELETE FROM articles WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        $del = $statement->rowCount();

        if($del) {
            printMessage('成功刪除文章！', './admin.php');
        } else {
            printMessage('刪除失敗！？', './admin.php');
        }
        printMessage('刪除失敗了！', './admin.php');
    }
    printMessage('Delete failed.', './admin.php');
}

?>