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
	post('posts/store', ['uses' => 'Admin\PostsController@store', 'as' => 'admin.posts.store']);

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

	// Users
	get('profile', ['uses' => 'Admin\UsersController@profile', 'as' => 'admin.users.profile'] );
	Route::group(['prefix' => 'users'], function()
	{
		get('{username}', ['uses' => 'Admin\UsersController@edit', 'as' => 'admin.users.edit']);
	});
});

/**
 * Api
 */
Route::group(['prefix' => 'api'], function()
{
	Route::get('categories', ['uses' => 'Api\TermsController@categories', 'as' => 'api.categories']);
	Route::post('categories', ['uses' => 'Api\TermsController@storeCategory', 'as' => 'api.terms']);
});
