import { Router } from "express";
import * as userController from '../controllers/userController.js';
import requireAuth from '../middlewares/authMiddleware.js';

const router = Router();

router.get('/', userController.home);
router.get('/profile', requireAuth, userController.showProfile);
router.post('/profile/edit', requireAuth, userController.editUser);
router.post('/profile/delete', requireAuth, userController.deleteUser);

export default router;