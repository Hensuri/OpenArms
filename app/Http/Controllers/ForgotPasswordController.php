<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendCode;
use App\Models\User;
use App\Models\PasswordReset;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('resetpassword.forgot-password');
    }

    public function sendCode(Request $request)
    {
        $request->validate(['identifier' => 'required|string']);
        
        $identifier = $request->input('identifier');
        $user = User::where('email', $identifier)
                    ->orWhere('username', $identifier) // jika pakai username
                    ->first();

        if (! $user) {
            return redirect()->route('password.enter-code', ['identifier' => $identifier]);
        }
        
        $code = random_int(100000, 999999);
        $codeString = (string) $code;

        $codeHash = Hash::make($codeString);
        $expiresAt = Carbon::now()->addMinutes(15);

        PasswordReset::updateOrCreate(
            ['email' => $user->email, 'used' => false],
            [
                'code_hash' => $codeHash,
                'reset_token' => null,
                'expires_at' => $expiresAt,
                'used' => false,
            ]
        );

        Mail::to($email)->send(new sendCode($user->username, $code));

        return redirect()->route('password.enter-code', ['identifier' => $user->email]);
    }
    
    public function showEnterCode()
    {
        return view('resetpassword.enter-code');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6',
        ]);

        $email = $request->input('email');
        $code = $request->input('code');

        $reset = PasswordReset::where('email', $email)
            ->where('used', false)
            ->orderBy('created_at', 'desc')
            ->first();

        if (! $reset) {
            return back()->with('error', 'Kode tidak valid atau sudah dipakai.');

        }

        if (Carbon::now()->greaterThan($reset->expires_at)) {
            return back()->with('error', 'Kode sudah kadaluarsa. Silakan minta kode baru.');
        }

        if (! Hash::check($code, $reset->code_hash)) {
            return back()->with('error', 'Kode salah.');
        }

        $resetToken = (string) Str::uuid();
        $reset->reset_token = $resetToken;
        $reset->save();

        return redirect()->route('password.reset.form', ['token' => $resetToken]);
    }

    public function showResetForm($token)
    {
        $reset = PasswordReset::where('reset_token', $token)
            ->where('used', false)
            ->first();

        if (! $reset || Carbon::now()->greaterThan($reset->expires_at)) {
            return redirect()->route('password.request')
                ->withErrors(['token' => 'Link reset tidak valid atau sudah kadaluarsa.']);
        }

        return view('resetpassword.enter-password', ['token' => $token, 'email' => $reset->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $token = $request->input('token');
        $password = $request->input('password');

        $reset = PasswordReset::where('reset_token', $token)
            ->where('used', false)
            ->first();

        if (! $reset || Carbon::now()->greaterThan($reset->expires_at)) {
            return back()->with('error', 'Token tidak valid atau sudah kadaluarsa.');
        }

        $user = User::where('email', $reset->email)->first();

        if (! $user) {
            return back()->with('error', 'Akun tidak ditemukan.');
        }

        $user->password = Hash::make($password);
        $user->save();

        $reset->used = true;
        $reset->reset_token = null;
        $reset->save();


        // return redirect()->route('login')->with('status', 'Password berhasil diubah. Silakan login.');
    }

}
