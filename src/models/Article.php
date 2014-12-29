<?php namespace Poc\News;

use \Illuminate\Database\Eloquent\Model as Eloquent;
use \Illuminate\Database\Eloquent\SoftDeletingTrait;

class Article extends Eloquent {

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

	protected $fillable = array('title', 'body');

	public function postedAt()
    {
    	$dateObj =  $this->created_at;

    	if (is_string($this->created_at))
            $dateObj =  DateTime::createFromFormat('Y-m-d H:i:s', $dateObj);
 
        return $dateObj->format('d/m/Y');
    }
}
