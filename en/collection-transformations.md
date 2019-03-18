---
layout: article
language: 'en'
version: '4.0'
upgrade: ''
category: 'collection'
---
### Transformations
`Phalcon\Collection` also exposes two transformation methods: `toArray()` and `toJson(int $options)`. `toArray()` returns the object transformed as an array. This method returns the same array as `jsonSerialize()`.

	 
```php
<?php

use Phalcon\Collection;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Collection($data);

echo $collection->toArray();  // $data
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

use Phalcon\Collection;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Collection($data);

echo $collection->toJson();    // ["red","white","blue"],"year":1776}

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