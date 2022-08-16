---
layout: default
language: 'fr-fr'
version: '5.0'
title: 'Helper'
keywords: 'helper, text, factory'
---

# Helper
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Vue d'ensemble
[Phalcon\Support\HelperFactory][support-helper] offers support methods that manipulate arrays, files, JSON, numbers and strings. The factory replaces the `Phalcon\Text` component, offering the same functionality and more.

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();
 ```

The methods are available either by calling `newInstance()` on the factory object with the relevant name of the helper class, or calling the helper class directly as a method on the helper factory. The factory acts as a service locator, caching the objects to be reused if need be, in the same request.

## Available Classes

| Type   | Name            | Class                                          |
| ------ | --------------- | ---------------------------------------------- |
| Array  | `blacklist`     | `Phalcon\Support\Helper\Arr\Blacklist`     |
| Array  | `chunk`         | `Phalcon\Support\Helper\Arr\Chunk`         |
| Array  | `filter`        | `Phalcon\Support\Helper\Arr\Filter`        |
| Array  | `first`         | `Phalcon\Support\Helper\Arr\First`         |
| Array  | `firstKey`      | `Phalcon\Support\Helper\Arr\FirstKey`      |
| Array  | `flatten`       | `Phalcon\Support\Helper\Arr\Flatten`       |
| Array  | `get`           | `Phalcon\Support\Helper\Arr\Get`           |
| Array  | `group`         | `Phalcon\Support\Helper\Arr\Group`         |
| Array  | `has`           | `Phalcon\Support\Helper\Arr\Has`           |
| Array  | `isUnique`      | `Phalcon\Support\Helper\Arr\IsUnique`      |
| Array  | `last`          | `Phalcon\Support\Helper\Arr\Last`          |
| Array  | `lastKey`       | `Phalcon\Support\Helper\Arr\LastKey`       |
| Array  | `order`         | `Phalcon\Support\Helper\Arr\Order`         |
| Array  | `pluck`         | `Phalcon\Support\Helper\Arr\Pluck`         |
| Array  | `set`           | `Phalcon\Support\Helper\Arr\Set`           |
| Array  | `sliceLeft`     | `Phalcon\Support\Helper\Arr\SliceLeft`     |
| Array  | `sliceRight`    | `Phalcon\Support\Helper\Arr\SliceRight`    |
| Array  | `split`         | `Phalcon\Support\Helper\Arr\Split`         |
| Array  | `toObject`      | `Phalcon\Support\Helper\Arr\ToObject`      |
| Array  | `validateAll`   | `Phalcon\Support\Helper\Arr\ValidateAll`   |
| Array  | `validateAny`   | `Phalcon\Support\Helper\Arr\ValidateAny`   |
| Array  | `whitelist`     | `Phalcon\Support\Helper\Arr\Whitelist`     |
| File   | `basename`      | `Phalcon\Support\Helper\File\Basename`     |
| JSON   | `decode`        | `Phalcon\Support\Helper\Json\Decode`       |
| JSON   | `encode`        | `Phalcon\Support\Helper\Json\Encode`       |
| Number | `isBetween`     | `Phalcon\Support\Helper\Number\IsBetween`  |
| String | `camelize`      | `Phalcon\Support\Helper\Str\Camelize`      |
| String | `concat`        | `Phalcon\Support\Helper\Str\Concat`        |
| String | `countVowels`   | `Phalcon\Support\Helper\Str\CountVowels`   |
| String | `decapitalize`  | `Phalcon\Support\Helper\Str\Decapitalize`  |
| String | `decrement`     | `Phalcon\Support\Helper\Str\Decrement`     |
| String | `dirFromFile`   | `Phalcon\Support\Helper\Str\DirFromFile`   |
| String | `dirSeparator`  | `Phalcon\Support\Helper\Str\DirSeparator`  |
| String | `dynamic`       | `Phalcon\Support\Helper\Str\Dynamic`       |
| String | `endsWith`      | `Phalcon\Support\Helper\Str\EndsWith`      |
| String | `firstBetween`  | `Phalcon\Support\Helper\Str\FirstBetween`  |
| String | `friendly`      | `Phalcon\Support\Helper\Str\Friendly`      |
| String | `humanize`      | `Phalcon\Support\Helper\Str\Humanize`      |
| String | `includes`      | `Phalcon\Support\Helper\Str\Includes`      |
| String | `increment`     | `Phalcon\Support\Helper\Str\Increment`     |
| String | `interpolate`   | `Phalcon\Support\Helper\Str\Interpolate`   |
| String | `isAnagram`     | `Phalcon\Support\Helper\Str\IsAnagram`     |
| String | `isLower`       | `Phalcon\Support\Helper\Str\IsLower`       |
| String | `isPalindrome`  | `Phalcon\Support\Helper\Str\IsPalindrome`  |
| String | `isUpper`       | `Phalcon\Support\Helper\Str\IsUpper`       |
| String | `kebabCase`     | `Phalcon\Support\Helper\Str\KebabCase`     |
| String | `len`           | `Phalcon\Support\Helper\Str\Len`           |
| String | `lower`         | `Phalcon\Support\Helper\Str\Lower`         |
| String | `pascalCase`    | `Phalcon\Support\Helper\Str\PascalCase`    |
| String | `prefix`        | `Phalcon\Support\Helper\Str\Prefix`        |
| String | `random`        | `Phalcon\Support\Helper\Str\Random`        |
| String | `reduceSlashes` | `Phalcon\Support\Helper\Str\ReduceSlashes` |
| String | `snakeCase`     | `Phalcon\Support\Helper\Str\SnakeCase`     |
| String | `startsWith`    | `Phalcon\Support\Helper\Str\StartsWith`    |
| String | `suffix`        | `Phalcon\Support\Helper\Str\Suffix`        |
| String | `ucwords`       | `Phalcon\Support\Helper\Str\Ucwords`       |
| String | `uncamelize`    | `Phalcon\Support\Helper\Str\Uncamelize`    |
| String | `underscore`    | `Phalcon\Support\Helper\Str\Underscore`    |
| String | `upper`         | `Phalcon\Support\Helper\Str\Upper`         |

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$upper = $helper->newInstance('upper');
```

## Méthodes
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
Returns the first element of the collection. If a `callable` is passed, the element returned is the first that validates `true`

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
Returns the key of the first element of the collection. If a `callable` is passed, the element returned is the first that validates `true`

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
Groups the elements of an array based on the passed callable

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
Returns the last element of the collection. If a `callable` is passed, the element returned is the first that validates `true`

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
Returns the key of the first element of the collection. If a `callable` is passed, the element returned is the first that validates `true`

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
Returns the passed array as an object

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

### `decode(string $data, bool $associative = false, int $depth = 512, int $options = 0): string`
Decodes a string using `json_decode` and throws an exception if the JSON data cannot be decoded

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
Encodes a string using `json_encode` and throws an exception if the JSON data cannot be encoded

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
Returns number of vowels in provided string. Uses a regular expression to count the number of vowels (A, E, I, O, U) in a string

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'Luke, I am your father!';

$result = $helper->countVowels($source);

echo $result; // 9
```

### `decapitalize(string $text, bool $upperRest = false, string $encoding = 'UTF-8'): string`
Decapitalizes the first letter of the string and then adds it with rest of the string. Omit the upperRest parameter to keep the rest of the string intact, or set it to true to convert to uppercase.

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'BeetleJuice';

$result = $helper->decapitalize($source);

echo $result; // 'beetleJuice'
```

### `decrement(string $text, string $separator = '_'): string`
Removes a number from the end of a string or decrements that number if it is already defined

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'file_2';

$result = $helper->decrement($source);

echo $result; // 'file_1'
```

### `dirFromFile(string $file): string`
Accepts a file name (without extension) and returns a calculated directory structure with the filename in the end

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'abcdef12345.jpg';

$result = $helper->dirFromFile($source);

echo $result; // 'ab/cd/ef/12/3/'
```

### `dirSeparator(string $directory): string`
Accepts a directory name and ensures that it ends with `DIRECTORY_SEPARATOR`

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = '/home/phalcon//';

$result = $helper->dirSeparator($source);

echo $result; // '/home/phalcon/'
```

### `dynamic(string $text, string $leftDelimiter = "{", string $rightDelimiter = "}", string $separator = "|"): string`
Generates random text in accordance with the template. The template is defined by the left and right delimiter, and it can contain values separated by the separator

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = '{Hi|Hello}, my name is Bob!';

$result = $helper->dynamic($source);

echo $result; // 'Hi, my name is Bob!'

$result = $helper->dynamic($source);

echo $result; // 'Hello, my name is Bob!'
```

### `endsWith(string $haystack, string $needle, bool $ignoreCase = true): bool`
Returns `true` if a string ends with a given string, `false` otherwise

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'abcdef';

$result = $helper->endsWith($source, 'ef');

echo $result; // true
```

### `firstBetween(string $text, string $start, string $end): string`
Returns the first string there is between the strings from the parameter start and end.

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'This is a [custom] string';

$result = $helper->firstBetween($source, '[', ']');

echo $result; // 'custom'
```

### `friendly(string $text, string $separator = '-', bool $lowercase = true, mixed $replace = null): string`
Changes a text to a URL friendly one. Replaces commonly known accented characters with their Latin equivalents. If a `replace` string or array is passed, it will also be used to replace those characters with a space.

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'This is a Test';

$result = $helper->friendly($source);

echo $result; // 'this-is-a-test'
```

### `humanize(string $text): string`
Changes a text with underscores or dashes to human-readable

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'kittens-are_cats';

$result = $helper->friendly($source);

echo $result; // 'kittens are cats'
```

### `includes(string $haystack, string $needle): bool`
Determines whether a string includes another string or not

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'Phalcon Framework';

$result = $helper->includes($source, 'Framework');

echo $result; // true
```

### `increment(string $text, string $separator = '_'): string`
Adds a number to the end of a string or increments that number if it is already defined

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'file_1';

$result = $helper->increment($source);

echo $result; // 'file_2'
```

### `interpolate(string $message, array $context = [], string $leftToken = "%", string $rightToken = "%"): string`
Interpolates context values into the message placeholders. By default, the right and left tokens are `%`

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = '%date% (YYYY-MM-DD) %level% (0-9)';
$data   = [
    'date'  => '2020-09-09',
    'level' => 'CRITICAL',
];

$result = $helper->interpolate($source, $data);

echo $result; // '2020-09-09 (YYYY-MM-DD) CRITICAL (0-9)'
```

### `isAnagram(string $first, string $second): bool`
Compares two strings and returns `true` if both strings are anagram, `false` otherwise

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'rail safety';
$target = 'fairy tales';

$result = $helper->isAnagram($source, $target);

echo $result; // true
```

### `isLower(string $text, string $encoding = 'UTF-8'): bool`
Returns `true` if the given string is in lower case, `false` otherwise

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'phalcon framework';

$result = $helper->isLower($source);

echo $result; // true
```

### `isPalindrome(string $text): bool`
Returns `true` if the given string is a palindrome, `false` otherwise

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'racecar';

$result = $helper->isPalindrome($source);

echo $result; // true
```

### `isUpper(string $text, string $encoding = 'UTF-8'): bool`
Returns `true` if the given string is in upper case, `false` otherwise

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'PHALCON FRAMEWORK';

$result = $helper->isUpper($source);

echo $result; // true
```

### `kebabCase(string $text, string $delimiters = null): string`
Convert strings to kebab-case style

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'customer_session';

$result = $helper->kebabCase($source);

echo $result; // 'customer-session'
```

### `len(string $text, string $encoding = 'UTF-8'): int`
Calculates the length of the string using `mb_strlen`

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'abcdef';

$result = $helper->len($source);

echo $result; // 6
```

### `lower(string $text, string $encoding = 'UTF-8'): string`
Converts a string to lowercase using `mbstring`

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'Phalcon Framework';

$result = $helper->lower($source);

echo $result; // 'phalcon framework'
```

### `pascalCase(string $text, string $delimiters = null): string`
Convert strings to PascalCase style

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'customer-session';

$result = $helper->pascalCase($source);

echo $result; // 'CustomerSession'
```

### `prefix($text, string $prefix): string`
Prefixes the text with the supplied prefix

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'Framework';

$result = $helper->prefix($source, 'Phalcon');

echo $result; // 'PhalconFramework'
```

### `random(int $type = 0, int $length = 8): string`
Generates a random string based on the given type. Type is one of:

| Constant          | Description                                                                                      |
| ----------------- | ------------------------------------------------------------------------------------------------ |
| `RANDOM_ALNUM`    | Only alphanumeric characters [a-zA-Z0-9]                                                         |
| `RANDOM_ALPHA`    | Only alphabetical characters [azAZ]                                                              |
| `RANDOM_DISTINCT` | Only alphanumeric uppercase characters exclude similar characters [2345679ACDEFHJKLMNPRSTUVWXYZ] |
| `RANDOM_HEXDEC`   | Only hexadecimal characters [0-9a-f]                                                             |
| `RANDOM_NOZERO`   | Only numbers without 0 [1-9]                                                                     |
| `RANDOM_NUMERIC`  | Only numbers [0-9]                                                                               |

```php
<?php

use Phalcon\Support\Helper\Str\Random;
use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

echo $helper->random(Random::RANDOM_ALNUM); // 4
echo $helper->random(Random::RANDOM_ALNUM); // 2
echo $helper->random(Random::RANDOM_ALNUM); // 1
echo $helper->random(Random::RANDOM_ALNUM); // 3
```

### `reduceSlashes(string $text): string`
Reduces multiple slashes in a string to single slashes

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'app/controllers//IndexController';

$result = $helper->reduceSlashes($source);

echo $result; // 'app/controllers/IndexController'
```

### `snakeCase(string $text, string $delimiters = null): string`
Convert strings to snake_case style

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'customer-session';

$result = $helper->snakeCase($source);

echo $result; // 'customer_session'
```

### `startsWith(string $haystack, string $needle, bool $ignoreCase = true): bool`
Returns `true` if a string starts with a given string, `false` otherwise

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'abcdef';

$result = $helper->startsWith($source, 'ab');

echo $result; // true
```

### `suffix($text, string $suffix): string`
Suffixes the text with the supplied suffix

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'Phalcon';

$result = $helper->suffix($source, 'Framework');

echo $result; // 'PhalconFramework'
```

### `ucwords(string $text, string $encoding = 'UTF-8'): string`
Capitalizes the first letter of each word

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'phalcon framework';

$result = $helper->ucwords($source);

echo $result; // 'Phalcon Framework'
```

`uncamelize(string $text, string $delimiters = '_'): string` Converts strings to non camelized style

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'CameLiZe';

$result = $helper->uncamelize($source);

echo $result; // came-li-ze
```

### `underscore(string $text): string`
Converts spaces to underscores

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'Phalcon Framework';

$result = $helper->underscore($source);

echo $result; // 'Phalcon_Framework'
```

### `upper(string $text, string $encoding = 'UTF-8'): string`
Converts a string to uppercase using mbstring

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();

$source = 'Phalcon Framework';

$result = $helper->upper($source);

echo $result; // 'PHALCON FRAMEWORK'
```

[support-helper]: api/phalcon_support#support-helperfactory
