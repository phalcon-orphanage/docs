---
layout: default
language: 'es-es'
version: '4.0'
title: 'Fichero Subido HTTP (PSR-7)'
keywords: 'psr-7, http, fichero subido http'
---

# Fichero Subido HTTP (PSR-7)
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen
[Phalcon\Http\Message\UploadedFile](api/phalcon_http#http-message-uploadedfile) es una implementación de la interfaz de mensajería [PSR-7](https://www.php-fig.org/psr/psr-7/) definida por [PHP-FIG](https://www.php-fig.org/).

![](/assets/images/implements-psr--7-blue.svg)

[Phalcon\Http\Message\UploadedFile](api/phalcon_http#http-message-uploadedfile) es un clase que almacena información sobre los ficheros subidos a tu aplicación. facilita el trabajo. Hay varias limitaciones cuando se usa únicamente la variable superglobal `$_FILES`, que resuelve [Phalcon\Http\Message\UploadedFile](api/phalcon_http#http-message-uploadedfile). El objeto [Phalcon\Http\Message\ServerRequest](api/phalcon_http#http-message-serverrequest) te permite obtener todos los ficheros subidos en una estructura normalizada, donde cada hoja es un objeto [Phalcon\Http\Message\UploadedFile](api/phalcon_http#http-message-uploadedfile).

```php
<?php

use Phalcon\Http\Message\UploadedFile;

$file = new UploadedFile(
    'php://memory',
    0,
    UPLOAD_ERR_OK,
    'phalcon.txt'
);

echo $file->getClientFilename(); // 'phalcon.txt'
```

Estamos creando un nuevo [Phalcon\Http\Message\UploadedFile](api/phalcon_http#http-message-uploadedfile) usando el flujo de memoria, con tamaño `0`, indicando que no hay ningún error de subida (`UPLOAD_ERR_OK`) y el nombre del fichero es `phalcon.txt`. Esta información está disponible automáticamente cuando trabajamos con el objeto [Phalcon\Http\Message\ServerRequest](api/phalcon_http#http-message-serverrequest).

## Constructor

```php
public function __construct(
    StreamInterface | string | null $stream 
    [, int $size = null 
    [, int error = 0
    [, string clientFilename = null
    [, string clientMediaType = null ]]]] 
)
```
El constructor acepta parámetros que permiten crear el objeto con ciertas propiedades rellenadas. Se puede definir el flujo, el tamaño del fichero, si ha habido algún error en la subida, el nombre del fichero así como el tipo de medio.

- `stream` - Un flujo válido para el fichero (`StreamInterface`, `string`)
- `size` - El tamaño del fichero
- `error` - Un error de subida (ver las [constantes](https://php.net/manual/en/features.file-upload.errors.php) PHP `UPLOAD_ERR_*`)
- `clientFilename` - El nombre del fichero subido desde el cliente
- `clientMediaType` - El tipo de medio del fichero subido desde el cliente

## Getters

### `getClientFilename()`

Devuelve el nombre del fichero enviado por el cliente. No debería confiar en el valor devuelto por este método. El cliente podría enviar perfectamente un nombre de fichero malicioso con la intención de corromper o hackear su aplicación. El valor devuelto es el valor almacenado en la clave `name` del vector `$_FILES`.

```php
<?php

use Phalcon\Http\Message\UploadedFile;

$file = new UploadedFile(
    'php://memory',
    0,
    UPLOAD_ERR_OK,
    'phalcon.txt'
);

echo $file->getClientFilename(); // 'phalcon.txt'
```

### `getClientMediaType()`

Devuelve el tipo de medio enviado por el cliente. No debería confiar en el valor devuelto por este método. El cliente podría enviar perfectamente un nombre de fichero malicioso con la intención de corromper o hackear su aplicación. El valor devuelto es el valor almacenado en la clave `type` del vector `$_FILES`.

```php
<?php

use Phalcon\Http\Message\UploadedFile;

$file = new UploadedFile(
    'php://memory',
    0,
    UPLOAD_ERR_OK,
    'phalcon.txt',
    'application/text'
);

echo $file->getClientMediaType(); // 'application/text'
```

### `getError()`

 Devuelve el error asociado al fichero subido. El valor es de alguna [constante](https://php.net/manual/en/features.file-upload.errors.php) PHP `UPLOAD_ERR_*`. Si el fichero se ha subido correctamente, el método devolverá `UPLOAD_ERR_OK`. El valor devuelto es el valor almacenado en la clave `error` del vector `$_FILES`.

```php
<?php

use Phalcon\Http\Message\UploadedFile;

$file = new UploadedFile(
    'php://memory',
    0,
    UPLOAD_ERR_OK,
    'phalcon.txt',
    'application/text'
);

echo $file->getError(); // UPLOAD_ERR_OK
```

### `getSize()`

Devuelve el tamaño del fichero subido. El valor devuelto es el valor almacenado en la clave `size` del vector `$_FILES` si está disponible.

```php
<?php

use Phalcon\Http\Message\UploadedFile;

$file = new UploadedFile(
    'php://memory',
    1234,
    UPLOAD_ERR_OK,
    'phalcon.txt'
);

echo $file->getSize(); // 1234
```

### `getStream()`

Devuelve el flujo que representa al fichero subido. El método devuelve una instancia `StreamInterface`. El propósito de este método es permitir utilizar la funcionalidad nativa de flujo de PHP para manipular la carga de archivos, tales como [stream_copy_to_stream()](https://www.php.net/manual/en/function.stream-copy-to-stream.php) (aunque el resultado necesitará ser decorado en un contenedor nativo de flujo de PHP para trabajar con tales funciones).

Si el método `moveTo()` ha sido llamado anteriormente, se lanzará una excepción [Phalcon\Http\Message\Exception\InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception).

```php
<?php

use Phalcon\Http\Message\Stream;
use Phalcon\Http\Message\UploadedFile;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$file = new UploadedFile(
    $stream,
    1234,
    UPLOAD_ERR_OK,
    'phalcon.txt'
);

echo $file->getStream(); // '/assets/stream/mit.txt'
```

## `moveTo()`
Mueve el fichero subido a una nueva ubicación. Este método debe utilizarse como alternativa a [move_uploaded_file()](https://www.php.net/manual/en/function.move-uploaded-file.php). Este método funciona tanto en entornos SAPI como no-SAPI.

El parámetro `$targetPath` puede ser una ruta absoluta o relativa. Cuando se llama a este método, el fichero o flujo original se elimina. Como se ha mencionado anteriormente, si este método se llama más de una vez, cualquier llamada posterior generará una excepción [Phalcon\Http\Message\Exception\InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception).

El método realiza las comprobaciones necesarias internamente para que los permisos se mantengan correctamente. Si necesitas mover el fichero a un flujo, necesitas usar `getStream()`, ya que las operaciones SAPI no pueden garantizar la escritura en flujos de destino.

```php
<?php

use Phalcon\Http\Message\Stream;
use Phalcon\Http\Message\UploadedFile;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$file = new UploadedFile(
    $stream,
    1234,
    UPLOAD_ERR_OK,
    'phalcon.txt'
);

$file->moveTo('/storage/files/');
```
