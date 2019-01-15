<?php

// 引入連線資料庫的檔案
require './inc/conn.php';

// 未完成之前，先把刪除作廢
require './inc/utils.php';
printMessage('\n\n\n你已經刪除了你已經刪除了你已經刪除了...\n\n\n(模擬刪除)', './admin.php');
exit;

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