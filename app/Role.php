<?php

namespace Creuset;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $table = 'roles';
    
    public $fillable = ['name', 'display_name'];

    /**
     * Set timestamps off.
     */
    public $timestamps = false;

    /**
     * Get users with a certain role.
     */
    public function users()
    {
        return $this->hasMany('Creuset\User', 'users');
    }
}
