<?php

use App\Post;
use App\Product;
use App\Term;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TermablesTableSeeder extends Seeder
{
    private $faker;

    public function run()
    {
        $this->faker = Faker::create();
        $this->seedPostTermables();
        $this->seedProductTermables();
    }

    private function seedPostTermables()
    {
        $post_ids = Post::lists('id')->toArray();
        $term_ids = Term::whereIn('taxonomy', ['tag', 'category'])->lists('id')->toArray();

        foreach (range(1, 30) as $index) {
            DB::table('termables')->insert([
                'term_id'          => $this->faker->randomElement($term_ids),
                'termable_id'      => $this->faker->randomElement($post_ids),
                'termable_type'    => 'App\Post',
                ]);
        }
    }

    private function seedProductTermables()
    {
        $product_ids = Product::lists('id')->toArray();
        $term_ids = Term::whereIn('taxonomy', ['product_category'])->lists('id')->toArray();
        foreach (range(1, 30) as $index) {
            DB::table('termables')->insert([
                'term_id'          => $this->faker->randomElement($term_ids),
                'termable_id'      => $this->faker->randomElement($product_ids),
                'termable_type'    => 'App\Product',
                ]);
        }
    }
}
