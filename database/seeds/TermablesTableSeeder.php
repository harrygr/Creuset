<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Creuset\Post;
use Creuset\Term;

class TermablesTableSeeder extends Seeder {
	public function run()
	{
		$faker = Faker::create();

		$postIds = Post::lists('id');
		$termIds = Term::lists('id');


		foreach (range(1,30) as $index)
		{
			DB::table('termables')->insert([
				'term_id'	=> $faker->randomElement($termIds),
				'termable_id'	=> $faker->randomElement($postIds),
				'termable_type'	=> 'Creuset\Post',
				]);
		}
	}
}