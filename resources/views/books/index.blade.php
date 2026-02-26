@extends('layouts.app')

@section('title', 'All Books')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Books</h1>
        <a href="{{ route('books.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
            + Add New Book
        </a>
    </div>

    <!-- Search / Look Up -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form method="GET" action="{{ route('books.index') }}" class="flex gap-4">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search by title, author, or ISBN..."
                   class="flex-1 border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('books.index') }}"
                   class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Books Table -->
    @if($books->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ISBN</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Available</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($books as $book)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $book->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('books.show', $book) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                                    {{ $book->title }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $book->author }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $book->isbn }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $book->available > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $book->available }} / {{ $book->quantity }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                <a href="{{ route('books.show', $book) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                <a href="{{ route('books.edit', $book) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                @if($book->available > 0)
                                    <a href="{{ route('borrowings.create', ['book_id' => $book->id]) }}"
                                       class="text-green-600 hover:text-green-900">Borrow</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $books->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 text-lg">No books found.</p>
            <a href="{{ route('books.create') }}" class="text-indigo-600 hover:text-indigo-800 mt-2 inline-block">
                Add your first book →
            </a>
        </div>
    @endif
@endsection
