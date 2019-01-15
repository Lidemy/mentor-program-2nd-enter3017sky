<?php

require './inc/conn.php';
require_once './inc/utils.php';


$title = htmlspecialchars($_POST['title']);
$content = htmlspecialchars($_POST['content']);

// checkbox 沒勾選的話，沒參數，以下兩種方法。
$category_arr = @$_POST['category_id'];
$draft = @$_POST['draft'];

// if(isset($_POST['category_id'])) {
//     $category_arr = $_POST['category_id'];
// }

if(empty($title) || empty($content) || empty($category_arr)) {
    printMessage('有東西忘記填了唷！');
} else {

        // articles(table) 新增標題及內文，並取得這筆資料的 id
    $sql = "INSERT INTO articles(title, content, draft)VALUES(?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $content, $draft]);
    $id = $pdo->lastInsertId();

    for ($i=0; $i < count($category_arr) ; $i++) {
        // taxonomy(table) 直接新增新的資料 (文章 id, 分類 id)
        $sqlInsert = "INSERT INTO taxonomy(article_id, category_id)VALUES(?, ?)";
        $stmtInsert = $pdo->prepare($sqlInsert);
        $stmtInsert->execute([$id, $category_arr[$i]]);
    }

    header('location: ./admin.php');


    // if($result) {
    //     header('location: ./admin.php');
    // } else {
    //     die('fail');
    // }

}


?>