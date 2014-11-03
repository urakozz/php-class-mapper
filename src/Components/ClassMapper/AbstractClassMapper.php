<?php
/**
 * @author ykmship@yandex-team.ru
 * Date: 15/10/14
 */

namespace Kozz\Components\ClassMapper;

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Cache\Cache;
use ReflectionClass;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Cache\ArrayCache;
use JMS\Serializer\Metadata\Driver\AnnotationDriver;
use JMS\Serializer\Metadata\ClassMetadata;

/**
 * Class AbstractClassMapper
 *
 * @pattern Decorator
 * @patternComponent AbstractComponent
 * @see https://en.wikipedia.org/wiki/Decorator_pattern
 *
 * @package Kozz\Components\ClassMapper
 */
abstract class AbstractClassMapper
{

  /**
   * @var
   */
  protected $object;

  /**
   * @var ReflectionClass
   */
  protected $reflection;

  /**
   * @var ClassMetadata
   */
  protected $metadata;

  /**
   * @var AnnotationDriver
   */
  protected $driver;

  /**
   * @var array
   */
  protected $properties = [];

  protected static $annotationReader;

  public function __construct($object, Reader $annotationReader = null)
  {
    $this->object = $object;
    $this->reflection = new \ReflectionClass($object);
    $this->setAnnotationReader($annotationReader);
    \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
  }

  protected function setAnnotationReader(Reader $annotationReader = null)
  {
    if(null === self::$annotationReader)
    {
      self::$annotationReader = $annotationReader;
    }
  }

  abstract public function setAttributes(array $attributes = []);

  /**
   * @return mixed
   */
  protected function getCurrentObject()
  {
    return $this->object;
  }

  /**
   * @return Reader
   */
  protected function getAnnotationReader()
  {
    if(null === self::$annotationReader)
    {
      self::$annotationReader = new CachedReader(new AnnotationReader(), new ArrayCache());
    }
    return self::$annotationReader;
  }

  /**
   * @return ReflectionClass
   */
  protected function getReflection()
  {
    if(!$this->reflection)
    {
      $this->reflection = new \ReflectionClass($this->object);
    }
    return $this->reflection;
  }

  /**
   * @return ClassMetadata
   */
  protected function getMetadata()
  {
    if(!$this->metadata)
    {
      $this->metadata = $this->getDriver()->loadMetadataForClass($this->getReflection());
    }
    return $this->metadata;
  }

  /**
   * @return AnnotationDriver
   */
  protected function getDriver()
  {
    if(!$this->driver)
    {
      $this->driver = new AnnotationDriver($this->getAnnotationReader());
    }
    return $this->driver;
  }


  /**
   * @return array
   */
  protected function getProperties()
  {
    if(!$this->properties)
    {
      $this->properties = array_keys($this->getMetadata()->propertyMetadata);
    }
    return $this->properties;
  }

} 