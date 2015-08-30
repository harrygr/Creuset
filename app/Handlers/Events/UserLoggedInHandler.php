<?php

namespace Creuset\Handlers\Events;

use Creuset\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserLoggedInHandler
{
    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Events  $event
     * @return void
     */
    public function handle(User $user, $remember)
    {
        $ip = \Request::getClientIp();
        \Log::info("the user {$user->name} <{$user->username}> logged in from IP $ip");

        $user->last_seen_at = new \DateTime;
        $user->save();
    }
}
