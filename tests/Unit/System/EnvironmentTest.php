<?php

namespace Tests\System;

it('displays the current environment', function () {
    $env = env('APP_ENV');
    expect($env)->toBe(env('APP_ENV'));
})->group('system');
