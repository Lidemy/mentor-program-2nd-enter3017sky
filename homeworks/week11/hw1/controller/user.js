// const Sequelize = require('sequelize');
// const sequelize = require('../models/conn')
// const userModel = require('../models/blog_user')
// const User = userModel(sequelize, Sequelize)
// const User = require('../model/user')
// const {  sequelize } = require('../models/sequelize')

const { User, Post, Tag, Tax, AboutInfo, Comments, sequelize } = require('../models/sequelize')

const ejs_helpers = require('../public/ejs_helper') 

// 處理時間格式
const moment = require('moment');

// markdown
const marked = require('marked')

// highlight code
const Prism = require('prismjs');

// password hash
const bcrypt = require('bcrypt');

module.exports = {
    index: function(req, res) {

        user = req.session.username

        Post.findAll({
            where:  {
                draft: 0
            },
            // 測試用 取消 content log 出來才不會太多資料
            // attributes: ['created_at', 'title', 'id'],
            order: [
                ['created_at', 'DESC']
            ],
            raw: true // 把撈出來的 instance 變成 object
        }).then((originPosts) => {

            // console.log(originPosts)

            // 轉換成 markdown，方式不太好
            const mdPosts = handleContent(originPosts)
            function handleContent(arr) {
                for(let i = 0, len = arr.length; i < len; i++) {
                    console.log("arr[i]['content'].length", i ,  arr[i]['content'].length)
                    arr[i]['content'] = arr[i]['content'].slice(0, 500)
                    arr[i]['content'] = marked(arr[i]['content'])
                    console.log("arr[i]['content'].length", i , arr[i]['content'].length)
                }
                return arr
            }

            res.render('index', {
                user: user ? user : null,
                // content,
                posts: mdPosts,
                title: 'enter3017sky Blog'
            })
        })

    },

    /** 登入與註冊的畫面 */
    login: function(req, res) {
        user = req.session.username;
        res.render('loginAndRegister', {
            user: user ? user : null,
            title: 'Login & Sign up',
        })
    },

    /** 處理登入 */
    handleLogin: function(req, res) {

        if(req.body.submit === 'login' && req.body.username !== '' && req.body.password !== '') {
            /**
             * 當使用者點擊 login 時，檢查 user 是否存在，然後取得 data.password(從 DB 拿到的資料 as hashPwd)
             *  bcrypt.compare(使用者輸入, hashPwd in DB, 做些啥)
            */
            User.findOne({
                where:{
                    username: req.body.username
                }
            }).then(data => {

                const hash = data.password;
                const myPlaintextPassword = req.body.password;

                bcrypt.compare(myPlaintextPassword, hash, function(err, result) {
                    if(result === true) {
                        req.session.username = data.username
                        user = req.session.username
                        res.redirect('/')
                    } else {
                        console.log('帳號或密碼錯誤！！！')
                        res.redirect('/login')
                    }
                });

            }).catch(err => {
                console.log(password)
                console.error('******************** \n error Message: \n', err, '\n********************\n')
                console.log('帳號或密碼錯誤！')
                res.redirect('/login')
            });

        } else {
            console.log('是否忘記輸入什麼了？')
            res.redirect('/login')
        }
    },

    /** 處理註冊 */
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
                        email: req.body.email,
                    }

                    User.create(insertValue).then((data) => {
                        req.session.username = req.body.username;
                        user = req.session.username
                        res.redirect('/')
                    }).catch((err) => {

                        console.log(err)
                    })
                } else {
                    console.log(err)
                }
            });

        } else {
            console.log('是否忘記輸入什麼了？')
            res.redirect('/login')
        }

    },

    /** 登出 */
    logout: function(req, res) {
        // 清除 session 後導去首頁
        req.session.destroy();
        res.redirect('/')
    },

    /** 新增文章的頁面 */
    newPost: function(req, res) {

        user = req.session.username;

        Tag.findAll({
            order: [['id', 'ASC']],
            raw: true
        }).then(tags => {
            console.log(tags)
            // res.json(tags)

            res.render('newPost', {
                tags,
                user,
                title: '新增文章'
            })
        }).catch(err => {
            console.log(err)
        });
    },

    /** 顯示新增分類的頁面 */
    newTag: function(req, res) {

        user = req.session.username;
        
        Tag.findAll({
            order: [['name', 'ASC']],
            raw: true
        }).then(tags => {

            console.log('顯示新增分類的頁面: \n', tags)

            res.render('newTag', {
                title: '新增分類',
                tags,
                user
            })
        }).catch(err => console.log(err))

    },

    /** 新增分類 */
    createNewTag: function(req, res) {

        console.log('新增了分類: ', req.body.name)

        Tag.create({
            name: req.body.name
        }).then(() => {
            res.redirect('back')
        }).catch(err => console.log(err))

    },

    /** 新增文章 */
    createNewPost: function(req, res) {

        // 先處理新增文章
        Post.create({
            title: req.body.title,
            content: req.body.content,
            draft: req.body.draft
        }).then(data => {

            console.log('文章 id: ', data.id)
            console.log('選取的分類', req.body.category_id)
            const tags = req.body.category_id

            // 在判斷是文章選了單一分類或多項分類(陣列)
            if(Array.isArray(tags)) {
                 // 利用 forEach 遍歷 tags 這個陣列
                tags.forEach(tag => {
                    Tax.create({
                        category_id: tag,
                        article_id: data.id
                    }).then(data=> {
                        console.log('dataByTag:', data)
                        res.redirect('/')
                    }).catch(err => console.log(err));
                });
            } else {
                Tax.create({
                    category_id: tags,
                    article_id: data.id
                }).then(data=> {
                    console.log('dataByTag:', data)
                    res.redirect('/')
                }).catch(err => console.log(err));
            }

        }).catch(err => console.log('err: ', err))

    },

    /** 所有文章列表 */
    archives: function(req, res) {
        user = req.session.username;

        Post.findAll({
            where: { draft: 0 },
            attributes: ['created_at', 'title', 'id'],
            order: [['created_at', 'DESC']],
            // raw: true 用了這個之後， moment() 沒有效果?
        }).then(posts => {

            console.log('所有文章列表：\n', posts)

            // for (const created_at in posts) {
            //     if (object.hasOwnProperty(created_at)) {
            //         const element = object['created_at'];
                    
            //     }
            // }

            // 這樣本來是 posts.get() 但怪怪的
            return posts

        }).then(posts => {

            res.render('archives', {
                posts,
                user,
                title: 'Archives'
            })

        }).catch(err => {
            console.log(err)
        })
    },

    /** 顯示單篇文章 */
    posts: function(req, res) {
        user = req.session.username;
        const id = req.params.id

        // 透過 articles.id 撈其他資料(categories, comments)
        Post.findOne({
            where: {
                id
            },
            raw: true
        }).then(post => {

            // 取得文章的分類
            tagRawQuery = "SELECT c.name FROM categories c LEFT JOIN taxonomy t ON c.id=t.category_id WHERE t.article_id = ?";

            sequelize.query(tagRawQuery,{
                replacements: [id],
                type: sequelize.QueryTypes.SELECT
            }).then(categories => {

                console.log('單篇文章的分類選項：', categories)

                commentsQuery = "SELECT * FROM comments WHERE article_id = ?";

                console.log('This is article ID:', id)

                sequelize.query(commentsQuery,{
                    replacements: [id],
                    type: sequelize.QueryTypes.SELECT,
                    rew: true
                }).then(comments => {

                    comment = req.session.comment

                    const time =  post.created_at
                    content = marked(post.content)
                    res.render('post', {
                        categories,
                        user,
                        id,
                        content,
                        title: post.title,
                        time: time,
                        postState: post.draft,
                        comments,
                        comment
                    })

                }).catch(err => console.log(err))

            }).catch(err => console.log(err))

        }).catch(err => console.log(err))
    },

    /** 關於我頁面 */
    about: function(req, res) {
        user = req.session.username;
        AboutInfo.findOne({
            where: {
                id: 1
            }
        }).then(aboutInst => {
            return aboutInst.get()
        }).then(data => {

            const aboutTextInfo = marked(data.introduction)
            res.render('about', {
                aboutTextInfo,
                user,
                title: 'About Me'
            })
        })

    },

    /** 分類: 顯示分類及數量 */
    categories: function(req, res) {

        console.log(req.params)
        
        user = req.session.username;

        const rawQuery = "SELECT c.name, t.category_id, count(t.category_id) FROM categories c left join taxonomy t on c.id=t.category_id left join articles a on a.id=t.article_id  WHERE a.draft=0  group BY category_id desc";

                // 測試其中的差別
        // sequelize.query(rawQuery).spread((results, metadata) => {
        //     Raw query - use spread
        //     res.json({results, metadata})
        //     return

        // join 的部分有些複雜，故出此下策
        sequelize.query(rawQuery,{

            type: sequelize.QueryTypes.SELECT

        }).then((tags) => {

            console.log('tags:', tags, typeof tags)

            res.render('categories', {
                tags,
                user,
                title: 'Categories'
            });

        }).catch(err => console.log(err))

    },

    /** 透過標籤名稱取得相關文章 */
    getPostByTagName: function(req, res) {

        // console.log('tagname: ', req.param(), '\n\n', 'req.query: ', req.body)
        console.log(' req.params.tagName: ', req.params.tagName)

        const tagRawQuery = "SELECT a.id, a.title, a.created_at , t.category_id FROM articles a LEFT JOIN taxonomy t ON a.id = t.article_id WHERE t.category_id = ? AND a.draft=0 ORDER BY a.created_at ASC";

        // 從 url 參數取得分類的名稱，然後透過分類的名稱取得分類 id (note: 不增加 url 參數的情況下，不知道有沒有更好的方法，想了好久)
        Tag.findOne({
            where: {
                name: req.params.tagName
            }
        }).then(tag => {
            
            console.log('分類 id: ', tag.id)

            // 取得 category_id 之後，用原本 PHP 的 query 來操作
            sequelize.query(tagRawQuery,{
                replacements: [tag.id],
                type: sequelize.QueryTypes.SELECT 
            }).then(getPostDataByCategoryId => {

                const posts = getPostDataByCategoryId

                res.render('category', {
                    posts,
                    title: req.params.tagName,
                    user: req.session.username
                })
            }).catch(err => console.log(err))

        }).catch(err => console.log(err))
    
    },

    /** 跟顯示所有文章列表差不多 */
    archivesAdmin: function(req, res) {
        user = req.session.username;
        
        Post.findAll({
            // where:{ draft: 0 },
            attributes: ['title', 'id', 'draft', 'created_at'],
            order: [['created_at', 'DESC']],
            // raw: true  // 用了這個之後， moment() 沒有效果?
        }).then(posts => {

            // console.log(posts)

            res.render('archivesAdmin', {
                posts,
                user,
                title: 'Archives'
            })

        }).catch(err => {
            console.log(err)
        })
    },

    /** 管理分類的頁面 */
    categoriesAdmin: function(req, res) {

        user = req.session.username;
        const rawQuery = "SELECT * FROM categories ORDER BY id DESC";

        sequelize.query(rawQuery,{

            type: sequelize.QueryTypes.SELECT

        }).then((tags) => {

            console.log('所有分類:\n', tags)

            res.render('categoriesAdmin', {
                tags,
                user,
                title: 'Categories'
            });

        }).catch(err => console.log(err))
    },

    /** 處理文章底下的留言 */
    comments: function(req, res) {

        comment = req.session.comment

        if(comment) { // 留言者已有暱稱，將 insert 的資料 name 換成使用者輸入的

            insertValue = {
                name: comment,
                content: req.body.content,
                article_id: req.body.article_id
            }

            Comments.create(insertValue).then(CommentsData => {
                req.session.comment = CommentsData.name
                res.redirect('back')
            }).catch(err => console.log(err));

        } else {

            Comments.create(req.body).then(CommentsData => {
                req.session.comment = CommentsData.name // 留言者暱稱存入 session
                comment = req.session.comment
                res.redirect('back') // 重新導向回原本的地方
            }).catch(err => console.log(err));

        }
    },

    /** 刪除單篇文章 */
    postDelete: function(req, res) {

        user = req.session.username
        
        const article_id = req.params.id
        
        if(user) {

            console.log('User Login: ', user, '\n article_id: ', article_id);
            
            Tax.destroy({
                where: {
                    article_id
                }
            }).then(result => {

                Comments.destroy({
                    where: {
                        article_id
                    }
                }).then(result => {

                    Post.destroy({
                        where: {
                            id: article_id
                        }
                    }).then(result => {
                        console.log(`文章 ID:{req.params.id}, 成功刪除 ${result} 筆`)

                        res.redirect('back')

                    }).catch(err => console.log(err));
                    console.log(`文章 ID 為 ${req.params.id} 的 Comments, 成功刪除 ${result} 筆`)
                }).catch(err => console.log(err))
                console.log(`文章 ID 為 ${req.params.id} 的分類, 成功刪除 ${result} 筆`)
            }).catch(err => console.log(err))

        } else {
            console.log('User Not Login!!!')
            res.redirect('/')
        }
    },

    /** 編輯文章的畫面 */
    postEdit: function(req, res) {

        user = req.session.username

        if(user) {

            Post.findOne({
                where: {
                    id: req.params.id
                },
                raw: true
            }).then(postData => {
    
                Tag.findAll({
                    order: [['id', 'ASC']],
                    raw: true
                }).then(allTags => {
                    console.log(allTags)
    
                    Tax.findAll({
                        attributes: ['category_id'],
                        where: {
                            article_id: req.params.id
                        },
                        raw: true
                    }).then(checkedTag => {
    
                        // 將選過的分類 data 轉成 array
                        return checkedTag.map(tag => tag.category_id)
    
                    }).then(checkedTagArray => {
    
                        console.log('categories_checked_array:', checkedTagArray)
                        res.render('editPost', {
                            _:ejs_helpers,
                            allTags,
                            postData,
                            checkedTagArray,
                            user: req.session.username,
                            title: '編輯文章'
                        })
    
                    }).catch(err => console.log(err))
    
                }).catch(err => console.log(err))
    
            }).catch(err => console.log(err))
        } else {
            res.redirect('./')
        }

    },

    /** 處理編輯文章的行為 */
    handlePostEdit: function(req, res) {

        user = req.session.username
        console.log('編輯文章的內容:\n ', req.body)
        if(user) {
        const id = req.body.id
        const title = req.body.title.trim()
        const content = req.body.content.trim()
        const draft = req.body.draft
        const categoriesUpdateData = req.body['category_id[]']

            Post.findOne({
                where: {
                    id: req.body.id
                },
                // attributes: ['id', 'title', 'content', 'draft'],
            }).then(postInstanceData => {
                // 取得文章資料並更新，繼續往下執行
                return postInstanceData.update({
                    title: req.body.title,
                    content: req.body.content,
                    draft: req.body.draft
                })

            }).then(data => {
                return data.get()
            }).then(objectData => {

                console.log('更新後的資料\n', objectData, '\n')

                Tax.destroy({
                    where: {
                        article_id: id
                    }
                }).then(data => {
                    console.log('已刪除 ', data, '筆分類。')
                })

                if(Array.isArray(categoriesUpdateData) || categoriesUpdateData === undefined) {
                    categoriesUpdateData.forEach(
                        function(category_id){
                            Tax.create({
                                article_id: id,
                                category_id:category_id
                            }).then(data => {
                                // console.log('新增', data.get({ plain: true }), '的分類')
                                console.log('新增 id: ', data.article_id, '的文章, id: ', data.category_id , '的分類')
                            }).catch( err => console.log(err))
                        })
                } else  {
                    Tax.create({
                        article_id: id,
                        category_id:categoriesUpdateData
                    }).then(data => {
                        console.log('新增 id: ', data.article_id, '的文章, id: ', data.category_id , '的分類')
                    }).catch(err => console.log(err))
                }
                return objectData

            }).then(data => {

                res.redirect('./')
            }).catch(err => console.log(err))

        } else {
            res.redirect('./')
        }


    }
}