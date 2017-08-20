<?php

Route::get('img/{file?}', 'FileController@img')->where('file', '(.*)')->name('images'); //while refactoring
