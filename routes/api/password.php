<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PasswordController;

Route::controller(PasswordController::class)->group(function () {
  Route::post('/forgot-password', 'forgotPassword')->name('forgot-password');
  Route::post('/reset-password', 'resetPassword')->name('reset-password');
  Route::get('/reset-password', 'verifyResetPassword')->name('verify-reset-password');
});
