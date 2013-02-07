<?php

class AttrStringTest extends PHPUnit_Framework_TestCase
{
  public function testNew()
  {
    $attr = new App\Attr\String('O hai!');
    $this->assertEquals( 'O hai!', $attr->read() );
  }

  public function testReadAndWrite()
  {
    $attr = new App\Attr\String;
    $attr->write('O hai!');
    $this->assertEquals( 'O hai!', $attr->read() );
  }
}
