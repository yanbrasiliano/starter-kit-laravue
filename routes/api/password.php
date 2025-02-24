<?php

use App\Http\Controllers\Api\Auth\PasswordController;
use Illuminate\Support\Facades\Route;

Route::controller(PasswordController::class)->group(function () {
    Route::post('/forgot-password', 'forgotPassword')->name('forgot-password');
    Route::post('/reset-password', 'resetPassword')->name('reset-password');
    Route::get('/reset-password', 'verifyResetPassword')->name('verify-reset-password');
});
