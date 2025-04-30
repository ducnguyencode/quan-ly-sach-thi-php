@extends('layouts.app')

@section('title', 'Quản lý tài khoản')

@section('content')
<div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-2xl mx-auto">
    <div class="border-b border-gray-200">
        <div class="flex items-center justify-between px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-user-circle text-indigo-600 mr-2 text-xl"></i>
                Thông tin tài khoản
            </h2>
            <a href="{{ route('profile.password') }}" class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center">
                <i class="fas fa-key mr-1"></i>
                Đổi mật khẩu
            </a>
        </div>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" class="p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-indigo-50 rounded-lg p-4 mb-4 flex items-start">
            <div class="text-indigo-500 mr-3 pt-1">
                <i class="fas fa-info-circle text-xl"></i>
            </div>
            <div class="text-sm text-indigo-800">
                Bạn có thể cập nhật thông tin tài khoản của mình ở đây. Đảm bảo email của bạn luôn được cập nhật để không bỏ lỡ thông báo quan trọng.
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Họ và tên</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                    class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150
                    @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                    class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150
                    @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full sm:w-auto px-6 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150">
                <i class="fas fa-save mr-1"></i> Lưu thay đổi
            </button>
        </div>
    </form>
</div>
@endsection
