<?php namespace Poc\News\Repositories\Interfaces;

interface ArticlesRepositoryInterface {
	public function all();
	public function get();
	public function create($data);
	public function save($data);
	public function update($data);
	public function find($id);
	public function destroy($id);
	public function getModel();
	public function setModel($model);
}