## 資料庫欄位型態 VARCHAR 跟 TEXT 的差別是什麼

- TEXT: 大型的純文字欄位。 text 不設置長度， 當不知道屬性的最大長度時，適合用 text。當不知道最大長度時，適合用 text。

-  VARCHAR: 是可變長度，可以設置最大長度；適合用在長度可變的屬性。會比較省空間。


## Cookie 是什麼？在 HTTP 這一層要怎麼設定 Cookie，瀏覽器又會以什麼形式帶去 Server？

1. Cookie 是網站為了辨別用戶身分而儲存在客戶端上的資料，常用來放帳號密碼等，使用者輸入過的資訊。

2. 譬如說在留言板登入之後，Server 會回應給 Browser "Set-Cookie"， Response Headers 裡面就會看到 Set-Cookie 以及相關的資訊，瀏覽器接收到 Set-Cookie 指令時，會將 Cookie 的名稱與值儲存在 Cookie 的存在區。

每當 Browser 再次發出 HTTP Request 指令到 Server 時，就會比對目前在 Browser 內的 Cookie 存放區有沒有「該網域」、「該目錄」、「過期時間尚未過期」且「是否為安全連線」的 Cookie，如果沒什麼問題的話，Request Header 中 可以看到 Cookie 以及相關的資訊。


## 我們本週實作的會員系統，你能夠想到什麼潛在的問題嗎？

- 會有 XSS(Cross-Site Scriptng)這個漏洞，能在網頁上執行 html 的標籤。

- 會被惡意執行 SQL 的指令。

- 密碼的安全問題，因為存放在資料庫裡面的密碼沒有經過處理。
