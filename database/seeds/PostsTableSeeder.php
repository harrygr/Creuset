<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Creuset\Post;
use Creuset\User;
use Carbon\Carbon;

class PostsTableSeeder extends Seeder {
	public function run()
	{
		$faker = Faker::create();

		$userIds = User::lists('id')->toArray();

		foreach (range(1,15) as $index)
		{
			factory('Creuset\Post')->create([
				'user_id' => $faker->randomElement($userIds)
				]);
			// $title = $faker->sentence(5);
			// $creationTime = $faker->dateTimeThisMonth(); //Carbon::instance($faker->dateTimeThisMonth())->toDateTimeString();

			// Post::create([
			// 	'title' => $title,
			// 	'slug'	=> Str::slug($title),
			// 	'content' => $faker->paragraph(4),
			// 	'user_id' => $faker->randomElement($userIds),
			// 	'published_at' => $creationTime,
			// 	'created_at' => $creationTime,
			// 	'updated_at' => $creationTime,
			// 	]);
		}
	}
}