---
layout: default
language: 'en'
version: '4.0'
title: 'HTTP Factories (PSR-17)'
keywords: 'psr-17, http, http factories'
---
# HTTP Factories (PSR-17)
<hr/>
![](/assets/images/document-status-stable-success.svg)

## Overview
[Phalcon\Http\Message\RequestFactory][http-message-requestfactory], [Phalcon\Http\Message\ResponseFactory][http-message-responsefactory], [Phalcon\Http\Message\ServerRequestFactory][http-message-serverrequestfactory], [Phalcon\Http\Message\StreamFactory][http-message-streamfactory], [Phalcon\Http\Message\UploadedFileFactory][http-message-uploadedfilefactory], [Phalcon\Http\Message\UriFactory][http-message-urifactory] are the factories implemented of the [PSR-17][psr-17] HTTP messaging interface factories as defined by [PHP-FIG][php-fig].

![](/assets/images/implements-psr--17-blue.svg)

These components aid in creating HTTP objects as defined by the [PSR-7][psr-7] standard.

## RequestFactory
The [Phalcon\Http\Message\RequestFactory][http-message-requestfactory] can be used to create [Phalcon\Http\Message\Request][http-message-request] objects.

```php
<?php

use Phalcon\Http\Message\RequestFactory;

$factory = new RequestFactory();

$stream = $factory->createRequest(
    'GET', 
    'https://api.phalcon.io/companies/1'
);
```
The `createRequest()` method accepts a string as the method (`GET`, `POST` etc.) and the URI and returns back the request object.

## ResponseFactory
The [Phalcon\Http\Message\ResponseFactory][http-message-responsefactory] can be used to create [Phalcon\Http\Message\Response][http-message-response] objects.

```php
<?php

use Phalcon\Http\Message\ResponseFactory;

$factory = new ResponseFactory();

$stream = $factory->createResponse(200, 'OK');
```
The `createResponse()` method accepts an integer which is the response status as well as a string, representing the reason phrase. If no reason is specified, the component will use the default ones as suggested by the HTTP RFCs.

## ServerRequestFactory
The [Phalcon\Http\Message\ServerRequestFactory][http-message-serverrequestfactory] can be used to create [Phalcon\Http\Message\ServerRequest][http-message-serverrequest] objects.

```php
<?php

use Phalcon\Http\Message\ServerRequestFactory;

$factory = new ServerRequestFactory();

$request = $factory->createServerRequest(
    'GET', 
    'https://api.phalcon.io/companies/1',
    [
        'param' => 'value'
    ]
);
```

The `createServerRequest()` creates the new object using a method (`GET`, `POST` etc.), a URI and optionally an array of SAPI parameters with which to seed the generated request instance.

In addition to the `createServerRequest()` the factory offers the `load()` method as a helper to create a request by populating it from the superglobals.

```php
<?php

use Phalcon\Http\Message\ServerRequestFactory;

$factory = new ServerRequestFactory();

$request = $factory->load(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);
```

If If any argument is not supplied, the corresponding superglobal will be used.

## StreamFactory
The [Phalcon\Http\Message\StreamFactory][http-message-streamfactory] can be used to create [Phalcon\Http\Message\Stream][http-message-stream] objects.

```php
<?php

use Phalcon\Http\Message\StreamFactory;

$factory = new StreamFactory();

$stream = $factory->createStream('stream contents');
```

## UploadedFileFactory
The [Phalcon\Http\Message\UploadedFileFactory][http-message-uploadedfilefactory] can be used to create [Phalcon\Http\Message\UploadedFile][http-message-uploadedfile] objects.

```php
<?php

use Phalcon\Http\Message\StreamFactory;
use Phalcon\Http\Message\UploadedFileFactory;

$factory = new UploadedFileFactory();
$streamFactory = new StreamFactory();

$stream = $streamFactory->createStream('stream contents');
        
$size            = 12345;
$error           = 0;
$clientFilename  = null;
$clientMediaType = null;

$file = $factory->createUploadedFile(
    $stream,
    $size,
    $error,
    $clientFilename,
    $clientMediaType
);
```

If a size is not provided it will be determined by checking the size of the stream. The `$error` is the PHP file upload error, It defaults to `0`. If provided by the client, you can use the `clientFilename` and `clientMediaType`. Otherwise they can be set to `null`.

## UriFactory
The [Phalcon\Http\Message\UriFactory][http-message-urifactory] can be used to create [Phalcon\Http\Message\Uri][http-message-uri] objects.

```php
<?php

use Phalcon\Http\Message\UriFactory;

$factory = new UriFactory();

$uri = $factory->createUri('https://api.phalcon.io/companies/1');
```


[php-fig]: https://www.php-fig.org/
[psr-7]: https://www.php-fig.org/psr/psr-7/
[psr-17]: https://www.php-fig.org/psr/psr-17/
[http-message-request]: api/Phalcon_Http#http-message-request
[http-message-requestfactory]: api/Phalcon_Http#http-message-requestfactory
[http-message-response]: api/Phalcon_Http#http-message-response
[http-message-responsefactory]: api/Phalcon_Http#http-message-responsefactory
[http-message-serverrequest]: api/Phalcon_Http#http-message-serverrequest
[http-message-serverrequestfactory]: api/Phalcon_Http#http-message-serverrequestfactory
[http-message-stream]: api/Phalcon_Http#http-message-stream
[http-message-streamfactory]: api/Phalcon_Http#http-message-streamfactory
[http-message-uploadedfile]: api/Phalcon_Http#http-message-uploadedfile
[http-message-uploadedfilefactory]: api/Phalcon_Http#http-message-uploadedfilefactory
[http-message-uri]: api/Phalcon_Http#http-message-uri
[http-message-urifactory]: api/Phalcon_Http#http-message-urifactory


[http-message-exception-invalidargumentexception]: api/Phalcon_Http#http-message-exception-invalidargumentexception
[http-message-stream-input]: api/Phalcon_Http#http-message-stream-input
[http-message-stream-memory]: api/Phalcon_Http#http-message-stream-memory
[http-message-stream-temp]: api/Phalcon_Http#http-message-stream-temp
