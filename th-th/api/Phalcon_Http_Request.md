---
layout: default
language: 'th-th'
version: '4.0'
title: 'Phalcon\Http\Request'
---

# Class **Phalcon\Http\Request**

*implements* [Phalcon\Http\RequestInterface](Phalcon_Http_RequestInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/request.zep)

## Methods

### Public

```php
public function get( 
    [string $name = null 
    [, string | array $filters = null 
    [, mixed $defaultValue = null 
    [, bool $notAllowEmpty = false 
    [, bool $noRecursive = false ]]]]] 
): mixed
```

Gets a variable from the `$_REQUEST` superglobal applying filters if needed. If no parameters are given the `$_REQUEST` superglobal is returned

```php
<?php

// Returns value from $_REQUEST["user_email"] without sanitizing
$userEmail = $request->get("user_email");

// Returns value from $_REQUEST["user_email"] with sanitizing
$userEmail = $request->get("user_email", "email");
```

* * *

```php
public function getAcceptableContent(): array
```

Gets an array with mime/types and their quality accepted by the browser/client from `$_SERVER["HTTP_ACCEPT"]`

* * *

```php
public function getBasicAuth(): array | null
```

Gets auth info accepted by the browser/client from `$_SERVER["PHP_AUTH_USER"]`

* * *

```php
public function getBestAccept(): string
```

Gets best mime/type accepted by the browser/client from `$_SERVER["HTTP_ACCEPT"]`

* * *

```php
public function getBestCharset(): string
```

Gets best charset accepted by the browser/client from `$_SERVER["HTTP_ACCEPT_CHARSET"]`

* * *

```php
public function getBestLanguage(): string
```

Gets best language accepted by the browser/client from `$_SERVER["HTTP_ACCEPT_LANGUAGE"]`

* * *

```php
public function getClientAddress( bool $trustForwardedHeader = false ): string | bool
```

Gets most possible client IPv4 Address. This method searches in `$_SERVER["REMOTE_ADDR"]` and optionally in `$_SERVER["HTTP_X_FORWARDED_FOR"]`

* * *

```php
public function getClientCharsets(): array
```

Gets a charsets array and their quality accepted by the browser/client from `$_SERVER["HTTP_ACCEPT_CHARSET"]`

* * *

```php
public function getContentType(): string | null
```

Gets content type which request has been made

* * *

```php
public function getDigestAuth(): array
```

Gets auth info accepted by the browser/client from `$_SERVER["PHP_AUTH_DIGEST"]`

* * *

```php
public function getDI(): Phalcon\Di\DiInterface
```

Returns the internal dependency injector

    <hr/>
    ```php
    public function getFilteredPost(
        [string $name = null 
        [, mixed $defaultValue = null 
        [, bool $notAllowEmpty = false 
        [, bool $noRecursive = false ]]]] 
    ): mixed
    

Retrieves a post value always sanitized with the preset filters

* * *

```php
public function getFilteredPut(
    [string $name = null 
    [, mixed $defaultValue = null 
    [, bool $notAllowEmpty = false 
    [, bool $noRecursive = false ]]]] 
): mixed
```

Retrieves a put value always sanitized with the preset filters

* * *

```php
public function getFilteredQuery(
    [string $name = null 
    [, mixed $defaultValue = null 
    [, bool $notAllowEmpty = false 
    [, bool $noRecursive = false ]]]] 
): mixed
```

Retrieves a query/get value always sanitized with the preset filters

* * *

```php
public function getHeader( string $header ): string
```

Gets HTTP header from request data

* * *

```php
public function getHeaders(): array
```

Returns the available headers in the request ```php <?php

$_SERVER = [ "PHP_AUTH_USER" => "phalcon", "PHP_AUTH_PW" => "secret", ];

$headers = $request->getHeaders();

echo $headers["Authorization"]; // Basic cGhhbGNvbjpzZWNyZXQ=

    <hr/>
    ```php
    public function getHttpHost(): string
    

Gets the host name used by the request. The method will try to find host name in following order: - `$_SERVER["HTTP_HOST"]` - `$_SERVER["SERVER_NAME"]` - `$_SERVER["SERVER_ADDR"]`

Optionally `getHttpHost()` validates and performs a strict check on the host name. To achieve that you can use the `setStrictHostCheck()` method.

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

* * *

```php
public function getHttpMethodParameterOverride(): bool
```

Returns the method parameter override setting

* * *

```php
public function getHTTPReferer(): string
```

Gets the web page that was the original referrer for the request. ie: `https://www.duckduckgo.com`

* * *

```php
public function getJsonRawBody( bool $associative = false ): \stdClass | array | bool
```

Gets the decoded JSON HTTP raw request body

* * *

```php
public function getLanguages(): array
```

Gets a languages array and their quality accepted by the browser/client from `$_SERVER["HTTP_ACCEPT_LANGUAGE"]`

* * *

```php
public function getMethod(): string
```

Gets HTTP method which request has been made. If the `X-HTTP-Method-Override` header is set, and if the method is a `POST`, then it is used to determine the "real" intended HTTP method. The `_method` request parameter can also be used to determine the HTTP method, `setHttpMethodParameterOverride(true)` has been called. The method always returns an uppercase string.

* * *

```php
public function getPort(): int
```

Gets the port the request was made

* * *

```php
public function getServer( string $name ): string | null
```

Gets server's address IP

* * *

```php
public function getServerAddress(): string
```

Gets the server's IP address

* * *

```php
public function setHttpMethodParameterOverride( bool $httpMethodParameterOverride )
```

Sets the method parameter override setting

* * *

```php
public final function getURI(): string
```

Gets the HTTP URI of the request

* * *

```php
public function getPost( 
    [string $name = null 
    [, string | array $filters = null 
    [, mixed $defaultValue = null 
    [, bool $notAllowEmpty = false 
    [, bool $noRecursive = false ]]]]] 
): mixed
```

Gets a variable from a POST request

* * *

```php
public function getPut( 
    [string $name = null 
    [, string | array $filters = null 
    [, mixed $defaultValue = null 
    [, bool $notAllowEmpty = false 
    [, bool $noRecursive = false ]]]]] 
): mixed
```

Gets a variable from a PUT request

* * *

```php
public function getQuery( 
    [string $name = null 
    [, string | array $filters = null 
    [, mixed $defaultValue = null 
    [, bool $notAllowEmpty = false 
    [, bool $noRecursive = false ]]]]] 
): mixed
```

Gets a variable from a GET request

* * *

```php
public function getRawBody(): string
```

Gets the raw request body

* * *

```php
public function getScheme(): string
```

Gets the HTTP schema (http/https)

* * *

```php
public function getServer(string name): string | null
```

Gets an element from `$_SERVER` superglobal

* * *

```php
public function getServerAddress(): string
```

Gets the active server address IP

* * *

```php
public function getServerName(): string
```

Gets the active server name

* * *

```php
public function getUploadedFiles(
    bool $onlySuccessful = false, 
    bool $namedKeys = false 
): Phalcon\Http\Request\FileInterface[]
```

Gets the attached files contained in a collection of [Phalcon\Http\Request\FileInterface](Phalcon_Http_Request_FileInterface) objects

* * *

```php
public function getUserAgent(): string
```

Gets the user agent used for this request

* * *

```php
public function has( string $name ): bool
```

Checks whether `$_REQUEST` superglobal has a certain element

* * *

```php
public function hasFiles( bool $onlySuccessful = false ): long
```

Checks whether the request has attached files

* * *

```php
public function hasHeader( string $header ): bool
```

Checks whether the headers have a certain element

* * *

```php
public function hasPost( string $name ): bool
```

Checks whether `$_POST` superglobal has a certain element

* * *

```php
public function hasPut( string name ): bool
```

Checks whether the PUT data has a certain element

* * *

```php
public function hasQuery( string $name ): bool
```

Checks whether `$_GET` superglobal has a certain element

* * *

```php
public function hasServer( string $name ): bool
```

Checks whether `$_SERVER` superglobal has a certain element

* * *

```php
public function isAjax(): bool
```

Checks whether request was made using Ajax. (`$_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest"`)

* * *

```php
public function isConnect(): bool
```

Checks whether HTTP method is `CONNECT`. (`$_SERVER["REQUEST_METHOD"] === "CONNECT"`)

* * *

```php
public function isDelete(): bool
```

Checks whether HTTP method is `DELETE`. (`$_SERVER["REQUEST_METHOD"] === "DELETE"`)

* * *

```php
public function isGet(): bool
```

Checks whether HTTP method is `GET`. (`$_SERVER["REQUEST_METHOD"] === "GET"`)

* * *

```php
public function isHead(): bool
```

Checks whether HTTP method is `HEAD`. (`$_SERVER["REQUEST_METHOD"] === "HEAD"`)

* * *

```php
public function isMethod( string | array $methods, bool $strict = false ): bool
```

Check if HTTP method match any of the passed methods

* * *

```php
public function isOptions(): bool
```

Checks whether HTTP method is `OPTIONS`. (`$_SERVER["REQUEST_METHOD"] === "OPTIONS"`)

* * *

```php
public function isPost(): bool
```

Checks whether HTTP method is `POST`. ($_SERVER["REQUEST_METHOD"] === "POST"`) 

* * *

```php
public function isPurge(): bool
```

Checks whether HTTP method is `PURGE` (Squid and Varnish support). (`$_SERVER["REQUEST_METHOD"] === "PURGE"`) 

* * *

```php
public function isPut(): bool
```

Checks whether HTTP method is `PUT`. (`$_SERVER["REQUEST_METHOD"] === "PUT"`) 

* * *

```php
public function isSecure(): bool
```

Checks whether request has been made using a secure layer 

* * *

```php
public function isSoap(): bool
```

Checks whether request has been made using SOAP 

* * *

```php
public function isTrace(): bool
```

Checks whether HTTP method is `TRACE`. (`$_SERVER["REQUEST_METHOD"] === "TRACE"`)

    <hr/>
    ```php
    public function isValidHttpMethod( string $method ): bool
    

Checks if a method is a valid HTTP method

    <hr/>
    ```php
    public function setDI( Phacon\Di\DiInterface $container)
    

Sets the dependency injector 

* * *

```php
public function setParameterFilters( string $name, array $filters = [], array $scope = [] ): Phalcon\Http\RequestInterface
```

Sets automatic sanitizers/filters for a particular field and for particular methods

    <hr/>
    ```php
    public function setStrictHostCheck( bool $flag = true ): Phalcon\Http\RequestInterface
    

Sets if the `Request::getHttpHost` method must be use strict validation of host name or not

* * *

### Protected

```php
protected final function getHelper( 
    array $source, 
    string $name = null, 
    array | string $filters = null, 
    mixed $defaultValue = null, 
    bool $notAllowEmpty = false, 
    bool $noRecursive = false 
): mixed
```

Helper to get data from superglobals, applying filters if needed. If no parameters are given the superglobal is returned.

* * *

```php
protected final function hasFileHelper( mixed $data, bool $onlySuccessful ): long
```

Recursively counts file in an array of files

* * *

```php
protected final function getBestQuality( array $qualityParts, string $name ): string
```

Process a request header and return the one with best quality

* * *

```php
protected final function getQualityHeader( string $serverIndex, string $name ): array
```

Process a request header and return an array of values with their qualities

* * *

```php
protected function resolveAuthorizationHeaders(): array
```

Resolve authorization headers.

* * *

```php
protected final function smoothFiles( 
    array $names, 
    array $types, 
    array $tmp_names, 
    array $sizes, 
    array $errors, 
    string $prefix 
): array
```

Smooth out `$_FILES` to have plain array with all files uploaded ```