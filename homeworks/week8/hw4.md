## 什麼是 DNS？Google 有提供的公開的 DNS，對 Google 的好處以及對一般大眾的好處是什麼？

1.

    - DNS: Domain name servers。網域名稱系統。
    - 使用網際網路的所有設備都是透過 IP 地址互相通訊的，而 DNS 就是將網站的 IP 位址對應到使用者好理解、好記憶的名稱的伺服器。
    - 以 Google Maps 來比喻的話，網域就是地標、而 DNS 就是在地導遊，IP 位址就好比是座標(經緯度)，使用者在網址列打上網址並送出的時候，透過 DNS 將網域轉換為對應到的 IP 位址，進而讓使用者可以連到該 IP 位址的伺服器。

2.

    - 對 Google 的好處：
        - 使用數據來構建更好的服務。
        - 維護和改善我們的服務。
        - 提供個性化服務，包括內容和廣告
    - 對一般大眾的好處：
        - 加速瀏覽體驗。
        - 提升網路安全。
        - 直接取得 DNS 查詢結果。

參考資料：

- [什麼是 DNS？ – DNS 簡介 – AWS](https://aws.amazon.com/tw/route53/what-is-dns/)
- [Your Privacy  |  Public DNS  |  Google Developers](https://developers.google.com/speed/public-dns/privacy)
- [隱私權政策 – 隱私權與條款 – Google](https://policies.google.com/privacy?hl=tw)

## 什麼是資料庫的 lock？為什麼我們需要 lock？

- 一般來說，如果我們在 _查詢(query)_ 資料的時候，其他使用者可能也在對同一筆資料進行不同的 _查詢(query)_，正規的查詢沒辦法提供資料足夠的保護，很有可能會發生嚴重的問題，InnoDB 這個型態的儲存引擎提供了兩種類型的 _鎖定讀取_ 增加額外的安全性。

- 為了保持 ACID 以及避免產生 [Race condition](https://zh.wikipedia.org/wiki/%E7%AB%B6%E7%88%AD%E5%8D%B1%E5%AE%B3)。

參考資料：

- [Mysql加鎖過程詳解（1）-基本知識](http://www.cnblogs.com/crazylqy/p/7611069.html)
- [MySQL :: MySQL 8.0 Reference Manual :: 15.7.2.4 Locking Reads](https://dev.mysql.com/doc/refman/8.0/en/innodb-locking-reads.html)
- [用 SELECT ... FOR UPDATE 避免 Race condition](https://blog.xuite.net/vexed/tech/22289223-%E7%94%A8+SELECT+...+FOR+UPDATE+%E9%81%BF%E5%85%8D+Race+condition)

## NoSQL 跟 SQL 的差別在哪裡？

|  | NoSQL(not only SQL)| SQL(Structured Query Language)|
| -------- | -------- | -------- |
| 資料結構  | 動態結構  | 預定義結構 |
| 資料模型 |文件、圖形、鍵值，非結構化的大數據|標準化的資料，結構化的數據|
|數據存放方式|數據分佈在多個表中|數據合併在幾個集合中|
| 優點 |擴充易、讀寫快、成本低|事務處理(保持數據的一致性ACID)|
| API | 物件為基礎的自定義 API| 結構化查詢(SQL)|

參考資料：

- [什麼是 NoSQL？| 非關聯式資料庫，彈性的結構描述資料模型 | AWS](https://aws.amazon.com/tw/nosql/)
- [SQL vs NoSQL or MySQL vs MongoDB](https://www.youtube.com/watch?v=ZS_kXvOeQ5Y)

## 資料庫的 ACID 是什麼？

    - Transaction 的構成要件。
        - Atomicity（原子性）：事務內的多個指令像原子一樣不能被分割，如果其中一個指令執行失敗就全部失敗。實現原子性的方式，在執行指令之前儲存備份。
        - Consistency（一致性）：封閉資料庫系統內資料總數不變。
        - Isolation（隔離性）：每一筆對資料庫的請求(交易)之間相互獨立，各自執行，不會互相影響。
        - Durability（持久性）：交易完成之後，所有的交易記錄都會完整的保留下來。

參考資料:

- [Database Transaction第一話: ACID](http://karenten10-blog.logdown.com/posts/192629-database-transaction-1-acid)
- [MySQL ACID及四种隔离级别的解释](http://www.cnblogs.com/xuanzhi201111/p/4103696.html)