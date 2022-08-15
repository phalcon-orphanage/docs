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
// ];
```

`chunk(array $collection, int $size, bool $preserveKeys = false): array`

`first(array $collection, callable $method = null): mixed`

`firstKey(array $collection, callable $method = null): mixed`

`flatten(array $collection, bool $deep = false): array`

`get(array $collection, $index, $defaultValue = null, string $cast = null): mixed`

`group(array $collection, $method): array`

`has(array $collection, $index): bool`

`isUnique(array $collection): bool`

`last(array $collection, callable $method = null): mixed`

`lastKey(array $collection, callable $method = null): mixed`

`order(array $collection, $attribute, string $order = 'asc'): array`

`pluck(array $collection, string $element): array`

`set(array $collection, $value, $index = null): array`

`sliceLeft(array $collection, int $elements = 1): array`

`sliceRight(array $collection, int $elements = 1): array`

`split(array $collection): array`

`toObject(array $collection): object`

`validateAll(array $collection, callable $method): bool`

`validateAny(array $collection, callable $method): bool`

`whitelist(array $collection, array $whiteList): array`

`basename(string $uri, string $suffix = null): string`

`decode(string $data, bool $associative = false, int $depth = 512, int $options = 0): string`

`encode($data, int $options = 0, int $depth = 512): string`

`between(int $value, int $start, int $end): bool`

`camelize(string $text, string $delimiters = null, bool $lowerFirst = false): string`

`concat(string $delimiter, string $first, string $second, string ...$arguments): string`

`countVowels(string $text): int`

`decapitalize(string $text, bool $upperRest = false, string $encoding = 'UTF-8'): string`

`decrement(string $text, string $separator = '_'): string`

`dirFromFile(string $file): string`

`dirSeparator(string $directory): string`

`endsWith(string $haystack, string $needle, bool $ignoreCase = true): bool`

`firstBetween(string $text, string $start, string $end): string`

`friendly(string $text, string $separator = '-', bool $lowercase = true, $replace = null): string`

`humanize(string $text): string`

`includes(string $haystack, string $needle): bool`

`increment(string $text, string $separator = '_'): string`

`isAnagram(string $first, string $second): bool`

`isLower(string $text, string $encoding = 'UTF-8'): bool`

`isPalindrome(string $text): bool`

`isUpper(string $text, string $encoding = 'UTF-8'): bool`

`kebabCase(string $text, string $delimiters = null): string`

`len(string $text, string $encoding = 'UTF-8'): int`

`lower(string $text, string $encoding = 'UTF-8'): string`

`pascalCase(string $text, string $delimiters = null): string`

`prefix($text, string $prefix): string`

`random(int $type = 0, int $length = 8): string`

`reduceSlashes(string $text): string`

`startsWith(string $haystack, string $needle, bool $ignoreCase = true): bool`

`snakeCase(string $text, string $delimiters = null): string`

`suffix($text, string $suffix): string`

`ucwords(string $text, string $encoding = 'UTF-8'): string`

`uncamelize(string $text, string $delimiters = '_'): string`

`underscore(string $text): string`

`upper(string $text, string $encoding = 'UTF-8'): string`




[support-helper]: api/phalcon_support#support-helperfactory
