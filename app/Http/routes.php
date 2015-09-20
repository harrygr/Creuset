<?php

Route::get('/', 'HomeController@index');

Route::controllers([
	//'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

/**
 * Registration
 */
Route::get('register', ['uses' => 'Auth\AuthController@getRegister', 'as' => 'auth.register']);
Route::post('register', ['uses' => 'Auth\AuthController@postRegister', 'as' => 'auth.register']);


/**
 * Authentication
 */
Route::get('login', ['uses' => 'Auth\AuthController@getLogin', 'as' => 'auth.login']);
Route::post('login', ['uses' => 'Auth\AuthController@postLogin', 'as' => 'auth.login']);
Route::get('logout', ['uses' => 'Auth\AuthController@getLogout', 'as' => 'auth.logout']);

/**
 * Admin Area
 */
Route::group(['prefix' => 'admin'], function()
{
	Route::get('/', ['uses' => 'Admin\AdminController@dashboard', 'as' => 'admin.dashboard']);

    // Posts
	get('posts', ['uses' => 'Admin\PostsController@index', 'as' => 'admin.posts.index']);
	get('posts/create', ['uses' => 'Admin\PostsController@create', 'as' => 'admin.posts.create']);
	post('posts', ['uses' => 'Admin\PostsController@store', 'as' => 'admin.posts.store']);
	post('posts/{post}/image', ['uses' => 'Api\ImagesController@store', 'as' => 'posts.image.store']);


	get('posts/{post}/edit', ['uses' => 'Admin\PostsController@edit', 'as' => 'admin.posts.edit']);
	patch('posts/{post}', ['uses' => 'Admin\PostsController@update', 'as' => 'admin.posts.update']);
	delete('posts/{post}', ['uses' => 'Admin\PostsController@destroy', 'as' => 'admin.posts.delete']);

	// Terms
	get('categories', ['uses' => 'Admin\TermsController@categoriesIndex', 'as' => 'admin.categories.index']);
	get('tags', ['uses' => 'Admin\TermsController@tagsIndex', 'as' => 'admin.tags.index']);

	get('terms/{term}/edit', ['uses' => 'Admin\TermsController@edit', 'as' => 'admin.terms.edit']);

	get('categories/{term}/edit', ['uses' => 'Admin\TermsController@edit', 'as' => 'admin.categories.edit']);
	patch('categories/{term}', ['uses' => 'Admin\TermsController@update', 'as' => 'admin.categories.update']);
	delete('terms/{term}', ['uses' => 'Admin\TermsController@destroy', 'as' => 'admin.terms.delete']);

	get('images', ['uses' => 'Admin\ImagesController@index', 'as' => 'admin.images.index']);

	// Users
	get('profile', ['uses' => 'Admin\UsersController@profile', 'as' => 'admin.users.profile'] );
	Route::group(['prefix' => 'users'], function()
	{
		get('/', ['uses' => 'Admin\UsersController@index', 'as' => 'admin.users.index']);
		get('new', ['uses' => 'Admin\UsersController@create', 'as' => 'admin.users.create']);
		post('/', ['uses' => 'Admin\UsersController@store', 'as' => 'admin.users.store']);
		get('{username}', ['uses' => 'Admin\UsersController@edit', 'as' => 'admin.users.edit']);
		patch('{user}', ['as' => 'admin.users.update', 'uses' => 'Admin\UsersController@update']);
	});
});

/**
 * Api
 */
Route::group(['prefix' => 'api'], function()
{
	get('categories', ['uses' => 'Api\TermsController@categories', 'as' => 'api.categories']);
	post('categories', ['uses' => 'Api\TermsController@storeCategory', 'as' => 'api.terms']);

	get('posts/{post}/images', ['uses' => 'Api\PostsController@images', 'as' => 'api.posts.images']);

	patch('images/{image}', ['uses' => 'Api\ImagesController@update', 'as' => 'api.images.update']);

});
