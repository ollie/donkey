<?php

class Model extends App\Model
{
  protected function defineAttributes()
  {
    $this->string('title');
    $this->string('contents');
  }
}

class ModelTest extends PHPUnit_Framework_TestCase
{
  protected function setUp()
  {
    $this->page = new Model(array(
      'title'    => 'Super Title',
      'contents' => "Hey\nHo",
    ));
  }

  public function testModel()
  {
    $this->assertEquals( 'Super Title', $this->page->title );
    $this->assertEquals( "Hey\nHo", $this->page->contents );
  }

  public function testSetAttributes()
  {
    $this->assertEquals( 'Super Title', $this->page->title );
    $this->assertEquals( "Hey\nHo", $this->page->contents );
  }

  /**
   * @expectedException App\ModelAttributeNotDefinedException
   */
  public function testSetUnknownAttributes()
  {
    $page = new Model;
    $page->setAttributes(array(
      'title'   => 'Super Title',
      'hacking' => 'Hehe',
    ));
  }

  /**
   * @expectedException App\ModelAttributeNotDefinedException
   */
  public function testUnknownAttribute()
  {
    $page = new Model;
    $page->hacking;
  }

  public function testAttributes()
  {
    $attributes = array(
      'title'    => 'Super Title',
      'contents' => "Hey\nHo",
    );

    $page = new Model;
    $page->setAttributes($attributes);

    $this->assertEquals( $attributes, $page->attributes() );
  }

  public function testIsValid()
  {
    $this->assertTrue( $this->page->isValid() );
  }

  public function testIsInvalid()
  {
    $this->assertFalse( $this->page->isInvalid() );
  }
}
