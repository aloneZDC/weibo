<?php

Route::get('products/{product}', ['uses' => 'ProductsController@show', 'as' => 'products.show']);
