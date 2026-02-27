# 📚 Athenaeum — Library App

A Library Management System built with **Laravel 12** using the MVC architecture, featuring a custom "Athenaeum" design theme, multilingual support (English, Filipino, Japanese), and offline Tailwind CSS.

---

## Group Members

**Year & Section:** *(BSIT 3-B)*

| #  | Name                   |
|----|------------------------|
| 1  | Curio, Josh Nathan     |
| 2  | Gilera, Rowena         |
| 3  | Gromea, Nehje John     |
| 4  | Guanzon, Jurriel       |
| 5  | Sagum, Patrick         |
| 6  | Sildora, Jegrick       |

---

## About

A library application for managing books and borrowing records. It follows the **MVC (Model-View-Controller)** pattern and uses **SQLite** as its database. No authentication required.

## Features

- **Book Management** — Add, edit, view, and delete books with title, author, ISBN, description, and quantity
- **Borrow & Return** — Borrow available books, set due dates, mark as returned, and track overdue status
- **Search** — Search books by title, author, or ISBN with paginated results
- **Multilingual UI** — Switch between English 🇺🇸, Filipino 🇵🇭, and Japanese 🇯🇵 at any time
- **Responsive Design** — Works on desktop and mobile with a custom warm library theme
- **Sample Data** — 15 pre-seeded classic books ready to use

## Tech Stack

| Layer      | Technology                        |
|------------|-----------------------------------|
| Framework  | Laravel 12                        |
| Language   | PHP 8.2+                          |
| Database   | SQLite                            |
| Frontend   | Blade Templates + Tailwind CSS v4 |
| Build Tool | Vite 7 + @tailwindcss/vite        |
| JS         | Alpine.js (language switcher)     |
| Fonts      | Inter + Playfair Display (Google) |
| Node.js    | Required for asset compilation    |

## Installation

```bash
# 1. Clone the repository
git clone <repository-url>
cd library-app

# 2. Install PHP dependencies
composer install

# 3. Install Node.js dependencies
npm install

# 4. Copy environment file and generate app key
cp .env.example .env
php artisan key:generate

# 5. Create the database and run migrations
touch database/database.sqlite
php artisan migrate

# 6. Seed the database with sample books
php artisan db:seed

# 7. Build frontend assets
npm run build

# 8. Start the server
php artisan serve
```

Open **http://localhost:8000** in your browser.

## Project Structure

```
app/
  Http/
    Controllers/
      BookController.php          → Book CRUD logic
      BorrowingController.php     → Borrow & return logic
    Middleware/
      SetLocale.php               → Language switcher middleware
  Models/
    Book.php                      → Book model
    Borrowing.php                 → Borrowing model
database/
  migrations/                     → Database schema definitions
  seeders/
    BookSeeder.php                → 15 sample books
    DatabaseSeeder.php            → Runs all seeders
lang/
  en.json                         → English translations
  fil.json                        → Filipino translations
  ja.json                         → Japanese translations
resources/
  css/app.css                     → Tailwind v4 + custom theme
  js/app.js                       → Alpine.js entry point
  views/
    layouts/app.blade.php         → Master layout with nav + language switcher
    books/                        → Book views (index, create, show, edit)
    borrowings/                   → Borrowing views (index, create)
    vendor/pagination/
      tailwind.blade.php          → Custom themed pagination
routes/web.php                    → All route definitions
vite.config.js                    → Vite build configuration
```

## License

Open-sourced under the [MIT license](https://opensource.org/licenses/MIT).
