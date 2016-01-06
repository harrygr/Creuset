<?php

namespace Creuset\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'auth.login' => [
            'Creuset\Handlers\Events\UserLoggedInHandler',
        ],
        'Creuset\Events\OrderWasCreated' => [
            'Creuset\Listeners\ReduceProductStock',
        ],
        'Creuset\Events\OrderWasPaid' => [
            'Creuset\Listeners\MarkOrderPaid',
            'Creuset\Listeners\SendCustomerOrderEmail',
            'Creuset\Listeners\SendAdminOrderEmail',
        ],
        'Creuset\Events\ProductStockChanged' => [
            'Creuset\Listeners\EmailStockNotification',
        ],
    ];
}
