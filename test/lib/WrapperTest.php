<?php

class WrapperTest extends PHPUnit_Framework_TestCase
{
  protected function setUp()
  {
    $this->app = new App\App;
  }

  public function testSetInstance()
  {
    $app = new App\App;
    App\Wrapper::setInstance($app);
    $this->assertTrue( App\Wrapper::instance() instanceof App\App );
    $this->assertEquals( $app, App\Wrapper::instance() );
  }

  public function testSetInstanceThroughFunction()
  {
    App\Wrapper::setInstanceThroughFunction(function() {
      return new App\App;
    });
    $this->assertTrue( App\Wrapper::instance() instanceof App\App );
  }
}
