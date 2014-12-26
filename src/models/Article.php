<?php namespace Poc\News;

use \LaravelBook\Ardent\Ardent;

class Article extends Ardent {
	protected $fillable = array('title', 'body');

	public static $rules = array(
		'title' => 'required'
	);

	public function postedAt()
    {
    	$dateObj =  $this->created_at;

    	if (is_string($this->created_at))
            $dateObj =  DateTime::createFromFormat('Y-m-d H:i:s', $dateObj);
 
        return $dateObj->format('d/m/Y');
    }
}
