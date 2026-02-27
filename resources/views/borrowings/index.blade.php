@extends('layouts.app')

@section('title', 'All Borrowings')

@section('content')
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
        <div>
            <h1 class="page-title">Borrowings</h1>
            <p class="text-muted mt-1 text-sm">Track all active and past borrowing records.</p>
        </div>
        <a href="{{ route('borrowings.create') }}" class="btn-primary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Borrow a Book
        </a>
    </div>

    @if($borrowings->count() > 0)
        {{-- Desktop Table --}}
        <div class="card hidden md:block">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-library-100">
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-library-400 uppercase tracking-wider">Book</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-library-400 uppercase tracking-wider">Borrower</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-library-400 uppercase tracking-wider">Borrowed</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-library-400 uppercase tracking-wider">Due</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-library-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3.5 text-right text-xs font-semibold text-library-400 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-library-50">
                        @foreach($borrowings as $borrowing)
                            <tr class="hover:bg-library-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <a href="{{ route('books.show', $borrowing->book) }}"
                                       class="font-medium text-ink hover:text-library-700 transition-colors font-serif">
                                        {{ $borrowing->book->title }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-ink">{{ $borrowing->borrower_name }}</p>
                                    @if($borrowing->borrower_email)
                                        <p class="text-xs text-library-300 mt-0.5">{{ $borrowing->borrower_email }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-muted">
                                    {{ $borrowing->borrowed_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-muted">
                                    {{ $borrowing->due_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($borrowing->returned_at)
                                        <span class="badge-returned">Returned</span>
                                    @elseif($borrowing->due_date->isPast())
                                        <span class="badge-overdue">Overdue</span>
                                    @else
                                        <span class="badge-borrowed">Borrowed</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if(!$borrowing->returned_at)
                                        <form method="POST" action="{{ route('borrowings.return', $borrowing) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="btn-success text-xs !py-1.5 !px-3"
                                                    onclick="return confirm('Mark this book as returned?')">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                Return
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-library-300">{{ $borrowing->returned_at->format('M d, Y') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Mobile Cards --}}
        <div class="md:hidden space-y-3">
            @foreach($borrowings as $borrowing)
                <div class="card p-4">
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <a href="{{ route('books.show', $borrowing->book) }}" class="font-serif font-bold text-ink hover:text-library-700">
                            {{ $borrowing->book->title }}
                        </a>
                        @if($borrowing->returned_at)
                            <span class="badge-returned shrink-0">Returned</span>
                        @elseif($borrowing->due_date->isPast())
                            <span class="badge-overdue shrink-0">Overdue</span>
                        @else
                            <span class="badge-borrowed shrink-0">Borrowed</span>
                        @endif
                    </div>
                    <p class="text-sm text-muted">{{ $borrowing->borrower_name }}</p>
                    <p class="text-xs text-library-300 mt-1">{{ $borrowing->borrowed_at->format('M d, Y') }} &mdash; Due {{ $borrowing->due_date->format('M d, Y') }}</p>
                    @if(!$borrowing->returned_at)
                        <form method="POST" action="{{ route('borrowings.return', $borrowing) }}" class="mt-3">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-success text-xs !py-1.5 w-full justify-center"
                                    onclick="return confirm('Mark this book as returned?')">
                                Return Book
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $borrowings->links() }}
        </div>
    @else
        <div class="card p-12 text-center">
            <div class="w-16 h-16 rounded-full bg-library-100 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-library-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
            </div>
            <h3 class="section-title mb-1">No borrowings yet</h3>
            <p class="text-sm text-muted mb-4">Start lending books to create borrowing records.</p>
            <a href="{{ route('borrowings.create') }}" class="btn-primary">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Borrow a Book
            </a>
        </div>
    @endif
@endsection
