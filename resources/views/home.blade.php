@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center pb-6 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">
                <i class="fas fa-book-open text-indigo-600 mr-2"></i>Thư viện sách
            </h1>
            <form action="{{ route('books.search') }}" method="GET" class="relative w-full md:w-64">
                <input type="text" name="q" id="searchInput" placeholder="Tìm kiếm sách..." value="{{ $search ?? '' }}"
                    class="w-full px-4 py-2 pr-10 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <i class="fas fa-search text-gray-400 hover:text-indigo-500"></i>
                </button>
            </form>
        </div>
        @isset($search)
            <div class="my-4 text-gray-600">
                <p>Kết quả tìm kiếm cho: <span class="font-semibold">{{ $search }}</span></p>
            </div>
        @endisset

        <!-- Tùy chọn sắp xếp -->
        <div class="my-4 flex flex-wrap items-center">
            <span class="text-sm text-gray-600 mr-2">Sắp xếp theo:</span>
            <div class="flex flex-wrap gap-2">
                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'title', 'direction' => (request('sort_by') == 'title' && request('direction') == 'asc') ? 'desc' : 'asc']) }}"
                    class="px-3 py-1 rounded-full text-sm {{ request('sort_by') == 'title' || !request('sort_by') ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Tên
                    @if(request('sort_by') == 'title' || !request('sort_by'))
                        <i class="fas fa-sort-{{ request('direction') == 'desc' ? 'down' : 'up' }}"></i>
                    @endif
                </a>

                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'year', 'direction' => (request('sort_by') == 'year' && request('direction') == 'asc') ? 'desc' : 'asc']) }}"
                    class="px-3 py-1 rounded-full text-sm {{ request('sort_by') == 'year' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Năm xuất bản
                    @if(request('sort_by') == 'year')
                        <i class="fas fa-sort-{{ request('direction') == 'desc' ? 'down' : 'up' }}"></i>
                    @endif
                </a>

                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'rating', 'direction' => (request('sort_by') == 'rating' && request('direction') == 'asc') ? 'desc' : 'asc']) }}"
                    class="px-3 py-1 rounded-full text-sm {{ request('sort_by') == 'rating' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Đánh giá
                    @if(request('sort_by') == 'rating')
                        <i class="fas fa-sort-{{ request('direction') == 'desc' ? 'down' : 'up' }}"></i>
                    @endif
                </a>

                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'reviews_count', 'direction' => (request('sort_by') == 'reviews_count' && request('direction') == 'asc') ? 'desc' : 'asc']) }}"
                    class="px-3 py-1 rounded-full text-sm {{ request('sort_by') == 'reviews_count' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Số lượng đánh giá
                    @if(request('sort_by') == 'reviews_count')
                        <i class="fas fa-sort-{{ request('direction') == 'desc' ? 'down' : 'up' }}"></i>
                    @endif
                </a>
            </div>
        </div>
    </div>

    @if($books->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-10 text-center">
            <div class="text-6xl text-indigo-200 mb-4 flex justify-center">
                <i class="fas fa-book-open"></i>
            </div>
            @if(isset($search))
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Không tìm thấy sách</h3>
                <p class="text-gray-500 mb-6">Không có sách nào phù hợp với từ khóa "{{ $search }}".</p>
                <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-800">
                    <i class="fas fa-arrow-left mr-1"></i> Quay lại trang chủ
                </a>
            @else
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Chưa có sách nào</h3>
                <p class="text-gray-500 mb-6">Hệ thống chưa có sách nào được thêm vào.</p>
            @endif
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($books as $book)
                <div class="bg-white rounded-lg shadow-md overflow-hidden card">
                    <div class="h-52 bg-gray-200 flex items-center justify-center relative overflow-hidden">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="h-full w-full object-cover transition-transform duration-500 hover:scale-110">
                        @else
                            <div class="text-7xl text-gray-400 flex items-center justify-center w-full h-full bg-gray-100">
                                <i class="fas fa-book"></i>
                            </div>
                        @endif
                        <div class="absolute top-0 right-0 mt-2 mr-2">
                            <span class="bg-indigo-600 text-white text-xs px-2 py-1 rounded-full">{{ $book->published_year ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="mb-1 text-xs text-gray-500">
                            @if($book->authors->isNotEmpty())
                                <i class="fas fa-user-edit mr-1"></i> {{ $book->authors->pluck('name')->join(', ') }}
                            @else
                                <i class="fas fa-user-edit mr-1"></i> Không có tác giả
                            @endif
                        </div>
                        <h2 class="text-xl font-bold mb-2 text-gray-800">{{ $book->title }}</h2>

                        <!-- Đánh giá sao -->
                        <div class="flex items-center mb-2">
                            <div class="flex">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $book->average_rating)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500 ml-1">
                                ({{ $book->reviews_count > 0 ? $book->reviews_count : 'Chưa có' }} đánh giá)
                            </span>
                        </div>

                        <p class="text-gray-600 mb-4 text-sm line-clamp-3">{{ Str::limit($book->description, 150) }}</p>

                        <div class="flex justify-between items-center">
                            <a href="{{ route('books.show', $book->id) }}" class="text-indigo-600 hover:text-indigo-800 flex items-center text-sm">
                                <span>Xem chi tiết</span>
                                <i class="fas fa-arrow-right ml-1 text-xs"></i>
                            </a>
                            @if($book->isbn)
                                <span class="text-xs text-gray-500">ISBN: {{ $book->isbn }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $books->links() }}
        </div>
    @endif

    @if(isset($search) && $books->isNotEmpty())
        <div class="mt-6 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
                <i class="fas fa-arrow-left mr-1"></i> Quay lại trang chủ
            </a>
        </div>
    @endif
@endsection
