<?php

namespace App;

class Controller
{
  protected $_view;   # View
  protected $_layout; # string

  public function callBeforeActions()
  {

  }

  public function action($action = '')
  {
    if ( empty($action) )
      $action = 'index';

    $this->callBeforeActions();
    $this->{$action}();

    if ( !$this->view() )
      $this->initView($action);
  }

  public function render($action)
  {
    $this->initView($action);
  }

  protected function initView($action)
  {
    $path = $this->nameToPath() . '/' . $action;
    $view = new View($path);

    if ( !empty($this->_layout) )
      $view->setLayout($this->_layout);

    $this->setView($view);
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

  public function view()
  {
    return $this->_view;
  }

  public function setView(View $view)
  {
    $this->_view = $view;
  }

  public function setLayout($layout)
  {
    $this->_layout = $layout;
  }
}
