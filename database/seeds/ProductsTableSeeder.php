<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Creuset\Post;
use Creuset\User;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder {
	public function run()
	{
		$faker = Faker::create();

		$userIds = User::lists('id')->toArray();

		foreach (range(1,15) as $index)
		{
			factory('Creuset\Product')->create([
				'user_id' => $faker->randomElement($userIds)
				]);
		}
	}
}