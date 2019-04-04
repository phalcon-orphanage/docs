---
layout: default
language: 'tr-tr'
version: '4.0'
upgrade: ''
category: 'collection'
---
### Remove

To remove an element in the collection, you can use the following:

- unset the property
- `__unset()`
- array based unset 
- `offsetUnset()`
- `remove()`

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

unset($collection->year);
```

You can use `__unset($element)` but it is not advisable as it is much slower than the property syntax. The same applies to `offsetUnset`

```php
$collection->__unset('year');
unset($collection['year']);
$collection->offsetUnset('year');
$collection->remove('year'); 
```

```php
public function remove(string $element, bool $insensitive = true):  void
```

Using `remove()` offers an extra parameter. By default `$insensitive` is set to `true`, making searches in the collection case insensitive. Setting this value to `false` will make the search for the element case sensitive.

```php
$collection->remove('YEAR', true);
$collection->remove('YEAR', false);
```