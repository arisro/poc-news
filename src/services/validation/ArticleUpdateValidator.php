<?php namespace Poc\News\Services\Validation;

use Poc\News\Services\Validation\ValidableInterface;
use Poc\News\Services\Validation\LaravelValidator;

class ArticleUpdateValidator extends LaravelValidator implements ValidableInterface {
	protected $rules = array(
		'title' => 'min:5',
		'body' => 'min:14',
	);
}