---
layout: default
language: 'de-de'
version: '4.0'
category: 'http-request'
---

# HTTP Request (PSR-7)

* * *

## Overview

`Phalcon\Http\Message\Request` is an implementation of the PSR-7 HTTP messaging interface as defined by [PHP-FIG](https://www.php-fig.org/psr/psr-7/).

![](/assets/images/implements-psr--7-blue.svg) ![](/assets/images/implements-psr--17-blue.svg)

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
   ->withMethod('POST')
   ->withHeader('Authorization', 'Bearer ' . $jwtToken)
   ->withHeader('Content-Type', 'application/json')
;

$result = $httpClient->send($request);
```

We are creating a new `Phalcon\Http\Message\Request` object and a new [Phalcon\Http\Message\Uri](http-uri) object with the target URL. Following that we define the method (`POST`) and additional headers that we need to send with our request. The client then sends the request by using the request object. In the above example, `$httpClient` is the client of your choice which implements PSR-7.

The above example can be implemented by only using the constructor parameters:

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
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

It defaults to `php://memory`. The method accepts either an object that implements the `StreamInterface` or a string such as the name of the stream. The default mode for the stream is `w+b`. If a non valid stream is passed, an `\InvalidArgumentException` is thrown

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

$request = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    $stream,
    [
        'Authorization' => 'Bearer ' . $jwtToken,
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

$request = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
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

$request = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
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

$request = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
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

$request = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
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

$request = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
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

$request = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => [
            'application/json',
            'application/html',
        ],
    ]
);

var_dump(
    $request->getHeaders()
);
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

$request = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => [
            'application/json',
            'application/html',
        ],
    ]
);

var_dump(
    $request->getHeaders()
);
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

$request = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => [
            'application/json',
            'application/html',
        ],
    ]
);

echo $request->hasHeader('content-type'); // true
```

## With

The Request object is immutable. However there are a number of methods that allow you to inject data into it. The returned object is a clone of the original one.

```php
public function withAddedHeader( string $name, string|string[] $value ): Request
```

Returns an instance with the specified header appended with the given value. Existing values for the specified header will be maintained. The new value(s) will be appended to the existing list. If the header did not exist previously, it will be added. Throws `\InvalidArgumentException` for invalid header names or values.

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => [
            'application/json',
        ],
    ]
);

var_dump(
    $request->getHeaders()
);
// [
//     'Authorization' => 'Bearer abc.def.ghi',
//     'Content-Type'  => [
//         'application/json',
//     ],
// ]

$clone = $request->withAddedHeader('Content-Type', ['application/html']);

var_dump(
    $clone->getHeaders()
);
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
public function withBody( StreamInterface body ): Request
```

Returns an instance with the specified message body. Throws `\InvalidArgumentException` when the body is not valid.

```php
<?php

use Phalcon\Http\Message\Request;
use Phalcon\Http\Message\Stream;

$jwtToken = 'abc.def.ghi';
$fileName = dataFolder('/assets/stream/bill-of-rights.txt');
$stream   = new Stream($fileName, 'rb');

$request = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => 'application/json',
    ]
);

$clone = $request->withBody($stream);

echo $clone->getBody(); // '/assets/stream/bill-of-rights.txt'
```

* * *

```php
public function withHeader(var name, var value): Request
```

Returns an instance with the provided value replacing the specified header. While header names are case-insensitive, the casing of the header will be preserved by this function, and returned from `getHeaders()`. Throws `\InvalidArgumentException` for invalid header names or values.

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
    ]
);

var_dump(
    $request->getHeaders()
);
// [
//     'Authorization' => 'Bearer abc.def.ghi',
// ]

$clone = $request->withAddedHeader(
    'Content-Type',
    [
        'application/html',
    ]
);

var_dump(
    $clone->getHeaders()
);
// [
//     'Authorization' => 'Bearer abc.def.ghi',
//     'Content-Type'  => [
//         'application/html',
//     ],
// ]
```

* * *

```php
public function withMethod( string $method ): Request
```

Return an instance with the provided HTTP method. Throws `\InvalidArgumentException` for invalid HTTP methods.

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => 'application/json',
    ]
);

echo $request->getMethod(); // POST

$clone = $request->withMethod('GET');

echo $clone->getMethod(); // GET
```

* * *

```php
public function withProtocolVersion( string $version ): Request
```

Returns an instance with the specified HTTP protocol version.

```php
<?php

use Phalcon\Http\Message\Request;

$request  = new Request();

echo $request->getProtocolVersion(); // '1.1'

$clone = $request->withProtocolVersion('2.0');

echo $clone->getProtocolVersion(); // '2.0'
```

* * *

```php
public function withRequestTarget( mixed $requestTarget ): Request
```

Returns an instance with the specific request-target.

```php
<?php

use Phalcon\Http\Message\Request;

$request = new Request();

echo $request->getRequestTarget(); // "/"

$clone = $request->withRequestTarget('/test');

echo $clone->getRequestTarget(); // '/test'
```

* * *

```php
public function withUri( UriInterface $uri, bool $preserveHost = false ): Request
```

Returns an instance with the provided URI. This method updates the Host header of the returned request by default if the URI contains a host component. If the URI does not contain a host component, any pre-existing Host header will be carried over to the returned request.

You can opt-in to preserving the original state of the Host header by setting `$preserveHost` to `true`. When `$preserveHost` is set to `true`, this method interacts with the Host header in the following ways:

- If the Host header is missing or empty, and the new URI contains a host component, this method MUST update the Host header in the returned request.
- If the Host header is missing or empty, and the new URI does not contain a host component, this method MUST NOT update the Host header in the returned request.
- If a Host header is present and non-empty, this method will not update the Host header in the returned request.

```php
<?php

use Phalcon\Http\Message\Request;

$query   = 'https://phalconphp.com';
$uri     = new Uri($query);
$request = new Request();

$clone = $request->withUri($uri);

echo $clone->getRequestTarget(); // 'https://phalconphp.com'
```

* * *

```php
public function withoutHeader( string $name ): Request
```

Return an instance without the specified header.

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => [
            'application/json',
        ],
    ]
);

var_dump(
    $request->getHeaders()
);
// [
//     'Authorization' => 'Bearer abc.def.ghi',
//     'Content-Type'  => [
//         'application/json',
//     ],
// ]

$clone = $request->withoutHeader('Content-Type');

var_dump(
    $clone->getHeaders()
);
// [
//     'Authorization' => 'Bearer abc.def.ghi',
// ]
```