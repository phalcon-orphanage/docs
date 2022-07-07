---
layout: default
language: 'es-es'
version: '5.0'
title: 'Factorías HTTP (PSR-17)'
keywords: 'psr-17, http, factorías http'
---

# Factorías HTTP (PSR-17)
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
[Phalcon\Http\Message\RequestFactory][http-message-requestfactory], [Phalcon\Http\Message\ResponseFactory][http-message-responsefactory], [Phalcon\Http\Message\ServerRequestFactory][http-message-serverrequestfactory], [Phalcon\Http\Message\StreamFactory][http-message-streamfactory], [Phalcon\Http\Message\UploadedFileFactory][http-message-uploadedfilefactory], [Phalcon\Http\Message\UriFactory][http-message-urifactory] are the factories implemented of the [PSR-17][psr-17] HTTP messaging interface factories as defined by [PHP-FIG][php-fig].

![](/assets/images/implements-psr--17-blue.svg)

These components aid in creating HTTP objects as defined by the [PSR-7][psr-7] standard.

## RequestFactory
The [Phalcon\Http\Message\RequestFactory][http-message-requestfactory] can be used to create [Phalcon\Http\Message\Request][http-message-request] objects.

```php
<?php

use Phalcon\Http\Message\RequestFactory;

$factory = new RequestFactory();

$stream = $factory->createRequest(
    'GET', 
    'https://api.phalcon.io/companies/1'
);
```
El método `createRequest()` acepta una cadena como método (`GET`, `POST` etc.) y la URI y devuelve el objeto de la petición.

## ResponseFactory
The [Phalcon\Http\Message\ResponseFactory][http-message-responsefactory] can be used to create [Phalcon\Http\Message\Response][http-message-response] objects.

```php
<?php

use Phalcon\Http\Message\ResponseFactory;

$factory = new ResponseFactory();

$stream = $factory->createResponse(200, 'OK');
```
El método `createResponse()` acepta un entero con el estado de la respuesta así como una cadena, que representa la frase de razón. Si no se específica la razón, el componente usará el valor por defecto sugerido por el RFC de HTTP.

## ServerRequestFactory
The [Phalcon\Http\Message\ServerRequestFactory][http-message-serverrequestfactory] can be used to create [Phalcon\Http\Message\ServerRequest][http-message-serverrequest] objects.

```php
<?php

use Phalcon\Http\Message\ServerRequestFactory;

$factory = new ServerRequestFactory();

$request = $factory->createServerRequest(
    'GET', 
    'https://api.phalcon.io/companies/1',
    [
        'param' => 'value'
    ]
);
```

`createServerRequest()` crea el nuevo objeto usando un método (`GET`, `POST` etc.), una URI y opcionalmente un vector de parámetros SAPI con los que configurar la instancia de la petición generada.

Además de `createServerRequest()`, la factoría ofrece el método `load()` como ayuda para crear una petición rellenándola desde las variables superglobales.

```php
<?php

use Phalcon\Http\Message\ServerRequestFactory;

$factory = new ServerRequestFactory();

$request = $factory->load(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);
```

Si no se suministra algún argumento, se usará la variable superglobal correspondiente.

## StreamFactory
The [Phalcon\Http\Message\StreamFactory][http-message-streamfactory] can be used to create [Phalcon\Http\Message\Stream][http-message-stream] objects.

```php
<?php

use Phalcon\Http\Message\StreamFactory;

$factory = new StreamFactory();

$stream = $factory->createStream('stream contents');
```

## UploadedFileFactory
The [Phalcon\Http\Message\UploadedFileFactory][http-message-uploadedfilefactory] can be used to create [Phalcon\Http\Message\UploadedFile][http-message-uploadedfile] objects.

```php
<?php

use Phalcon\Http\Message\StreamFactory;
use Phalcon\Http\Message\UploadedFileFactory;

$factory = new UploadedFileFactory();
$streamFactory = new StreamFactory();

$stream = $streamFactory->createStream('stream contents');

$size            = 12345;
$error           = 0;
$clientFilename  = null;
$clientMediaType = null;

$file = $factory->createUploadedFile(
    $stream,
    $size,
    $error,
    $clientFilename,
    $clientMediaType
);
```

Si no se especifica tamaño se obtendrá comprobando el tamaño del flujo. `$error` es el error de subida de fichero PHP, por defecto `0`. Si se indica por el cliente, puede usar `clientFilename` y `clientMediaType`. De lo contrario valdrán `null`.

## UriFactory
The [Phalcon\Http\Message\UriFactory][http-message-urifactory] can be used to create [Phalcon\Http\Message\Uri][http-message-uri] objects.

```php
<?php

use Phalcon\Http\Message\UriFactory;

$factory = new UriFactory();

$uri = $factory->createUri('https://api.phalcon.io/companies/1');
```


[php-fig]: https://www.php-fig.org/
[psr-7]: https://www.php-fig.org/psr/psr-7/
[psr-17]: https://www.php-fig.org/psr/psr-17/
[http-message-request]: api/phalcon_http#http-message-request
[http-message-requestfactory]: api/phalcon_http#http-message-requestfactory
[http-message-response]: api/phalcon_http#http-message-response
[http-message-responsefactory]: api/phalcon_http#http-message-responsefactory
[http-message-serverrequest]: api/phalcon_http#http-message-serverrequest
[http-message-serverrequestfactory]: api/phalcon_http#http-message-serverrequestfactory
[http-message-stream]: api/phalcon_http#http-message-stream
[http-message-streamfactory]: api/phalcon_http#http-message-streamfactory
[http-message-uploadedfile]: api/phalcon_http#http-message-uploadedfile
[http-message-uploadedfilefactory]: api/phalcon_http#http-message-uploadedfilefactory
[http-message-uri]: api/phalcon_http#http-message-uri
[http-message-urifactory]: api/phalcon_http#http-message-urifactory
