@extends('layouts.app')

@section('title', $book->title)

@section('content')
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-muted mb-6">
        <a href="{{ route('books.index') }}" class="hover:text-library-700 transition-colors">{{ __('Books') }}</a>
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="text-ink font-medium truncate">{{ $book->title }}</span>
    </nav>

    <div class="max-w-4xl">
        {{-- Hero Card --}}
        <div class="card mb-6">
            <div class="p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-bold font-serif text-ink tracking-tight leading-tight">{{ $book->title }}</h1>
                        <p class="text-lg text-muted mt-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ $book->author }}
                        </p>
                    </div>
                    <span class="{{ $book->available > 0 ? 'badge-available' : 'badge-unavailable' }} text-sm px-3! py-1! shrink-0">
                        {{ $book->available > 0 ? __('Available') : __('All Copies Borrowed') }}
                    </span>
                </div>

                {{-- Details Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 p-5 rounded-xl bg-library-50/60 border border-library-100 mb-6">
                    <div>
                        <p class="text-xs font-semibold text-library-400 uppercase tracking-wider mb-1">{{ __('ISBN') }}</p>
                        <p class="font-mono text-ink">{{ $book->isbn }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-library-400 uppercase tracking-wider mb-1">{{ __('Copies') }}</p>
                        <p class="text-ink"><span class="font-bold text-library-700">{{ $book->available }}</span> {{ __('available of') }} {{ $book->quantity }} {{ __('total') }}</p>
                    </div>
                </div>

                @if($book->description)
                    <div class="mb-6">
                        <p class="text-xs font-semibold text-library-400 uppercase tracking-wider mb-2">{{ __('Description') }}</p>
                        <p class="text-muted leading-relaxed">{{ $book->description }}</p>
                    </div>
                @endif

                {{-- Actions --}}
                <div class="flex flex-wrap gap-3 pt-4 border-t border-library-100">
                    @if($book->available > 0)
                        <a href="{{ route('borrowings.create', ['book_id' => $book->id]) }}" class="btn-success">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            {{ __('Borrow This Book') }}
                        </a>
                    @endif
                    <a href="{{ route('books.edit', $book) }}" class="btn-warning">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        {{ __('Edit') }}
                    </a>
                    <form method="POST" action="{{ route('books.destroy', $book) }}" class="inline"
                          onsubmit="return confirm(&quot;{{ __('Are you sure you want to delete this book? This action cannot be undone.') }}&quot;)">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            {{ __('Delete') }}
                        </button>
                    </form>
                    <a href="{{ route('books.index') }}" class="btn-ghost ml-auto">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        {{ __('Back to Collection') }}
                    </a>
                </div>
            </div>
        </div>

        {{-- Borrowing History --}}
        <div class="card">
            <div class="px-6 py-5 border-b border-library-100">
                <h2 class="section-title flex items-center gap-2">
                    <svg class="w-5 h-5 text-library-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ __('Borrowing History') }}
                </h2>
            </div>

            @if($book->borrowings->count() > 0)
                <div class="divide-y divide-library-100">
                    @foreach($book->borrowings as $borrowing)
                        <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-ink">{{ $borrowing->borrower_name }}</p>
                                <p class="text-xs text-muted mt-0.5">
                                    {{ $borrowing->borrowed_at->format('M d, Y') }} &mdash; {{ __('Due') }} {{ $borrowing->due_date->format('M d, Y') }}
                                </p>
                            </div>
                            @if($borrowing->returned_at)
                                <span class="badge-returned">{{ __('Returned') }} {{ $borrowing->returned_at->format('M d, Y') }}</span>
                            @elseif($borrowing->due_date->isPast())
                                <span class="badge-overdue">{{ __('Overdue') }}</span>
                            @else
                                <span class="badge-borrowed">{{ __('Borrowed') }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="px-6 py-10 text-center">
                    <p class="text-sm text-muted">{{ __('No borrowing records for this book yet.') }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection
