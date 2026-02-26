@extends('layouts.app')

@section('title', 'All Borrowings')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Borrowings</h1>
        <a href="{{ route('borrowings.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
            + Borrow a Book
        </a>
    </div>

    @if($borrowings->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrower</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrowed On</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($borrowings as $borrowing)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('books.show', $borrowing->book) }}"
                                   class="text-indigo-600 hover:text-indigo-900 font-medium">
                                    {{ $borrowing->book->title }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $borrowing->borrower_name }}
                                @if($borrowing->borrower_email)
                                    <br><span class="text-gray-400 text-xs">{{ $borrowing->borrower_email }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $borrowing->borrowed_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $borrowing->due_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($borrowing->returned_at)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Returned
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if(!$borrowing->returned_at)
                                    <form method="POST" action="{{ route('borrowings.return', $borrowing) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700"
                                                onclick="return confirm('Mark this book as returned?')">
                                            Return Book
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs">{{ $borrowing->returned_at->format('M d, Y') }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $borrowings->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 text-lg">No borrowings yet.</p>
            <a href="{{ route('borrowings.create') }}" class="text-indigo-600 hover:text-indigo-800 mt-2 inline-block">
                Borrow a book →
            </a>
        </div>
    @endif
@endsection
