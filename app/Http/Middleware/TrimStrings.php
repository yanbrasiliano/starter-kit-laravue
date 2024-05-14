<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

// @codeCoverageIgnoreStart
class TrimStrings extends Middleware
{
    protected $except = [
        'current_password',
        'password',
        'password_confirmation',
    ];
}
// @codeCoverageIgnoreEnd
