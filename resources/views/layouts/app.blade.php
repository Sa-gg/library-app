<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Library App')</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-indigo-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('books.index') }}" class="text-white text-xl font-bold">
                        📚 Library App
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('books.index') }}"
                       class="text-indigo-100 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                        Books
                    </a>
                    <a href="{{ route('books.create') }}"
                       class="text-indigo-100 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                        Add Book
                    </a>
                    <a href="{{ route('borrowings.index') }}"
                       class="text-indigo-100 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                        Borrowings
                    </a>
                    <a href="{{ route('borrowings.create') }}"
                       class="bg-indigo-500 text-white hover:bg-indigo-400 px-4 py-2 rounded-md text-sm font-medium">
                        Borrow a Book
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-8">
        <div class="max-w-7xl mx-auto px-4 py-4 text-center text-gray-500 text-sm">
            Library App &copy; {{ date('Y') }} — Built with Laravel
        </div>
    </footer>
</body>
</html>
