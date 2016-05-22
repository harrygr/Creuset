<?php

namespace App\Providers;

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
        'App\Events\ModelWasChanged' => [
            'App\Listeners\FlushModelCache',
        ],
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\UserLoggedInHandler',
        ],
        'App\Events\OrderWasCreated' => [

        ],
        'App\Events\OrderWasPaid' => [
            'App\Listeners\ReduceProductStock',
            'App\Listeners\MarkOrderPaid',
            'App\Listeners\SendCustomerOrderEmail',
            'App\Listeners\SendAdminOrderEmail',
        ],
        'App\Events\ProductStockChanged' => [
            'App\Listeners\EmailStockNotification',
        ],
        'searchable.created' => [
            'App\Listeners\UpsertModelToSearchIndex',
        ],
        'searchable.updated' => [
            'App\Listeners\UpsertModelToSearchIndex',
        ],
        'searchable.deleted' => [
            'App\Listeners\RemoveModelFromSearchIndex',
        ],
    ];
}
