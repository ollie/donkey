<?php

namespace App;

class Router
{
  const GET  = 'GET';
  const POST = 'POST';

  protected $_routes  = array(
    self::GET  => array(),
    self::POST => array(),
  );

  public function get($path, $string)
  {
    $this->route($path, $string, self::GET);
  }

  public function post($path, $string)
  {
    $this->route($path, $string, self::POST);
  }

  public function route($path, $string, $method = self::GET)
  {
    $this->_routes[$method][$path] = new Route($path, $string, $method);
  }

  public function getRoute($path, $method = self::GET)
  {
    if ( $this->routesTo($path, $method) )
      return $this->_routes[$method][$path];
  }

  public function routesTo($path, $method = self::GET)
  {
    return isset( $this->_routes[$method][$path] );
  }
}
