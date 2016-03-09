<?php

use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $userIds = User::lists('id')->toArray();

        foreach (range(1, 15) as $index) {
            factory('App\Product')->create([
                'user_id' => $faker->randomElement($userIds),
                ]);
        }
    }
}
