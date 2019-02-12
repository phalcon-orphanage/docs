---
layout: article
language: 'en'
version: '4.0'
category: 'request'
---
# HTTP Request Component
<hr/>

## Getting Values
PHP automatically fills the superglobal arrays [$_GET][get], [$_POST][post] and [$_REQUEST][request] depending on the type of the request. These arrays contain the values present in forms submitted or the parameters sent via the URL. The variables in the arrays are never sanitized and can contain illegal characters or even malicious code, which can lead to [SQL injection][sql-injection] or [Cross Site Scripting (XSS)][xss] attacks.

[Phalcon\Http\Request](api/Phalcon_Http_Request) allows you to access the values stored in the [$_GET][get], [$_POST][post] and [$_REQUEST][request] arrays and sanitize or filter them with the [filter](filter) service, (by default [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator)). 

There are 4 methods that allow you to retrieve submitted data from a request:
- `get()`
- `getQuery()`
- `getPost()` 
- `getPut()`
- `getServer()`

All (except from `getServer()` accept the following parameters:
- `name` the name of the value to get
- `filters` (array/string) the sanitizers to apply to the value
- `defaultValue` returned if the element is not defined (`null`)
- `notAllowEmpty` if set (default) and the value is empty, the `defaultValue` will be returned; otherwise `null`
- `noRecursive` applies the sanitizers recursively in the value (if value is an array)

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
The [$_REQUEST][request] superglobal contains an associative array that contains the contents of [$_GET][get], [$_POST][post] and [$_COOKIE][cookie]. You can retrieve the data stored in the array by calling the `get()` method in the [Phalcon\Http\Request](api/Phalcon_Http_Request) object as follows: 

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
The [$_GET][get] superglobal contains an associative array that contains the variables passed to the current script via URL parameters (also known as the query string). You can retrieve the data stored in the array by calling the `getQuery()` method as follows: 

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
The [$_POST][post] superglobal contains an associative array that contains the variables passed to the current script via the HTTP POST method when using `application/x-www-form-urlencoded` or `multipart/form-data` as the HTTP `Content-Type` in the request. You can retrieve the data stored in the array by calling the `getPost()` method as follows: 

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
The [$_SERVER][server] superglobal contains an array containing information such as headers, paths, and script locations. You can retrieve the data stored in the array by calling the `getServer()` method as follows: 

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

// Get the name of the server $_SERVER superglobal
$name = $request->getServer('SERVER_NAME');
```

[cookie]: https://secure.php.net/manual/en/reserved.variables.cookies.php
[get]: https://secure.php.net/manual/en/reserved.variables.get.php
[request]: https://secure.php.net/manual/en/reserved.variables.request.php
[post]: https://secure.php.net/manual/en/reserved.variables.post.php
[server]: https://secure.php.net/manual/en/reserved.variables.server.php
[sql-injection]: https://en.wikipedia.org/wiki/SQL_injection
[xss]: https://en.wikipedia.org/wiki/Cross-site_scripting
[iana]: https://www.iana.org/assignments/http-authschemes/http-authschemes.xhtml
[aws-auth]: https://docs.aws.amazon.com/AmazonS3/latest/API/sigv4-auth-using-authorization-header.html
