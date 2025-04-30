@extends('layouts.app')

@section('title', 'Quên mật khẩu')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden md:shadow-lg my-10">
    <div class="p-6">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Quên mật khẩu</h2>

        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500
                    @error('email') border-red-500 @enderror"
                    required autofocus>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-600 mt-2">
                    Nhập email đã đăng ký, chúng tôi sẽ gửi link đặt lại mật khẩu cho bạn.
                </p>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Gửi link đặt lại mật khẩu
                </button>
                <a href="{{ route('login.show') }}" class="text-sm text-blue-500 hover:text-blue-700">
                    Quay lại đăng nhập
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
