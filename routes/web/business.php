<?php

Route::group(['roles' => ['seller', 'admin'], 'middleware' => ['auth', 'roles']], function () {

    Route::post('orders/usersOrders', ['uses' => 'OrdersController@usersOrders', 'as' => 'orders.pendingOrders']);

    Route::get('orders/usersOrders', ['uses' => 'OrdersController@usersOrders', 'as' => 'orders.pendingOrders']);

    Route::get('orders/start/{order_id}', ['uses' => 'OrdersController@startOrder', 'as' => 'orders.start']);

    Route::get('orders/send/{order_id}', ['uses' => 'OrdersController@sendOrder', 'as' => 'orders.send']);

});
