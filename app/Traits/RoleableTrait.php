<?php

namespace App\Traits;

use App\Role;

trait RoleableTrait
{
    /**
     * A model belongs to a single role.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Find out if the entity has a specific role.
     *
     * @return bool
     */
    public function hasRole($check)
    {
        $check = is_array($check) ? $check : [$check];

        return $this->role and in_array($this->role->name, $check);
    }

    /**
     * Give an entity the minimum role of subscriber.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function enroll()
    {
        return $this->assignRole('subscriber');
    }

    /**
     * Assign a role by name to the entity.
     *
     * @param string $role_name The role to assign
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function assignRole($role_name)
    {
        if ($this->isBaseRole($role_name)) {
            $role = Role::firstOrCreate(['name' => $role_name]);
        } else {
            $role = Role::where('name', $role_name)->first();
        }

        if (!$role) {
            throw new \InvalidArgumentException("The role to assign '$role_name' does not exist");
        }

        if (!$this->hasRole($role_name)) {
            $this->role()->associate($role);
            $this->save();
        }

        return $this;
    }

    protected function isBaseRole($role_name)
    {
        return in_array($role_name, array_keys(self::$base_roles));
    }
}
