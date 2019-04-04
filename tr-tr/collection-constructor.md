---
layout: default
language: 'tr-tr'
version: '4.0'
upgrade: ''
category: 'collection'
---
### Constructor

You can construct the object as any other object in PHP. However, the constructor accepts an optional `array` parameter, which will populate the object for you.

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