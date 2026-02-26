<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Display a listing of books.
     */
    public function index(Request $request): View
    {
        $query = Book::query();

        // Search / Look Up functionality
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

    /**
     * Show the form for creating a new book.
     */
    public function create(): View
    {
        return view('books.create');
    }

    /**
     * Store a newly created book in the database.
     */
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

    /**
     * Display the specified book.
     */
    public function show(Book $book): View
    {
        $book->load(['borrowings' => function ($query) {
            $query->latest('borrowed_at');
        }]);

        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified book.
     */
    public function edit(Book $book): View
    {
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified book in the database.
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'isbn'        => 'required|string|max:20|unique:books,isbn,' . $book->id,
            'description' => 'nullable|string',
            'quantity'    => 'required|integer|min:1',
        ]);

        // Adjust available count based on quantity change
        $quantityDiff = $validated['quantity'] - $book->quantity;
        $validated['available'] = max(0, $book->available + $quantityDiff);

        $book->update($validated);

        return redirect()->route('books.show', $book)
            ->with('success', 'Book updated successfully!');
    }

    /**
     * Remove the specified book from the database.
     */
    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully!');
    }
}
