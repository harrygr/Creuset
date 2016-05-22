<?php

 // DB::listen(function ($query) {
 //    var_dump($query->sql, $query->bindings, $query->time);
 //        });

Route::group(['middleware' => ['web']], function () {

    Route::get('/', 'HomeController@index');

    Route::controllers([
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
    Route::get('shop/search', ['uses' => 'ShopController@search', 'as' => 'shop.search']);
    Route::get('shop/{product_category?}', ['uses' => 'ShopController@index', 'as' => 'products.index']);
    Route::get('shop/{product_category}/{product_slug}', ['uses' => 'ProductsController@show', 'as' => 'products.show']);

    Route::get('cart', ['uses' => 'CartController@index', 'as' => 'cart', 'middleware' => 'cart.empty']);
    Route::post('cart', ['uses' => 'CartController@store', 'as' => 'cart.store']);
    Route::delete('cart/{rowid}', ['uses' => 'CartController@remove', 'as' => 'cart.remove']);

    Route::get('checkout', ['uses' => 'CheckoutController@show', 'as' => 'checkout.show', 'middleware' => 'cart.empty']);
    Route::get('checkout/shipping', ['uses' => 'CheckoutController@shipping', 'as' => 'checkout.shipping']);
    Route::get('checkout/pay', ['uses' => 'CheckoutController@pay', 'as' => 'checkout.pay']);

    Route::post('orders', ['uses' => 'OrdersController@store', 'as' => 'orders.store']);
    Route::post('orders/shipping', ['uses' => 'OrdersController@shipping', 'as' => 'orders.shipping']);

    Route::post('payments', ['uses' => 'PaymentsController@store', 'as' => 'payments.store']);

    Route::get('order-completed', ['uses' => 'OrdersController@completed', 'as' => 'orders.completed']);

    /*
     * Account
     */
    Route::group(['prefix' => 'account'], function () {

        Route::get('/', ['uses' => 'AccountsController@show', 'as' => 'accounts.show']);
        Route::get('edit', ['uses' => 'AccountsController@edit', 'as' => 'accounts.edit']);
        Route::patch('{user}', ['uses' => 'AccountsController@update', 'as' => 'accounts.update']);

        Route::get('orders/{order}', ['uses' => 'OrdersController@show', 'as' => 'orders.show']);

        Route::get('addresses/new', ['uses' => 'AddressesController@create', 'as' => 'addresses.create']);
        Route::post('addresses', ['uses' => 'AddressesController@store', 'as' => 'addresses.store']);
        Route::get('addresses', ['uses' => 'AddressesController@index', 'as' => 'addresses.index']);
        Route::get('addresses/{address}/edit', ['uses' => 'AddressesController@edit', 'as' => 'addresses.edit']);
        Route::put('addresses/{address}', ['uses' => 'AddressesController@update', 'as' => 'addresses.update']);
        Route::delete('addresses/{address}', ['uses' => 'AddressesController@destroy', 'as' => 'addresses.delete']);
    });

}); // /web middleware group

/*
 * Admin Area
 */
Route::group(['prefix' => 'admin', 'middleware' => ['web', 'admin']], function () {

    Route::get('/', ['uses' => 'Admin\AdminController@dashboard', 'as' => 'admin.dashboard']);

    // Orders
    Route::get('orders/{order}', ['uses' => 'Admin\OrdersController@show', 'as' => 'admin.orders.show'])->where('order', '[0-9]+');
    Route::get('orders/{order_status?}', ['uses' => 'Admin\OrdersController@index', 'as' => 'admin.orders.index']);
    Route::patch('orders/{order}', ['uses' => 'Admin\OrdersController@update', 'as' => 'admin.orders.update']);

    // Shipping Methods
    Route::get('shipping-methods', ['uses' => 'Admin\ShippingMethodsController@index', 'as' => 'admin.shipping_methods.index']);
    Route::post('shipping-methods', ['uses' => 'Admin\ShippingMethodsController@store', 'as' => 'admin.shipping_methods.store']);
    Route::get('shipping-methods/{shipping_method}/edit', ['uses' => 'Admin\ShippingMethodsController@edit', 'as' => 'admin.shipping_methods.edit']);
    Route::patch('shipping-methods/{shipping_method}', ['uses' => 'Admin\ShippingMethodsController@update', 'as' => 'admin.shipping_methods.update']);
    Route::delete('shipping-methods/{shipping_method}', ['uses' => 'Admin\ShippingMethodsController@destroy', 'as' => 'admin.shipping_methods.delete']);

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

    // Pages
    Route::get('pages', ['uses' => 'Admin\PagesController@index', 'as' => 'admin.pages.index']);
    Route::get('pages/create', ['uses' => 'Admin\PagesController@create', 'as' => 'admin.pages.create']);
    Route::get('pages/{page}/edit', ['uses' => 'Admin\PagesController@edit', 'as' => 'admin.pages.edit']);
    Route::get('pages/trash', ['uses' => 'Admin\PagesController@trash', 'as' => 'admin.pages.trash']);

    Route::post('pages', ['uses' => 'Admin\PagesController@store', 'as' => 'admin.pages.store']);
    Route::put('pages/{trashedPage}/restore', ['uses' => 'Admin\PagesController@restore', 'as' => 'admin.pages.restore']);
    Route::patch('pages/{page}', ['uses' => 'Admin\PagesController@update', 'as' => 'admin.pages.update']);
    Route::delete('pages/{trashedPage}', ['uses' => 'Admin\PagesController@destroy', 'as' => 'admin.pages.delete']);

    // Products
    Route::get('products/create', ['uses' => 'Admin\ProductsController@create', 'as' => 'admin.products.create']);
    Route::get('products/{product}/edit', ['uses' => 'Admin\ProductsController@edit', 'as' => 'admin.products.edit']);
    Route::get('products/{product}/images', ['uses' => 'Admin\ProductsController@images', 'as' => 'admin.products.images']);
    Route::post('products', ['uses' => 'Admin\ProductsController@store', 'as' => 'admin.products.store']);
    Route::patch('products/{product}', ['uses' => 'Admin\ProductsController@update', 'as' => 'admin.products.update']);
    Route::get('products', ['uses' => 'Admin\ProductsController@index', 'as' => 'admin.products.index']);
    Route::post('products/{product}/image', ['uses' => 'Api\MediaController@store', 'as' => 'admin.products.attach_image']);
    Route::delete('products/{product}', ['uses' => 'Admin\ProductsController@destroy', 'as' => 'admin.products.delete']);

    // Terms
    Route::get('terms/{taxonomy}', ['uses' => 'Admin\TermsController@index', 'as' => 'admin.terms.index']);
    Route::get('categories', ['uses' => 'Admin\TermsController@categoriesIndex', 'as' => 'admin.categories.index']);
    Route::get('tags', ['uses' => 'Admin\TermsController@tagsIndex', 'as' => 'admin.tags.index']);

    Route::get('terms/{term}/edit', ['uses' => 'Admin\TermsController@edit', 'as' => 'admin.terms.edit']);
    Route::patch('terms/{term}', ['uses' => 'Admin\TermsController@update', 'as' => 'admin.terms.update']);

    Route::get('categories/{term}/edit', ['uses' => 'Admin\TermsController@edit', 'as' => 'admin.categories.edit']);
    Route::patch('categories/{term}', ['uses' => 'Admin\TermsController@update', 'as' => 'admin.categories.update']);
    Route::delete('terms/{term}', ['uses' => 'Admin\TermsController@destroy', 'as' => 'admin.terms.delete']);

    // Product Attributes
    Route::get('attributes', ['uses' => 'Admin\AttributesController@index', 'as' => 'admin.attributes.index']);
    Route::get('attributes/create', ['uses' => 'Admin\AttributesController@create', 'as' => 'admin.attributes.create']);
    Route::get('attributes/{attribute_slug}/edit', ['uses' => 'Admin\AttributesController@edit', 'as' => 'admin.attributes.edit']);
    Route::delete('attributes/{taxonomy}', ['uses' => 'Admin\AttributesController@destroy', 'as' => 'admin.attributes.delete']);

    // Media
    Route::get('media', ['uses' => 'Admin\MediaController@index', 'as' => 'admin.media.index']);
    Route::delete('media/{media}', ['uses' => 'Admin\MediaController@destroy', 'as' => 'admin.media.delete']);

    // Users
    Route::get('profile', ['uses' => 'Admin\UsersController@profile', 'as' => 'admin.users.profile']);
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', ['uses' => 'Admin\UsersController@index', 'as' => 'admin.users.index']);
        Route::get('new', ['uses' => 'Admin\UsersController@create', 'as' => 'admin.users.create']);
        Route::post('/', ['uses' => 'Admin\UsersController@store', 'as' => 'admin.users.store']);
        Route::get('{user}', ['uses' => 'Admin\UsersController@edit', 'as' => 'admin.users.edit'])->where('user', '[0-9]+');
        Route::get('{username}', ['uses' => 'Admin\UsersController@edit', 'as' => 'admin.users.edit']);

        Route::patch('{user}', ['as' => 'admin.users.update', 'uses' => 'Admin\UsersController@update']);

        Route::get('{username}/orders', ['uses' => 'Admin\UsersController@orders', 'as' => 'admin.users.orders']);
        Route::get('{username}/addresses', ['uses' => 'Admin\UsersController@addresses', 'as' => 'admin.users.addresses']);
    });
});

/*
 * Api
 */
Route::group(['prefix' => 'api', 'middleware' => 'api'], function () {
    Route::get('terms/{taxonomy}', ['uses' => 'Api\TermsController@terms', 'as' => 'api.terms']);
    Route::post('terms', ['uses' => 'Api\TermsController@store', 'as' => 'api.terms.store']);
    Route::delete('terms/{term}', ['uses' => 'Api\TermsController@destroy', 'as' => 'api.terms.delete']);
    Route::patch('terms/{term}', ['uses' => 'Api\TermsController@update', 'as' => 'api.terms.update']);

    // Attributes
    Route::get('product_attributes/{slug?}', ['uses' => 'Api\ProductAttributesController@index', 'as' => 'api.product_attributes.index']);
    Route::post('product_attributes', ['uses' => 'Api\ProductAttributesController@store', 'as' => 'api.product_attributes.store']);
    Route::delete('product_attributes/{product_attribute}', ['uses' => 'Api\ProductAttributesController@destroy', 'as' => 'api.product_attributes.delete']);
    Route::patch('product_attributes/{product_attribute}', ['uses' => 'Api\ProductAttributesController@update', 'as' => 'api.product_attributes.update']);

    Route::get('categories', ['uses' => 'Api\TermsController@categories', 'as' => 'api.categories']);
    Route::post('categories', ['uses' => 'Api\TermsController@storeCategory', 'as' => 'api.categories']);

    Route::get('posts/{post}/images', ['uses' => 'Api\MediaController@modelImages', 'as' => 'api.posts.images']);
    Route::get('products/{product}/images', ['uses' => 'Api\MediaController@modelImages', 'as' => 'api.products.images']);

    Route::patch('media/{media}', ['uses' => 'Api\MediaController@update', 'as' => 'api.images.update']);
    Route::delete('media/{media}', ['uses' => 'Api\MediaController@destroy', 'as' => 'api.images.destroy']);

    Route::get('media/{media}', ['uses' => 'Api\MediaController@show', 'as' => 'api.media.show'])->where('id', '[0-9]+');
    Route::get('media/{collection?}', ['uses' => 'Api\MediaController@index', 'as' => 'api.media.index']);

    Route::group(['prefix' => 'orders'], function () {
        Route::patch('{order}', ['uses' => 'Api\OrdersController@update', 'as' => 'api.orders.update']);
    });

});

/*
 * If none of the above routes are matched we will see if a page has a matching path
 */
Route::get('{path}', ['uses' => 'PagesController@show', 'middleware' => ['web']])->where('path', '.+');
