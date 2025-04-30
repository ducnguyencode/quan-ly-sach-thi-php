<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NguyenDucBook - @yield('title', 'Trang chủ')</title>
    <!-- Tailwind CSS từ CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8fafc;
        }
        main {
            flex: 1;
        }
        .dropdown-menu {
            display: none;
            transition: all 0.3s ease;
            transform-origin: top right;
            transform: scale(0.95);
            opacity: 0;
        }
        .dropdown-menu.show {
            display: block;
            transform: scale(1);
            opacity: 1;
        }
        .card {
            transition: all 0.3s ease;
            border-radius: 12px;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .btn-primary {
            @apply bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200;
        }
        .btn-secondary {
            @apply bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg transition-all duration-200;
        }
        .nav-link {
            position: relative;
            margin-right: 1.5rem;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: white;
            transition: width 0.3s;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        .profile-dropdown {
            cursor: pointer;
        }
        .logo-container {
            transition: transform 0.3s ease;
        }
        .logo-container:hover {
            transform: scale(1.05);
        }
        .form-input {
            @apply block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 transition-colors duration-200;
        }
        .form-input.error {
            @apply border-red-500;
        }
        .form-label {
            @apply block text-sm font-medium text-gray-700 mb-1;
        }
        .btn {
            @apply px-4 py-2 rounded-lg transition-all duration-200 font-medium;
        }
        .btn-submit {
            @apply bg-purple-600 hover:bg-purple-700 text-white shadow-sm;
        }
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="bg-gradient-to-r from-purple-600 to-blue-500 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center logo-container">
                    <a href="{{ Auth::check() ? route('home') : route('login.show') }}" class="flex items-center">
                        <div class="p-2 bg-white rounded-full shadow-md mr-3">
                            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 19.5C4 18.837 4.26339 18.2011 4.73223 17.7322C5.20107 17.2634 5.83696 17 6.5 17H20" stroke="url(#paint0_linear)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M6.5 2H20V22H6.5C5.83696 22 5.20107 21.7366 4.73223 21.2678C4.26339 20.7989 4 20.163 4 19.5V4.5C4 3.83696 4.26339 3.20107 4.73223 2.73223C5.20107 2.26339 5.83696 2 6.5 2Z" stroke="url(#paint1_linear)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <defs>
                                    <linearGradient id="paint0_linear" x1="4" y1="18.25" x2="20" y2="18.25" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#8B5CF6"/>
                                        <stop offset="1" stop-color="#3B82F6"/>
                                    </linearGradient>
                                    <linearGradient id="paint1_linear" x1="4" y1="12" x2="20" y2="12" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#8B5CF6"/>
                                        <stop offset="1" stop-color="#3B82F6"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                        <span class="text-lg font-bold">NguyenDucBook</span>
                    </a>
                </div>

                @auth
                <nav class="hidden md:flex items-center">
                    <a href="{{ route('home') }}" class="nav-link text-white hover:text-blue-100 font-medium text-sm transition-colors duration-200 flex items-center">
                        <i class="fas fa-home mr-1"></i> Trang chủ
                    </a>

                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('books.index') }}" class="nav-link text-white hover:text-blue-100 font-medium text-sm transition-colors duration-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span>Quản lý sách</span>
                    </a>
                    <a href="{{ route('authors.index') }}" class="nav-link text-white hover:text-blue-100 font-medium text-sm transition-colors duration-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Tác giả</span>
                    </a>
                    <a href="{{ route('admin.users') }}" class="nav-link text-white hover:text-blue-100 font-medium text-sm transition-colors duration-200 flex items-center">
                        <i class="fas fa-users-cog mr-1"></i> Quản lý người dùng
                    </a>
                    @else
                    <a href="{{ route('books.index') }}" class="nav-link text-white hover:text-blue-100 font-medium text-sm transition-colors duration-200 flex items-center">
                        <i class="fas fa-book mr-1"></i> Danh sách sách
                    </a>
                    @endif

                    <div class="relative ml-6">
                        <div onclick="toggleDropdown()" class="profile-dropdown flex items-center text-white hover:text-blue-100 font-medium text-sm transition-colors duration-200 px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-10">
                            <span class="w-8 h-8 flex items-center justify-center bg-white bg-opacity-20 rounded-full mr-2">
                                <i class="fas fa-user text-white"></i>
                            </span>
                            <span>{{ auth()->user()->name }}</span>
                            @if(auth()->user()->isAdmin())
                                <span class="ml-1 px-1.5 py-0.5 bg-green-500 text-xs rounded-full">Admin</span>
                            @endif
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <div id="userDropdown" class="dropdown-menu absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl py-1 z-50">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm text-gray-400">Đăng nhập với</p>
                                <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-50 hover:text-purple-600">
                                <i class="fas fa-user-cog mr-2 text-gray-400"></i> Quản lý tài khoản
                            </a>
                            <a href="{{ route('profile.password') }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-50 hover:text-purple-600">
                                <i class="fas fa-key mr-2 text-gray-400"></i> Đổi mật khẩu
                            </a>
                            <hr class="my-1 border-gray-100">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-3 text-gray-700 hover:bg-gray-50 hover:text-red-600">
                                    <i class="fas fa-sign-out-alt mr-2 text-gray-400"></i> Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                </nav>
                <button onclick="toggleMobileMenu()" class="md:hidden text-white hover:text-blue-100 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                @endauth

                @guest
                <nav class="flex items-center space-x-4">
                    <a href="{{ route('login.show') }}" class="text-white hover:text-blue-100 font-medium text-sm transition-colors duration-200 px-3 py-1.5 rounded-md hover:bg-white hover:bg-opacity-10">
                        <i class="fas fa-sign-in-alt mr-1"></i> Đăng nhập
                    </a>
                    <a href="{{ route('register.show') }}" class="bg-white text-purple-600 hover:bg-purple-50 font-medium py-1.5 px-4 rounded-md text-sm transition-colors duration-200 shadow-sm">
                        <i class="fas fa-user-plus mr-1"></i> Đăng ký
                    </a>
                </nav>
                @endguest
            </div>
        </div>
        <!-- Mobile Menu -->
        @auth
        <div id="mobileMenu" class="hidden md:hidden bg-white border-t border-purple-100 shadow-inner">
            <div class="container mx-auto px-4 py-2">
                <a href="{{ route('home') }}" class="block py-2 text-purple-600 font-medium">
                    <i class="fas fa-home mr-1"></i> Trang chủ
                </a>

                @if(auth()->user()->isAdmin())
                <a href="{{ route('books.index') }}" class="block py-2 text-purple-600 font-medium">
                    <i class="fas fa-book mr-1"></i> Quản lý sách
                </a>
                <a href="{{ route('authors.index') }}" class="block py-2 text-purple-600 font-medium">
                    <i class="fas fa-user-edit mr-1"></i> Tác giả
                </a>
                <a href="{{ route('admin.users') }}" class="block py-2 text-purple-600 font-medium">
                    <i class="fas fa-users-cog mr-1"></i> Quản lý người dùng
                </a>
                @else
                <a href="{{ route('books.index') }}" class="block py-2 text-purple-600 font-medium">
                    <i class="fas fa-book mr-1"></i> Danh sách sách
                </a>
                @endif

                <hr class="my-2 border-gray-200">
                <a href="{{ route('profile.edit') }}" class="block py-2 text-purple-600 font-medium">
                    <i class="fas fa-user-cog mr-1"></i> Quản lý tài khoản
                </a>
                <a href="{{ route('profile.password') }}" class="block py-2 text-purple-600 font-medium">
                    <i class="fas fa-key mr-1"></i> Đổi mật khẩu
                </a>
                <form action="{{ route('logout') }}" method="POST" class="py-2">
                    @csrf
                    <button type="submit" class="text-red-600 font-medium">
                        <i class="fas fa-sign-out-alt mr-1"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </div>
        @endauth
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                <div class="flex">
                    <div class="py-1"><i class="fas fa-check-circle text-green-500 mr-3"></i></div>
                    <div>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                <div class="flex">
                    <div class="py-1"><i class="fas fa-exclamation-circle text-red-500 mr-3"></i></div>
                    <div>
                        <p class="font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-10 mt-auto">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between">
                <div class="mb-6 md:mb-0">
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-white rounded-full shadow-md mr-3">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 19.5C4 18.837 4.26339 18.2011 4.73223 17.7322C5.20107 17.2634 5.83696 17 6.5 17H20" stroke="url(#paint0_linear)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M6.5 2H20V22H6.5C5.83696 22 5.20107 21.7366 4.73223 21.2678C4.26339 20.7989 4 20.163 4 19.5V4.5C4 3.83696 4.26339 3.20107 4.73223 2.73223C5.20107 2.26339 5.83696 2 6.5 2Z" stroke="url(#paint1_linear)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <defs>
                                    <linearGradient id="paint0_linear" x1="4" y1="18.25" x2="20" y2="18.25" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#8B5CF6"/>
                                        <stop offset="1" stop-color="#3B82F6"/>
                                    </linearGradient>
                                    <linearGradient id="paint1_linear" x1="4" y1="12" x2="20" y2="12" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#8B5CF6"/>
                                        <stop offset="1" stop-color="#3B82F6"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                        <span class="text-lg font-bold">NguyenDucBook</span>
                    </div>
                    <p class="text-gray-400 text-sm">Hệ thống quản lý sách hiện đại.</p>
                    <div class="flex space-x-4 mt-4">
                        <a href="https://www.facebook.com/nguyenhuynhduc1205/" class="text-gray-400 hover:text-white transition-colors duration-200">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://x.com/Nguyenduc1205" class="text-gray-400 hover:text-white transition-colors duration-200">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.instagram.com/maixephunglinh/" class="text-gray-400 hover:text-white transition-colors duration-200">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Liên kết</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white text-sm">Trang chủ</a></li>
                            <li><a href="{{ route('books.index') }}" class="text-gray-400 hover:text-white text-sm">Quản lý sách</a></li>
                            <li><a href="{{ route('authors.index') }}" class="text-gray-400 hover:text-white text-sm">Tác giả</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Trợ giúp</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white text-sm">Hướng dẫn sử dụng</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white text-sm">Câu hỏi thường gặp</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white text-sm">Chính sách</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Liên hệ</h3>
                        <ul class="space-y-2">
                            <li class="text-gray-400 text-sm flex items-start">
                                <i class="fas fa-envelope mt-1 mr-2 w-4"></i>
                                <span>huynhducnguyenht@gmail.com</span>
                            </li>
                            <li class="text-gray-400 text-sm flex items-start">
                                <i class="fas fa-phone mt-1 mr-2 w-4"></i>
                                <span>0981826971</span>
                            </li>
                            <li class="text-gray-400 text-sm flex items-start">
                                <i class="fas fa-map-marker-alt mt-1 mr-2 w-4"></i>
                                <span>Aptech D5, TP Hồ Chí Minh</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-10 pt-6 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} NguyenDucBook. Đã đăng ký Bản quyền.</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleDropdown() {
            document.getElementById("userDropdown").classList.toggle("show");
        }

        function toggleMobileMenu() {
            document.getElementById("mobileMenu").classList.toggle("hidden");
        }

        // Đóng dropdown khi click bên ngoài
        window.onclick = function(event) {
            if (!event.target.closest('.profile-dropdown')) {
                var dropdowns = document.getElementsByClassName("dropdown-menu");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</body>
</html>
