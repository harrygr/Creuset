<?php

$factory('Creuset\Post', [
	'title'		=> $faker->sentence,
	'content'	=> $faker->paragraph,
	'slug'		=> $faker->slug,
	'published_at' => $faker->dateTimeThisMonth(),
	'user_id'	=> 'factory:Creuset\User',
	]);

$factory('Creuset\User', [
	'name'			=> $faker->name,
	'email'			=> $faker->email,
	'password'		=> $faker->password,
	]);

$factory('Creuset\Term', [
	'taxonomy'	=> 'category',
	'term'		=> $faker->word,
	]);

$factory('Creuset\Termable', [
	'term_id'		=> 'factory:Creuset\Term',
	'termable_id'	=> 'factory:Creuset\Post',
	'termable_type'	=> 'Creuset/Post'
]);