<?php

use App\Address;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $userIds = User::lists('id')->toArray();

        foreach (range(1, 15) as $i) {
            factory(Address::class)->create([
                'addressable_id' => $faker->randomElement($userIds),
                ]);
        }
    }
}
