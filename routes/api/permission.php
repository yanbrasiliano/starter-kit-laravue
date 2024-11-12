<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PermissionController;

Route::prefix('permissions')->controller(PermissionController::class)->group(function () {
  Route::get('/', 'index')->name('permissions.list')->middleware('auth:sanctum');
});
