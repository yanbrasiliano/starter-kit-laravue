<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

// @codeCoverageIgnoreStart
class EncryptCookies extends Middleware
{
    protected $except = [
        //
    ];
}
// @codeCoverageIgnoreEnd
