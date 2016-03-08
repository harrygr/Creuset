<?php

namespace App\Http\Middleware;

class VerifyCsrfToken extends \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken
{
    protected $except = [
        'api/images',
        'api/posts',
        'api/*',
    ];
}
