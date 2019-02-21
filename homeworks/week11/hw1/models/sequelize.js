/**
 * Sequelize: 插件
 * configure: mysql password
 * UserModel: user schema
 */

const Sequelize = require('sequelize');
const configure = require('./configure');

const UserModel = require('./blog_user')
const PostModel = require('./articles')

// 連線資料庫
const sequelize = new Sequelize('enter3017sky_db', 'enter3017sky', configure.password, {
    host: 'enter3017sky.tw',
    dialect: 'mysql',
    operatorsAliases: false,
    logging: false
});

const User = UserModel(sequelize, Sequelize);
const Post = PostModel(sequelize, Sequelize)

// 測試連接 Promise
sequelize.authenticate()
    .then(() => {
        console.log('\t** Connection has been established successfully. **');
    })
    .catch((err) => {
        console.error(`
        ------------START-----------
        Unable to connect to the database:
        ${err}
        -------------END------------`);
    });

// 導出
module.exports = {
    User,
    Post
}