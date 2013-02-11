<?php

class RouterTest extends PHPUnit_Framework_TestCase
{
  protected function setUp()
  {
    $this->router = new App\Router;
  }

  public function testRoutesTo()
  {
    $this->router->get('/some/path', 'PagesController#index');
    $this->assertTrue( $this->router->routesTo('/some/path') );

    $this->router->post('/some/path', 'PagesController#index');
    $this->assertTrue( $this->router->routesTo('/some/path', 'POST') );
  }

  public function testRoutesToWithNonExistentPath()
  {
    $this->assertFalse( $this->router->routesTo('/some/path') );
  }

  /**
   * @expectedException App\NoRouteException
   */
  public function testGetRouteWithNonExistentPath()
  {
    $this->router->getRoute('/some/path');
  }

  public function testRouteGetRoute()
  {
    $this->router->get('/some/path', 'PagesController#index');
    $route = $this->router->getRoute('/some/path');
    $this->assertTrue( $route instanceof App\Route );
  }

  public function testRouteGetRouteControllerAndAction()
  {
    $this->router->post('/some/path', 'PagesController#index');
    $route = $this->router->getRoute('/some/path', 'POST');
    $this->assertEquals( 'PagesController', $route->controller() );
    $this->assertEquals( 'index', $route->action() );
    $this->assertEquals( 'POST', $route->method() );
  }

  public function testMultipleRoutes()
  {
    $this->router->get('/', 'PagesController#index');
    $this->router->post('/whatever', 'AnotherController#whatever');

    $this->assertTrue( $this->router->routesTo('/') );
    $this->assertTrue( $this->router->routesTo('/whatever', 'POST') );
  }
}
