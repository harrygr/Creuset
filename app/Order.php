<?php

namespace App;

use App\Presenters\PresentableTrait;
use Cart;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use PresentableTrait;

    protected $presenter = 'App\Presenters\OrderPresenter';

    const PENDING = 'pending';
    const PAID = 'processing';
    const COMPLETED = 'completed';
    const REFUNDED = 'refunded';
    const CANCELLED = 'cancelled';

    /**
     * The possible statuses for an order.
     *
     * @var array
     */
    public static $statuses = [
        'pending'       => 'Pending',
        'processing'    => 'Processing',
        'completed'     => 'Completed',
        'refunded'      => 'Refunded',
        'cancelled'     => 'Cancelled',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = ['amount', 'status', 'user_id', 'payment_id', 'billing_address_id', 'shipping_address_id'];

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
            return OrderItem::forProduct($row->product, $row->qty);
        });

        $this->order_items()->saveMany($order_items);
        $this->refreshAmount();

        return $this;
    }

    /**
     * Add a product to an order, creating a new Order Item,
     * or appending to an existing one.
     *
     * @param Product $product
     * @param int     $quantity
     *
     * @return \App\Order
     */
    public function addProduct(Product $product, $quantity = 1)
    {
        $item = $this->product_items()->where('orderable_id', $product->id)->first();

        if ($item) {
            $item->update(['quantity' => $item->quantity + $quantity]);

            return $this;
        }

        $item = OrderItem::forProduct($product, $quantity);

        $this->order_items()->save($item);

        return $this;
    }

    /**
     * Add a shipping method to the order.
     *
     * @param int $id
     *
     * @return \App\Order
     */
    public function setShipping($id)
    {
        $this->shipping_items()->delete();

        $shipping_method = ShippingMethod::find($id);
        $shipping_item = new OrderItem([
            'quantity'    => 1,
            'description' => $shipping_method->description,
            'price_paid'  => $shipping_method->getPrice(),
            ]);
        $shipping_item->orderable()->associate($shipping_method);
        $this->order_items()->save($shipping_item);
        $this->refreshAmount();

        return $this;
    }

    /**
     * Has the order had a shipping method set.
     *
     * @return bool
     */
    public function hasShipping()
    {
        return $this->shipping_items->count() > 0;
    }

    /**
     * Refresh the total for an order by tallying up all the order items.
     *
     * @return float
     */
    public function refreshAmount()
    {
        $amount = $this->order_items->reduce(function ($carry, $item) {
            return ($item->price_paid * $item->quantity) + $carry;
        });

        $this->update(['amount' => $amount]);

        return $this;
    }

    /**
     * Get the Order Item that holds the shipping method for an order.
     *
     * @return OrderItem
     */
    public function getShippingItemAttribute()
    {
        return $this->shipping_items()->first() ?: new OrderItem();
    }

    /**
     * Get the underlying shipping method for an order.
     *
     * @return ShippingMethod
     */
    public function getShippingMethodAttribute()
    {
        $item = $this->shipping_item;
        if ($item->exists) {
            return $item->orderable;
        }

        return new ShippingMethod();
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
     * An order has many shipping items.
     *
     * @return Illuminate\Database\Eloquent\Relations\Relation
     */
    public function shipping_items()
    {
        return $this->order_items()->where('orderable_type', ShippingMethod::class);
    }

    /**
     * An order has many shipping items.
     *
     * @return Illuminate\Database\Eloquent\Relations\Relation
     */
    public function product_items()
    {
        return $this->order_items()->where('orderable_type', Product::class);
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

    /**
     * Limit to abandoned orders.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return void
     */
    public function scopeAbandoned($query)
    {
        $query->where('status', self::PENDING)
              ->where('updated_at', '<', \Carbon\Carbon::now()->subMinutes(config('shop.order_time_limit')));
    }
}
