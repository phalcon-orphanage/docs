---
layout: default
language: 'sr-sp'
version: '4.0'
category: 'request'
---

# Request Component

* * *

# Request Environment

Every HTTP request (usually originated by a browser) contains additional information regarding the request such as header data, files, variables, etc. A web based application needs to parse that information in order to perform a particular action and send the correct response back to the requester. [Phalcon\Http\Request](api/Phalcon_Http_Request) encapsulates the request information in a simple value object.

```php
<?php

use Phalcon\Http\Request;

// Getting a request instance
$request = new Request();

// Check whether the request was made with method POST
if (true === $request->isPost()) {
    // Check whether the request was made with Ajax
    if (true === $request->isAjax()) {
        echo 'Request was made using POST and AJAX';
    }
}
```

## Getting Values

PHP automatically fills the superglobal arrays [$_GET](https://secure.php.net/manual/en/reserved.variables.get.php), [$_POST](https://secure.php.net/manual/en/reserved.variables.post.php) and [$_REQUEST](https://secure.php.net/manual/en/reserved.variables.request.php) depending on the type of the request. These arrays contain the values present in forms submitted or the parameters sent via the URL. The variables in the arrays are never sanitized and can contain illegal characters or even malicious code, which can lead to [SQL injection](https://en.wikipedia.org/wiki/SQL_injection) or [Cross Site Scripting (XSS)](https://en.wikipedia.org/wiki/Cross-site_scripting) attacks.

[Phalcon\Http\Request](api/Phalcon_Http_Request) allows you to access the values stored in the [$_GET](https://secure.php.net/manual/en/reserved.variables.get.php), [$_POST](https://secure.php.net/manual/en/reserved.variables.post.php) and [$_REQUEST](https://secure.php.net/manual/en/reserved.variables.request.php) arrays and sanitize or filter them with the <filter> service, (by default [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator)).

There are 4 methods that allow you to retrieve submitted data from a request: - `get()` - `getQuery()` - `getPost()` - `getPut()` - `getServer()`

All (except from `getServer()` accept the following parameters: - `name` the name of the value to get - `filters` (array/string) the sanitizers to apply to the value - `defaultValue` returned if the element is not defined (`null`) - `notAllowEmpty` if set (default) and the value is empty, the `defaultValue` will be returned; otherwise `null` - `noRecursive` applies the sanitizers recursively in the value (if value is an array)

```php
$request->get(
    string $name = null, 
    mixed $filters = null, 
    mixed $defaultValue = null, 
    bool notAllowEmpty = false, 
    bool noRecursive = false
): mixed
```

`getServer()` accepts only a `name` (string) variable, representing the name of the server variable that you need to retrieve.

### $_REQUEST

The [$_REQUEST](https://secure.php.net/manual/en/reserved.variables.request.php) superglobal contains an associative array that contains the contents of [$_GET](https://secure.php.net/manual/en/reserved.variables.get.php), [$_POST](https://secure.php.net/manual/en/reserved.variables.post.php) and [$_COOKIE](https://secure.php.net/manual/en/reserved.variables.cookies.php). You can retrieve the data stored in the array by calling the `get()` method in the [Phalcon\Http\Request](api/Phalcon_Http_Request) object as follows:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

// Get the "user_email" field from the $_REQUEST superglobal
$email = $request->get('user_email');

// Get the "user_email" field from the $_REQUEST superglobal.
// Sanitize the value with the "email" sanitizer
$email = $request->get('user_email', 'email', 'some@example.com');

// Get the "user_email" field from the $_REQUEST superglobal. Do not sanitize it.
// If the parameter is null, return the default value
$email = $request->get('user_email', null, 'some@example.com');
```

### $_GET

The [$_GET](https://secure.php.net/manual/en/reserved.variables.get.php) superglobal contains an associative array that contains the variables passed to the current script via URL parameters (also known as the query string). You can retrieve the data stored in the array by calling the `getQuery()` method as follows:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

// Get the "user_email" field from the $_GET superglobal
$email = $request->getQuery('user_email');

// Get the "user_email" field from the $_GET superglobal
// Sanitize the value with the "email" sanitizer
$email = $request->getQuery('user_email', 'email', 'some@example.com');

// Get the "user_email" field from the $_GET superglobal. Do not sanitize it.
// If the parameter is null, return the default value
$email = $request->getQuery('user_email', null, 'some@example.com');
```

### $_POST

The [$_POST](https://secure.php.net/manual/en/reserved.variables.post.php) superglobal contains an associative array that contains the variables passed to the current script via the HTTP POST method when using `application/x-www-form-urlencoded` or `multipart/form-data` as the HTTP `Content-Type` in the request. You can retrieve the data stored in the array by calling the `getPost()` method as follows:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

// Get the "user_email" field from the $_POST superglobal
$email = $request->getPost('user_email');

// Get the "user_email" field from the $_POST superglobal.
// Sanitize the value with the "email" sanitizer
$email = $request->getPost('user_email', 'email', 'some@example.com');

// Get the "user_email" field from the $_POST superglobal. Do not sanitize it.
// If the parameter is null, return the default value
$email = $request->getPost('user_email', null, 'some@example.com');
```

### Put

The request object parses the PUT stream that has been received internally. You can retrieve the data stored in the array by calling the `getPut()` method as follows:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

// Get the "user_email" field from the PUT stream
$email = $request->getPut('user_email');

// Get the "user_email" field from the PUT stream.
// Sanitize the value with the "email" sanitizer
$email = $request->getPut('user_email', 'email', 'some@example.com');

// Get the "user_email" field from the PUT stream. Do not sanitize it.
// If the parameter is null, return the default value
$email = $request->getPut('user_email', null, 'some@example.com');
```

### $_SERVER

The [$_SERVER](https://secure.php.net/manual/en/reserved.variables.server.php) superglobal contains an array containing information such as headers, paths, and script locations. You can retrieve the data stored in the array by calling the `getServer()` method as follows:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

// Get the name of the server $_SERVER superglobal
$name = $request->getServer('SERVER_NAME');
```

## Preset sanitizers

It is relatively common that certain fields are using the same name throughout your application. A field posted from a form in your application can have the same name and function to another form in a different area. Examples of this behavior could be `id` fields, `name` etc.

To make the sanitization process easier, when retrieving such fields, [Phalcon\Http\Request](api/Phalcon_Http_Request) offers a method to define those sanitizing filters based on HTTP methods when setting up the object.

```php
<?php

use Phalcon\Di;
use Phalcon\Filter\FilterLocator;
use Phalcon\Http\Request;

$container = new Di();

$container->set(
    'request',
    function () {
        $request = new Request();
        $request
            ->setParameterFilters('id', FilterLocator::FILTER_ABSINT, ['post'])
            ->setParameterFilters('name', ['trim', 'string'], ['post'])
        ;

        return $request;
    }
);

```

The above will automatically sanitize any parameter that is POSTed from a form that has a name `id` or `name` with their respective filters. Sanitization takes place when calling the following methods (one per HTTP method) - `getFilteredPost()` - `getFilteredPut()` - `getFilteredQuery()`

These methods accept the same parameters as the `getPost()`, `getPut()` and `getQuery()` but without the `$filter` parameter.

## Accessing the Request from Controllers

The most common place to access the request environment is in an action of a controller. To access the [Phalcon\Http\Request](api/Phalcon_Http_Request) object from a controller you will need to use the `$this->request` public property of the controller:

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
            $customerName = $this->request->getPost('name');
            $customerBorn = $this->request->getPost('born', 'string', '1984');
        }
    }
}
```

## Checking operations

The [Phalcon\Http\Request](api/Phalcon_Http_Request) component contains a number of methods that help you check the current operation. For instance if you want to check if a particular request was made using AJAX, you can do so by using the `isAjax()` method. All the methods are prefixed with `is`. - `isAjax()`: Checks whether request has been made using AJAX - `isConnect()`: Checks whether HTTP method is CONNECT - `isDelete()`: Checks whether HTTP method is DELETE - `isGet()`: Checks whether HTTP method is GET - `isHead()`: Checks whether HTTP method is HEAD - `isMethod()`: Check if HTTP method match any of the passed methods - `isOptions()`: Checks whether HTTP method is OPTIONS - `isPatch()`: Checks whether HTTP method is PATCH - `isPost()`: Checks whether HTTP method is POST - `isPurge()`: Checks whether HTTP method is PURGE (Squid and Varnish support) - `isPut()`: Checks whether HTTP method is PUT - `isSecure()`: Checks whether request has been made using any secure layer - `isSoap()`: Checks whether request has been made using SOAP - `isTrace()`: Checks whether HTTP method is TRACE - `isValidHttpMethod()`: Checks if a method is a valid HTTP method

## Checking existence

There are a number of methods available that allow you to check the existence of elements in the request. These methods are prefixed with `has`. Depending on the method used, you can check if an element exists in the `$_REQUEST`, `$_GET`, `$_POST`, `$_SERVER`, `$_FILES`, PUT cache and the request headers. - `has()`: Checks whether the $_REQUEST superglobal has a certain element - `hasFiles()`: Checks whether the request has any uploaded files - `hasHeader()`: Checks whether the headers have a certain element - `hasPost()`: Checks whether $_POST superglobal has a certain element - `hasPut()`: Checks whether the PUT data has a certain element - `hasQuery()`: Checks whether $_GET superglobal has a certain element - `hasServer()`: Checks whether $_SERVER superglobal has a certain element

## Request information

The [Phalcon\Http\Request](api/Phalcon_Http_Request) object offers methods that provide additional information regarding the request.

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
* `getURI()`: Gets HTTP URI which request has been made

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

## Dependency Injection

The [Phalcon\Http\Request](api/Phalcon_Http_Request) object implements the [Phalcon\Di\InjectionAwareInterface](api/Phalcon_Di_InjectionAwareInterface) interface. As a result, the DI container is available and can be retrieved using the `getDI()` method. A container can also be set using the `setDI()` method.

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

## Uploading Files

Another common task is file uploading. [Phalcon\Http\Request](api/Phalcon_Http_Request) offers an object-oriented way work with files. For the whole upload process to work, you will need to make the necessary changes to your `php.ini` (see [php-uploads](https://secure.php.net/manual/en/ini.core.php#ini.file-uploads)).

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
        // Check if the user has uploaded files
        if ($this->request->hasFiles()) {
            $files = $this->request->getUploadedFiles();

            // Print the real file names and sizes
            foreach ($files as $file) {
                // Print file details
                echo $file->getName(), ' ', $file->getSize(), '\n';

                // Move the file into the application
                $file->moveTo(
                    'files/' . $file->getName()
                );
            }
        }
    }
}
```

Each object returned by `Phalcon\Http\Request::getUploadedFiles()` is an instance of the [Phalcon\Http\Request\File](api/Phalcon_Http_Request_File) class. Using the `$_FILES` superglobal array offers the same behavior. `Phalcon\Http\Request\File` encapsulates only the information related to each file uploaded with the request.

The `getUploadedFiles()` accepts two parameters. - `$onlySuccessful`: Contains only successful uploads - `$namedKeys`: Returns the array with named keys obtained by the upload process

## Dependency Injection

The [Phalcon\Http\Request](api/Phalcon_Http_Request) object implements the [Phalcon\Di\InjectionAwareInterface](api/Phalcon_Di_InjectionAwareInterface) interface. As a result, the DI container is available and can be retrieved using the `getDI()` method. A container can also be set using the `setDI()` method.

## Events

| Event                        | Description                                      |
| ---------------------------- | ------------------------------------------------ |
| `afterAuthorizationResolve`  | Fires when the authorization has been resolved   |
| `beforeAuthorizationResolve` | Fires before the authorization has been resolved |

When using HTTP authorization, the `Authorization` header has the following format:

```text
Authorization: <type> <credentials>
```

where `<type>` is an authentication type. A common type is `Basic`. Additional authentication types are described in [IANA registry of Authentication schemes](https://www.iana.org/assignments/http-authschemes/http-authschemes.xhtml) and [Authentication for AWS servers (AWS4-HMAC-SHA256)](https://docs.aws.amazon.com/AmazonS3/latest/API/sigv4-auth-using-authorization-header.html). In most use cases the authentication type is: * `AWS4-HMAC-SHA256` * `Basic` * `Bearer` * `Digest` * `HOBA` * `Mutual` * `Negotiate` * `OAuth` * `SCRAM-SHA-1` * `SCRAM-SHA-256` * `vapid`

You can use the `request:beforeAuthorizationResolve` and `request:afterAuthorizationResolve` events to perform additional operations before or after the authorization resolves. A custom authorization resolver is required.

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

        list($type,) = explode(' ', $data['server']['CUSTOM_KERBEROS_AUTH'], 2);

        if (!$type || stripos($type, 'negotiate') !== 0) {
            return false;
        }

        return [
           'Authorization'=> $data['server']['CUSTOM_KERBEROS_AUTH'],
        ];
    }
}

$_SERVER['CUSTOM_KERBEROS_AUTH'] = 'Negotiate a87421000492aa874209af8bc028';

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