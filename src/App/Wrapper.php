<?php

namespace App;

class Wrapper
{
  private static $_instance;

  public static function instance()
  {
    return self::$_instance;
  }

  public static function setInstance(App $app)
  {
    self::$_instance = $app;
  }

  public static function setInstanceThroughFunction($function)
  {
    self::$_instance = $function();
  }
}
