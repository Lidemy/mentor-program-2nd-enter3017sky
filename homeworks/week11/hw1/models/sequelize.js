/**
 * Sequelize: 插件
 * configure: mysql password
 * UserModel: user schema
 */

const Sequelize = require('sequelize');
const configure = require('./configure');

const UserModel = require('./blog_user');
const PostModel = require('./articles');
const Categories = require('./categories');
const Taxonomy = require('./taxonomy');
const CommentsModel = require('./comments');
const About = require('./about');



// 連線資料庫
const sequelize = new Sequelize(configure.dbname, configure.username, configure.password, {
    host: configure.host,
    dialect: 'mysql',
    operatorsAliases: false,
    // logging: false,
    define: {
        timestamps: false,
        // createdAt: 'created_at',
        // 用底線 ex. articles_id , 不用駝峰命名 articlesId  
        underscored: true
    }
});

// 使用者
const User = UserModel(sequelize, Sequelize);

// 文章列表
const Post = PostModel(sequelize, Sequelize);

// 分類列表
const Tag = Categories(sequelize, Sequelize);

// category_id article_id
const Tax = Taxonomy(sequelize, Sequelize);

// 文章底下的 comments
const Comments = CommentsModel(sequelize, Sequelize)

const AboutInfo = About(sequelize, Sequelize);

// const BlogTag = sequelize.define('blog_tag', {})

// Post.belongsToMany(Tag, { through: BlogTag, unique: false })
// Tag.belongsToMany(Post, { through: BlogTag, unique: false })

// Post.belongsTo(Tag, {foreignKey: 'id', foreignKeyContraints:false, constraints: false})

// Tag.hasMany(Post, {foreignKey: 'id', foreignKeyContraints:false, constraints: false})


// Post.belongsTo(Tax, { 
//     foreignKey: { 
//         primaryKey: true 
//     },
//     through: Tag 
// })

// Tax.belongsToMany(Post, { foreignKey: { primaryKey: true }, through: Tag })


// sequelize.sync().then(function() {
//     // this is where we continue ...
// })


// 測試連接 Promise
sequelize.authenticate()
    .then(() => {
        console.log('\n\t** Connection has been established successfully. **\n');
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
    Post,
    Tag,
    Tax,
    AboutInfo,
    Comments,
    sequelize
}