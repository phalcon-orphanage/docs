---
layout: default
language: 'en'
version: '4.0'
title: 'HTTP Uri (PSR-7)'
keywords: 'psr-7, http, http uri'
---

# HTTP Uri (PSR-7)
<hr />
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

[Phalcon\Http\Message\Uri](api/phalcon_http#http-message-uri) is an implementation of the [PSR-7](https://www.php-fig.org/psr/psr-7/) HTTP messaging interface as defined by [PHP-FIG](https://www.php-fig.org/).

![](/assets/images/implements-psr--7-blue.svg)

The [Phalcon\Http\Message\Uri](api/phalcon_http#http-message-uri) returns a value object representing a URI. The object represents a URI as defined in [RFC 3986](http://tools.ietf.org/html/rfc3986), providing methods for the most common operations. The primary use of this component is for HTTP requests but can be used in other contexts.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri();

echo $uri->getHost(); // 'd.phalcon.ld'
```

The [Uri](api/phalcon_http#http-message-uri) object created is immutable, meaning it will never change. Any call to methods prefixed with `with*` will return a clone of the object to maintain immutability, as per the standard.

## Constructor

```php
public function __construct(
    [string $uri = ''] 
)
```
The constructor accepts an optional string, representing the URI. If specified, the URI will be processed and split into the necessary parts internally.

## Getters

### `__toString()`

Returns the string representation of the URI. Depending on which components of the URI are present, the resulting string is either a full URI or relative reference according to [RFC 3986](http://tools.ietf.org/html/rfc3986), Section 4.1. The method concatenates the various components of the URI.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri();

echo (string) $uri; 
// 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag'
```

### `getAuthority()`

Returns a string representing the authority of the URI. If no authority is present, an empty string is returned. The format of the authority is:

```php
[user-info@]host[:port]
```

If the port is not set, or is one of the standard for the scheme, it will not be returned

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri();

echo $uri->getAuthority(); // 'usr:pass@d.phalcon.ld:8080'
```

### `getFragment()`

Returns a string representing the fragment of the URI. If no fragment is present, an empty string is returned. The value returned will not contain the leading `#` and it will be percent-encoded.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri();

echo $uri->getFragment(); // 'frag'
```

### `getHost()`

Returns a string representing the host component of the URI. If no host is present, an empty string is returned. The value returned will be converted to lowercase.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri();

echo $uri->getHost(); // 'd.phalcon.ld'
```

### `getPath()`

Returns a string representing the path component of the URI. The path can either be empty or absolute (starting with a slash) or rootless (not starting with a slash). Normally, the empty path "" and absolute path `/` are considered equal but this method will not do this normalization automatically. The value returned is percent-encoded.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri();

echo $uri->getPath(); // '/action'
```

### `getPort()`

Returns an integer representing the port component of the URI. If the port is present and it is non-standard for the current scheme, it will be returned. If however it is a standard port for the specified scheme, `null` will be returned. Additionally, if no port is present and no scheme is present then `null` is returned.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri();

echo $uri->getPort(); // 8080
```

### `getQuery()`

Returns a string representing the query of the URI. If no query is present, an empty string is returned. The value returned will not contain the leading `?` and it will be percent-encoded.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri();

echo $uri->getQuery(); // '/par=val'
```

### `getScheme()`

Returns a string representing the scheme of the URI. If the scheme is not present, an empty string is returned. The value returned is converted to lowercase.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri();

echo $uri->getScheme(); // 'https'
```

### `getUserInfo()`

Returns a string representation of the user information of the URI. If no user information is present, an empty string is returned. If both user and password are present, they will be returned together concatenated with a colon (`:`) separating the values.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri();

echo $uri->getUserInfo(); // 'usr:pass'
```

## With
The Request object is immutable. However there are a number of methods that allow you to inject data into it. The returned object is a clone of the original one.

### `withFragment()`

Returns an instance with the new fragment. An empty fragment supplied will remove the fragment from the URI.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri();

echo $uri->getFragment(); // 'frag'

$clone = $uri->withFragment('newfrag');

echo $clone->getFragment(); // 'newfrag'
```

### `withHost()`

Returns an instance with the new host. An empty host supplied will remove the host from the URI.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri();

echo $uri->getHost(); // 'd.phalcon.ld'

$clone = $uri->withHost('a.phalcon.ld');

echo $clone->getHost(); // 'a.phalcon.ld'
```

### `withPath()`

Returns an instance with the new path. An empty path supplied will remove the path from the URI.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri();

echo $uri->getPath(); // '/action'

$clone = $uri->withPath('/create');

echo $clone->getPath(); // '/create'
```

### `withPort()`

Returns an instance with the new port. A `null` port supplied will remove the port from the URI.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri();

echo $uri->getPort(); // 8080

$clone = $uri->withPort(8081);

echo $clone->getPort(); // 8081
```

### `withQuery()`

Returns an instance with the new query. An empty query supplied will remove the query from the URI.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri();

echo $uri->getQuery(); // 'par=val'

$clone = $uri->withQuery('one=two');

echo $clone->getQuery(); // 'one=two'
```

### `withScheme()`

Returns an instance with the new scheme. An empty scheme supplied will remove the scheme from the URI.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri();

echo $uri->getScheme(); // 'https'

$clone = $uri->withScheme('http');

echo $clone->getScheme(); // 'http'
```

### `withUserInfo()`

Returns an instance with the new user information. The password is optional. If an empty user is supplied, it will remove the user information from the URI.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri();

echo $uri->getUserInfo(); // 'usr:pass'

$clone = $uri->withUserInfo('phalcon', 'notsecret');

echo $clone->getUserInfo(); // 'phalcon:notsecret'
```