<?php namespace Poc\News\Tests;

class TestCase extends \Illuminate\Foundation\Testing\TestCase {

	protected static $laravel = null;

	public function setUp()
    {
        parent::setUp();

        $this->prepareForTests();
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
        \Artisan::call('migrate');
        \Artisan::call('migrate', array(
            '--path' => './workbench/poc/news/src/migrations',
        ));
        \Mail::pretend(true);
    }
}