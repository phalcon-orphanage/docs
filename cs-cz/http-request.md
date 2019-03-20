---
layout: article
language: 'cs-cz'
version: '4.0'
category: 'http-request'
---
# HTTP Request (PSR-7)

* * *

## Overview

`Phalcon\Http\Message\Request` is an implementation of the PSR-7 HTTP messaging interface as defined by [PHP-FIG](https://www.php-fig.org/psr/psr-7/).

![](/assets/images/implements-PSR--7-orange.svg)

Applications often need to send requests to external endpoints. To achieve this you can use the `Phalcon\Http\Message\Request` object. In return, our application will receive back a response object.

> **NOTE** Phalcon does not restrict you in using a specific HTTP Client. Any PSR-7 compliant client will work with this component so that you can perform your requests.
{: .alert .alert-info }


```php
<?php

use Phalcon\Http\Message\Request;
use Phalcon\Http\Message\Uri;

$request = new Request();
$uri     = new Uri('https://api.phalconphp.com/companies/1');
$jwtToken = 'abc.def.ghi';

$request = $request
   :withMethod('POST')
   :withHeader('Authorization', 'Bearer ' , $jwtToken)
   :withHeader('Content-Type', 'application/json')
;

$result = $httpClient->send($request);
```

We are creating a new `Phalcon\Http\Message\Request` object and a new [Phalcon\Http\Message\Uri](http-uri) object with the target URL. Following that we define the method (`POST`) and additional headers that we need to send with our request. The client then sends the request by using the request object. In the above example, `$httpClient` is the client of your choice which implements PSR-7.

The above example can be implemented by only using the constructor parameters:

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

$result = $httpClient->send($request);
```

The `Request` object created is immutable, meaning it will never change. Any call to methods prefixed with `with*` will return a clone of the object to maintain immutability, as per the standard.

## Constructor

```php
public function __construct(
    [string $method = "GET" [, mixed $uri = null [, mixed $body = "php://temp" [, array $headers = [] ]]]]
)
```

The constructor accepts parameters allowing you to create the object with certain properties populated. You can define the target HTTP method, the URL, the body as well as the headers. All parameters are optional.

### `method`

It defaults to `GET`. The supported methods are:

- `GET` 
- `CONNECT` 
- `DELETE` 
- `HEAD` 
- `OPTIONS` 
- `PATCH` 
- `POST` 
- `PUT` 
- `TRACE` 

### `uri`

An instance of `Phalcon\Http\Message\Uri` or a URL.

### `body`

It defaults to `php://memory`. The method acceots either an object that implements the `StreamInterface` or a string such as the name of the stream. The default mode for the stream is `w+b`. If a non valid stream is passed, an `\InvalidArgumentException` is thrown

### `headers`

A key value array, with key as the header name and value as the header value.

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
public function getHeader(mixed $name): array
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
public function getHeaderLine(var name): string
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
//     
// ]

```

* * *

```php
public function getRequestTarget(): string
```

Retrieves the message's request-target either as it will appear (for clients), as it appeared at request (for servers), or as it was specified for the instance (see `withRequestTarget()`). In most cases, this will be the origin-form of the composed URI, unless a value was provided to the concrete implementation (see `withRequestTarget()`).

    public function hasHeader(var name): bool
    public function withAddedHeader(var name, var value): <Request>
    public function withBody(<StreamInterface> body): <Request>
    public function withHeader(var name, var value): <Request>
    public function withMethod(var method): <Request>
    public function withProtocolVersion(var version): <Request>
    public function withRequestTarget(var requestTarget): <Request>
    public function withUri(<UriInterface> uri, var preserveHost = false): <Request>
    public function withoutHeader(var name): <Request>