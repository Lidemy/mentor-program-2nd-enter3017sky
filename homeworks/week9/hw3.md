### hw3：Event Loop

在 JavaScript 裡面，一個很重要的概念就是 Event Loop，是 JavaScript 底層在執行程式碼時的運作方式。請你說明以下程式碼會輸出什麼，以及盡可能詳細的解釋原因。

```js
console.log(1)
setTimeout(() => {
  console.log(2)
}, 0)
console.log(3)
setTimeout(() => {
  console.log(4)
}, 0)
console.log(5)
```

---

首先我們都知道「JavaScript 是單執行緒(single threaded)的程式語言，而所有的程式碼都會在堆疊(stack)中被執行，而且一次只會執行一件事情(one thing at a time)。」

想當然，輸出肯定是 12345，一看就知道！假如 setTimeout() 參數給了一秒，就是先跑 1，一秒後跑 2，以此類推。結果自己敲一敲 code，實際跑了一次，才發現跟想像中的完全不一樣！

之前不明白同步(synchronous)與異步(asynchronous)是什麼意思，為什麼單執行緒的 JavaScript 可以非同步的執行其他任務。後來理解了，JavaScript 是單執行緒的，之所以可以非同步的執行是因為 JavaScript 只是瀏覽網頁過程中的一部分，而瀏覽器提供的 API 讓 JavaScript 使用，就可以做到異步(asynchronous)執行了。

JavaScript 在執行程式碼的時候，執行堆疊會記錄目前執行到程式碼的哪個部分，程式碼會被添加到堆疊的最上方，程式碼執行完畢之後，最上面的堆疊會被移除，然後再往下執行。

如果只能以同步的方式執行程式碼的話，假如有某個程式碼的片段需要等待很長一段時間，它就會一直卡在執行堆疊中，而底下其他的 stack 就不會繼續執行 （後進先出 LIFO），這種「卡住」的現象，被稱作阻塞（blocking），會導致瀏覽器無法重新渲染、瀏覽器停滯，使用者體驗將會變得非常不好。

所以透過瀏覽器提供的 API 來處理非同步的程式碼，需要等待的程式碼從堆疊中移除，讓 Web APIs 處理非同步的部分，讓同步任務得以繼續執行，而等到回應的程式碼將被移到任務佇列(task queue)。最後如果執行堆疊的空了，代表同步任務執行完畢，而在佇列中等待的非同步任務，將以 FIFO （先進先出） 的方式依序被丟回 call stack 執行。

這整個過程、運行的機制稱之為事件循環(event loop)。

---
以下用圖來簡單的說明：

1.程式碼跑到 `console.log(1)` 時，會被放到堆疊中執行，執行後而輸出 1， `console.log(1)` 被移出堆疊。

```js
// result=>
// console.log(1) 被新增到執行堆疊
// call stack                  // Web APIs
|                |  → → →   |                  |
|                |          |                  |
|                |  event   |                  |
|                |  loop    |__________________|
|                |              ↓ ↓ ↓
|                |_____________________________
| console.log(1) |←
|                |←
|----------------|-----------------------------
                            // task queue
```

2. 接著執行到 `setTimeout()`，`setTimeout()` 就會被新增到執行堆疊，而 WebAPIs 會替 `setTimeout()` 新增一個定時器(時間到了移到任務佇列的定時器)，`setTimeout()` 從執行堆疊移出、再移入任務佇列(task queue)。(setTimeout 被移出後，接著新增 `console.log(3)` 到執行堆疊)。
    - 這個步驟反覆到 `console.log(5)` 被新增、執行、然後移出執行堆疊，此時執行堆疊空了，換任務佇列的 `console.log(2)`、`console.log(4)`，依照 FIFO 的模式執行。

```js
// result=>  1
// console.log(1) 從執行堆疊移出
// setTimeout     新增到執行堆疊

// call stack                  // Web APIs
|                |  → → →   |                  |
|                |          |                  |
|                |  event   |                  |
|                |  loop    |__________________|
|                |              ↓ ↓ ↓
|                |_____________________________
| setTimeout(1)  |←
|                |←
|----------------|-----------------------------
                            // task queue


// result=>  1
// setTimeout      從執行堆疊移出
// console.log(3)  新增到執行堆疊
// Web APIs        新增 Timer(cb1)
// call stack                  // Web APIs
|                |  → → →   |                  |
|                |          |                  |
|                |  event   |    Timer(cb1)    |
|                |  loop    |__________________|
|                |              ↓ ↓ ↓
|                |_____________________________
| console.log(3) |←
|                |←
|----------------|-----------------------------
                            // task queue

// result=>  1 3
// console.log(3)  從執行堆疊移出
// setTimeout2     從執行堆疊移出
// Web APIs        新增 Timer2(cb)
// console.log(2)  新增到任務佇列

// call stack                  // Web APIs
|                |  → → →   |                  |
|                |          |                  |
|                |  event   |   Timer2(cb)     |
|                |  loop    |__________________|
|                |              ↓ ↓ ↓
|                |_____________________________
| console.log(5) |←
|                |← console.log(2)
|----------------|-----------------------------
                            // task queue

```

```js

// result=>  1 3 5
// console.log(5)  從執行堆疊移出
//  call stack   空了，佇列的 console.log(2) 移出
// console.log(2)  新增到執行堆疊

// call stack                  // Web APIs
|                |  → → →   |                  |
|                |          |                  |
|                |  event   |                  |
|                |  loop    |__________________|
|                |              ↓ ↓ ↓
|                |_____________________________
| console.log(2) |←
|                |←  console.log(4)
|----------------|-----------------------------
                            // task queue

```

```js
// result=>  1 3 5 2
// console.log(2)  從執行堆疊移出
// console.log(4)  新增到執行堆疊，執行

// call stack                  // Web APIs
|                |  → → →   |                  |
|                |          |                  |
|                |  event   |                  |
|                |  loop    |__________________|
|                |              ↓ ↓ ↓
|                |_____________________________
| console.log(4) |←
|                |←
|----------------|-----------------------------
                            // task queue

```