<?php

use Creuset\User;
use Illuminate\Database\Seeder;

class ShippingMethodsTableSeeder extends Seeder
{
    public function run()
    {
        Creuset\ShippingMethod::create([
            'description'   => 'UK Shipping',
            'base_rate'     => 400,
        ]);

        Creuset\ShippingMethod::create([
            'description'   => '1st Class Shipping',
            'base_rate'     => 650,
        ]);
    }
}
