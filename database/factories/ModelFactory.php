<?php

use Carbon\Carbon;

$factory->define('Creuset\Post', function($faker) {

	$creationDate = $faker->dateTimeThisMonth();

	return [
	'title'		   => $faker->sentence,
	'content'	   => $faker->paragraph,
	'slug'		   => $faker->slug,
	'published_at' =>  $creationDate, 
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
	'termable_type'	=> 'Creuset/Post'
	];
});
