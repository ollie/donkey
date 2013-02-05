<?php

set_include_path(implode(PATH_SEPARATOR, array(
  realpath( dirname(__FILE__) . '/../src/App' ),
  get_include_path(),
)));

define('ROOT_VIEWS', 'views');

require_once 'App.php';
require_once 'Wrapper.php';
require_once 'Router.php';
require_once 'Route.php';
require_once 'Controller.php';
require_once 'View.php';
require_once 'Exceptions.php';
