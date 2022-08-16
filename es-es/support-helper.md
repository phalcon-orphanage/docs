---
layout: default
language: 'es-es'
version: '5.0'
title: 'Ayudantes'
keywords: 'helper, text, factory'
---

# Ayudantes
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
[Phalcon\Support\HelperFactory][support-helper] offers support methods that manipulate arrays, files, JSON, numbers and strings. The factory replaces the `Phalcon\Text` component, offering the same functionality and more.

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();
 ```

The methods are available either by calling `newInstance()` on the factory object with the relevant name of the helper class, or calling the helper class directly as a method on the helper factory. The factory acts as a service locator, caching the objects to be reused if need be, in the same request.

## Available Classes

| Tipo    | Nombre          | Clase                                          |
| ------- | --------------- | ---------------------------------------------- |
| Vector  | `blacklist`     | `Phalcon\Support\Helper\Arr\Blacklist`     |
| Vector  | `chunk`         | `Phalcon\Support\Helper\Arr\Chunk`         |
| Vector  | `filter`        | `Phalcon\Support\Helper\Arr\Filter`        |
| Vector  | `first`         | `Phalcon\Support\Helper\Arr\First`         |
| Vector  | `firstKey`      | `Phalcon\Support\Helper\Arr\FirstKey`      |
| Vector  | `flatten`       | `Phalcon\Support\Helper\Arr\Flatten`       |
| Vector  | `get`           | `Phalcon\Support\Helper\Arr\Get`           |
| Vector  | `group`         | `Phalcon\Support\Helper\Arr\Group`         |
| Vector  | `has`           | `Phalcon\Support\Helper\Arr\Has`           |
| Vector  | `isUnique`      | `Phalcon\Support\Helper\Arr\IsUnique`      |
| Vector  | `last`          | `Phalcon\Support\Helper\Arr\Last`          |
| Vector  | `lastKey`       | `Phalcon\Support\Helper\Arr\LastKey`       |
| Vector  | `order`         | `Phalcon\Support\Helper\Arr\Order`         |
| Vector  | `pluck`         | `Phalcon\Support\Helper\Arr\Pluck`         |
| Vector  | `set`           | `Phalcon\Support\Helper\Arr\Set`           |
| Vector  | `sliceLeft`     | `Phalcon\Support\Helper\Arr\SliceLeft`     |
| Vector  | `sliceRight`    | `Phalcon\Support\Helper\Arr\SliceRight`    |
| Vector  | `split`         | `Phalcon\Support\Helper\Arr\Split`         |
| Vector  | `toObject`      | `Phalcon\Support\Helper\Arr\ToObject`      |
| Vector  | `validateAll`   | `Phalcon\Support\Helper\Arr\ValidateAll`   |
| Vector  | `validateAny`   | `Phalcon\Support\Helper\Arr\ValidateAny`   |
| Vector  | `whitelist`     | `Phalcon\Support\Helper\Arr\Whitelist`     |
| Archivo | `basename`      | `Phalcon\Support\Helper\File\Basename`     |
| JSON    | `decode`        | `Phalcon\Support\Helper\Json\Decode`       |
| JSON    | `encode`        | `Phalcon\Support\Helper\Json\Encode`       |
| Number  | `isBetween`     | `Phalcon\Support\Helper\Number\IsBetween`  |
| Cadena  | `camelize`      | `Phalcon\Support\Helper\Str\Camelize`      |
| Cadena  | `concat`        | `Phalcon\Support\Helper\Str\Concat`        |
| Cadena  | `countVowels`   | `Phalcon\Support\Helper\Str\CountVowels`   |
| Cadena  | `decapitalize`  | `Phalcon\Support\Helper\Str\Decapitalize`  |
| Cadena  | `decrement`     | `Phalcon\Support\Helper\Str\Decrement`     |
| Cadena  | `dirFromFile`   | `Phalcon\Support\Helper\Str\DirFromFile`   |
| Cadena  | `dirSeparator`  | `Phalcon\Support\Helper\Str\DirSeparator`  |
| Cadena  | `dynamic`       | `Phalcon\Support\Helper\Str\Dynamic`       |
| Cadena  | `endsWith`      | `Phalcon\Support\Helper\Str\EndsWith`      |
| Cadena  | `firstBetween`  | `Phalcon\Support\Helper\Str\FirstBetween`  |
| Cadena  | `friendly`      | `Phalcon\Support\Helper\Str\Friendly`      |
| Cadena  | `humanize`      | `Phalcon\Support\Helper\Str\Humanize`      |
| Cadena  | `include`       | `Phalcon\Support\Helper\Str\Includes`      |
| Cadena  | `increment`     | `Phalcon\Support\Helper\Str\Increment`     |
| Cadena  | `interpolate`   | `Phalcon\Support\Helper\Str\Interpolate`   |
| Cadena  | `isAnagram`     | `Phalcon\Support\Helper\Str\IsAnagram`     |
| Cadena  | `isLower`       | `Phalcon\Support\Helper\Str\IsLower`       |
| Cadena  | `isPalindrome`  | `Phalcon\Support\Helper\Str\IsPalindrome`  |
| Cadena  | `isUpper`       | `Phalcon\Support\Helper\Str\IsUpper`       |
| Cadena  | `kebabCase`     | `Phalcon\Support\Helper\Str\KebabCase`     |
| Cadena  | `len`           | `Phalcon\Support\Helper\Str\Len`           |
| Cadena  | `lower`         | `Phalcon\Support\Helper\Str\Lower`         |
| Cadena  | `pascalCase`    | `Phalcon\Support\Helper\Str\PascalCase`    |
| Cadena  | `prefix`        | `Phalcon\Support\Helper\Str\Prefix`        |
| Cadena  | `random`        | `Phalcon\Support\Helper\Str\Random`        |
| Cadena  | `reduceSlashes` | `Phalcon\Support\Helper\Str\ReduceSlashes` |
| Cadena  | `snakeCase`     | `Phalcon\Support\Helper\Str\SnakeCase`     |
| Cadena  | `startsWith`    | `Phalcon\Support\Helper\Str\StartsWith`    |
| Cadena  | `suffix`        | `Phalcon\Support\Helper\Str\Suffix`        |
| Cadena  | `ucwords`       | `Phalcon\Support\Helper\Str\Ucwords`       |
| Cadena  | `uncamelize`    | `Phalcon\Support\Helper\Str\Uncamelize`    |
| Cadena  | `underscore`    | `Phalcon\Support\Helper\Str\Underscore`    |
| Cadena  | `upper`         | `Phalcon\Support\Helper\Str\Upper`         |

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$upper = $helper->newInstance('upper');
```

## Métodos
The methods can be called directly from the helper factory.

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'abcde';
$result = $helper->upper($source);

echo $result; // ABCDE
```

### `blacklist(array $collection, array $blackList): array`
Excludes elements of an array by the keys obtained from the elements of a blacklist

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'value-1',
    'key-2'   => 'value-2',
    'key-3'   => 'value-3',
    9         => 'value-4',
    12        => 'value-5',
    ' key-6 ' => 'value-6',
    99        => 'value-7',
    'key-8'   => 'value-8',
];

$blackList = [
    99,
    48,
    31,
    9,
    'key-45',
    null,
    -228,
    new stdClass(),
    [],
    3.501,
    false,
    'key-2',
    'key-3',
];

$result = $helper->blacklist($source, $blackList);

var_dump($result);
// [
//     'value-1',
//     12        => 'value-5',
//     ' key-6 ' => 'value-6',
//     'key-8'   => 'value-8',
// ]
```

### `chunk(array $collection, int $size, bool $preserveKeys = false): array`
Chunks an array into smaller arrays of a specified size

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'k1' => 1,
    'k2' => 2,
    'k3' => 3,
    'k4' => 4,
    'k5' => 5,
    'k6' => 6,
];

$result = $helper->chunk($source, 2, true);

var_dump($result);
// [
//     ['k1' => 1, 'k2' => 2],
//     ['k3' => 3, 'k4' => 4],
//     ['k5' => 5, 'k6' => 6],
// ]
```

### `filter(array $collection, mixed $method = null): mixed`
Filters a collection using array_filter and using the callable (if defined)

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    1  => 1,
    2  => 2,
    3  => 3,
    4  => 4,
    5  => 5,
    6  => 6,
    7  => 7,
    8  => 8,
    9  => 9,
    10 => 10,
];

$result = $helper->filter(
    $source,
    function ($element) {
        return $element & 1;
    }
);

var_dump($result);
// [
//     1 => 1,
//     3 => 3,
//     5 => 5,
//     7 => 7,
//     9 => 9,
// ]
```

### `first(array $collection, callable $method = null): mixed`
Devuelve el primer elemento de la colección. If a `callable` is passed, the element returned is the first that validates `true`

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
    'two' => 'Framework',
];

$result = $helper->first($source);

echo $result; // 'Phalcon'
```

### `firstKey(array $collection, callable $method = null): mixed`
Devuelve la clave del primer elemento de la colección. If a `callable` is passed, the element returned is the first that validates `true`

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
    'two' => 'Framework',
];

$result = $helper->firstKey($source);

echo $result; // 'one'
```

### `flatten(array $collection, bool $deep = false): array`
Flattens an array up to the one level depth, unless `$deep` is set to `true

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [1, [2], [[3], 4], 5];

$result = $helper->flatten($source);

var_dump($result);
// [1, 2, [3], 4, 5]
```

### `get(array $collection, mixed $index, mixed $defaultValue = null, string $cast = null): mixed`
Gets an array element by key and if it does not exist returns the default. It also allows for casting the returned value to a specific type using `settype` internally

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
    'two' => '1',
];

echo $helper->get($source, 1);               // 'Phalcon'
echo $helper->get($source, 3, 'Unknown');    // 'Unknown'
echo $helper->get($source, 2, null, 'int');  // 1
```

### `group(array $collection, mixed $method): array`
Agrupa los elementos de un vector según el invocable pasado

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    [
        'name' => 'Paul',
        'age'  => 34,
    ],
    [
        'name' => 'Peter',
        'age'  => 31,
    ],
    [
        'name' => 'John',
        'age'  => 29,
    ],
];

$result = $helper->group($source, 'age');

// [
//     34 => [
//         [
//             'name' => 'Paul',
//             'age'  => 34,
//         ],
//     ],
//     31 => [
//         [
//             'name' => 'Peter',
//             'age'  => 31,
//         ],
//     ],
//     29 => [
//         [
//             'name' => 'John',
//             'age'  => 29,
//         ],
//     ],
// ]
```

### `has(array $collection, mixed $index): bool`
Checks an array if it has an element with a specific key and returns `true`/`false` accordingly

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    1     => 'Phalcon',
    'two' => 'Framework',
];

echo $helper->has($source, 1);         // true
echo $helper->get($source, 'two');     // true
echo $helper->get($source, 'unknown'); // false
```

### `isUnique(array $collection): bool`
Checks an array for duplicate values. Returns `true` if all values are unique, `false` otherwise.

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'Phalcon',
    'Framework',
];

echo $helper->isUnique($source); // true

$source = [
    'Phalcon',
    'Framework',
    'Phalcon',
];

echo $helper->isUnique($source); // false
```

### `last(array $collection, callable $method = null): mixed`
Devuelve el último elemento de la colección. If a `callable` is passed, the element returned is the first that validates `true`

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
    'two' => 'Framework',
];

$result = $helper->last($source);

echo $result; // 'Framework'
```

### `lastKey(array $collection, callable $method = null): mixed`
Devuelve la clave del primer elemento de la colección. If a `callable` is passed, the element returned is the first that validates `true`

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
    'two' => 'Framework',
];

$result = $helper->lastKey($source);

echo $result; // 'two'
```

### `order(array $collection, mixed $attribute, string $order = 'asc'): array`
Sorts a collection of arrays or objects by an attribute of the object. It supports ascending/descending sorts but also flags that are identical to the ones used by `ksort` and `krsort`

```php
<?php

use Phalcon\Support\Helper\Arr\Order;
use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    [
        'id'   => 2,
        'name' => 'Paul',
    ],
    [
        'id'   => 3,
        'name' => 'Peter',
    ],
    [
        'id'   => 1,
        'name' => 'John',
    ],
];

$result = $helper->order($source, 'id');

var_dump($result);
// [
//     [
//         'id'   => 1,
//         'name' => 'John',
//     ],
//     [
//         'id'   => 2,
//         'name' => 'Paul',
//     ],
//     [
//         'id'   => 3,
//         'name' => 'Peter',
//     ],
// ]

$result = $helper->order($source, 'id', Order::ORDER_DESC);

var_dump($result);
// [
//     [
//         'id'   => 3,
//         'name' => 'Peter',
//     ],
//     [
//         'id'   => 2,
//         'name' => 'Paul',
//     ],
//     [
//         'id'   => 1,
//         'name' => 'John',
//     ],
// ]

$source = [
    (object) [
        'id'   => 2,
        'name' => 'Paul',
    ],
    (object) [
        'id'   => 3,
        'name' => 'Peter',
    ],
    (object) [
        'id'   => 1,
        'name' => 'John',
    ],
];

$result = $helper->order($source, 'id');

var_dump($result);
// [
//     (object) [
//         'id'   => 1,
//         'name' => 'John',
//     ],
//     (object) [
//         'id'   => 2,
//         'name' => 'Paul',
//     ],
//     (object) [
//         'id'   => 3,
//         'name' => 'Peter',
//     ],
// ]
```

### `pluck(array $collection, string $element): array`
Returns a subset of the collection based on the collection values

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    ['product_id' => 'prod-100', 'name' => 'Desk'],
    ['product_id' => 'prod-200', 'name' => 'Chair'],
];

$result = $helper->pluck($source, 'name');

var_dump($result);
// [
//     'Desk',
//     'Chair',
// ]

$source = [
    (object) ['product_id' => 'prod-100', 'name' => 'Desk'],
    (object) ['product_id' => 'prod-200', 'name' => 'Chair'],
];

$result = $helper->pluck($source, 'name');

var_dump($result);
// [
//     'Desk',
//     'Chair',
// ]
```

### `set(array $collection, mixed $value, mixed $index = null): array`
Sets an array element with an optional key

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

### `sliceLeft(array $collection, int $elements = 1): array`
Returns a new array with `n` elements removed from the left.

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'Phalcon',
    'Framework',
    'for',
    'PHP',
];

$result = $helper->sliceLeft($source);

var_dump($result);
// [
//     'Phalcon',
// ]

$result = $helper->sliceLeft($source, 3);

var_dump($result);
// [
//     'Phalcon',
//     'Framework',
//     'for',
// ]
```

### `sliceRight(array $collection, int $elements = 1): array`
Returns a new array with `n` elements removed from the right.

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'Phalcon',
    'Framework',
    'for',
    'PHP',
];

$result = $helper->sliceRight($source);

var_dump($result);
// [
//     'PHP',
// ]

$result = $helper->sliceRight($source, 3);

var_dump($result);
// [
//     'Framework',
//     'for',
//     'PHP',
// ]
```

### `split(array $collection): array`
Returns a new array with keys of the collection as one element and values as another

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    1 => 'Phalcon',
    3 => 'Framework',
];

$result = $helper->split($source);

var_dump($result);
// [
//     [1, 3],
//     ['Phalcon', 'Framework'],
// ];
```

### `toObject(array $collection): object`
Devuelve el vector pasado como un objeto

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one'   => 'two',
    'three' => 'four',
];

$result = $helper->toObject($source);

var_dump($result);
// class stdClass#1 (2) {
//   public $one =>
//   string(3) "two"
//   public $three =>
//   string(4) "four"
// }
```

### `validateAll(array $collection, callable $method): bool`
Returns `true` if the provided function returns `true` for all elements of the collection, `false` otherwise.

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [2, 3, 4, 5];

$result = $helper->validateAll(
    $source,
    function ($element) {
        return $element > 1;
    }
);

echo $result; // true        
```

### `validateAny(array $collection, callable $method): bool`
Returns `true` if the provided function returns `true` for at least one  element of the collection, `false` otherwise.

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [1, 2, 3, 4, 5];

$result = $helper->validateAny(
    $collection,
    function ($element) {
        return $element < 2;
    }
);

echo $result; // true
```

### `whitelist(array $collection, array $whiteList): array`
Includes elements of an array by the keys obtained from the elements of a whitelist

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source  = [
    'value-1',
    ' key '  => 'value-2',
    5        => 'value-3',
    6        => 'value-4',
    7        => 'value-5',
    ' key-2' => 'value-6',
    'key-3 ' => 'value-7',
    'key-4'  => 'value-8',
];

$whiteList = [
    7,
    5,
    0,
    'key-3 ',
    null,
    -13,
    new stdClass(),
    [],
    3.1415,
];

$result = $helper->whitelist($source, $blackList);

var_dump($result);
// [
//     0        => 'value-1',
//     5        => 'value-3',
//     7        => 'value-5',
//     'key-3 ' => 'value-7',
// ];
```

### `basename(string $uri, string $suffix = null): string`
Gets the filename from a given path, Same as PHP's `basename()` but has non-ASCII support. PHP's `basename()` does not properly support streams or filenames beginning with a non-US-ASCII character.

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = '/etc/sudoers.d';

$result = $helper->basename($source);

echo $result; // .d

$source = '/root/ελληνικά.txt';

$result = $helper->basename($source);

echo $result; // 'ελληνικά.txt'
```

### `decode(

    string $data, 
    bool $associative = false, 
    int $depth = 512, 
    int $options = 0
): string`
Decodes a string using`json_decode` and throws an exception if the JSON data cannot be decoded

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = '{"one":"two","0":"three"}';

$result = $helper->decode($source);

var_dump($result);
// [
//     'one' => 'two',
//     'three',
// ];
```

### `encode($data, int $options = 0, int $depth = 512): string`
Codifica una cadena usando `json_encode` y lanza una excepción si los datos JSON no se han podido codificar

The following options are used if none specified for `json_encode`

- JSON_HEX_TAG
- JSON_HEX_APOS
- JSON_HEX_AMP
- JSON_HEX_QUOT
- JSON_UNESCAPED_SLASHES
- JSON_THROW_ON_ERROR

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'two',
    'three',
];

$result = $helper->encode($source);

echo $result; // '{"one":"two","0":"three"}'
```

### `isBetween(int $value, int $start, int $end): bool`
Checks if a number is within a range

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$result = $helper->isBetween(5, 1, 10);

echo $result; // true
```

### `camelize(string $text, string $delimiters = null, bool $lowerFirst = false): string`
Convert strings to upperCamelCase or lowerCamelCase

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'came-li-ze';

$result = $helper->camelize($source);

echo $result; // CameLiZe
```

### `concat(string $delimiter, string $first, string $second, string ...$arguments): string`
Concatenate strings using the separator, only once, without duplication

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$result = $helper->concat(
    '.',
    '@test.',
    '.test2.',
    '.test',
    '.34'
);

$result = $helper->concat($source);

echo $result; // '@test.test2.test.34'
```

### `countVowels(string $text): int`
Devuelve el número de vocales de la cadena indicada. Uses a regular expression to count the number of vowels (A, E, I, O, U) in a string

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

### `decapitalize(

    string $text, 
    bool $upperRest = false, 
    string $encoding = 'UTF-8'
): string` Decapitalizes the first letter of the string and then adds it with rest of the string. Omit the upperRest parameter to keep the rest of the string intact, or set it to true to convert to uppercase.

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

### `decrement(string $text, string $separator = '_'): string`
Removes a number from the end of a string or decrements that number if it is already defined

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

### `dirFromFile(string $file): string`
Acepta un nombre de fichero (sin extension) y devuelve una estructura de directorio calculada con el nombre del fichero al final

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

### `dirSeparator(string $directory): string`
Acepta un nombre de directorio y se asegura que termina con `DIRECTORY_SEPARATOR`

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

### `dynamic(

    string $text, 
    string $leftDelimiter = "{", 
    string $rightDelimiter = "}", 
    string $separator = "|"
): string` Generates random text in accordance with the template. The template is defined by the left and right delimiter and it can contain values separated by the separator


### `endsWith(string $haystack, string $needle, bool $ignoreCase = true): bool`
Returns `true` if a string ends with a given string, `false` otherwise

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

### `firstBetween(string $text, string $start, string $end): string`
Devuelve la primera cadena que hay entre las cadenas de los parámetros `start` y `end`.

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

### `friendly(

    string $text, 
    string $separator = '-', 
    bool $lowercase = true, 
    mixed $replace = null
): string`
Changes a text to a URL friendly one. Replaces commonly known accented characters with their Latin equivalents. If a`replace` string or array is passed, it will also be used to replace those characters with a space.

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

`humanize(string $text): string` Changes a text with underscores or dashes to human-readable

`includes(string $haystack, string $needle): bool` Determines whether a string includes another string or not

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

`increment(string $text, string $separator = '_'): string` Adds a number to the end of a string or increments that number if it is already defined

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

`interpolate(
    string $message, 
    array $context = [], 
    string $leftToken = "%", 
    string $rightToken = "%"
): string` Interpolates context values into the message placeholders. By default, the right and left tokens are `%`

`isAnagram(string $first, string $second): bool` Compares two strings and returns `true` if both strings are anagram, `false` otherwise

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

`isLower(string $text, string $encoding = 'UTF-8'): bool` Returns `true` if the given string is in lower case, `false` otherwise

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

`isPalindrome(string $text): bool` Returns `true` if the given string is a palindrome, `false` otherwise

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

`isUpper(string $text, string $encoding = 'UTF-8'): bool` Returns `true` if the given string is in upper case, `false` otherwise

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

`kebabCase(string $text, string $delimiters = null): string` Converts strings to kebab-case style

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

`len(string $text, string $encoding = 'UTF-8'): int` Calculates the length of the string using `mb_strlen`

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

`lower(string $text, string $encoding = 'UTF-8'): string` Converts a string to lowercase using `mbstring`

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

`pascalCase(string $text, string $delimiters = null): string` Converts strings to PascalCase style

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

`prefix($text, string $prefix): string` Prefixes the text with the supplied prefix

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

`random(int $type = 0, int $length = 8): string` Generates a random string based on the given type. Type is one of:

| Constante         | Descripción                                                                                      |
| ----------------- | ------------------------------------------------------------------------------------------------ |
| `RANDOM_ALNUM`    | Only alphanumeric characters [a-zA-Z0-9]                                                         |
| `RANDOM_ALPHA`    | Only alphabetical characters [azAZ]                                                              |
| `RANDOM_DISTINCT` | Only alphanumeric uppercase characters exclude similar characters [2345679ACDEFHJKLMNPRSTUVWXYZ] |
| `RANDOM_HEXDEC`   | Only hexadecimal characters [0-9a-f]                                                             |
| `RANDOM_NOZERO`   | Only numbers without 0 [1-9]                                                                     |
| `RANDOM_NUMERIC`  | Only numbers [0-9]                                                                               |

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

`reduceSlashes(string $text): string` Reduces multiple slashes in a string to single slashes

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

`snakeCase(string $text, string $delimiters = null): string` Converts strings to snake_case style

`startsWith(string $haystack, string $needle, bool $ignoreCase = true): bool` Returns `true` if a string starts with a given string, `false` otherwise

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

`suffix($text, string $suffix): string` Suffixes the text with the supplied suffix

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

`ucwords(string $text, string $encoding = 'UTF-8'): string` Capitalizes the first letter of each word

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

`uncamelize(string $text, string $delimiters = '_'): string` Converts strings to non camelized style

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

`underscore(string $text): string` Converts spaces in the passed text to underscores

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```

`upper(string $text, string $encoding = 'UTF-8'): string` Converts a string to uppercase using mbstring

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = [
    'one' => 'Phalcon',
];

$result = $helper->set($source, 'Framework');

var_dump($result);
// [
//     'one' => 'Phalcon',
//     1     => 'Framework',
// ]

$result = $helper->set($source, 'abcde', 'suffix');

var_dump($result);
// [
//     'one'    => 'Phalcon',
//     1        => 'Framework',
//     'suffix' => 'abcde',
// ]
```





[support-helper]: api/phalcon_support#support-helperfactory
