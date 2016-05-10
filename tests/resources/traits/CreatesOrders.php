<?php

trait CreatesOrders
{
    protected $customer;
    protected $order;
    protected $address;

    protected function createOrder($overrides = [])
    {
        $this->customer = factory(\App\User::class)->create();
        $this->address = factory(\App\Address::class)->create(['addressable_id' => $this->customer->id]);

        $order_attributes = array_merge([
            'user_id'             => $this->customer->id,
            'billing_address_id'  => $this->address->id,
            'shipping_address_id' => $this->address->id,
            ], $overrides);

        $this->order = factory('App\Order')->create($order_attributes);
        $order_item = factory('App\OrderItem')->create(['order_id' => $this->order->id]);

        $this->order->amount = $order_item->price_paid;
        $this->order->save();

        return $this->order;
    }
}
