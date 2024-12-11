<?php

use App\Http\Controllers\API\PermissionController;
use Illuminate\Support\Facades\Route;

Route::prefix('permissions')->controller(PermissionController::class)->group(function () {
    Route::get('/', 'index')->name('permissions.list')->middleware('auth:sanctum');
});
