<?php

namespace Creuset;

use Cart;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = 'orders';

    public $fillable = ['total_paid', 'status', 'user_id'];


    public static function createFromCart(User $user)
    {
        $order = self::create([
            'user_id' => $user->id,
            'total_paid' => Cart::total(),
            'status' => 'paid',
            ]);

            $order_items = Cart::content()->map(function($row) use ($order){
                $item = new OrderItem([
                    'order_id' => $order->id,
                    'quantity' => $row->qty,
                    'description' => $row->product->name,
                    'price_paid' => $row->product->getPrice(),
                    ]);
                $item->orderable()->associate($row->product);
                $item->save();
                return $item;
            });
        return $order;

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->user();
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
