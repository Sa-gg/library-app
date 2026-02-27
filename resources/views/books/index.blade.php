@extends('layouts.app')

@section('title', __('All Books'))

@section('content')
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
        <div>
            <h1 class="page-title">{{ __('Book Collection') }}</h1>
            <p class="text-muted mt-1 text-sm">{{ __('Browse, search, and manage your library catalog.') }}</p>
        </div>
        <a href="{{ route('books.create') }}" class="btn-primary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            {{ __('Add New Book') }}
        </a>
    </div>

    {{-- Search --}}
    <div class="card p-4 mb-8">
        <form method="GET" action="{{ route('books.index') }}" class="flex gap-3">
            <div class="relative flex-1">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-library-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="{{ __('Search by title, author, or ISBN...') }}"
                       class="form-input pl-10!">
            </div>
            <button type="submit" class="btn-primary">{{ __('Search') }}</button>
            @if(request('search'))
                <a href="{{ route('books.index') }}" class="btn-ghost">{{ __('Clear') }}</a>
            @endif
        </form>
    </div>

    {{-- Books Grid --}}
    @if($books->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            @foreach($books as $book)
                <a href="{{ route('books.show', $book) }}" class="card group hover:shadow-md hover:border-library-200 transition-all duration-300">
                    <div class="p-5">
                        {{-- Top row: title + badge --}}
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <h3 class="font-serif font-bold text-lg text-ink leading-snug group-hover:text-library-700 transition-colors line-clamp-2">
                                {{ $book->title }}
                            </h3>
                            <span class="{{ $book->available > 0 ? 'badge-available' : 'badge-unavailable' }} shrink-0 mt-0.5">
                                {{ $book->available }}/{{ $book->quantity }}
                            </span>
                        </div>

                        {{-- Author --}}
                        <p class="text-sm text-muted flex items-center gap-1.5 mb-3">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ $book->author }}
                        </p>

                        {{-- ISBN --}}
                        <p class="text-xs text-library-300 font-mono tracking-wide">{{ __('ISBN') }} {{ $book->isbn }}</p>
                    </div>

                    {{-- Card footer --}}
                    <div class="px-5 py-3 bg-library-50/50 border-t border-library-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-muted hover:text-library-700">{{ __('View') }}</span>
                            <span class="text-xs text-muted hover:text-library-700">{{ __('Edit') }}</span>
                            @if($book->available > 0)
                                <span class="text-xs text-success font-medium">{{ __('Borrow') }}</span>
                            @endif
                        </div>
                        <svg class="w-4 h-4 text-library-300 group-hover:text-library-500 group-hover:translate-x-0.5 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $books->links() }}
        </div>
    @else
        <div class="card p-12 text-center">
            <div class="w-16 h-16 rounded-full bg-library-100 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-library-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <h3 class="section-title mb-1">{{ __('No books found') }}</h3>
            <p class="text-sm text-muted mb-4">{{ __('Your collection is empty. Add your first title to get started.') }}</p>
            <a href="{{ route('books.create') }}" class="btn-primary">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                {{ __('Add First Book') }}
            </a>
        </div>
    @endif
@endsection
