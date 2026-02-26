@extends('layouts.app')

@section('title', 'Add New Book')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Add New Book</h1>

        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('books.store') }}">
                @csrf

                <!-- Title -->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                    <input type="text"
                           name="title"
                           id="title"
                           value="{{ old('title') }}"
                           required
                           class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <!-- Author -->
                <div class="mb-4">
                    <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Author *</label>
                    <input type="text"
                           name="author"
                           id="author"
                           value="{{ old('author') }}"
                           required
                           class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <!-- ISBN -->
                <div class="mb-4">
                    <label for="isbn" class="block text-sm font-medium text-gray-700 mb-1">ISBN *</label>
                    <input type="text"
                           name="isbn"
                           id="isbn"
                           value="{{ old('isbn') }}"
                           required
                           class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description"
                              id="description"
                              rows="4"
                              class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
                </div>

                <!-- Quantity -->
                <div class="mb-6">
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                    <input type="number"
                           name="quantity"
                           id="quantity"
                           value="{{ old('quantity', 1) }}"
                           min="1"
                           required
                           class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <!-- Buttons -->
                <div class="flex gap-4">
                    <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">
                        Add Book
                    </button>
                    <a href="{{ route('books.index') }}"
                       class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
