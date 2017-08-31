<?php

Auth::routes();

Route::get('register/confirm/{token}/{email}', [
	'uses' => 'Auth\RegisterController@confirm',
    'as' => 'register.confirm',
]);

Route::get('img/{file?}', 'FileController@img')->where('file', '(.*)')->name('images'); //while refactoring

// home
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get('summary', ['as' => 'home', 'uses' => 'HomeController@summary']); //while refactoring

Route::group(['prefix' => 'home'], function () {
    Route::get('/', 'HomeController@index');
});

//about routes
Route::post('contact', ['as' => 'contact_store', 'uses' => 'AboutController@store']);
Route::get('refunds', ['as' => 'refunds', 'uses' => 'AboutController@refunds']);
Route::get('privacy', ['as' => 'privacy', 'uses' => 'AboutController@privacy']);
Route::get('contact', ['as' => 'contact', 'uses' => 'AboutController@create']);
Route::get('about', ['as' => 'about', 'uses' => 'AboutController@about']);
Route::get('terms', ['as' => 'terms', 'uses' => 'AboutController@terms']);

//orders routes
Route::get('user/orders/removeFrom/{orderName}/{productId}/{idOrder?}', ['uses' => 'OrdersController@removeFromOrder', 'as' => 'orders.remove_from_order']);
Route::put('user/orders/updateQuantity/{detailId}/{newQuantity}', ['uses' => 'OrdersController@updateQuantity', 'as' => 'orders.update_quantity']);
Route::get('modalDetailsProductCart/', ['uses' => 'OrdersController@modalDetailsProductCart', 'as' => 'orders.modalDetailsProductCart']);
Route::get('showDetailsProductCart/{id}', ['uses' => 'OrdersController@showDetailsProductCart', 'as' => 'orders.showDetailsProductCart']);
Route::get('user/orders/addTo/{destination}/{productId}', ['uses' => 'OrdersController@addToOrder', 'as' => 'orders.add_to_order']);
Route::put('user/orders/addTo/{destination}/{productId}', ['uses' => 'OrdersController@addToOrder', 'as' => 'orders.add_to_order']);
Route::get('orders/report/{type}/{filter}', ['uses' => 'OrdersController@reports', 'as' => 'orders.report']);
Route::get('user/cart', ['uses' => 'OrdersController@showCart', 'as' => 'orders.show_cart']);
Route::resource('orderdetails', 'OrderDetailsController');
Route::get('mailTest', 'OrdersController@mailtest');

Route::group(['prefix' => 'user', 'roles' => array_keys(trans('globals.roles')), 'middleware' => ['auth', 'roles']], function ($router) {
    $router->get('user/orders/updateQuantity/{orderId}/{orderDetailId}/{newValue}', ['uses' => 'OrdersController@updateQuantity', 'as' => 'orders.update_order_quantity']);
    $router->get('orders/moveFrom/{origin}/to/{destination}/{productId}', ['uses' => 'OrdersController@moveFromOrder', 'as' => 'orders.move_from_order']);
    $router->get('orders/addToOrder/{orderId}/{productId}', ['uses' => 'OrdersController@addToOrderById', 'as' => 'orders.add_to_order_by_id']);
    $router->get('orders/checkOut/address/{addressId}', ['uses' => 'OrdersController@checkOutResume', 'as' => 'orders.check_out_address']);
    $router->get('product/save/{product}', ['uses' => 'OrdersController@saveForLater', 'as' => 'orders.save_for_later']);
    $router->get('orders/placeOrder/{type}', ['uses' => 'OrdersController@placeOrder', 'as' => 'orders.place_order']);
    $router->get('orders/checkOut/', ['uses' => 'OrdersController@checkOut', 'as' => 'orders.check_out']);
    $router->get('orders', ['uses' => 'OrdersController@usersOrders', 'as' => 'orders.show_orders']);

    $router->get('orders/showSeller/{orderId}', ['uses' => 'OrdersController@showSellerOrder', 'as' => 'orders.show_seller_order']);
    $router->get('orders/rate/{orderId}', ['uses' => 'OrdersController@rateOrder', 'as' => 'orders.rate_order']);
    $router->get('orders/show/{orderId}', ['uses' => 'OrdersController@showOrder', 'as' => 'orders.show_order']);
    $router->get('orders/cancel/{orderId}', ['uses' => 'OrdersController@cancel', 'as' => 'orders.cancel']);

    $router->get('orders/comment/{order_id}', ['uses' => 'OrdersController@commentOrder', 'as' => 'orders.comment']);
    $router->post('orders/storeComment', ['uses' => 'OrdersController@storeComment', 'as' => 'orders.store_comment']);
    $router->get('orders/delete/{order_id}/{type}', ['uses' => 'OrdersController@destroy', 'as' => 'orders.delete']);
    $router->get('orders/close/{order_id}', ['uses' => 'OrdersController@closeOrder', 'as' => 'orders.close']);
    $router->post('rates/product', ['uses' => 'OrdersController@rateProduct', 'as' => 'orders.rate_product']);
    $router->post('rates/seller', ['uses' => 'OrdersController@rateSeller', 'as' => 'orders.rate_seller']);
});

Route::group(['roles' => ['seller', 'admin'], 'middleware' => ['auth', 'roles']], function ($router) {
    $router->get('orders/usersOrders', ['uses' => 'OrdersController@usersOrders', 'as' => 'orders.pendingOrders']);

    $router->get('orders/start/{order_id}', ['uses' => 'OrdersController@startOrder', 'as' => 'orders.start']);
    $router->get('orders/send/{order_id}', ['uses' => 'OrdersController@sendOrder', 'as' => 'orders.send']);
});

Route::group(['prefix' => 'wishes', 'roles' => array_keys(trans('globals.roles')), 'middleware' => ['auth', 'roles']], function ($router) {
    $router->get('/directory', ['uses' => 'OrdersController@wishListDirectory', 'as' => 'orders.show_list_directory']);
    $router->get('/{id}/products', ['uses' => 'OrdersController@showWishList', 'as' => 'orders.show_wish_list_by_id']);
    $router->get('/create', ['uses' => 'OrdersController@createWishList', 'as' => 'orders.create_wish_list']);
    $router->post('/store', ['uses' => 'OrdersController@storeWishList', 'as' => 'orders.store_list']);
    $router->get('/', ['uses' => 'OrdersController@showWishList', 'as' => 'orders.show_wish_list']);
});
