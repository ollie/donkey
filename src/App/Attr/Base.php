<?php

namespace App\Attr;

abstract class Base
{
  protected $_value;

  public function __construct($value = null)
  {
    $this->write($value);
  }

  abstract public function write($value);
  abstract public function read();
}
