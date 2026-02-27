<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('Library')) — Athenaeum</title>
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
                                {{ __('Books') }}
                            </span>
                        </a>
                        <a href="{{ route('borrowings.index') }}"
                           class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                                  {{ request()->routeIs('borrowings.*') ? 'bg-library-100 text-library-800' : 'text-muted hover:text-library-800 hover:bg-library-50' }}">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                {{ __('Borrowings') }}
                            </span>
                        </a>
                        <div class="w-px h-6 bg-library-200 mx-2"></div>

                        {{-- Language Switcher --}}
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open" class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium text-muted hover:text-library-800 hover:bg-library-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                                @php
                                    $localeLabels = ['en' => 'EN', 'fil' => 'FIL', 'ja' => 'JA'];
                                @endphp
                                {{ $localeLabels[app()->getLocale()] ?? 'EN' }}
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-1 w-36 bg-white rounded-xl shadow-lg border border-library-100 py-1 z-50" style="display: none;">
                                <a href="{{ route('language.switch', 'en') }}" class="flex items-center gap-2 px-3 py-2 text-sm {{ app()->getLocale() === 'en' ? 'text-library-700 font-semibold bg-library-50' : 'text-muted hover:bg-library-50 hover:text-ink' }} transition-colors">
                                    <span class="w-5 text-center">🇺🇸</span> English
                                </a>
                                <a href="{{ route('language.switch', 'fil') }}" class="flex items-center gap-2 px-3 py-2 text-sm {{ app()->getLocale() === 'fil' ? 'text-library-700 font-semibold bg-library-50' : 'text-muted hover:bg-library-50 hover:text-ink' }} transition-colors">
                                    <span class="w-5 text-center">🇵🇭</span> Filipino
                                </a>
                                <a href="{{ route('language.switch', 'ja') }}" class="flex items-center gap-2 px-3 py-2 text-sm {{ app()->getLocale() === 'ja' ? 'text-library-700 font-semibold bg-library-50' : 'text-muted hover:bg-library-50 hover:text-ink' }} transition-colors">
                                    <span class="w-5 text-center">🇯🇵</span> 日本語
                                </a>
                            </div>
                        </div>

                        <div class="w-px h-6 bg-library-200 mx-1"></div>
                        <a href="{{ route('borrowings.create') }}" class="btn-primary text-sm py-2! px-4!">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            {{ __('Borrow Book') }}
                        </a>
                    </nav>

                    {{-- Mobile menu button --}}
                    <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="sm:hidden p-2 rounded-lg text-muted hover:bg-library-100">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>

                {{-- Mobile Nav --}}
                <div id="mobile-menu" class="hidden sm:hidden pb-4 space-y-1">
                    <a href="{{ route('books.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('books.*') ? 'bg-library-100 text-library-800' : 'text-muted' }}">{{ __('Books') }}</a>
                    <a href="{{ route('borrowings.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('borrowings.*') ? 'bg-library-100 text-library-800' : 'text-muted' }}">{{ __('Borrowings') }}</a>
                    <a href="{{ route('borrowings.create') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-library-700">+ {{ __('Borrow Book') }}</a>
                    <div class="flex items-center gap-2 px-3 py-2">
                        <a href="{{ route('language.switch', 'en') }}" class="text-xs px-2 py-1 rounded {{ app()->getLocale() === 'en' ? 'bg-library-200 text-library-800 font-bold' : 'text-muted' }}">🇺🇸 EN</a>
                        <a href="{{ route('language.switch', 'fil') }}" class="text-xs px-2 py-1 rounded {{ app()->getLocale() === 'fil' ? 'bg-library-200 text-library-800 font-bold' : 'text-muted' }}">🇵🇭 FIL</a>
                        <a href="{{ route('language.switch', 'ja') }}" class="text-xs px-2 py-1 rounded {{ app()->getLocale() === 'ja' ? 'bg-library-200 text-library-800 font-bold' : 'text-muted' }}">🇯🇵 JA</a>
                    </div>
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
                        <p class="text-sm font-bold">{{ __('Please fix the following errors:') }}</p>
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
                    &copy; {{ date('Y') }} Athenaeum &middot; {{ __('Built with Laravel') }}
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
