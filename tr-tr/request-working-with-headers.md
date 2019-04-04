---
layout: default
language: 'tr-tr'
version: '4.0'
category: 'request'
---
# HTTP Request Component

* * *

## Working with Headers

Request headers contain useful information, allowing you to take necessary steps to send the proper response back to the user. The [Phalcon\Http\Request](api/Phalcon_Http_Request) exposes the `getHeader()` and `getHeaders()` methods.

```php
<?php

use Phalcon\Http\Request;

$request = new Request;

$_SERVER["HTTP_HOST"] = "example.com";
$request->getHttpHost(); // example.com

$_SERVER["HTTP_HOST"] = "example.com:8080";
$request->getHttpHost(); // example.com:8080

$request->setStrictHostCheck(true);
$_SERVER["HTTP_HOST"] = "ex=am~ple.com";
$request->getHttpHost(); // UnexpectedValueException

$_SERVER["HTTP_HOST"] = "ExAmPlE.com";
$request->getHttpHost(); // example.com
```

The `getHttpHost()` method will return the host name used by the request. The method will try to find host name in following order: - `$_SERVER["HTTP_HOST"]` - `$_SERVER["SERVER_NAME"]` - `$_SERVER["SERVER_ADDR"]`

Optionally `getHttpHost()` validates and performs a strict check on the host name. To achieve that you can use the `setStrictHostCheck()` method.