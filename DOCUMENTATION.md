# 📚 Athenaeum — Library App Documentation

A step-by-step guide to building a Library Management application using **Laravel 12** with the **MVC (Model-View-Controller)** architecture pattern. Features a custom "Athenaeum" design theme, multilingual support (EN/FIL/JA), and Tailwind CSS v4 compiled offline via Vite.

---

## Table of Contents

1. [Prerequisites](#1-prerequisites)
2. [Installation](#2-installation)
3. [Project Structure Overview](#3-project-structure-overview)
4. [Understanding MVC in Laravel](#4-understanding-mvc-in-laravel)
5. [Step 1 — Database Configuration](#step-1--database-configuration)
6. [Step 2 — Create Migrations (Database Schema)](#step-2--create-migrations-database-schema)
7. [Step 3 — Create Models (M in MVC)](#step-3--create-models-m-in-mvc)
8. [Step 4 — Create Controllers (C in MVC)](#step-4--create-controllers-c-in-mvc)
9. [Step 5 — Define Routes](#step-5--define-routes)
10. [Step 6 — Create Views (V in MVC)](#step-6--create-views-v-in-mvc)
11. [Step 7 — Run Migrations & Seed Sample Data](#step-7--run-migrations--seed-sample-data)
12. [Step 8 — Build Frontend Assets (Vite)](#step-8--build-frontend-assets-vite)
13. [Step 9 — Run the Application](#step-9--run-the-application)
14. [Additional Features](#additional-features)
15. [Features Summary](#features-summary)
16. [File Structure Recap](#file-structure-recap)
17. [Quick Reference](#quick-reference)

---

## 1. Prerequisites

- **PHP 8.2+** installed
- **Composer** (PHP dependency manager) installed
- **Node.js 18+** and **npm** installed (required for building CSS/JS assets)
- A code editor (VS Code recommended)
- A terminal / command prompt

---

## 2. Installation

### Create a new Laravel project

```bash
composer create-project laravel/laravel library-app
```

### Navigate into the project

```bash
cd library-app
```

### Install Node.js dependencies

```bash
npm install
```

### Generate app encryption key

```bash
php artisan key:generate
```

### Verify installation

```bash
php artisan --version
# Output: Laravel Framework 12.x.x
```

---

## 3. Project Structure Overview

```
library-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/           ← Controllers (C)
│   │   │   ├── BookController.php
│   │   │   └── BorrowingController.php
│   │   └── Middleware/
│   │       └── SetLocale.php      ← Language switcher middleware
│   └── Models/                    ← Models (M)
│       ├── Book.php
│       └── Borrowing.php
├── database/
│   ├── migrations/                ← Database schema definitions
│   └── seeders/
│       ├── BookSeeder.php         ← 15 sample classic books
│       └── DatabaseSeeder.php
├── lang/
│   ├── en.json                    ← English translations
│   ├── fil.json                   ← Filipino translations
│   └── ja.json                    ← Japanese translations
├── resources/
│   ├── css/
│   │   └── app.css                ← Tailwind v4 + custom Athenaeum theme
│   ├── js/
│   │   └── app.js                 ← Alpine.js entry point
│   └── views/                     ← Views (V)
│       ├── layouts/
│       │   └── app.blade.php      ← Master layout with nav + language switcher
│       ├── books/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── show.blade.php
│       │   └── edit.blade.php
│       ├── borrowings/
│       │   ├── index.blade.php
│       │   └── create.blade.php
│       └── vendor/pagination/
│           └── tailwind.blade.php ← Custom library-themed pagination
├── routes/
│   └── web.php                    ← Route definitions (CRUD + language switch)
├── vite.config.js                 ← Vite build configuration
├── .env                           ← Environment configuration
└── ...
```

---

## 4. Understanding MVC in Laravel

| Layer          | Laravel Component     | Purpose                                           |
|----------------|-----------------------|---------------------------------------------------|
| **Model**      | `app/Models/`         | Represents data & business logic. Talks to the DB. |
| **View**       | `resources/views/`    | The HTML templates (Blade). What the user sees.     |
| **Controller** | `app/Http/Controllers/` | Handles requests, processes logic, returns views.  |

### How a request flows:

```
User clicks a link
    → Route (web.php) matches the URL
        → Controller method runs
            → Model queries the database
                → Controller passes data to View
                    → View renders HTML back to browser
```

---

## Step 1 — Database Configuration

Laravel 12 uses **SQLite** by default. The `.env` file already contains:

```env
DB_CONNECTION=sqlite
```

Create the SQLite database file:

```bash
touch database/database.sqlite
```

> SQLite requires no server setup — the entire database is a single file.

---

## Step 2 — Create Migrations (Database Schema)

Migrations define the structure of your database tables using PHP code.

### Books Migration

Create file: `database/migrations/2026_02_26_000001_create_books_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();                              // Auto-increment primary key
            $table->string('title');                    // Book title
            $table->string('author');                   // Author name
            $table->string('isbn')->unique();           // ISBN (unique identifier)
            $table->text('description')->nullable();    // Optional description
            $table->integer('quantity')->default(1);    // Total copies
            $table->integer('available')->default(1);   // Available copies
            $table->timestamps();                       // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
```

### Borrowings Migration

Create file: `database/migrations/2026_02_26_000002_create_borrowings_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->string('borrower_name');
            $table->string('borrower_email')->nullable();
            $table->date('borrowed_at');
            $table->date('due_date');
            $table->date('returned_at')->nullable();   // null = still borrowed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
```

**Key concepts:**
- `$table->id()` — creates an auto-incrementing `id` column
- `$table->foreignId('book_id')->constrained()` — creates a foreign key linking to the `books` table
- `$table->timestamps()` — adds `created_at` and `updated_at` columns
- `->nullable()` — allows the column to be `NULL`

---

## Step 3 — Create Models (M in MVC)

Models represent your data and define relationships between tables.

### Book Model — `app/Models/Book.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    // Fields that can be mass-assigned (filled via forms)
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'description',
        'quantity',
        'available',
    ];

    // A book can have many borrowings (One-to-Many)
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    // Get only active (not yet returned) borrowings
    public function activeBorrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class)->whereNull('returned_at');
    }
}
```

### Borrowing Model — `app/Models/Borrowing.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'borrower_name',
        'borrower_email',
        'borrowed_at',
        'due_date',
        'returned_at',
    ];

    // Cast date strings to Carbon date objects automatically
    protected function casts(): array
    {
        return [
            'borrowed_at' => 'date',
            'due_date' => 'date',
            'returned_at' => 'date',
        ];
    }

    // A borrowing belongs to one book (inverse of One-to-Many)
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
```

**Key concepts:**
- `$fillable` — protects against mass-assignment vulnerabilities
- `HasMany` / `BelongsTo` — Eloquent relationships (one book has many borrowings)
- `casts()` — automatically converts database values to PHP types

---

## Step 4 — Create Controllers (C in MVC)

Controllers handle HTTP requests, interact with Models, and return Views.

### BookController — `app/Http/Controllers/BookController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookController extends Controller
{
    // LIST all books (with search / look up)
    public function index(Request $request): View
    {
        $query = Book::query();

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        $books = $query->latest()->paginate(10);
        return view('books.index', compact('books'));
    }

    // SHOW form to create a new book
    public function create(): View
    {
        return view('books.create');
    }

    // STORE (insert) a new book into the database
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'isbn'        => 'required|string|max:20|unique:books,isbn',
            'description' => 'nullable|string',
            'quantity'    => 'required|integer|min:1',
        ]);

        $validated['available'] = $validated['quantity'];
        Book::create($validated);

        return redirect()->route('books.index')
            ->with('success', 'Book added successfully!');
    }

    // SHOW a single book's details
    public function show(Book $book): View
    {
        $book->load(['borrowings' => function ($query) {
            $query->latest('borrowed_at');
        }]);
        return view('books.show', compact('book'));
    }

    // SHOW form to edit a book
    public function edit(Book $book): View
    {
        return view('books.edit', compact('book'));
    }

    // UPDATE basic book info
    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'isbn'        => 'required|string|max:20|unique:books,isbn,' . $book->id,
            'description' => 'nullable|string',
            'quantity'    => 'required|integer|min:1',
        ]);

        $quantityDiff = $validated['quantity'] - $book->quantity;
        $validated['available'] = max(0, $book->available + $quantityDiff);
        $book->update($validated);

        return redirect()->route('books.show', $book)
            ->with('success', 'Book updated successfully!');
    }

    // DELETE a book
    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();
        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully!');
    }
}
```

### BorrowingController — `app/Http/Controllers/BorrowingController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    // LIST all borrowings
    public function index(): View
    {
        $borrowings = Borrowing::with('book')
            ->latest('borrowed_at')
            ->paginate(10);
        return view('borrowings.index', compact('borrowings'));
    }

    // SHOW form to borrow a book
    public function create(Request $request): View
    {
        $books = Book::where('available', '>', 0)->get();
        $selectedBookId = $request->query('book_id');
        return view('borrowings.create', compact('books', 'selectedBookId'));
    }

    // STORE a new borrowing (borrow a book)
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'book_id'        => 'required|exists:books,id',
            'borrower_name'  => 'required|string|max:255',
            'borrower_email' => 'nullable|email|max:255',
            'due_date'       => 'required|date|after:today',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        if ($book->available <= 0) {
            return back()->withErrors(['book_id' => 'This book is not available.'])
                ->withInput();
        }

        Borrowing::create([
            'book_id'        => $validated['book_id'],
            'borrower_name'  => $validated['borrower_name'],
            'borrower_email' => $validated['borrower_email'] ?? null,
            'borrowed_at'    => now(),
            'due_date'       => $validated['due_date'],
        ]);

        $book->decrement('available');

        return redirect()->route('borrowings.index')
            ->with('success', 'Book borrowed successfully!');
    }

    // RETURN a borrowed book
    public function returnBook(Borrowing $borrowing): RedirectResponse
    {
        if ($borrowing->returned_at) {
            return back()->with('error', 'This book has already been returned.');
        }

        $borrowing->update(['returned_at' => now()]);
        $borrowing->book->increment('available');

        return redirect()->route('borrowings.index')
            ->with('success', 'Book returned successfully!');
    }
}
```

**Key concepts:**
- `Request $request` — access form data and query parameters
- `$request->validate([...])` — validate input, return errors if invalid
- `Book $book` — **Route Model Binding** (Laravel auto-fetches the Book by ID)
- `compact('books')` — passes variables to the view
- `redirect()->route(...)` — redirects to a named route
- `->with('success', ...)` — flash a success message to the session

---

## Step 5 — Define Routes

Routes map URLs to controller methods.

### `routes/web.php`

```php
<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use Illuminate\Support\Facades\Route;

// Home redirects to books list
Route::get('/', function () {
    return redirect()->route('books.index');
});

// Book CRUD routes (resource generates 7 routes automatically)
Route::resource('books', BookController::class);

// Borrowing routes
Route::get('/borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
Route::get('/borrowings/create', [BorrowingController::class, 'create'])->name('borrowings.create');
Route::post('/borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');
Route::patch('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');
```

**`Route::resource('books', BookController::class)` generates these routes automatically:**

| Method     | URI                  | Action  | Route Name     |
|------------|----------------------|---------|----------------|
| GET        | `/books`             | index   | books.index    |
| GET        | `/books/create`      | create  | books.create   |
| POST       | `/books`             | store   | books.store    |
| GET        | `/books/{book}`      | show    | books.show     |
| GET        | `/books/{book}/edit` | edit    | books.edit     |
| PUT/PATCH  | `/books/{book}`      | update  | books.update   |
| DELETE     | `/books/{book}`      | destroy | books.destroy  |

---

## Step 6 — Create Views (V in MVC)

Views use **Blade** — Laravel's templating engine. Files end in `.blade.php`.

### Layout — `resources/views/layouts/app.blade.php`

The master layout defines the shared HTML structure (navbar, flash messages, footer). Other views **extend** this layout.

```blade
@yield('content')   {{-- Placeholder for page-specific content --}}
```

### Key Blade Syntax

| Syntax                     | Meaning                                  |
|----------------------------|------------------------------------------|
| `@extends('layouts.app')`  | Inherit from the layout                  |
| `@section('content')`      | Define content for a `@yield` placeholder|
| `{{ $variable }}`          | Echo a variable (auto-escaped)           |
| `@if ... @endif`           | Conditional rendering                    |
| `@foreach ... @endforeach` | Loop through a collection                |
| `@csrf`                    | Include CSRF token (required for forms)  |
| `@method('PUT')`           | Spoof HTTP methods for forms             |
| `{{ route('name') }}`      | Generate URL from a named route          |

### Views created

| File                                      | Purpose                        |
|-------------------------------------------|--------------------------------|
| `resources/views/layouts/app.blade.php`   | Master layout with navbar      |
| `resources/views/books/index.blade.php`   | List books + search bar        |
| `resources/views/books/create.blade.php`  | Form to add a new book         |
| `resources/views/books/show.blade.php`    | Book details + borrow history  |
| `resources/views/books/edit.blade.php`    | Form to edit a book            |
| `resources/views/borrowings/index.blade.php`  | List all borrowings        |
| `resources/views/borrowings/create.blade.php` | Form to borrow a book      |

---

## Step 7 — Run Migrations & Seed Sample Data

Create the database tables and populate with 15 classic sample books:

```bash
touch database/database.sqlite
php artisan migrate
php artisan db:seed
```

Expected output:

```
INFO  Running migrations.

  0001_01_01_000000_create_users_table ................. DONE
  0001_01_01_000001_create_cache_table ................. DONE
  0001_01_01_000002_create_jobs_table .................. DONE
  2026_02_26_000001_create_books_table ................. DONE
  2026_02_26_000002_create_borrowings_table ............ DONE

INFO  Seeding database.
```

The seeder inserts 15 classic books including *To Kill a Mockingbird*, *1984*, *Pride and Prejudice*, *Noli Me Tángere*, *Norwegian Wood*, *Dune*, and more.

To reset and reseed from scratch:

```bash
php artisan migrate:fresh --seed
```

---

## Step 8 — Build Frontend Assets (Vite)

Compile Tailwind CSS v4 and Alpine.js for production:

```bash
npm run build
```

Expected output:

```
✓ built in X.XXs
dist/assets/app-[hash].css   ~74 kB
dist/assets/app-[hash].js    ~83 kB
```

For development with hot-reload:

```bash
npm run dev
```

---

## Step 9 — Run the Application

Start the development server:

```bash
php artisan serve
```

Open your browser and go to: **http://localhost:8000**

---

## Additional Features

### Multilingual Support (EN / FIL / JA)

The app supports three languages switchable at runtime using a language switcher in the navigation bar.

**How it works:**

1. User clicks a flag emoji (🇺🇸 EN / 🇵🇭 FIL / 🇯🇵 JA) in the nav dropdown
2. A GET request is sent to `/language/{locale}`
3. `SetLocale` middleware reads `session('locale')` on every request and calls `App::setLocale()`
4. All view strings use the `__('key')` helper which resolves from `lang/{locale}.json`

**Translation files:** `lang/en.json`, `lang/fil.json`, `lang/ja.json` — ~89 keys each

**SetLocale middleware** (`app/Http/Middleware/SetLocale.php`):

```php
public function handle(Request $request, Closure $next): Response
{
    $locale = session('locale', 'en');
    if (in_array($locale, ['en', 'fil', 'ja'])) {
        App::setLocale($locale);
    }
    return $next($request);
}
```

**Language switch route** (`routes/web.php`):

```php
Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fil', 'ja'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('language.switch');
```

---

### Custom "Athenaeum" Design Theme

The app uses a warm, library-inspired color palette built with Tailwind CSS v4's `@theme` block in `resources/css/app.css`.

**Color Tokens:**

| Token              | Description                   |
|--------------------|-------------------------------|
| `library-50`       | Near-white warm tint           |
| `library-100–200`  | Light parchment backgrounds    |
| `library-600–700`  | Primary action colors (brown)  |
| `library-800–900`  | Dark text and header shades    |
| `--color-parchment`| Page background (#fdf8f0)      |
| `--color-ink`      | Primary text (#2c1810)         |
| `--color-muted`    | Secondary text (#6b5344)       |

**Component Classes:**

| Class             | Usage                         |
|-------------------|-------------------------------|
| `.btn-primary`    | Main action buttons            |
| `.btn-success`    | Positive actions (add, save)   |
| `.btn-danger`     | Destructive actions (delete)   |
| `.btn-warning`    | Neutral warnings (edit)        |
| `.btn-ghost`      | Subtle links/actions           |
| `.card`           | Content card containers        |
| `.form-input`     | Styled text inputs             |
| `.form-label`     | Input labels                   |
| `.badge-available`| Green availability badge       |
| `.badge-borrowed` | Orange borrowed status         |
| `.badge-overdue`  | Red overdue warning            |
| `.badge-returned` | Gray returned status           |
| `.page-title`     | H1 page headings               |
| `.section-title`  | H2 section headings            |

---

### Custom Pagination

Laravel's built-in pagination view was published and restyled to match the library theme.

**Publish command used:**

```bash
php artisan vendor:publish --tag=laravel-pagination
```

The published view at `resources/views/vendor/pagination/tailwind.blade.php` was rewritten with:
- Active page: `bg-library-700 text-white rounded-lg`
- Inactive pages: `bg-white border-library-200 text-library-600 rounded-lg`
- Disabled arrows: `bg-library-50 border-library-100 text-library-300`
- Mobile view: shows "Page X / Y" counter
- Desktop view: shows "Showing X to Y of Z results"

---

## Features Summary

### 1. 📖 Managing Books

- Navigate to **Books → Add New Book**
- Fill in Title, Author, ISBN, Description, and Quantity
- Edit or delete books from the list or detail page
- **MVC flow:** View (form) → Route → Controller (`store`/`update`/`destroy`) → Model (`Book`)

### 2. 📚 Borrowing & Returning

- Click **Borrow a Book** or "Borrow" next to a book
- Select a book, enter borrower name, email, and due date
- Submit → borrowing record is created, available count decreases
- Click "Return Book" in the Borrowings list to mark as returned
- Overdue items are highlighted automatically
- **MVC flow:** View (form) → Route → Controller (`store` / `returnBook`) → Model (`Borrowing`, `Book`)

### 3. 🔍 Search & Browse

- Use the search bar on the Books page to filter by title, author, or ISBN
- Results are paginated (10 per page) with a custom library-themed paginator
- Click a book title to see full details and borrowing history
- **MVC flow:** View → Route → Controller (`index` with `?search=`) → Model (`where LIKE`) → View

### 4. 🌐 Language Switching

- Click the globe/flag dropdown in the top navigation bar
- Select 🇺🇸 English, 🇵🇭 Filipino, or 🇯🇵 Japanese
- All UI text, labels, buttons, and messages change instantly
- Preference is stored in the session

---

## File Structure Recap

```
library-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── BookController.php          ← Book CRUD operations
│   │   │   └── BorrowingController.php     ← Borrow & return logic
│   │   └── Middleware/
│   │       └── SetLocale.php               ← Session-based language switcher
│   └── Models/
│       ├── Book.php                        ← Book model + relationships
│       └── Borrowing.php                   ← Borrowing model + relationships
├── database/
│   ├── database.sqlite                     ← SQLite database file
│   ├── migrations/
│   │   ├── 2026_02_26_000001_create_books_table.php
│   │   └── 2026_02_26_000002_create_borrowings_table.php
│   └── seeders/
│       ├── BookSeeder.php                  ← 15 classic sample books
│       └── DatabaseSeeder.php             ← Runs all seeders
├── lang/
│   ├── en.json                             ← English (~89 keys)
│   ├── fil.json                            ← Filipino (~89 keys)
│   └── ja.json                             ← Japanese (~89 keys)
├── resources/
│   ├── css/app.css                         ← Tailwind v4 + Athenaeum theme
│   ├── js/app.js                           ← Alpine.js bootstrap
│   └── views/
│       ├── layouts/app.blade.php           ← Master layout + language dropdown
│       ├── books/
│       │   ├── index.blade.php             ← Book list + search
│       │   ├── create.blade.php            ← Add book form
│       │   ├── show.blade.php              ← Book detail
│       │   └── edit.blade.php             ← Edit book form
│       ├── borrowings/
│       │   ├── index.blade.php             ← Borrowing list
│       │   └── create.blade.php            ← Borrow form
│       └── vendor/pagination/
│           └── tailwind.blade.php          ← Custom themed pagination
├── routes/web.php                          ← All routes (CRUD + language switch)
├── vite.config.js                          ← Vite + Tailwind build config
└── .env                                    ← Database & app configuration
```

---

## Quick Reference

| Command | Purpose |
|---------|---------|
| `composer create-project laravel/laravel library-app` | Create new project |
| `npm install` | Install Node.js dependencies |
| `php artisan key:generate` | Generate encryption key |
| `php artisan migrate` | Run database migrations |
| `php artisan db:seed` | Seed all seeders |
| `php artisan db:seed --class=BookSeeder` | Run only BookSeeder |
| `php artisan migrate:fresh --seed` | Reset DB and reseed |
| `npm run build` | Compile assets for production |
| `npm run dev` | Start Vite dev server (hot-reload) |
| `php artisan serve` | Start Laravel development server |
| `php artisan route:list` | View all registered routes |
| `php artisan migrate:status` | Check migration status |
| `php artisan vendor:publish --tag=laravel-pagination` | Publish pagination views |

**Happy Coding! 🎉**
