---
layout: default
language: 'tr-tr'
version: '4.0'
category: 'http-request'
---
# HTTP Request (PSR-7)

* * *

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
$request  = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' , $jwtToken,
        'Content-Type'  => [
            'application/json',
        ],
    ]
);

var_dump($request-getHeaders());
// [
//     'Authorization' => 'Bearer abc.def.ghi',
//     'Content-Type'  => [
//         'application/json',
//     ],
// ]

$clone = $request->withAddedHeader('Content-Type', ['application/html']);

var_dump($clone-getHeaders());
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

$request  = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' , $jwtToken,
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

Returns an instance with the provided value replacing the specified header. While header names are case-insensitive, the casing of the header will be preserved by this function, and returned from getHeaders(). Throws `\InvalidArgumentException` for invalid header names or values.

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
    ]
);

var_dump($request-getHeaders());
// [
//     'Authorization' => 'Bearer abc.def.ghi',
// ]

$clone = $request->withAddedHeader('Content-Type', ['application/html']);

var_dump($clone-getHeaders());
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

echo $clone->getProtocolVersion();   // '2.0'
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

echo $clone->getRequestTarget();   // '/test'
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

echo $clone->getRequestTarget();   // 'https://phalconphp.com'
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
$request  = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' , $jwtToken,
        'Content-Type'  => [
            'application/json',
        ],
    ]
);

var_dump($request-getHeaders());
// [
//     'Authorization' => 'Bearer abc.def.ghi',
//     'Content-Type'  => [
//         'application/json',
//     ],
// ]

$clone = $request->withoutHeader('Content-Type');

var_dump($clone-getHeaders());
// [
//     'Authorization' => 'Bearer abc.def.ghi',
// ]
```