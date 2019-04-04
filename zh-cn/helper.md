---
layout: default
language: 'en'
version: '4.0'
upgrade: ''
category: 'collection'
---
# Helper Component
<hr/>

## Overview
`Phalcon\Helper` a component exposing helper classes and static methods used throughout the framework. 

## Arr
This class exposes static methods that offer quick access to common functionality when working with arrays.

### get
Retrieves an element from an array. If the element exists its value is returned. If not, the `defaultValue` is returned.

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

echo Arr::get($data, 'year');          // 1776
echo Arr::get($data, 'unknown', 1776); // 1776
```

### has
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

## Number
This class exposes static methods that offer quick access to common functionality when working with numbers.

### between
Checks if the passed value is between the range specified in `from` and `to`

```php
<?php

use Phalcon\Helper\Number;

$min = 10;
$max = 100;
$value = 13;

echo Number::between($value, $min, $max);   // true

$value = 2;
echo Number::between($value, $min, $max);   // false
```
