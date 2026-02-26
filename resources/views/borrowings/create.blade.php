@extends('layouts.app')

@section('title', 'Borrow a Book')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Borrow a Book</h1>

        <div class="bg-white rounded-lg shadow p-6">
            @if($books->count() > 0)
                <form method="POST" action="{{ route('borrowings.store') }}">
                    @csrf

                    <!-- Book Selection -->
                    <div class="mb-4">
                        <label for="book_id" class="block text-sm font-medium text-gray-700 mb-1">Select Book *</label>
                        <select name="book_id"
                                id="book_id"
                                required
                                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">-- Choose a Book --</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}"
                                    {{ (old('book_id', $selectedBookId) == $book->id) ? 'selected' : '' }}>
                                    {{ $book->title }} by {{ $book->author }} ({{ $book->available }} available)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Borrower Name -->
                    <div class="mb-4">
                        <label for="borrower_name" class="block text-sm font-medium text-gray-700 mb-1">Borrower Name *</label>
                        <input type="text"
                               name="borrower_name"
                               id="borrower_name"
                               value="{{ old('borrower_name') }}"
                               required
                               class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <!-- Borrower Email -->
                    <div class="mb-4">
                        <label for="borrower_email" class="block text-sm font-medium text-gray-700 mb-1">Borrower Email</label>
                        <input type="email"
                               name="borrower_email"
                               id="borrower_email"
                               value="{{ old('borrower_email') }}"
                               class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <!-- Due Date -->
                    <div class="mb-6">
                        <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Due Date *</label>
                        <input type="date"
                               name="due_date"
                               id="due_date"
                               value="{{ old('due_date', now()->addDays(14)->format('Y-m-d')) }}"
                               min="{{ now()->addDay()->format('Y-m-d') }}"
                               required
                               class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4">
                        <button type="submit"
                                class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700">
                            Borrow Book
                        </button>
                        <a href="{{ route('borrowings.index') }}"
                           class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400">
                            Cancel
                        </a>
                    </div>
                </form>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500 text-lg">No books available for borrowing right now.</p>
                    <a href="{{ route('books.index') }}" class="text-indigo-600 hover:text-indigo-800 mt-2 inline-block">
                        View all books →
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
