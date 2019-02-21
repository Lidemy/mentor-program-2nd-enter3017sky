/* jshint indent: 2 */

module.exports = function(sequelize, DataTypes) {
  return sequelize.define('products', {
    id: {
      type: DataTypes.INTEGER(11),
      allowNull: false,
      primaryKey: true,
      autoIncrement: true
    },
    name: {
      type: DataTypes.TEXT,
      allowNull: false
    },
    amount: {
      type: DataTypes.INTEGER(11),
      allowNull: true
    },
    selled: {
      type: DataTypes.INTEGER(11),
      allowNull: false
    },
    price: {
      type: DataTypes.INTEGER(11),
      allowNull: false
    }
  }, {
    tableName: 'products'
  });
};
