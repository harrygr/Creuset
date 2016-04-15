<?php

namespace App;

use App\Scopes\AttributeScope;

class Attribute extends Term
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope(new AttributeScope());
    }
}