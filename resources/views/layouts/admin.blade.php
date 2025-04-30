<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Quản lý sách (Admin)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Thanh điều hướng -->
        <nav class="bg-blue-800 text-white shadow-md">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold">Quản lý sách</a>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('books.index') }}" class="hover:underline">Sách</a>
                    <a href="{{ route('authors.index') }}" class="hover:underline">Tác giả</a>
                    <a href="{{ route('admin.users') }}" class="hover:underline">Người dùng</a>

                    <div class="relative group">
                        <button class="flex items-center space-x-1 focus:outline-none">
                            <span>{{ Auth::user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden group-hover:block">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Tài khoản</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Đăng xuất</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Thanh công cụ phụ (nếu cần) -->
        <div class="bg-blue-700 text-white">
            <div class="container mx-auto px-4 py-2">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold">@yield('page-title', 'Trang quản trị')</h2>

                    <div class="flex space-x-2">
                        @yield('action-buttons')
                    </div>
                </div>
            </div>
        </div>

        <!-- Nội dung chính -->
        <main class="flex-grow container mx-auto px-4 py-6">
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

            @yield('content')
        </main>

        <!-- Chân trang -->
        <footer class="bg-blue-800 text-white py-4">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center">
                    <p>&copy; {{ date('Y') }} Hệ thống quản lý sách</p>
                    <p class="text-sm">Phiên bản: 1.0</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Thêm JavaScript nếu cần
    </script>
</body>
</html>
