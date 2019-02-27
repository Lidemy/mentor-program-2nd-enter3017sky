
const express = require('express');
const app = express();
const session = require('express-session');

// const route = express.Router()
// console.log(JSON.stringify(route))


// const UserModel = require('./models/blog_user')

// module.exports = app;

// // console.log(app)
// console.log('UserModel:', UserModel, '\n\n')


// 解析 req.body
const bodyParser = require('body-parser');

// 解析 application/json, 將 request 進來的 data 轉成 json()
app.use(bodyParser.json());

// 解析 application/x-www-form-urlencoded
app.use(bodyParser.urlencoded({ extended: false}));

// const sequelize = require('./model/conn');
// const User = require('./model/user');

const userController = require('./controller/user');

const testController = require('./controller/test')

app.set('view engine', 'ejs');

app.use(session({
    name: 'Blog-Username',
    secret:'blog',
    saveUninitialized: false,  // 是否自动保存未初始化的会话，建议false
    resave: false,  // 是否每次都重新保存会话，建议false
    cookie: {
        maxAge: 24*60*60*30*1000
    }
}))


app.use(express.static('public'))

app.use(express.static(__dirname + '/node_modules/jquery/dist/'))



app.get('/', userController.index)

app.get('/headers', function(req, res) {
        // 請求標頭: 顯示遊覽器傳遞的資料(使用者代理程式)
        res.set('Content-Type', 'application/json')
        var s = '';
        for (var name in req.headers) s += name + ':' + req.headers[name] + '\n';

})


/** 測試用 */
// app.get('/test/:id', testController.getArticleAllData)


    /** 顯示登入與註冊會員的頁面 */
app.get('/login', userController.login)

    /** 處理的登入的行為 */
app.post('/handle-login', userController.handleLogin)

    /** 處理註冊的行為 */
app.post('/handle-register', userController.handleRegister)

    /** 處理登出的行為 */
app.get('/logout', userController.logout)

    /** 顯示所有文章(除了草稿) */
app.get('/archives', userController.archives)

    /** 管理文章(顯示所有文章(包括草稿)) */
app.get('/admin/archives', userController.archivesAdmin)

    /** 管理分類 */
app.get('/admin/categories', userController.categoriesAdmin)

    /** 顯示單篇文章 */
app.get('/posts/:id', userController.posts)

    /** 刪除單篇文章 */
app.get('/posts/:id/delete', userController.postDelete)

    /** 刪除單篇文章 */
app.get('/posts/:id/delete', userController.postDelete)

    /** 顯示新增文章的畫面 */
app.get('/posts', userController.newPost)

    /** 顯示編輯文章的畫面 */
app.get('/posts/:id/edit', userController.postEdit)

    /** 處理編輯文章 */
app.post('/posts/:id/edit', userController.handlePostEdit)

    /** 顯示新增分類的行為 */
app.get('/category', userController.newTag)

    /** 顯示所有分類 */
app.get('/categories', userController.categories)

    /** 顯示某分類底下的文章 */
app.get('/categories/:tagName', userController.getPostByTagName)

    /** 處理創建文章的行為 */
app.post('/posts', userController.createNewPost)

    /** 處理創建分類的行為 */
app.post('/category', userController.createNewTag)

    /** 顯示關於我的畫面 */
app.get('/about', userController.about)

app.post('/comments', userController.comments)





// app.get('/error', (req, res) => {
//     throw new Error('This is a forced error.')
// })

// Handle for 404 - Resource Not Found
// app.use((req, res, next) => {
//     res.status(404).send('We think you are lost!!')
// })


// // Handle for Error 500
// app.use((err, req, res, next) => {
//     console.error(err.stack)

//     res.sendFile(__dirname, '/500.html')
// })

const PORT = process.env.PORT || 3000

app.listen(PORT, () => console.log(`Server has started on ${PORT}!`))