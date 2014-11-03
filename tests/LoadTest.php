<?php
/**
 * @author ykmship@yandex-team.ru
 * Date: 03/11/14
 */

namespace Kozz\Tests;


use PHPUnit_Framework_TestCase;

class LoadTest extends PHPUnit_Framework_TestCase
{
  public function testLoad()
  {
    $this->assertTrue(class_exists('Kozz\Components\ClassMapper\AbstractMapperDecorator'));
    $this->assertTrue(class_exists('Kozz\Components\ClassMapper\AbstractClassMapper'));
    $this->assertTrue(class_exists('Kozz\Components\ClassMapper\ClassMapper'));
    $this->assertTrue(class_exists('Kozz\Components\ClassMapper\Normalizer'));
  }
} 