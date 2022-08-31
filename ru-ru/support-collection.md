---
layout: default
language: 'ru-ru'
version: '5.0'
title: 'Collection'
upgrade: '#support-collection'
keywords: 'collection, arrayaccess, countable, iteratoraggregate, jsonserializeable, serializable'
---

# Collection
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Введение
`Phalcon\Support\Collection` is an object-oriented array. It offers speed, as well as implementations of various PHP interfaces. These are:

- [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)
- [Countable](https://php.net/manual/en/class.countable.php)
- [IteratorAggregate](https://php.net/manual/en/class.iteratoraggregate.php)
- [JsonSerializable](https://php.net/manual/en/class.jsonserializable.php)
- [Serializable](https://php.net/manual/en/class.serializable.php)

```php
<?php

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
    'year'   => 1987,
];

$collection = new Collection($data);
```

## Constructor
You can construct the object as any other object in PHP. However, the constructor accepts an optional `array` parameter, which will populate the object for you.

```php
<?php

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
    'year'   => 1987,
];

$collection = new Collection($data);
```

## Case sensitivity
When instantiating the object you can specify a second `bool` parameter, which will control the key searching in the object. By default `$insensitive` is set to `true`, making searches in the collection case-insensitive. Setting this value to `false` will make the search for the element in a case-sensitive manner.

```php
<?php

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
    'year'   => 1987,
];

$collection = new Collection($data, false);

echo $collection->has('COLORS'); // false
```

## Reusing
You can also reuse the component, by repopulating it. `Phalcon\Support\Collection` exposes the `clear()` and `init()` methods, which will clear and repopulate the internal array respectively,

```php
<?php

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
    'year'   => 1987,
];

$collection = new Collection($data);

echo $collection->count(); // 2

$data = [
    'year' => 1987,
];

$collection->clear();
$collection->init($data);

echo $collection->count(); // 1
```

## Get
As mentioned above, `Phalcon\Support\Collection` implements several interfaces, in order to make the component as flexible as possible. Retrieving data stored in an element can be done by using:
- Property
- `__get()`
- array based get (`$collection[$element]`)
- `offsetGet()`
- `get()`

The fastest way is by using the property syntax:

```php
<?php

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
    'year'   => 1987,
];

$collection = new Collection($data);

echo $collection->year;                    // 1987
```

You can use `__get($element)` but it is not advisable as it is much slower than the property syntax. The same applies to `offsetGet`

```php
echo $collection->__get('year');           // 1987
echo $collection['year'];                  // 1987
echo $collection->offsetGet('year');       // 1987
echo $collection->get('year', 1987, true); // 1987
```

```php
public function get(
    string $element, 
    mixed $defaultValue = null, 
    string $cast = null
):  mixed
```

Using `get()` offers three parameters. `$key` is the key of the element we want to retrieve

If `$defaultValue` is set, it will be returned if the `$key` is not set or the `$key` is set and its value is `null`

The `cast` parameter accepts a string that defines what the returned value will be cast. The available values are:

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

The collection object also offers two more getters `getKeys` and `getValues` `getKeys( bool $insensitive = true )` returns all the keys stored internally in the collection. By default, it will return the keys case-insensitive manner i.e. all lowercase. If `false` is passed in the call, it will return the keys exactly as they have been stored. `getValues` returns the values stored in the internal collection.

## Has
To check whether an element exists or not in the collection, you can use the following:
- `isset()` on the property
- `__isset()`
- array based isset (`isset($coollection[$element])`)
- `offsetExists()`
- `has()`

The fastest way is by using the property syntax:

```php
<?php

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
    'year'   => 1987,
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

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
];

$collection = new Collection($data);

$collection->year = 1987;
```

You can use `__set($element, $value)` but it is not advisable as it is much slower than the property syntax. The same applies to `offsetSet`

```php
$collection->__set('year', 1987);
$collection['year'] = 1987;
$collection->offsetSet('year', 1987);
$collection->set('year', 1987); 
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

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
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
public function remove(string $element):  void
```

## Iteration
Since the collection object implements `\IteratorAggregate`, you can iterate through the object with ease. The method `getIterator()` returns an `ArrayIterator()` object

```php
<?php

use Phalcon\Support\Collection;

$data = [
   'red',
   'green',
   'blue'
];

$collection = new Collection($data);

foreach ($collection as $key => $value) {
    echo $key . ' - ' . $value . PHP_EOL;
}
```

## Count
The implementation of the `\Countable` interface exposes the `count()` method, which stores the number of elements in the collection.

```php
<?php

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
    'year'   => 1987,
];

$collection = new Collection($data);

echo $collection->count();    // 2
```

## Serialization
The `\Serializable` and `\JsonSerializable` interfaces expose methods that allow you to serialize and unserialize the object. `serialize()` and `unserialize()` use PHP's `serialize` and `unserialize` functions. `jsonSerialize()` returns an array which can be used with `json_encode` to serialize the object.

```php
<?php

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
    'year'   => 1987,
];

$collection = new Collection($data);

echo $collection->serialize();    
// a:2:{s:6:"colors";a:3:{i:0;s:3:"red";
//  i:1;s:5:"green";i:2;s:4:"blue";}s:4:"year";i:1987;}

$serialized = 'a:2:{s:6:"colors";a:3:{i:0;s:3:"red";'
    . 'i:1;s:5:"green";i:2;s:4:"blue";}s:4:"year";i:1987;}';
$collection->unserialize($serialized);

echo $collection->jsonSerialize(); // $data
```

## Transformations
`Phalcon\Support\Collection` also exposes two transformation methods: `toArray()` and `toJson(int $options)`. `toArray()` returns the object transformed as an array. This method returns the same array as `jsonSerialize()`.


```php
<?php

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
    'year'   => 1987,
];

$collection = new Collection($data);

echo $collection->toArray();  // $data
```

`toJson(int $options)` returns a JSON representation of the object. It uses `json_encode` internally and accepts a parameter, which represents the flags that `json_encode` accepts. By default, the options are set up with the value 79, ([RFC4327](https://www.ietf.org/rfc/rfc4627.txt)) which translates to:

- `JSON_HEX_TAG`
- `JSON_HEX_APOS`
- `JSON_HEX_AMP`
- `JSON_HEX_QUOT`
- `JSON_UNESCAPED_SLASHES`

You can pass any valid flags to the method according to your needs.

```php
<?php

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
    'year'   => 1987,
];

$collection = new Collection($data);

echo $collection->toJson();    // ["red","green","blue"],"year":1987}

echo $collection->toJson(74 + JSON_PRETTY_PRINT);
/**
{
    "colors": [
        "red",
        "green",
        "blue"
    ],
    "year": 1987
}
*/
```

## Read Only Collection
Phalcon also offers a component that can be used in a read-only fashion. `Phalcon\Support\Collection\ReadOnlyCollection` can serve as a collection in your application that can only be populated with initial data but not allowing its contents to be changed throughout the application.

> This class has been renamed from `ReadOnly` in order to avoid collisions with PHP 8.x reserved words. 
> 
> {: .alert .alert-info }

```php
<?php

use Phalcon\Support\Collection\ReadOnlyCollection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
    'year'   => 1987,
];

$collection = new ReadOnly($data);

echo $collection->toJson();    // ["red","green","blue"],"year":1987}

$collection->set('colors', ['red']); // Exception
```

## Custom Objects
Phalcon allows developers to define their Collection objects. These objects must implement the [Phalcon\Support\Collection\CollectionInterface][support-collection-collectioninterface]:

```php
<?php

namespace MyApp;

use Phalcon\Support\Collection\CollectionInterface

class MyCollection implements CollectionInterface
{
    public function __get(string $element): mixed;

    public function __isset(string $element): bool;

    public function __set(string $element, mixed $value): void;

    public function __unset(string $element): void;

    public function clear(): void;

    public function get(
        string $element, 
        mixed $defaultValue = null, 
        string $cast = null
    ): mixed;

    public function getKeys(bool $insensitive = true): array;

    public function getValues(): array;

    public function has(string $element): bool;

    public function init(array $data = []): void;

    public function remove(string $element): void;

    public function set(string $element, var $value): void;

    public function toArray(): array;

    public function toJson(int $options = 79): string;
}

```


[support-collection-collectioninterface]: api/phalcon_support#support-collection-collectioninterface
