<?php

namespace Creuset;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Set timestamps off
     */
    public $timestamps = false;
 
    /**
     * Get users with a certain role
     */
    public function users()
    {
        return $this->hasMany('Creuset\User', 'users');
    }

}