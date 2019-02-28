/* jshint indent: 2 */

module.exports = function(sequelize, DataTypes) {
    return sequelize.define('taxonomy', {
        article_id: {
            type: DataTypes.INTEGER(11),
            allowNull: false,
            primaryKey: true
            // references: {
            //     model: "articles",
            //     key: "article_id"
            // }
        },
        category_id: {
            type: DataTypes.INTEGER(11),
            allowNull: false,
            // references: {
            //     model: "categories",
            //     key: "category_id"
            // }
        }
    }, {
        tableName: 'taxonomy',
        
    });
};
