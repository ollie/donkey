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
  public function testModel()
  {
    $page = new Model(array(
      'title'    => 'Super Title',
      'contents' => "Hey\nHo",
    ));

    $this->assertEquals( 'Super Title', $page->title );
    $this->assertEquals( "Hey\nHo", $page->contents );
  }

  public function testSetAttributes()
  {
    $page = new Model;
    $page->setAttributes(array(
      'title'    => 'Super Title',
      'contents' => "Hey\nHo",
    ));

    $this->assertEquals( 'Super Title', $page->title );
    $this->assertEquals( "Hey\nHo", $page->contents );
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
}
