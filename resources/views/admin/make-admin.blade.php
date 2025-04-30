@extends('layouts.app')

@section('title', 'Tạo tài khoản Admin')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Tạo tài khoản Admin</h1>
        <p class="text-gray-600">Đặt tài khoản hiện tại làm Admin.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden p-6">
        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Thông tin tài khoản</h2>
            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Tên người dùng:</p>
                    <p class="font-medium">{{ auth()->user()->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email:</p>
                    <p class="font-medium">{{ auth()->user()->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Quyền hiện tại:</p>
                    <p class="font-medium">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ auth()->user()->role === 'admin' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ auth()->user()->role === 'admin' ? 'Quản trị viên' : 'Người dùng' }}
                        </span>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Ngày tạo:</p>
                    <p class="font-medium">{{ auth()->user()->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="mt-6">
            @if(auth()->user()->role === 'admin')
                <div class="p-4 bg-green-50 rounded-lg">
                    <p class="text-green-700">Tài khoản của bạn đã có quyền quản trị viên.</p>
                </div>
            @else
                <form action="{{ route('admin.make-admin') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg shadow-sm">
                        Đặt làm Admin
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection
