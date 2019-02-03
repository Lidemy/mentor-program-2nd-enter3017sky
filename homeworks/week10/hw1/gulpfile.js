//** https://gulpjs.org/API.html */

const { src, dest, series, parallel } = require('gulp');

const server = require('browser-sync').create();
const uglify= require('gulp-uglify-es').default;    /** 醜化壓縮 */
const concat = require('gulp-concat');   /** 連接檔案 */
const babel = require('gulp-babel');     /** 編譯 ES6 */

const jshint = require('gulp-jshint')

const stylus = require('gulp-stylus');   /** 編譯 stylus */
const sourcemaps   = require('gulp-sourcemaps');  /** 來源映像 */

const autoprefixer = require('gulp-autoprefixer'); // 跟以下的方式一樣
const plugins = { browsers: ['> .5%, last 2 versions'] }

/** 用物件的形式設定路徑 */
const paths = {
    src: {
        stylus: './src/css/*.styl',
        scripts: './src/scripts/*.js'
    },
    public: {
        js:'./public/js',
        css: './public/css',
    }
}

// const cssFiles = [
//     './public/css/css-3.css',
//     './public/css/css-2.css',
//     './public/css/css-1.css',
//     './public/css/index.css'
// ];

/**
hw1：Gulp
gulp 就是用來把原本的工作流程自動化的，現在請你寫一個gulp 的設定檔，依序完成以下事情：
把scss 編譯成 css，把js 用babel 轉成ES5 語法
把css 以及 js 壓縮
 */

/** 將 stylus/css 轉成 css、、sourcemaps、壓縮 */
function stylCss() {
    return src(paths.src.stylus)
        .pipe(sourcemaps.init()) // 製作 sourcemaps
        // .pipe(stylus({
        //     'include css': true
        // })) 
        .pipe(stylus({ compress: true })) // 將 styl 轉成 css 並壓縮
        .pipe(autoprefixer(plugins)) // 加上 prefixes
        .pipe(sourcemaps.write('.'))
        .pipe(dest(paths.public.css)) // directories 目錄 存放的位置
}

function js() {
    return src(paths.src.scripts)
        .pipe(jshint())
        .pipe(sourcemaps.init()) // 製作 sourcemaps
        .pipe(babel()) // 轉換語法
        .pipe(concat('all.min.js'))  // 合併檔案
        .pipe(uglify()) // 壓縮檔案
        // .pipe(sourcemaps.write('.'))
        .pipe(dest(paths.public.js)); // 將處理好的檔案存放於這
}

/** 任務定義  [gulp -T] 可查看任務列表*/

exports.styl = stylCss
exports.js = js

/** 預設任務：
 * 同時將 stylus 及 js 檔案編譯、壓縮、sourcemaps。
 */
exports.default = parallel(stylCss, js);











/** 把 public 全部的 CSS 串起來 */
// function concatCss() {
//     return src(cssFiles)
//         .pipe(concat('all.css'))
//         .pipe(autoprefixer(plugins))
//         .pipe(dest(paths.public.css))
// }

// function fn1(done){
//     console.log(1)
//     done()
// }
// function fn2(done){
//     console.log(2)
//     done()
// }
// function fn3(done){
//     console.log(3)
//     done()
// }
// function fn4(done){
//     console.log(4)
//     done()
// }
// function fn5(done){
//     console.log(5)
//     done()
// }
// exports.build = series(
//     parallel(fn1, fn4,parallel(fn1, series(fn2, fn3))),
//      fn5);
// const testCss = ((parallel( css, js), concatCss))
// function watchs() {
//     gulp.watchs(paths.src.stylus, gulp.series(testCss));
//     gulp.watchs(paths.src.scripts, gulp.series(js));
// }














/** gulp3 的寫法 */

// var gulp = require('gulp'); 

// const server = require('browser-sync').create();
// const uglify= require('gulp-uglify');    /** 醜化壓縮 */
// const concat = require('gulp-concat');   /** 連接檔案 */
// const babel = require('gulp-babel');     /** 編譯 ES6 */

// const jshint = require('gulp-jshint')

// const stylus = require('gulp-stylus');   /** 編譯 stylus */
// const sourcemaps   = require('gulp-sourcemaps');  /** 來源映像 */

// const autoprefixer = require('gulp-autoprefixer'); // 跟以下的方式一樣
// const plugins = { browsers: ['> .5%, last 2 versions'] }

// const postcss = require('gulp-postcss');
// const autoprefixer = require('autoprefixer');
// var plugins = [
//     autoprefixer({browsers: ['last 2 version']}) 
// ]

/** 用物件的形式設定路徑 */
// const paths = {
//     src: {
//         stylus: './src/css/*.styl',
//         scripts: './src/scripts/*.js',
//     },
//     public: {
//         js:'./public/js',
//         css: './public/css',
//     }
// }

// gulp.task('css', function() {
//     return gulp.src(paths.src.stylus)
//         .pipe(stylus()) 
//         .pipe(sourcemaps.init()) // 製作 sourcemaps
//         // .pipe(stylus({ compress: true })) // 將 styl 轉成 css 並壓縮
//         // .pipe(postcss(plugins)) // 加上 prefixes
//         .pipe(autoprefixer(plugins))
//         .pipe(sourcemaps.write('.'))
//         .pipe(gulp.dest(paths.public.css)); // directories 目錄 存放的位置
// })

// gulp.task('js', function () {
//     return gulp.src(paths.src.scripts)
//     .pipe(jshint())
//         .pipe(sourcemaps.init()) // 製作 sourcemaps
//         .pipe(babel()) // 轉換語法
//         .pipe(concat('all.min.js'))  // 合併檔案
//         .pipe(uglify()) // 壓縮檔案
//         .pipe(sourcemaps.write('.'))
//         .pipe(gulp.dest(paths.public.js)); // 將處理好的檔案存放於這
// })

// /** default 預設任務: parallel 並行任務 */
// gulp.task('default', gulp.parallel('css', 'js'))
