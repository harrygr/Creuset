<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Creuset\User;

class UsersTableSeeder extends Seeder {
	public function run()
	{
		$faker = Faker::create();

		// Make a pre-defined user so we can log into the application and play around
		User::create([
			'name' 		=> 'Harry G',
			'username'	=> 'harryg',
			'email' 	=> 'harry@laravel.com',
			'password' 	=> Hash::make('secret'),
			]);

		// Make some auto-generated users for extra usage
		foreach (range(1,4) as $index)
		{
			$name = $faker->name();

			factory('Creuset\User')->create();
		}
	}
}