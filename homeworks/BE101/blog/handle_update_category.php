<?php

// 第一件事情，引入連線資料庫的檔案
require './inc/conn.php';
require_once './inc/utils.php';
require_once './check_login.php';


/** 防止惡意行為，沒有登入不能用。 */

checkLoginAndPrintMsg($user, '你沒有登入齁！');
// if(!isset($user) && empty($user)) {
//     $_POST['name'] = null;
//     $_POST['id'] = null;
//     printMessage('嘿嘿嘿，想幹嘛？', './index.php');
// }




// 第二件事情，拿資料
$name = $_POST['name'];
$id = $_POST['id'];

if(empty($name) || empty($id)) {
    die('empty data');
} else {

    /** 如果沒有改名稱，下列兩者(exec(), prepare())皆返回 0 ，所以會導致出錯 */

    // $sql = "UPDATE categories SET name = '$name' WHERE id = $id";
    // $result = $pdo->exec($sql);

    $sql = "UPDATE categories SET name = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $id]);
    $result = $stmt->rowCount();

    if(!$result) {
        // 編輯前後相同返回 0，導回原本的畫面
        printMessage('分類名稱一樣唷！');
    } else {
        // 編輯成功導回管理分頁的畫面
        header("location: admin_category.php");
    }
}

?>