[Português](README.md) | English

---

# Saboria

![Node.js](https://img.shields.io/badge/Node.js-ESM-000000?style=flat-square&logo=node.js&logoColor=white)
![Express](https://img.shields.io/badge/Express-5-000000?style=flat-square&logo=express&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-000000?style=flat-square&logo=mysql&logoColor=white)
![EJS](https://img.shields.io/badge/Views-EJS-000000?style=flat-square)
![License](https://img.shields.io/badge/License-ISC-000000?style=flat-square)

A web application for creating, browsing, and managing recipes, built with Node.js, Express, MySQL, and EJS. The project includes session-based authentication, image uploads, and recipe ownership checks.

---

## About

Saboria allows visitors to browse recipes published by all users. Authenticated users can create recipes and manage their own posts.

Each recipe has a title, description, category, image path, author, and creation date. Images are served by Express from the `public/` directory.

The main request flow is:

```text
HTTP Request
    ↓
Express Route
    ↓
Authentication Middleware (protected routes)
    ↓
Controller
    ↓
Sequelize Model
    ↓
MySQL
```

Pages are rendered server-side with EJS. Forms using `multipart/form-data` are processed with Formidable.

---

## Technology stack

| Technology | Role |
|---|---|
| Node.js | Application runtime |
| Express 5 | HTTP server, middleware, and routing |
| MySQL | Relational database |
| Sequelize | Object-relational mapping and database queries |
| EJS | Server-side page rendering |
| express-session | Authentication sessions |
| Formidable | Processing forms with file uploads |
| bcrypt | Password hashing and verification |
| Tailwind CSS 4 | Interface styling |
| dotenv | Environment variable loading |

---

## Features

- User registration and login.
- Optional profile photo during registration; it can also be updated from the profile page.
- Password hashing with bcrypt.
- Create, read, update, and delete recipes.
- Public recipe listing with cards showing the image, category, description, and author.
- Public recipe detail pages.
- Session-based access control for write operations.
- Recipe editing and deletion restricted to the author.
- JPG, PNG, and WEBP image uploads, limited to 5 MB.
- Shared navigation bar with links based on authentication state.
- Pagination for public listings and profile recipes.

---

## Architecture

### Routes

Routes map HTTP methods and paths to controllers. Routes that create, edit, or delete recipes use the `requireAuth` middleware.

### Middleware

`requireAuth` checks for `req.session.userId`. Requests without an authenticated session are redirected to `/login`.

### Controllers

Controllers coordinate requests, validate submitted data, call Sequelize models, and choose the response or view to render.

### Models

Sequelize models represent the `users`, `categories`, and `recipes` tables. Associations allow each recipe's category and author to be loaded with the recipe.

### Views

EJS pages are stored in `views/`. Shared components such as the navigation bar, recipe form, and recipe card are stored in `views/partials/` or `views/recipes/partials/`.

---

## Project structure

```text
src/
├── config/
│   └── database.js
├── controllers/
│   ├── authController.js
│   ├── recipeController.js
│   └── userController.js
├── middlewares/
│   └── authMiddleware.js
├── models/
│   ├── Category.js
│   ├── Recipe.js
│   ├── User.js
│   └── index.js
└── routes/
    ├── authRoutes.js
    ├── recipeRoutes.js
    └── userRoutes.js

views/
├── auth/
├── partials/
├── recipes/
└── user/

public/
├── css/
├── images/
└── uploads/       # created when a file is uploaded

app.js
server.js
trabalho3.sql
```

---

## Database

The [`trabalho3.sql`](trabalho3.sql) file creates the tables and inserts the initial recipe categories. Create the database before running the script.

### Tables

```text
users
├── id        INT, primary key
├── name      VARCHAR(100), not null
├── email     VARCHAR(255), not null, unique
├── password  VARCHAR(255), not null (bcrypt hash)
└── photo     VARCHAR(255), not null (relative image path)

categories
├── id        INT, primary key
└── name      VARCHAR(80), not null

recipes
├── id          INT, primary key
├── title       VARCHAR(150), not null
├── description TEXT, not null
├── category_id INT, foreign key to categories.id
├── archive     VARCHAR(255), not null (relative image path)
├── user_id     INT, foreign key to users.id, nullable
└── created_at  TIMESTAMP
```

When an account is deleted, `user_id` for its recipes is set to `NULL`, preserving the recipes and their images.

The `archive` field stores a relative path, such as `/uploads/generated-name.webp`. The corresponding files are saved in `public/uploads/`.

---

## Image uploads

- New recipes require an image.
- When editing a recipe, its existing image can be kept or replaced.
- Profile photos are optional during registration and can be changed from the profile page.
- Accepted formats are JPG, PNG, and WEBP.
- Upload forms are configured with a 5 MB file size limit.
- The `public/uploads/` directory is created when needed.

---

## Authentication and authorization

Express Session stores the authenticated user's ID, name, and photo in the session. The cookie is configured as `httpOnly` and expires after 24 hours. The default Express Session store keeps sessions in memory.

The authentication middleware protects recipe creation, editing, and deletion routes. Controllers also query recipes by both the recipe ID and the session's `user_id` before allowing edits or deletions. Recipe listing and detail routes are public.

Passwords are stored as bcrypt hashes; the original password is not stored in the database.

---

## Routes

| Method | Route | Access | Description |
|---|---|---|---|
| `GET` | `/` | Public | Home page and recent recipes |
| `GET` | `/recipes` | Public | Paginated recipe listing |
| `GET` | `/recipes/:id` | Public | Recipe details |
| `GET` | `/register` | Public | Registration form |
| `POST` | `/register` | Public | Creates an account with an optional photo |
| `GET` | `/login` | Public | Login form |
| `POST` | `/login` | Public | Authenticates a user |
| `POST` | `/logout` | Authenticated | Ends the session |
| `GET` | `/profile` | Authenticated | User profile and recipes |
| `POST` | `/profile/edit` | Authenticated | Updates the name, email, or profile photo |
| `POST` | `/profile/delete` | Authenticated | Deletes the account |
| `GET` | `/recipes/create` | Authenticated | Recipe creation form |
| `POST` | `/recipes/create` | Authenticated | Creates a recipe |
| `GET` | `/recipes/edit/:id` | Authenticated author | Recipe editing form |
| `POST` | `/recipes/edit/:id` | Authenticated author | Updates a recipe |
| `POST` | `/recipes/delete/:id` | Authenticated author | Deletes a recipe |

---

## Environment variables

Create a `.env` file in the project root:

```env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=saboria
DB_USER=root
DB_PASSWORD=your_mysql_password
SESSION_SECRET=set-a-long-random-secret
PORT=3000
```

`DB_PASSWORD` can be empty if the local MySQL installation does not require a password. `PORT` is optional; the server defaults to port `3000`.

---

## Installation and execution

### 1. Install dependencies

```bash
npm install
```

### 2. Create the database

Create the database in MySQL:

```sql
CREATE DATABASE saboria CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Select `saboria` and run [`trabalho3.sql`](trabalho3.sql). After creating the database, the MySQL command-line client can also import it with:

```bash
mysql -u root -p saboria < trabalho3.sql
```

### 3. Configure the environment

Create `.env` with the MySQL connection details and the session secret.

### 4. Start the server

```bash
npm start
```

The server authenticates with the database before listening on the configured port. The application is available at `http://localhost:3000`, unless `PORT` is changed.

For development with automatic restarts:

```bash
npm run dev
```

---

## Tailwind CSS

The compiled stylesheet is served from `public/css/style.css`. Rebuild it after changing views or Tailwind classes:

```bash
npm run css:build
```

To rebuild automatically during development:

```bash
npm run css:watch
```

---

## Available scripts

| Command | Description |
|---|---|
| `npm start` | Starts the server |
| `npm run dev` | Starts the server with Nodemon |
| `npm run css:build` | Builds the Tailwind stylesheet |
| `npm run css:watch` | Watches files and rebuilds the stylesheet |

---

## License

This project is licensed under the ISC License, as specified in `package.json`.
