<?php

use App\ProductAttribute;
use App\Term;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ProductAttributesTableSeeder extends Seeder
{
    public function run()
    {
        $attributes = collect(range(0,8))->map(function($i) {
            return factory(ProductAttribute::class)->create();
        });
    }

}
