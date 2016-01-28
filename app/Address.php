<?php

namespace Creuset;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    /**
     * The table used by the model
     * 
     * @var string
     */
    protected $table = 'addresses';

    /**
     * The fields that are mass-assignable
     * 
     * @var array
     */
    protected $fillable = ['name', 'phone', 'line_1', 'line_2', 'city', 'country', 'postcode'];

    /**
     * Mutate these dates to Carbon instances
     * 
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Validation rules for an address
     * 
     * @var array
     */
    public static $rules = [
        'name'      => 'required',
        'line_1'    => 'required',
        'city'      => 'required',
        'postcode'  => 'required',
        'country'   => 'required|alpha|size:2',
    ];

    /**
     * An address belongs to a user.
     *     
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute()
    {
        return $this->name;
    }

    /**
     * Get the full country name.
     *
     * @param string $code The address's country code
     *
     * @return string The full country name
     */
    public function getCountryNameAttribute()
    {
        $countries = \App::make(\Creuset\Countries\CountryRepository::class);

        return $countries->getByCode($this->country);
    }

    /**
     * Get the raw country code.
     *
     * @return string
     */
    public function getCountryCodeAttribute()
    {
        return $this['attributes']['country'];
    }
}
