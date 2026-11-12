import sequelize from "../config/database.js";
import { DataTypes } from "sequelize";

const Category = sequelize.define('Category', {
    name: {
        type: DataTypes.STRING(80),
        allowNull: false
    }
}, {
    tableName: 'categories',
    timestamps: false
});

export default Category;