<?php

namespace App;

class View
{
  const HTML_FORMAT    = 'html';
  const JS_FORMAT      = 'js';
  const TXT_FORMAT     = 'txt';
  const DEFAULT_FORMAT = 'html';

  protected $_format;                 # 'html' | 'js' | 'xml' ...
  protected $_incompletePath;         # 'pages/index' ...
  protected $_rootPath;               # 'app/views'
  protected $_viewPath;               # 'app/views/pages/index.html.php' ...
  protected $_layout = 'application'; # 'application' | 'whatever_string' | null
  protected $_layoutPath;             # 'app/views/layouts/application.html.php' ...

  public static function formats()
  {
    return array(
      self::HTML_FORMAT,
      self::JS_FORMAT,
      self::TXT_FORMAT,
    );
  }

  public function hasIncompletePath()
  {
    return (bool) $this->_incompletePath;
  }

  public function setIncompletePath($path)
  {
    $this->_incompletePath = $path;
  }

  public function render($format = null)
  {
    $this->_format = $format;

    $this->initFormat();
    $this->initViewPath();
    $this->initLayoutPath();

    if ( $this->hasLayout() )
      return $this->loadLayout();
    else
      return $this->loadView();
  }

  protected function initFormat()
  {
    if ( empty($this->_format) )
      $this->_format = self::DEFAULT_FORMAT;

    if ( !in_array( $this->_format, self::formats() ) )
    {
      throw new \InvalidArgumentException('Format must be one of the following: '
        . join(', ', self::formats()) . " (was: $this->_format)");
    }
  }

  protected function initViewPath()
  {
    $this->_viewPath = "{$this->_rootPath}/{$this->_incompletePath}.{$this->_format}.php";

    if ( !is_file($this->_viewPath) )
      throw new ViewNotFoundException("View {$this->_viewPath} seems to be missing");
  }

  protected function initLayoutPath()
  {
    if ( empty($this->_layout) )
      return;

    $this->_layoutPath = "{$this->_rootPath}/layouts/{$this->_layout}.{$this->_format}.php";
  }

  protected function hasLayout()
  {
    return !empty($this->_layoutPath) && is_file($this->_layoutPath);
  }

  public function loadView()
  {
    return $this->read($this->_viewPath);
  }

  public function loadLayout()
  {
    return $this->read($this->_layoutPath);
  }

  public function partial($incompletePath)
  {
    $path = $this->getPartialPath($incompletePath);

    if ( !is_file($path) )
      throw new ViewNotFoundException("View {$path} seems to be missing");

    return $this->read($path);
  }

  public function getPartialPath($incompletePath)
  {
    $incompletePath = self::underscoreLastItem($incompletePath);
    $path = $this->_rootPath;

    // Starts with /, so it's absolute path.
    if ( preg_match('@^/@', $incompletePath) )
      $path .= $incompletePath;
    else
    {
      $currentViewDirectory = explode('/', $this->_incompletePath);
      $currentViewDirectory = $currentViewDirectory[0];
      $path .= "/{$currentViewDirectory}/{$incompletePath}";
    }

    $path .= ".{$this->_format}.php";

    return $path;
  }

  public static function underscoreLastItem($path)
  {
    $parts = explode('/', $path);
    $last = array_pop($parts);
    array_push($parts, "_{$last}");

    return join('/', $parts);
  }

  protected function read($path)
  {
    ob_start();
    include $path;
    $contents = ob_get_contents();
    ob_end_clean();

    return $contents;
  }

  public function rootPath()
  {
    return $this->_rootPath;
  }

  public function setRootPath($rootPath)
  {
    if ( !file_exists($rootPath) )
      throw new \InvalidArgumentException("Root path {$rootPath} does not exist!");

    $this->_rootPath = $rootPath;
  }

  public function path()
  {
    return $this->_viewPath;
  }

  public function setLayout($layout)
  {
    $this->_layout = $layout;
  }
}
