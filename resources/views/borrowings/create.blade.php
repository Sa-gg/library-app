@extends('layouts.app')

@section('title', 'Borrow a Book')

@section('content')
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-muted mb-6">
        <a href="{{ route('borrowings.index') }}" class="hover:text-library-700 transition-colors">Borrowings</a>
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="text-ink font-medium">New Borrowing</span>
    </nav>

    <div class="max-w-2xl">
        <h1 class="page-title mb-2">Borrow a Book</h1>
        <p class="text-muted text-sm mb-8">Fill in the details below to check out a book.</p>

        <div class="card">
            @if($books->count() > 0)
                <form method="POST" action="{{ route('borrowings.store') }}">
                    @csrf

                    <div class="p-6 sm:p-8 space-y-5">
                        {{-- Book Selection --}}
                        <div>
                            <label for="book_id" class="form-label">Select Book *</label>
                            <select name="book_id" id="book_id" required class="form-input">
                                <option value="">— Choose a book —</option>
                                @foreach($books as $book)
                                    <option value="{{ $book->id }}"
                                        {{ (old('book_id', $selectedBookId) == $book->id) ? 'selected' : '' }}>
                                        {{ $book->title }} by {{ $book->author }} ({{ $book->available }} available)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Borrower Name --}}
                        <div>
                            <label for="borrower_name" class="form-label">Borrower Name *</label>
                            <input type="text" name="borrower_name" id="borrower_name" value="{{ old('borrower_name') }}" required
                                   placeholder="Full name of the borrower"
                                   class="form-input">
                        </div>

                        {{-- Borrower Email --}}
                        <div>
                            <label for="borrower_email" class="form-label">Borrower Email</label>
                            <input type="email" name="borrower_email" id="borrower_email" value="{{ old('borrower_email') }}"
                                   placeholder="email@example.com (optional)"
                                   class="form-input">
                        </div>

                        {{-- Due Date --}}
                        <div>
                            <label for="due_date" class="form-label">Due Date *</label>
                            <input type="date" name="due_date" id="due_date"
                                   value="{{ old('due_date', now()->addDays(14)->format('Y-m-d')) }}"
                                   min="{{ now()->addDay()->format('Y-m-d') }}"
                                   required
                                   class="form-input w-52">
                            <p class="text-xs text-muted mt-1.5">Default is 14 days from today.</p>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="px-6 sm:px-8 py-4 bg-library-50/50 border-t border-library-100 flex items-center gap-3">
                        <button type="submit" class="btn-success">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Confirm Borrowing
                        </button>
                        <a href="{{ route('borrowings.index') }}" class="btn-ghost">Cancel</a>
                    </div>
                </form>
            @else
                <div class="p-12 text-center">
                    <div class="w-16 h-16 rounded-full bg-library-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-library-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h3 class="section-title mb-1">No books available</h3>
                    <p class="text-sm text-muted mb-4">All copies are currently borrowed.</p>
                    <a href="{{ route('books.index') }}" class="btn-secondary">View All Books</a>
                </div>
            @endif
        </div>
    </div>
@endsection
