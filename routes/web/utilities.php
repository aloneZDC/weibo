<?php

Route::get('img/{file?}', 'FileController@img')->where('file', '(.*)')->name('images');

Route::get('logs', 'LogController@index');

Route::resource('log', 'LogController');
