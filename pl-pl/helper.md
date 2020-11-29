---
layout: default
language: 'pl-pl'
version: '4.0'
upgrade: ''
title: 'Helper'
keywords: 'helpers, array, string, file system, number, utilities'
---

# Helper Component

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

`Phalcon\Helper` a component exposing helper classes and static methods used throughout the framework.

## Arr

[Phalcon\Helper\Arr](api/phalcon_helper#helper-arr) exposes static methods that offer quick access to common functionality when working with arrays.

### `chunk`

```php
final public static function chunk(
    array $collection, 
    int $size, 
    bool $preserveKeys = false
): array
```

Chunks an array into smaller arrays of a specified size.

```php
<?php

use Phalcon\Helper\Arr;

$source   = [
    'k1' => 1,
    'k2' => 2,
    'k3' => 3,
    'k4' => 4,
    'k5' => 5,
    'k6' => 6,
];

$chunks = Arr::chunk($source, 2);

// [
//    [1, 2],
//    [3, 4],
//    [5, 6],
// ]
```

### first

```php
final public static function first(
    array $collection, 
    mixed $method = null
): var
```

Returns the first element of the collection. If a callable is passed, the element returned is the first that validates `true`

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    'Phalcon',
    'Framework',
];

echo Arr::first($collection); // 'Phalcon'

$result = Arr::first(
    $collection,
    function ($element) {
        return strlen($element) > 8;
    }
);

echo $result; // 'Framework'
```

### `firstKey`

```php
final public static function firstKey(
    array $collection, 
    mixed $method = null
): var
```

Returns the key of the first element of the collection. If a callable is passed, the element returned is the first that validates true

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    1 => 'Phalcon',
    3 => 'Framework',
];

echo Arr::firstKey($collection); // 1

$result = Arr::firstKey(
    $collection,
    function ($element) {
        return strlen($element) > 8;
    }
);

echo $result; // 3
```

### `flatten`

```php
final public static function flatten(
    array $collection, 
    bool $deep = false
): array
```

Flattens an array up to the one level depth. If `$deep` is set to `true`, it traverses all elements and flattens them all.

```php
<?php

use Phalcon\Helper\Arr;

$source   = [1, [2], [[3], 4], 5];
var_dump(
    Arr::flatten($source)
);

// [1, 2, [3], 4, 5];

$source   = [1, [2], [[3], 4], 5];
var_dump(
    Arr::flatten($source, true)
);
// [1, 2, 3, 4, 5];
```

### `get`

```php
final public static function get(
    array $collection, 
    mixed $index, 
    mixed $defaultValue = null,
    string $cast = null
): mixed
```

Retrieves an element from an array. If the element exists its value is returned. If not, the `defaultValue` is returned. The `cast` parameter accepts a string that defines what the returned value will be casted. The available values are:

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

```php
<?php

use Phalcon\Helper\Arr;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

echo Arr::get($data, 'year');                    // 1776
echo Arr::get($data, 'unknown', 1776);           // 1776
echo Arr::get($data, 'unknown', 1776, 'string'); // '1776'
```

### `group`

```php
final public static function group(
    array $collection, 
    mixed $method
): array
```

Groups the elements of an array based on the passed callable and returns the array of the grouped elements back. The callable can be a string as the element name, a callable or a method available. The array can contain sub arrays as elements or objects with relevant properties.

```php
<?php

use Phalcon\Helper\Arr;

$collection =  [
    ['name' => 'Paul',  'age' => 34],
    ['name' => 'Peter', 'age' => 31],
    ['name' => 'John',  'age' => 29],
];

$result = Arr::group($collection, 'age');
var_dump($result);

// [
//     34 => [
//         [
//             'name' => 'Paul',
//             'age' => 34,
//         ],
//     ],
//     31 => [
//         [
//             'name' => 'Peter',
//             'age' => 31,
//         ],
//     ],
//     29 => [
//         [
//             'name' => 'John',
//             'age' => 29,
//         ],
//     ],
// ]


$peter = new \stdClass();
$peter->name = 'Peter';
$peter->age = 34;

$paul = new \stdClass();
$paul->name = 'Paul';
$paul->age = 31;

$collection = [
    'peter' => $peter,
    'paul'  => $paul,
];

$result = = Arr::group($collection, 'name');
var_dump($result);

// [
//     'Peter' => [
//          stdClass(
//              name : 'Peter',
//              age  : 34
//          ),
//      ],
//     'Paul'  => [
//          stdClass(
//              name : 'Paul',
//              age  : 31
//          ),
//      ],
// ]


$collection = ['one', 'two', 'three'];

$result = Arr::group($collection, 'strlen');
var_dump($result);

// [
//     3 => ['one', 'two'],
//     5 => ['three']
// ]
```

### `has`

```php
final public static function has(array $collection, mixed $index): bool
```

Checks if an element exists in an array. Returns `true` if found, `false` otherwise.

```php
<?php

use Phalcon\Helper\Arr;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

echo Arr::has($data, 'year');          // true
echo Arr::has($data, 'unknown');       // false
```

### `isUnique`

```php
final public static function isUnique(array $collection): bool
```

Checks a flat list for duplicate values. Returns `true` if duplicate values exist and `false` if values are all unique.

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    'Phalcon',
    'Framework',
];

$result = Arr::isUnique($collection); // true

$collection = [
    'Phalcon',
    'Framework',
    'Phalcon',
];
$result = Arr::isUnique($collection); // false
```

### `last`

```php
final public static function last(
    array $collection, 
    mixed $method = null
): var
```

Returns the last element of the collection. If a callable is passed, the element returned is the last that validates `true`

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    'Phalcon',
    'Framework',
];

echo Arr::last($collection); // 'Framework'

$result = Arr::last(
    $collection,
    function ($element) {
        return strlen($element) < 8;
    }
);

echo $result; // 'Phalcon'
```

### `lastKey`

```php
final public static function lastKey(
    array $collection, 
    mixed $method = null
): var
```

Returns the key of the last element of the collection. If a callable is passed, the element returned is the last that validates `true`

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    1 => 'Phalcon',
    3 => 'Framework',
];

echo Arr::lastKey($collection); // 3

$result = Arr::lastKey(
    $collection,
    function ($element) {
        return strlen($element) < 8;
    }
);

echo $result; // 1
```

### `order`

```php
final public static function order(
    array $collection, 
    mixed $attribute, 
    string $order = 'asc'
): array
```

Sorts a collection of arrays or objects by `attribute` and returns the sorted array. The third parameter controls the sort order.

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    ['id' => 2],
    ['id' => 3],
    ['id' => 1],
];

$result = Arr::order($collection, 'id');
var_dump($result);
// [
//     ['id' => 1],
//     ['id' => 2],
//     ['id' => 3],
// ]

$result = Arr::order($collection, 'id', 'desc');
var_dump($result);
// [
//     ['id' => 3],
//     ['id' => 2],
//     ['id' => 1],
// ]
```

### `pluck`

```php
final public static function pluck(
    array $collection, 
    string element
): array
```

Retrieves all of the values for a given key returning them as an array

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    ['product_id' => 'prod-100', 'name' => 'Desk'],
    ['product_id' => 'prod-200', 'name' => 'Chair'],
];

$result = Arr::pluck($collection, 'name');
var_dump($result);
// [
//     'Desk', 
//     'Chair'
// ]
```

### `set`

```php
final public static function set(
    array $collection, 
    mixed $value, 
    mixed $index = null
): array
```

Sets an array element and returns the new array back. The third parameter is the index/key.

```php
<?php

use Phalcon\Helper\Arr;

$collection = [];
$result = Arr::set($collection, 'Phalcon');
var_dump($result);
// [
//     0 => 'Phalcon',
// ]


$collection = [
    1 => 'Phalcon'
];
$result = Arr::set($collection, 'Framework', 1);
var_dump($result);
// [
//     1 => 'Framework',
// ]
```

### `sliceLeft`

```php
final public static function sliceLeft(
    array $collection, 
    int $elements = 1
): array
```

Returns a new array with n elements removed from the left.

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    'Phalcon',
    'Framework',
    'for',
    'PHP',
];

$result = Arr::sliceLeft($collection, 1);
var_dump($result);
// [
//     'Phalcon',
// ]

$result = Arr::sliceLeft($collection, 3);
var_dump($result);
// [
//     'Phalcon',
//     'Framework',
//     'for',
// ]
```

### `sliceRight`

```php
final public static function sliceRight(
    array $collection, 
    int $elements = 1
): array
```

Returns a new array with n elements removed from the right.

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    'Phalcon',
    'Framework',
    'for',
    'PHP',
];

$result   = Arr::sliceRight($collection, 1);
var_dump($result);
// [
//     'Framework',
//     'for',
//     'PHP',
// ]

$result   = Arr::sliceRight($collection, 3);
var_dump($result);
// [
//     'PHP',
// ]
```

### `split`

```php
final public static function split(array $collection): array
```

Returns a new array with keys of the passed array as one element and values as another.

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    1 => 'Phalcon',
    3 => 'Framework',
];

$result = Arr::split($collection);
var_dump($result);
// [
//     [1, 3],
//     ['Phalcon', 'Framework']
// ]
```

### `toObject`

```php
final public static function toObject(array $collection)
```

Converts an array to an object

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    1 => 'Phalcon',
    3 => 'Framework',
];

$result = Arr::toObject($collection);
var_dump($result);
// object(stdClass)#1 (2) {
//   ["1"] => string(7) "Phalcon"
//   ["3"] => string(9) "Framework"
// }
```

### `validateAll`

```php
final public static function validateAll(
    array $collection, 
    mixed $method
): bool
```

Returns true if the provided function returns `true` for all elements of the collection, `false` otherwise.

```php
<?php

use Phalcon\Helper\Arr;

$collection = [2, 3, 4, 5];
$result     = Arr::validateAll(
    $collection,
    function ($element) {
        return $element > 1;
    }
);

var_dump($result); // true
```

### `validateAny`

```php
final public static function validateAny(
    array $collection, 
    mixed $method
): bool
```

Returns true if the provided function returns `true` for at least one element of the collection, `false` otherwise.

```php
<?php

use Phalcon\Helper\Arr;

$collection = [2, 3, 4, 5];
$result     = Arr::validateAny(
    $collection,
    function ($element) {
        return $element > 4;
    }
);

var_dump($result); // true
```

### `whiteList`

```php
final public static function whiteList(
    array $collection, 
    array $whiteList 
): array
```

Returns a subset of the array, white listing elements by key. The returned array contains only the elements of the source array that have keys identical to the whitelist array that was passed as a parameter.

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    2     => 'Phalcon',
    3     => 'Apples',
    'one' => 'Framework',
    'two' => 'Oranges',
];
$result     = Arr::whiteList(
    $collection,
    [2, 'one']
);

var_dump($result);
// [
//     2     => 'Phalcon',
//     'one' => 'Framework'
// ]
```

## Exception

Any exceptions thrown in the `Phalcon\Helper\*` components will be of this type: [Phalcon\Helper\Exception](api/phalcon_helper#helper-exception)

## Fs

[Phalcon\Helper\Fs](api/phalcon_helper#helper-fs) exposes static methods that offer file operation helper methods

### `basename`

```php
final public static function basename(
    int $uri, 
    mixed $suffix
) -> string
```

Gets the filename from a given path, This method is similar to PHP's [basename()](https://www.php.net/manual/en/function.basename.php) but has non-ASCII character support. PHP's [basename()](https://www.php.net/manual/en/function.basename.php) does not properly support streams or filenames beginning with a non-US-ASCII character.

```php
<?php

use Phalcon\Helper\Fs;

$file = '/file/热爱中文.txt';

echo Fs::basename($file); // '热爱中文.txt'

$file = '/myfolder/日本語のファイル名.txt';

echo Fs::basename($file); // '日本語のファイル名.txt'

$file = '/root/ελληνικά.txt';

echo Fs::basename($file); // 'ελληνικά.txt';
```

## Json

[Phalcon\Helper\Json](api/phalcon_helper#helper-json) acts as a wrapper to `json_encode` and `json_decode` PHP methods, checking for errors and raising exceptions accordingly.

### `decode`

```php
final public static function decode(
    string $data,
    bool $associative = false,
    int $depth = 512,
    int $options = 0
 ): mixed
```

Decodes a string using `json_decode` and throws an exception if the JSON data cannot be decoded

```php
use Phalcon\Helper\Json;

$data = ' {"one":"two","0":"three"}
';

var_dump(Json::decode($data));
// [
//     'one' => 'two',
//     'three'
// ];
```

### `encode`

```php
final public static function encode(
    $data,
    int $depth = 512,
    int $options = 0
): string
```

Encodes a string using `json_encode` and throws an exception if the JSON data cannot be encoded

```php
use Phalcon\Helper\Json;

$data = [
    'one' => 'two',
    'three'
];

echo Json::encode($data);
// {"one":"two","0":"three"}
```

## Number

[Phalcon\Helper\Number](api/phalcon_helper#helper-number) exposes static methods that offer quick access to common functionality when working with numbers.

### `between`

```php
final public static function between(
    int $value, 
    int $from, 
    int $to
) -> bool
```

Checks if the passed value is between the range specified in `from` and `to`

```php
<?php

use Phalcon\Helper\Number;

$min   = 10;
$max   = 100;
$value = 13;

echo Number::between($value, $min, $max);   // true

$value = 2;
echo Number::between($value, $min, $max);   // false
```

## Str

[Phalcon\Helper\Str](api/phalcon_helper#helper-str) exposes static methods that offer quick manipulations to strings.

### `camelize`

```php
final public static function camelize(string $text, mixed $delimiter = null): string
```

Converts strings to camelize style

```php
<?php

use Phalcon\Helper\Str;

echo Str::camelize('coco_bongo');         // CocoBongo
echo Str::camelize('co_co-bon_go', '-');  // Co_coBon_go
echo Str::camelize('co_co-bon_go', '_-'); // CoCoBonGo
```

### `concat`

```php
final public static function concat(
    string $separator, 
    string $a, 
    string $b 
    [, string $x] ... 
): string
```

Concatenates strings using the separator only once, removing duplicate delimiters. The first parameter is the separator, the subsequent ones are the strings to concatenate together. The minimum required parameters are three.

```php
<?php

use Phalcon\Helper\Str;

$folder = Str::concat(
    '/',
    '/tmp/',
    '/folder_1/',
    '/folder_2',
    'folder_3/'
);

echo $folder; // /tmp/folder_1/folder_2/folder_3/

```

### `countVowels`

```php
final public static function countVowels(string $text): int
```

Returns number of vowels in provided string. Uses a regular expression to count the number of vowels (A, E, I, O, U) in a string.

```php
<?php

use Phalcon\Helper\Str;

$source = 'Luke, I am your father!';

echo Str::countVowels($source); // 8
```

### `decapitalize`

```php
final public static function decapitalize(
    string $text, 
    bool $upperRest = false, 
    string $encoding = 'UTF-8'
): string
```

Decapitalizes the first letter of the string and then adds it back. If the `upperRest` parameter is set to `false` the rest of the string remains intact, otherwise it is converted to uppercase. The method will try to use methods provided by the `mbstring` extension and use the PHP equivalent as a fallback. The last parameter is the encoding that `mbstring` methods will use. It defaults to `UTF-8`.

```php
<?php

use Phalcon\Helper\Str;

$source   = 'BeetleJuice';

echo Str::decapitalize($source);       // beetleJuice
echo Str::decapitalize($source, true); // bEETLEJUICE
```

### decrement

```php
final public static function decrement(
    string $text, 
    string $separator = '_'
): string
```

Removes a number from a string or decrements that number if it already is defined.

```php
<?php

use Phalcon\Helper\Str;

echo Str::decrement('a_1'); // 'a'
echo Str::decrement('a_2'); // 'a_1'
```

### `dirFromFile`

```php
final public static function dirFromFile(string $file): string
```

Accepts a file name (without extension) and returns a calculated directory structure with the filename in the end

```php
<?php

use Phalcon\Helper\Str;

echo Str::dirFromFile("file1234.jpg"); // fi/le/12/
```

### `dirSeparator`

```php
final public static function dirSeparator(string $directory): string
```

Accepts a directory name and ensures that it ends with `DIRECTORY_SEPARATOR`

```php
<?php

use Phalcon\Helper\Str;

echo Str::dirSeparator("/home/phalcon"); // /home/phalcon/
```

### `dynamic`

```php
final public static function dynamic(
    string $text,
    string $leftDelimiter = '{',
    string $rightDelimiter = '}',
    string $separator = '|'
): string
```

Generates random text based on the template. The template needs separators as well as a delimiter for the different values. The defaults for those can be overridden with the method parameters.

```php
<?php

use Phalcon\Helper\Str;

echo Str::dynamic('{Han|Leia|Luke} {Solo|Skywalker}!');  // Han Solo!
echo Str::dynamic('{Han|Leia|Luke} {Solo|Skywalker}!');  // Leia Skywalker!
echo Str::dynamic('{Han|Leia|Luke} {Solo|Skywalker}!');  // Luke Solo!
```

### `endsWith`

```php
final public static function endsWith(
    string $text, 
    string $end, 
    bool $ignoreCase = true
): bool
```

Returns `true` if a string ends with a given string. If the last parameter is `true` (default), the search is made in a case-insensitive manner.

```php
<?php

use Phalcon\Helper\Str;

echo Str::endsWith('Hello', 'llo');        // true
echo Str::endsWith('Hello', 'LLO', false); // false
echo Str::endsWith('Hello', 'LLO');        // true
```

### `firstBetween`

```php
final public static function firstBetween(
    string $haystack,
    string $start,
    string $end
): string
```

Returns the first string there is between the strings from the parameter start and end. The method will try to use methods provided by the `mbstring` extension and use the PHP equivalent as a fallback.

```php
<?php

use Phalcon\Helper\Str;

$source   = 'This is a [custom] string with [other] stuff';

echo Str::firstBetween($source, '[', ']'); // custom
```

### `humanize`

```php
final public static function humanize(string $text): string
```

Makes an underscored or dashed phrase human-readable

```php
<?php

use Phalcon\Helper\Str;

echo Str::humanize('start-a-horse'); // 'start a horse'
echo Str::humanize('five_cats');     // 'five cats'
```

### `includes`

```php
final public static function includes(
    string $needle, 
    string $haystack
): bool
```

Checks if a string is included in another string. Returns `true` if it is included, `false` otherwise. The method will try to use methods provided by the `mbstring` extension and use the PHP equivalent as a fallback.

```php
<?php

use Phalcon\Helper\Str;

echo Str::includes('start', 'start-a-horse'); // true
echo Str::includes('end', 'start-a-horse'); // false
```

### `increment`

```php
final public static function increment(
    string $text, 
    string $separator = '_'
): string
```

Adds a number to a string or increment that number if it already is defined.

```php
<?php

use Phalcon\Helper\Str;

echo Str::increment('a');   // 'a_1'
echo Str::increment('a_1'); // 'a_2'
```

### `isAnagram`

```php
final public static function isAnagram(
    string $first, 
    string $second
): bool
```

Compare two strings and returns `true` if both strings are anagram, `false` otherwise.

```php
<?php

use Phalcon\Helper\Str;

echo Str::isAnagram('rail safety', 'fairy tales'); // true
```

### `isLower`

```php
final public static function isLower(
    string $text, 
    string $encoding = 'UTF-8'
):  bool
```

Returns `true` if the given string is lower case, `false` otherwise. The method will try to use methods provided by the `mbstring` extension and use the PHP equivalent as a fallback. The last parameter is the encoding that `mbstring` methods will use. It defaults to `UTF-8`.

```php
<?php

use Phalcon\Helper\Str;

echo Str::isLower('phalcon framework'); // true
echo Str::isLower('Phalcon Framework'); // false
```

### `isPalindrome`

```php
final public static function isPalindrome(string $text): bool
```

Returns `true` if the given string is a palindrome, `false` otherwise.

```php
<?php

use Phalcon\Helper\Str;

echo Str::isPalindrome('racecar'); // true
```

### `isUpper`

```php
final public static function isUpper(
    string $text, 
    string $encoding = 'UTF-8'
):  bool
```

Returns `true` if the given string is upper case, `false` otherwise. The method will try to use methods provided by the `mbstring` extension and use the PHP equivalent as a fallback. The last parameter is the encoding that `mbstring` methods will use. It defaults to `UTF-8`.

```php
<?php

use Phalcon\Helper\Str;

echo Str::isUpper('PHALCON FRAMEWORK'); // true
echo Str::isUpper('Phalcon Framework'); // false
```

### `lower`

```php
final public static function lower(
    string $text, 
    string $encoding = 'UTF-8'
): string
```

Converts a string to lowercase characters. The method will try to use methods provided by the `mbstring` extension and use the PHP equivalent as a fallback. The last parameter is the encoding that `mbstring` methods will use. It defaults to `UTF-8`.

```php
<?php

use Phalcon\Helper\Str;

echo Str::lower('PHALCON FRAMEWORK'); // phalcon framework
```

### `random`

```php
final public static function random(
    int $type = 0, 
    long $length = 8
): string
```

Generates a random string based on the given type. The first parameter is one of the `RANDOM_*` constants. The second parameter specifies the length of the string (defaults to 8).

| Constant          | Description                                                                                         |
| ----------------- | --------------------------------------------------------------------------------------------------- |
| `RANDOM_ALNUM`    | Only alpha numeric characters `[a-zA-Z0-9]`                                                         |
| `RANDOM_ALPHA`    | Only alphabetical characters `[azAZ]`                                                               |
| `RANDOM_DISTINCT` | Only alpha numeric uppercase characters exclude similar characters `[2345679ACDEFHJKLMNPRSTUVWXYZ]` |
| `RANDOM_HEXDEC`   | Only hexadecimal characters `[0-9a-f]`                                                              |
| `RANDOM_NOZERO`   | Only numbers without `0` `[1-9]`                                                                    |
| `RANDOM_NUMERIC`  | Only numbers `[0-9]`                                                                                |

```php
<?php

use Phalcon\Helper\Str;

echo Str::random(Str::RANDOM_ALNUM); // 'aloiwkqz'
```

### `reduceSlashes`

```php
final public static function reduceSlashes(string $text): string
```

Reduces multiple slashes in a string to single slashes. If a scheme is present (`https://`, `ftp://` it will not be changed)

```php
<?php

use Phalcon\Helper\Str;

echo Str::reduceSlashes('foo//bar/baz');             // foo/bar/baz
echo Str::reduceSlashes('http://foo.bar///baz/buz'); // http://foo.bar/baz/buz
echo Str::reduceSlashes('//foo.bar///baz/buz');      // /foo.bar/baz/buz
echo Str::reduceSlashes('ftp://foo.bar///baz/buz');  // ftp://foo.bar/baz/buz
echo Str::reduceSlashes('ftp//foo.bar///baz/buz');   // ftp/foo.bar/baz/buz
```

### `startsWith`

```php
final public static function startsWith(
    string $text, 
    string $start, 
    bool $ignoreCase = true
): bool
```

Returns `true` if a string starts with a given string. If the last parameter is `true` (default), the search is made in a case-insensitive manner.

```php
<?php

use Phalcon\Helper\Str;

echo Str::startsWith('Hello', 'He');        // true
echo Str::startsWith('Hello', 'he', false); // false
echo Str::startsWith('Hello', 'he');        // true
```

### `uncamelize`

```php
final public static function uncamelize(
    string $text,   
    mixed $delimiter = null
): string
```

Uncamelize strings which are camelized

```php
<?php

use Phalcon\Helper\Str;

echo Str::uncamelize('CocoBongo');      // coco_bongo
echo Str::uncamelize('CocoBongo', '-'); // coco-bongo
```

### `underscore`

```php
final public static function underscore(string $text): string
```

Makes a phrase underscored instead of spaced.

```php
<?php

use Phalcon\Helper\Str;

echo Str::underscore('look behind');     // 'look_behind'
echo Str::underscore('Awesome Phalcon'); // 'Awesome_Phalcon'
```

### `upper`

```php
final public static function upper(
    string $text, 
    string $encoding = 'UTF-8'
): string
```

Converts a string to uppercase characters. The method will try to use methods provided by the `mbstring` extension and use the PHP equivalent as a fallback. The last parameter is the encoding that `mbstring` methods will use. It defaults to `UTF-8`.

```php
<?php

use Phalcon\Helper\Str;

echo Str::upper('phalcon framework'); // PHALCON FRAMEWORK
```