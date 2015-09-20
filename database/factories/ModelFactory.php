<?php

use Carbon\Carbon;
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
	'user_id'	   => 'factory:Creuset\User',
	];
});

$factory->define('Creuset\User', function($faker) {

	$name = $faker->name;

	return [
	'name'			=> $name,
	'username'		=> str_slug($name),
	'email'			=> $faker->email,
	'password'		=> bcrypt('password'),
	];
});

$factory->define('Creuset\Term', function($faker) {

	$term = $faker->word;
	if (strlen($term < 3))
	{
		$term .= " {$faker->word}";
	}
	
	return [
	'taxonomy' => 'category',
	'term'		 => $term,
	'slug'		 => str_slug($term),
	];
});

$factory->define('Creuset\Termable', function($faker) {
	return [
	'term_id'		=> 'factory:Creuset\Term',
	'termable_id'	=> 'factory:Creuset\Post',
	'termable_type'	=> 'Creuset\Post'
	];
});

$factory->define('Creuset\Image', function($faker) {
	$filename = str_random() . '.jpg';

	Intervention::make($faker->imageUrl())
				->save(public_path("uploads/images/{$filename}"))
				->fit(200)
				->save(public_path("uploads/images/tn-{$filename}"));
	return [
		'title' 		=> $faker->sentence,
		'caption' 		=> $faker->paragraph,
		'filename'		=> $filename,
	];
});
