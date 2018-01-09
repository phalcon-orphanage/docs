# Class **Phalcon\\Http\\Request**

*implements* [Phalcon\Http\RequestInterface](/en/3.2/api/Phalcon_Http_RequestInterface), [Phalcon\Di\InjectionAwareInterface](/en/3.2/api/Phalcon_Di_InjectionAwareInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/http/request.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Encapsulates request information for easy and secure access from application controllers.

The request object is a simple value object that is passed between the dispatcher and controller classes. It packages the HTTP request environment.

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

if ($request->isPost() && $request->isAjax()) {
    echo "Request was made using POST and AJAX";
}

$request->getServer("HTTP_HOST"); // Retrieve SERVER variables
$request->getMethod();            // GET, POST, PUT, DELETE, HEAD, OPTIONS, PATCH, PURGE, TRACE, CONNECT
$request->getLanguages();         // An array of languages the client accepts

```

## Methods

public **getHttpMethodParameterOverride** ()

...

public **setHttpMethodParameterOverride** (*mixed* $httpMethodParameterOverride)

...

public **setDI** ([Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector)

Sets the dependency injector

public **getDI** ()

Returns the internal dependency injector

public **get** ([*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue], [*mixed* $notAllowEmpty], [*mixed* $noRecursive])

Gets a variable from the $_REQUEST superglobal applying filters if needed. If no parameters are given the $_REQUEST superglobal is returned

```php
<?php

// Returns value from $_REQUEST["user_email"] without sanitizing
$userEmail = $request->get("user_email");

// Returns value from $_REQUEST["user_email"] with sanitizing
$userEmail = $request->get("user_email", "email");

```

public **getPost** ([*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue], [*mixed* $notAllowEmpty], [*mixed* $noRecursive])

Gets a variable from the $_POST superglobal applying filters if needed If no parameters are given the $_POST superglobal is returned

```php
<?php

// Returns value from $_POST["user_email"] without sanitizing
$userEmail = $request->getPost("user_email");

// Returns value from $_POST["user_email"] with sanitizing
$userEmail = $request->getPost("user_email", "email");

```

public **getPut** ([*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue], [*mixed* $notAllowEmpty], [*mixed* $noRecursive])

Gets a variable from put request

```php
<?php

// Returns value from $_PUT["user_email"] without sanitizing
$userEmail = $request->getPut("user_email");

// Returns value from $_PUT["user_email"] with sanitizing
$userEmail = $request->getPut("user_email", "email");

```

public **getQuery** ([*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue], [*mixed* $notAllowEmpty], [*mixed* $noRecursive])

Gets variable from $_GET superglobal applying filters if needed If no parameters are given the $_GET superglobal is returned

```php
<?php

// Returns value from $_GET["id"] without sanitizing
$id = $request->getQuery("id");

// Returns value from $_GET["id"] with sanitizing
$id = $request->getQuery("id", "int");

// Returns value from $_GET["id"] with a default value
$id = $request->getQuery("id", null, 150);

```

final protected **getHelper** (*array* $source, [*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue], [*mixed* $notAllowEmpty], [*mixed* $noRecursive])

Helper to get data from superglobals, applying filters if needed. If no parameters are given the superglobal is returned.

public **getServer** (*mixed* $name)

Gets variable from $_SERVER superglobal

public **has** (*mixed* $name)

Checks whether $_REQUEST superglobal has certain index

public **hasPost** (*mixed* $name)

Checks whether $_POST superglobal has certain index

public **hasPut** (*mixed* $name)

Checks whether the PUT data has certain index

public **hasQuery** (*mixed* $name)

Checks whether $_GET superglobal has certain index

final public **hasServer** (*mixed* $name)

Checks whether $_SERVER superglobal has certain index

final public **getHeader** (*mixed* $header)

Gets HTTP header from request data

public **getScheme** ()

Gets HTTP schema (http/https)

public **isAjax** ()

Checks whether request has been made using ajax

public **isSoap** ()

Checks whether request has been made using SOAP

public **isSoapRequested** ()

Alias of isSoap(). It will be deprecated in future versions

public **isSecure** ()

Checks whether request has been made using any secure layer

public **isSecureRequest** ()

Alias of isSecure(). It will be deprecated in future versions

public **getRawBody** ()

Gets HTTP raw request body

public **getJsonRawBody** ([*mixed* $associative])

Gets decoded JSON HTTP raw request body

public **getServerAddress** ()

Gets active server address IP

public **getServerName** ()

Gets active server name

public **getHttpHost** ()

Gets host name used by the request. `Request::getHttpHost` trying to find host name in following order:

- `$_SERVER["HTTP_HOST"]`
- `$_SERVER["SERVER_NAME"]`
- `$_SERVER["SERVER_ADDR"]` Optionally `Request::getHttpHost` validates and clean host name. The `Request::$_strictHostCheck` can be used to validate host name. Note: validation and cleaning have a negative performance impact because they use regular expressions.

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

public **setStrictHostCheck** ([*mixed* $flag])

Sets if the `Request::getHttpHost` method must be use strict validation of host name or not

public **isStrictHostCheck** ()

Checks if the `Request::getHttpHost` method will be use strict validation of host name or not

public **getPort** ()

Gets information about the port on which the request is made.

final public **getURI** ()

Gets HTTP URI which request has been made

public **getClientAddress** ([*mixed* $trustForwardedHeader])

Gets most possible client IPv4 Address. This method searches in $_SERVER["REMOTE_ADDR"] and optionally in $_SERVER["HTTP_X_FORWARDED_FOR"]

final public **getMethod** ()

Gets HTTP method which request has been made If the X-HTTP-Method-Override header is set, and if the method is a POST, then it is used to determine the "real" intended HTTP method. The _method request parameter can also be used to determine the HTTP method, but only if setHttpMethodParameterOverride(true) has been called. The method is always an uppercased string.

public **getUserAgent** ()

Gets HTTP user agent used to made the request

public **isValidHttpMethod** (*mixed* $method)

Checks if a method is a valid HTTP method

public **isMethod** (*mixed* $methods, [*mixed* $strict])

Check if HTTP method match any of the passed methods When strict is true it checks if validated methods are real HTTP methods

public **isPost** ()

Checks whether HTTP method is POST. if _SERVER["REQUEST_METHOD"]==="POST"

public **isGet** ()

Checks whether HTTP method is GET. if _SERVER["REQUEST_METHOD"]==="GET"

public **isPut** ()

Checks whether HTTP method is PUT. if _SERVER["REQUEST_METHOD"]==="PUT"

public **isPatch** ()

Checks whether HTTP method is PATCH. if _SERVER["REQUEST_METHOD"]==="PATCH"

public **isHead** ()

Checks whether HTTP method is HEAD. if _SERVER["REQUEST_METHOD"]==="HEAD"

public **isDelete** ()

Checks whether HTTP method is DELETE. if _SERVER["REQUEST_METHOD"]==="DELETE"

public **isOptions** ()

Checks whether HTTP method is OPTIONS. if _SERVER["REQUEST_METHOD"]==="OPTIONS"

public **isPurge** ()

Checks whether HTTP method is PURGE (Squid and Varnish support). if _SERVER["REQUEST_METHOD"]==="PURGE"

public **isTrace** ()

Checks whether HTTP method is TRACE. if _SERVER["REQUEST_METHOD"]==="TRACE"

public **isConnect** ()

Checks whether HTTP method is CONNECT. if _SERVER["REQUEST_METHOD"]==="CONNECT"

public **hasFiles** ([*mixed* $onlySuccessful])

Checks whether request include attached files

final protected **hasFileHelper** (*mixed* $data, *mixed* $onlySuccessful)

Recursively counts file in an array of files

public **getUploadedFiles** ([*mixed* $onlySuccessful])

Gets attached files as Phalcon\\Http\\Request\\File instances

final protected **smoothFiles** (*array* $names, *array* $types, *array* $tmp_names, *array* $sizes, *array* $errors, *mixed* $prefix)

Smooth out $_FILES to have plain array with all files uploaded

public **getHeaders** ()

Returns the available headers in the request

```php
<?php

$_SERVER = [
    "PHP_AUTH_USER" => "phalcon",
    "PHP_AUTH_PW"   => "secret",
];

$headers = $request->getHeaders();

echo $headers["Authorization"]; // Basic cGhhbGNvbjpzZWNyZXQ=

```

public **getHTTPReferer** ()

Gets web page that refers active request. ie: http://www.google.com

final protected **_getBestQuality** (*array* $qualityParts, *mixed* $name)

Process a request header and return the one with best quality

public **getContentType** ()

Gets content type which request has been made

public **getAcceptableContent** ()

Gets an array with mime/types and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT"]

public **getBestAccept** ()

Gets best mime/type accepted by the browser/client from _SERVER["HTTP_ACCEPT"]

public **getClientCharsets** ()

Gets a charsets array and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT_CHARSET"]

public **getBestCharset** ()

Gets best charset accepted by the browser/client from _SERVER["HTTP_ACCEPT_CHARSET"]

public **getLanguages** ()

Gets languages array and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT_LANGUAGE"]

public **getBestLanguage** ()

Gets best language accepted by the browser/client from _SERVER["HTTP_ACCEPT_LANGUAGE"]

public **getBasicAuth** ()

Gets auth info accepted by the browser/client from $_SERVER["PHP_AUTH_USER"]

public **getDigestAuth** ()

Gets auth info accepted by the browser/client from $_SERVER["PHP_AUTH_DIGEST"]

final protected **_getQualityHeader** (*mixed* $serverIndex, *mixed* $name)

Process a request header and return an array of values with their qualities