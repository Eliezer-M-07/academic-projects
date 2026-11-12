import User from './User.js';
import Category from './Category.js';
import Recipe from './Recipe.js';

User.hasMany(Recipe, {
    foreignKey: 'user_id',
    onDelete: 'SET NULL'
});

Recipe.belongsTo(User, {
    foreignKey: 'user_id'
});

Category.hasMany(Recipe, {
    foreignKey: 'category_id'
});

Recipe.belongsTo(Category, {
    foreignKey: 'category_id'
});

export {
    User,
    Category,
    Recipe
};
