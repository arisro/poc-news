<?php namespace Poc\News\Repositories;

use Poc\News\Repositories\Interfaces\ArticlesRepositoryInterface;
use Poc\News\Article;

class EloquentArticlesRepository implements ArticlesRepositoryInterface {
	protected $model;

	public function __construct(Article $article)
	{
		$this->model = $article;
	}

	public function all()
	{
		return $this->model->all();
	}

	public function get()
	{
		return $this->model->get();
	}

	public function create($data)
	{
		return $this->model->create($data);
	}

	public function save($data)
	{
		return $this->model->save($data);
	}

	public function update($data)
	{
		return $this->model->update($data);
	}

	public function find($id)
	{
		return $this->model->find($id);
	}

	public function destroy($id)
	{
		return $this->model->destroy($id);
	}

	public function getModel()
	{
		return $this->model;
	}

	public function setModel($model)
	{
		$this->model = $model;
	}
}