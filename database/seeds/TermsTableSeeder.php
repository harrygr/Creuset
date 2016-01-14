<?php

use Creuset\Term;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TermsTableSeeder extends Seeder
{
    private $usedWords = [];
    private $faker;

    public function run()
    {
        $this->createUncategorisedCategories();

        $taxonomies = ['category', 'tag', 'product_category'];
        $usedWords = [];
        $this->faker = Faker::create();

        foreach (range(1, 30) as $index) {
            $term = $this->getUniqueWord();

            Term::create([
                'taxonomy' => $this->faker->randomElement($taxonomies),
                'term'     => $term,
                'slug'     => Str::slug($term),
                ]);
        }
    }

    /**
     * Generate a word that hasn't yet been used in the class.
     */
    private function getUniqueWord()
    {
        return str_replace('.', '', $this->faker->unique()->sentence(2));
    }

    private function createUncategorisedCategories()
    {
        Term::create([
            'taxonomy' => 'product_category',
            'term'     => 'Uncategorised',
            'slug'     => 'uncategorised',
            ]);

        Term::create([
            'taxonomy' => 'category',
            'term'     => 'Uncategorised',
            'slug'     => 'uncategorised',
            ]);
    }
}
