<?php

namespace Creuset\Listeners;

use Creuset\Events\ModelWasChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class FlushModelCache implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  ModelWasChanged  $event
     * @return void
     */
    public function handle(ModelWasChanged $event)
    {
        \Cache::tags($event->tag)->flush();
    }
}
