<?php

Route::get('products/{id}', ['uses' => 'ProductsController@show', 'as' => 'products.show']);

Route::resource('productsoffers', 'ProductOffersController');

//virtual
Route::resource('virtualproducts', 'VirtualProductsController');
