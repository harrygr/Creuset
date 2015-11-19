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
	get('posts/trash', ['uses' => 'Admin\PostsController@trash', 'as' => 'admin.posts.trash']);
	post('posts', ['uses' => 'Admin\PostsController@store', 'as' => 'admin.posts.store']);

	put('posts/{trashedPost}/restore', ['uses' => 'Admin\PostsController@restore', 'as' => 'admin.posts.restore']);
	get('posts/{post}/edit', ['uses' => 'Admin\PostsController@edit', 'as' => 'admin.posts.edit']);
    
    get('posts/{post}/images', ['uses' => 'Admin\PostsController@images', 'as' => 'admin.posts.images'] );

	patch('posts/{post}', ['uses' => 'Admin\PostsController@update', 'as' => 'admin.posts.update']);
	delete('posts/{trashedPost}', ['uses' => 'Admin\PostsController@destroy', 'as' => 'admin.posts.delete']);
	// Deprecate this in favor of generic images route
	post('posts/{post}/image', ['uses' => 'Api\MediaController@store', 'as' => 'admin.posts.attach_image']);

	/**
	 * PRODUCTS
	 */
	get('products/create', ['uses' => 'Admin\ProductsController@create', 'as' => 'admin.products.create']);
	get('products/{product}/edit', ['uses' => 'Admin\ProductsController@edit', 'as' => 'admin.products.edit']);
	get('products/{product}/images', ['uses' => 'Admin\ProductsController@images', 'as' => 'admin.products.images'] );
	post('products', ['uses' => 'Admin\ProductsController@store', 'as' => 'admin.products.store']);
	patch('products/{product}', ['uses' => 'Admin\ProductsController@update', 'as' => 'admin.products.update']);
	get('products', ['uses' => 'Admin\ProductsController@index', 'as' => 'admin.products.index']);
	delete('products/{trashedProduct}', ['uses' => 'Admin\ProductsController@destroy', 'as' => 'admin.products.delete']);
	post('products/{product}/image', ['uses' => 'Api\MediaController@store', 'as' => 'admin.products.attach_image']);




	// Terms
	get('terms/{taxonomy}', ['uses' => 'Admin\TermsController@index', 'as' => 'admin.terms.index']);
	get('categories', ['uses' => 'Admin\TermsController@categoriesIndex', 'as' => 'admin.categories.index']);
	get('tags', ['uses' => 'Admin\TermsController@tagsIndex', 'as' => 'admin.tags.index']);

	get('terms/{term}/edit', ['uses' => 'Admin\TermsController@edit', 'as' => 'admin.terms.edit']);

	get('categories/{term}/edit', ['uses' => 'Admin\TermsController@edit', 'as' => 'admin.categories.edit']);
	patch('categories/{term}', ['uses' => 'Admin\TermsController@update', 'as' => 'admin.categories.update']);
	delete('terms/{term}', ['uses' => 'Admin\TermsController@destroy', 'as' => 'admin.terms.delete']);

	get('images', ['uses' => 'Admin\MediaController@index', 'as' => 'admin.images.index']);
	delete('images/{media}', ['uses' => 'Admin\MediaController@destroy', 'as' => 'admin.images.delete']);

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
	get('terms/{taxonomy}', ['uses' => 'Api\TermsController@terms', 'as' => 'api.terms']);
	post('terms', ['uses' => 'Api\TermsController@store', 'as' => 'api.terms.store']);

	get('categories', ['uses' => 'Api\TermsController@categories', 'as' => 'api.categories']);
	post('categories', ['uses' => 'Api\TermsController@storeCategory', 'as' => 'api.categories']);

	get('posts/{post}/images', ['uses' => 'Api\MediaController@modelImages', 'as' => 'api.posts.images']);
	get('products/{product}/images', ['uses' => 'Api\MediaController@modelImages', 'as' => 'api.products.images']);

    patch('images/{image}', ['uses' => 'Api\ImagesController@update', 'as' => 'api.images.update']);
    delete('images/{media}', ['uses' => 'Api\MediaController@destroy', 'as' => 'api.images.destroy']);

	get('media/{media}', ['uses' => 'Api\MediaController@show', 'as' => 'api.media.show'])->where('id', '[0-9]+');
    get('media/{collection?}', ['uses' => 'Api\MediaController@index', 'as' => 'api.media.index']);

});
