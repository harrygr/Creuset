<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Creuset\Term;

class TermsTableSeeder extends Seeder {
	public function run()
	{
		$faker = Faker::create();
		$taxonomies = ['category', 'tag'];

		foreach (range(1,15) as $index)
		{
			$term = $faker->word(1);
			Term::create([
				'taxonomy' => $faker->randomElement($taxonomies),
				'term'	=> $term,
				'slug'	=> Str::slug($term),
				]);
		}
	}
}