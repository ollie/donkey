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

  public function testAddError()
  {
    $attr = new App\Attr\String('O hai!');
    $this->assertEquals( '', $attr->error() );
    $attr->addError('Is required.');
    $attr->addError('Is not valid value.');
    $this->assertEquals( 'Is required. Is not valid value.', $attr->error() );
  }
}
