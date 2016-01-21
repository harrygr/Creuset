<?php

use Creuset\Address;
use Creuset\Order;
use Creuset\Product;
use Creuset\ShippingMethod;
use Creuset\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $userIds = User::lists('id')->toArray();

        foreach(range(1,15) as $i) {
            factory(Address::class)->create([
                'user_id' => $faker->randomElement($userIds),
                ]);
        }

    }
}
