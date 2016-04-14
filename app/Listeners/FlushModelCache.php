<?php

namespace App\Listeners;

use App\Events\ModelWasChanged;
use Illuminate\Contracts\Queue\ShouldQueue;

class FlushModelCache implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param ModelWasChanged $event
     *
     * @return void
     */
    public function handle(ModelWasChanged $event)
    {
        \Cache::tags($event->tag)->flush();
    }
}
