<?php namespace Poc\News;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Controller;

class NewsController extends Controller
{
	protected $article;

	public function __construct(Article $article) {
		$this->article = $article;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Response::json($this->article->all());
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->article->create(array(
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
		$this->article->destroy($id);
		return Response::json(array('success' => true));
	}
}