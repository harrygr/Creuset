<?php

namespace Creuset\Providers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    use DispatchesJobs;

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Creuset\Events\ModelWasChanged' => [
            'Creuset\Listeners\FlushModelCache',
        ],
        'Illuminate\Auth\Events\Login' => [
            'Creuset\Listeners\UserLoggedInHandler',
        ],
        'Creuset\Events\OrderWasCreated' => [

        ],
        'Creuset\Events\OrderWasPaid' => [
            'Creuset\Listeners\ReduceProductStock',
            'Creuset\Listeners\MarkOrderPaid',
            'Creuset\Listeners\SendCustomerOrderEmail',
            'Creuset\Listeners\SendAdminOrderEmail',
        ],
        'Creuset\Events\ProductStockChanged' => [
            'Creuset\Listeners\EmailStockNotification',
        ],
    ];
}
