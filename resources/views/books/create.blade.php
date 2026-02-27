@extends('layouts.app')

@section('title', 'Add New Book')

@section('content')
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-muted mb-6">
        <a href="{{ route('books.index') }}" class="hover:text-library-700 transition-colors">Books</a>
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="text-ink font-medium">Add New Book</span>
    </nav>

    <div class="max-w-2xl">
        <h1 class="page-title mb-2">Add New Book</h1>
        <p class="text-muted text-sm mb-8">Add a new title to the library collection.</p>

        <div class="card">
            <form method="POST" action="{{ route('books.store') }}">
                @csrf
                <div class="p-6 sm:p-8 space-y-5">
                    {{-- Title --}}
                    <div>
                        <label for="title" class="form-label">Title *</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                               placeholder="e.g. The Great Gatsby"
                               class="form-input">
                    </div>

                    {{-- Author --}}
                    <div>
                        <label for="author" class="form-label">Author *</label>
                        <input type="text" name="author" id="author" value="{{ old('author') }}" required
                               placeholder="e.g. F. Scott Fitzgerald"
                               class="form-input">
                    </div>

                    {{-- ISBN --}}
                    <div>
                        <label for="isbn" class="form-label">ISBN *</label>
                        <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}" required
                               placeholder="e.g. 978-0-7432-7356-5"
                               class="form-input font-mono">
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="4"
                                  placeholder="A brief summary of the book..."
                                  class="form-input resize-y">{{ old('description') }}</textarea>
                    </div>

                    {{-- Quantity --}}
                    <div>
                        <label for="quantity" class="form-label">Quantity *</label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" min="1" required
                               class="form-input w-28">
                        <p class="text-xs text-muted mt-1.5">Number of copies in the collection.</p>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="px-6 sm:px-8 py-4 bg-library-50/50 border-t border-library-100 flex items-center gap-3">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Add Book
                    </button>
                    <a href="{{ route('books.index') }}" class="btn-ghost">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
