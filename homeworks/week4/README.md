# 作業

## hw1：計算機

![](calculator.png)

可參考範例：[https://lidemy.github.io/mentor-program-kristxeng/homeworks/week4/hw1/](https://lidemy.github.io/mentor-program-kristxeng/homeworks/week4/hw1/)（第一期學生 Kris 的作品）

請用你在之前學會的網頁技術（HTML, CSS, JavaScript）打造出一個簡單的計算機，功能如下：

1. 要有 0 到 9
2. 要有加減乘除
3. 要能夠清空

計算機這一題其實要難可以到很難，這個作業的目的只是想讓你熟悉基本操作而已，所以你可以用以下的範例來測試，能夠通過就好：

### 測試1

1. 按下 123
2. 按下 +
2. 按下 456
3. 按下 =
4. 出現 579

### 測試2

1. 按下 20
2. 按下 -
2. 按下 25
3. 按下 =
4. 出現 -5

## hw2：仿 Google 表單

請實作出你們當初報名時所填寫的表單：https://docs.google.com/forms/d/e/1FAIpQLSeOTy7j1OjgI-q9xYaiGCJJn5w2TkpB1JNZZXXQwqCt3SsDsg/viewform

![](form.png)

可參考範例：[https://lidemy.github.io/mentor-program-pychiang/homeworks/week4/hw2/](https://lidemy.github.io/mentor-program-pychiang/homeworks/week4/hw2/)（第一期學生 pychiang 的作品）

背景隨便用一個顏色就好了，重點是實做出表單內容以及驗證。UI 可以不用完全一樣，只要功能有做出來就好，UI 只是讓你參考的。

功能如下：

1. 文字輸入框可以選擇必填或是非必填
2. 送出表單時，必填的地方如果空白，要能夠把背景變紅色並且提示使用者
3. 成功提交之後，把表單的資料輸出在 console，並且用`alert`跳出提示即可

## hw3：仿 Twitch 頻道頁面

請串接 [Twitch API v5](https://dev.twitch.tv/docs/v5/)，顯示出 League of Legends 目前正在直播的前 20 個實況。

![](twitch.png)

1. [Twitch API](https://dev.twitch.tv/docs/v5/)裡面有一個 API 是可以拿到現在正在直播的某個遊戲底下的資料，API 的描述是「Gets a list of live streams.」，看到這行就代表你找對 API 了。
2. API 要帶的參數有一個 `game` 的欄位，請帶`League%20of%20Legends`
3. 請顯示 20 個實況，不多不少，要剛好 20 個

（基本上這題就是直接照搬我之前在別的地方出過的[作業](https://github.com/aszx87410/frontend-intermediate-course/blob/master/homeworks/hw4.md)）

## hw4：化繁為簡

每次在操縱 DOM 物件時，都需要輸入`document.querySelector()`，重複幾次之後會覺得有點煩瑣，所以我們可以實作出一個簡單的 function 叫做`q`，可以快速的選取到你要的元素，接著利用選到之後的這個物件進行常見的操作（`hide`跟`show`）

可以參考以下範例，只要能夠按照以下範例運行即可：

``` js
var element = q('.title')
element.hide() // 隱藏
element.show() // 顯示

```
## hw5：簡答題

1. 什麼是 DOM？
  - DOM 是 Document Object Model 的縮寫，文件物件模型。其本質是瀏覽器提供給程式語言來操縱 HTML ，建立網頁與程式語言溝通的橋樑(API)。不是 JavsScript 的一部分。
  - DOM 提供了文件以樹狀的結構表示，描述頁面元素在瀏覽器中的組成結構，可以把這些東西看成不同的節點，譬如文件節點、標籤元件節點、屬性節點、文字節點。
  - 定義了很多種特性和方法，讓程式語言可以存取或更改每個東西。

2. 什麼是 Ajax？
  - Asynchronous JavaScript and XML，非同步的 JavaScript 與 XML 技術。指的是一套綜合了多項技術的瀏覽器端網頁開發技術。
  - Ajax 使用一種非同步處理的模型，這是表示使用者可以在瀏覽器等待資料載入的時候，仍然可以進行其他操作，讓操作更順暢，使用者體驗更好。
  - 簡單來說就是透過瀏覽器提供的 API，可以不換頁就跟 Server 溝通。
  - 應用：輸入帳號就能確認有沒有重複、留言之後不會換頁

3. HTTP method 有哪幾個？有什麼不一樣？
  - 1. GET: GET 方法請求展示指定資源。使用 GET 的請求只應用於取得資料。
  - 2. POST: POST 方法用於提交指定資源的實體，通常會改變伺服器的狀態或副作用（side effect）。
  - 3. PATCH: 更改資料。
  - 4. PUT: PUT 方法會取代指定資源所酬載請求（request payload）的所有表現。
  - 5. DELETE: DELETE 方法會刪除指定資源。
  - 6. OPTIONS: OPTIONS 方法描述指定資源的溝通方法（communication option）。
  - 7. HEAD: HEAD 方法請求與 GET 方法相同的回應，但它沒有回應主體（response body）。

4. `GET` 跟 `POST` 有哪些區別，可以試著舉幾個例子嗎？
    - GET
  1. GET 就是在網址後面加上參數，?a=1&b=2&c=3
  2. 會自動做 URL encoded
      - `encodeURIComponent` 把 `=` 轉成 `%3D`
      - `decodeURIComponent` 在把 `%3D` 變回 `=`
  3. 因為資訊會顯示在網址上，所以會有長度限制，不會放敏感資訊

    - POST
  1. POST 會把參數放在 request body 裡面
  2. 適合拿來放敏感資訊，從網址什麼都看不出來

5. 什麼是 RESTful API？
  - REST: REpresentational State Transfer
  - 直觀簡短的資源位址：URI，比如：http://example.com/resources/。
  - 傳輸的資源：Web服務接受與返回的網際網路媒體類型，比如：JSON，XML，YAML等。
  - 對資源的操作：Web服務在該資源上所支援的一系列請求方法（比如：POST，GET，PUT或DELETE）。
  - 符合這種設計風格就是 RESTful
  參考資料：[維基百科](https://zh.wikipedia.org/wiki/%E8%A1%A8%E7%8E%B0%E5%B1%82%E7%8A%B6%E6%80%81%E8%BD%AC%E6%8D%A2)
  [restful Tutorial](https://restfulapi.net/)

6. JSON 是什麼？
  - JavaScript Object Notation
  - 一種資料格式，是依照 JavaScript 物件語法的資料格式，以純文字去儲存和傳送簡單結構資料。

7. JSONP 是什麼？
  - JSON with Padding
  - JSONP 需要 Server-Side 的支援
  - 原理：利用有些 HTML 不受同源政策`<script>` 標籤可以跨網域，是資料格式JSON的一種「使用模式」，可以讓網頁從別的網域要資料。另一個解決這個問題的新方法是跨來源資源共用。
  - 但如果別人的網站被入侵了，把那段程式碼換掉的話，可能會有安全性的問題，因為你引入了別人的 `<script>`。
8. 要如何存取跨網域的 API？
  - 利用 JSONP
  - 若要開啟跨來源請求，必須在伺服器端做一些設定，像是在 Response Header 加上 Access-Control-Allow-Origin：

參考資料：[跨來源請求](https://pjchender.github.io/2018/08/20/%E5%90%8C%E6%BA%90%E6%94%BF%E7%AD%96%E8%88%87%E8%B7%A8%E4%BE%86%E6%BA%90%E8%B3%87%E6%BA%90%E5%85%B1%E7%94%A8%EF%BC%88cors%EF%BC%89/)