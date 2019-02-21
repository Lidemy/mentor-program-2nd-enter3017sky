// 老師的範例

const Sequelize = require('sequelize');
const sequelize = require('../models/sequelize')

// 資料庫的 schema
// 建立一個名稱 'user' 的 table 
const User = sequelize.define('blog_user', {
    username: {
        type: Sequelize.STRING,
        validate:  {
            notEmpty: true
        }
    },
    password: {
        type: Sequelize.STRING,
        validate:  {
            notEmpty: true
        }
    },
    email: {
        type: Sequelize.STRING,
        validate:  {
            isEmail: true
        }
    },
    created_at: {
        type: Sequelize.DATE
    }
}, {
    tableName: 'blog_user',
    timestamps: false,
    createdAt: 'created_at'
})

// 創建資料庫
// User.sync()

module.exports = User;

// module.exports = {
//     getUser: (id, callback) => {
//         // get user from database
//         callback({
//             name: 'Clark',
//             id: 123
//         })
//     }
// }