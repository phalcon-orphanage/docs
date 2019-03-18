---
layout: article
language: 'en'
version: '4.0'
upgrade: ''
category: 'collection'
---
### Has
To check whether an element exists or not in the collection, you can use the following:
- `isset()` on the property
- `__isset()`
- array based isset (`isset($coollection[$element])`)
- `offsetExists()`
- `has()`

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

echo isset($collection->year); // true
```

You can use `__isset(element)` but it is not advisable as it is much slower than the property syntax. The same applies to `offsetExists`

```php
echo $collection->__isset('year');        // true
echo isset($collection['year']);          // true
echo $collection->offsetExists('year');   // true
echo $collection->has('year', true);      // true
```

```php
public function has(string $element, bool $insensitive = true):  bool
```
Using `has()` offers an extra parameter. By default `$insensitive` is set to `true`, making searches in the collection case insensitive. Setting this value to `false` will make the search for the element case sensitive. 

```php
echo $collection->has('YEAR', true);      // true
echo $collection->has('YEAR', false);     // false
```
