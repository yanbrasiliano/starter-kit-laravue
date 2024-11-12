<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

Route::prefix('v1')->group(function () {
  Route::get('/', function () {
    return response()->json([
      'message' => Str::upper('API_STARTERKIT_' . config('app.env') . '_ONLINE'),
      'database' => DB::connection()->getDatabaseName(),
    ]);
  });

  collect(glob(__DIR__ . '/api/*.php'))->each(fn($routeFile) => require $routeFile);
});
