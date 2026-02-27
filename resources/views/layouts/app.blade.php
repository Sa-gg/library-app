<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Library') — Athenaeum</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-parchment text-ink font-sans">
    <div class="min-h-full flex flex-col">

        {{-- ===== NAVIGATION ===== --}}
        <header class="sticky top-0 z-50 backdrop-blur-md bg-parchment/80 border-b border-library-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    {{-- Logo --}}
                    <a href="{{ route('books.index') }}" class="flex items-center gap-3 group">
                        <div class="w-9 h-9 rounded-xl bg-library-700 flex items-center justify-center shadow-sm group-hover:bg-library-800 transition-colors">
                            <svg class="w-5 h-5 text-library-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold font-serif text-library-800 tracking-tight">Athenaeum</span>
                    </a>

                    {{-- Nav Links --}}
                    <nav class="hidden sm:flex items-center gap-1">
                        <a href="{{ route('books.index') }}"
                           class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                                  {{ request()->routeIs('books.*') ? 'bg-library-100 text-library-800' : 'text-muted hover:text-library-800 hover:bg-library-50' }}">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                Books
                            </span>
                        </a>
                        <a href="{{ route('borrowings.index') }}"
                           class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                                  {{ request()->routeIs('borrowings.*') ? 'bg-library-100 text-library-800' : 'text-muted hover:text-library-800 hover:bg-library-50' }}">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                Borrowings
                            </span>
                        </a>
                        <div class="w-px h-6 bg-library-200 mx-2"></div>
                        <a href="{{ route('borrowings.create') }}" class="btn-primary text-sm !py-2 !px-4">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            Borrow Book
                        </a>
                    </nav>

                    {{-- Mobile menu button --}}
                    <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="sm:hidden p-2 rounded-lg text-muted hover:bg-library-100">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>

                {{-- Mobile Nav --}}
                <div id="mobile-menu" class="hidden sm:hidden pb-4 space-y-1">
                    <a href="{{ route('books.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('books.*') ? 'bg-library-100 text-library-800' : 'text-muted' }}">Books</a>
                    <a href="{{ route('borrowings.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('borrowings.*') ? 'bg-library-100 text-library-800' : 'text-muted' }}">Borrowings</a>
                    <a href="{{ route('borrowings.create') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-library-700">+ Borrow Book</a>
                </div>
            </div>
        </header>

        {{-- ===== FLASH MESSAGES ===== --}}
        <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-4">
            @if(session('success'))
                <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-xl mb-4">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-5 py-3.5 rounded-xl mb-4">
                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 px-5 py-3.5 rounded-xl mb-4">
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        <p class="text-sm font-bold">Please fix the following errors:</p>
                    </div>
                    <ul class="list-disc list-inside text-sm ml-7 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        {{-- ===== MAIN CONTENT ===== --}}
        <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
            @yield('content')
        </main>

        {{-- ===== FOOTER ===== --}}
        <footer class="border-t border-library-100 bg-white/50 mt-auto">
            <div class="max-w-7xl mx-auto px-4 py-5 flex items-center justify-between">
                <p class="text-xs text-muted">
                    &copy; {{ date('Y') }} Athenaeum &middot; Built with Laravel
                </p>
                <div class="flex items-center gap-1 text-xs text-library-300">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
