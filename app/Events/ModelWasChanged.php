<?php

namespace App\Events;

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
}
