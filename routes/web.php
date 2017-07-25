<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Admin Routing
// Loaded from RouteServiceProvider.php


// Items
Route::get('/', 'ItemsController@featured')->name('featured');
Route::get('/store', 'ItemsController@index')->name('items');
Route::post('/store', 'ItemsController@index')->name('items.post');
Route::get('/item/{item}', 'ItemsController@show')->name('items.show');

// Posts
Route::get('/blog', 'PostsController@index')->name('posts');
Route::get('/blog/{post}', 'PostsController@show')->name('posts.show');

// Tags
Route::get('/tags', 'TagsController@index')->name('tags.index');

// Newsletter
Route::match(['post','get'], '/newsletters/subscribe/{email?}', 'NewsletterController@subscribe')->name('newsletters.subscribe');
Route::match(['post','get'], '/newsletters/unsubscribe/{email?}', 'NewsletterController@unsubscribe')->name('newsletters.unsubscribe');

// Users
Auth::routes();
Route::get('/account', 'UsersController@account')->name('account')->middleware('auth');
Route::patch('/account', 'UsersController@update')->name('users.update')->middleware('auth');
Route::get('/account/password', 'UsersController@password')->name('users.password')->middleware('auth');
Route::patch('/account/password', 'UsersController@change_password')->name('users.change_password')->middleware('auth');

// Orders
Route::get('/my-orders', 'OrdersController@index')->name('myorders')->middleware('auth');
Route::get('/my-orders/{order}', 'OrdersController@show')->name('orders.show')->middleware('auth');
Route::get('/checkout', 'OrdersController@create')->name('checkout');
Route::post('/checkout', 'OrdersController@store')->name('orders.store');

// Cart
Route::get('/carts/add/{item}/{qty?}', 'CartsController@add')->name('carts.add');
Route::get('/carts/change/{item}/{qty}', 'CartsController@change')->name('carts.change');
Route::post('/carts/change/{item}', 'CartsController@change')->name('carts.post.change');
Route::get('/carts/remove/{item}', 'CartsController@remove')->name('carts.remove');
Route::get('/carts/clear', 'CartsController@clear')->name('carts.clear');

// Pages
Route::get('/about', 'PagesController@about')->name('about');
