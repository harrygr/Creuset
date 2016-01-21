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
    $price = $faker->numberBetween(30, 30000) / 100;

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
    'last_seen_at'     => new \DateTime(),
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
    if (strlen($term) < 4) {
        $term .= ' '.$faker->word;
    }

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

$factory->define('Creuset\OrderItem', function ($faker) {
    $product = factory(Creuset\Product::class)->create();

    return [
    'order_id'          => factory('Creuset\Order')->create()->id,
    'description'       => $product->name,
    'price_paid'        => $product->getPrice(),
    'quantity'          => 1,
    'orderable_type'    => Creuset\Product::class,
    'orderable_id'      => $product->id,
    ];
});

$factory->define('Creuset\Order', function ($faker) {

    $user_id = factory('Creuset\User')->create()->id;
    $address_id = factory('Creuset\Address')->create(['user_id' => $user_id])->id;

    return [
    'user_id'               => $user_id,
    'billing_address_id'    => $address_id,
    'shipping_address_id'   => $faker->randomElement([$address_id, factory('Creuset\Address')->create(['user_id' => $user_id])->id]),
    'status'                => $faker->randomElement(['pending', 'processing', 'processing', 'completed', 'completed', 'cancelled']),
    ];
});

$factory->define('Creuset\Address', function ($faker) {

    return [
    'user_id'       => factory('Creuset\User')->create()->id,
    'name'          => $faker->name,
    'phone'         => $faker->phoneNumber,
    'line_1'        => $faker->buildingNumber.' '.$faker->streetName,
    'city'          => $faker->city,
    'postcode'      => $faker->postcode,
    'country'       => $faker->countryCode,
    ];
});


$factory->define('Creuset\ShippingMethod', function ($faker) {

    return [
        'description'   => $faker->sentence,
        'base_rate'     => $faker->numberBetween(100,600)/100,
    ];
});