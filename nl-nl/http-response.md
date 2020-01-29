---
layout: default
language: 'nl-nl'
version: '4.0'
title: 'HTTP Response (PSR-7)'
keywords: 'psr-7, http, http response'
---

# HTTP Response (PSR-7)
<hr />
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview
[Phalcon\Http\Message\Response](api/phalcon_http#http-message-response) is an implementation of the [PSR-7](https://www.php-fig.org/psr/psr-7/) HTTP messaging interface as defined by [PHP-FIG](https://www.php-fig.org/).

![](/assets/images/implements-psr--7-blue.svg)

[Phalcon\Http\Message\Response](api/phalcon_http#http-message-response) is a representation of an outgoing, server-side response. As per the HTTP specification, this interface includes properties for each of the following:
 - Protocol version
 - Status code and reason phrase
 - Headers
 - Message body

> **NOTE**: In the examples below, `$httpClient` is the client of your choice which implements PSR-7. 
> 
> {: .alert .alert-info }

```php
<?php

use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$response = new Response();

$payload = [
    'code'   => 2000,
    'status' => 'success',
    'payload' => [
        'id'   => 12345,
        'name' => 'John Doe',
    ]
];

$stream = new Stream('php://memory', 'wb');
$stream->write(json_encode($payload));

$response = $response
    ->withHeader('Content-Type', 'application/json')
    ->withBody($stream)
    ->withStatusCode(200)
;

$result = $httpClient->send($response);


$payload = 'The above copyright notice and this permission '
         . 'notice shall be included in all copies or '
         . 'substantial portions of the Software.'
;

$response = $response
    ->withHeader('Content-Type', 'text/html')
    ->withBody($payload)
    ->withStatusCode(200)
;

$result = $httpClient->send($response);
```

We are creating a new [Phalcon\Http\Message\Response](api/phalcon_http#http-message-response) object with a payload represented as JSON, the necessary headers and the status code. The client then sends the response back using the request object.

The above example can be implemented by only using the constructor parameters:

```php
<?php

use Phalcon\Http\Message\Response;

$payload = [
    'code'   => 2000,
    'status' => 'success',
    'payload' => [
        'id'   => 12345,
        'name' => 'John Doe',
    ]
];


$request = new Response(
    json_encode($payload),
    200,
    [
        'Content-Type'  => 'application/json',
    ]
);

$result = $httpClient->send($request);
```

The [Response](api/phalcon_http#http-message-response) object created is immutable, meaning it will never change. Any call to methods prefixed with `with*` will return a clone of the object to maintain immutability, as per the standard.

## Constructor

```php
public function __construct(
    [mixed $body = "php://temp" 
    [, int $code = 200 
    [, array $headers = [] ]]]
)
```
The constructor accepts parameters allowing you to create the object with certain properties populated. You can define the body, status code as well as the headers. All parameters are optional.

- `body` - It defaults to `php://memory`. The method accepts either an object that implements the `StreamInterface` interface or a string such as the name of the stream. The default mode for the stream is `w+b`. If a non valid stream is passed, an [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) is thrown
- `code`  - An integer representing the status code for the response. It defaults to `200`.
- `headers`  - A key value array, with key as the header name and value as the header value.

## Getters

### `getBody()`

Returns the body as a `StreamInterface` object. This method is useful also when in need to quickly adjust the body of the message. You can check the methods you can call by checking the [Phalcon\Http\Message\Stream](http-stream) class.

```php
<?php

use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$response = new Response($stream);

echo $response->getBody(); // '/assets/stream/mit.txt'


$response->getBody()->write('additional content goes here');
```

To get all the contents of the stream:

```php
<?php

use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$response = new Response($stream);

$body = $response->getBody();
$body->rewind()

$text = $body->getContents();
```

### `getHeader()`

Returns an array of all the header values of the passed case insensitive header name. If the string parameter representing the header name requested is not present, an empty array is returned.

```php
<?php

use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$response = new Response(
    $stream,
    200,
    [
        'Content-Type'  => 'application/json',
    ]
);

echo $response->getHeader('content-Type'); // ['application/json']
echo $response->getHeader('unknown');      // []
```

### `getHeaderLine()`

Returns all of the header values of the given case-insensitive header name as a string concatenated together using a comma. If the string parameter representing the header name requested, an empty string is returned.

```php
<?php

use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$response = new Response(
    $stream,
    200,
    [
        'Content-Type'  => [
            'application/json',
            'application/html',
        ],
    ]
);

echo $response->getHeaderLine('content-Type'); // 'application/json,application/html'
```

### `getHeaders()`

Returns an array with all the message header values. The keys represent the header name as it will be sent over the wire, and each value is an array of strings associated with the header. While header names are not case-sensitive, this method preserves the exact case in which headers were originally specified.

```php
<?php

use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$response = new Response(
    $stream,
    200,
    [
        'Content-Type'  => [
            'application/json',
            'application/html',
        ],
    ]
);

var_dump(
    $response->getHeaders()
);
// [
//     'Content-Type'  => [
//         'application/json',
//         'application/html',
//     ],
// ]
```

### `getProtocolVersion()`

Returns the protocol version as as string (default `1.1`)

```php
<?php


use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$response = new Response(
    $stream,
    200,
    [
        'Content-Type'  => 'application/json',
    ]
);


echo $response->getProtocolVersion(); // '1.1'
```

### `getReasonPhrase()`

Returns the response reason phrase associated with the status code. Because a reason phrase is not a required element in a response status line, the reason phrase value may be empty. The return string comes from the IANA HTTP Status Code Registry, as defined in the [RFC 7231](https://tools.ietf.org/html/rfc7231#section-6).

```php
<?php


use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$response = new Response(
    $stream,
    203,
    [
        'Content-Type'  => 'application/json',
    ]
);


echo $response->getReasonPhrase(); // 'Non-Authoritative Information'
```

### `getStatusCode()`

Returns the response status code. The status code is a 3-digit integer result code of the server's attempt to understand and satisfy the request.

```php
<?php

use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$response = new Response(
    $stream,
    203,
    [
        'Content-Type'  => 'application/json',
    ]
);


echo $response->getStatusCode(); // 203
```

### `getUri()`

Returns the Uri as a `UriInterface` object

```php
<?php

use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$response = new Response(
    $stream,
    200,
    [
        'Content-Type'  => 'application/json',
    ]
);

$response = $response->withUri('https://api.phalcon.io/companies/1');

echo $response->getUri(); // UriInterface : https://api.phalcon.io/companies/1
```

## Existence

### `hasHeader()`

Checks if a header exists by the given case-insensitive name. Returns `true` if the header has been found, `false` otherwise

```php
<?php

use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$response = new Response(
    $stream,
    200,
    [
        'Content-Type'  => [
            'application/json',
            'application/html',
        ],
    ]
);

echo $response->hasHeader('content-type'); // true
```

## With
The Request object is immutable. However there are a number of methods that allow you to inject data into it. The returned object is a clone of the original one.

### `withAddedHeader()`

Returns an instance with an additional header appended with the given value. Existing values for the specified header will be maintained. The new value(s) will be appended to the existing list. If the header did not exist previously, it will be added. Throws [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) for invalid header names or values. The header values can be a string or an array of strings.

```php
<?php

use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$jwtToken = 'abc.def.ghi';
$response = new Response(
    $stream,
    200,
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => [
            'application/json',
        ],
    ]
);

var_dump(
    $response->getHeaders()
);
// [
//     'Authorization' => 'Bearer abc.def.ghi',
//     'Content-Type'  => [
//         'application/json',
//     ],
// ]

$clone = $response->withAddedHeader('Content-Type', ['application/html']);

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

use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$jwtToken = 'abc.def.ghi';
$response = new Response(
    null,
    200,
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => 'application/json',
    ]
);

$clone = $response->withBody($stream);

echo $clone->getBody(); // '/assets/stream/mit.txt'
```

### `withHeader()`

Returns an instance with the provided value replacing the specified header. While header names are case-insensitive, the casing of the header will be preserved by this function, and returned from `getHeaders()`. Throws [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) for invalid header names or values.

```php
<?php

use Phalcon\Http\Message\Response;

$jwtToken = 'abc.def.ghi';
$response = new Response(
    null,
    200,
    [
        'Authorization' => 'Bearer ' . $jwtToken,
    ]
);

var_dump(
    $response->getHeaders()
);
// [
//     'Authorization' => 'Bearer abc.def.ghi',
// ]

$clone = $response->withAddedHeader(
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

### `withProtocolVersion()`

Returns an instance with the specified HTTP protocol version (as string).

```php
<?php

use Phalcon\Http\Message\Response;

$response  = new Request();

echo $response->getProtocolVersion(); // '1.1'

$clone = $response->withProtocolVersion('2.0');

echo $clone->getProtocolVersion(); // '2.0'
```

### `withStatus()`

Return an instance with the specified status code and, optionally, reason phrase. If no reason is defined, the reason string will come from the IANA HTTP Status Code Registry, as defined in the [RFC 7231](https://tools.ietf.org/html/rfc7231#section-6).

```php
<?php

use Phalcon\Http\Message\Response;

$response  = new Request();

echo $response->getStatusCode();   // 200
echo $response->getReasonPhrase(); // OK

$clone = $response->withStatus(203, 'Something Else');

echo $response->getStatusCode();   // 203
echo $response->getReasonPhrase(); // 'Something Else'
```

### `withUri()`

Returns an instance with the provided `UriInterface` URI. This method updates the `Host` header of the returned request by default if the URI contains a host component. If the URI does not contain a host component, any pre-existing Host header will be carried over to the returned request.

You can opt-in to preserving the original state of the Host header by setting `$preserveHost` to `true`. When `$preserveHost` is set to `true`, this method interacts with the Host header in the following ways:

- If the Host header is missing or empty, and the new URI contains a host component, this method will update the `Host` header in the returned request.
- If the Host header is missing or empty, and the new URI does not contain a host component, this method will not update the `Host` header in the returned request.
- If a Host header is present and non-empty, this method will not update the `Host` header in the returned request.

```php
<?php

use Phalcon\Http\Message\Response;

$query   = 'https://phalcon.io';
$uri     = new Uri($query);
$request = new Response();

$clone = $request->withUri($uri);

echo $clone->getUri(); // UriInterface: 'https://phalcon.io'
```

### `withoutHeader()`

Return an instance without the specified header.

```php
<?php

use Phalcon\Http\Message\Response;

$jwtToken = 'abc.def.ghi';

$response = new Response(
    null,
    200,
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => [
            'application/json',
        ],
    ]
);

var_dump(
    $response->getHeaders()
);
// [
//     'Authorization' => 'Bearer abc.def.ghi',
//     'Content-Type'  => [
//         'application/json',
//     ],
// ]

$clone = $response->withoutHeader('Content-Type');

var_dump(
    $clone->getHeaders()
);
// [
//     'Authorization' => 'Bearer abc.def.ghi',
// ]
```
