<?php

use Poc\News\Tests\TestCase;
use League\FactoryMuffin\Facade as FactoryMuffin;

class ArticleTest extends TestCase {
    
    public function testPostedAt()
    {
        $article = FactoryMuffin::create('Poc\News\Article');

        $expected = '/^\d{2}\/\d{2}\/\d{4}$/';
        $matches = (preg_match($expected, $article->postedAt())) ? true : false;
        $this->assertTrue($matches);
    }

    public function setUp() {
        parent::setUp();

        \Artisan::call('migrate');
        \Artisan::call('migrate', array(
            '--path' => './workbench/poc/news/src/migrations',
        ));
    }
}