---
layout: default
language: 'zh-cn'
version: '4.0'
title: 'HTTP Response'
keywords: 'http, http response, response'
---

# Response Component

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

[Phalcon\Http\Response](api/phalcon_http#http-response) is a component that encapsulates the actual HTTP response by the application to the user. The most commonly returned payload is headers and content. Note that this is not *only* the actual response payload. The component acts as a constructor of the response and as a HTTP client to send the response back to the caller. You can always use the [Phalcon\Http\Message\Response](api/phalcon_http#http-message-response) for a PSR-7 compatible response and use a client such as Guzzle to send it back to the caller.

```php
<?php

use Phalcon\Http\Response;

// Getting a response instance
$response = new Response();

$response->setStatusCode(404, 'Not Found');
$response->setContent("Sorry, the page doesn't exist");
$response->send();
```

The above example demonstrates how we can send a 404 page back to the user.

The component implements the [Phalcon\Http\ResponseInterface](api/phalcon_http#http-responseinterface), [Phalcon\Di\InjectionAware](api/phalcon_di#di-injectionawareinterface) and [Phalcon\Events\EventsAware](api/phalcon_events#events-eventsawareinterface) interfaces.

Upon instantiation, you can use the constructor to set your content, the code as well as the status if you need to.

```php
<?php

use Phalcon\Http\Response;

// Getting a response instance
$response = new Response(
    "Sorry, the page doesn't exist",
    404, 
    'Not Found'
);

$response->send();
```

After we set up all the necessary information, we can call the `send()` method to send the response back. There are however instances that due to errors or application workflow, that our response might have already been sent back to the caller. Calling `send()` will therefore introduce the dreaded `headers already sent` message on screen.

To avoid this we can use the `isSent()` method to check if the response has already sent the data back to the caller.

```php
<?php

use Phalcon\Http\Response;

// Getting a response instance
$response = new Response(
    "Sorry, the page doesn't exist",
    404, 
    'Not Found'
);

if (true !== $response->isSent()) {
    $response->send();
}
```

## Getters

The [Phalcon\Http\Response](api/phalcon_http#http-response) offers several getters, allowing you to retrieve information regarding the response based on your application needs. The following getters are available: - `getContent(): string` - Returns the HTTP response body. - `getHeaders(): HeadersInterface` - Returns the headers object, containing headers set by the user. - `getReasonPhrase(): string | null` - Returns the reason phrase (e.g. `Not Found`). The text returned is the one specified in the [IANA HTTP Status Codes](http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml) document. - `getStatusCode(): int | null` - Returns the status code (e.g. `200`).

## Content

There are a number of methods available that allow you to set the content or body of the response. `setContent()` is the most frequently used method.

```php
<?php

use Phalcon\Http\Response;

// Getting a response instance
$response = new Response();

$response->setContent("<h1>Hello World!</h1>");
$response->send();
```

You can also accompany that with `setContentLength()` which allows you to set the length or number of bytes that the response has, as well as the `setContentType()` which tells the recipient what type the data is. This is especially handy to use, because the recipient (often a browser) will treat different types of content differently.

> **NOTE**: All setters return the response object back so they are chainable, offering a more fluent interface
{: .alert .alert-info }

**Examples**

PDF File:

```php
<?php

use Phalcon\Http\Response;

$response = new Response();
$contents = file_get_contents('/app/storage/files/invoice.pdf');

$response
    ->setContent($contents)
    ->setContentType('application/pdf')
    ->setHeader(
        'Content-Disposition', 
        "attachment; filename='downloaded.pdf'"
    )
    ->send()
;
```

JSON:

```php
<?php

use Phalcon\Http\Response;

$response = new Response();
$contents = [
    'invoice' => [
        'id'    => 12345,
        'name'  => 'invoice.pdf',
        'date'  => '2019-01-01 01:02:03',
        'owner' => 'admin',
    ]   
];

$response
    ->setJsonContent($contents)
    ->send();
```

Note that in the above JSON example we used the `setJsonContent()` instead of the `setContent()`. `setJsonContent()` allows us to send a payload to the method and it will automatically set the content type header to `application/json` and call `json_encode` on the payload. You can also pass options and depth as the last two parameters of the method, which will be used by [json_encode](https://www.php.net/manual/en/function.json-encode.php) internally:

```php
<?php

use Phalcon\Http\Response;

$response = new Response();
$contents = [
    'invoice' => [
        'id'    => 12345,
        'name'  => 'invoice.pdf',
        'date'  => '2019-01-01 01:02:03',
        'owner' => 'admin',
    ]   
];

$response
    ->setJsonContent($contents, JSON_PRETTY_PRINT, 512)
    ->send();
```

For applications that need to add content to the response based on certain criteria (various `if` statements for instance), you can use the `appendContent()` method, which will just add the new content to the existing one stored in the component.

## Headers

The HTTP headers are a very important part of the HTTP response, since they contain information regarding the response. Information such as the status, content type, cache etc. is wrapped in the headers. The [Phalcon\Http\Response](api/phalcon_http#http-response) object offers methods that allow you to manipulate those headers based on your application workflow and needs.

Setting headers using the response object only requires you to call the `setHeader()` method.

```php
<?php

use Phalcon\Http\Response;

$response = new Response();

$response
    ->setHeader(
        'Content-Type', 
        'application/pdf'
    )
    ->setHeader(
        'Content-Disposition', 
        "attachment; filename='downloaded.pdf'"
    )
;

$response->setRawHeader('HTTP/1.1 200 OK');
```

You can also use the `setRawHeader()` method to set the header using the raw syntax.

You can check whether a header exists using `hasHeader()`, remove it using `removeHeader()` method, or clear the headers completely using `resetHeaders()`.

```php
<?php

use Phalcon\Http\Response;

$response = new Response();

$response->setHeader(
    'Content-Type', 
    'application/pdf'
);

if (true === $response->hasHeader('Content-Type')) {
    $response->removeHeader('Content-Type');
}

$response->resetHeaders();
```

If you need to, you can also send only the headers back to the caller using `sendHeaders()`

```php
<?php

use Phalcon\Http\Response;

$response = new Response();

$response->setHeader(
    'Content-Type', 
    'application/pdf'
);

$response->sendHeaders();
```

The [Phalcon\Http\Response](api/phalcon_http#http-response) object also wraps the [Phalcon\Http\Response\Headers](api/phalcon_http#http-response-headers) collection object automatically, which offers more methods for header manipulation. You can instantiate a [Phalcon\Http\Response\Headers](api/phalcon_http#http-response-headers) object or any object that implements the [Phalcon\Http\Response\HeadersInterface](api/phalcon_http#http-response-headersinterface) and then set it in the response using `setHeaders()`:

```php
<?php

use Phalcon\Http\Response;
use Phalcon\Http\Response\Headers;

$response = new Response();
$headers  = new Headers();

$headers
    ->set(
        'Content-Type', 
        'application/pdf'
    )
    ->set(
        'Content-Disposition', 
        "attachment; filename='downloaded.pdf'"
    )
;

$response->setHeaders($headers);
```

> **NOTE**: Note that using `setHeaders()` merges the passed headers with the ones present in the response object already. The method will not clear the headers before setting them. To clear the headers you need to call `reset()` first (or `resetHeaders()` on the response object).
{: .alert .alert-warning }

The [Phalcon\Http\Response\Headers](api/phalcon_http#http-response-headers) object offers the following methods, allowing you to manipulate headers:

* `get( string $name ): string | bool` - Gets a header value from the object
* `has( string $name ): bool` - Sets a header to be sent at the end of the request
* `remove( string $header )` - Removes a header to be sent at the end of the request
* `reset()` - Resets all headers
* `send(): bool` - Sends the headers to the client
* `set( string $name, string $value )` - Sets a header to be sent at the end of the request
* `setRaw( string $header )` Sets a raw header to be sent at the end of the request
* `toArray(): array` - Returns the current headers as an array

```php
<?php

use Phalcon\Http\Response;

$response = new Response();
$headers  = $response->getHeaders();

$headers->set('Content-Type', 'application/json');

$response->setHeaders($headers);
```

## Cookies

The [Phalcon\Http\Response](api/phalcon_http#http-response) offers a collection to store and manipulate cookies. You can then send those cookies back with the response.

To set up cookies you will need to instantiate a [Phalcon\Http\Response\Cookies](api/phalcon_http#http-response-cookies) object or any object that implements the [Phalcon\Http\Response\CookiesInterface](api/phalcon_http#http-response-cookiesinterface).

```php
<?php

use Phalcon\Http\Response;
use Phalcon\Http\Response\Cookies;

$response = new Response();
$cookies  = new Cookies();

$response->setCookies($cookies);
```

To get the cookies set by the user you can use the `getCookies()` method on the [Phalcon\Http\Response](api/phalcon_http#http-response) object. The method returns a [Phalcon\Http\Response\Cookies](api/phalcon_http#http-response-cookies) collection object. You can set the cookies in the response object using the `setCookies()`, as shown above, and then use `sendCookies()` to send them back to the caller.

### `SameSite`

If you are using PHP 7.3 or later you can set the `SameSite` as an element to the `options` array (last parameter of the constructor) or by using `setOptions()`. It is your responsibility to assign a valid value for `SameSite` (such as `Strict`, `Lax` etc.) >

```php
<?php

use Phalcon\Http\Cookie;

$cookie  = new Cookie(
    'my-cookie',                   // name
    1234,                          // value
    time() + 86400,                // expires
    "/",                           // path
    true,                          // secure
    ".phalcon.io",                 // domain
    true,                          // httponly
    [                              // options
        "samesite" => "Strict",    // 
    ]                              // 
);
```

> **NOTE**: If your DI container contains the `session` service, the cookies will be stored in the session automatically. If not, they will not be stored, and you are responsible to persist them if you wish to.
{: .alert .alert-info } 

### Encryption

The cookies collection is automatically registered as part of the `response` service that is registered in the DI container. By default, cookies are automatically encrypted prior to sending them to the client and are decrypted when retrieved from the user.

In order to set the sign key used to generate a message you can either set it in the constructor:

```php
<?php 

use Phalcon\Http\Response;
use Phalcon\Http\Response\Cookies;

$response = new Response();
$signKey  = "#1dj8$=dp?.ak//j1V$~%*0XaK\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\\\x5c";

$cookies  = new Cookies(true, $signKey);

$response->setCookies($cookies);
```

or if you want you can use the `setSignKey()` method:

```php
<?php 

use Phalcon\Http\Response;
use Phalcon\Http\Response\Cookies;

$response = new Response();
$signKey  = "#1dj8$=dp?.ak//j1V$~%*0XaK\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\\\x5c";

$cookies  = new Cookies();

$cookies->setSignKey($signKey);

$response->setCookies($cookies);
```

> **NOTE**: The `signKey` **MUST** be at least 32 characters long, and it always helps if it is generated using a cryptographically secure pseudo random generator. You can always use the `Crypt` component to generate a good `signKey`.
{: .alert .alert-danger }


> 
> **NOTE**: Cookies can contain complex structures such as service information, resultsets etc. As a result, sending cookies without encryption to clients could expose application details that can be used by attackers to compromise the application and underlying system. If you do not wish to use encryption, you could send only unique identifiers that could be tied to a database table that stores more complex information that your application can use. 
{: .alert .alert-danger }

There are several methods available to help you retrieve data from the component:

* `delete( string $name ): bool` - Deletes a cookie by name. This method does not removes cookies from the `$_COOKIE` superglobal
* `get( string $name ): CookieInterface` - Gets a cookie by name
* `getCookies(): array` - Returns an array of all available cookies in the object
* `has( string $name ): bool` - Check if a cookie is defined in the bag or exists in the `$_COOKIE` superglobal
* `isUsingEncryption(): bool` - Returns if the bag is automatically encrypting/decrypting cookies.
* `reset(): CookiesInterface` - Reset all set cookies
* `send(): bool` - Sends all the cookies to the client. Cookies are not sent if headers are already sent during the current request
* `setSignKey( string $signKey = null ): CookieInterface` - Sets the cookie's sign key. If set to `NULL` the signing is disabled.
* `useEncryption( bool $useEncryption ): CookiesInterface` - Set if cookies in the bag must be automatically encrypted/decrypted
* `set()` - Sets a cookie to be sent at the end of the request.

`set(): CookiesInterface` accepts the following parameters: - `string $name` - The name of the cookie - `mixed $value = null` - The value of the cookie - `int $expire = 0` - The expiration of the cookie - `string $path = "/"` - The path of the cookie - `bool $secure = null` - Whether the cookie is secure or not - `string $domain = null` - The domain of the cookie - `bool $httpOnly = null` - Whether to set http only or not

```php
<?php

use Phalcon\Http\Response\Cookies;

$now = new DateTimeImmutable();
$tomorrow = $now->modify('tomorrow');

$cookies = new Cookies();
$cookies->set(
    'remember-me',
    json_encode(
        [
            'user_id' => 1,
        ]
    ),
    (int) $tomorrow->format('U')
);
```

## Files

The `setFileToSend()` helper method allows you to easily set a file to be sent back to the caller using the response object. This is particularly useful when we want to introduce download files functionality in our application.

The method accepts the following parameters: - `filePath` - string - The path of where the file is - `attachmentName` - string - the name that the browser will save the file as - `attachment` - bool - whether this is an attachment or not (sets headers)

```php
<?php

use Phalcon\Http\Response;

$response = new Response();
$contents = file_get_contents();

$response
    ->setFileToSend(
        '/app/storage/files/invoice.pdf',
        'downloaded.pdf',
        true
    )
    ->send()
;
```

In the above example, we set where the file lives (`/app/storage/files/invoice.pdf`). The second parameter will set the name of the file (when downloaded by the browser) to `downloaded.pdf`. The third parameter instructs the component to set the relevant headers for the download to happen. These are:

* `Content-Description: File Transfer`
* `Content-Type: application/octet-stream"`
* `Content-Disposition: attachment; filename=downloaded.pdf;"`
* `Content-Transfer-Encoding: binary"`

When calling `send()`, the file will be read using [readfile()](https://www.php.net/manual/en/function.readfile.php) and the contents will be sent back to the caller.

## Redirections

With [Phalcon\Http\Response](api/phalcon_http#http-response) you can also execute HTTP redirections.

**Examples**

Redirect to the default URI

```php
<?php 

use Phalcon\Http\Response;

$response = new Response();

$response->redirect();
```

Redirect to `posts/index`

```php
<?php 

use Phalcon\Http\Response;

$response = new Response();

$response->redirect('posts/index');
```

Redirect to an external URI (note the second parameter set to `true`)

```php
<?php 

use Phalcon\Http\Response;

$response = new Response();

$response->redirect('https://en.wikipedia.org', true);
```

Redirect to an external URI with a HTTP status code, handy for permanent or temporary redirections.

```php
<?php 

use Phalcon\Http\Response;

$response = new Response();

$response->redirect('https://www.example.com/new-location', true, 301);
```

All internal URIs are generated using the <url> service (by default [Phalcon\Url](api/phalcon_url)). This example demonstrates how you can redirect using a route you have defined in your application:

```php
<?php 

use Phalcon\Http\Response;

$response = new Response();

return $response->redirect(
    [
        'for'        => 'index-lang',
        'lang'       => 'jp',
        'controller' => 'index',
    ]
);
```

> **NOTE**: Even if there is a view associated with the current action, it will not be rendered since `redirect` disables the view.
{: .alert .alert-warning }

## HTTP Cache

One of the easiest ways to improve the performance in your applications and reduce the traffic is using HTTP Cache. The [Phalcon\Http\Response](api/phalcon_http#http-response) object exposes methods that help with this task.

> **NOTE**: Depending on the needs of your application, you might not want to control HTTP caching using Phalcon. There are several services available on the Internet that can help with that and could potentially be cheaper and easier to maintain (BitMitigate, Varnish etc.). Implementing HTTP Cache in your application will definitely help but it will have a small impact in the performance of your application. It is up to you to decide which strategy is best for your application and audience.
{: .alert .alert-info } 

HTTP Cache is implemented by setting certain headers in the response. The cache is set (using the headers) upon the first visit of the user to our application. The following headers help with HTTP Cache: * `Expires:` - Set the expiration date of the page. Once the page expires the browser will request a fresh copy of the page vs. using the cached one. * `Cache-Control:` - How long is a page considered *fresh* in the browser. * `Last-Modified:` - When was the last time that this page was modified by the application (avoids reloading). * `ETag:` - Also known as *entity tag*, is a unique identifier for each page, created using the modification timestamp. * `304:` - Send a `not modified` back

### `Expires`

The expiration date is one of the easiest and most effective ways to cache a page in the client (browser). Starting from the current date we add the amount of time the page will be stored in the browser cache. The browser will not request a copy of this page until the time expires.

```php
<?php

use Phalcon\Http\Response;

$response   = new Response();
$expiryDate = new DateTime();

$expiryDate->modify('+2 months');

$response->setExpires($expiryDate);
```

The [Phalcon\Http\Response](api/phalcon_http#http-response) component automatically formats the date to the `GMT` timezone as expected in an `Expires` header. Irrespective of the timezone of your application, the component converts the time first to `UTC` and then sets the `Expires` header. Setting the expiry with a date in the past will instruct the browser to always request a fresh copy of the page. This is particularly useful if we want to force the client browsers to request a new copy of our page.

```php
<?php

use Phalcon\Http\Response;

$response   = new Response();
$expiryDate = new DateTime();

$expiryDate->modify('-10 minutes');

$response->setExpires($expiryDate);
```

> **NOTE**: Browsers rely on the client machine's clock to identify if the date has passed or not. Therefore this caching mechanism has some limitations that the developer must account for (different timezones, clock skew etc.)
{: .alert .alert-warning }

### `Cache-Control`

This header provides a better to cache the pages served. We simply specify a time in seconds, instructing the browser that our content is cached for that amount of time.

```php
<?php

use Phalcon\Http\Response;

$response = new Response();

$response->setHeader(
    'Cache-Control', 
    'max-age=86400'
);
```

If you do not want to call the `setHeaders()`, a utility method is available to you `setCache()` which sets the `Cache-Control` for you.

```php
<?php

use Phalcon\Http\Response;

$response = new Response();

// $response->setHeader('Cache-Control', 'max-age=86400');
$response->setCache(86400);
```

To invalidate the above or to instruct the browser to always request a fresh copy of the page, we can do the following:

```php
<?php

use Phalcon\Http\Response;

$response = new Response();

$response->setHeader(
    'Cache-Control', 
    'private, max-age=0, must-revalidate'
);
```

### `Last-Modified`

You can also use the `setLastModified()` method to instruct the browser on when the page was last modified. This header is less accurate than the `E-Tag` header but can be used as a fallback mechanism.

```php
<?php

use Phalcon\Http\Response;

$response   = new Response();
$expiryDate = new DateTime();

$expiryDate->modify('+2 months');

$response->setLastModified($expiryDate);
```

The [Phalcon\Http\Response](api/phalcon_http#http-response) component automatically formats the date to the `GMT` timezone as expected in an `Last-Modified` header. Irrespective of the timezone of your application, the component converts the time first to `UTC` and then sets the `Last-Modified` header. Setting the expiry with a date in the past will instruct the browser to always request a fresh copy of the page. This is particularly useful if we want to force the client browsers to request a new copy of our page.

```php
<?php

use Phalcon\Http\Response;

$response   = new Response();
$expiryDate = new DateTime();

$expiryDate->modify('-10 minutes');

$response->setLastModified($expiryDate);
```

### `E-Tag`

An `entity-tag` or `E-tag` is a unique identifier that helps the browser identify if the page has changed or not between requests. The identifier is usually calculated taking into account the last modified date, the contents and other identifying parameters for the page:

```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Http\Response;

$response = new Response();

$mostRecentDate = Invoices::maximum(
    [
        'column' => 'inv_created_date',
    ]
);

$eTag = sha1($mostRecentDate);

$response->setHeader('E-Tag', $eTag);
```

### `304`

Generating a `not-modified` response also helps with caching, by instructing the browser that the contents have not been modified, and therefore the locally cached copy of the data on the browser should be used.

```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Http\Response;

$response = new Response();

$response->setNotModified();
```

## Dependency Injection

The [Phalcon\Http\Response](api/phalcon_http#http-response) object implements the [Phalcon\Di\InjectionAwareInterface](api/phalcon_di#di-injectionawareinterface) interface. As a result, the DI container is available and can be retrieved using the `getDI()` method. A container can also be set using the `setDI()` method.

If you have used the [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) DI container for your application, the service is already registered for you. You can access it using the `response` name. The example below shows the usage in a controller

```php
<?php

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

/**
 * Class PostsController
 * 
 * @property Response $response
 */
class PostsController extends Controller
{
    public function uploadAction()
    {
        return $this
            ->response
            ->setStatusCode(404, 'Not Found')
            ->setContent("Sorry, the page doesn't exist")
            ->send();
    }
}
```

## Events

The [Phalcon\Http\Response](api/phalcon_http#http-response) object implements the [Phalcon\Events\EventsAware](api/phalcon_events#events-eventsawareinterface) interfaces. As a result `getEventsManager()` and `setEventsManager()` are available for you to use.

| Event               | 描述                                      | Can stop operation |
| ------------------- | --------------------------------------- |:------------------:|
| `afterSendHeaders`  | Fires after the headers have been sent  |         否          |
| `beforeSendHeaders` | Fires before the headers have been sent |         是的         |