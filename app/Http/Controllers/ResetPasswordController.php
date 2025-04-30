<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    /**
     * Nơi chuyển hướng sau khi reset mật khẩu
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Hiển thị form reset mật khẩu
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Reset mật khẩu
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $tokenData = \DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$tokenData) {
            return back()->withErrors(['email' => 'Token không hợp lệ.']);
        }
        if (Carbon::parse($tokenData->expires_at)->isPast()) {
            \DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            return back()->withErrors(['email' => 'Token đã hết hạn. Vui lòng yêu cầu link mới.']);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Không tìm thấy người dùng với email này.']);
        }

        $user->password = Hash::make($request->password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        \DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        event(new PasswordReset($user));

        return redirect()->route('login.show')
            ->with('status', 'Mật khẩu của bạn đã được đặt lại thành công!');
    }
}
