<?php

use Image as Intervention;

$factory->define('Creuset\Post', function($faker) {

	$creationDate = $faker->dateTimeThisMonth();
	$title = $faker->sentence;	

	return [
		'title'		   => $title,
		'content'	   => $faker->paragraph,
		'slug'		   => str_slug($title),
		'published_at' => $creationDate, 
		'created_at'   => $creationDate,
		'updated_at'   => $creationDate,
		'user_id'	   => factory(Creuset\User::class)->create()->id,
	];
});

$factory->define('Creuset\User', function($faker) {

	$name = $faker->unique()->name;

	return [
		'name'			=> $name,
		'username'		=> str_slug($name),
		'email'			=> $faker->unique()->email,
		'password'		=> bcrypt('password'),
	];
});

$factory->define('Creuset\Term', function($faker) {

	$term = $faker->unique()->word;
	
	return [
		'taxonomy'   => 'category',
		'term'		 => $term,
		'slug'		 => str_slug($term),
	];
});

$factory->define('Creuset\Termable', function($faker) {
	return [
		'term_id'		=> factory(Creuset\Term::class)->create()->id,
		'termable_id'	=> factory(Creuset\Post::class)->create()->id,
		'termable_type'	=> 'Creuset\Post'
	];
});

$factory->define('Creuset\Image', function($faker) {
	$filename = str_random() . '.jpg';
	$image_path = public_path("uploads/images");

	if (!File::exists($image_path)) {
		File::makeDirectory($image_path, 0777, true);
	}

	Intervention::make($faker->imageUrl())
				->save("{$image_path}/{$filename}")
				->fit(200)
				->save("{$image_path}/tn-{$filename}");
	return [
		'title' 		=> $faker->sentence,
		'caption' 		=> $faker->paragraph,
		'filename'		=> $filename,
		'user_id' 		=> factory(Creuset\User::class)->create()->id,
	];
});
