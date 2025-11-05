<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CreateDonationController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\MidtransController;
use App\Livewire\Donations;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::get('/', Donations::class)->name('Donation');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('adminDonation');
    Route::post('/admin/donation/{id}/approve', [AdminDashboardController::class, 'approve']);
    Route::post('/admin/donation/{id}/reject', [AdminDashboardController::class, 'reject']);
});

Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'show'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendCode'])->name('password.send-code');

Route::get('/enter-code', [ForgotPasswordController::class, 'showEnterCode'])->name('password.enter-code');
Route::post('/verify-code', [ForgotPasswordController::class, 'verifyCode'])->name('password.verify-code');

Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');

Route::middleware('auth')->group(function () {
    Route::get('/edit-account', [AccountController::class, 'edit'])->name('account.edit');
    Route::post('/edit-account', [AccountController::class, 'update'])->name('account.update');
});

Route::get('/my-donation', [CreateDonationController::class, 'index'])->name('myDonationList');
Route::get('/create-donation', [CreateDonationController::class, 'show'])->name('createDonation');
Route::post('/create-donation', [CreateDonationController::class, 'store'])->name('addDonation');

Route::post('/midtrans-create', [MidtransController::class, 'create'])->name('midtrans.create');
Route::post('/midtrans/callback', [MidtransController::class, 'callback'])->withoutMiddleware([VerifyCsrfToken::class]);;