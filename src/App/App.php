<?php

namespace App;

class App
{
  protected $_root, $_env, $_url, $_format; # string
  protected $_router;     # Router
  protected $_controller; # Controller
  protected $_flash = array();

  public static function namespacesToSlashes($namespacedString)
  {
    $parts = preg_split('/\\\/', $namespacedString, -1, PREG_SPLIT_NO_EMPTY);
    return join('/', $parts);
  }

  public static function create($function)
  {
    $instance = new self;
    $function($instance);
    return $instance;
  }

  public function setRoot($path = '')
  {
    if ( empty($path) )
      throw new \InvalidArgumentException('$path must not be empty!');

    if ( !file_exists($path) )
      throw new \InvalidArgumentException('$path does not exist! (was: ' . $path);

    $this->_root = $path;
  }

  public function setDevelopment()
  {
    $this->_env = 'development';
    ini_set('display_errors', true);
    error_reporting(E_ALL | E_STRICT);
  }

  public function setTesting()
  {
    $this->_env = 'testing';
    ini_set('display_errors', true);
    error_reporting(E_ALL | E_STRICT);
  }

  public function setProduction()
  {
    $this->_env = 'production';
    ini_set('display_errors', false);
    error_reporting(null);
  }

  public function isDevelopment()
  {
    return $this->_env === 'development';
  }

  public function isProduction()
  {
    return $this->_env === 'production';
  }

  public function env()
  {
    return $this->_env;
  }

  public function root()
  {
    return $this->_root;
  }

  public function router()
  {
    return $this->_router;
  }

  public function setRouter(Router $router)
  {
    $this->_router = $router;
  }

  public function controller()
  {
    return $this->_controller;
  }

  public function setController(Controller $controller)
  {
    $this->_controller = $controller;
  }

  public function url()
  {
    return $this->_url;
  }

  public function setUrl($urlWithQueryString)
  {
    $urlWithFormat = preg_replace('/\?.*/', '', $urlWithQueryString);
    $parts = explode('.', $urlWithFormat);

    $this->_url = $parts[0];

    if ( !empty($parts[1]) )
      $this->setFormat($parts[1]);
  }

  public function format()
  {
    return $this->_format;
  }

  public function setFormat($format)
  {
    $this->_format = $format;
  }

  public function flash()
  {
    return $this->_flash;
  }

  public function addFlash($message)
  {
    $this->_flash[] = $message;
  }
}
