<?php

namespace App;

abstract class Model
{
  protected $_attributes = array();

  abstract protected function defineAttributes();

  public function __construct($attributes = array())
  {
    $this->defineAttributes();
    $this->setAttributes($attributes);
  }

  protected function addAttribute($attribute, $defaultValue)
  {
    if ( !$this->hasAttribute($attribute) )
      $this->setAttribute($attribute, $defaultValue);
  }

  protected function hasAttribute($attribute)
  {
    return array_key_exists($attribute, $this->_attributes);
  }

  public function __get($attribute)
  {
    if ( !$this->hasAttribute($attribute) )
      throw new ModelAttributeNotDefinedException("Attribute \"{$attribute}\" not defined.");

    return $this->_attributes[ $attribute ];
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

  protected function setAttribute($attribute, $value)
  {
    $this->_attributes[ $attribute ] = $value;
  }

  public function attributes()
  {
    return $this->_attributes;
  }

  protected function string($attribute)
  {
    $this->addAttribute($attribute, '');
  }
}
