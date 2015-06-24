<?php

use Carbon\Carbon;

$factory->define('Creuset\Post', function($faker) {

	$creationDate = $faker->dateTimeThisMonth();

	return [
	'title'		=> $faker->sentence,
	'content'	=> $faker->paragraph,
	'slug'		=> $faker->slug,
	'published_at' =>  $creationDate, //$faker->dateTimeThisMonth(), //Carbon::instance($faker->dateTimeThisMonth())->toDateTimeString(),
	'created_at' => $creationDate,
	'updated_at' => $creationDate,
	'user_id'	=> factory('Creuset\User')->create()->id,
	];
});

$factory->define('Creuset\User', function($faker) {
	return [
	'name'			=> $faker->name,
	'email'			=> $faker->email,
	'password'		=> bcrypt('password'),
	];
});

$factory->define('Creuset\Term', function($faker) {
	return [
	'taxonomy'	=> 'category',
	'term'		=> $faker->word,
	];
});

$factory->define('Creuset\Termable', function($faker) {
	return [
	'term_id'		=> 'factory:Creuset\Term',
	'termable_id'	=> 'factory:Creuset\Post',
	'termable_type'	=> 'Creuset/Post'
	];
});