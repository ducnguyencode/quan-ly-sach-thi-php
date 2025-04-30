<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;
use App\Mail\EmailVerification;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            if (Auth::user()->email_verified_at === null) {
                session(['verification_email' => Auth::user()->email]);
                
                Auth::logout();
                
                return redirect()->route('verification.notice')
                    ->with('info', 'Bạn cần xác thực email trước khi đăng nhập. Vui lòng kiểm tra email hoặc yêu cầu gửi lại mã xác thực.');
            }

            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->withInput();
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $isFirstUser = (User::count() === 0);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $isFirstUser ? 'admin' : 'user', 
        ]);

        $verificationToken = Str::random(64);
        $tokenExpiry = Carbon::now()->addHours(24); 

        \DB::table('verification_tokens')->insert([
            'user_id' => $user->id,
            'token' => $verificationToken,
            'expires_at' => $tokenExpiry
        ]);

        Mail::to($user->email)->send(new EmailVerification($user, $verificationToken));

        if ($isFirstUser) {
            $user->email_verified_at = now();
            $user->save();
            Auth::login($user);
            return redirect()->route('home')->with('success', 'Tài khoản admin đã được tạo thành công!');
        }

        return redirect()->route('verification.notice')
            ->with('status', 'Vui lòng kiểm tra email của bạn để xác thực tài khoản.');
    }

    public function verifyEmail(Request $request, $token)
    {
        $verificationData = \DB::table('verification_tokens')
            ->where('token', $token)
            ->first();

        if (!$verificationData) {
            return redirect()->route('login.show')
                ->with('error', 'Liên kết xác thực không hợp lệ.');
        }

        if (Carbon::parse($verificationData->expires_at)->isPast()) {
            \DB::table('verification_tokens')
                ->where('token', $token)
                ->delete();

            return redirect()->route('login.show')
                ->with('error', 'Liên kết xác thực đã hết hạn. Vui lòng yêu cầu gửi lại.');
        }

        $user = User::findOrFail($verificationData->user_id);

        $user->email_verified_at = now();
        $user->save();
        \DB::table('verification_tokens')
            ->where('token', $token)
            ->delete();

        Auth::login($user);

        return redirect()->route('home')
            ->with('success', 'Xác thực email thành công!');
    }

    public function resendVerification(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->email_verified_at !== null) {
            return back()->with('info', 'Email này đã được xác thực rồi.');
        }
        \DB::table('verification_tokens')
            ->where('user_id', $user->id)
            ->delete();

        $verificationToken = Str::random(64);
        $tokenExpiry = Carbon::now()->addHours(24);

        \DB::table('verification_tokens')->insert([
            'user_id' => $user->id,
            'token' => $verificationToken,
            'expires_at' => $tokenExpiry
        ]);

        Mail::to($user->email)->send(new EmailVerification($user, $verificationToken));

        return back()->with('status', 'Liên kết xác thực mới đã được gửi đến email của bạn.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.show');
    }

    public function usersList()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Bạn không thể thay đổi quyền của chính mình!');
        }

        $validator = Validator::make($request->all(), [
            'role' => 'required|in:user,admin',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $user->update([
            'role' => $request->role
        ]);

        return back()->with('success', 'Quyền của người dùng đã được cập nhật thành công!');
    }
}
