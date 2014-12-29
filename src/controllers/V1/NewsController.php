<?php namespace Poc\News\V1;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Controller;

use Poc\News\Repositories\Interfaces\ArticlesRepositoryInterface;
use Poc\News\Services\Validation\ArticleCreateValidator;
use Poc\News\Services\Validation\ArticleUpdateValidator;

class NewsController extends Controller
{
	protected $articles;
	protected $createValidator;
	protected $updateValidator;

	public function __construct(ArticlesRepositoryInterface $articles, ArticleCreateValidator $createValidator,
		ArticleUpdateValidator $updateValidator) {
		$this->articles = $articles;
		$this->createValidator = $createValidator;
		$this->updateValidator = $updateValidator;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Response::json($this->articles->all());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();

		$validator = $this->createValidator->with($input);
		if (!$this->createValidator->passes()) {
			return Response::json(array('errors' => $this->createValidator->errors()->toJson()), 400);
		}

		$news = $this->articles->create($input);
		
		return Response::json($news, 201);
	}

	/**
	 * Update an existing resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();

		$validator = $this->updateValidator->with($input);
		if (!$this->updateValidator->passes()) {
			return Response::json(array('errors' => $this->updateValidator->errors()->toJson()), 400);
		}

		$article = $this->articles->find($id);
		if (!$article) {
			return Response::json(null, 404);
		}

		$this->articles->setModel($article);
		if (!$this->articles->update($input)) {
			return Response::json(null, 400);
		}
		
		return Response::json($this->articles->getModel(), 200);
	}

	/**
	 * Retrieve the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$news = $this->articles->find($id);
		if (!$news) {
			return Response::make(null, 404);
		}

		return Response::json($news);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if ($this->articles->destroy($id)) {
			return Response::make(null, 204);
		} else {
			return Response::make(null, 404);
		}
		
	}
}