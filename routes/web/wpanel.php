<?php

Route::group(['prefix' => 'wpanel', 'roles' => 'admin', 'middleware' => ['auth', 'roles']], function () {
    Route::resource('/', 'WpanelController');

    Route::resource('productsdetails', 'ProductDetailsController');

    Route::get('features', ['uses' => 'ProductDetailsController@index', 'as' => 'features']);

    Route::resource('profile', 'CompanyController');
});
