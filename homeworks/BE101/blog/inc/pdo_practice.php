<?php


/**
 * 用 PDO 連接到 MySQL
 */

$dsn = 'mysql:host=localhost; dbname=enter3017sky_db; charset=utf8';
$db_username = 'root';
$db_password = 'ji394su3';

// 1. 連結資料庫（如果 PHP 可以連接到資料庫，就會有全新的 PDO物件儲存在變數 $pdo。）
try {
    $pdo = new PDO($dsn, $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
    
    // 設定資料庫出錯時丟出列外（如果 PHP 無法連接，PDO 創建失敗，就會尋找 PDOException 物件被丟出來，來告訴我們無法連接的錯誤訊息。）
} catch (PDOException $e) {
    print "<h1>Couldn't connect to the database: <br>" . $e->getMessage() . "</h1>";
}



/**
 *  從表格選取(select)資料
 * 當用 PDO 選取資料時，我們創建了一個 PDOStatement 物件。它代表我們的查詢，並讓我們取得結果。
 * 對於一個基本的查詢，我們可以使用 PDO::query() 方法。
 */

// 執行查詢
$stmt = $pdo->query("SELECT * FROM articles WHERE id = 1");

// 顯示結果
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "標題: ". $row['title'] ."<br>";
    echo "內文: ". $row['content'] ."<br>";
    echo "<pre>";
    var_dump($row);
    echo "<br><br><br>";
}

/** 資料取得模式
 * 
 * fetch() 取得一列。
 * fetchAll() 取得所有的列。
 * 這兩種方法的接受 fetch_style 參數，它定義了結果的資料集如何格式化。
 * 
 * PDO::FETCH_ASSOC 返回以欄位名稱作為索引鍵的陣列
 * PDO::FETCH_NUM 返回以數字作為索引鍵的陣列(從 0 開始)
 * PDO::FETCH_BOTH(Default) 返回以上兩者。
 * PDO::FETCH_BOUND 
 */



// fetch(PDO::FETCH_BOUND) 返回一個 bool

// fetchAll(PDO::FETCH_BOUND) 返回一個陣列與 bool
// array(1) {
//     [0]=>
//     bool(true)
//   }

// $stmt = $pdo->prepare("SELECT * FROM taxonomy WHERE article_id = ? AND category_id = ?");

// $stmt->execute([$art_arr, $cate_arr[2]]);

// // 顯示結果
// if($row = $stmt->fetch(PDO::FETCH_BOUND)) {
//     echo '<pre>';
//     var_dump($row);
// } else {
//     echo '<pre>';
//     var_dump($row);
// }






// 執行查詢

// $a = 1;
// $b = 25;


// $art_arr = 16;
// $cate_arr = array(3);



// $stmt = $pdo->prepare("SELECT * FROM taxonomy WHERE article_id = ? AND category_id = ?");
// $stmt->execute([$art_arr, $cate_arr[0]]);
// // $stmt->execute([$art_arr, $cate_arr[0]]);
// // 顯示結果
// if($row = $stmt->fetchAll(PDO::FETCH_BOUND)) {
//     echo 'test true';
//     echo '<pre>';
//     var_dump($row);
// } else {
//     echo 'test fail';
//     echo '<pre>';
//     var_dump($row);
// }







for ($i=0; $i < count($category_id) ; $i++) {

    $sql = "SELECT * FROM taxonomy where article_id = ? AND category_id = ?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$id, $category_id[$i]]);
    $check = $stmt->fetch(PDO::FETCH_BOUND);

    if($check) {
        echo "$check<br>";
        print($result);
        echo "\$i: $i, \$id: $id, \$category_id[$i]";
    } else {
        echo "$check<br>";
        echo "\$i: $i, \$id: $id, \$category_id[$i]";
    }

}

for ($i=0; $i < count($category_id) ; $i++) {
    $sql = "SELECT * FROM taxonomy where article_id = ? AND category_id = ?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$id, $category_id[$i]]);
    $check = $stmt->fetch(PDO::FETCH_BOUND);
    if($check) {
        echo "\$check: ";
        var_dump($check);
        echo "\$i: $i, \$id: $id, \$category_id[$i]: $category_id[$i]";
        echo "<br>";
        echo "<br>";

        $sqlUpdate = "UPDATE taxonomy SET article_id = ?, category_id = ? WHERE article_id = ?";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([$id, $category_id[$i], $id]);

    } else {
        echo "\$check: ";
        var_dump($check);
        echo "\$i: $i, \$id: $id, \$category_id[$i]: $category_id[$i]";
        echo "<br>";
        echo "<br>";

        $sqlInsert = "INSERT INTO taxonomy(article_id, category_id)VALUES(?, ?)";
        $stmtInsert = $pdo->prepare($sqlInsert);
        $stmtInsert->execute([$id, $category_id[$i]]);
    }
}













?>