---
layout: default
language: 'es-es'
version: '5.0'
title: 'Fichero Subido HTTP (PSR-7)'
keywords: 'psr-7, http, fichero subido http'
---

# Fichero Subido HTTP (PSR-7)
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
[Phalcon\Http\Message\UploadedFile][http-message-uploadedfile] is an implementation of the [PSR-7][psr-7] HTTP messaging interface as defined by [PHP-FIG][php-fig].

![](/assets/images/implements-psr--7-blue.svg)

The [Phalcon\Http\Message\UploadedFile][http-message-uploadedfile] is a value object class that stores information for the uploaded files to your application. facilita el trabajo. There are several limitations when using just the `$_FILES` superglobal, which the [Phalcon\Http\Message\UploadedFile][http-message-uploadedfile] resolves. The [Phalcon\Http\Message\ServerRequest][http-message-serverrequest] object allows you to retrieve all the uploaded files in a normalized structure, which each leaf is a [Phalcon\Http\Message\UploadedFile][http-message-uploadedfile] object.

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

We are creating a new [Phalcon\Http\Message\UploadedFile][http-message-uploadedfile] using the memory stream, with size `0`, specifying that there was no upload error (`UPLOAD_ERR_OK`) and the name of the file is `phalcon.txt`. This information is available to us when working with the [Phalcon\Http\Message\ServerRequest][http-message-serverrequest] object automatically.

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
El constructor acepta parámetros que le permiten crear el objeto con ciertas propiedades rellenadas. Se puede definir el flujo, el tamaño del fichero, si ha habido algún error en la subida, el nombre del fichero así como el tipo de medio.

- `stream` - Un flujo válido para el fichero (`StreamInterface`, `string`)
- `size` - El tamaño del fichero
- `error` - An upload error (see the `UPLOAD_ERR_*`PHP [constants][upload-errors])
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

 Devuelve el error asociado al fichero subido. The value is PHP's `UPLOAD_ERR_*` [constants][upload-errors]. Si el fichero se ha subido correctamente, el método devolverá `UPLOAD_ERR_OK`. El valor devuelto es el valor almacenado en la clave `error` del vector `$_FILES`.

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

Devuelve el flujo que representa al fichero subido. El método devuelve una instancia `StreamInterface`. The purpose of this method is to allow utilizing native PHP stream functionality to manipulate the file upload, such as [stream_copy_to_stream()][stream-copy-to-stream] (though the result will need to be decorated in a native PHP stream wrapper to work with such functions).

If the `moveTo()` method has been called previously, a [Phalcon\Http\Message\Exception\InvalidArgumentException][http-message-exception-invalidargumentexception] exception will be thrown.

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
Mueve el fichero subido a una nueva ubicación. This method should be used as an alternative to [move_uploaded_file()][move-uploaded-file]. Este método funciona tanto en entornos SAPI como no-SAPI.

El parámetro `$targetPath` puede ser una ruta absoluta o relativa. Cuando se llama a este método, el fichero o flujo original se elimina. As noted above, if this method is called more than once, any subsequent calls will raise a [Phalcon\Http\Message\Exception\InvalidArgumentException][http-message-exception-invalidargumentexception] exception.

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

[php-fig]: https://www.php-fig.org/
[psr-7]: https://www.php-fig.org/psr/psr-7/
[http-message-serverrequest]: api/phalcon_http#http-message-serverrequest
[http-message-uploadedfile]: api/phalcon_http#http-message-uploadedfile
[upload-errors]: https://php.net/manual/en/features.file-upload.errors.php
[http-message-exception-invalidargumentexception]: api/phalcon_http#http-message-exception-invalidargumentexception
[move-uploaded-file]: https://www.php.net/manual/en/function.move-uploaded-file.php
[stream-copy-to-stream]: https://www.php.net/manual/en/function.stream-copy-to-stream.php