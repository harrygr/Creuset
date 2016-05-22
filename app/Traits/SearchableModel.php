<?php

namespace App\Traits;

use Event;

trait SearchableModel
{
    protected static function bootSearchableModel()
    {
        static::created(function ($model) {
            Event::fire('searchable.created', $model);
        });

        static::updated(function ($model) {
            Event::fire('searchable.updated', $model);
        });

        static::deleted(function ($model) {
            Event::fire('searchable.deleted', $model);
        });
    }
}
