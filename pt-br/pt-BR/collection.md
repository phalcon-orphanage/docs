---
layout: default
language: 'pt-br'
version: '4.0'
upgrade: ''
category: 'collection'
---
# Collection Component

* * *

- [Constructor](collection-constructor)
- [Reusing](collection-reusing)
- [Get](collection-get)
- [Has](collection-has)
- [Set](collection-set)
- [Remove](collection-remove)
- [Iteration](collection-iteration)
- [Count](collection-count)
- [Serialization](collection-serialization)
- [Transformations](collection-transformations)

* * *

## Overview

`Phalcon\Collection` is an object oriented array. It offers speed, as well as implementations of various PHP interfaces. These are:

- [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)
- [Countable](https://php.net/manual/en/class.countable.php)
- [IteratorAggregate](https://php.net/manual/en/class.iteratoraggregate.php)
- [JsonSerializable](https://php.net/manual/en/class.jsonserializable.php)
- [Serializable](https://php.net/manual/en/class.serializable.php)

```php
<?php

use Phalcon\Collection;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Collection($data);
```