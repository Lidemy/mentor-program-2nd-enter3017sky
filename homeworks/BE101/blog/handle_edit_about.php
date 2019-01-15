<?php

require_once './inc/conn.php';

// $introduction = $_POST['introduction'];

$introduction = str_replace("\r\n", "<br/>", $_POST['introduction']);

// 使用 exec()、query() 輸入複雜的資料可能會有 SQL Injection 的問題， submit 也可能會出錯。
// $sql = "UPDATE about SET about.introduction WHERE id = 1";
// $stmt = $pdo->query($sql);

try {
    $sql = "UPDATE about SET about.introduction = ? WHERE id = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$introduction]);

    header('location: ./about.php');

} catch(PDOException $e) {
    echo 'fail';
}

?>