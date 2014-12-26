<?php

use Poc\News\Tests\TestCase;
use Poc\News\Article;
use League\FactoryMuffin\Facade as FactoryMuffin;
use \Mockery as M;

class PostsControllerTest extends TestCase {

	public function __construct()
	{
		$this->createApplication();

		// $this->mock = $this->mock('Poc\News\ArticleRepo');
		// M::mock('Eloquent');
		// $this->mock = M::mock('Ardent', 'Poc\News\Article');
	}

	public function testIndex()
	{
		// $this->mock
		// 	->shouldReceive('newQuery')
		//     ->once()
		//     ->shouldReceive('all')
		//     ->once()
		//     ->andReturn('foo');

  //       self::$laravel->instance('Poc\News\Article', $this->mock);

  //       $response = $this->call('GET', 'api/news');

        // var_dump($response);
 
  		// $this->assertResponseOk();

		// $response = $this->get('news');
		// var_dump($response->original->getData());
		// $this->assertViewHas('news');

		// $posts = $response->original->getData();

		// $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $posts);
		$this->assertTrue(true);
	}

	public function tearDown()
	{
		M::close();
	}
}