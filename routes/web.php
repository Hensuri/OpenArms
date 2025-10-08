<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Login');
});

use App\Http\Controllers\LoginController;

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

use App\Http\Controllers\RegisterController;

Route::get('/register', function () {
    return view('Regist');
})->name('register');

Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/forgot-password', function () {
    return view('ForgotPWD');
});

Route::get('/verify', function () {
    return view('verification');
});