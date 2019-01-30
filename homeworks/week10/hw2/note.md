## week10-2 note

hw2：Webpack
Webpack的目的其實就是讓前端也能夠像Node.js那樣，支援module.exports以及require。

為了讓你體驗Webpack，在這個作業中你只要做以下簡單的幾件事情就好：

寫一個檔案叫做utils.js，裡面有一個叫做add的function
寫一個檔案叫做 index.js
在index.js裡面引入add這個function並且輸出add(10, 3)
用Webpack 把以上檔案打包產生出 bundle.js


---


1. 使用 yarn 把這個作業當作專案來做，所以首先建立一個目錄 _webpack-dome_，然後輸入 `yarn init` 初始化這個作業。

2. 這個作業的主角是 _webpack_，所以用 `yarn add webpack webpack-cli --dev` 來安裝 _webpack_, _webpack-cli_ 這兩個插件。

3. 然後依照 webpack 的範例來設定，首先 `touch webpack.config.js` 新增一個 webpack 的設定檔，然後貼上官方的範例。
    - entry: 入口點
    - output.path: 設定 bundle 完成的檔案路徑。
    - output.filename: 設定 bundle 完成的檔案名稱。

```js
const path = require('path');

module.exports = {
  entry: './src/index.js',
  output: {
    path: path.resolve(__dirname, 'dist'),
    filename: 'index.bundle.js'
  }
};
```

4. 照著作業的需求在 `src` 這個目錄底下新增 `index.js`、`utils.js` 這兩個檔案。
    - _utils.js_ 裡面新增 `function add(...){...}`，用 `exports` 輸出給其他 `.js` 檔案用。
    - _index.js_ 裡面用 `import` 來引入 `export`。

5. 可以加入更多的 Plugins，譬如 _babel_ 等等。

---

### 執行腳本 yarn run/npm run

- 在 _package.json_ 加入以下的設定，讓我們可以執行 `yarn run [watch/start/deploy]` 就可以直接執行 webpack 相關的指令。

```js
"scripts": {
    "watch": "webpack --mode development --watch",
    "start": "webpack --mode development",
    "deploy": "webpack --mode production"
},
```

---

## note

#### `Module not found: Error: Can't resolve 'file' in 'directory'`

- 可能是某個檔案裡的 _import_ 的檔案名稱錯誤、或者路徑錯誤

#### export, import

- 用 export 可以指派函式、物件或變數，透過 import 宣告給外部檔案引用。

```js
// 預設 export
// example 1
const add = (a, b) => a + b
export default add

// example 2
export default function add(a, b) {
    return a + b
}

// 其他 export
export { findMin, findSmallCount }
```

- import 宣告用於引入由另一個模塊所導出的綁定。被引入的模塊，無論是否宣告 strict mode，都會處於該模式。

```js
// add 是預設, * as u 所有的檔案取別名為 u
import add, * as u from './utils.js'
console.log(u.findMin([12, 35, 123, 1, -1]))
console.log(u.findSmallCount([12, 35, 123, 1, -1], 1))
console.log(add(10, 3))

// 預設的檔案不能再大括號，非預設的要用大括號
import add, { findMin, findSmallCount } from './utils.js'
console.log(findMin([12, 35, 123, 1, -1]))
console.log(findSmallCount([12, 35, 123, 1, -1], 1))
console.log(add(10, 3))
```

更多範例：[export | MDN](https://developer.mozilla.org/zh-TW/docs/Web/JavaScript/Reference/Statements/export)、[import | MDN](https://developer.mozilla.org/zh-TW/docs/Web/JavaScript/Reference/Statements/import)

參考資料：
[JavaScript ES6的import, export, default使用方法](https://www.nctusam.com/2017/11/12/368/)
[[譯 + 補充] Webpack 2 學習筆記](https://andyyou.github.io/2017/02/17/webpack-2-beginner-guide/)