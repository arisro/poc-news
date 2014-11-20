<?php

Route::group(array('prefix' => 'api'), function() {
	Route::resource('news', 'Poc\News\NewsController',
		array('only' => array('index', 'store', 'destroy', 'update', 'show')));
});