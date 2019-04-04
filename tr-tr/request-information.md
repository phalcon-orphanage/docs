---
layout: default
language: 'tr-tr'
version: '4.0'
category: 'request'
---
# HTTP Request Component

* * *

## Request information

The [Phalcon\Http\Request](api/Phalcon_Http_Request) object offers methods that provide additional information regarding the request.

### Authentication

- `getBasicAuth()`: Gets auth info accepted by the browser/client
- `getDigestAuth()`: Gets auth info accepted by the browser/client

### Client

- `getClientAddress()`: Gets most possible client IPv4 Address
- `getClientCharsets()`: Gets a charsets array and their quality accepted by the browser/client
- `getUserAgent()`: Gets HTTP user agent used to made the request
- `getHTTPReferer()`: Gets web page that refers active request

### Content

- `getAcceptableContent()`: Gets an array with mime/types and their quality accepted by the browser/client
- `getBestAccept()`: Gets best mime/type accepted by the browser/client
- `getContentType()`: Gets content type which request has been made
- `getJsonRawBody()`: Gets decoded JSON HTTP raw request body
- `getRawBody()`: Gets HTTP raw request body

### i18n

- `getBestCharset()`: Gets best charset accepted by the browser/client
- `getBestLanguage()`: Gets best language accepted by the browser/client
- `getLanguages()`: Gets languages array and their quality accepted by the browser/client

### Server

- `getPort()`: Gets information about the port on which the request is made
- `getServerAddress()`: Gets active server address IP
- `getServerName()`: Gets active server name
- `getScheme()`: Gets HTTP schema (http/https)
- `getURI()`: Gets HTTP URI which request has been made

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

if ($request->isAjax()) {
    echo 'The request was made with Ajax';
}

// Check the request layer
if ($request->isSecure()) {
    echo 'The request was made using a secure layer';
}

// Get the servers's IP address. ie. 192.168.0.100
$ipAddress = $request->getServerAddress();

// Get the client's IP address ie. 201.245.53.51
$ipAddress = $request->getClientAddress();

// Get the User Agent (HTTP_USER_AGENT)
$userAgent = $request->getUserAgent();

// Get the best acceptable content by the browser. ie text/xml
$contentType = $request->getAcceptableContent();

// Get the best charset accepted by the browser. ie. utf-8
$charset = $request->getBestCharset();

// Get the best language accepted configured in the browser. ie. en-us
$language = $request->getBestLanguage();
```

### Method

`getMethod()` returns the HTTP method which request has been made. If the `X-HTTP-Method-Override` header is set, and if the method is a `POST`, then it is used to determine the "real" intended HTTP method. The `_method` request parameter can also be used to determine the HTTP method, `setHttpMethodParameterOverride(true)` has been called. The method always returns an uppercase string.

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

// POST
$_SERVER['REQUEST_METHOD'] = 'POST';
echo $request->getMethod();

// GET
/**
 * Assume
 * 
 * header('X-HTTP-Method-Override: GET');
 */ 
$_SERVER['REQUEST_METHOD'] = 'POST';
$request->setHttpMethodParameterOverride(true);
echo $request->getMethod();

// GET
$_SERVER['REQUEST_METHOD'] = 'POST';
$_REQUEST['_method']       = 'GET';
$request->setHttpMethodParameterOverride(true);
echo $request->getMethod();
```