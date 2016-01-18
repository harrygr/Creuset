<?php

namespace Creuset\Http\Middleware;

use Closure;
use Illuminate\Session\TokenMismatchException;

class VerifyCsrfToken extends \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken
{
    protected $except = [
        'api/images',
        'api/posts',
        'api/*',
    ];
}
