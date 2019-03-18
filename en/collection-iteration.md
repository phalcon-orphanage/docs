---
layout: article
language: 'en'
version: '4.0'
upgrade: ''
category: 'collection'
---
### Iteration
Since the collection object implements `\IteratorAggregate`, you can iterate through the object with ease. The method `getIterator()` returns an `ArrayIterator()` object

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

foreach ($collection as $key => $value) {
    echo $key . ' - ' . $value . PHP_EOL;
}
```
