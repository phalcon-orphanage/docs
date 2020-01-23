---
layout: default
language: 'el-gr'
version: '4.0'
title: 'Phalcon\Helper'
---

* [Phalcon\Helper\Arr](#helper-arr)
* [Phalcon\Helper\Exception](#helper-exception)
* [Phalcon\Helper\Fs](#helper-fs)
* [Phalcon\Helper\Json](#helper-json)
* [Phalcon\Helper\Number](#helper-number)
* [Phalcon\Helper\Str](#helper-str)

<h1 id="helper-arr">Class Phalcon\Helper\Arr</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/helper/arr.zep)

| Namespace | Phalcon\Helper | | Uses | stdClass |

This class offers quick array functions throughout the framework

## Methods

```php
final public static function chunk( array $collection, int $size, bool $preserveKeys = bool ): array;
```

Chunks an array into smaller arrays of a specified size.

@return array

```php
final public static function filter( array $collection, mixed $method = null ): array;
```

Helper method to filter the collection

@return array

```php
final public static function first( array $collection, mixed $method = null ): mixed;
```

Returns the first element of the collection. If a callable is passed, the element returned is the first that validates true

@return mixed

```php
final public static function firstKey( array $collection, mixed $method = null ): mixed;
```

Returns the key of the first element of the collection. If a callable is passed, the element returned is the first that validates true

@return mixed

```php
final public static function flatten( array $collection, bool $deep = bool ): array;
```

Flattens an array up to the one level depth, unless `$deep` is set to `true`

@return array

```php
final public static function get( array $collection, mixed $index, mixed $defaultValue = null, string $cast = null ): mixed;
```

Helper method to get an array element or a default

```php
final public static function group( array $collection, mixed $method ): array;
```

Groups the elements of an array based on the passed callable

@return array

```php
final public static function has( array $collection, mixed $index ): bool;
```

Helper method to get an array element or a default

return bool

```php
final public static function isUnique( array $collection ): bool;
```

Checks a flat list for duplicate values. Returns true if duplicate values exist and false if values are all unique.

@return bool

```php
final public static function last( array $collection, mixed $method = null ): mixed;
```

Returns the last element of the collection. If a callable is passed, the element returned is the first that validates true

return mixed

```php
final public static function lastKey( array $collection, mixed $method = null ): mixed;
```

Returns the key of the last element of the collection. If a callable is passed, the element returned is the first that validates true

@return mixed

```php
final public static function order( array $collection, mixed $attribute, string $order = string ): array;
```

Sorts a collection of arrays or objects by key

@return array

```php
final public static function pluck( array $collection, string $element ): array;
```

Retrieves all of the values for a given key:

@return array

```php
final public static function set( array $collection, mixed $value, mixed $index = null ): array;
```

Helper method to set an array element

@return array

```php
final public static function sliceLeft( array $collection, int $elements = int ): array;
```

Returns a new array with n elements removed from the right.

@return array

```php
final public static function sliceRight( array $collection, int $elements = int ): array;
```

Returns a new array with the X elements from the right

@return array

```php
final public static function split( array $collection ): array;
```

Returns a new array with keys of the passed array as one element and values as another

@return array

```php
final public static function toObject( array $collection );
```

Returns the passed array as an object

```php
final public static function validateAll( array $collection, mixed $method = null ): bool;
```

Returns true if the provided function returns true for all elements of the collection, false otherwise.

@return bool

```php
final public static function validateAny( array $collection, mixed $method = null ): bool;
```

Returns true if the provided function returns true for at least one element of the collection, false otherwise.

@return bool

```php
final public static function whiteList( array $collection, array $whiteList ): array;
```

White list filter by key: obtain elements of an array filtering by the keys obtained from the elements of a whitelist

@return array

<h1 id="helper-exception">Class Phalcon\Helper\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/helper/exception.zep)

| Namespace | Phalcon\Helper | | Extends | \Phalcon\Exception |

Exceptions thrown in Phalcon\Helper will use this class

<h1 id="helper-fs">Class Phalcon\Helper\Fs</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/helper/fs.zep)

| Namespace | Phalcon\Helper |

This class offers file operation helper

## Methods

```php
final public static function basename( string $uri, mixed $suffix = null ): string;
```

Gets the filename from a given path, Same as PHP's basename() but has non-ASCII support. PHP's basename() does not properly support streams or filenames beginning with a non-US-ASCII character. see https://bugs.php.net/bug.php?id=37738

@return string

<h1 id="helper-json">Class Phalcon\Helper\Json</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/helper/json.zep)

| Namespace | Phalcon\Helper | | Uses | InvalidArgumentException |

This class offers a wrapper for JSON methods to serialize and unserialize

## Methods

```php
final public static function decode( string $data, bool $associative = bool, int $depth = int, int $options = int ): mixed;
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

@return mixed

@throws \InvalidArgumentException if the JSON cannot be decoded. @link http://www.php.net/manual/en/function.json-decode.php

```php
final public static function encode( mixed $data, int $options = int, int $depth = int ): string;
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

@return mixed

@throws \InvalidArgumentException if the JSON cannot be encoded. @link http://www.php.net/manual/en/function.json-encode.php

<h1 id="helper-number">Class Phalcon\Helper\Number</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/helper/number.zep)

| Namespace | Phalcon\Helper |

Phalcon\Helper\number

This class offers numeric functions for the framework

## Methods

```php
final public static function between( int $value, int $from, int $to ): bool;
```

Helper method to get an array element or a default

<h1 id="helper-str">Class Phalcon\Helper\Str</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/helper/str.zep)

| Namespace | Phalcon\Helper | | Uses | RuntimeException |

This class offers quick string functions throughout the framework

## Constants

```php
const RANDOM_ALNUM = 0;
const RANDOM_ALPHA = 1;
const RANDOM_DISTINCT = 5;
const RANDOM_HEXDEC = 2;
const RANDOM_NOZERO = 4;
const RANDOM_NUMERIC = 3;
```

## Methods

```php
final public static function camelize( string $text, mixed $delimiter = null ): string;
```

Converts strings to camelize style

```php
use Phalcon\Helper\Str;

echo Str::camelize("coco_bongo");            // CocoBongo
echo Str::camelize("co_co-bon_go", "-");     // Co_coBon_go
echo Str::camelize("co_co-bon_go", "_-");    // CoCoBonGo
```

@return string

```php
final public static function concat(): string;
```

Concatenates strings using the separator only once without duplication in places concatenation

```php
$str = Phalcon\Helper\Str::concat(
    "/",
    "/tmp/",
    "/folder_1/",
    "/folder_2",
    "folder_3/"
);

echo $str;   // /tmp/folder_1/folder_2/folder_3/
```

@return string

```php
final public static function countVowels( string $text ): int;
```

Returns number of vowels in provided string. Uses a regular expression to count the number of vowels (A, E, I, O, U) in a string.

@return int

```php
final public static function decapitalize( string $text, bool $upperRest = bool, string $encoding = string ): string;
```

Decapitalizes the first letter of the string and then adds it with rest of the string. Omit the upperRest parameter to keep the rest of the string intact, or set it to true to convert to uppercase.

@return string

```php
final public static function decrement( string $text, string $separator = string ): string;
```

Removes a number from a string or decrements that number if it already is defined. defined

```php
use Phalcon\Helper\Str;

echo Str::decrement("a_1");    // "a"
echo Str::decrement("a_2");  // "a_1"
```

@return string

```php
final public static function dirFromFile( string $file ): string;
```

Accepts a file name (without extension) and returns a calculated directory structure with the filename in the end

```php
use Phalcon\Helper\Str;

echo Str::dirFromFile("file1234.jpg"); // fi/le/12/
```

@return string

```php
final public static function dirSeparator( string $directory ): string;
```

Accepts a directory name and ensures that it ends with DIRECTORY_SEPARATOR

```php
use Phalcon\Helper\Str;

echo Str::dirSeparator("/home/phalcon"); // /home/phalcon/
```

@return string

```php
final public static function dynamic( string $text, string $leftDelimiter = string, string $rightDelimiter = string, string $separator = string ): string;
```

Generates random text in accordance with the template

```php
use Phalcon\Helper\Str;

// Hi my name is a Bob
echo Str::dynamic("{Hi|Hello}, my name is a {Bob|Mark|Jon}!");

// Hi my name is a Jon
echo Str::dynamic("{Hi|Hello}, my name is a {Bob|Mark|Jon}!");

// Hello my name is a Bob
echo Str::dynamic("{Hi|Hello}, my name is a {Bob|Mark|Jon}!");

// Hello my name is a Zyxep
echo Str::dynamic(
    "[Hi/Hello], my name is a [Zyxep/Mark]!",
    "[", "]",
    "/"
);
```

@return string

```php
final public static function endsWith( string $text, string $end, bool $ignoreCase = bool ): bool;
```

Check if a string ends with a given string

```php
use Phalcon\Helper\Str;

echo Str::endsWith("Hello", "llo");          // true
echo Str::endsWith("Hello", "LLO", false);   // false
echo Str::endsWith("Hello", "LLO");          // true
```

@return bool

```php
final public static function firstBetween( string $text, string $start, string $end ): string;
```

Returns the first string there is between the strings from the parameter start and end.

@return string

```php
final public static function humanize( string $text ): string;
```

Makes an underscored or dashed phrase human-readable

```php
use Phalcon\Helper\Str;

echo Str::humanize("start-a-horse"); // "start a horse"
echo Str::humanize("five_cats");     // "five cats"
```

@return string

```php
final public static function includes( string $needle, string $haystack ): bool;
```

Lets you determine whether or not a string includes another string.

@return bool

```php
final public static function increment( string $text, string $separator = string ): string;
```

Adds a number to a string or increment that number if it already is defined

```php
use Phalcon\Helper\Str;

echo Str::increment("a");    // "a_1"
echo Str::increment("a_1");  // "a_2"
```

@return string

```php
final public static function isAnagram( string $first, string $second ): bool;
```

Compare two strings and returns true if both strings are anagram, false otherwise.

@return bool

```php
final public static function isLower( string $text, string $encoding = string ): bool;
```

Returns true if the given string is lower case, false otherwise.

@return bool

```php
final public static function isPalindrome( string $text ): bool;
```

Returns true if the given string is a palindrome, false otherwise.

@return bool

```php
final public static function isUpper( string $text, string $encoding = string ): bool;
```

Returns true if the given string is upper case, false otherwise.

@return bool

```php
final public static function lower( string $text, string $encoding = string ): string;
```

Lowercases a string, this function makes use of the mbstring extension if available

```php
echo Phalcon\Helper\Str::lower("HELLO"); // hello
```

@return string

```php
final public static function random( int $type = int, long $length = int ): string;
```

Generates a random string based on the given type. Type is one of the RANDOM_* constants

```php
use Phalcon\Helper\Str;

echo Str::random(Str::RANDOM_ALNUM); // "aloiwkqz"
```

@return string

```php
final public static function reduceSlashes( string $text ): string;
```

Reduces multiple slashes in a string to single slashes

```php
// foo/bar/baz
echo Phalcon\Helper\Str::reduceSlashes("foo//bar/baz");

// http://foo.bar/baz/buz
echo Phalcon\Helper\Str::reduceSlashes("http://foo.bar///baz/buz");
```

@return string

```php
final public static function startsWith( string $text, string $start, bool $ignoreCase = bool ): bool;
```

Check if a string starts with a given string

```php
use Phalcon\Helper\Str;

echo Str::startsWith("Hello", "He");         // true
echo Str::startsWith("Hello", "he", false);  // false
echo Str::startsWith("Hello", "he");         // true
```

@return bool

```php
final public static function uncamelize( string $text, mixed $delimiter = null ): string;
```

Uncamelize strings which are camelized

```php
use Phalcon\Helper\Str;

echo Str::uncamelize("CocoBongo");       // coco_bongo
echo Str::uncamelize("CocoBongo", "-");  // coco-bongo
```

@return string

```php
final public static function underscore( string $text ): string;
```

Makes a phrase underscored instead of spaced

```php
use Phalcon\Helper\Str;

echo Str::underscore("look behind");     // "look_behind"
echo Str::underscore("Awesome Phalcon"); // "Awesome_Phalcon"
```

@return string

```php
final public static function upper( string $text, string $encoding = string ): string;
```

Uppercases a string, this function makes use of the mbstring extension if available

```php
echo Phalcon\Helper\Str::upper("hello"); // HELLO
```

@return string