<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');


Route::controllers([
	//'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('register', ['uses' => 'Auth\AuthController@getRegister', 'as' => 'auth.register']);
Route::post('register', ['uses' => 'Auth\AuthController@postRegister', 'as' => 'auth.register']);


Route::get('login', ['uses' => 'Auth\AuthController@getLogin', 'as' => 'auth.login']);
Route::post('login', ['uses' => 'Auth\AuthController@postLogin', 'as' => 'auth.login']);
Route::get('logout', ['uses' => 'Auth\AuthController@getLogout', 'as' => 'auth.logout']);



Route::model('post', 'Creuset\Post');

Route::group(['prefix' => 'admin'], function()
{
	Route::get('/', ['uses' => 'Admin\AdminController@dashboard', 'as' => 'admin.dashboard']);

	Route::get('posts', ['uses' => 'Admin\PostsController@index', 'as' => 'admin.posts.index']);
	Route::get('posts/create', ['uses' => 'Admin\PostsController@create', 'as' => 'admin.posts.create']);
	Route::post('posts/store', ['uses' => 'Admin\PostsController@store', 'as' => 'admin.posts.store']);

	Route::get('posts/{post}/edit', ['uses' => 'Admin\PostsController@edit', 'as' => 'admin.posts.edit']);
	Route::patch('posts/{post}', ['uses' => 'Admin\PostsController@update', 'as' => 'admin.posts.update']);
	Route::delete('posts/{post}', ['uses' => 'Admin\PostsController@destroy', 'as' => 'admin.posts.delete']);
});

Route::group(['prefix' => 'api'], function()
{
	Route::get('categories', ['uses' => 'Api\TermsController@categories', 'as' => 'api.categories']);
	Route::post('categories', ['uses' => 'Api\TermsController@storeCategory', 'as' => 'api.terms']);
});
