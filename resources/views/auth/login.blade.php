@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden md:shadow-lg my-10">
    <div class="p-6">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Đăng nhập</h2>

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

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

            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mật khẩu</label>
                <input type="password" name="password" id="password"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500
                    @error('password') border-red-500 @enderror"
                    required>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <div class="text-right mt-1">
                    <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-blue-500">
                        Quên mật khẩu?
                    </a>
                </div>
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="h-4 w-4 text-blue-600">
                    <span class="ml-2 text-sm text-gray-600">Ghi nhớ đăng nhập</span>
                </label>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Đăng nhập
                </button>
                <a href="{{ route('register.show') }}" class="text-sm text-blue-500 hover:text-blue-700">
                    Chưa có tài khoản? Đăng ký
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
