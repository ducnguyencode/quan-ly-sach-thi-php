@extends('layouts.app')

@section('title', $author->name)

@section('content')
    <div class="mb-6">
        <a href="{{ route('authors.index') }}" class="text-blue-500 hover:text-blue-700 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Quay lại danh sách tác giả
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ $author->name }}</h1>

                <div class="flex space-x-2">
                    <a href="{{ route('authors.edit', $author->id) }}" class="text-yellow-500 hover:text-yellow-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </a>
                    <form action="{{ route('authors.destroy', $author->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa tác giả này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 text-gray-600">
                @if($author->birth_date)
                    <div>
                        <span class="font-medium">Ngày sinh:</span> {{ date('d/m/Y', strtotime($author->birth_date)) }}
                    </div>
                @endif

                @if($author->nationality)
                    <div>
                        <span class="font-medium">Quốc tịch:</span> {{ $author->nationality }}
                    </div>
                @endif
            </div>

            @if($author->biography)
                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-2 text-gray-700">Tiểu sử</h2>
                    <div class="prose max-w-none text-gray-600">
                        {{ $author->biography }}
                    </div>
                </div>
            @endif
        </div>

        <div class="border-t border-gray-200 p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Sách của tác giả</h2>

            @if($author->books->isEmpty())
                <p class="text-gray-500">Tác giả chưa có sách nào.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($author->books as $book)
                        <div class="bg-gray-50 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                            <h3 class="font-semibold text-lg mb-2">
                                <a href="{{ route('books.show', $book->id) }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $book->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 text-sm mb-2 line-clamp-2">{{ Str::limit($book->description, 100) }}</p>
                            @if($book->published_year)
                                <p class="text-gray-500 text-xs">Năm xuất bản: {{ $book->published_year }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
