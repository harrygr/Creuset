<?php

namespace Creuset\Events;

use Illuminate\Queue\SerializesModels;

class ModelWasChanged extends Event
{
    use SerializesModels;

    public $tag;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($tag)
    {
        $this->tag = $tag;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
