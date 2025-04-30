@extends('layouts.app')

@section('title', 'Chỉnh sửa tác giả')

@section('content')
    <div class="mb-6">
        <a href="{{ route('authors.show', $author->id) }}" class="text-blue-500 hover:text-blue-700 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Quay lại chi tiết tác giả
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Chỉnh sửa tác giả: {{ $author->name }}</h1>

        <form action="{{ route('authors.update', $author->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Tên tác giả <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $author->name) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500
                        @error('name') border-red-500 @enderror"
                        required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nationality" class="block text-gray-700 text-sm font-bold mb-2">Quốc tịch</label>
                    <input type="text" name="nationality" id="nationality" value="{{ old('nationality', $author->nationality) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500
                        @error('nationality') border-red-500 @enderror">
                    @error('nationality')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="birth_date" class="block text-gray-700 text-sm font-bold mb-2">Ngày sinh</label>
                    <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $author->birth_date) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500
                        @error('birth_date') border-red-500 @enderror">
                    @error('birth_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="biography" class="block text-gray-700 text-sm font-bold mb-2">Tiểu sử</label>
                <textarea name="biography" id="biography" rows="5"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500
                    @error('biography') border-red-500 @enderror">{{ old('biography', $author->biography) }}</textarea>
                @error('biography')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Cập nhật tác giả
                </button>
            </div>
        </form>
    </div>
@endsection
