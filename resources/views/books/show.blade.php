@extends('layouts.app')

@section('title', $book->title)

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Book Details Card -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $book->title }}</h1>
                    <p class="text-lg text-gray-600 mt-1">by {{ $book->author }}</p>
                </div>
                <span class="px-3 py-1 text-sm font-semibold rounded-full
                    {{ $book->available > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $book->available > 0 ? 'Available' : 'All Copies Borrowed' }}
                </span>
            </div>

            <div class="mt-4 grid grid-cols-2 gap-4">
                <div>
                    <span class="text-sm text-gray-500">ISBN</span>
                    <p class="text-gray-800 font-mono">{{ $book->isbn }}</p>
                </div>
                <div>
                    <span class="text-sm text-gray-500">Copies</span>
                    <p class="text-gray-800">{{ $book->available }} available out of {{ $book->quantity }} total</p>
                </div>
            </div>

            @if($book->description)
                <div class="mt-4">
                    <span class="text-sm text-gray-500">Description</span>
                    <p class="text-gray-700 mt-1">{{ $book->description }}</p>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="mt-6 flex gap-3">
                @if($book->available > 0)
                    <a href="{{ route('borrowings.create', ['book_id' => $book->id]) }}"
                       class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                        Borrow This Book
                    </a>
                @endif
                <a href="{{ route('books.edit', $book) }}"
                   class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">
                    Edit
                </a>
                <form method="POST" action="{{ route('books.destroy', $book) }}" class="inline"
                      onsubmit="return confirm('Are you sure you want to delete this book?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                        Delete
                    </button>
                </form>
                <a href="{{ route('books.index') }}"
                   class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                    Back to List
                </a>
            </div>
        </div>

        <!-- Borrowing History -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Borrowing History</h2>

            @if($book->borrowings->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Borrower</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Borrowed On</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($book->borrowings as $borrowing)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $borrowing->borrower_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $borrowing->borrowed_at->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $borrowing->due_date->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @if($borrowing->returned_at)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Returned {{ $borrowing->returned_at->format('M d, Y') }}
                                        </span>
                                    @elseif($borrowing->due_date->isPast())
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Overdue
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Borrowed
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500">No borrowing history for this book.</p>
            @endif
        </div>
    </div>
@endsection
