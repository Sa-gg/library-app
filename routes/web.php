<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use Illuminate\Support\Facades\Route;

// Home page redirects to books index
Route::get('/', function () {
    return redirect()->route('books.index');
});

// Language switcher
Route::get('/language/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'fil', 'ja'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('language.switch');

// Book resource routes (CRUD)
Route::resource('books', BookController::class);

// Borrowing routes
Route::get('/borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
Route::get('/borrowings/create', [BorrowingController::class, 'create'])->name('borrowings.create');
Route::post('/borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');
Route::patch('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');
