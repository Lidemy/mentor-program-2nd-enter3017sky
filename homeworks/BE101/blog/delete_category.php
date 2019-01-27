<?php

// 引入連線資料庫的檔案
require './inc/conn.php';

require_once './inc/utils.php';
require_once './check_login.php';



/** 防止惡意行為，沒有登入不能用。 */
checkLoginAndPrintMsg($user);


// GET 方法
$id = $_GET['id'];
$sql = "DELETE FROM categories WHERE id = $id";
$result = $pdo->exec($sql);

// 執行成功的話，轉回原本的畫面
if($result) {
    header('location: admin_category.php');
} else {
// 停止執行，顯示刪除失敗
    die('Delete failed.');
}

?>