<?php

use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->controller(UserController::class)->group(function () {
    Route::post('/register', 'register')->name('users.register');
    Route::get('/verify', 'verify')->name('users.verify')->middleware('signed');
    Route::get('/', 'index')->name('users.list')->middleware(['auth:sanctum', 'permission']);
    Route::post('/', 'store')->name('users.create')->middleware(['auth:sanctum', 'permission']);
    Route::get('/{user}', 'show')->name('users.view')->middleware(['auth:sanctum', 'permission']);
    Route::put('/{user}', 'update')->name('users.edit')->middleware(['auth:sanctum', 'permission']);
    Route::delete('/{id}', 'destroy')->name('users.delete')->middleware(['auth:sanctum', 'permission']);
});
