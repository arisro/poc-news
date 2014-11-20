<?php namespace Poc\News;

use Illuminate\Support\Facades\Response;

class NewsController extends \BaseController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Response::json(News::get());
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		News::create(array(
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
		News::destroy($id);
		return Response::json(array('success' => true));
	}
}