<?php

use App\Http\Controllers\API\RoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('roles')->controller(RoleController::class)->group(function () {
    Route::get('/list-all', 'listAll')->name('roles.listAll')->middleware('auth:sanctum');
    Route::get('/', 'index')->name('roles.list')->middleware(['auth:sanctum', 'permission']);
    Route::post('/', 'store')->name('roles.create')->middleware(['auth:sanctum', 'permission']);
    Route::get('/{id}', 'show')->name('roles.view')->middleware(['auth:sanctum', 'permission']);
    Route::match(['put', 'patch'], '/{id}', 'update')->name('roles.edit')->middleware(['auth:sanctum', 'permission']);
    Route::delete('/{id}', 'destroy')->name('roles.delete')->middleware(['auth:sanctum', 'permission']);
});
