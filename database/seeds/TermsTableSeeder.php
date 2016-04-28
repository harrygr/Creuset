<?php

use App\Term;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TermsTableSeeder extends Seeder
{
    public function run()
    {
        $this->createUncategorisedCategories();

        $faker = Faker::create();
        $taxonomies = ['category', 'tag', 'product_category'];

        foreach (range(1, 30) as $index) {
            factory(Term::class)->create([
                'taxonomy' => $faker->randomElement($taxonomies),
                ]);
        }
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
