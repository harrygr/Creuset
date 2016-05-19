<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\SearchIndex\Searchable;

class UpsertModelToSearchIndex implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param \Spatie\SearchIndex\Searchable $model
     *
     * @return void
     */
    public function handle(Searchable $model)
    {
        \SearchIndex::upsertToIndex($model);
    }
}
