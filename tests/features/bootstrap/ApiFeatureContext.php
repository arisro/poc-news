<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\Context,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Behat\Testwork\Hook\Scope\AfterSuiteScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Hook\Scope\AfterScenarioScope;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

use League\FactoryMuffin\Facade as FactoryMuffin;

require_once 'src/Framework/Assert/Functions.php';

class ApiFeatureContext implements Context
{
    protected static $laravel = null;

	protected $client;

    protected $resource;

	protected $response;

    protected $requestPayload;

    protected $responsePayload;

	public function __construct($base_url)
    {
    	$client_params = [
            'base_url' => $base_url
        ];
        $this->client = new Client($client_params);

        $this->resetDatabase();

        \League\FactoryMuffin\Facade::loadFactories(__DIR__ . '/../../factories');
    }

    /**
     * @Given /^I have the payload:$/
     */
    public function iHaveThePayload(PyStringNode $requestPayload)
    {
        $this->requestPayload = $requestPayload;
    }

    /**
     * @When /^I send a ([A-Z]+) request to "([^"]*)"$/
     */
    public function iSendARequestTo($httpMethod, $url)
    {
        $this->resource = $url;
        $method = strtolower($httpMethod);

        try {
            switch($httpMethod) {
                case 'POST':
                    $post = GuzzleHttp\Utils::jsonDecode($this->requestPayload, true);
                    $this->response = $this->client->$method($url, array('body' => $post));
                    break;
                case 'PUT':
                    $put = GuzzleHttp\Utils::jsonDecode($this->requestPayload, true);
                    $this->response = $this->client->$method($url, array('body' => $put));
                    break;
                default:
                    $this->response = $this->client->$method($url);
            }
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
            if ($response === null) {
                throw $e;
            }

            $this->response = $e->getResponse();
        }
    }


    /**
     * @Then /^the response code should be (\d+)$/
     */
    public function theResponseCodeShouldBe($responseCode)
    {
    	assertEquals((int) $responseCode, $this->response->getStatusCode());
    }

    /**
     * @Given /^the JSON response should contain (\d+) items?$/
     */
    public function theJsonResponseShouldContainItems($numberOfItems)
    {
    	$jsonData = $this->response->json();
    	assertCount((int) $numberOfItems, $jsonData);
    }

    /**
     * @Given /^the response should be empty$/
     */
    public function theResponseShouldBeEmpty()
    {
        assertTrue((string) $this->response->getBody() === '');
    }    

    /**
     * @Given /^there (is|are) (\d+) rows? of "([^"]*)"$/
     */
    public function thereAreRowsOf($ign1, $arg1, $arg2)
    {
        $count = $arg2::all()->count();
        if ($count != $arg1) {
            throw new Exception(
                "Actual count is:\n" . $count
            );
        }
    }

    /**
     * @Given /^there (is|are) (\d+) "([^"]+)"s?$/
     */
    public function thereAreTests($ign1, $num, $modelName)
    {
        FactoryMuffin::seed($num, $modelName);
    }

    /**
     * @BeforeScenario
     */
    public function prepareDatabase(BeforeScenarioScope $scope)
    {
        self::runDatabaseMigrations();
    }

    /**
     * @AfterScenario
     */
    public function resetDatabase(AfterScenarioScope $scope = null)
    {
        self::$laravel['artisan']->call('migrate:reset');
    }

    /**
     * @BeforeSuite
     */
    public static function prepare(BeforeSuiteScope $scope)
    {
        $unitTesting = true;
        $testEnvironment = 'testing';
        if (self::$laravel == null) {
            self::$laravel = require_once __DIR__.'/../../../../../../bootstrap/start.php';
        }

        self::runDatabaseMigrations();
    }

    public static function runDatabaseMigrations() {
        // migrate the main app
        self::$laravel['artisan']->call('migrate');

        // migrate dependencies packages
        // self::$laravel['artisan']->call('migrate', array('--package' => 'poc/users'));

        // migrate our package
        self::$laravel['artisan']->call('migrate', array(
            '--path' => './workbench/poc/news/src/migrations',
        ));
    }
}