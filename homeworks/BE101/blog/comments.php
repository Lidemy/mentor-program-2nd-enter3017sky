<?php

require './inc/conn.php';
require './inc/utils.php';
require_once './check_login.php';


$article_id = escape($_POST['article_id']);
$name = $_POST['name'];
$content = $_POST['content'];

if(empty($name) || empty($content) || empty($article_id)) {
    echo 'data empty';
} else {

    // 把留言的暱稱存入 SESSION
    $_SESSION['commenter'] = $name;

    $sql = "INSERT INTO comments(article_id, name, content)VALUES(?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$article_id, $name, $content]);

    // 取得 comment 的 id
    $commentId = $pdo->lastInsertId();
    $result = $stmt->rowCount();

    if($result) {
        printMessage('新增留言成功！');
    } else {
        echo 'Add comment failed.';
    }
}


?>