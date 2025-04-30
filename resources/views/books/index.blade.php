@extends('layouts.app')

@section('title', 'Danh sách sách')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Danh sách sách</h1>
        @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('books.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Thêm sách mới
            </a>
        @endif
    </div>

    @if($books->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <p class="text-gray-500">Chưa có sách nào. Hãy thêm sách mới!</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($books as $book)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="h-full w-full object-cover">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        @endif
                    </div>
                    <div class="p-4">
                        <h2 class="text-xl font-semibold mb-2 text-gray-800">{{ $book->title }}</h2>
                        <p class="text-gray-600 mb-4 line-clamp-2">{{ Str::limit($book->description, 100) }}</p>

                        <div class="text-sm text-gray-500 mb-4">
                            <p>Tác giả:
                                @if($book->authors->isNotEmpty())
                                    {{ $book->authors->pluck('name')->join(', ') }}
                                @else
                                    Chưa có thông tin
                                @endif
                            </p>
                            @if($book->published_year)
                                <p>Năm xuất bản: {{ $book->published_year }}</p>
                            @endif
                        </div>

                        <div class="flex justify-between items-center">
                            <a href="{{ route('books.show', $book->id) }}" class="text-blue-500 hover:text-blue-700">
                                Xem chi tiết
                            </a>
                            @if(Auth::check() && Auth::user()->role === 'admin')
                            <div class="flex space-x-2">
                                <a href="{{ route('books.edit', $book->id) }}" class="text-yellow-500 hover:text-yellow-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa sách này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $books->links() }}
        </div>
    @endif
@endsection
