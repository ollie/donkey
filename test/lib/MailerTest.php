<?php

class MailerTest extends PHPUnit_Framework_TestCase
{
  protected function setUp()
  {
    $this->mailer = new App\Mailer;
  }

  public function testTo()
  {
    $this->mailer->setTo('john@example.com');
    $this->assertEquals( 'john@example.com', $this->mailer->to() );
  }

  public function testToReturnValue()
  {
    $this->assertEquals( $this->mailer, $this->mailer->setTo('john@example.com') );
  }

  public function testInvalidTo()
  {
    $this->mailer->setTo('brekeke');
    $this->assertFalse( $this->mailer->to() );
  }

  public function testFrom()
  {
    $this->mailer->setFrom('doe@example.com');
    $this->assertEquals( 'doe@example.com', $this->mailer->from() );
  }

  public function testFromReturnValue()
  {
    $this->assertEquals( $this->mailer, $this->mailer->setFrom('doe@example.com') );
  }

  public function testInvalidFrom()
  {
    $this->mailer->setFrom('brekeke');
    $this->assertFalse( $this->mailer->from() );
  }

  public function testSubject()
  {
    $this->mailer->setSubject('Yo!');
    $this->assertEquals( 'Yo!', $this->mailer->subject() );
  }

  public function testSubjectReturnValue()
  {
    $this->assertEquals( $this->mailer, $this->mailer->setSubject('Yo!') );
  }

  public function testMessage()
  {
    $this->mailer->setMessage('Move yo ass!');
    $this->assertEquals( 'Move yo ass!', $this->mailer->message() );
  }

  public function testMessageReturnValue()
  {
    $this->assertEquals( $this->mailer, $this->mailer->setMessage('Move yo ass!') );
  }

  public function testHeadersTo()
  {
    $this->mailer->setTo('john@example.com');
    $this->assertEquals( "To: john@example.com\r\nBcc: john@example.com", $this->mailer->headers() );
  }

  public function testHeadersFrom()
  {
    $this->mailer->setFrom('doe@example.com');
    $this->assertEquals( "From: doe@example.com", $this->mailer->headers() );
  }

  public function testHeadersToFrom()
  {
    $this->mailer->setTo('john@example.com');
    $this->mailer->setFrom('doe@example.com');
    $this->assertEquals( "To: john@example.com\r\nFrom: doe@example.com\r\nBcc: john@example.com", $this->mailer->headers() );
  }

  public function testValid()
  {
    $this->mailer
      ->setTo('john@example.com')
      ->setFrom('doe@example.com')
      ->setSubject('Yo!')
      ->setMessage('Wash up!')
    ;
    $this->assertTrue( $this->mailer->isValid() );
  }

  public function testInvalid1()
  {
    $this->mailer->setTo('john@example.com');
    $this->assertTrue( $this->mailer->isInvalid() );
  }

  public function testInvalid2()
  {
    $this->mailer->setTo('joh n@e xa mple.com');
    $this->assertTrue( $this->mailer->isInvalid() );
  }

  public function testInvalid3()
  {
    $this->mailer->setFrom('doe@example.com');
    $this->assertTrue( $this->mailer->isInvalid() );
  }

  public function testInvalid4()
  {
    $this->mailer->setSubject('Yo!');
    $this->assertTrue( $this->mailer->isInvalid() );
  }

  public function testInvalid5()
  {
    $this->mailer->setMessage('Wash up!');
    $this->assertTrue( $this->mailer->isInvalid() );
  }

  public function testMailWithValidData()
  {
    $mailer = $this->getMock('App\Mailer', array('deliver'));

    $mailer->expects( $this->any() )
           ->method('deliver')
           ->will( $this->returnValue(true) );

    $mailer
      ->setTo('john@example.com')
      ->setFrom('doe@example.com')
      ->setSubject('Yo, wash up!')
      ->setMessage("You\nshould\ntry\nshower\nsometimes.")
    ;

    $this->assertTrue( $mailer->isValid() );
    $this->assertTrue( $mailer->deliver() );
  }

  public function testMailWithInvalidData()
  {
    $mailer = $this->getMock('App\Mailer', array('deliver'));

    $mailer->expects( $this->any() )
           ->method('deliver')
           ->will( $this->returnValue(false) );

    $mailer
      ->setTo('joh n @exa mple.com')
      ->setFrom('do e@examp le.com')
      ->setSubject('Yo, wash up!')
      ->setMessage("You\nshould\ntry\nshower\nsometimes.")
    ;

    $this->assertFalse( $mailer->isValid() );
    $this->assertFalse( $mailer->deliver() );
  }
}
