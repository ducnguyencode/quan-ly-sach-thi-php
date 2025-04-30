<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verification.verify');
Route::post('/verification/resend', [AuthController::class, 'resendVerification'])->name('verification.resend');
Route::get('/verification/notice', function() {
    return view('auth.verify');
})->name('verification.notice');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [BookController::class, 'home'])->name('home');

    Route::get('/search', [BookController::class, 'search'])->name('books.search');

    Route::get('/books', [BookController::class, 'index'])->name('books.index');

    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

    Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
    Route::get('/authors/create', [AuthorController::class, 'create'])->name('authors.create');
    Route::post('/authors', [AuthorController::class, 'store'])->name('authors.store');
    Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');

    Route::get('/books-create-test', [BookController::class, 'create'])->name('books.create.test');
    Route::post('/books-store-test', [BookController::class, 'store'])->name('books.store.test');
    Route::get('/authors-create-test', [AuthorController::class, 'create'])->name('authors.create.test');
    Route::post('/authors-store-test', [AuthorController::class, 'store'])->name('authors.store.test');

    Route::post('/books/{book}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'showPasswordForm'])->name('profile.password');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::get('/make-admin', function() {
        if (User::where('role', 'admin')->count() > 0) {
            return redirect()->route('home')->with('error', 'Đã có tài khoản admin trong hệ thống!');
        }
        return view('admin.make-admin');
    })->name('admin.make-admin.form');

    Route::post('/make-admin', function() {
        if (User::where('role', 'admin')->count() > 0) {
            return redirect()->route('home')->with('error', 'Đã có tài khoản admin trong hệ thống!');
        }

        $user = Auth::user();
        $user->role = 'admin';
        $user->save();

        return redirect()->route('home')->with('success', 'Tài khoản của bạn đã được đặt làm admin!');
    })->name('admin.make-admin');

    Route::get('/debug-admin', function() {
        $user = Auth::user();
        $isAdmin = ($user && $user->role === 'admin');

        return response()->json([
            'user_id' => $user ? $user->id : null,
            'name' => $user ? $user->name : null,
            'role' => $user ? $user->role : null,
            'is_admin' => $isAdmin,
            'routes' => [
                'books_create_url' => route('books.create'),
                'authors_create_url' => route('authors.create')
            ]
        ]);
    })->name('debug.admin');

    Route::middleware(['admin'])->group(function () {
        Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');

        Route::get('/authors/{author}/edit', [AuthorController::class, 'edit'])->name('authors.edit');
        Route::put('/authors/{author}', [AuthorController::class, 'update'])->name('authors.update');
        Route::delete('/authors/{author}', [AuthorController::class, 'destroy'])->name('authors.destroy');
        Route::get('/admin/users', [AuthController::class, 'usersList'])->name('admin.users');
        Route::put('/admin/users/{user}/role', [AuthController::class, 'updateUserRole'])->name('admin.users.update-role');
    });
});

Route::get('/check-role', [UserController::class, 'checkRole']);
