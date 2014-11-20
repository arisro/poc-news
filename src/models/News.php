<?php
namespace Poc\News;

class News extends \Illuminate\Database\Eloquent\Model {
	protected $fillable = array('title', 'body');
}
