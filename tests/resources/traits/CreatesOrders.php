<?php

trait CreatesOrders
{
    protected $customer;
    protected $order;
    protected $address;

    protected function createOrder()
    {
        $this->customer = $this->loginWithUser();
        $this->address = factory(\Creuset\Address::class)->create(['user_id' => $this->customer->id]);
        $this->order = factory('Creuset\Order')->create([
                                                        'user_id' => $this->customer->id,
                                                        'billing_address_id' => $this->address->id,
                                                        'shipping_address_id' => $this->address->id,                                                        
                                                        ]);
        $order_item = factory('Creuset\OrderItem')->create(['order_id' => $this->order->id]);

        $this->order->amount = $order_item->price_paid;
        $this->order->save();
    }
}