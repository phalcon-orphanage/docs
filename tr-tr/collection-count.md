---
layout: default
language: 'tr-tr'
version: '4.0'
upgrade: ''
category: 'collection'
---
### Count

The implementation of the `\Countable` interface exposes the `count()` method, which stores the number of elements in the collection.

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

echo $collection->count();    // 2
```