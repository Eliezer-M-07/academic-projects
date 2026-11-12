import { Router } from "express";
import * as authController from '../controllers/authController.js';

const router = Router();

router.get('/register', authController.showRegister);
router.get('/login', authController.showLogin);

router.post('/register', authController.registerUser);
router.post('/login', authController.loginUser);
router.post('/logout', authController.logout);


export default router;
