<?php

namespace Creuset;

use Creuset\Presenters\PresentableTrait;
use Creuset\Traits\RoleableTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, PresentableTrait, RoleableTrait;

    /**
     * The presenter instance to use.
     *
     * @var string
     */
    protected $presenter = 'Creuset\Presenters\UserPresenter';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The fields to be parsed into Carbon instance.
     *
     * @var array
     */
    protected $dates = ['last_seen_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'name', 'email', 'password', 'role_id', 'auto_created'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * A user has several orders.
     *
     * @return [type] [description]
     */
    public function orders()
    {
        return $this->hasMany(Order::class)->orderBy('created_at', 'DESC');
    }

    /**
     * A user has several addresses.
     *
     * @return 
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Does the user own the model.
     *
     * @param Model $model The model to check
     *
     * @return bool
     */
    public function owns(Model $model)
    {
        return $this->id == $model->user_id;
    }

    /**
     * Attach an address to a user.
     *
     * @param Address $address
     *
     * @return Address
     */
    public function addAddress(Address $address)
    {
        return $this->addresses()->save($address);
    }
}
