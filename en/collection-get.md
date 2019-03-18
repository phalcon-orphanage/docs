---
layout: article
language: 'en'
version: '4.0'
upgrade: ''
category: 'collection'
---
### Get
As mentioned above, `Phalcon\Collection` implements several interfaces, in order to make the component as flexible as possible. Retrieving data stored in an element can be done by using:
- Property
- `__get()`
- array based get (`$collection[$element]`)
- `offsetGet()`
- `get()`

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
    'year'   => 1776,
];

$collection = new Collection($data);

echo $collection->year;                    // 1776
```

You can use `__get($element)` but it is not advisable as it is much slower than the property syntax. The same applies to `offsetGet`

```php
echo $collection->__get('year');           // 1776
echo $collection['year'];                  // 1776
echo $collection->offsetGet('year');       // 1776
echo $collection->get('year', 1776, true); // 1776
```

```php
public function get(string $element, mixed $defaultValue = null, bool $insensitive = true):  mixed
```
Using `get()` offers two extra parameters. When `$defaultValue` is defined in the call, if the element is not found, `$defaultValue` will be returned.  By default `$insensitive` is set to `true`, making searches in the collection case insensitive. Setting this value to `false` will make the search for the element case sensitive. 
