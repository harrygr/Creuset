<?php

namespace Creuset;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $table = 'shipping_methods';

    public static $rules = [
    'description' => 'required',
    'base_rate'   => 'required|numeric',
    ];

    public $fillable = ['description', 'base_rate'];

    /**
     * Get the cost of a shipping method
     * 
     * @return float
     */
    public function getPrice()
    {
        return $this->base_rate / 100;
    }

    public function setBaseRateAttribute($rate)
    {
        $this->attributes['base_rate'] = (int) ($rate * 100);
    }
}
