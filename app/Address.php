<?php

namespace Creuset;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $table = 'addresses';

    protected $fillable = ['name', 'phone', 'line_1', 'line_2', 'city', 'country', 'postcode'];

    protected $dates = ['deleted_at'];

    public static $rules = [
        'name'      => 'required',
        'line_1'    => 'required',
        'city'      => 'required',
        'postcode'  => 'required',
        'country'   => 'required',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute()
    {
        return $this->name;
    }
}
