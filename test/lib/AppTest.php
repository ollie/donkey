<?php

class AppTest extends PHPUnit_Framework_TestCase
{
  protected function showErrors()
  {
    ini_set('display_errors', true);
    error_reporting(E_ALL | E_STRICT);
  }

  protected function setUp()
  {
    $this->showErrors();
    $this->app = new App\App;
  }

  public function testNew()
  {
    $app = new App\App;
    $this->assertTrue( $app instanceof App\App );
  }

  public function testCreate()
  {
    $app = App\App::create(function($app) {
      return $app;
    });

    $this->assertTrue( $app instanceof App\App );
  }

  /**
   * @expectedException InvalidArgumentException
   */
  public function testRootWithNull()
  {
    $this->app->setRoot();
  }

  /**
   * @expectedException InvalidArgumentException
   */
  public function testRootWithEmptyString()
  {
    $this->app->setRoot('');
  }

  /**
   * @expectedException InvalidArgumentException
   */
  public function testRootWithInvalidPath()
  {
    $this->app->setRoot('../sdada');
  }

  public function testRoot()
  {
    $appRoot = realpath( dirname(__FILE__) . '/..');
    $this->app->setRoot($appRoot);
    $this->assertEquals( $appRoot, $this->app->root() );
  }

  public function testSetRouter()
  {
    $router = new App\Router;
    $this->app->setRouter($router);
    $this->assertTrue( $this->app->router() instanceof App\Router );
  }

  public function testSetController()
  {
    $controller = new App\Controller;
    $this->app->setController($controller);
    $this->assertTrue( $this->app->controller() instanceof App\Controller );
  }

  public function testSetUrl()
  {
    $this->app->setUrl('/asd?key1=value1&key2=value2&key3=value3');
    $this->assertEquals( '/asd', $this->app->url() );
    $this->assertEquals( '', $this->app->format() );
  }

  public function testSetUrlWithFormat()
  {
    $this->app->setUrl('/some-action.js?key1=value1&key2=value2&key3=value3');
    $this->assertEquals( '/some-action', $this->app->url() );
    $this->assertEquals( 'js', $this->app->format() );
  }

  public function testNamespacesToSlashes1()
  {
    $this->assertEquals( 'App/Controller', App\App::namespacesToSlashes('App\\Controller') );
  }

  public function testNamespacesToSlashes2()
  {
    $this->assertEquals( 'App/Controller', App\App::namespacesToSlashes('\\App\\Controller') );
  }

  public function testNamespacesToSlashes3()
  {
    $this->assertEquals( 'Some/Very/Long/Class', App\App::namespacesToSlashes('\\Some\\Very\\Long\\Class') );
  }

  public function testSetDevelopment()
  {
    $this->app->setDevelopment();
    $this->assertEquals( 'development', $this->app->env() );
    $this->assertEquals( '1', ini_get('display_errors') );
    $this->assertEquals( E_ALL | E_STRICT , error_reporting() );
  }

  public function testSetTesting()
  {
    $this->app->setTesting();
    $this->assertEquals( 'testing', $this->app->env() );
    $this->assertEquals( '1', ini_get('display_errors') );
    $this->assertEquals( E_ALL | E_STRICT , error_reporting() );
  }

  public function testSetProduction()
  {
    $this->app->setProduction();
    $this->assertEquals( 'production', $this->app->env() );
    $this->assertEquals( '', ini_get('display_errors') );
    $this->assertEquals( null , error_reporting() );
    $this->showErrors();
  }

  public function testIsDevelopment()
  {
    $this->app->setDevelopment();
    $this->assertTrue( $this->app->isDevelopment() );
  }

  public function testIsProduction()
  {
    $this->app->setProduction();
    $this->assertTrue( $this->app->isProduction() );
    $this->showErrors();
  }
}
