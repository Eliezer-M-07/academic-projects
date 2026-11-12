import express from 'express';
import authRoutes from './src/routes/authRoutes.js';
import userRoutes from './src/routes/userRoutes.js';
import recipeRoutes from './src/routes/recipeRoutes.js';
import session from 'express-session';

const app = express();

app.set('view engine', 'ejs');

app.use(express.urlencoded({ extended: true }));
app.use(express.static('public'));

app.use(session({
    secret: process.env.SESSION_SECRET,
    resave: false,
    saveUninitialized: false,
    cookie: {
        httpOnly: true,
        maxAge: 1000 * 60 * 60 * 24
    }
}));

app.use((req, res, next) => {
    res.locals.isLoggedIn = !!req.session.userId;
    res.locals.userId = req.session.userId;
    res.locals.username = req.session.username;
    res.locals.userPhoto = req.session.userPhoto;
    next();
});

app.use('/', authRoutes);
app.use('/', userRoutes);
app.use('/', recipeRoutes);

export default app;
