<?php

namespace App;

class Controller
{
  protected $_view; # View

  public function __construct()
  {
    $this->_view = new View;
  }

  protected function callBeforeActions()
  {

  }

  public function action($action = '')
  {
    if ( empty($action) )
      $action = 'index';

    $this->callBeforeActions();
    $this->{$action}();

    if ( !$this->_view->hasIncompletePath() )
      $this->setViewPath($action);
  }

  public function render($action)
  {
    $this->setViewPath($action);
  }

  protected function setViewPath($action)
  {
    $this->_view->setIncompletePath( $this->nameToPath() . '/' . $action );
  }

  public function name()
  {
    return get_class($this);
  }

  public function nameToPath()
  {
    $name = str_replace('Controller', '', $this->name());
    return self::underscore($name);
  }

  public static function underscore($camelCaseString = '')
  {
    $words = preg_split('/(?=[A-Z])/', $camelCaseString, -1, PREG_SPLIT_NO_EMPTY);
    $underscoredWords = array_map(function($word) { return strtolower($word); }, $words);
    $underscoredString = join('_', $underscoredWords);
    return $underscoredString;
  }

  public function params()
  {
    return $this->_params;
  }

  public function setParams($params = array())
  {
    $this->_params = $params;
  }

  public function view()
  {
    return $this->_view;
  }

  public function setLayout($layout)
  {
    $this->_view->setLayout($layout);
  }
}
