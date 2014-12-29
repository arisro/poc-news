<?php

require_once(__DIR__.'/bindings.php');;

// API routes prefix
Route::group(array('prefix' => 'api'), function() {
	// API versioning
	Route::group(array('prefix' => 'v1'), function() {
		Route::resource('news', 'Poc\News\V1\NewsController');
	});
});