# 📚 Library App

A simple Library Management System built with **Laravel 12** using the MVC architecture.

---

## Group Members

**Year & Section:** *(BSIT 3-B)*

| #  | Name                   |
|----|------------------------|
| 1  | Curio, Josh Nathan     |
| 2  | Gilera, Rowena         |
| 3  | Gromea, Nehje John     |
| 4  | Sagum, Patrick         |
| 5  | Sildora, Jegrick       |

---

## About

This is a basic library application that allows users to manage books and borrowing records. It follows the **MVC (Model-View-Controller)** pattern and uses **SQLite** as its database. No authentication is required.

## Features

- **Insert Book** — Add new books with title, author, ISBN, description, and quantity
- **Borrow Book** — Borrow available books, set due dates, and return them
- **Look Up Book** — Search books by title, author, or ISBN

## Tech Stack

- **Framework:** Laravel 12
- **Language:** PHP 8.2+
- **Database:** SQLite
- **Frontend:** Blade Templates + Tailwind CSS (CDN)

## Installation

```bash
# 1. Clone the repository
git clone <repository-url>
cd library-app

# 2. Install dependencies
composer install

# 3. Copy environment file and generate app key
cp .env.example .env
php artisan key:generate

# 4. Create the database and run migrations
touch database/database.sqlite
php artisan migrate

# 5. Start the server
php artisan serve
```

Open **http://localhost:8000** in your browser.

## Project Structure

```
app/Models/Book.php              → Book model
app/Models/Borrowing.php         → Borrowing model
app/Http/Controllers/BookController.php       → Book CRUD logic
app/Http/Controllers/BorrowingController.php  → Borrow & return logic
routes/web.php                   → All route definitions
resources/views/books/           → Book views (list, create, show, edit)
resources/views/borrowings/      → Borrowing views (list, create)
resources/views/layouts/app.blade.php → Master layout
```

## License

Open-sourced under the [MIT license](https://opensource.org/licenses/MIT).
