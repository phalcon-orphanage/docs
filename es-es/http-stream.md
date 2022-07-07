---
layout: default
language: 'es-es'
version: '5.0'
title: 'Respuesta HTTP (PSR-7)'
keywords: 'psr-7, http, flujo http'
---

# Respuesta HTTP (PSR-7)
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
[Phalcon\Http\Message\Stream][http-message-stream] is an implementation of the [PSR-7][psr-7] HTTP messaging interface as defined by [PHP-FIG][php-fig].

![](/assets/images/implements-psr--7-blue.svg)

Esta clase describe un flujo de datos. Normalmente, una instancia envuelve un flujo PHP, este interfaz provee una envoltura sobre la mayoría de operaciones comunes, incluyendo la serialización de todo el flujo a una cadena.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

echo $stream->getContents(); // 'The MIT License (MIT) ...'
```

## Constructor

```php
public function __construct(
    mixed $stream, 
    string $mode = "rb"
)
```
El primer parámetro puede ser una cadena que indique la ubicación del archivo en el sistema de ficheros o área de almacenamiento. It can also be a resource, as returned by a method such as [fopen][fopen]. El segundo parámetro es el modo de apertura del flujo. El modo por defecto es `rb`. For a list of available modes, you can check the documentation for [fopen][fopen].

- `stream` - cadena o recurso
- `mode` - Cadena que indica el modo en el que el archivo es abierto.

Si hay un error, se lanzará un `RuntimeException`.

## Getters
### `__toString()`
Lee todos los datos del flujo en un cadena, de principio a fin. El método intentará primero `seek()` al principio del flujo antes de leer los datos y leer el flujo hasta que se alcance el final.

> **NOTA** Llamar a este método en archivos grandes provocará que una gran cantidad de datos se carguen en memoria 
> 
> {: .alert .alert-danger }

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

echo (string) $stream; // 'The MIT License (MIT) ...'
```

### `getContents()`
Devuelve una cadena con el contenido restante. Si el flujo no se puede leer o ocurre algún error, se lanzará `RuntimeException`.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

echo $stream->getContents(); // 'The MIT License (MIT) ...'
```

### `getMetadata()`
Devuelve los metadatos del flujo como un vector asociativo. Si el parámetro `$key` se define, se devolverá la cadena del elemento relevante. The method is a wrapper for PHP's [stream_get_meta_data()][stream-get-meta-data] function. Si no se encuentra la clave, el método devolverá `null`.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

var_dump(
    $stream->getMetadata()
);

// [
//     'timed_out'    => false,
//     'blocked'      => true,
//     'eof'          => false,
//     'wrapper_type' => 'plainfile',
//     'stream_type'  => 'STDIO',
//     'mode'         => 'rb',
//     'unread_bytes' => 0,
//     'seekable'     => true,
//     'uri'          => $fileName,
// ];

echo $stream->getMetadata('wrapper_type'); // 'plainfile'
echo $stream->getMetadata('unknown');      // null
```

### `getSize()`
Devuelve el tamaño del flujo. Si no se conoce, se devolverá `null`

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

echo $stream->getSize(); // 1087
```

## Is
### `isSeekable()`
Devuelve `true` si el flujo es consultable, `false` en caso contrario.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

echo $stream->isSeekable(); // 'true'
```

### `isReadable()`
Devuelve `true` si el flujo es legible, `false` en caso contrario.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'w');

echo $stream->isReadable(); // 'false'
```

### `isWritable()`
Devuelve `true` si el flujo es escribible, `false` en caso contrario.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

echo $stream->isWritable(); // 'false'
```

## `close()`
Cierra el flujo y cualquier recurso subyacente.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

$stream->close();
```

## `detach()`
Separa cualquier recurso subyacente del flujo. Después de que el flujo haya sido desvinculado, el flujo queda en un estado inutilizable. Llamar a este método en un flujo cerrado/desvinculado devolverá `null`

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

echo $stream->detach(); // The handle
echo $stream->detach(); // null
```

## `eof()`
Devuelve `true` si flujo está al final del flujo, `false` en caso contrario.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

echo $stream->eof(); // false

$stream->seek(9999);

echo $stream->eof(); // true
```

## `read()`
Lee datos desde el flujo. El método acepta un entero que indique el número de bytes del objeto y los devuelva. El método podría devolver un número menor de bytes que el especificado si se alcanza el final del flujo. Si no hay más datos disponibles se devolverá una cadena vacía. Si ocurre algún error, se lanzará `RuntimeException`.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

echo $stream->read(15); // 'The MIT License'
```

## `rewind()`
Busca el principio del flujo. Uses [fseek()][fseek] calling `seek(0)` internally. Si el flujo no es consultable, se lanzará `RuntimeException`.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

$stream->seek(8);
echo $stream->read(7); // 'License'
$stream->rewind();
echo $stream->read(3); // 'The'
```

## `seek()`
Intenta colocarse en una posición del flujo. Uses [fseek()][fseek] internally. Acepta:
- `offset` - `int` Desplazamiento sobre el flujo
- `whence` - `int` Especifica como se calculará la posición del cursor teniendo en cuenta el desplazamiento buscado. Valid values are identical to the built-in PHP $whence values for [fseek()][fseek].
    - `SEEK_SET` Establece la posición igual a los bytes de desplazamiento
    - `SEEK_CUR` Establece la posición en la ubicación actual más el desplazamiento
    - `SEEK_END` Establece la posición al final del flujo más el desplazamiento.

Si ocurre algún error, se lanzará `RuntimeException`.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

$stream->seek(8);
echo $stream->read(7); // 'License'
$stream->rewind();
echo $stream->read(3); // 'The'
```

## `tell()`
Devuelve la posición actual del puntero de lectura/escritura como entero. Si ocurre algún error, se lanzará `RuntimeException`.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

$stream->seek(8);
echo $stream->tell(); // 8
```

## `write()`
Escribe datos al flujo. Acepta un parámetro `cadena` como contenido a ser escrito. El método devuelve el número de bytes escritos al flujo como entero. Si ocurre algún error, se lanzará `RuntimeException`.

```php
<?php

use Phalcon\Http\Message\Stream;

$stream = new Stream('php://memory', 'wb');
$source = 'The above copyright notice and this permission '
        . 'notice shall be included in all copies or '
        . 'substantial portions of the Software.';

echo $stream->write($source); // 126
```

[php-fig]: https://www.php-fig.org/
[psr-7]: https://www.php-fig.org/psr/psr-7/
[http-message-stream]: api/phalcon_http#http-message-stream
[fopen]: https://www.php.net/manual/en/function.fopen.php
[stream-get-meta-data]: https://php.net/manual/en/function.stream-get-meta-data.php
[fseek]: https://www.php.net/manual/en/function.fseek.php
