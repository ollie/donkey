<?php

namespace App;

class Mailer
{
  protected $_to, $_subject, $_message;
  protected $_isValid = true;

  public function to()
  {
    return $this->_to;
  }

  public function setTo($value)
  {
    $this->_to = filter_var($value, FILTER_VALIDATE_EMAIL);
    return $this;
  }

  public function from()
  {
    return $this->_from;
  }

  public function setFrom($value)
  {
    $this->_from = filter_var($value, FILTER_VALIDATE_EMAIL);
    return $this;
  }

  public function subject()
  {
    return $this->_subject;
  }

  public function setSubject($value)
  {
    $this->_subject = $value;
    return $this;
  }

  public function message()
  {
    return $this->_message;
  }

  public function setMessage($value)
  {
    $this->_message = $value;
    return $this;
  }

  public function headers()
  {
    $headers = array();

    if ( !empty($this->_to) )
      $headers[] = 'To: ' . $this->_to;

    if ( !empty($this->_from) )
      $headers[] = 'From: ' . $this->_from;

    $headers = join("\n", $headers);
    return $headers;
  }

  public function validate()
  {
    if ( empty($this->_to) )
      $this->_isValid = false;

    if ( empty($this->_from) )
      $this->_isValid = false;

    if ( empty($this->_subject) )
      $this->_isValid = false;

    if ( empty($this->_message) )
      $this->_isValid = false;

    return $this->_isValid;
  }

  public function isValid()
  {
    return $this->validate();
  }

  public function isInvalid()
  {
    return ! $this->isValid();
  }

  public function deliver()
  {
    if ( $this->isInvalid() )
      return false;

    return mail(
      $this->to(),
      $this->subject(),
      $this->message(),
      $this->headers()
    );
  }
}
