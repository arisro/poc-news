<?php namespace Poc\News;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;

class NewsController extends \BaseController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Response::json(Article::get());
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		Article::create(array(
			'title' => Input::get('title'),
			'body' => Input::get('body')
		));

		return Response::json(array('success' => true));
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Article::destroy($id);
		return Response::json(array('success' => true));
	}
}