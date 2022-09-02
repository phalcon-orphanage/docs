---
layout: default
language: 'es-es'
version: '4.0'
title: 'Factorías HTTP (PSR-17)'
keywords: 'psr-17, http, factorías http'
---

# Factorías HTTP (PSR-17)

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

[Phalcon\Http\Message\RequestFactory](api/phalcon_http#http-message-requestfactory), [Phalcon\Http\Message\ResponseFactory](api/phalcon_http#http-message-responsefactory), [Phalcon\Http\Message\ServerRequestFactory](api/phalcon_http#http-message-serverrequestfactory), [Phalcon\Http\Message\StreamFactory](api/phalcon_http#http-message-streamfactory), [Phalcon\Http\Message\UploadedFileFactory](api/phalcon_http#http-message-uploadedfilefactory), [Phalcon\Http\Message\UriFactory](api/phalcon_http#http-message-urifactory) son las factorías implementadas por las factorías de la interfaz de mensajería HTTP [PSR-17](https://www.php-fig.org/psr/psr-17/) definido por [PHP-FIG](https://www.php-fig.org/).

![](/assets/images/implements-psr--17-blue.svg)

Estos componentes ayudan a crear objetos HTTP según la definición del estándar [PSR-7](https://www.php-fig.org/psr/psr-7/).

## RequestFactory

[Phalcon\Http\Message\RequestFactory](api/phalcon_http#http-message-requestfactory) se puede usar para crear objetos [Phalcon\Http\Message\Request](api/phalcon_http#http-message-request).

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

[Phalcon\Http\Message\ResponseFactory](api/phalcon_http#http-message-responsefactory) se puede usar para crear objetos [Phalcon\Http\Message\Response](api/phalcon_http#http-message-response).

```php
<?php

use Phalcon\Http\Message\ResponseFactory;

$factory = new ResponseFactory();

$stream = $factory->createResponse(200, 'OK');
```

El método `createResponse()` acepta un entero con el estado de la respuesta así como una cadena, que representa la frase de razón. Si no se específica la razón, el componente usará el valor por defecto sugerido por el RFC de HTTP.

## ServerRequestFactory

[Phalcon\Http\Message\ServerRequestFactory](api/phalcon_http#http-message-serverrequestfactory) se usará para crear objetos [Phalcon\Http\Message\ServerRequest](api/phalcon_http#http-message-serverrequest).

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

[Phalcon\Http\Message\StreamFactory](api/phalcon_http#http-message-streamfactory) se usará para crear objetos [Phalcon\Http\Message\Stream](api/phalcon_http#http-message-stream).

```php
<?php

use Phalcon\Http\Message\StreamFactory;

$factory = new StreamFactory();

$stream = $factory->createStream('stream contents');
```

## UploadedFileFactory

[Phalcon\Http\Message\UploadedFileFactory](api/phalcon_http#http-message-uploadedfilefactory) se puede usar para crear objetos [Phalcon\Http\Message\UploadedFile](api/phalcon_http#http-message-uploadedfile).

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

[Phalcon\Http\Message\UriFactory](api/phalcon_http#http-message-urifactory) se puede usar para crear objetos [Phalcon\Http\Message\Uri](api/phalcon_http#http-message-uri).

```php
<?php

use Phalcon\Http\Message\UriFactory;

$factory = new UriFactory();

$uri = $factory->createUri('https://api.phalcon.io/companies/1');
```
