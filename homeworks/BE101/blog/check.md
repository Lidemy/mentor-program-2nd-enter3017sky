
- `GROUP_CONCAT()`: 將資料合併成一行
- `PDO::fetchAll(PDO::FETCH_KEY_PAIR)`: 把撈出的時候變成 key/value 的配對。
- `in_array`: 判斷 checked 的 id 。
    - `in_array(mixed 的參數, array(檢查的 arr)[, 嚴格模式(true): 預設 false])`


```php

// 用 GET 取文章的 id
$id = $_GET['id'];

// 從 db 撈出要編輯的資料
// 選取 文章的 id, title, content、分類的 name
// 使用 GROUP_CONCAT()[Return a concatenated string] 把有選擇過的 id 合併成一行。
// 註: 想要內容列出 id=1, name=A,B,C

$sql ="SELECT a.id, a.title, a.content, c.name, GROUP_CONCAT(t.category_id) 
FROM articles AS a 
LEFT JOIN taxonomy AS t ON a.id=t.article_id 
LEFT JOIN categories AS c ON t.category_id=c.id 
WHERE a.id = $id";

$result = $pdo->query($sql);
$row = $result->fetch();

// GROUP_CONCAT 取得並把重複的 column 的值用 , 接起來。
$category_list = $row['GROUP_CONCAT(t.category_id)'];

// 移除分隔符變成陣列 explode($delimiter ,$string)
$checked_arr = explode(',', $category_list);


        // ...顯示撈出的資料


// 這裡要顯示分類的選項，撈出所有分類的資料。
$sql_category = "SELECT * FROM categories ORDER BY id ASC";
$result_category = $pdo->query($sql_category);
if($result_category->rowCount() > 0) {

// 用 fetchAll(PDO::FETCH_KEY_PAIR) 取得鍵值的配對
$cat_option_arr = $result_category->fetchAll(PDO::FETCH_KEY_PAIR);

    // 確定印出的結果是我們要的 key => value。

    // Array
    // (
    //     [3] => JavaScript
    //     [16] => PHP
    //     [17] => 心情記事
    //     [18] => 感情交流
    //     (略)...
    // )

    foreach ($cat_option_arr as $id => $name) {
        $checked = '';
        if(in_array($id, $checked_arr)) {
            $checked = "checked";
        }
        print "
        <div class='form-check'>
            <input name='category_id[]' class='form-check-input' type='checkbox' value='$id' id='check_$id' $checked/>
            <label class='form-check-label' for='check_$id'>$name</label>
        </div>";
    }
}
```

參考來源: [Get checked Checkboxes value with PHP](https://makitweb.com/get-checked-checkboxes-value-with-php/)
[PHP ： in_array](https://sites.google.com/site/phplearnmark/php/php-zhi-ling-qing-dan/zhen-lie-han-shi/php-in_array)


- 不一樣的方式(有空嘗試一下)
[Re-introducing PDO: the Right Way to Access Databases](https://www.sitepoint.com/re-introducing-pdo-the-right-way-to-access-databases-in-php/)
```php
$names = explode(',', $names);
$placeholder = implode(',', array_fill(0, count($names), '?'));
$statement = $connection->prepare("SELECT * FROM users WHERE name IN ($placeholder)");
$statement->execute([$names]);
// 儘管外觀可怕，但第2行只是創建了一個問號數組，其中包含與names數組一樣多的元素。然後它連接該數組中的元素並,在它們之間放置- 有效地創建類似的東西?,?,?,?。由於我們的names數組也是一個數組，傳遞它execute()按預期工作 - 第一個元素綁定到第一個問號，第二個元素綁定到第二個問號，依此類推。
```




1. 假如我們要替 Blog 增加搜尋關鍵字的功能，首先就是把需要的資料撈出來。

```
$sql = "SELECT * FROM articles A WHERE draft=0 AND (title like ? OR content like ?) ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(["%$q%", "%$q%"]);

if(!$stmt->rowCount()){
      #code...
        } else {
      #code...
}
```
- 這個時候就會發現符合關鍵字的標題或內文，資料就會很多很多，就可以使用 PHP 處理字串的函式來處理過多的文字。

- `str_replace()`: 可以用來取代字串的內容。(區分大小寫)
-  str_replace(尋找的字串,取代成的字串,原字串)
- `str_ireplace()`:(不區分大小寫)

```php
// 資料庫撈出來的 content
$content = $row['content']; 
 // 把被搜尋的字串，用 <mark> 包起來。
$replace_content = str_ireplace($q, "<mark>$q</mark>", $content);
 // 從第1個字元開始擷取到200個字元
$result_content = mb_substr($replace_content, 0, 100, 'UTF-8');
```