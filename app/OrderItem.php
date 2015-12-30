<?php

namespace Creuset;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $table = 'order_items';

    public $fillable = ['order_id', 'quantity', 'description', 'price_paid'];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * An order item is related to an orderable entity, e.g. a product
     */
    public function orderable()
    {
        return $this->morphTo();
    }

    public function getTotalPaidAttribute()
    {
        return $this->quantity * $this->price_paid;
    }
}
