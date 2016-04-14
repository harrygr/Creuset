<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserLoggedInHandler implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param Login $event
     *
     * @return void
     */
    public function handle(Login $event)
    {
        $event->user->update([
            'last_seen_at' => new \DateTime(),
        ]);
    }
}
