<?php

namespace App;

class Route
{
  protected $_path, $_method, $_controller, $_action;

  public function __construct($path, $string, $method)
  {
    $this->_path   = (string) $path;
    $this->_method = (string) $method;
    $this->parseControllerAndActionFrom($string);
  }

  public function path()
  {
    return $this->_path;
  }

  public function method()
  {
    return $this->_method;
  }

  public function controller()
  {
    return $this->_controller;
  }

  public function action()
  {
    return $this->_action;
  }

  protected function parseControllerAndActionFrom($string)
  {
    list($controller, $action) = explode('#', (string) $string);

    $this->_controller = $controller;
    $this->_action     = $action;
  }
}
