<?php namespace Poc\News\Services\Validation;

use Illuminate\Validation\Factory;
use Poc\News\Services\Validation\ValidableInterface;
use Poc\News\Services\Validation\AbstractValidator;

abstract class LaravelValidator extends AbstractValidator {
	protected $validator;

	public function __construct(Factory $validator)
	{
		$this->validator = $validator;
	}

	public function passes()
	{
		$validator = $this->validator->make($this->data, $this->rules);

		if( $validator->fails() )
		{
			$this->errors = $validator->messages();
			return false;
		}

		return true;
	}
}