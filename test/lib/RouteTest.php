<?php

class RouteTest extends PHPUnit_Framework_TestCase
{
  public function testRoute()
  {
    $route = new App\Route('/some/path', 'PagesController#index', 'GET');

    $this->assertEquals( '/some/path', $route->path() );
    $this->assertEquals( 'PagesController', $route->controller() );
    $this->assertEquals( 'index', $route->action() );
    $this->assertEquals( 'GET', $route->method() );
  }

  public function testRoutePath()
  {
    $route = new App\Route('/some/path', 'PagesController#index', 'GET');
    $this->assertEquals( '/some/path', $route->path() );
  }

  public function testRouteController()
  {
    $route = new App\Route('/some/path', 'PagesController#index', 'GET');
    $this->assertEquals( 'PagesController', $route->controller() );
  }

  public function testRouteControllerAction()
  {
    $route = new App\Route('/some/path', 'PagesController#index', 'GET');
    $this->assertEquals( 'index', $route->action() );
  }

  public function testRouteControllerMethod()
  {
    $route = new App\Route('/some/path', 'PagesController#index', 'POST');
    $this->assertEquals( 'POST', $route->method() );
  }
}
