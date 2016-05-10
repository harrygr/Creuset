<?php

use App\Address;
use App\Order;
use App\Product;
use App\ShippingMethod;
use App\User;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        $shipping_methods = ShippingMethod::all();
        $products = Product::all();
        $users = User::with('addresses')->get();

        $order_ids = array_map(function ($index) use ($shipping_methods, $products, $users) {

            $user = $users->random();

            if (!$user->addresses->count()) {
                $address = factory(Address::class)->create(['addressable_id' => $user->id]);
                $user = $user->fresh();
            }

            $order = factory(Order::class)->create([
                'user_id'               => $user->id,
                'shipping_address_id'   => $user->addresses->random()->id,
                'billing_address_id'    => $user->addresses->random()->id,
                ]);

            $order->addProduct($products->random());
            $order->setShipping($shipping_methods->random()->id);

            return $order->id;

        }, range(1, 15));
    }
}
