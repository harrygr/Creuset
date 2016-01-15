<?php

namespace Creuset;

use Cart;
use Creuset\Presenters\PresentableTrait;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use PresentableTrait;

    protected $presenter = 'Creuset\Presenters\OrderPresenter';

    const PENDING = 'pending';
    const PAID = 'processing';
    const COMPLETED = 'completed';
    const REFUNDED = 'refunded';
    const CANCELLED = 'cancelled';

    public $table = 'orders';

    public $fillable = ['amount', 'status', 'user_id', 'billing_address_id', 'shipping_address_id'];

    /**
     * Sync the order with the current contents of the cart in
     * the session deleting any existing items beforehand.
     * 
     * @return Order
     */
    public function syncWithCart()
    {
        $this->items()->delete();

        $order_items = Cart::content()->map(function ($row) {
            $item = new OrderItem([
                'order_id'    => $this->id,
                'quantity'    => $row->qty,
                'description' => $row->product->name,
                'price_paid'  => $row->product->getPrice(),
                ]);
            $item->orderable()->associate($row->product);
            $item->save();

            return $item;
        });
        $this->update(['amount' => Cart::total()]);

        return $this;
    }

    /**
     * An order belongs to a User.
     * 
     * @return Illuminate\Database\Eloquent\Relations\Relation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * An order belongs to a customer.
     * 
     * @return Illuminate\Database\Eloquent\Relations\Relation
     */
    public function customer()
    {
        return $this->user();
    }

    /**
     * An order has many items.
     * 
     * @return Illuminate\Database\Eloquent\Relations\Relation
     */
    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * An order has many items.
     * 
     * @return Illuminate\Database\Eloquent\Relations\Relation
     */
    public function items()
    {
        return $this->order_items();
    }

    /**
     * An order has one billing address.
     * 
     * @return Illuminate\Database\Eloquent\Relations\Relation
     */
    public function billing_address()
    {
        return $this->hasOne(Address::class, 'id', 'billing_address_id')->withTrashed();
    }

    /**
     * An order has one shipping address.
     * 
     * @return Illuminate\Database\Eloquent\Relations\Relation
     */
    public function shipping_address()
    {
        return $this->hasOne(Address::class, 'id', 'shipping_address_id')->withTrashed();
    }

    /**
     * Is the shipping address the same as the billing.
     * 
     * @return bool
     */
    public function shippingSameAsBilling()
    {
        return !is_null($this->billing_address_id) and $this->billing_address_id === $this->shipping_address_id;
    }

    /**
     * Get the email of the user who owns the order.
     * 
     * @return string
     */
    public function getEmailAttribute()
    {
        if ($this->user) {
            return $this->user->email;
        }

        return;
    }

    /**
     * Get the address of the order.
     * 
     * @param string $type Type of address to get; billing or shipping
     * 
     * @return Address
     */
    public function getAddress($type = 'billing')
    {
        if ($address = $this->{$type.'_address'}) {
            return $address;
        }

        return new Address();
    }
}
