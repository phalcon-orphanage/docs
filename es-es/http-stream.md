---
layout: default
language: 'es-es'
version: '4.0'
title: 'Respuesta HTTP (PSR-7)'
keywords: 'psr-7, http, flujo http'
---

# Respuesta HTTP (PSR-7)
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen
[Phalcon\Http\Message\Stream](api/phalcon_http#http-message-stream) es una implementación del interfaz de mensajería HTTP [PSR-7](https://www.php-fig.org/psr/psr-7/) definido por [PHP-FIG](https://www.php-fig.org/).

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
El primer parámetro puede ser una cadena que indique la ubicación del archivo en el sistema de ficheros o área de almacenamiento. También puede ser un recurso, como el devuelto por un método como [fopen](https://www.php.net/manual/en/function.fopen.php). El segundo parámetro es el modo de apertura del flujo. El modo por defecto es `rb`. Para una lista de modos disponibles, se puede consultar la documentación de [fopen](https://www.php.net/manual/en/function.fopen.php).

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
Devuelve los metadatos del flujo como un vector asociativo. Si el parámetro `$key` se define, se devolverá la cadena del elemento relevante. El método es una envoltura de la función PHP [stream_get_meta_data()](https://php.net/manual/en/function.stream-get-meta-data.php). Si no se encuentra la clave, el método devolverá `null`.

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
Busca el principio del flujo. Usa internamente [fseek()](https://www.php.net/manual/en/function.fseek.php) llamando `seek(0)`. Si el flujo no es consultable, se lanzará `RuntimeException`.

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
Intenta colocarse en una posición del flujo. Usa internamente [fseek()](https://www.php.net/manual/en/function.fseek.php). Acepta:
- `offset` - `int` Desplazamiento sobre el flujo
- `whence` - `int` Especifica como se calculará la posición del cursor teniendo en cuenta el desplazamiento buscado. Los valores correctos son idénticos a los que vienen de serie en PHP como valores de $whence para [fseek()](https://www.php.net/manual/en/function.fseek.php).
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
