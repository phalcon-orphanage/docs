---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Http\Response'
---
# Class **Phalcon\Http\Response**

*implements* [Phalcon\Http\ResponseInterface](Phalcon_Http_ResponseInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/response.zep)

Part of the HTTP cycle is return responses to the clients. Phalcon\HTTP\Response is the Phalcon component responsible to achieve this task. HTTP responses are usually composed by headers and body.

```php
<?php

$response = new \Phalcon\Http\Response();

$response->setStatusCode(200, "OK");
$response->setContent("<html><body>Hello</body></html>");

$response->send();

```

## Métodos

public **__construct** ([*mixed* $content], [*mixed* $code], [*mixed* $status])

Phalcon\Http\Response constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Configura el inyector de dependencia

public **getDI** ()

Devuelve el inyector de dependencias interno

public **setStatusCode** (*mixed* $code, [*mixed* $message])

Sets the HTTP response code

```php
<?php

$response->setStatusCode(404, "Not Found");

```

public **getStatusCode** ()

Devuelve el código del estado

```php
<?php

print_r(
    $response->getStatusCode()
);

```

public **setHeaders** ([Phalcon\Http\Response\HeadersInterface](Phalcon_Http_Response_HeadersInterface) $headers)

Establece externamente una bolsa de cabeceras para la respuesta

public **getHeaders** ()

Devuelve las cabeceras establecidas por el usuario

public **getReasonPhrase** (): *string* | *null*

Returns the reason phrase from the response status

```php
<?php

echo $response->getReasonPhrase();
```

public **setCookies** ([Phalcon\Http\Response\CookiesInterface](Phalcon_Http_Response_CookiesInterface) $cookies)

Establece externamente una bolsa de cookies para la respuesta

public [Phalcon\Http\Response\CookiesInterface](Phalcon_Http_Response_CookiesInterface) **getCookies** ()

Devuelve las cookies establecidas por el usuario

public **setHeader** (*mixed* $name, *mixed* $value)

Sobrescribe una cabecera en la respuesta

```php
<?php

$response->setHeader("Content-Type", "text/plain");

```

public **setRawHeader** (*mixed* $header)

Envía una cabecera sin procesar a la respuesta

```php
<?php

$response->setRawHeader("HTTP/1.1 404 Not Found");

```

public **resetHeaders** ()

Restablece todas las cabeceras establecidas

public **setExpires** ([DateTime](https://php.net/manual/en/class.datetime.php) $datetime)

Establece una cabecera Expires en la respuesta que permite utilizar el caché HTTP

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