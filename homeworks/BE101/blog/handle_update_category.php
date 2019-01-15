<?php

// 第一件事情，引入連線資料庫的檔案
require './inc/conn.php';

// 第二件事情，拿資料
$name = $_POST['name'];
$id = $_POST['id'];

if(empty($name) || empty($id)) {
    die('empty data');
} else {
    $sql = "UPDATE categories SET name = '$name' WHERE id = $id";
    $result = $pdo->exec($sql);
    if(!$result) {
        echo "<pre>";
        print_r($pdo->errorInfo());
        die("failed.");
    } else {
        header("location: admin_category.php");
    }
}

?>