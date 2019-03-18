---
layout: article
language: 'en'
version: '4.0'
upgrade: ''
category: 'collection'
---
### Reusing
You can also reuse the component, by repopulating it. `Phalcon\Collection` exposes the `clear()` and `init()` methods, which will clear and repopulate the internal array respectively, 

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

echo $collection->count(); // 2

$data = [
    'year' => 1776,
];

$collection->clear();
$collection->init($data);

echo $collection->count(); // 1
```
