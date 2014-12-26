<?php

use Poc\News\Tests\TestCase;
use League\FactoryMuffin\Facade as FactoryMuffin;

class ArticleTest extends TestCase {

    public function testCreateNewArticle()
    {
        $article = FactoryMuffin::create('Poc\News\Article');
        $this->assertInstanceOf('Poc\News\Article', $article);
    }

    public function testTitleIsRequired()
    {
        $article = FactoryMuffin::instance('Poc\News\Article', array('title' => ''));
        $this->assertFalse($article->save());

        $errors = $article->errors()->all();

        $this->assertCount(1, $errors);
        $this->assertEquals($errors[0], "The title field is required.");
    }

    public function testPostedAt()
    {
        $article = FactoryMuffin::create('Poc\News\Article');

        $expected = '/^\d{2}\/\d{2}\/\d{4}$/';
        $matches = ( preg_match($expected, $article->postedAt()) ) ? true : false;
        $this->assertTrue( $matches );
    }
}