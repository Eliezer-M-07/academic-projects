🇺🇸 English | [🇧🇷 Português](README.md)

---

<img src="https://github.com/user-attachments/assets/59a50e72-04e2-4fa1-a9ea-726220b2c1d9" width="100%" alt="Library">

# Library

![Laravel](https://img.shields.io/badge/Laravel-12-000000?style=flat-square)
![PHP](https://img.shields.io/badge/PHP-8.2.12-000000?style=flat-square)
![Blade](https://img.shields.io/badge/Blade-000000?style=flat-square)
![MySQL](https://img.shields.io/badge/MySQL-000000?style=flat-square)

Web application developed with Laravel as an academic project, with the goal of implementing a complete CRUD for managing books read by users.

---

## About the Project

The project consists of a web application for managing books that users have read.

Each user can create their own account, log in, and register books they have already read, providing information such as title, author, genre, publication year, rating, and completion date.

The application uses Laravel's built-in authentication system and the `auth` middleware to restrict access to book-related features.

Each book is associated with the user who created it, allowing users to manage their own collection of books.

This project was developed as part of a university assignment, focusing on the implementation of a CRUD using the Laravel framework.

---

## Technologies Used

| Technology | Role in the Project |
|---|---|
| PHP 8.2.12 | Programming language |
| Laravel 12 | Main application framework |
| Blade | Template engine used to build the application's views |
| MySQL | Relational database |
| Eloquent ORM | Database interaction |
| Laravel Authentication | User authentication system |
| `auth` Middleware | Protects routes that require authentication |
| Migrations | Database structure creation and management |

---

## Features

* User registration
* Login and logout
* Authentication using Laravel's built-in features
* Route protection using the `auth` middleware
* Book creation
* Book listing
* Book viewing
* Book editing
* Book deletion
* Association of books with the authenticated user
* Book rating
* Reading completion date
* File upload and storage for books

---

## Book Information

Each registered book contains the following information:

| Field | Description |
|---|---|
| `id` | Unique identifier of the book |
| `user_id` | User responsible for creating the book |
| `titulo` | Book title |
| `autor` | Book author |
| `genero` | Book genre |
| `ano_publicacao` | Publication year |
| `nota` | Rating given to the book |
| `data_conclusao` | Date when the book was finished |
| `arquivo` | File related to the book |
| `created_at` | Record creation date |
| `updated_at` | Last record update date |

---

## Database Structure

The books table has a relationship with the users table through the `user_id` foreign key.

```text
User
 │
 │ 1:N
 │
 ▼
Book
```

A user can have multiple registered books, while each book belongs to a single user.

When a user is deleted, all books associated with that user are also deleted through `cascadeOnDelete()`.

### Migration

```php
$table->id();
$table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->string('titulo');
$table->string('autor');
$table->string('genero');
$table->integer('ano_publicacao');
$table->decimal('nota', 3, 1);
$table->date('data_conclusao');
$table->string('arquivo');
$table->timestamps();
```

---

## How It Works

```text
User accesses the application
        ↓
Creates an account
        ↓
Logs in
        ↓
Accesses the books section
        ↓
Registers a book
        ↓
Provides the book information
        ↓
The book is associated with the authenticated user
        ↓
The user can view, edit, or delete their books
```

---

## Authentication

The application uses Laravel's built-in authentication system.

The routes responsible for book management are protected by the:

```php
auth
```

middleware.

This ensures that only authenticated users can access the book management features.

---

## Book CRUD

The system implements the four main CRUD operations:

### Create

Allows users to register a new book by providing its information and recording their completed reading.

### Read

Allows users to view and list the books they have registered.

### Update

Allows users to edit the information of an existing book.

### Delete

Allows users to remove a book from their collection.

---

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/your-username/academic-projects.git
```

Navigate to the repository:

```bash
cd academic-projects
```

Then, navigate to the specific project directory:

```bash
cd CRUD books
```

### 2. Install dependencies

```bash
composer install
```

### 3. Configure the environment

Copy the `.env.example` file:

```bash
cp .env.example .env
```

On Windows, if necessary, you can also simply copy `.env.example` and rename it to `.env`.

Configure your database connection in the `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=username
DB_PASSWORD=password
```

### 4. Generate the application key

```bash
php artisan key:generate
```

### 5. Run the migrations

```bash
php artisan migrate
```

### 6. Start the development server

```bash
php artisan serve
```

The application will be available at:

```text
http://127.0.0.1:8000
```

---

## Requirements

Before running the project, make sure you have the following installed:

* PHP 8.2 or higher
* Composer
* MySQL
* PHP extensions required by Laravel 12

---

## Academic Context

This project was developed as part of a university assignment, with the main goal of applying practical concepts related to web development, databases, user authentication, and CRUD operations using the Laravel framework.

---