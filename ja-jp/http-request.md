---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'HTTP Request (PSR-7)'
keywords: 'psr-7, http, http request'
---

# HTTP Request (PSR-7)

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## 概要

[Phalcon\Http\Message\Request](api/phalcon_http#http-message-request) is an implementation of the [PSR-7](https://www.php-fig.org/psr/psr-7/) HTTP messaging interface as defined by [PHP-FIG](https://www.php-fig.org/).

![](/assets/images/implements-psr--7-blue.svg)

This implementation has been created to establish a standard between middleware implementations. Applications often need to send requests to external endpoints. To achieve this you can use the [Phalcon\Http\Message\Request](api/phalcon_http#http-message-request) object. In return, our application will receive back a response object.

> **NOTE** Phalcon does not restrict you in using a specific HTTP Client. Any PSR-7 compliant client will work with this component so that you can perform your requests.
{: .alert .alert-info }

> 
> **NOTE**: In the examples below, `$httpClient` is the client of your choice which implements PSR-7. 
{: .alert .alert-info }

```php
<?php

use Phalcon\Http\Message\Request;
use Phalcon\Http\Message\Uri;

$request = new Request();
$uri     = new Uri('https://api.phalcon.io/companies/1');

$jwtToken = 'abc.def.ghi';

$request = $request
   ->withMethod('POST')
   ->withHeader('Authorization', 'Bearer ' . $jwtToken)
   ->withHeader('Content-Type', 'application/json')
;

$result = $httpClient->send($request);
```

We are creating a new [Phalcon\Http\Message\Request](api/phalcon_http#http-message-request) object and a new [Phalcon\Http\Message\Uri](api/phalcon_http#http-message-uri) object with the target URL. Following that we define the method (`POST`) and additional headers that we need to send with our request. The client then sends the request by using the request object.

The above example can be implemented by only using the constructor parameters:

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => 'application/json',
    ]
);

$result = $httpClient->send($request);
```

The [Request](api/phalcon_http#http-message-request) object created is immutable, meaning it will never change. Any call to methods prefixed with `with*` will return a clone of the object to maintain immutability, as per the standard.

## Constructor

```php
public function __construct(
    [string $method = "GET" 
    [, mixed $uri = null 
    [, mixed $body = "php://temp" 
    [, array $headers = [] ]]]]
)
```

The constructor accepts parameters allowing you to create the object with certain properties populated. You can define the target HTTP method, the URL, the body as well as the headers. All parameters are optional.

- `method` - defaults to `GET`. The supported methods are: `GET`, `CONNECT`, `DELETE`, `HEAD`, `OPTIONS`, `PATCH`, `POST`, `PUT`, `TRACE`
- `uri` - An instance of [Phalcon\Http\Message\Uri](api/phalcon_http#http-message-uri) or a URL.
- `body` - It defaults to `php://memory`. The method accepts either an object that implements the `StreamInterface` interface or a string such as the name of the stream. The default mode for the stream is `w+b`. If a non valid stream is passed, an [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) is thrown
- `headers` - A key value array, with key as the header name and value as the header value.

## Getters

### `getBody()`

Returns the body as a `StreamInterface` object

```php
<?php

use Phalcon\Http\Message\Request;
use Phalcon\Http\Message\Stream;

$jwtToken = 'abc.def.ghi';
$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
    $stream,
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => 'application/json',
    ]
);

echo $request->getBody(); // '/assets/stream/mit.txt'
```

### `getHeader()`

Returns an array of all the header values of the passed case insensitive header name. If the string parameter representing the header name requested is not present, an empty array is returned.

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => 'application/json',
    ]
);

echo $request->getHeader('content-Type'); // ['application/json']
echo $request->getHeader('unknown');      // []
```

### `getHeaderLine()`

Returns all of the header values of the given case-insensitive header name as a string concatenated together using a comma. If the string parameter representing the header name requested, an empty string is returned.

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
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

### `getHeaders()`

Returns an array with all the message header values. The keys represent the header name as it will be sent over the wire, and each value is an array of strings associated with the header. While header names are not case-sensitive, this method preserves the exact case in which headers were originally specified.

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
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

### `getMethod()`

Returns the method as a string

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => 'application/json',
    ]
);

echo $request->getMethod(); // POST
```

### `getProtocolVersion()`

Returns the protocol version as as string (default `1.1`)

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => 'application/json',
    ]
);

echo $request->getProtocolVersion(); // '1.1'
```

### `getRequestTarget()`

Returns a string representing the message's request-target either as it will appear (for clients), as it appeared at request (for servers), or as it was specified for the instance (see `withRequestTarget()`). In most cases, this will be the origin-form of the composed URI, unless a value was provided to the concrete implementation (see `withRequestTarget()`).

```php
<?php

use Phalcon\Http\Message\Request;

$request = new Request();
$request = $request->withRequestTarget('/test');

echo $request->getRequestTarget(); // '/test'
```

### `getUri()`

Returns the Uri as a `UriInterface` object

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => 'application/json',
    ]
);

echo $request->getUri(); // UriInterface : https://api.phalcon.io/companies/1
```

## Existence

### `hasHeader()`

Checks if a header exists by the given case-insensitive name. Returns `true` if the header has been found, `false` otherwise

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
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

### `withAddedHeader()`

Returns an instance with an additional header appended with the given value. Existing values for the specified header will be maintained. The new value(s) will be appended to the existing list. If the header did not exist previously, it will be added. Throws [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) for invalid header names or values. The header values can be a string or an array of strings.

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
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

$clone = $request
    ->withAddedHeader(
        'Content-Type', 
        [
            'application/html'
        ]
    );

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

### `withBody()`

Returns an instance with the specified message body which implements `StreamInterface`. Throws [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) when the body is not valid.

```php
<?php

use Phalcon\Http\Message\Request;
use Phalcon\Http\Message\Stream;

$jwtToken = 'abc.def.ghi';
$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => 'application/json',
    ]
);

$clone = $request->withBody($stream);

echo $clone->getBody(); // '/assets/stream/mit.txt'
```

### `withHeader()`

Returns an instance with the provided value replacing the specified header. While header names are case-insensitive, the casing of the header will be preserved by this function, and returned from `getHeaders()`. Throws [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) for invalid header names or values.

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
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

### `withMethod()`

Return an instance with the provided HTTP method as a string. Throws [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) for invalid HTTP methods.

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
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

### `withProtocolVersion()`

Returns an instance with the specified HTTP protocol version (as string).

```php
<?php

use Phalcon\Http\Message\Request;

$request  = new Request();

echo $request->getProtocolVersion(); // '1.1'

$clone = $request->withProtocolVersion('2.0');

echo $clone->getProtocolVersion(); // '2.0'
```

### `withRequestTarget()`

Returns an instance with the specific request-target.

```php
<?php

use Phalcon\Http\Message\Request;

$request = new Request();

echo $request->getRequestTarget(); // "/"

$clone = $request->withRequestTarget('/test');

echo $clone->getRequestTarget(); // '/test'
```

### `withUri()`

Returns an instance with the provided `UriInterface` URI. This method updates the `Host` header of the returned request by default if the URI contains a host component. If the URI does not contain a host component, any pre-existing Host header will be carried over to the returned request.

You can opt-in to preserving the original state of the Host header by setting `$preserveHost` to `true`. When `$preserveHost` is set to `true`, this method interacts with the Host header in the following ways:

- If the Host header is missing or empty, and the new URI contains a host component, this method will update the `Host` header in the returned request.
- If the Host header is missing or empty, and the new URI does not contain a host component, this method will not update the `Host` header in the returned request.
- If a Host header is present and non-empty, this method will not update the `Host` header in the returned request.

```php
<?php

use Phalcon\Http\Message\Request;

$query   = 'https://phalcon.io';
$uri     = new Uri($query);
$request = new Request();

$clone = $request->withUri($uri);

echo $clone->getRequestTarget(); // 'https://phalcon.io'
```

### `withoutHeader()`

Return an instance without the specified header.

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
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