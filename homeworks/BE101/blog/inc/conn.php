<?php
// 資料來源名稱 (Data Source Name, DSN)
$dsn = 'mysql:host=localhost; dbname=enter3017sky_db; charset=utf8';
$db_username = 'root';
$db_password = 'ji394su3';


// 連結資料庫
try {
    $pdo = new PDO($dsn, $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
} catch (PDOException $e) {
    print "<h1>Couldn't connect to the database: <br>" . $e->getMessage() . "</h1>";
}
// 設定資料庫出錯時丟出列外

?>