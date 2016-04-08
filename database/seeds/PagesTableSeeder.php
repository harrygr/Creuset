<?php

use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $userIds = User::lists('id')->toArray();

        foreach (range(1, 15) as $index) {
            factory('App\Page')->create([
                'user_id' => $faker->randomElement($userIds),
                ]);
        }
    }
}
