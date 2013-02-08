<?php

namespace App\Attr;

abstract class Base
{
  protected $_value;
  protected $_errors = array();

  public function __construct($value = null)
  {
    $this->write($value);
  }

  abstract public function write($value);
  abstract public function read();

  public function error()
  {
    return join(' ', $this->_errors);
  }

  public function addError($message)
  {
    $this->_errors[] = $message;
  }
}
