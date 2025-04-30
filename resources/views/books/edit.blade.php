@extends('layouts.app')

@section('title', 'Chỉnh sửa sách')

@section('content')
    <div class="mb-6">
        <a href="{{ route('books.show', $book->id) }}" class="text-blue-500 hover:text-blue-700 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Quay lại chi tiết sách
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Chỉnh sửa sách: {{ $book->title }}</h1>

        <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Tiêu đề <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500
                        @error('title') border-red-500 @enderror"
                        required>
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="published_year" class="block text-gray-700 text-sm font-bold mb-2">Năm xuất bản</label>
                    <input type="number" name="published_year" id="published_year" value="{{ old('published_year', $book->published_year) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500
                        @error('published_year') border-red-500 @enderror"
                        min="1000" max="{{ date('Y') }}">
                    @error('published_year')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="isbn" class="block text-gray-700 text-sm font-bold mb-2">ISBN</label>
                    <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500
                        @error('isbn') border-red-500 @enderror">
                    @error('isbn')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="cover_image" class="block text-gray-700 text-sm font-bold mb-2">Ảnh bìa</label>
                    <input type="file" name="cover_image" id="cover_image"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500
                        @error('cover_image') border-red-500 @enderror">
                    @error('cover_image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    @if($book->cover_image)
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Ảnh hiện tại:</p>
                            <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="h-24 mt-1">
                        </div>
                    @endif
                </div>
            </div>

            <div class="mb-6">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Mô tả <span class="text-red-500">*</span></label>
                <textarea name="description" id="description" rows="5"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500
                    @error('description') border-red-500 @enderror"
                    required>{{ old('description', $book->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Tác giả</label>
                <div class="border border-gray-300 rounded-md p-4">
                    @if($authors->isEmpty())
                        <p class="text-gray-500">Chưa có tác giả nào. <a href="{{ route('authors.create') }}" class="text-blue-500 hover:text-blue-700">Thêm tác giả mới</a></p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($authors as $author)
                                <div class="flex items-center">
                                    <input type="checkbox" name="authors[]" id="author_{{ $author->id }}" value="{{ $author->id }}"
                                        {{ in_array($author->id, old('authors', $book->authors->pluck('id')->toArray())) ? 'checked' : '' }}
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="author_{{ $author->id }}" class="ml-2 text-gray-700">
                                        {{ $author->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Cập nhật sách
                </button>
            </div>
        </form>
    </div>
@endsection
