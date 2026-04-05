<?php

declare(strict_types = 1);

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestForgery as Middleware;

// @codeCoverageIgnoreStart
final class PreventRequestForgery extends Middleware
{
    protected $except = [];
}
// @codeCoverageIgnoreEnd
