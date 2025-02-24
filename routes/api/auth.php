<?php

use App\Http\Controllers\Api\Auth\AuthenticateController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthenticateController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout')->middleware('auth:sanctum');
    Route::get('auth/my-profile', 'myProfile')->name('auth.myProfile')->middleware('auth:sanctum');
});
