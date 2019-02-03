## CSS 預處理器是什麼？我們可以不用它嗎？

用程式化的方式寫 CSS，最後 compile 成真的 CSS，

可以不用它。但是可能隨著專案越來越大，使用預處理器可以讓我們更加方便。

## 請舉出任何一個跟 HTTP Cache 有關的 Header 並說明其作用。

- `Expires` 方法1: 要達成上述的功能，可以在 HTTP Response Header 裡面加上一個 Expires 的字段，裡面就是這個 Cache 到期的時間，例如說：
    - `Expires: Wed, 21 Oct 2017 07:28:00 GMT`
    - 打開 Chrome dev tool，就會看到它寫著：`Status code 200 (from disk cache)`，代表這個 Request 其實沒有發出去，Response 是直接從 disk cache 裡面拿的。
    - 如果使用者活在未來(時間設定在未來的時間)，瀏覽器會認為所有的 cache 是過期的，就會重新發送 Requst。
    - Expires 是 HTTP 1.0 就存在的 Header。

- `max-age` 方法2: 為了解決上述 Expires 會碰到的問題，換個方式思考，以相對時間來看的話，就不會發生了。
    - HTTP 1.1 有一個新的 header 出現了，叫做：`Cache-Control`。

- `Last-Modified`、`Last-Modified-Since`
    - 在 Server 傳送 Response 的時候，可以多加一個Last-Modified的 Header，表示這個檔案上一次更改是什麼時候。而當快取過期，瀏覽器下次再發送 Request 的時候，就可以利用這個資訊，改用If-Modified-Since來跟 Server 指定拿取：某個時間點以後有更改的資料。


## Stack 跟 Queue 的差別是什麼？

不同類型的資料結構。(data structure：電腦中儲存、組織資料的方式。)

舉例來說，Stack 堆疊 像是疊書本、拿盤子一樣，用圖像的方式思考，你可能會把它想成是垂直的，所以你只能從最上面的開始拿，先放下去的先拿起來。FILO(First in las out)。

而 Queue 佇列，就像是排隊一樣，FIFO(first in first out)，優先去排隊的人，優先出去。
這兩種資料結構，有不同的方法來模擬他們的行為。
Stack: 用 push() 放入堆疊的頂部，用 pop() 從堆疊的頂部移出。
Queue: 用 push() 排入佇列的尾巴，用 shift() 從佇列的前面移出。



## 請去查詢資料並解釋 CSS Selector 的權重是如何計算的（不要複製貼上，請自己思考過一遍再自己寫出來）

- 在同一個元素上，設定兩個不同的 CSS，權重愈高的會優先蓋過其他的。
- 在同一個 CSS 檔案裡面，權重分數一樣的前提下，越下面的會覆蓋上面的。
- 在同一個 HTML 裡面 CSS 擺放的位置也會影響，inline style > CSS 寫在`<head></head>`之間 > 外部連結link放置在下面 >  外部連結link放置在上面。

CSS 權重計算的方式為：

```css
!Important      1.0.0.0.0
inline-style      1.0.0.0
ID                  1.0.0
Class/attr/pseudo   0.1.0
Element/pseudo      0.0.1
```

Important，inline-style 的使用上要很小心，也不太會這樣用，會照成很多不必要的麻煩。
權重計算可以想成是階級的關係，只有「Important 能超越 Important」，記住這個口訣之後，其他的就沒問題了。
所以當一個元素遇到兩個 CSS 的選擇器的時候，相同的階層去比較，假如 !Important 沒有 -> 行內沒有 -> id 沒有，結果 class 選擇器假如有兩個，分數也相同，那會繼續往下比分數，來判斷是哪一個選擇器影響了元素。

