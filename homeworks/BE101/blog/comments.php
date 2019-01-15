<?php

require './inc/conn.php';
require './inc/utils.php';


$article_id = $_POST['article_id'];
$name = $_POST['name'];
$content = $_POST['content'];

if(empty($name) || empty($content) || empty($article_id)) {
    echo 'data empty';
} else {

    $sql = "INSERT INTO comments(article_id, name, content)VALUES(?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$article_id, $name, $content]);
    $result = $stmt->rowCount();

    if($result) {
        printMessage('新增成功');
    } else {
        echo 'Add comment failed.';
    }
}


?>