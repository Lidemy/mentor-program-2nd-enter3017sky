<?php

// 第一件事情，引入連線資料庫的檔案
require './inc/conn.php';

// 第二件事情，拿資料
$name = $_POST['name'];

if(isset($name)) {

    $sql = "INSERT INTO categories(name)VALUES('$name')";
    $result = $pdo->exec($sql);
    if(!$result) {
        die("failed. " . $pdo->errorInfo() );
    } else {
        header("location: admin_category.php");
    }
} else {
    die('empty data');
}

?>