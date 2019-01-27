<?php

require_once './inc/conn.php';

require_once './inc/utils.php';
require_once './check_login.php';

/** 防止惡意行為，沒有登入不能用。 */
checkLoginAndPrintMsg($user, '你沒有登入齁！');
// if(!isset($user) && empty($user)) {
//     $_POST['introduction'] = null;
//     printMessage('嘿嘿嘿，想幹嘛？', './index.php');
// }



// $introduction = $_POST['introduction'];

$introduction = str_replace("\r\n", "<br/>", $_POST['introduction']);

// 使用 exec()、query() 輸入複雜的資料可能會有 SQL Injection 的問題， submit 也可能會出錯。
// $sql = "UPDATE about SET about.introduction WHERE id = 1";
// $stmt = $pdo->query($sql);

try {
    $sql = "UPDATE about SET about.introduction = ? WHERE id = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$introduction]);

    printMessage('編輯 About Me 成功！', './about.php');

} catch(PDOException $e) {
    echo 'Edit about me fail';
}

?>