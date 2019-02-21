/* jshint indent: 2 */

module.exports = function(sequelize, DataTypes) {
    return sequelize.define('articles', {
        id: {
        type: DataTypes.INTEGER(11),
        allowNull: false,
        primaryKey: true,
        autoIncrement: true
        },
        title: {
        type: DataTypes.STRING(128),
        allowNull: false
        },
        content: {
        type: DataTypes.TEXT,
        allowNull: false
        },
        created_at: {
        type: DataTypes.DATE,
        allowNull: false,
        defaultValue: sequelize.literal('CURRENT_TIMESTAMP')
        },
        draft: {
        type: DataTypes.INTEGER(1),
        allowNull: false
        }
    }, {
        tableName: 'articles',
        timestamps: false,
        createdAt: 'created_at'
    });
};
