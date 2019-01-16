* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Http\Response'

* * *

# Class **Phalcon\Http\Response**

*implements* [Phalcon\Http\ResponseInterface](Phalcon_Http_ResponseInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/http/response.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Part of the HTTP cycle is return responses to the clients. Phalcon\HTTP\Response is the Phalcon component responsible to achieve this task. HTTP responses are usually composed by headers and body.

```php
<?php

$response = new \Phalcon\Http\Response();

$response->setStatusCode(200, "OK");
$response->setContent("<html><body>Hello</body></html>");

$response->send();

```

## Methods

public **__construct** ([*mixed* $content], [*mixed* $code], [*mixed* $status])

Phalcon\Http\Response constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Sets the dependency injector

public **getDI** ()

Returns the internal dependency injector

public **setStatusCode** (*mixed* $code, [*mixed* $message])

Sets the HTTP response code

```php
<?php

$response->setStatusCode(404, "Not Found");

```

public **getStatusCode** ()

Returns the status code

```php
<?php

print_r(
    $response->getStatusCode()
);

```

public **setHeaders** ([Phalcon\Http\Response\HeadersInterface](Phalcon_Http_Response_HeadersInterface) $headers)

Sets a headers bag for the response externally

public **getHeaders** ()

Returns headers set by the user

public **getReasonPhrase** (): *string* | *null*

Returns the reason phrase from the response status

```php
<?php

echo $response->getReasonPhrase();
```

public **setCookies** ([Phalcon\Http\Response\CookiesInterface](Phalcon_Http_Response_CookiesInterface) $cookies)

Sets a cookies bag for the response externally

public [Phalcon\Http\Response\CookiesInterface](Phalcon_Http_Response_CookiesInterface) **getCookies** ()

Returns cookies set by the user

public **setHeader** (*mixed* $name, *mixed* $value)

Overwrites a header in the response

```php
<?php

$response->setHeader("Content-Type", "text/plain");

```

public **setRawHeader** (*mixed* $header)

Send a raw header to the response

```php
<?php

$response->setRawHeader("HTTP/1.1 404 Not Found");

```

public **resetHeaders** ()

Resets all the established headers

public **setExpires** ([DateTime](https://php.net/manual/en/class.datetime.php) $datetime)

Sets an Expires header in the response that allows to use the HTTP cache

```php
<?php

$this->response->setExpires(
    new DateTime()
);

```

public **setLastModified** ([DateTime](https://php.net/manual/en/class.datetime.php) $datetime)

Sets Last-Modified header

```php
<?php

$this->response->setLastModified(
    new DateTime()
);

```

public **setCache** (*mixed* $minutes)

Sets Cache headers to use HTTP cache

```php
<?php

$this->response->setCache(60);

```

public **setNotModified** ()

Sends a Not-Modified response

public **setContentType** (*mixed* $contentType, [*mixed* $charset])

Sets the response content-type mime, optionally the charset

```php
<?php

$response->setContentType("application/pdf");
$response->setContentType("text/plain", "UTF-8");

```

public **setContentLength** (*mixed* $contentLength)

Sets the response content-length

```php
<?php

$response->setContentLength(2048);

```

public **setEtag** (*mixed* $etag)

Set a custom ETag

```php
<?php

$response->setEtag(md5(time()));

```

public **redirect** ([*mixed* $location], [*mixed* $externalRedirect], [*mixed* $statusCode])

Redirect by HTTP to another action or URL

```php
<?php

// Using a string redirect (internal/external)
$response->redirect("posts/index");
$response->redirect("https://en.wikipedia.org", true);
$response->redirect("https://www.example.com/new-location", true, 301);

// Making a redirection based on a named route
$response->redirect(
    [
        "for"        => "index-lang",
        "lang"       => "jp",
        "controller" => "index",
    ]
);

```

public **setContent** (*mixed* $content)

Sets HTTP response body

```php
<?php

$response->setContent("<h1>Hello!</h1>");

```

public **setJsonContent** (*mixed* $content, [*mixed* $jsonOptions], [*mixed* $depth])

Sets HTTP response body. The parameter is automatically converted to JSON and also sets default header: Content-Type: "application/json; charset=UTF-8"

```php
<?php

$response->setJsonContent(
    [
        "status" => "OK",
    ]
);

```

public **appendContent** (*mixed* $content)

Appends a string to the HTTP response body

public **getContent** ()

Gets the HTTP response body

public **isSent** ()

Check if the response is already sent

public **sendHeaders** ()

Sends headers to the client

public **sendCookies** ()

Sends cookies to the client

public **send** ()

Prints out HTTP response to the client

public **setFileToSend** (*mixed* $filePath, [*mixed* $attachmentName], [*mixed* $attachment])

Sets an attached file to be sent at the end of the request