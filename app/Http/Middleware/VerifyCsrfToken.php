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

    // public function handle($request, Closure $next)
    // {
    //     // Here we'll disable csrf checks for requests to certain urls; specifically those to the api
    //     if ($this->isReading($request) || $this->tokensMatch($request) || $this->isExceptedUrl($request)) {
    //         return $this->addCookieToResponse($request, $next($request));
    //     }

    //     throw new TokenMismatchException();
    // }

    // protected function isExceptedUrl($request)
    // {
    //     $regex = '#'.implode('|', $this->except_urls).'#';

    //     return preg_match($regex, $request->path());
    // }
}
