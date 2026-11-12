import { Router } from "express";
import * as recipeController from '../controllers/recipeController.js';
import requireAuth from '../middlewares/authMiddleware.js';

const router = Router();

router.get('/recipes', recipeController.index);
router.get('/recipes/create', requireAuth, recipeController.showRegister);
router.get('/recipes/:id', recipeController.showRecipe);
router.get('/recipes/edit/:id', requireAuth, recipeController.editRecipeForm);

router.post('/recipes/create', requireAuth, recipeController.createRecipe);
router.post('/recipes/edit/:id', requireAuth, recipeController.editRecipe);
router.post('/recipes/delete/:id', requireAuth, recipeController.deleteRecipe);

export default router;