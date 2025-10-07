<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForgotPasswordController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendCode'])->name('password.send-code');

Route::get('/enter-code', [PasswordResetController::class, 'showEnterCode'])->name('password.enter-code');
Route::post('/verify-code', [PasswordResetController::class, 'verifyCode'])->name('password.verify-code');

Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.reset');
