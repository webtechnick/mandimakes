<?php
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
    Route::get('/items/toggle_new/{item}', 'AdminItemsController@toggle_new')->name('items.toggle_new');
    Route::get('/items/clear_new', 'AdminItemsController@clear_new')->name('items.clear_new');

    // Posts
    Route::get('/posts', 'AdminPostsController@index')->name('posts');
    Route::post('/posts', 'AdminPostsController@store')->name('posts.store');
    Route::get('/posts/create', 'AdminPostsController@create')->name('posts.create');
    Route::get('/posts/{post}/preview', 'AdminPostsController@show')->name('posts.show');
    Route::get('/posts/{post}/edit', 'AdminPostsController@edit')->name('posts.edit');
    Route::patch('/posts/{post}/edit', 'AdminPostsController@update')->name('posts.update');
    Route::get('/posts/{post}/delete', 'AdminPostsController@destroy')->name('posts.delete');
    Route::get('/posts/{post}/toggle', 'AdminPostsController@toggle')->name('posts.toggle');

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