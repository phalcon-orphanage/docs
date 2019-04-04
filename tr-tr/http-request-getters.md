---
layout: default
language: 'tr-tr'
version: '4.0'
category: 'http-request'
---
# HTTP Request (PSR-7)

* * *

## Getters

There are several getters for the object.

```php
public function getBody(): StreamInterface
```

Returns the body

```php
<?php

use Phalcon\Http\Message\Request;
use Phalcon\Http\Message\Stream;

$jwtToken = 'abc.def.ghi';
$fileName = dataFolder('/assets/stream/bill-of-rights.txt');
$stream   = new Stream($fileName, 'rb');

$request  = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    $stream,
    [
        'Authorization' => 'Bearer ' , $jwtToken,
        'Content-Type'  => 'application/json',

    ]
);

echo $request->getBody(); // '/assets/stream/bill-of-rights.txt'
```

* * *

```php
public function getMethod(): string
```

Returns the method

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';
$request  = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' , $jwtToken,
        'Content-Type'  => 'application/json',

    ]
);

echo $request->getMethod(); // POST
```

* * *

```php
public function getProtocolVersion(): string
```

Returns the protocol version (default `1.1`)

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';
$request  = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' , $jwtToken,
        'Content-Type'  => 'application/json',

    ]
);

echo $request->getProtocolVersion(); // '1.1'
```

* * *

```php
public function getUri(): UriInterface
```

Returns the Uri

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';
$request  = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' , $jwtToken,
        'Content-Type'  => 'application/json',

    ]
);

echo $request->getUri(); // UriInterface : https://api.phalconphp.com/companies/1
```

* * *

```php
public function getHeader( mixed $name ): array
```

Returns an array of all the header values of the passed case insensitive header name. If the header is not present, an empty array is returned.

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';
$request  = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' , $jwtToken,
        'Content-Type'  => 'application/json',

    ]
);

echo $request->getHeader('content-Type'); // ['application/json']
echo $request->getHeader('unknown');      // []
```

* * *

```php
public function getHeaderLine( mixed $name ): string
```

Returns all of the header values of the given case-insensitive header name as a string concatenated together using a comma. If the header does not appear in the message, an empty string is returned.

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';
$request  = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' , $jwtToken,
        'Content-Type'  => [
            'application/json',
            'application/html',
        ],

    ]
);

echo $request->getHeaderLine('content-Type'); // 'application/json,application/html'
```

* * *

```php
public function getHeaders(): array
```

Returns all the message header values. The keys represent the header name as it will be sent over the wire, and each value is an array of strings associated with the header. While header names are not case-sensitive, this method preserves the exact case in which headers were originally specified.

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';
$request  = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' , $jwtToken,
        'Content-Type'  => [
            'application/json',
            'application/html',
        ],

    ]
);

var_dump($request-getHeaders());
// [
//     'Authorization' => 'Bearer abc.def.ghi',
//     'Content-Type'  => [
//         'application/json',
//         'application/html',
//     ],
// ]

```

* * *

```php
public function getRequestTarget(): string
```

Retrieves the message's request-target either as it will appear (for clients), as it appeared at request (for servers), or as it was specified for the instance (see `withRequestTarget()`). In most cases, this will be the origin-form of the composed URI, unless a value was provided to the concrete implementation (see `withRequestTarget()`).

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';
$request  = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' , $jwtToken,
        'Content-Type'  => [
            'application/json',
            'application/html',
        ],

    ]
);

var_dump($request-getHeaders());
// [
//     'Authorization' => 'Bearer abc.def.ghi',
//     'Content-Type'  => [
//         'application/json',
//         'application/html',
//     ],
// ]

```

* * *

```php
public function hasHeader( mixed name ): bool
```

Checks if a header exists by the given case-insensitive name. Returns `true` if the header has been found, `false` otherwise

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';
$request  = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' , $jwtToken,
        'Content-Type'  => [
            'application/json',
            'application/html',
        ],

    ]
);

echo $request->hasHeader('content-type'); // true
```