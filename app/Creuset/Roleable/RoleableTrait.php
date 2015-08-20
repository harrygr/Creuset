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
        if (!is_array($check)) $check = [$check];

        return $this->role and in_array($this->role->name, $check);
    }

    /**
     * Determine if the entity has permission
     * @param  string $action The permission to check
     * @return boolean
     *
     * This needs to be outsourced to a seperate Permissions model and table 
     * but we've encapsulated it into a single method for now
     */
    public function can($action)
    {
        if ('edit_user' == $action)
            return $this->hasRole(['admin']);


        if ('edit_post' == $action)
            return $this->hasRole(['admin', 'contributor']);

        if ('view_site' == $action)
            return true;

        return false;
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

        if (!$role)
        {
            throw new NonExistantRoleException("The role to assign '$roleName' does not exist");
        }

        if (!$this->hasRole($roleName))
        {
            $this->role()->associate($role);
            $this->save();
        }

        return $this;
    }

}