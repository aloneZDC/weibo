<?php

Route::get('products/{id}', ['uses' => 'ProductsController@show', 'as' => 'products.show']);

//virtual
Route::resource('virtualproducts', 'VirtualProductsController');
