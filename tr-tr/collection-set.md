---
layout: default
language: 'tr-tr'
version: '4.0'
upgrade: ''
category: 'collection'
---
### Set

To set an element in the collection, you can use the following:

- assign the value to the property
- `__set()`
- array based assignment 
- `offsetSet()`
- `set()`

The fastest way is by using the property syntax:

```php
<?php

use Phalcon\Collection;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
];

$collection = new Collection($data);

$collection->year = 1776;
```

You can use `__set($element, $value)` but it is not advisable as it is much slower than the property syntax. The same applies to `offsetSet`

```php
$collection->__set('year', 1776);
$collection['year'] = 1776;
$collection->offsetSet('year', 1776);
$collection->set('year', 1776); 
```