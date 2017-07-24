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

//include(base_path('routes/admin.php'));
//Admin Routing
Route::group([
    'middleware' => ['auth', 'admin'],
    'as' => 'admin.',
    'prefix' => 'admin',
    'namespace' => 'Admin',
], function() {
    // Orders
    Route::get('/', 'AdminOrdersController@index')->name('orders');
    Route::get('/orders/edit/{order}', 'AdminOrdersController@edit')->name('orders.edit');
    Route::patch('/orders/edit/{order}', 'AdminOrdersController@update')->name('orders.update');
    Route::get('/orders/delete/{order}', 'AdminOrdersController@destroy')->name('orders.delete');

    // Items
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

    // Tags
    Route::get('/tags', 'AdminTagsController@index')->name('tags');
    Route::post('/tags', 'AdminTagsController@store')->name('tags.store');
    Route::get('/tags/create', 'AdminTagsController@create')->name('tags.create');
    Route::get('/tags/edit/{tag}', 'AdminTagsController@edit')->name('tags.edit');
    Route::patch('/tags/edit/{tag}', 'AdminTagsController@update')->name('tags.update');
    Route::get('/tags/delete/{tag}', 'AdminTagsController@destroy')->name('tags.delete');
    Route::get('/tags/toggle/{tag}', 'AdminTagsController@toggle_nav')->name('tags.toggle');
    Route::get('/tags/featured/{tag}', 'AdminTagsController@set_featured')->name('tags.featured');

    // Newsletter
    Route::get('/newsletters', 'AdminNewsletterController@create')->name('newsletters.create');
    Route::post('/newsletters', 'AdminNewsletterController@send')->name('newsletters.send');

    // Users
    Route::get('/users', 'AdminUsersController@index')->name('users');
    Route::post('/users', 'AdminUsersController@store')->name('users.store');
    Route::get('/users/create', 'AdminUsersController@create')->name('users.create');
    Route::get('/users/edit/{user}', 'AdminUsersController@edit')->name('users.edit');
    Route::patch('/users/edit/{user}', 'AdminUsersController@update')->name('users.update');
    Route::get('/users/delete/{user}', 'AdminUsersController@destroy')->name('users.delete');

    // Shippings
    Route::get('/shippings', 'AdminShippingsController@index')->name('shippings');
    Route::post('/shippings', 'AdminShippingsController@store')->name('shippings.store');
    Route::get('/shippings/create', 'AdminShippingsController@create')->name('shippings.create');
    Route::get('/shippings/edit/{shipping}', 'AdminShippingsController@edit')->name('shippings.edit');
    Route::patch('/shippings/edit/{shipping}', 'AdminShippingsController@update')->name('shippings.update');
    Route::get('/shippings/delete/{shipping}', 'AdminShippingsController@destroy')->name('shippings.delete');

    // Utils
    Route::get('/clear_cache', 'AdminUtilsController@clear_cache')->name('clear_cache');
});

// Items
Route::get('/', 'ItemsController@featured')->name('featured');
Route::get('/store', 'ItemsController@index')->name('items');
Route::post('/store', 'ItemsController@index')->name('items.post');
Route::get('/item/{item}', 'ItemsController@show')->name('items.show');

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
