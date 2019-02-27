
// const { User, Post, Tag, Tax, AboutInfo, sequelize } = require('../models/sequelize')

// // 處理時間格式
// const moment = require('moment');

// // markdown
// const marked = require('marked')

// // highlight code
// const Prism = require('prismjs');

// // password hash
// const bcrypt = require('bcrypt')

// module.exports = {

//     getArticleAllData: (req, res) => {

//         // console.log(Post.associate())
//         // Tax.belongsTo(Post, { foreignKey: 'article_id', constraints: true, target: 'id' })
        
//         // Tax.belongsTo(Post, { foreignKey: 'article_id' })
//         // Tax.hasMany(Post, { foreignKey: 'uId',sourceKey: 'id' });
//         // // Post.belongsTo(Tax, { foreignKey: 'uId',sourceKey: 'id' })

//         // Tax.hasMany(Post);
//         // Post.belongsTo(Tax)

//         // Tax.belongsToMany(Post, { foreignKey: { primaryKey: true }, through: Tag })
//         // Post.belongsTo(Tax, { foreignKey: { primaryKey: true }, through: Tag })

//         // var cases = yield models.PatientCase.findOne({
//         //     attributes: ['status', 'source'],
//         //     include: [{
//         //         model: models.Reservation,
//         //         attributes: ['id']
//         //     }],
//         //     where: {
//         //         id: 1,
//         //         '$reservation.id$': 2
//         //     }
//         // });

//         // Post.findAll({
//         //     // attributes: ['discoverySource'],
//         //     where: { 
//         //         id: req.params.id
//         //     },
//         //     // required: true,
//         //     // foreignKeyConstraint: false,

//         // }).then(data => {
//         //     console.log(data)
//         // }).catch( err => console.log(err))


        
//         // console.log(req.params.id)

//         // Post.findOne({
//         //     where: {
//         //         id: req.params.id
//         //     },
//         //     raw: true
//         // }).then(data => {

//         //     // console.log(data)

//         //     // console.log(data.content)

//         //     res.render('post', {
//         //         user: 'Controller',
//         //         title: 'TEST',
//         //         time: new Date(),
//         //         id: req.params.id,
//         //         postState: data.draft,
//         //         content: data.content
//         //     })
//         // }).catch(err => console.log(err))

//     }
// }