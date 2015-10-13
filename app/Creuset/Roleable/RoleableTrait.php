<?php

namespace Creuset\Creuset\Roleable;

use Illuminate\Database\Eloquent\Model;
use Creuset\Role;

trait RoleableTrait {
	
	/**
     * A model belongs to a single role
     */
    public function role()
    {
        return $this->belongsTo('Creuset\Role');
    }

    /**
     * Find out if the entity has a specific role
     *
     * @return boolean
     */
    public function hasRole($check)
    {
        $check = is_array($check) ? $check : [$check];

        return $this->role and in_array($this->role->name, $check);
    }

    /**
     * Give an entity the minimum role of subscriber'
     * @return Model
     */
    public function enroll()
    {
        return $this->assignRole('subscriber');
    }

    /**
     * Assign a role by name to the entity
     * @param  string $role The role to assign
     * @return Model       
     */
    public function assignRole($roleName)
    {
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            throw new NonExistantRoleException("The role to assign '$roleName' does not exist");
        }

        if (!$this->hasRole($roleName)) {
            $this->role()->associate($role);
            $this->save();
        }

        return $this;
    }

}