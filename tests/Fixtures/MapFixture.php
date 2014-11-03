<?php
/**
 * @author ykmship@yandex-team.ru
 * Date: 03/11/14
 */

namespace Kozz\Tests\Fixtures;

use JMS\Serializer\Annotation\Type;

class MapFixture
{

  /**
   * @Type("integer")
   */
  public $client_id;

  /**
   * @Type("integer")
   */
  public $sender_id;

  /**
   * @Type("string")
   */
  public $order_requisite;

  /**
   * @Type("string")
   */
  public $order_warehouse;
} 