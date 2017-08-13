<?php

Route::get('img/{file?}', 'FileController@img')->where('file', '(.*)')->name('images'); //while refactoring

Route::get('logs', 'LogController@index');

Route::resource('log', 'LogController');
