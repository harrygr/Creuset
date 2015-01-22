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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

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

Route::get('admin/posts', ['uses' => 'Admin\PostsController@index', 'as' => 'admin.posts']);
Route::get('admin/posts/{post}/edit', ['uses' => 'Admin\PostsController@edit', 'as' => 'admin.posts.edit']);
Route::patch('admin/posts/{post}', ['uses' => 'Admin\PostsController@update', 'as' => 'admin.posts.update']);
Route::delete('admin/posts/{id}', ['uses' => 'Admin\PostsController@delete', 'as' => 'admin.posts.delete']);