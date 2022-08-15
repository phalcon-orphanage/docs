---
layout: default
language: 'zh-cn'
version: '5.0'
title: 'Helper'
keywords: 'helper, text, factory'
---

# Helper
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview
[Phalcon\Support\HelperFactory][support-helper] offers support methods that manipulate arrays, files, JSON, numbers and strings. The factory replaces the `Phalcon\Text` component, offering the same functionality and more.

```php
<?php

use Phalcon\Support\HelperFactory;

$helper = new HelperFactory();
 ```

The methods are available either by calling `newInstance()` on the factory object with the relevant name of the helper class, or calling the helper class directly as a method on the helper factory. The factory acts as a service locator, caching the objects to be reused if need be, in the same request.

## Available Classes

| Type   | Name            | 类                                              |
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
| String | `前缀`            | `Phalcon\Support\Helper\Str\Prefix`        |
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

## Methods
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

$helper = new HelperFactory();

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

$source = [
    'k1' => 1,
    'k2' => 2,
    'k3' => 3,
    'k4' => 4,
    'k5' => 5,
    'k6' => 6,
];

$helper = new HelperFactory();

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

$helper = new HelperFactory();

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

$source = [
    'one' => 'Phalcon',
    'two' => 'Framework',
];

$helper = new HelperFactory();

$result = $helper->first($source);

echo $result; // 'Phalcon'
```

### `firstKey(array $collection, callable $method = null): mixed`
Returns the key of the first element of the collection. If a `callable` is passed, the element returned is the first that validates `true`

```php
<?php

use Phalcon\Support\HelperFactory;

$source = [
    'one' => 'Phalcon',
    'two' => 'Framework',
];

$helper = new HelperFactory();

$result = $helper->firstKey($source);

echo $result; // 'one'
```

### `flatten(array $collection, bool $deep = false): array`
Flattens an array up to the one level depth, unless `$deep` is set to `true

```php
<?php

use Phalcon\Support\HelperFactory;

$source = [1, [2], [[3], 4], 5];

$helper = new HelperFactory();

$result = $helper->flatten($source);

var_dump($result);

// [1, 2, [3], 4, 5]
```

### `get(array $collection, mixed $index, mixed $defaultValue = null, string $cast = null): mixed`
Gets an array element by key and if it does not exist returns the default. It also allows for casting the returned value to a specific type using `settype` internally

```php
<?php

use Phalcon\Support\HelperFactory;

$source = [
    'one' => 'Phalcon',
    'two' => '1',
];

$helper = new HelperFactory();

echo $helper->get($source, 1);               // 'Phalcon'
echo $helper->get($source, 3, 'Unknown');    // 'Unknown'
echo $helper->get($source, 2, null, 'int');  // 1
```

### `group(array $collection, mixed $method): array`
Groups the elements of an array based on the passed callable

```php
<?php

use Phalcon\Support\HelperFactory;

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

$source = [
    1     => 'Phalcon',
    'two' => 'Framework',
];

$helper = new HelperFactory();

echo $helper->has($source, 1);         // true
echo $helper->get($source, 'two');     // true
echo $helper->get($source, 'unknown'); // false
```

### `isUnique(array $collection): bool`
Checks an array for duplicate values. Returns `true` if all values are unique, `false` otherwise.

```php
<?php

use Phalcon\Support\HelperFactory;

$source = [
    'Phalcon',
    'Framework',
];

$helper = new HelperFactory();

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

$source = [
    'one' => 'Phalcon',
    'two' => 'Framework',
];

$helper = new HelperFactory();

$result = $helper->last($source);

echo $result; // 'Framework'
```

### `lastKey(array $collection, callable $method = null): mixed`
Returns the key of the first element of the collection. If a `callable` is passed, the element returned is the first that validates `true`

```php
<?php

use Phalcon\Support\HelperFactory;

$source = [
    'one' => 'Phalcon',
    'two' => 'Framework',
];

$helper = new HelperFactory();

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

`toObject(array $collection): object` Sets an array element with an optional key

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

`validateAll(array $collection, callable $method): bool` Sets an array element with an optional key

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

`validateAny(array $collection, callable $method): bool` Sets an array element with an optional key

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

`whitelist(array $collection, array $whiteList): array` Sets an array element with an optional key

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

`basename(string $uri, string $suffix = null): string` Sets an array element with an optional key

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

`decode(string $data, bool $associative = false, int $depth = 512, int $options = 0): string` Sets an array element with an optional key

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

`encode($data, int $options = 0, int $depth = 512): string` Sets an array element with an optional key

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

`between(int $value, int $start, int $end): bool` Sets an array element with an optional key

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

`camelize(string $text, string $delimiters = null, bool $lowerFirst = false): string` Sets an array element with an optional key

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

`concat(string $delimiter, string $first, string $second, string ...$arguments): string` Sets an array element with an optional key

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

`countVowels(string $text): int` Sets an array element with an optional key

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

`decapitalize(string $text, bool $upperRest = false, string $encoding = 'UTF-8'): string` Sets an array element with an optional key

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

`decrement(string $text, string $separator = '_'): string` Sets an array element with an optional key

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

`dirFromFile(string $file): string` Sets an array element with an optional key

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

`dirSeparator(string $directory): string` Sets an array element with an optional key

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

`endsWith(string $haystack, string $needle, bool $ignoreCase = true): bool` Sets an array element with an optional key

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

`firstBetween(string $text, string $start, string $end): string` Sets an array element with an optional key

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

`friendly(
    string $text, 
    string $separator = '-', 
    bool $lowercase = true, 
    mixed $replace = null
): string` Sets an array element with an optional key

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

`humanize(string $text): string`

`includes(string $haystack, string $needle): bool` Sets an array element with an optional key

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

`increment(string $text, string $separator = '_'): string` Sets an array element with an optional key

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

`isAnagram(string $first, string $second): bool` Sets an array element with an optional key

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

`isLower(string $text, string $encoding = 'UTF-8'): bool` Sets an array element with an optional key

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

`isPalindrome(string $text): bool` Sets an array element with an optional key

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

`isUpper(string $text, string $encoding = 'UTF-8'): bool` Sets an array element with an optional key

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

`kebabCase(string $text, string $delimiters = null): string` Sets an array element with an optional key

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

`len(string $text, string $encoding = 'UTF-8'): int` Sets an array element with an optional key

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

`lower(string $text, string $encoding = 'UTF-8'): string` Sets an array element with an optional key

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

`pascalCase(string $text, string $delimiters = null): string` Sets an array element with an optional key

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

`prefix($text, string $prefix): string` Sets an array element with an optional key

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

`random(int $type = 0, int $length = 8): string` Sets an array element with an optional key

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

`reduceSlashes(string $text): string` Sets an array element with an optional key

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

`startsWith(string $haystack, string $needle, bool $ignoreCase = true): bool` Sets an array element with an optional key

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

`snakeCase(string $text, string $delimiters = null): string` Sets an array element with an optional key

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

`suffix($text, string $suffix): string` Sets an array element with an optional key

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

`ucwords(string $text, string $encoding = 'UTF-8'): string` Sets an array element with an optional key

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

`uncamelize(string $text, string $delimiters = '_'): string` Sets an array element with an optional key

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

`underscore(string $text): string` Sets an array element with an optional key

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

`upper(string $text, string $encoding = 'UTF-8'): string` Sets an array element with an optional key

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
