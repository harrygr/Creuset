<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The table used by the model.
     *
     * @var string
     */
    public $table = 'roles';

    /**
     * The fields that are mass-assignable.
     *
     * @var array
     */
    public $fillable = ['name', 'display_name'];

    /**
     * Disable timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get users with a certain role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function users()
    {
        return $this->hasMany('App\User', 'users');
    }

    /**
     * Derive the display name if it's not set.
     *
     * @param string $display_name
     *
     * @return string
     */
    public function getDisplayNameAttribute($display_name)
    {
        if (!$display_name) {
            return ucwords(\Present::unslug($this->name));
        }

        return $display_name;
    }
}
