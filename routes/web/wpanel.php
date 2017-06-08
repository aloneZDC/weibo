<?php

Route::group(['prefix' => 'wpanel', 'roles' => 'admin', 'middleware' => ['auth', 'roles']], function () {

    Route::get('/', 'WpanelController@index');

    Route::resource('productsdetails', 'ProductDetailsController');

    // Route::resource('profile', 'CompanyController');
});
