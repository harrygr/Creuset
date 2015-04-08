<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Creuset\Term;

class TermsTableSeeder extends Seeder {

	private $usedWords = [];
	private $faker;


	public function run()
	{
		$taxonomies = ['category', 'tag'];
		$usedWords = [];
		$this->faker = Faker::create();

		foreach (range(1,15) as $index)
		{
			Term::create([
				'taxonomy' => $this->faker->randomElement($taxonomies),
				'term'	=> $this->getUniqueWord();,
				'slug'	=> Str::slug($term),
				]);
		}
	}

	/**
	 * Generate a word that hasn't yet been used in the class
	 */
	private function getUniqueWord()
	{
		$word = $this->faker->word(1);
		if (! in_array($word, $this->usedWords))
		{
			$this->usedWords[] = $word;
			return $word;
		}
		return $this->getUniqueWord();
	}
}