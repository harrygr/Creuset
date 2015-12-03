<?php


$factory->define('Creuset\Post', function ($faker) {

    $creationDate = $faker->dateTimeThisMonth();
    $title = $faker->sentence;

    return [
        'title'           => $title,
        'content'         => $faker->paragraph,
        'slug'            => str_slug($title),
        'published_at'    => $creationDate,
        'created_at'      => $creationDate,
        'updated_at'      => $creationDate,
        'user_id'         => factory(Creuset\User::class)->create()->id,
    ];
});

$factory->define('Creuset\Product', function ($faker) {
    $name = $faker->sentence(3);
    $price = $faker->numberBetween(3, 300);

    return [
        'name'          => $name,
        'slug'          => str_slug($name),
        'sku'           => strtoupper($faker->unique()->bothify('???###')),
        'description'   => $faker->paragraph(3),
        'price'         => $price,
        'sale_price'    => $faker->randomElement([null, $faker->numberBetween(2, $price)]),
        'stock_qty'     => $faker->numberBetween(0, 15),
        'user_id'       => factory(Creuset\User::class)->create()->id,
    ];
});

$factory->define('Creuset\User', function ($faker) {

    $name = $faker->unique()->name;

    return [
        'name'             => $name,
        'username'         => str_slug($name),
        'email'            => $faker->unique()->email,
        'password'         => bcrypt('password'),
    ];
});

$factory->define('Creuset\Role', function ($faker) {
    $name = $faker->unique()->word;

    return [
        'name'         => str_slug($name),
        'display_name' => $name,
        'description'  => $faker->sentence,
    ];
});

$factory->define('Creuset\Term', function ($faker) {

    $term = $faker->unique()->word;

    return [
        'taxonomy'     => 'category',
        'term'         => $term,
        'slug'         => str_slug($term),
    ];
});

$factory->define('Creuset\Termable', function ($faker) {
    return [
        'term_id'          => factory(Creuset\Term::class)->create()->id,
        'termable_id'      => factory(Creuset\Post::class)->create()->id,
        'termable_type'    => 'Creuset\Post',
    ];
});
