@extends('layouts.app')

@section('title', 'Đăng ký')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden md:shadow-lg my-10">
    <div class="p-6">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Đăng ký tài khoản</h2>

        <form action="{{ route('register.post') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Họ và tên</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500
                    @error('name') border-red-500 @enderror"
                    required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500
                    @error('email') border-red-500 @enderror"
                    required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mật khẩu</label>
                <input type="password" name="password" id="password"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500
                    @error('password') border-red-500 @enderror"
                    required>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
                    required>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Đăng ký
                </button>
                <a href="{{ route('login.show') }}" class="text-sm text-blue-500 hover:text-blue-700">
                    Đã có tài khoản? Đăng nhập
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
