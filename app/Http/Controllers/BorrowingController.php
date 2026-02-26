<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    /**
     * Display a listing of all borrowings.
     */
    public function index(): View
    {
        $borrowings = Borrowing::with('book')
            ->latest('borrowed_at')
            ->paginate(10);

        return view('borrowings.index', compact('borrowings'));
    }

    /**
     * Show the form for borrowing a book.
     */
    public function create(Request $request): View
    {
        $books = Book::where('available', '>', 0)->get();
        $selectedBookId = $request->query('book_id');

        return view('borrowings.create', compact('books', 'selectedBookId'));
    }

    /**
     * Store a new borrowing record.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'book_id'        => 'required|exists:books,id',
            'borrower_name'  => 'required|string|max:255',
            'borrower_email' => 'nullable|email|max:255',
            'due_date'       => 'required|date|after:today',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        // Check availability
        if ($book->available <= 0) {
            return back()->withErrors(['book_id' => 'This book is not available for borrowing.'])
                ->withInput();
        }

        // Create the borrowing record
        Borrowing::create([
            'book_id'        => $validated['book_id'],
            'borrower_name'  => $validated['borrower_name'],
            'borrower_email' => $validated['borrower_email'] ?? null,
            'borrowed_at'    => now(),
            'due_date'       => $validated['due_date'],
        ]);

        // Decrease available count
        $book->decrement('available');

        return redirect()->route('borrowings.index')
            ->with('success', 'Book borrowed successfully!');
    }

    /**
     * Return a borrowed book.
     */
    public function returnBook(Borrowing $borrowing): RedirectResponse
    {
        if ($borrowing->returned_at) {
            return back()->with('error', 'This book has already been returned.');
        }

        // Mark as returned
        $borrowing->update(['returned_at' => now()]);

        // Increase available count
        $borrowing->book->increment('available');

        return redirect()->route('borrowings.index')
            ->with('success', 'Book returned successfully!');
    }
}
