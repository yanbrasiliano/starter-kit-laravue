<?php

declare(strict_types = 1);

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

// @codeCoverageIgnoreStart
class VerifyCsrfToken extends Middleware
{
    protected $except = [
        //
    ];
}
// @codeCoverageIgnoreEnd
