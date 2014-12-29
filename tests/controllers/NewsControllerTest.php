<?php

use Poc\News\Tests\TestCase;
use \Mockery as M;

class PostsControllerTest extends TestCase {

	public function __construct()
	{
		$this->createApplication();
	}

	// V1 API tests
	public function testIndexV1()
	{
		$articlesRepoMock = $this->mock('Poc\News\Repositories\Interfaces\ArticlesRepositoryInterface');
		$articlesRepoMock->shouldReceive('all')->once();

        $this->get(route('api.v1.news.index'));

  		$this->assertResponseOk();
	}

	public function testStoreV1Fails()
	{
		$articlesRepoMock = $this->mock('Poc\News\Repositories\Interfaces\ArticlesRepositoryInterface');

		$validatorMock = $this->mock('Poc\News\Services\Validation\ArticleCreateValidator');

		$errors = $this->mock('Illuminate\Support\MessageBag');
    	$errors
    		->shouldReceive('toJson')
    		->once()
    		->andReturn(json_encode(array('errors' => array())));

		$validatorMock
			->shouldReceive('with')
			->shouldReceive('errors')
			->once()
			->andReturn($errors)
			->shouldReceive('passes')
			->once()
			->andReturn(false);

		$response = $this->post(route('api.v1.news.store'));

		$this->assertResponseStatus(400);
	}

	public function testStoreV1Success()
	{
		$articlesRepoMock = $this->mock('Poc\News\Repositories\Interfaces\ArticlesRepositoryInterface');
		$validatorMock = $this->mock('Poc\News\Services\Validation\ArticleCreateValidator');

		$validatorMock
			->shouldReceive('with')
			->shouldReceive('passes')
			->once()
			->andReturn(true);

		$articlesRepoMock
			->shouldReceive('create')
			->once();

		$response = $this->post(route('api.v1.news.store'));

		$this->assertResponseStatus(201);
	}

	public function testUpdateSuccess()
	{
		$articlesRepoMock = $this->mock('Poc\News\Repositories\Interfaces\ArticlesRepositoryInterface');
		$validatorMock = $this->mock('Poc\News\Services\Validation\ArticleUpdateValidator');

		$validatorMock
			->shouldReceive('with')
			->shouldReceive('passes')
			->once()
			->andReturn(true);

		$articlesRepoMock
			->shouldReceive('find')
			->once()
			->andReturn(true)
			->shouldReceive('setModel')
			->shouldReceive('update')
			->once()
			->andReturn(true)
			->shouldReceive('getModel');

		$response = $this->put(route('api.v1.news.update'));

		$this->assertResponseStatus(200);
	}

	public function testUpdateNotFound()
	{
		$articlesRepoMock = $this->mock('Poc\News\Repositories\Interfaces\ArticlesRepositoryInterface');
		$validatorMock = $this->mock('Poc\News\Services\Validation\ArticleUpdateValidator');

		$validatorMock
			->shouldReceive('with')
			->shouldReceive('passes')
			->once()
			->andReturn(true);

		$articlesRepoMock
			->shouldReceive('find')
			->once()
			->andReturn(false);

		$response = $this->put(route('api.v1.news.update'));

		$this->assertResponseStatus(404);
	}

	public function testUpdateValidationFail()
	{
		$articlesRepoMock = $this->mock('Poc\News\Repositories\Interfaces\ArticlesRepositoryInterface');
		$validatorMock = $this->mock('Poc\News\Services\Validation\ArticleUpdateValidator');
		$errors = $this->mock('Illuminate\Support\MessageBag');

    	$errors
    		->shouldReceive('toJson')
    		->once()
    		->andReturn(json_encode(array('errors' => array())));

		$validatorMock
			->shouldReceive('with')
			->shouldReceive('passes')
			->once()
			->andReturn(false)
			->shouldReceive('errors')
			->once()
			->andReturn($errors);

		$response = $this->put(route('api.v1.news.update'));

		$this->assertResponseStatus(400);
	}

	public function testShowV1Success()
	{
		$articlesRepoMock = $this->mock('Poc\News\Repositories\Interfaces\ArticlesRepositoryInterface');

		$id = rand(1,100);
		$articlesRepoMock->shouldReceive('find')->once()->with($id)->andReturn(M::mock());

		$response = $this->get(route('api.v1.news.show', $id));

		$this->assertResponseStatus(200);
	}

	public function testShowV1NotFound()
	{
		$articlesRepoMock = $this->mock('Poc\News\Repositories\Interfaces\ArticlesRepositoryInterface');

		$id = rand(1,100);
		$articlesRepoMock->shouldReceive('find')->once()->with($id)->andReturn(null);

		$response = $this->get(route('api.v1.news.show', $id));

		$this->assertResponseStatus(404);
	}

	public function testDestroySuccess()
	{
		$articlesRepoMock = $this->mock('Poc\News\Repositories\Interfaces\ArticlesRepositoryInterface');
		$id = rand(1,100);
		$articlesRepoMock
			->shouldReceive('destroy')
			->once()
			->with($id)
			->andReturn(true);

		$response = $this->delete(route('api.v1.news.destroy', $id));

		$this->assertResponseStatus(204);
	}

	public function testDestroyNotFound()
	{
		$articlesRepoMock = $this->mock('Poc\News\Repositories\Interfaces\ArticlesRepositoryInterface');
		$id = rand(1,100);
		$articlesRepoMock
			->shouldReceive('destroy')
			->once()
			->with($id)
			->andReturn(false);

		$response = $this->delete(route('api.v1.news.destroy', $id));

		$this->assertResponseStatus(404);
	}

	public function tearDown()
	{
		parent::tearDown();
		M::close();
	}
}