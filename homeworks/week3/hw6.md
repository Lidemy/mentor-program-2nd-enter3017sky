## 請找出三個課程裡面沒提到的 HTML 標籤並一一說明作用。

- `<nav>` : 網頁中提供導航欄連結的區域，常跟無序清單單配使用。

- `<article>` : 用來放網頁的主要內容，文章的區域。

- `<input>` : 建立表單文字輸入欄位。


## 請問什麼是盒模型（box modal）

> Box Model 是製作網頁的基礎，每個元素都像是一個個的盒子。
盒子由內而外，content, padding, border, margin, 像是洋蔥一樣以層層疊疊的關係建立起來。

- Content: 內容。
- Padding: 內邊界距離；內邊距；內距；留白。
- Border: 邊框。
- Margin: 外邊界距離；外邊距；邊界。

## 請問 display: inline, block 跟 inline-block 的差別是什麼？

> display 屬性可以讓你將一個行內元素轉變成區塊元素，或區塊變成行內元素，也可以隱藏元素。
- block: 變成區塊元素的模式。
  - 佔滿整行(寬度)的區塊，無法與其他元素併排在同一行，可以設定寬度(width)與高度(height)。
- inline: 變成行內元素的模式。
  - 佔據內容(文本)本身的大小，可以與其他元素並排。無法設定寬度(width)與高度(height)，也無法設定上下的 margin。可以設定左右 margin、全部的 padding（元素會被左右 padding 影響，上下不會，但如果有 border，會被撐開）。
- inline-block: 這可以像行內元素一樣與其他元素並排，但保有區塊元素的模式。
- none: 將元素隱藏起來，不會顯示。


## 請問 position: static, relative, absolute 跟 fixed 的差別是什麼？

- 正常流向：`position: static;`: 即該元素出現在文檔的常規位置，不會重新定位。
- 相對定位：`position: relative;`: 相對於原本的 參考點 做定位。使用 top 、 bottom、 left 、 right 的屬性來偏移其文檔的常規位置。
- 絕對定位：`position: absolute;`: 以上層非 static(預設定位)的父元素為定位基準。
- 固定定位：`position: fixed;`: 固定定位，從瀏覽器窗口做定位，滾輪的滾動還是會固定到相同位置。