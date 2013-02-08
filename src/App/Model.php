<?php

namespace App;

abstract class Model
{
  protected $_attributes = array();
  protected $_isValid = true;

  abstract protected function defineAttributes();

  public function __construct($attributes = array())
  {
    $this->defineAttributes();
    $this->setAttributes($attributes);
  }

  protected function string($attribute)
  {
    $this->addAttribute($attribute, new Attr\String);
  }

  protected function addAttribute($attribute, $defaultValue)
  {
    $this->initAttribute($attribute, $defaultValue);
  }

  protected function initAttribute($attribute, Attr\Base $value)
  {
    $this->_attributes[ $attribute ] = $value;
  }

  protected function setAttribute($attribute, $value)
  {
    $this->_attributes[ $attribute ]->write($value);
  }

  public function __get($attribute)
  {
    if ( !$this->hasAttribute($attribute) )
      throw new ModelAttributeNotDefinedException("Attribute \"{$attribute}\" not defined.");

    return $this->_attributes[ $attribute ]->read();
  }

  public function setAttributes($attributes)
  {
    if ( empty($attributes) )
      $attributes = array();

    foreach ($attributes as $attribute => $value)
    {
      if ( !$this->hasAttribute($attribute) )
        throw new ModelAttributeNotDefinedException("Attribute \"{$attribute}\" not defined.");

      $this->setAttribute($attribute, $value);
    }
  }

  protected function hasAttribute($attribute)
  {
    return array_key_exists($attribute, $this->_attributes);
  }

  public function attributes()
  {
    $mappedAttributes = array();

    foreach ($this->_attributes as $attribute => $valueObject)
      $mappedAttributes[ $attribute ] = $valueObject->read();

    return $mappedAttributes;
  }

  public function validate()
  {
    return $this->_isValid;
  }

  public function isValid()
  {
    return $this->validate();
  }

  public function isInvalid()
  {
    return ! $this->validate();
  }

  public function error($attribute)
  {
    return $this->_attributes[ $attribute ]->error();
  }

  public function addError($attribute, $message)
  {
    $this->_attributes[ $attribute ]->addError($message);
    $this->_isValid = false;
  }
}
