<?php

use Illuminate\Support\Facades\{DB, Route};
use Illuminate\Support\Str;

Route::prefix('v1')->group(function () {
    Route::controller(App\Http\Controllers\API\AuthenticateController::class)->group(function () {
        Route::post('/login', 'login')->name('login');
        Route::post('/logout', 'logout')->name('logout')->middleware('auth:sanctum');
    });

    Route::get('/', function () {
        return response()->json([
            'message' => Str::upper('API_STARTERKIT_' . config('app.env') . '_ONLINE'),
            'database' => DB::connection()->getDatabaseName(),
        ]);
    });

    Route::controller(App\Http\Controllers\API\PasswordController::class)->group(function () {
        Route::post('/forgot-password', 'forgotPassword')->name('forgot-password');
        Route::post('/reset-password', 'resetPassword')->name('reset-password');
        Route::get('/reset-password', 'verifyResetPassword')->name('verify-reset-password');
    });

    Route::prefix('users')->controller(App\Http\Controllers\API\UserController::class)->group(function () {
        Route::post('/register', 'register')->name('users.register');
        Route::get('/verify', 'verify')->name('users.verify')->middleware('signed');
    });

    Route::middleware('auth:sanctum')->group(function () {

        Route::controller(App\Http\Controllers\API\AuthenticateController::class)->group(function () {
            Route::get('auth/my-profile', 'myProfile')->name('auth.myProfile');
        });
        Route::prefix('permissions')->controller(App\Http\Controllers\API\PermissionController::class)->group(function () {
            Route::get('/', 'index')->name('permissions.list');
        });
        Route::prefix('roles')->controller(App\Http\Controllers\API\RoleController::class)->group(function () {
            Route::get('/list-all', 'listAll')->name('roles.listAll');
        });
        // Routes that require access permissions
        Route::middleware('permission')->group(function () {
            Route::prefix('users')->controller(App\Http\Controllers\API\UserController::class)->group(function () {
                Route::get('/', 'index')->name('users.list');
                Route::post('/', 'store')->name('users.create');
                Route::get('/{id}', 'show')->name('users.view');
                Route::put('/{id}', 'update')->name('users.edit');
                Route::delete('/{id}', 'destroy')->name('users.delete');
            });
            Route::prefix('roles')->controller(App\Http\Controllers\API\RoleController::class)->group(function () {
                Route::get('/', 'index')->name('roles.list');
                Route::post('/', 'store')->name('roles.create');
                Route::get('/{id}', 'show')->name('roles.view');
                Route::match(['put', 'patch'], '/{id}', 'update')->name('roles.edit');
                Route::delete('/{id}', 'destroy')->name('roles.delete');
            });
        });
    });
});
