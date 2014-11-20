<?php namespace Poc\News;

use \Illuminate\Database\Eloquent\Model;

class News extends Model {
	protected $fillable = array('title', 'body');
}
