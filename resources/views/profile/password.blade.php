@extends('layouts.app')

@section('title', 'Đổi mật khẩu')

@section('content')
<div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-2xl mx-auto">
    <div class="border-b border-gray-200">
        <div class="flex items-center justify-between px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-key text-indigo-600 mr-2 text-xl"></i>
                Đổi mật khẩu
            </h2>
            <a href="{{ route('profile.edit') }}" class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center">
                <i class="fas fa-user-circle mr-1"></i>
                Thông tin tài khoản
            </a>
        </div>
    </div>

    <form action="{{ route('profile.password.update') }}" method="POST" class="p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-yellow-50 rounded-lg p-4 mb-4 flex items-start">
            <div class="text-yellow-500 mr-3 pt-1">
                <i class="fas fa-shield-alt text-xl"></i>
            </div>
            <div class="text-sm text-yellow-800">
                Đảm bảo tài khoản của bạn đang sử dụng mật khẩu dài, ngẫu nhiên để giữ an toàn. Mật khẩu phải có ít nhất 8 ký tự.
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu hiện tại</label>
                <input type="password" name="current_password" id="current_password"
                    class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150
                    @error('current_password') border-red-500 @enderror">
                @error('current_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu mới</label>
                <input type="password" name="password" id="password"
                    class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150
                    @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Xác nhận mật khẩu mới</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150">
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full sm:w-auto px-6 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150">
                <i class="fas fa-save mr-1"></i> Cập nhật mật khẩu
            </button>
        </div>
    </form>
</div>
@endsection
