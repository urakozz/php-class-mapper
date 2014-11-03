<?php
/**
 * @author ykmship@yandex-team.ru
 * Date: 15/10/14
 */

namespace Kozz\Components\ClassMapper;


use JMS\Serializer\Metadata\PropertyMetadata;

/**
 * Class ClassMapper
 *
 * @pattern Decorator
 * @patternComponent ConcreteComponent
 * @see https://en.wikipedia.org/wiki/Decorator_pattern
 *
 * @package Kozz\Components\ClassMapper
 */
class ClassMapper extends AbstractClassMapper
{

  /**
   * @var
   */
  protected $object;

  /**
   * @var \ReflectionClass
   */
  protected $reflection;

  protected $driver;

  /**
   * @var \JMS\Serializer\Metadata\ClassMetadata
   */
  protected $metadata;

  protected $properties = [];


  public function setAttributes(array $attributes = [])
  {
    foreach($this->filterAttributes($attributes) as $name => $value)
    {
      /** @var PropertyMetadata $propertyMetadata */
      $propertyMetadata = $this->getMetadata()->propertyMetadata[$name];
      $propertyMetadata->reflection->setValue($this->object, $value);
    }
  }

  public function getObject()
  {
    return $this->object;
  }


  protected function filterAttributes(array $attributes)
  {
    return array_intersect_key($attributes, array_flip($this->getProperties()));
  }
} 