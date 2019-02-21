
const express = require('express');
const app = express();
const session = require('express-session');


// const UserModel = require('./models/blog_user')

// module.exports = app;

// // console.log(app)
// console.log('UserModel:', UserModel, '\n\n')



// 解析 req.body
const bodyParser = require('body-parser');

// 解析 application/json
app.use(bodyParser.json());

// 解析 application/x-www-form-urlencoded
app.use(bodyParser.urlencoded({ extended: false}));

// const sequelize = require('./model/conn');
// const User = require('./model/user');

const userController = require('./controller/user');

app.set('view engine', 'ejs');

app.use(session({
    secret:'blog',
    saveUninitialized: false,  // 是否自动保存未初始化的会话，建议false
    resave: false,  // 是否每次都重新保存会话，建议false
    cookie: {
        maxAge: 24*60*60*30*1000
    }
}))

app.use(express.static('public'))

app.get('/', userController.index)
app.get('/logout', userController.logout)

app.get('/archives', userController.archives)
app.get('/posts/:id', userController.posts)

app.get('/about', userController.about)
app.get('/categories', userController.categories)

app.get('/login', userController.login)
app.post('/login', userController.handleLogin)
// app.get('/register', userController.register)
app.post('/handle-register', userController.handleRegister)


// app.get('/about', (request, response) => {
//     // response.send(`<h1>${request.query.name}</h1>`);
//     response.render('pages/about', {
//         title: request.query.name || 'default'
//     })
// })

app.listen(3000, () => {
    console.log('Blog app listening on port 3000!')
})