@extends('layouts.app')

@section('title', __('Edit Book'))

@section('content')
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-muted mb-6">
        <a href="{{ route('books.index') }}" class="hover:text-library-700 transition-colors">{{ __('Books') }}</a>
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('books.show', $book) }}" class="hover:text-library-700 transition-colors truncate max-w-50">{{ $book->title }}</a>
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="text-ink font-medium">{{ __('Edit') }}</span>
    </nav>

    <div class="max-w-2xl">
        <h1 class="page-title mb-2">{{ __('Edit Book') }}</h1>
        <p class="text-muted text-sm mb-8">{{ __('Update the details for') }} <span class="font-medium text-ink">{{ $book->title }}</span>.</p>

        <div class="card">
            <form method="POST" action="{{ route('books.update', $book) }}">
                @csrf
                @method('PUT')

                <div class="p-6 sm:p-8 space-y-5">
                    {{-- Title --}}
                    <div>
                        <label for="title" class="form-label">{{ __('Title') }} *</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" required
                               class="form-input">
                    </div>

                    {{-- Author --}}
                    <div>
                        <label for="author" class="form-label">{{ __('Author') }} *</label>
                        <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}" required
                               class="form-input">
                    </div>

                    {{-- ISBN --}}
                    <div>
                        <label for="isbn" class="form-label">{{ __('ISBN') }} *</label>
                        <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}" required
                               class="form-input font-mono">
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="form-label">{{ __('Description') }}</label>
                        <textarea name="description" id="description" rows="4"
                                  class="form-input resize-y">{{ old('description', $book->description) }}</textarea>
                    </div>

                    {{-- Quantity --}}
                    <div>
                        <label for="quantity" class="form-label">{{ __('Quantity') }} *</label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $book->quantity) }}" min="1" required
                               class="form-input w-28">
                        <p class="text-xs text-muted mt-1.5">
                            {{ __('Currently') }} <span class="font-semibold text-library-700">{{ $book->available }}</span> {{ __('of') }} {{ $book->quantity }} {{ __('available') }}.
                        </p>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="px-6 sm:px-8 py-4 bg-library-50/50 border-t border-library-100 flex items-center gap-3">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        {{ __('Save Changes') }}
                    </button>
                    <a href="{{ route('books.show', $book) }}" class="btn-ghost">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
