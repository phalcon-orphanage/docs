---
layout: default
language: 'en'
version: '4.0'
title: 'HTTP Factories (PSR-17)'
keywords: 'psr-17, http, http factories'
---

# HTTP Factories (PSR-17)

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

[Phalcon\Http\Message\RequestFactory](api/phalcon_http#http-message-requestfactory), [Phalcon\Http\Message\ResponseFactory](api/phalcon_http#http-message-responsefactory), [Phalcon\Http\Message\ServerRequestFactory](api/phalcon_http#http-message-serverrequestfactory), [Phalcon\Http\Message\StreamFactory](api/phalcon_http#http-message-streamfactory), [Phalcon\Http\Message\UploadedFileFactory](api/phalcon_http#http-message-uploadedfilefactory), [Phalcon\Http\Message\UriFactory](api/phalcon_http#http-message-urifactory) are the factories implemented of the [PSR-17](https://www.php-fig.org/psr/psr-17/) HTTP messaging interface factories as defined by [PHP-FIG](https://www.php-fig.org/).

![](/assets/images/implements-psr--17-blue.svg)

These components aid in creating HTTP objects as defined by the [PSR-7](https://www.php-fig.org/psr/psr-7/) standard.

## RequestFactory

The [Phalcon\Http\Message\RequestFactory](api/phalcon_http#http-message-requestfactory) can be used to create [Phalcon\Http\Message\Request](api/phalcon_http#http-message-request) objects.

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

The [Phalcon\Http\Message\ResponseFactory](api/phalcon_http#http-message-responsefactory) can be used to create [Phalcon\Http\Message\Response](api/phalcon_http#http-message-response) objects.

```php
<?php

use Phalcon\Http\Message\ResponseFactory;

$factory = new ResponseFactory();

$stream = $factory->createResponse(200, 'OK');
```

The `createResponse()` method accepts an integer which is the response status as well as a string, representing the reason phrase. If no reason is specified, the component will use the default ones as suggested by the HTTP RFCs.

## ServerRequestFactory

The [Phalcon\Http\Message\ServerRequestFactory](api/phalcon_http#http-message-serverrequestfactory) can be used to create [Phalcon\Http\Message\ServerRequest](api/phalcon_http#http-message-serverrequest) objects.

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

The [Phalcon\Http\Message\StreamFactory](api/phalcon_http#http-message-streamfactory) can be used to create [Phalcon\Http\Message\Stream](api/phalcon_http#http-message-stream) objects.

```php
<?php

use Phalcon\Http\Message\StreamFactory;

$factory = new StreamFactory();

$stream = $factory->createStream('stream contents');
```

## UploadedFileFactory

The [Phalcon\Http\Message\UploadedFileFactory](api/phalcon_http#http-message-uploadedfilefactory) can be used to create [Phalcon\Http\Message\UploadedFile](api/phalcon_http#http-message-uploadedfile) objects.

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

The [Phalcon\Http\Message\UriFactory](api/phalcon_http#http-message-urifactory) can be used to create [Phalcon\Http\Message\Uri](api/phalcon_http#http-message-uri) objects.

```php
<?php

use Phalcon\Http\Message\UriFactory;

$factory = new UriFactory();

$uri = $factory->createUri('https://api.phalcon.io/companies/1');
```