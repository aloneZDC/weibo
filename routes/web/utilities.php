<?php

Route::get('img/{file?}', 'FileController@img')->where('file', '(.*)')->name('images');
Route::get('images/{file?}', 'FileController@image')->where('file', '(.*)')->name('images2');

Route::get('logs', 'LogController@index');

Route::resource('log', 'LogController');
