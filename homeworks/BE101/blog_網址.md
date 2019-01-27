
### blog 網址

http://enter3017sky.tw/blog/index.php




- `index.php`:首頁。撈出標題、文章內容(200個字)，點按 _READ MORE_ 可進入該文章。

- `archives.php`: 文章總覽。顯示所有發佈文章(草稿不顯示)。

- `categories.php`: 分類總覽。顯示所有分類以及分類的數量(草稿的文章不統計)。
    - 點擊分類可顯示相關的文章。

- `article.php`: 文章。可以輸出 markdown 的格式。底下可以簡易的訪客留言。[PHP Markdown Parser 函式庫](https://blog.longwin.com.tw/2015/07/php-markdown-parser-library-class-2015/)。
    - 新增功能：用 SESSION 存取訪客留言的暱稱，可以清除訪客暱稱。而 Blog 版主留言時顯示自己的暱稱。
    - 新增功能：使用者登入時顯示編輯按鈕。

- `about.php`: 關於我。

- `admin.php`: 管理頁面。會顯示包括草稿的所有文章。可編輯、可刪除(模擬刪除)。
    - `add.php`: 新增文章。
    - `update.php`: 編輯文章。可選擇發佈或草稿的狀態。
    - `admin_category.php`: 分類管理。
         - `add_category.php`: 新增分類。
         - `admin.php`: 管理文章。
         - `edit_about.php`: 編輯關於我。
- `handle_search.php`: 搜尋文章。


