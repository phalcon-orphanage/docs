---
layout: default
language: 'ko-kr'
version: '4.0'
upgrade: '#request'
title: 'HTTP Request'
keywords: 'http, http request, request'
---

# Request Component

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## 개요

[Phalcon\Http\Request](api/phalcon_http#http-request) is a component that encapsulates the actual HTTP request (usually originated by a browser) and sent to our application. The [Phalcon\Http\Request](api/phalcon_http#http-request) object is a simple value object that is passed between the dispatcher and controller classes, wrapping the HTTP request environment. It also offers easy access to information such as header data, files, method, variables etc.

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

// POST
if (true === $request->isPost()) {
    // AJAX
    if (true === $request->isAjax()) {
        // ....
    }
}
```

## Getting Values

PHP automatically fills the superglobal arrays [$_GET](https://secure.php.net/manual/en/reserved.variables.get.php), [$_POST](https://secure.php.net/manual/en/reserved.variables.post.php) and [$_REQUEST](https://secure.php.net/manual/en/reserved.variables.request.php) depending on the type of the request. These arrays contain the values present in forms submitted or the parameters sent via the URL. The variables in the arrays are never sanitized and can contain illegal characters or even malicious code, which can lead to [SQL injection](https://en.wikipedia.org/wiki/SQL_injection) or [Cross Site Scripting (XSS)](https://en.wikipedia.org/wiki/Cross-site_scripting) attacks.

[Phalcon\Http\Request](api/phalcon_http#http-request) allows you to access the values stored in the [$_GET](https://secure.php.net/manual/en/reserved.variables.get.php), [$_POST](https://secure.php.net/manual/en/reserved.variables.post.php) and [$_REQUEST](https://secure.php.net/manual/en/reserved.variables.request.php) arrays and sanitize or filter them with the <filter> service.

There are 5 methods that allow you to retrieve submitted data from a request: - `get()` - `getQuery()` - `getPost()` - `getPut()` - `getServer()`

All (except `getServer()`) accept the following parameters: - `name` the name of the value to get - `filters` (array/string) the sanitizers to apply to the value - `defaultValue` returned if the element is not defined (`null`) - `notAllowEmpty` if set (default) and the value is empty, the `defaultValue` will be returned; otherwise `null` - `noRecursive` applies the sanitizers recursively in the value (if value is an array)

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$request->get(
    $name = null,            // string
    $filters = null,         // mixed
    $defaultValue = null,    // mixed
    $notAllowEmpty = false,  // bool
    $noRecursive = false     // bool
): mixed
```

`getServer()` accepts only a `name` (string) variable, representing the name of the server variable that you need to retrieve.

### $_REQUEST

The [$_REQUEST](https://secure.php.net/manual/en/reserved.variables.request.php) superglobal contains an associative array that contains the contents of [$_GET](https://secure.php.net/manual/en/reserved.variables.get.php), [$_POST](https://secure.php.net/manual/en/reserved.variables.post.php) and [$_COOKIE](https://secure.php.net/manual/en/reserved.variables.cookies.php). You can retrieve the data stored in the array by calling the `get()` method in the [Phalcon\Http\Request](api/phalcon_http#http-request) object as follows:

**Examples** Get the `userEmail` field from the `$_REQUEST` superglobal:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->get('userEmail');
```

Get the `userEmail` field from the `$_REQUEST` superglobal. Sanitize the value with the `email` sanitizer:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->get('userEmail', 'email', 'some@example.com');
```

Get the `userEmail` field from the `$_REQUEST` superglobal. Do not sanitize it. If the parameter is null, return the default value:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->get('userEmail', null, 'some@example.com');
```

### $_GET

The [$_GET](https://secure.php.net/manual/en/reserved.variables.get.php) superglobal contains an associative array that contains the variables passed to the current script via URL parameters (also known as the query string). You can retrieve the data stored in the array by calling the `getQuery()` method as follows:

**Examples** Get the `userEmail` field from the `$_GET` superglobal:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->getQuery('userEmail');
```

Get the `userEmail` field from the `$_GET` superglobal. Sanitize the value with the `email` sanitizer:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->getQuery('userEmail', 'email', 'some@example.com');
```

Get the `userEmail` field from the `$_GET` superglobal. Do not sanitize it. If the parameter is null, return the default value:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->getQuery('userEmail', null, 'some@example.com');
```

### $_POST

The [$_POST](https://secure.php.net/manual/en/reserved.variables.post.php) superglobal contains an associative array that contains the variables passed to the current script via the HTTP POST method when using `application/x-www-form-urlencoded` or `multipart/form-data` as the HTTP `Content-Type` in the request. You can retrieve the data stored in the array by calling the `getPost()` method as follows:

**Examples** Get the `userEmail` field from the `$_POST` superglobal:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->getPost('userEmail');
```

Get the `userEmail` field from the `$_POST` superglobal. Sanitize the value with the `email` sanitizer:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->getPost('userEmail', 'email', 'some@example.com');
```

Get the `userEmail` field from the `$_POST` superglobal. Do not sanitize it. If the parameter is null, return the default value:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->getPost('userEmail', null, 'some@example.com');
```

### Put

The request object parses the PUT stream that has been received internally. You can retrieve the data stored in the array by calling the `getPut()` method as follows:

**Examples** Get the `userEmail` field from the `PUT` stream:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->getPut('userEmail');
```

Get the `userEmail` field from the `PUT` stream. Sanitize the value with the `email` sanitizer:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->getPut('userEmail', 'email', 'some@example.com');
```

Get the `userEmail` field from the `PUT` stream. Do not sanitize it. If the parameter is null, return the default value:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->getPut('userEmail', null, 'some@example.com');
```

### $_SERVER

The [$_SERVER](https://secure.php.net/manual/en/reserved.variables.server.php) superglobal contains an array containing information such as headers, paths, and script locations. You can retrieve the data stored in the array by calling the `getServer()` method as follows:

**Examples** Get the `SERVER_NAME` value from the `$_SERVER` superglobal:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$name = $request->getServer('SERVER_NAME');
```

## Preset Sanitizers

It is relatively common that certain fields are using the same name throughout your application. A field posted from a form in your application can have the same name and function with another form in a different area. Examples of this behavior could be `id` fields, `name` etc.

To make the sanitization process easier, when retrieving such fields, [Phalcon\Http\Request](api/phalcon_http#http-request) offers a method to define those sanitizing filters based on HTTP methods when setting up the object.

```php
<?php

use Phalcon\Di;
use Phalcon\Filter;
use Phalcon\Http\Request;

$container = new Di();

$container->set(
    'request',
    function () {
        $request = new Request();
        $request
            ->setParameterFilters(
                'id', 
                Filter::FILTER_ABSINT, 
                [
                    'post'
                ]
            )
            ->setParameterFilters(
                'name', 
                [
                    'trim', 
                    'string'
                ], 
                [
                    'post'
                ]
            )
        ;

        return $request;
    }
);

```

The above will automatically sanitize any parameter that is POSTed from a form that has a name `id` or `name` with their respective filters. Sanitization takes place when calling the following methods (one per HTTP method) - `getFilteredPost()` - `getFilteredPut()` - `getFilteredQuery()`

These methods accept the same parameters as the `getPost()`, `getPut()` and `getQuery()` but without the `$filter` parameter.

## 컨트롤러

If you use the [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) container, the [Phalcon\Http\Request](api/phalcon_http#http-request) is already registered for you. The most common place to access the request environment is in an action of a controller. To access the [Phalcon\Http\Request](api/phalcon_http#http-request) object from a controller you will need to use the `$this->request` public property of the controller:

```php
<?php

use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;

/**
 * Class PostsController
 * 
 * @property Request $request
 */
class PostsController extends Controller
{
    public function saveAction()
    {
        // Check if request has made with POST
        if (true === $this->request->isPost()) {
            // Access POST data
            $customerName = $this
                ->request
                ->getPost('name');
            $customerBorn = $this
                ->request
                ->getPost('born', 'string', '1984');
        }
    }
}
```

## Checking Operations

The [Phalcon\Http\Request](api/phalcon_http#http-request) component contains a number of methods that help you check the current operation. For instance if you want to check if a particular request was made using AJAX, you can do so by using the `isAjax()` method. All the methods are prefixed with `is`. - `isAjax()`: Checks whether request has been made using AJAX - `isConnect()`: Checks whether HTTP method is CONNECT - `isDelete()`: Checks whether HTTP method is DELETE - `isGet()`: Checks whether HTTP method is GET - `isHead()`: Checks whether HTTP method is HEAD - `isMethod()`: Check if HTTP method match any of the passed methods - `isOptions()`: Checks whether HTTP method is OPTIONS - `isPatch()`: Checks whether HTTP method is PATCH - `isPost()`: Checks whether HTTP method is POST - `isPurge()`: Checks whether HTTP method is PURGE (Squid and Varnish support) - `isPut()`: Checks whether HTTP method is PUT - `isSecure()`: Checks whether request has been made using any secure layer - `isSoap()`: Checks whether request has been made using SOAP - `isTrace()`: Checks whether HTTP method is TRACE - `isValidHttpMethod()`: Checks if a method is a valid HTTP method

## Checking Existence

There are a number of methods available that allow you to check the existence of elements in the request. These methods are prefixed with `has`. Depending on the method used, you can check if an element exists in the `$_REQUEST`, `$_GET`, `$_POST`, `$_SERVER`, `$_FILES`, PUT cache and the request headers. - `has()`: Checks whether the $_REQUEST superglobal has a certain element - `hasFiles()`: Checks whether the request has any uploaded files - `hasHeader()`: Checks whether the headers have a certain element - `hasPost()`: Checks whether $_POST superglobal has a certain element - `hasPut()`: Checks whether the PUT data has a certain element - `hasQuery()`: Checks whether $_GET superglobal has a certain element - `hasServer()`: Checks whether $_SERVER superglobal has a certain element - `numFiles()`: Returns the number of files present in the request

## Request Information

The [Phalcon\Http\Request](api/phalcon_http#http-request) object offers methods that provide additional information regarding the request.

### Authentication

* `getBasicAuth()`: Gets auth info accepted by the browser/client
* `getDigestAuth()`: Gets auth info accepted by the browser/client

### Client

* `getClientAddress()`: Gets most possible client IPv4 Address
* `getClientCharsets()`: Gets a charsets array and their quality accepted by the browser/client
* `getUserAgent()`: Gets HTTP user agent used to made the request
* `getHTTPReferer()`: Gets web page that refers active request

### Content

* `getAcceptableContent()`: Gets an array with mime/types and their quality accepted by the browser/client
* `getBestAccept()`: Gets best mime/type accepted by the browser/client
* `getContentType()`: Gets content type which request has been made
* `getJsonRawBody()`: Gets decoded JSON HTTP raw request body
* `getRawBody()`: Gets HTTP raw request body

### i18n

* `getBestCharset()`: Gets best charset accepted by the browser/client
* `getBestLanguage()`: Gets best language accepted by the browser/client
* `getLanguages()`: Gets languages array and their quality accepted by the browser/client

### Server

* `getPort()`: Gets information about the port on which the request is made
* `getServerAddress()`: Gets active server address IP
* `getServerName()`: Gets active server name
* `getScheme()`: Gets HTTP schema (http/https)
* `getURI()`: Gets HTTP URI which request has been made. If `true` is passed as a parameter, the query part will not be returned

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
```

Some methods:

```php
$ipAddress = $request->getServerAddress();
```

Get the servers's IP address. ie. `192.168.0.100`

```php
$ipAddress = $request->getClientAddress();
```

Get the client's IP address ie. `201.245.53.51`

```php
$userAgent = $request->getUserAgent();
```

Get the User Agent (`HTTP_USER_AGENT`)

```php
$contentType = $request->getAcceptableContent();
```

Get the best acceptable content by the browser. ie text/xml

```php
$charset = $request->getBestCharset();
```

Get the best charset accepted by the browser. ie. `utf-8`

```php
$language = $request->getBestLanguage();
```

Get the best language accepted configured in the browser. ie. `en-us`

### Method

`getMethod()` returns the HTTP method which request has been made. If the `X-HTTP-Method-Override` header is set, and if the method is a `POST`, then it is used to determine the "real" intended HTTP method. The `_method` request parameter can also be used to determine the HTTP method, `setHttpMethodParameterOverride(true)` has been called. The method always returns an uppercase string.

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

// POST
$_SERVER['REQUEST_METHOD'] = 'POST';
echo $request->getMethod();

/**
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

## 의존성 주입(Dependency Injection)

The [Phalcon\Http\Request](api/phalcon_http#http-request) object implements the [Phalcon\Di\InjectionAwareInterface](api/phalcon_di#di-injectionawareinterface) interface. As a result, the DI container is available and can be retrieved using the `getDI()` method. A container can also be set using the `setDI()` method.

## Working with Headers

Request headers contain useful information, allowing you to take necessary steps to send the proper response back to the user. The [Phalcon\Http\Request](api/phalcon_http#http-request) exposes the `getHeader()` and `getHeaders()` methods.

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

## Uploaded Files

Another common task is file uploading. [Phalcon\Http\Request](api/phalcon_http#http-request) offers an object-oriented way work with files. For the whole upload process to work, you will need to make the necessary changes to your `php.ini` (see [php-uploads](https://secure.php.net/manual/en/ini.core.php#ini.file-uploads)).

```php
<?php

use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;

/**
 * Class PostsController
 * 
 * @property Request $request
 */
class PostsController extends Controller
{
    public function uploadAction()
    {
        // if ($this->request->numFiles() > 0) {
        if ($this->request->hasFiles()) {
            $files = $this->request->getUploadedFiles();

            foreach ($files as $file) {
                echo $file->getName(), ' ', $file->getSize(), '\n';

                $file->moveTo(
                    'files/' . $file->getName()
                );
            }
        }
    }
}
```

Each object returned by `Phalcon\Http\Request::getUploadedFiles()` is an instance of the [Phalcon\Http\Request\File](api/phalcon_http#http-request-file) which implements the [Phalcon\Http\Request\FileInterface](api/phalcon_http#http-request-fileinterface) class. Using the `$_FILES` superglobal array offers the same behavior. [Phalcon\Http\Request\File](api/phalcon_http#http-request-file) encapsulates only the information related to each file uploaded with the request.

The `getUploadedFiles()` accepts two parameters. - `$onlySuccessful`: Contains only successful uploads - `$namedKeys`: Returns the array with named keys obtained by the upload process

The method returns an array of [Phalcon\Http\Request\File](api/phalcon_http#http-request-file) objects. Each object offers the following properties and methods, allowing you to work with uploaded files:

* `getError()` (string) - Returns any error that happened with this file
* `getExtension()` (string) - Returns the extension of the file
* `getKey()` (string) - Returns the internal key of the file
* `getName()` (string) -Returns the real name of the uploaded file
* `getRealType()` (string) - Return the real mime type of the upload file using finfo
* `getSize()` (int) - Returns the file size of the uploaded file
* `getTempName()` (string) - Returns the temporary name of the uploaded file
* `getType()` (string) - Returns the mime type reported by the browser. This mime type is not completely secure, use `getRealType()` instead
* `isUploadedFile()` (bool) - Checks whether the file has been uploaded via `POST`.
* `moveTo(string $destination)` (bool) - Moves the temporary file to a destination within the application

## 의존성 주입(Dependency Injection)

The [Phalcon\Http\Request](api/phalcon_http#http-request) object implements the [Phalcon\Di\InjectionAwareInterface](api/phalcon_di#di-injectionawareinterface) interface. As a result, the DI container is available and can be retrieved using the `getDI()` method. A container can also be set using the `setDI()` method.

## 이벤트

The [Phalcon\Http\Request](api/phalcon_http#http-request) object implements the [Phalcon\Events\EventsAware](api/phalcon_events#events-eventsawareinterface) interfaces. As a result `getEventsManager()` and `setEventsManager()` are available for you to use.

| Event                        | Description                                      | Can stop operation |
| ---------------------------- | ------------------------------------------------ |:------------------:|
| `afterAuthorizationResolve`  | Fires when the authorization has been resolved   |         No         |
| `beforeAuthorizationResolve` | Fires before the authorization has been resolved |        Yes         |

When using HTTP authorization, the `Authorization` header has the following format:

```text
Authorization: <type> <credentials>
```

where `<type>` is an authentication type. A common type is `Basic`. Additional authentication types are described in [IANA registry of Authentication schemes](https://www.iana.org/assignments/http-authschemes/http-authschemes.xhtml) and [Authentication for AWS servers (AWS4-HMAC-SHA256)](https://docs.aws.amazon.com/AmazonS3/latest/API/sigv4-auth-using-authorization-header.html). In most use cases the authentication type is: * `AWS4-HMAC-SHA256` * `Basic` * `Bearer` * `Digest` * `HOBA` * `Mutual` * `Negotiate` * `OAuth` * `SCRAM-SHA-1` * `SCRAM-SHA-256` * `vapid`

You can use the `request:beforeAuthorizationResolve` and `request:afterAuthorizationResolve` events to perform additional operations before or after the authorization resolves.

The `request:beforeAuthorizationResolve` receives the `SERVER` array with the key `server` as the second parameter of the event.

The `request:afterAuthorizationResolve` receives the `SERVER` array with the key `server` as well as the headers with the hey `headers`.

A custom authorization resolver is required.

Example without using custom authorization resolver:

```php
<?php

use Phalcon\Http\Request;

$_SERVER['HTTP_AUTHORIZATION'] = 'Enigma Secret';

$request = new Request();
print_r($request->getHeaders());
```

Result:

```bash
Array
(
    [Authorization] => Enigma Secret
)

Type: Enigma
Credentials: Secret
```

Example using custom authorization resolver:

```php
<?php

use Phalcon\Di;
use Phalcon\Events\Event;
use Phalcon\Http\Request;
use Phalcon\Events\Manager;

class NegotiateAuthorizationListener
{
    public function afterAuthorizationResolve(Event $event, Request $request, array $data)
    {
        if (empty($data['server']['CUSTOM_KERBEROS_AUTH'])) {
            return false;
        }

        list($type,) = explode(
            ' ', 
            $data['server']['CUSTOM_KERBEROS_AUTH'], 
            2
        );

        if (!$type || stripos($type, 'negotiate') !== 0) {
            return false;
        }

        return [
           'Authorization'=> $data['server']['CUSTOM_KERBEROS_AUTH'],
        ];
    }
}

$_SERVER['CUSTOM_KERBEROS_AUTH'] = 'Negotiate '
                                 . 'a87421000492aa874209af8bc028';

$di = new Di();

$di->set(
    'eventsManager',
    function () {
        $manager = new Manager();

        $manager->attach(
            'request',
            new NegotiateAuthorizationListener()
        );

        return $manager;
    }
);

$request = new Request();

$request->setDI($di);

print_r(
    $request->getHeaders()
);
```

Result:

```bash
Array
(
    [Authorization] => Negotiate a87421000492aa874209af8bc028
)

Type: Negotiate
Credentials: a87421000492aa874209af8bc028
```