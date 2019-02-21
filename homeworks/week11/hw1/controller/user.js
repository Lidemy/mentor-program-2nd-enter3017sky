// const Sequelize = require('sequelize');
// const sequelize = require('../models/conn')

// const userModel = require('../models/blog_user')
// const User = userModel(sequelize, Sequelize)


// const User = require('../model/user')

const { User, Post } = require('../models/sequelize')

// password hash
const bcrypt = require('bcrypt')

module.exports = {
    index: function(req, res) {
        const user = req.session.username

        Post.findAll({
            where:{
                draft: 0
            }
        }).then((posts) => {
            res.render('index', {
                user: user ? user : null,
                posts: posts,
                title: 'enter3017sky Blog'
            })
        })

        
    },
    login: function(req, res) {
        // console.log('User: ', User, '\n\n')
        // console.log('UserModel: ', userModel, '\n\n')
        // const user = req.session.username;
        res.render('loginAndRegister', {
            user: user ? user: null,
            title: 'Login & Sign up'
        })
    },
    handleLogin: function(req, res) {
        
    },
    handleRegister: function(req, res) {

        // 檢查 req.body(使用者輸入的值) 是否都有值
        // req.body: { username: '', password: '', email: '', submit: 'register' }

        const checkObjHaveValue = function(object) {
            for (var key in object) {
                if (object[key] === '') {
                    return false
                }
            }
            return true;
        };

        // console.log("\x1b[31m", 'checkObjHaveValue: ', checkObjHaveValue(req.body), '\n')
        // console.log("\x1b[31m", 'checkObjHaveValue: ', req.body, '\n')

        const saltRounds = 10; // 加鹽的等級
        const myPlaintextPassword = req.body.password; // 使用者輸入的密碼
        
        // 點擊 "register" && req.body 都不為空才執行
        if(req.body.submit === 'register' && checkObjHaveValue(req.body) ) {
            // hash password -> store in DB
            bcrypt.hash(myPlaintextPassword, saltRounds, function(err, hash) {

                if(!err) {
                    const insertValue = {
                        username: req.body.username,
                        password: hash,
                        email: req.body.email
                    }

                    User.create(insertValue).then((data) => {
                        req.session.username = req.body.username;

                        // console.log(`username: I'm Mr. ${user}`)
                        // console.log('created!!')
                        // console.log('data:', data)

                        return res.redirect('/')
                    }).catch((err) => {
                        console.log(err)
                    })

                } else {
                    console.log(err)
                }

            });
            

            // 以同步的方式處理密碼(bcrypt 推薦非同步)
            // const hash = bcrypt.hashSync(req.body.password, 10)   
            // 將使用者輸入的資料包乘物件，再塞進 User.create
            // const insertValue = {
            //     username: req.body.username,
                // password: hash,
            //     email: req.body.email
            // }
            // /**  User.create(insertValue).then((result) => {
            //         res.send(result)   // 成功的話回傳 result
            //     }).catch(err, () => {
            //         return res.send(err)  // 失敗的話返回錯誤訊息
            //     })
            // */
            // User.create(insertValue).then(() => {
            //     console.log('created!!')
            //     res.redirect('/')
            // }).catch((err) => {
            //     console.log(err)
            // })

        } else if(req.body.submit === 'login' && checkObjHaveValue(req.body)) {
            /**
             * 當使用者點擊 login 時，檢查 user 是否存在，然後取得 data.password(從 DB 拿到的資料)
             *  bcrypt.compare(使用者輸入, hashPwd in DB, 做些啥)
            */
            User.find({
                where:{
                    username: req.body.username
                }
            }).then(data => {

                console.log('data.username', data.username)

                const hash = data.password;
                const myPlaintextPassword = req.body.password;

                bcrypt.compare(myPlaintextPassword, hash, function(err, result) {
                    if(result === true) {
                        req.session.username = data.username
                        console.log('req.session.username: ', req.session.username)
                        console.log('req.session: ', req.session)

                        // console.log('req:', req)
                        return res.redirect('/')
                    } else {
                        console.log('帳號或密碼錯誤！！！')
                    }
                })

            }).catch(err => {
                console.log('帳號或密碼錯誤！')
            })
            

            // const password = req.body.password;

            // console.log(`\x1b[31m checkObjHaveValue(req.body): ${checkObjHaveValue(req.body)} \n`)
            // console.log(`password: ${req.body.password}\nusername: ${req.body.username}\nsubmit:${req.body.submit}\n\n`)


            // bcrypt.hash(password, 10, function(err, hash) {
            //     // Store hash in database
            //     const hashPassword = hash;
            //     console.log('hashPassword:', hashPassword)

            //     return hashPassword
            // });


            // console.log(`password: ${password}\nhash: ${hash}\n\n`)

            // bcrypt.compare(password, User.password, function(err, res) {
            //     console.log(hash)
            //     User.find({
            //         where:{
            //             username: req.body.username
            //         }
            //     }).then(data => {
            //         console.log(data)
            //     })
            //     console.log(res)
            // })

        } else {
            console.log('是否忘記輸入什麼了？')
        }

        


    },

    /** 登出 */
    logout: function(req, res) {
        // 清除 session 後導去首頁
        req.session.destroy();
        res.redirect('/')
    },

    /** 所有文章列表 */
    archives: function(req, res) {
        const user = req.session.username;
        
        Post.findAll({
            where:{
                draft: 0
            }
        }).then((posts) => {
            res.render('archives', {
                posts,
                user,
                title: 'archives'
            })
        }).catch((err) => {
            console.log(err)
        })
    },

    /** 單篇文章 */
    posts: function(req, res) {
        const user = req.session.username;

        const id = req.params.id
        console.log(id)
        Post.findOne({
            where: {
                id
            }
        }).then((post) => {
            console.log('post', post)
            console.log(post.content)
            console.log(post.title)
            res.render('post', {
                user,
                id,
                content: post.content,
                title: post.title,
                time: post.created_at,
                postState: post.draft
            })
        }).catch((err) => {
            console.log(err)
        })
    },

    /** 關於我頁面 */
    about: function(req, res) {
        const user = req.session.username;
        res.render('about', {
            user,
            title: 'About Me'
        })
    },

    /** 分類 */
    categories: function(req, res) {
        const user = req.session.username;
        res.render('categories', {
            user,
            title: 'Categories'
        })
    }
}