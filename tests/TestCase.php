<?php namespace Poc\News\Tests;

class TestCase extends \Illuminate\Foundation\Testing\TestCase {

	protected static $laravel = null;

	public function setUp()
    {
        parent::setUp();

        $this->prepareForTests();

        \Session::start();
        \Route::enableFilters();
    }

    public static function setupBeforeClass()
	{
		\League\FactoryMuffin\Facade::loadFactories(__DIR__ . '/factories');
	}

	public static function tearDownAfterClass()
	{
		\League\FactoryMuffin\Facade::deleteSaved();
	}

    /**
     * Creates the application.
     *
     * @return Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $unitTesting = true;
        $testEnvironment = 'testing';

        if (self::$laravel == null) {
        	self::$laravel = require __DIR__.'/../../../../bootstrap/start.php';
        }
 
        return self::$laravel;
    }

    /**
     * Migrates the database and set the mailer to 'pretend'.
     * This will cause the tests to run quickly.
     */
    private function prepareForTests()
    {
        \Mail::pretend(true);
    }

    public function mock($class)
    {
        $mock = \Mockery::mock($class);

        self::$laravel->instance($class, $mock);

        return $mock;
    }

    public function __call($method, $args)
    {
        if (in_array($method, ['get', 'post', 'put', 'patch', 'delete']))
        {
            return $this->call($method, $args[0], isset($args[1]) ? $args[1] : array());
        }

        throw new BadMethodCallException;
    }
}