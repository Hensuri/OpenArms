<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function show()
    {
        return view('Login');
    }

    public function login(Request $request)
    {
        $key = 'send-message:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            // Ambil sisa waktu (detik) kapan boleh coba lagi
            $seconds = RateLimiter::availableIn($key);
            Log::info("RATE LIMITED");
            return back()->withErrors([
                'Please wait for ' . $seconds . " second(s) to try again",
            ])->withInput($request->except('password'));
        }
        Log::info($key);
        // 3. Jika lolos, catat "hit" (percobaan bertambah)
        RateLimiter::hit($key);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}
