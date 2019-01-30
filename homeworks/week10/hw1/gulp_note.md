# week10 Gulp 相關練習

> 參考資料：[用Yarn取代npm加速開發](https://ithelp.ithome.com.tw/articles/10191745) 
> 官方網站：[Yarn](https://yarnpkg.com/zh-Hans/)

### Yarn 常用指令

- `yarn init` 初始化專案
- `yarn add [paakage] --dev`:儲存在 json.package中的 devDependencies。
- `yarn remove [package]` 移除套件。
- `yarn list --pattern gulp`: 顯示與 gulp 相關的檔案。

---

### 錯誤排除: [TypeError: dest.on is not a function](https://stackoverflow.com/questions/38253949/gulp-imagemin-dest-on-is-not-a-function-error)

原因：安裝 `postcss + autoprefixer` 導致 `dest.on is not a function`，後來看到上面那篇文章，因為安裝不正確的插件，沒有返回 stream。

---

## 使用 autoprefixer

### 方法一：安裝 [gulp-postcss](https://yarnpkg.com/zh-Hans/package/gulp-postcss) 加上 [autoprefixer](https://yarnpkg.com/zh-Hans/package/autoprefixer)

```js
// example
var gulp = require('gulp');
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');
var cssnano = require('cssnano');

gulp.task('css', function () {
    var plugins = [
        autoprefixer({browsers: ['last 1 version']}),
        cssnano()
    ];
    return gulp.src('./src/*.css')
        .pipe(postcss(plugins))
        .pipe(gulp.dest('./dest'));
});
```

---

### 方法二：直接用 [gulp-autoprefixer](https://yarnpkg.com/zh-Hans/package/gulp-autoprefixer)

```js
const gulp = require('gulp');
const autoprefixer = require('gulp-autoprefixer');
const plugin = {
            browsers: ['last 2 versions'],
            cascade: false
        }
gulp.task('default', () =>
    gulp.src('src/app.css')
        .pipe(autoprefixer(plugin))
        .pipe(gulp.dest('dist'))
);
```

---

## 使用 gulp 將 ES6 轉換成 ES5

### 方式一

- 1. 需要先安裝 gulp 與 Babel 提供的 gulp-babel、babel-core、babel-preset-env
- 2. 還是要建立 `.babelrc` 檔案 :

```js
// .babelrc
{
  "presets": ["env"]
}

// gulpfile.js
// babel() 裡面就不用打參數了
gulp.task('js', function () {
    return gulp.src(paths.scripts)
        .pipe(babel())
        .pipe(gulp.dest('public/js'));
})
```


### 方式二

不用建立 `.babelrc` 檔案，但是要打參數。

```js
gulp.task('js', function () {
    return gulp.src(paths.scripts)
    // .pipe(jshint())
        .pipe(sourcemaps.init()) // 製作 sourcemaps
        .pipe(concat('all.min.js')) // 加上 prefixes
        .pipe(babel({
            presets: ['env']
        }))
        .pipe(uglify())
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('public/js'));
})
```

### gulp-uglify 壓縮 js 檔案與 npx babel-node


- 在練習 import 與 export 指令的時候，發現 npx babel-node 一直出現錯誤。

```js
throw new Error(`${msg(loc)} must be an array, or undefined`);
^
Error: .presets must be an array, or undefined
```

- 然後根據 [Babel 官方文件](https://new.babeljs.io/docs/en/next/babel-preset-env.html#how-it-works)說明，.babelrc 裡面要設定 `"node": "current"`，才有支援 node 的編譯功能，`npx bael-node xxx.js` 才可以運作。

```js
{
    "presets": [
        ["env", {
            "targets": {
                "node": "current"
            }
        }]
    ]
}
```

- 後來跑了 gulp 測試一下，登愣，一邊好了另外一邊出現錯誤訊息。

`GulpUglifyError: unable to minify JavaScript Caused by: SyntaxError: Unexpected token: keyword (const)`

- 後來找到這篇文章 [How to solve this minification error on Gulp?](https://stackoverflow.com/questions/38886840/how-to-solve-this-minification-error-on-gulp)，總之，換了其他的插件（gulp-uglify-es、gulp-terser）之後就沒問題了。


---

<!-- note -->

```js
如果使用 gulp-uglify， `.babelrc` 如果不是下面那樣的話，會出現錯誤。
後來發現只有以下那樣的話，跑 `npx babel-node xxx.js` 指令時會顯示錯誤。
{
    "presets": "env"
}
```

```js
 gulp-uglify-es
根據官方說明，後面要加 `.default`
const uglify = require('gulp-uglify-es').default
```