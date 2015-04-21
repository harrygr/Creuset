<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Creuset\User;

class UsersTableSeeder extends Seeder {
	public function run()
	{
		$faker = Faker::create();

		User::create([
			'name' => 'Harry G',
			'email' => 'harry@laravel.com',
			'password' => Hash::make('secret'),
			]);

		foreach (range(1,4) as $index)
		{
			User::create([
				'name' => $faker->name(),
				'email' => $faker->email(),
				'password' => Hash::make($faker->password()),
				]);
		}
	}
}