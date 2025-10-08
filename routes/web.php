<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

Route::get('/', function () {
    return view('Login');
});

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('Regist');
})->name('register');

Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendCode'])->name('password.send-code');

Route::get('/enter-code', [PasswordResetController::class, 'showEnterCode'])->name('password.enter-code');
Route::post('/verify-code', [PasswordResetController::class, 'verifyCode'])->name('password.verify-code');

Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.reset');

