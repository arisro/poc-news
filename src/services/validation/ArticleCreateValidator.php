<?php namespace Poc\News\Services\Validation;

use Poc\News\Services\Validation\ValidableInterface;
use Poc\News\Services\Validation\LaravelValidator;

class ArticleCreateValidator extends LaravelValidator implements ValidableInterface {
	protected $rules = array(
		'title' => 'required|min:5',
		'body' => 'required|min:14',
	);
}