<?php

namespace Creuset;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
