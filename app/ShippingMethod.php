<?php

namespace Creuset;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $table = 'shipping_methods';

    /**
     * Get the cost of a shipping method
     * 
     * @return float
     */
    public function getPrice()
    {
        return $this->base_rate / 100;
    }
}
