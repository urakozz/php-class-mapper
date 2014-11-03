<?php
/**
 * @author ykmship@yandex-team.ru
 * Date: 03/11/14
 */

namespace Kozz\Tests;


use Kozz\Components\ClassMapper\ClassMapper;
use Kozz\Components\ClassMapper\Normalizer;
use Kozz\Tests\Fixtures\MapFixture;
use PHPUnit_Framework_TestCase;

class MapTest extends PHPUnit_Framework_TestCase
{

  public function testMap()
  {
    $map = new MapFixture();
    $mapper = new ClassMapper($map);
    $mapper->setAttributes([
      'client_id'=>1,
      'sender_id'=>2,
      'order_requisite'=>3,
      'order_warehouse'=>4,
    ]);

    $this->assertEquals(1, $map->client_id);
    $this->assertInternalType('integer', $map->client_id);
    $this->assertEquals(2, $map->sender_id);
    $this->assertInternalType('integer', $map->sender_id);
    $this->assertEquals(3, $map->order_requisite);
    $this->assertInternalType('integer', $map->order_requisite);
    $this->assertEquals(4, $map->order_warehouse);
    $this->assertInternalType('integer', $map->order_warehouse);
  }

  public function testNormalizer()
  {
    $map = new MapFixture();
    $mapper = new Normalizer(new ClassMapper($map));
    $mapper->setAttributes([
      'client_id'=>1,
      'sender_id'=>2,
      'order_requisite'=>3,
      'order_warehouse'=>4,
    ]);

    $this->assertEquals(1, $map->client_id);
    $this->assertInternalType('integer', $map->client_id);
    $this->assertEquals(2, $map->sender_id);
    $this->assertInternalType('integer', $map->sender_id);
    $this->assertEquals('3', $map->order_requisite);
    $this->assertInternalType('string', $map->order_requisite);
    $this->assertEquals('4', $map->order_warehouse);
    $this->assertInternalType('string', $map->order_warehouse);
  }
}