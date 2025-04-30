<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        $token = Str::random(64);
        $tokenExpiry = Carbon::now()->addHours(1);

        \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => $token,
                'created_at' => Carbon::now(),
                'expires_at' => $tokenExpiry
            ]
        );

        Mail::to($user->email)->send(new ResetPassword($user, $token));

        return back()->with('status', 'Chúng tôi đã gửi liên kết đặt lại mật khẩu đến email của bạn!');
    }
}
