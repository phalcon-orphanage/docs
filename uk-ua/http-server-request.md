---
layout: default
language: 'uk-ua'
version: '4.0'
title: 'HTTP Server Request (PSR-7)'
keywords: 'psr-7, http, http server request'
---

# HTTP Server Request (PSR-7)
<hr />
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview
[Phalcon\Http\Message\ServerRequest](api/phalcon_http#http-message-serverrequest) is an implementation of the [PSR-7](https://www.php-fig.org/psr/psr-7/) HTTP messaging interface as defined by [PHP-FIG](https://www.php-fig.org/).

![](/assets/images/implements-psr--7-blue.svg)

These interface implementations have been created to establish a standard between middleware implementations. Applications often need to receive data from external sources such as the users using the application. The [Phalcon\Http\Message\ServerRequest](api/phalcon_http#http-message-serverrequest) represents an incoming, server-side HTTP request. Per the HTTP specification, this interface includes properties for each of the following: These interface implementations have been created to establish a standard between middleware implementations. Applications often need to receive data from external sources such as the users using the application. The [Phalcon\Http\Message\ServerRequest](api/phalcon_http#http-message-serverrequest) represents an incoming, server-side HTTP request. Per the HTTP specification, this interface includes properties for each of the following:

- Headers
- HTTP method
- Message body
- Protocol version
- URI

Additionally, it encapsulates all data as it has arrived at the application from the CGI and/or PHP environment, including:

- The values represented in `$_SERVER`.
- Any cookies provided (generally via `$_COOKIE`)
- Query string arguments (generally via `$_GET`, or as parsed via [parse_str()](https://www.php.net/manual/en/function.parse-str.php))
- Upload files, if any (as represented by `$_FILES`)
- Unserialized body parameters (generally from `$_POST`)

`$_SERVER` values are treated as immutable, as they represent application state at the time of request; as such, no methods are provided to allow modification of those values. The other values provide such methods, as they can be restored from `$_SERVER` or the request body, and may need treatment during the application (e.g., body parameters may be unserialized based on content type).

Additionally, this interface recognizes the utility of introspecting a request to derive and match additional parameters (e.g., via URI path matching, decrypting cookie values, unserializing non-form-encoded body content, matching authorization headers to users, etc). These parameters are stored in an "attributes" property.

```php
<?php

use Phalcon\Http\Message\ServerRequest;
use Phalcon\Http\Message\Uri;

$request = new Request();
$uri     = new Uri('https://api.phalcon.io/companies/1');

$request = new ServerRequest();
$request = $request
    ->withHeader('Content-Type', ['application/json'])
    ->withMethod('GET')
    ->withProtocolVersion('1.1')
    ->withUploadedFiles($_FILES)
    ->withUri($uri)
;
```

We are creating a new [Phalcon\Http\Message\ServerRequest](api/phalcon_http#http-message-serverrequest) object and a new [Phalcon\Http\Message\Uri](api/phalcon_http#http-message-uri) object with the target URL. Following that we define the method (`GET`), a protocol version, uploaded files and additional headers.

The above example can be implemented by only using the constructor parameters:

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest(
    'GET',
    'https://api.phalcon.io/companies/1',
    $_SERVER,
    'php://input',
    [
        'Content-Type'  => 'application/json',
    ],
    $_COOKIE,
    $_GET,
    $_FILES,
    'some body',
    '1.2'
);
```

The [ServerRequest](api/phalcon_http#http-message-serverrequest) object created is immutable, meaning it will never change. Any call to methods prefixed with `with*` will return a clone of the object to maintain immutability, as per the standard.

## Constructor

```php
public function __construct(
    [string $method = "GET" 
    [, mixed $uri = null 
    [, array serverParams = [],
    [, mixed body = "php://input",
    [, mixed headers = [],
    [, array cookies = [],
    [, array queryParams = [],
    [, array uploadFiles = [],
    [, mixed parsedBody = null,
    [, string protocol = "1.1"]]]]]]]]]]
)
```
The constructor accepts parameters allowing you to create the object with certain properties populated. You can define the target HTTP method, the URL, the body as well as the headers. All parameters are optional.

- `method` - defaults to `GET`. The supported methods are: `GET`, `CONNECT`, `DELETE`, `HEAD`, `OPTIONS`, `PATCH`, `POST`, `PUT`, `TRACE`
- `uri` - An instance of [Phalcon\Http\Message\Uri](api/phalcon_http#http-message-uri) or a URL.
- `serverParams` - A key value array, with key as the server variable name and value as the server value
- `body` - It defaults to `php://input`. The method accepts either an object that implements the `StreamInterface` interface or a string such as the name of the stream. The default mode for the stream is `w+b`. If a non valid stream is passed, an [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) is thrown
- `headers` - A key value array, with key as the header name and value as the header value.
- `cookies` - A key value array, with key as the cookie name and value as the cookie value.
- `queryParams` - A key value array, with key as the query parameter name and value as the query parameter value.
- `uploadFiles` - An array of uploaded files (`$_FILES`)
- `parsedBody` - The parsed body of the server request
- `protocol` - A string representing the protocol (`1.0`, `1.1`)

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest(
    'GET',
    'https://api.phalcon.io/companies/1',
    $_SERVER,
    'php://input',
    [
        'Content-Type'  => 'application/json',
    ],
    $_COOKIE,
    $_GET,
    $_FILES,
    'some body',
    '1.2'
);
```

## Getters

### `getAttribute()`

Returns a single derived request attribute. The method gets a single attribute as produced by `getAttributes()`. The first parameter defines the name of the attribute that we need to retrieve. You can also supply a second variable which will be used as a default, in case the requested attribute name does not exist.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest();
$request = $request
    ->withAttribute('one', 'two')
;

echo $request->getAttribute('one');           // 'two'
echo $request->getAttribute('three', 'four'); // 'four'
```

### `getAttributes()`

Returns an array with all the attributes derived from the request. These request "attributes" may be used to allow injection of any parameters derived from the request: e.g., the results of path match operations; the results of decrypting cookies; the results of unserializing non-form-encoded message bodies; etc. Attributes will be application and request specific, and can be mutable.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest();
$request = $request
    ->withAttribute('one', 'two')
;

var_dump(
    $request->getAttributes()
);

// [
//     'one' => 'two',
// ]
```

### `getBody()`

Returns the body as a `StreamInterface` object

```php
<?php

use Phalcon\Http\Message\ServerRequest;
use Phalcon\Http\Message\Stream;

$jwtToken = 'abc.def.ghi';
$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$request = new ServerRequest('GET', null, [], $stream);

echo $request->getBody(); // '/assets/stream/mit.txt'
```

### `getCookieParams()`

Returns the cookies of the server request. The returned array is compatible with the structure of the `$_COOKIE` superglobal.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest(
    'GET',
    'https://api.phalcon.io/companies/1',
    [],
    'php://input',
    [],
    [
        'cookie-one' => 'cookie-value-one',
    ]
);

var_dump(
    $request->getCookieParams()
);

// [
//     'cookie-one' => 'cookie-value-one',
// ]
```

### `getHeader()`

Returns an array of all the header values of the passed case insensitive header name. If the string parameter representing the header name requested is not present, an empty array is returned.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request  = new ServerRequest(
    'POST',
    'https://api.phalcon.io/companies/1',
    [],
    'php://memory',
    [
        'Content-Type' => 'application/json',
    ]
);

echo $request->getHeader('content-Type'); // ['application/json']
echo $request->getHeader('unknown');      // []
```

### `getHeaderLine()`

Returns all of the header values of the given case-insensitive header name as a string concatenated together using a comma. If the string parameter representing the header name requested, an empty string is returned.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request  = new ServerRequest(
    'POST',
    'https://api.phalcon.io/companies/1',
    [],
    'php://memory',
    [
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

use Phalcon\Http\Message\ServerRequest;

$request  = new ServerRequest(
    'POST',
    'https://api.phalcon.io/companies/1',
    [],
    'php://memory',
    [
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

use Phalcon\Http\Message\ServerRequest;

$request  = new ServerRequest('POST');

echo $request->getMethod(); // POST
```

### `getParsedBody()`

Returns any parameters provided in the request body. If the request `Content-Type` is either `application/x-www-form-urlencoded` or `multipart/form-data`, and the request method is `POST`, this method will return the contents of `$_POST`. Otherwise, this method may return any results of unserializing the request body content; as parsing returns structured content, the potential types will be arrays or objects only. If there is no body content, `null` will be returned.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest(
    'POST',
    'https://api.phalcon.io/companies/1',
    $_SERVER,
    'php://input',
    [
        'Content-Type'  => 'application/x-www-form-urlencoded',
    ],
    $_COOKIE,
    $_GET,
    $_FILES,
    $_POST,
    '1.2'
);

var_dump(
    $this->getParsedBody()
);

// $_POST
```

### `getProtocolVersion()`

Returns the protocol version as as string (default `1.1`)

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request  = new ServerRequest();

echo $request->getProtocolVersion(); // '1.1'
```

### `getQueryParams()`

Returns an array with the unserialized query string arguments, if any. Note that the query params might not be in sync with the URI or server parameters. If you need to ensure you are only getting the original values, you may need to parse the query string from `getUri()->getQuery()` or from the `QUERY_STRING` server parameter.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest();
$request = $request->withQueryParams(
    [
        'param' => 'value',
    ]
);

var_dump(
    $request->getQueryParams()
);

// [
//     'param' => 'value',
// ]
```

### `getRequestTarget()`

Returns a string representing the message's request-target either as it will appear (for clients), as it appeared at request (for servers), or as it was specified for the instance (see `withRequestTarget()`). In most cases, this will be the origin-form of the composed URI, unless a value was provided to the concrete implementation (see `withRequestTarget()`).

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest();
$request = $request->withRequestTarget('/test');

echo $request->getRequestTarget(); // '/test'
```

### `getServerParams()`

Returns an array of data related to the incoming request environment, typically derived from PHP's `$_SERVER` superglobal. This data however is not required to originate from the `$_SERVER` superglobal.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request  = new ServerRequest(
    'POST',
    'https://api.phalcon.io/companies/1',
    $_SERVER
);

var_dump(
    $this->getServerParams()
);

// $_POST

$request  = new ServerRequest(
    'POST',
    'https://api.phalcon.io/companies/1',
    [
        'param' => 'value',
    ]   
);

var_dump(
    $this->getServerParams()
);

// [
//     'param' => 'value',
// ]
```

### `getUploadedFiles()`

Returns an array with upload metadata in a normalized tree, with each leaf is an instance of `Psr\Http\Message\UploadedFileInterface`. These values can derive from the `$_FILES` superglobal or the message body during instantiation or they can be injected using `withUploadedFiles()`. If no data is present, an empty array will be returned.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest(
    'GET',
    'https://api.phalcon.io/companies/1',
    $_SERVER,
    'php://input',
    [
        'Content-Type'  => 'application/json',
    ],
    $_COOKIE,
    $_GET,
    $_FILES
);

var_dump(
    $this->getUploadedFiles()
);

// [
//     'my-form' => [
//         'details' => [
//             'invoice' => /* UploadedFileInterface instance */
//         ],
//     ],
// ]
```

### `getUri()`

Returns the Uri as a `UriInterface` object

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest(
    'POST',
    'https://api.phalcon.io/companies/1'
);

echo $request->getUri(); // UriInterface : https://api.phalcon.io/companies/1
```


## Existence

### `hasHeader()`

Checks if a header exists by the given case-insensitive name. Returns `true` if the header has been found, `false` otherwise

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$jwtToken = 'abc.def.ghi';

$request = new ServerRequest(
    'GET',
    'https://api.phalcon.io/companies/1',
    $_SERVER,
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

use Phalcon\Http\Message\ServerRequest;

$jwtToken = 'abc.def.ghi';

$request = new ServerRequest(
    'GET',
    'https://api.phalcon.io/companies/1',
    $_SERVER,
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

### `withAttribute()`

Returns an instance with the specified derived request attribute. This method allows setting a single derived request attribute as described in `getAttributes()`.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest();

$clone = $request
    ->withAttribute(
        'attribute-name', 
        'attribute-value'
    );

var_dump(
    $clone->getAttributes()
);
// [
//     'attribute-name' => 'attribute-value',
// ]
```

### `withBody()`

Returns an instance with the specified message body which implements `StreamInterface`. Throws [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) when the body is not valid.

```php
<?php

use Phalcon\Http\Message\ServerRequest;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$request = new ServerRequest();

$clone = $request->withBody($stream);

echo $clone->getBody(); // '/assets/stream/mit.txt'
```

### `withCookieParams()`

Returns an instance with the specified cookies. The data is not required to come from the `$_COOKIE` superglobal, but it must be compatible with the structure of `$_COOKIE`. Typically, this data will be injected at instantiation. This method does not update the related `Cookie` header of the request instance, nor related values in the server parameters.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest();

$clone = $request
    ->withCookieParams(
        [
            'cookie-name' => 'cookie-value',
        ]
    );

var_dump(
    $clone->getCookieParams()
);
// [
//     'cookie-name' => 'cookie-value',
// ]
```

### `withHeader()`

Returns an instance with the provided value replacing the specified header. While header names are case-insensitive, the casing of the header will be preserved by this function, and returned from `getHeaders()`. Throws [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) for invalid header names or values.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$jwtToken = 'abc.def.ghi';

$request = new ServerRequest(
    'GET',
    'https://api.phalcon.io/companies/1',
    $_SERVER,
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

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest('POST');

echo $request->getMethod(); // POST

$clone = $request->withMethod('GET');

echo $clone->getMethod(); // GET
```

### `withParsedBody()`

Returns an instance with the specified body parameters. If the request `Content-Type` is either `application/x-www-form-urlencoded` or `multipart/form-data`, and the request method is `POST`, this method should be used only to inject the contents of `$_POST`. The data is not required to come from `$_POST`, but will be the results of unserializing the request body content. Unserialization/parsing returns structured data, and, as such, this method only accepts arrays or objects, or a null value if nothing was available to parse.

As an example, if content negotiation determines that the request data is a JSON payload, this method could be used to create a request instance with the unserialized parameters. Throws [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) for unsupported argument types.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest();

$clone = $request->withParsedBody(
    [
        'one' => 'two',
    ]
);

echo $clone->getParsedBody(); 
```

### `withProtocolVersion()`

Returns an instance with the specified HTTP protocol version (as string).

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest();

echo $request->getProtocolVersion(); // '1.1'

$clone = $request->withProtocolVersion('2.0');

echo $clone->getProtocolVersion(); // '2.0'
```

### `withQueryParams()`

Returns an instance with the specified query string arguments. These values remain immutable over the course of the incoming request. You can inject these parameters during instantiation, such as from PHP's `$_GET` superglobal, or they can be derived from some other value such as the URI. In cases where the arguments are parsed from the URI, the data is compatible with what PHP's [parse_str()](https://www.php.net/manual/en/function.parse-str.php) would return for purposes of how duplicate query parameters are handled, and how nested sets are handled.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest();

$clone = $request->withQueryParams(
    [
        'one' => 'two',
    ]
);

var_dump(
    $clone->getQueryParams()
);

// [
//     'one' => 'two',
// ]
```

### `withRequestTarget()`

Returns an instance with the specific request-target.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest();

echo $request->getRequestTarget(); // "/"

$clone = $request->withRequestTarget('/test');

echo $clone->getRequestTarget(); // '/test'
```

## `withUploadedFiles()`

Creates a new instance with the specified uploaded files. It accepts an array tree of `UploadedFileInterface` instances. Throws [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) if an invalid structure is provided.

```php
<?php

use Phalcon\Http\Message\ServerRequest;
use Phalcon\Http\Message\UploadedFile;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$file = new UploadedFile(
    $stream,
    1234,
    UPLOAD_ERR_OK,
    'phalcon.txt'
);

$request = new ServerRequest();

$clone = $request
    ->withUploadedFiles(
        [
            'my-form' => [
                'details' => [
                    'invoice' => $file,
                ] 
            ]          
        ]           
    );

var_dump(
    $this->getUploadedFiles()
);

// [
//     'my-form' => [
//         'details' => [
//             'invoice' => /* UploadedFileInterface instance */
//         ],
//     ],
// ]
```

### `withUri()`

Returns an instance with the provided `UriInterface` URI. This method updates the `Host` header of the returned request by default if the URI contains a host component. If the URI does not contain a host component, any pre-existing Host header will be carried over to the returned request.

You can opt-in to preserving the original state of the Host header by setting `$preserveHost` to `true`. When `$preserveHost` is set to `true`, this method interacts with the Host header in the following ways:

- If the Host header is missing or empty, and the new URI contains a host component, this method will update the `Host` header in the returned request.
- If the Host header is missing or empty, and the new URI does not contain a host component, this method will not update the `Host` header in the returned request.
- If a Host header is present and non-empty, this method will not update the `Host` header in the returned request.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$query   = 'https://phalcon.io';
$uri     = new Uri($query);
$request = new ServerRequest();

$clone = $request->withUri($uri);

echo $clone->getRequestTarget(); // 'https://phalcon.io'
```

## `withoutAttribute()`

Returns an instance that removes the specified derived request attribute. This method allows removing a single derived request attribute as described in `getAttributes()`.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest();

$clone = $request
    ->withAttribute('one', 'two')
    ->withAttribute('three', 'four')
;

var_dump(
    $clone->getAttributes()
);
// [
//     'one'   => 'two',
//     'three' => 'four',
// ]


$newClone = $request
    ->withoutAttribute('one')
;

var_dump(
    $newClone->getAttributes()
);
// [
//     'three' => 'four',
// ]
```

### `withoutHeader()`

Return an instance without the specified header.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$jwtToken = 'abc.def.ghi';

$request = new ServerRequest(
    'GET',
    'https://api.phalcon.io/companies/1',
    $_SERVER,
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
