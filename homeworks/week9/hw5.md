## CSS 預處理器是什麼？我們可以不用它嗎？


## 請舉出任何一個跟 HTTP Cache 有關的 Header 並說明其作用。


## Stack 跟 Queue 的差別是什麼？


## 請去查詢資料並解釋 CSS Selector 的權重是如何計算的（不要複製貼上，請自己思考過一遍再自己寫出來）


CSS 權重計算的方式為：
!Important      1.0.0.0.0
inline-style      1.0.0.0
ID                  1.0.0
Class/attr/pseudo   0.1.0
Element             0.0.1

在同一個 CSS 檔案裡面，全中分數一樣的前提下，越下面的會覆蓋上面的
在同一個 HTML 裡面，