Class mapper
================

[![Build Status](https://travis-ci.org/urakozz/php-class-mapper.svg?branch=master)](https://travis-ci.org/urakozz/php-class-mapper)
[![Coverage Status](https://coveralls.io/repos/urakozz/php-class-mapper/badge.png)](https://coveralls.io/r/urakozz/php-class-mapper)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/urakozz/php-class-mapper/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/urakozz/php-class-mapper/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/kozz/class-mapper/v/stable.svg)](https://packagist.org/packages/kozz/class-mapper)
[![Latest Unstable Version](https://poser.pugx.org/kozz/class-mapper/v/unstable.svg)](https://packagist.org/packages/kozz/class-mapper)
[![License](http://img.shields.io/packagist/l/kozz/class-mapper.svg)](https://packagist.org/packages/kozz/class-mapper)


Mapping Class properties using components of JMS Serializer

### Usage

Create a Map class like this
```php

use JMS\Serializer\Annotation\Type;
class Map
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
```
### Using ClassMapper

Now let's map it

```php
use Kozz\Components\ClassMapper\ClassMapper;

$map = new Map();
$mapper = new ClassMapper($map);
$mapper->setAttributes([
  'client_id'=>1,
  'sender_id'=>2,
  'order_requisite'=>3,
  'order_warehouse'=>4,
]);

$map->order_id; // 1 (integer)
$map->sender_id; // 2 (integer)
$map->order_requisite; // 3 (integer)
$map->order_warehouse; // 4 (integer)
```

### Using ClassMapper and Normalizer

```Normalizer``` is decorator for ```ClassMapper```. It reads ```@Type``` annotations and performs type casting

```php
use Kozz\Components\ClassMapper\ClassMapper;
use Kozz\Components\ClassMapper\Normalizer;

$map = new Map();
$mapper = new Normalizer(new ClassMapper($map));
$mapper->setAttributes([
  'client_id'=>'1str',
  'sender_id'=>'2str',
  'order_requisite'=>'3str',
  'order_warehouse'=>'4str',
]);

$map->order_id; // 1 (integer)
$map->sender_id; // 2 (integer)
$map->order_requisite; // '3str' (string)
$map->order_warehouse; // '4str' (string)
```


