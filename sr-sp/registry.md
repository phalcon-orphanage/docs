---
layout: default
language: 'sr-sp'
version: '4.0'
title: 'Registry'
keywords: 'registry'
---

# Registry Component

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

[Phalcon\Registry](api/phalcon_registry#registry) is an object oriented array. It extends [Phalcon\Collection](collection) but cannot be extended itself since all of its methods are declared `final`. It offers speed, as well as implementations of various PHP interfaces. These are:

- [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)
- [Countable](https://php.net/manual/en/class.countable.php)
- [IteratorAggregate](https://php.net/manual/en/class.iteratoraggregate.php)
- [JsonSerializable](https://php.net/manual/en/class.jsonserializable.php)
- [Serializable](https://php.net/manual/en/class.serializable.php)

```php
<?php

use Phalcon\Registry;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Registry($data);
```

## Constructor

You can construct the object as any other object in PHP. However, the constructor accepts an optional `array` parameter, which will populate the object for you.

```php
<?php

use Phalcon\Registry;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Registry($data);
```

## Reusing

You can also reuse the component, by repopulating it. [Phalcon\Registry](api/phalcon_registry#registry) exposes the `clear()` and `init()` methods, which will clear and repopulate the internal array respectively,

```php
<?php

use Phalcon\Registry;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Registry($data);

echo $collection->count(); // 2

$data = [
    'year' => 1776,
];

$collection->clear();

$collection->init($data);

echo $collection->count(); // 1
```

## Get

As mentioned above, [Phalcon\Registry](api/phalcon_registry#registry) implements several interfaces, in order to make the component as flexible as possible. Retrieving data stored in an element can be done by using:

- Property
- `__get()`
- array based get (`$collection[$element]`)
- `offsetGet()`
- `get()`

The fastest way is by using the property syntax:

```php
<?php

use Phalcon\Registry;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Registry($data);

echo $collection->year; // 1776
```

You can use `__get($element)` but it is not advisable as it is much slower than the property syntax. The same applies to `offsetGet`

```php
echo $collection->__get('year');           // 1776
echo $collection['year'];                  // 1776
echo $collection->offsetGet('year');       // 1776
echo $collection->get('year', 1776, true); // 1776
```

```php
public function get(
    string $element, 
    mixed $defaultValue = null, 
    string $cast = null
):  mixed
```

Using `get()` offers three extra parameters. When `$defaultValue` is defined in the call and the element is not found, `$defaultValue` will be returned. The `cast` parameter accepts a string that defines what the returned value will be casted. The available values are:

- `array`
- `bool`
- `boolean`
- `double`
- `float`
- `int`
- `integer`
- `null`
- `object`
- `string`

## Has

To check whether an element exists or not in the collection, you can use the following:

- `isset()` on the property
- `__isset()`
- array based isset (`isset($collection[$element])`)
- `offsetExists()`
- `has()`

The fastest way is by using the property syntax:

```php
<?php

use Phalcon\Registry;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Registry($data);

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
public function has(string $element):  bool
```

## Set

To set an element in the collection, you can use the following:

- assign the value to the property
- `__set()`
- array based assignment 
- `offsetSet()`
- `set()`

The fastest way is by using the property syntax:

```php
<?php

use Phalcon\Registry;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
];

$collection = new Registry($data);

$collection->year = 1776;
```

You can use `__set($element, $value)` but it is not advisable as it is much slower than the property syntax. The same applies to `offsetSet`

```php
$collection->__set('year', 1776);
$collection['year'] = 1776;
$collection->offsetSet('year', 1776);
$collection->set('year', 1776); 
```

## Remove

To remove an element in the collection, you can use the following:

- unset the property
- `__unset()`
- array based unset 
- `offsetUnset()`
- `remove()`

The fastest way is by using the property syntax:

```php
<?php

use Phalcon\Registry;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
];

$collection = new Registry($data);

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
public function remove(string $element):  void
```

## Iteration

Since the collection object implements `\IteratorAggregate`, you can iterate through the object with ease. The method `getIterator()` returns an `ArrayIterator()` object

```php
<?php

use Phalcon\Registry;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Registry($data);

foreach ($collection as $key => $value) {
    echo $key . ' - ' . $value . PHP_EOL;
}
```

## Count

The implementation of the `\Countable` interface exposes the `count()` method, which stores the number of elements in the collection.

```php
<?php

use Phalcon\Registry;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Registry($data);

echo $collection->count(); // 2
```

## Serialization

The `\Serializable` and `\JsonSerializable` interfaces expose methods that allow you to serialize and unserialize the object. `serialize()` and `unserialize()` use PHP's `serialize` and `unserialize` functions. `jsonSerialize()` returns an array which can be used with `json_encode` to serialize the object.

```php
<?php

use Phalcon\Registry;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Registry($data);

echo $collection->serialize();    // a:2:{s:6:"colors";a:3:{i:0;s:3:"red";i:1;s:5:"white";i:2;s:4:"blue";}s:4:"year";i:1776;}

$serialized = 'a:2:{s:6:"colors";a:3:{i:0;s:3:"red";i:1;s:5:"white";i:2;s:4:"blue";}s:4:"year";i:1776;}';
$collection->unserialize($serialized);

echo $collection->jsonSerialize(); // $data
```

## Transformations

[Phalcon\Registry](api/phalcon_registry#registry) also exposes two transformation methods: `toArray()` and `toJson(int $options)`. `toArray()` returns the object transformed as an array. This method returns the same array as `jsonSerialize()`.

```php
<?php

use Phalcon\Registry;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Registry($data);

echo $collection->toArray(); // $data
```

`toJson(int $options)` returns a JSON representation of the object. It uses `json_encode` internally and accepts a parameter, which represents the flags that `json_encode` accepts. By default the options are set up with the value 74, ([RFC4327](https://www.ietf.org/rfc/rfc4627.txt)) which translates to:

- `JSON_HEX_TAG`
- `JSON_HEX_APOS`
- `JSON_HEX_AMP`
- `JSON_HEX_QUOT`
- `JSON_UNESCAPED_SLASHES`

You can pass any valid flags to the method according to your needs.

```php
<?php

use Phalcon\Registry;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Registry($data);

echo $collection->toJson(); // ["red","white","blue"],"year":1776}

echo $collection->toJson(74 + JSON_PRETTY_PRINT);
/**
{
    "colors": [
        "red",
        "white",
        "blue"
    ],
    "year": 1776
}
*/
```