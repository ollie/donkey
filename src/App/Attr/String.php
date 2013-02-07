<?php

namespace App\Attr;

class String extends Base
{
  public function write($value)
  {
    $this->_value = (string) $value;
  }

  public function read()
  {
    return $this->_value;
  }
}
