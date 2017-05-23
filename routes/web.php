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
Route::group([
    'middleware' => ['auth', 'admin'],
    'as' => 'admin.',
    'prefix' => 'admin',
    'namespace' => 'Admin',
], function() {
    Route::get('/', 'AdminOrdersController@index')->name('orders');

    Route::get('/items', 'AdminItemsController@index')->name('items');
    Route::post('/items', 'AdminItemsController@store')->name('items.store');
    Route::get('/items/create', 'AdminItemsController@create')->name('items.create');
    Route::get('/items/edit/{item}', 'AdminItemsController@edit')->name('items.edit');
    Route::patch('/items/edit/{item}', 'AdminItemsController@update')->name('items.update');
    Route::get('/items/delete/{item}', 'AdminItemsController@destroy')->name('items.delete');

    // Photos
    Route::post('/items/{item}/photos', 'AdminPhotosController@store')->name('photos.store');
    Route::get('/photos/{photo}/delete', 'AdminPhotosController@destroy')->name('photos.delete');
    Route::get('/photos/{photo}/makeprimary', 'AdminPhotosController@makeprimary')->name('photos.primary');

    Route::get('/tags', 'AdminTagsController@index')->name('tags');
    Route::get('/users', 'AdminUsersController@index')->name('users');
    Route::get('/shippings', 'AdminShippingsController@index')->name('users');
});

// Items
Route::get('/', 'ItemsController@index')->name('items');
Route::post('/', 'ItemsController@index')->name('items.post');
Route::get('/item/{item}', 'ItemsController@show')->name('items.show');

// Users
Auth::routes();
Route::get('/account', 'UsersController@account')->name('account')->middleware('auth');

// Orders
Route::get('/my-orders', 'OrdersController@index')->name('myorders')->middleware('auth');
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
