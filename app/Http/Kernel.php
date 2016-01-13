<?php

namespace Creuset\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'           => 'Creuset\Http\Middleware\Authenticate',
        'auth.basic'     => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
        'guest'          => 'Creuset\Http\Middleware\RedirectIfAuthenticated',
        'admin'          => 'Creuset\Http\Middleware\ForbidIfNotAdmin',
        'order.customer' => 'Creuset\Http\Middleware\DeriveUserForOrder',
        'throttle'       => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Creuset\Http\Middleware\VerifyCsrfToken::class,
        ],
        'api' => [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            'throttle:60,1',
        ],
    ];
}
