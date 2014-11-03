<?php
/**
 * @author ykmship@yandex-team.ru
 * Date: 15/10/14
 */

namespace Kozz\Components\ClassMapper;

/**
 * Class AbstractBuilderDecorator
 *
 * @pattern Decorator
 * @patternComponent AbstractDecorator
 * @see https://en.wikipedia.org/wiki/Decorator_pattern
 *
 * @package Kozz\Components\ClassMapper
 */
abstract class AbstractMapperDecorator extends AbstractClassMapper
{
  /**
   * @var AbstractClassMapper
   */
  protected $component;

  /**
   * @param AbstractClassMapper $component
   */
  public function __construct(AbstractClassMapper $component)
  {
    $this->component = $component;
    parent::__construct($component->getCurrentObject());
  }
} 