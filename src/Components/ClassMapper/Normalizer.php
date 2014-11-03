<?php
/**
 * @author ykmship@yandex-team.ru
 * Date: 15/10/14
 */

namespace Kozz\Components\ClassMapper;


use JMS\Serializer\Construction\UnserializeObjectConstructor;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\EventDispatcher\EventDispatcher;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\HandlerRegistry;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\Metadata\PropertyMetadata;
use JMS\Serializer\Naming\CamelCaseNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use Metadata\MetadataFactory;

/**
 * Class Normalizer
 *
 * @pattern Decorator
 * @component ConcreteDecorator
 * @see https://en.wikipedia.org/wiki/Decorator_pattern
 *
 * @package Kozz\Components\ClassMapper
 */
class Normalizer extends AbstractMapperDecorator
{

  /**
   * @var JsonDeserializationVisitor
   */
  protected $visitor;

  /**
   * @var DeserializationContext
   */
  protected $context;

  /**
   * @var GraphNavigator
   */
  protected $navigator;

  /**
   * @var MetadataFactory
   */
  protected $metadataFactory;


  /**
   * @param array $attributes
   */
  public function setAttributes(array $attributes = [])
  {
    $this->component->setAttributes($attributes);

    foreach($this->filterAttributes($attributes) as $name => $value)
    {
      /** @var PropertyMetadata $propertyMetadata */
      $propertyMetadata = $this->getMetadata()->propertyMetadata[$name];
      $this->normalizeProperty($propertyMetadata, $attributes);
    }
  }


  /**
   * @param array $attributes
   *
   * @return array
   */
  protected function filterAttributes(array $attributes)
  {
    return array_intersect_key($attributes, $this->getFilteredPropertyMetadata());
  }

  /**
   * @return array
   */
  protected function getFilteredPropertyMetadata()
  {
    return array_filter($this->getMetadata()->propertyMetadata, function(PropertyMetadata $metadata){
        return null !== $metadata->type;
      });
  }

  /**
   * @param PropertyMetadata $propertyMetadata
   * @param                  $attributes
   */
  protected function normalizeProperty(PropertyMetadata $propertyMetadata, $attributes)
  {
    $this->getVisitor()->visitProperty($propertyMetadata, $attributes, $this->getContext());
  }

  /**
   * @return JsonDeserializationVisitor
   */
  protected function getVisitor()
  {
    if(!$this->visitor)
    {
      $namingStrategy = new SerializedNameAnnotationStrategy(new CamelCaseNamingStrategy());
      $visitor   = new JsonDeserializationVisitor($namingStrategy);

      $visitor->setNavigator($this->getNavigator());
      $visitor->setCurrentObject($this->getCurrentObject());
      $this->visitor = $visitor;
    }
    return $this->visitor;
  }

  /**
   * @return GraphNavigator
   */
  protected function getNavigator()
  {
    if(!$this->navigator)
    {
      $this->navigator = new GraphNavigator(
        $this->getMetadataFactory(),
        new HandlerRegistry(),
        new UnserializeObjectConstructor(),
        new EventDispatcher()
      );
    }
    return $this->navigator;
  }

  /**
   * @return MetadataFactory
   */
  protected function getMetadataFactory()
  {
    if(!$this->metadataFactory)
    {
      $this->metadataFactory = new MetadataFactory($this->getDriver());
    }
    return $this->metadataFactory;
  }


  /**
   * @return DeserializationContext
   */
  protected function getContext()
  {
    if(!$this->context)
    {
      $context = new DeserializationContext();
      $context->initialize(
        'json',
        $this->getVisitor(),
        $this->getNavigator(),
        $this->getMetadataFactory()
      );
      $this->context = $context;
    }
    return $this->context;
  }
}