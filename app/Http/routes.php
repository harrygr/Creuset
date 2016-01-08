<?php

Route::get('/', 'HomeController@index');

Route::controllers([
    //'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

/*
 * Registration
 */
Route::get('register', ['uses' => 'Auth\AuthController@getRegister', 'as' => 'auth.register']);
Route::post('register', ['uses' => 'Auth\AuthController@postRegister', 'as' => 'auth.register']);

/*
 * Authentication
 */
Route::get('login', ['uses' => 'Auth\AuthController@getLogin', 'as' => 'auth.login']);
Route::post('login', ['uses' => 'Auth\AuthController@postLogin', 'as' => 'auth.login']);
Route::get('logout', ['uses' => 'Auth\AuthController@getLogout', 'as' => 'auth.logout']);

/*
 * Shop
 */

Route::get('shop/{product_category?}', ['uses' => 'ShopController@index', 'as' => 'products.index']);
Route::get('shop/{product_category}/{product_slug}', ['uses' => 'ProductsController@show', 'as' => 'products.show']);

Route::get('cart', ['uses' => 'CartController@index', 'as' => 'cart']);
Route::post('cart', ['uses' => 'CartController@store', 'as' => 'cart.store']);
Route::delete('cart/{rowid}', ['uses' => 'CartController@remove', 'as' => 'cart.remove']);

Route::get('checkout', ['uses' => 'CheckoutController@show', 'as' => 'checkout.show']);
Route::get('checkout/pay', ['uses' => 'CheckoutController@pay', 'as' => 'checkout.pay']);

Route::post('orders', ['uses' => 'OrdersController@store', 'as' => 'orders.store']);

Route::post('payments', ['uses' => 'PaymentsController@store', 'as' => 'payments.store']);

Route::get('order-completed', ['uses' => 'OrdersController@completed', 'as' => 'orders.completed']);

Route::group(['prefix' => 'account'], function () {

    Route::get('/', ['uses' => 'AccountsController@show', 'as' => 'accounts.show']);

    Route::get('orders/{order}', ['uses' => 'OrdersController@show', 'as' => 'orders.show']);

    Route::get('addresses/new', ['uses' => 'AddressesController@create', 'as' => 'addresses.create']);
    Route::post('addresses', ['uses' => 'AddressesController@store', 'as' => 'addresses.store']);
    Route::get('addresses', ['uses' => 'AddressesController@index', 'as' => 'addresses.index']);
    Route::get('addresses/{address}/edit', ['uses' => 'AddressesController@edit', 'as' => 'addresses.edit']);
    Route::put('addresses/{address}', ['uses' => 'AddressesController@update', 'as' => 'addresses.update']);
    Route::delete('addresses/{address}', ['uses' => 'AddressesController@destroy', 'as' => 'addresses.delete']);
});

/*
 * Admin Area
 */
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', ['uses' => 'Admin\AdminController@dashboard', 'as' => 'admin.dashboard']);

    // Posts
    Route::get('posts', ['uses' => 'Admin\PostsController@index', 'as' => 'admin.posts.index']);
    Route::get('posts/create', ['uses' => 'Admin\PostsController@create', 'as' => 'admin.posts.create']);
    Route::get('posts/trash', ['uses' => 'Admin\PostsController@trash', 'as' => 'admin.posts.trash']);
    Route::post('posts', ['uses' => 'Admin\PostsController@store', 'as' => 'admin.posts.store']);

    Route::put('posts/{trashedPost}/restore', ['uses' => 'Admin\PostsController@restore', 'as' => 'admin.posts.restore']);
    Route::get('posts/{post}/edit', ['uses' => 'Admin\PostsController@edit', 'as' => 'admin.posts.edit']);

    Route::get('posts/{post}/images', ['uses' => 'Admin\PostsController@images', 'as' => 'admin.posts.images']);

    Route::patch('posts/{post}', ['uses' => 'Admin\PostsController@update', 'as' => 'admin.posts.update']);
    Route::delete('posts/{trashedPost}', ['uses' => 'Admin\PostsController@destroy', 'as' => 'admin.posts.delete']);
    // Deprecate this in favor of generic images route
    Route::post('posts/{post}/image', ['uses' => 'Api\MediaController@store', 'as' => 'admin.posts.attach_image']);

    /*
     * PRODUCTS
     */
    Route::get('products/create', ['uses' => 'Admin\ProductsController@create', 'as' => 'admin.products.create']);
    Route::get('products/{product}/edit', ['uses' => 'Admin\ProductsController@edit', 'as' => 'admin.products.edit']);
    Route::get('products/{product}/images', ['uses' => 'Admin\ProductsController@images', 'as' => 'admin.products.images']);
    Route::post('products', ['uses' => 'Admin\ProductsController@store', 'as' => 'admin.products.store']);
    Route::patch('products/{product}', ['uses' => 'Admin\ProductsController@update', 'as' => 'admin.products.update']);
    Route::get('products', ['uses' => 'Admin\ProductsController@index', 'as' => 'admin.products.index']);
    Route::delete('products/{trashedProduct}', ['uses' => 'Admin\ProductsController@destroy', 'as' => 'admin.products.delete']);
    Route::post('products/{product}/image', ['uses' => 'Api\MediaController@store', 'as' => 'admin.products.attach_image']);

    // Terms
    Route::get('terms/{taxonomy}', ['uses' => 'Admin\TermsController@index', 'as' => 'admin.terms.index']);
    Route::get('categories', ['uses' => 'Admin\TermsController@categoriesIndex', 'as' => 'admin.categories.index']);
    Route::get('tags', ['uses' => 'Admin\TermsController@tagsIndex', 'as' => 'admin.tags.index']);

    Route::get('terms/{term}/edit', ['uses' => 'Admin\TermsController@edit', 'as' => 'admin.terms.edit']);

    Route::get('categories/{term}/edit', ['uses' => 'Admin\TermsController@edit', 'as' => 'admin.categories.edit']);
    Route::patch('categories/{term}', ['uses' => 'Admin\TermsController@update', 'as' => 'admin.categories.update']);
    Route::delete('terms/{term}', ['uses' => 'Admin\TermsController@destroy', 'as' => 'admin.terms.delete']);

    Route::get('media', ['uses' => 'Admin\MediaController@index', 'as' => 'admin.media.index']);
    Route::delete('media/{media}', ['uses' => 'Admin\MediaController@destroy', 'as' => 'admin.media.delete']);

    // Users
    Route::get('profile', ['uses' => 'Admin\UsersController@profile', 'as' => 'admin.users.profile']);
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', ['uses' => 'Admin\UsersController@index', 'as' => 'admin.users.index']);
        Route::get('new', ['uses' => 'Admin\UsersController@create', 'as' => 'admin.users.create']);
        Route::post('/', ['uses' => 'Admin\UsersController@store', 'as' => 'admin.users.store']);
        Route::get('{username}', ['uses' => 'Admin\UsersController@edit', 'as' => 'admin.users.edit']);
        Route::patch('{user}', ['as' => 'admin.users.update', 'uses' => 'Admin\UsersController@update']);
    });
});

/*
 * Api
 */
Route::group(['prefix' => 'api'], function () {
    Route::get('terms/{taxonomy}', ['uses' => 'Api\TermsController@terms', 'as' => 'api.terms']);
    Route::post('terms', ['uses' => 'Api\TermsController@store', 'as' => 'api.terms.store']);

    Route::get('categories', ['uses' => 'Api\TermsController@categories', 'as' => 'api.categories']);
    Route::post('categories', ['uses' => 'Api\TermsController@storeCategory', 'as' => 'api.categories']);

    Route::get('posts/{post}/images', ['uses' => 'Api\MediaController@modelImages', 'as' => 'api.posts.images']);
    Route::get('products/{product}/images', ['uses' => 'Api\MediaController@modelImages', 'as' => 'api.products.images']);

    Route::patch('media/{media}', ['uses' => 'Api\MediaController@update', 'as' => 'api.images.update']);
    Route::delete('media/{media}', ['uses' => 'Api\MediaController@destroy', 'as' => 'api.images.destroy']);

    Route::get('media/{media}', ['uses' => 'Api\MediaController@show', 'as' => 'api.media.show'])->where('id', '[0-9]+');
    Route::get('media/{collection?}', ['uses' => 'Api\MediaController@index', 'as' => 'api.media.index']);

    Route::group(['prefix' => 'cart'], function () {
        Route::post('/', ['uses' => 'Api\CartController@store']);
    });

});
