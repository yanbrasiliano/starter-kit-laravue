<?php

use Illuminate\Support\Facades\{File, Route};

Route::get('{any}', function () {
    return view('app');
})->where('any', '^(?!der|assets|schema.json|docs).*');

Route::get('/der', function () {
    $key = request()->get('key');

    if (!request()->has('key')) {
        return abort(404);
    }

    if (request()->get('key') !== config('starterkit.der.key')) {
        return abort(401);
    }

    return response()->file(
        public_path('dist/index.html'),
        ['Content-Type' => 'text/html; charset=utf-8']
    );
});

Route::get('/schema.json', function () {
    $filePath = public_path('dist/schema.json');

    if (!File::exists($filePath)) {
        abort(500, "Schema.json file not found.");
    }

    return response()->file($filePath, [
        'headers' => [
            'Content-Type' => 'application/json',
        ],
    ]);
});

Route::get('/assets/{path}', function ($path) {
    $filePath = public_path("dist/assets/{$path}");

    if (!File::exists($filePath)) {
        abort(404);
    }

    $mimeType = match(pathinfo($filePath, PATHINFO_EXTENSION)) {
        'js' => 'application/javascript; charset=utf-8',
        'css' => 'text/css',
        'ico' => 'image/x-icon',
        'png' => 'image/png',
        default => File::mimeType($filePath)
    };

    return response()->file($filePath, ['Content-Type' => $mimeType]);
})->where('path', '.*');
