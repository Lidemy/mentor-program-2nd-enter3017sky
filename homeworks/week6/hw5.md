## 請說明 SQL Injection 的攻擊原理以及防範方法

 - SQL Injection 就是指 SQL 語法上的漏洞，通常指發生在網頁與資料庫之間的安全漏洞。攻擊方式簡單且不需要倚靠任何軟體或程式就可以達成，藉由特殊字元，改變語法上的邏輯，譬如駭客透過輸入的字串中夾帶 SQL 的指令，讓資料庫誤認為是正常的指令而執行，讓攻擊者取得資料庫內容或其他目的。
  - 常見的攻擊手法：
    1. Authorization Bypass（略過權限檢查）
      - 讓攻擊者可以不需要驗證帳號密碼的前提下就可以登入 DataBase
      - `'OR 1=1 --`
         - `'` 是將內容關閉
         - `OR`	是指或是的條件
         - `1=1` 恆正 true
         - `--` 將後方接著的內容註解掉
![image](http://ithelp.ithome.com.tw/upload/images/20170214/20103559evbYZgJL2b.png)
    2. Injecting SQL Sub-Statements into SQL Queries（注入 SQL 子語法）
    - 在原有指令加上 __`;`__ 繼續執行下一行指令。
    3. Exploiting Stored Procedures（利用預存程序）
      -Stored Procedures（預存程序）是將又臭又長又常用的 SQL 語法寫成一組程序並儲存起來，以供後續呼叫相同程序時不必再將完整個 SQL 語法重打一次，攻擊者亦可透過呼叫這些 Stored Procedures 進而對 DataBase 進行攻擊。


 - 防範方法：
   - Prepared Statements: Prepared Statment 是將SQL語句先傳入SQL 編譯器進行一次編譯,將原本該給使用者輸入的地方用特殊符號取代，再將使用者輸入作為參數傳入，不是以字串輸入，從而避免被SQL injection，這種作法又稱參數化查詢
   - 使用 Regular expression 驗證過濾輸入值與參數中惡意代碼。
   - 限制輸入字元格式並檢查輸入長度。
   - 資料庫設定使用者帳號權限，限制某些管道使用者無法作資料庫存取。


參考資料:
 - [SQL 資料隱碼攻擊 SQL injection](https://ithelp.ithome.com.tw/articles/10189201)
 - [為什麼用PreparedStatement還會有SQL injection?](https://www.qa-knowhow.com/?p=4172)

## 請說明 XSS 的攻擊原理以及防範方法

 - Cross Site Scripting (XSS)：跨網站腳本攻擊，是一種可威脅任何網站的應用形式，透過擷取使用者的cookie資料，讓攻擊者取得網站的管理權限，或允許惡意使用者將程式碼注入到網頁上，其他使用者在觀看網頁時就會受到影響。

以攻擊的方式分類可分為三種：
 - Stored XXS (儲存型 XXS)：
   - 又稱 持續型。
   - 注入的程式碼會被儲存在網站的伺服器。
   - Stored XSS 案例中，不可信賴的來源通常為資料庫或其它後端資料庫的儲存區。
   - 當其他用戶正常瀏覽網頁時，網站從資料庫讀取了非法用戶存入的非法資料。

 - Reflected XSS (反射型 XXS)：放在網址列的稱為反射型。當用戶點擊一個惡意鏈接，或者提交一個表單，或者進入一個惡意網站時，注入腳本進入被攻擊者的網站。Web服務器將注入腳本，比如一個錯誤信息，搜索結果等返回到用戶的瀏覽器上。瀏覽器會執行這段腳本，因為，它認為這個響應來自可信任的服務器。
   - 又稱 非持續性。
   - 最普遍的XSS攻擊類型。
   - 當攻擊用的指令碼不在目標網站本身內，而是在攻擊目標網站之外的其他位置。
 - DOM-Based XSS (基於 DOM 的類型)：被執行的惡意腳本會修改頁面腳本結構。

 - 防範方法：
   - 以使用者角度來看：
     - 使用經常更新、安全高的的瀏覽器： 例如 Google Chrome 瀏覽器安全性很高，會擋掉 `alert('hello')`、或 `<script>alert('123')</script>` 這些類型的程式碼。
     - 關閉瀏覽器的 JavaScript 的選項。
   - 以開發者的角度來看：
     - 改變 input 欄位的長度，提升注入程式碼的難度。
     - 使用者輸入時過濾特殊的字元 ```""''<>()$/&`。
     - 將使用者所提供的內容在輸出時做 Encoding，很多程式語言都有提供跳脫字元的函式，以 PHP 舉例，用 `htmlspecialchars()` 函式將 html 標籤跳脫字元，轉換成為純文字，

## 請說明 CSRF 的攻擊原理以及防範方法

- 跨站請求偽造，簡單地說，是攻擊者通過一些技術手段欺騙用戶的瀏覽器去存取一個自己曾經認證過的網站並執行一些操作（如發郵件，發訊息，甚至財產操作如轉帳和購買商品）。由於瀏覽器曾經認證過，所以被存取的網站會認為是真正的用戶操作而去執行。這利用了web中用戶身分驗證的一個漏洞：簡單的身分驗證只能保證請求發自某個用戶的瀏覽器，卻不能保證請求本身是用戶自願發出的。
- 目標：通過一個包含惡意請求的圖像利用已經驗證過的用戶身分實現惡意請求。
 - 原理：攻擊者盜用你的身分，以你的名義發送惡意請求。


防範方法：
 - 避免使用 GET 方法傳送參數及操作新增/更新/刪除動作。
 - 避免使用 HTTP Referer Header 來驗證來源要求者。(Referer 可以偽造)
 - 使用 token 來驗證來源要求者。( SessionID + salt, 亂數值 )
 - Double Submit Cookie。ex. `當使用者按下 submit 的時候，server 比對 cookie 內的 csrftoken 與 form 裡面的 csrftoken，檢查是否有值並且相等，就知道是不是使用者發的了。`
 - browser 本身的防禦。ex. Google 在 Chrome 51 版的時候正式加入了這個功能：SameSite cookie。


參考資料：
- [跨站請求偽造](https://sls.weco.net/node/24443)
- [讓我們來談談 CSRF](https://blog.techbridge.cc/2017/02/25/csrf-introduction/)

## 請舉出三種不同的雜湊函數
 - MD5
 - SHA-1
 - SHA-256
 - bcrypt


## 請去查什麼是 Session，以及 Session 跟 Cookie 的差別

1. 由於 HTTP 協議是無狀態特性，所以 Session 就像一個難以偽造的通行證機制，透過它來辨別使用者。

2.

 ### Cookie
  - Cookie 指某些網站為了辨別用戶身分，將用戶的訊息儲存在瀏覽器(client)的技術。
  - cookie 由於儲存在 client 端，安全性較低。
  - 有時效性。
  - 儲存指定的 key 及 value。

 ### Session
  - Session 負責紀錄在 web server 上的使用者訊息。Session 機制會在一個用戶完成身分認證後，存下所需的用戶資料，接著產生一組對應的 id，存入 cookie 後傳回用戶端。
  - Session 安全性較高。
  - Session 使用 [uuid](https://www.wikiwand.com/zh/%E9%80%9A%E7%94%A8%E5%94%AF%E4%B8%80%E8%AF%86%E5%88%AB%E7%A0%81)。

資考資料：

[Cookie/Session的機制與安全 - 掃文資訊](https://hk.saowen.com/a/342d11ae529c1969cfb50cbcbf85d96d73c48d8b85ba92ddc16f62f7f2a15bb6)
[正確理解HTTP短連接中的Cookie、Session和Token](http://www.52im.net/thread-1525-1-1.html)
[cookie 和session](http://wiki.jikexueyuan.com/project/node-lessons/cookie-session.html)

## `include`、`require`、`include_once`、`require_once` 的差別

 - include 和 require 語句是相同的，除了錯誤處理方面：
     - require 會生成致命錯誤（E_COMPILE_ERROR）並停止執行檔案。
     - include 只生成警告（E_WARNING），並且檔案會繼續執行。
  - 而 include_once 和 require_once 在執行前，會先檢查該檔案是否被引入過，如果有就不會在引入。