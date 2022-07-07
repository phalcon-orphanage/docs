---
layout: default
language: 'es-es'
version: '5.0'
title: 'Respuesta HTTP (PSR-7)'
keywords: 'psr-7, http, respuesta http'
---

# Respuesta HTTP (PSR-7)
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
[Phalcon\Http\Message\Response][http-message-response] is an implementation of the [PSR-7][psr-7] HTTP messaging interface as defined by [PHP-FIG][php-fig].

![](/assets/images/implements-psr--7-blue.svg)

[Phalcon\Http\Message\Response][http-message-response] is a representation of an outgoing, server-side response. Según la especificación HTTP, esta interfaz incluye propiedades para lo siguiente:
 - Versión de protocolo
 - Código de estado y frase de razón
 - Cabeceras
 - Cuerpo del mensaje

> **NOTA**: En los ejemplos siguientes, `$httpClient` es el cliente de su elección que implementa PSR-7. 
> 
> {: .alert .alert-info }

```php
<?php

use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$response = new Response();

$payload = [
    'code'   => 2000,
    'status' => 'success',
    'payload' => [
        'id'   => 12345,
        'name' => 'John Doe',
    ]
];

$stream = new Stream('php://memory', 'wb');
$stream->write(json_encode($payload));

$response = $response
    ->withHeader('Content-Type', 'application/json')
    ->withBody($stream)
    ->withStatus(200)
;

$result = $httpClient->send($response);


$payload = 'The above copyright notice and this permission '
         . 'notice shall be included in all copies or '
         . 'substantial portions of the Software.'
;

$response = $response
    ->withHeader('Content-Type', 'text/html')
    ->withBody($payload)
    ->withStatus(200)
;

$result = $httpClient->send($response);
```

We are creating a new [Phalcon\Http\Message\Response][http-message-response] object with a payload represented as JSON, the necessary headers and the status code. El cliente devuelve entonces la respuesta usando el objeto de la petición.

El ejemplo anterior se puede implementar usando únicamente parámetros del constructor:

```php
<?php

use Phalcon\Http\Message\Response;

$payload = [
    'code'   => 2000,
    'status' => 'success',
    'payload' => [
        'id'   => 12345,
        'name' => 'John Doe',
    ]
];


$request = new Response(
    json_encode($payload),
    200,
    [
        'Content-Type'  => 'application/json',
    ]
);

$result = $httpClient->send($request);
```

The [Response][http-message-response] object created is immutable, meaning it will never change. Cualquier llamada a los métodos con prefijo `with*` devolverán un clon del objeto para mantener la inmutabilidad, siguiendo el estándar.

## Constructor

```php
public function __construct(
    [mixed $body = "php://temp" 
    [, int $code = 200 
    [, array $headers = [] ]]]
)
```
El constructor acepta parámetros que le permiten crear el objeto con ciertas propiedades rellenadas. Puedes definir el cuerpo, código de estado y cabeceras. Todos los parámetros son opcionales.

- `body` - Por defecto `php://memory`. El método acepta un objeto que implemente la interfaz `StreamInterface` o una cadena como nombre del flujo. El modo por defecto para el flujo es `w+b`. If a non valid stream is passed, an [InvalidArgumentException][http-message-exception-invalidargumentexception] is thrown
- `code`  - Un entero que representa el código de estado de la respuesta. Por defecto `200`.
- `headers` - Un vector clave valor, con la clave como nombre de la cabecera y el valor como valor de la cabecera.

## Getters

### `getBody()`

Devuelve el cuerpo como un objeto `StreamInterface`. Este método es útil también cuando es necesario ajustar rápidamente el cuerpo del mensaje. Puede comprobar los métodos a los que puede llamar comprobando la clase [Phalcon\Http\Message\Stream](http-stream).

```php
<?php

use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$response = new Response($stream);

echo $response->getBody(); // '/assets/stream/mit.txt'


$response->getBody()->write('additional content goes here');
```

Para obtener todos el contenido del flujo:

```php
<?php

use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$response = new Response($stream);

$body = $response->getBody();
$body->rewind()

$text = $body->getContents();
```

### `getHeader()`

Devuelve un vector con todos los valores del nombre de la cabecera indicada insensible a mayúsculas y minúsculas. Si el parámetro de la cadena que representa el nombre de la cabecera solicitada no existe, se devuelve un vector vacío.

```php
<?php

use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$response = new Response(
    $stream,
    200,
    [
        'Content-Type'  => 'application/json',
    ]
);

echo $response->getHeader('content-Type'); // ['application/json']
echo $response->getHeader('unknown');      // []
```

### `getHeaderLine()`

Devuelve todos los valores del nombre de la cabecera dada insensible a mayúsculas y minúsculas como una cadena concatenada usando coma. Si el parámetro cadena que representa el nombre de la cabecera solicitada no existe, se devuelve una cadena vacía.

```php
<?php

use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$response = new Response(
    $stream,
    200,
    [
        'Content-Type'  => [
            'application/json',
            'application/html',
        ],
    ]
);

echo $response->getHeaderLine('content-Type'); // 'application/json,application/html'
```

### `getHeaders()`

Devuelve un vector con todos los valores de la cabecera del mensaje. Las claves representan el nombre de la cabecera que será enviada, y cada valor es un vector de cadenas asociadas a dicha cabecera. Aunque los nombres de las cabeceras son insensibles a mayúsculas y minúsculas, este método los mantiene tal y como están especificados en las cabeceras originalmente.

```php
<?php

use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$response = new Response(
    $stream,
    200,
    [
        'Content-Type'  => [
            'application/json',
            'application/html',
        ],
    ]
);

var_dump(
    $response->getHeaders()
);
// [
//     'Content-Type'  => [
//         'application/json',
//         'application/html',
//     ],
// ]
```

### `getProtocolVersion()`

Devuelve la versión del protocolo como cadena (por defecto `1.1`)

```php
<?php


use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$response = new Response(
    $stream,
    200,
    [
        'Content-Type'  => 'application/json',
    ]
);


echo $response->getProtocolVersion(); // '1.1'
```

### `getReasonPhrase()`

Devuelve la frase de razón de la respuesta asociada al código de estado. Ya que la frase de razón no es un elemento obligatorio en la línea de estado de la respuesta, la frase de razón puede estar vacía. The return string comes from the IANA HTTP Status Code Registry, as defined in the [RFC 7231][rfc-7231].

```php
<?php


use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$response = new Response(
    $stream,
    203,
    [
        'Content-Type'  => 'application/json',
    ]
);


echo $response->getReasonPhrase(); // 'Non-Authoritative Information'
```

### `getStatusCode()`

Devuelve el código de estado de la respuesta. El código de estado es un código entero de 3 dígitos, como resultado del servidor al intentar comprender y satisfacer la petición.

```php
<?php

use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$response = new Response(
    $stream,
    203,
    [
        'Content-Type'  => 'application/json',
    ]
);


echo $response->getStatusCode(); // 203
```

### `getUri()`

Devuelve la Uri como un objeto `UriInterface`

```php
<?php

use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$response = new Response(
    $stream,
    200,
    [
        'Content-Type'  => 'application/json',
    ]
);

$response = $response->withUri('https://api.phalcon.io/companies/1');

echo $response->getUri(); // UriInterface : https://api.phalcon.io/companies/1
```

## Existencia

### `hasHeader()`

Comprueba si existe una cabecera por el nombre dado insensible a mayúsculas y minúsculas. Devuelve `true` si se ha encontrado la cabecera, `false` en caso contrario

```php
<?php

use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$response = new Response(
    $stream,
    200,
    [
        'Content-Type'  => [
            'application/json',
            'application/html',
        ],
    ]
);

echo $response->hasHeader('content-type'); // true
```

## With
El objeto `Request` es inmutable. Sin embargo, hay una serie de métodos que le permiten inyectar datos en él. El objeto devuelto es un clon del original.

### `withAddedHeader()`

Devuelve una instancia con una cabecera adicional añadida con el valor dado. Se mantendrán los valores existentes para la cabecera especificada. El nuevo o nuevos valores serán añadidos a la lista existente. Si la cabecera no existía previamente, será añadida. Throws [InvalidArgumentException][http-message-exception-invalidargumentexception] for invalid header names or values. Los valores de la cabecera pueden ser una cadena o un vector de cadenas.

```php
<?php

use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$jwtToken = 'abc.def.ghi';
$response = new Response(
    $stream,
    200,
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => [
            'application/json',
        ],
    ]
);

var_dump(
    $response->getHeaders()
);
// [
//     'Authorization' => 'Bearer abc.def.ghi',
//     'Content-Type'  => [
//         'application/json',
//     ],
// ]

$clone = $response->withAddedHeader('Content-Type', ['application/html']);

var_dump(
    $clone->getHeaders()
);
// [
//     'Authorization' => 'Bearer abc.def.ghi',
//     'Content-Type'  => [
//         'application/json',
//         'application/html',
//     ],
// ]
```

### `withBody()`

Devuelve una instancia con el cuerpo del mensaje especificado, que implementa `StreamInterface`. Throws [InvalidArgumentException][http-message-exception-invalidargumentexception] when the body is not valid.

```php
<?php

use Phalcon\Http\Message\Response;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$jwtToken = 'abc.def.ghi';
$response = new Response(
    null,
    200,
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => 'application/json',
    ]
);

$clone = $response->withBody($stream);

echo $clone->getBody(); // '/assets/stream/mit.txt'
```

### `withHeader()`

Devuelve una instancia con el valor proporcionado reemplazando la cabecera especificada. Mientras que los nombres de cabecera son insensibles a mayúsculas, esta función mantendrá las mayúsculas y minúsculas de la cabecera, y se devolverán con `getHeaders()`. Throws [InvalidArgumentException][http-message-exception-invalidargumentexception] for invalid header names or values.

```php
<?php

use Phalcon\Http\Message\Response;

$jwtToken = 'abc.def.ghi';
$response = new Response(
    null,
    200,
    [
        'Authorization' => 'Bearer ' . $jwtToken,
    ]
);

var_dump(
    $response->getHeaders()
);
// [
//     'Authorization' => 'Bearer abc.def.ghi',
// ]

$clone = $response->withAddedHeader(
    'Content-Type',
    [
        'application/html',
    ]
);

var_dump(
    $clone->getHeaders()
);
// [
//     'Authorization' => 'Bearer abc.def.ghi',
//     'Content-Type'  => [
//         'application/html',
//     ],
// ]
```

### `withProtocolVersion()`

Devuelve una instancia con la versión del protocolo HTTP especificado (como cadena).

```php
<?php

use Phalcon\Http\Message\Response;

$response  = new Request();

echo $response->getProtocolVersion(); // '1.1'

$clone = $response->withProtocolVersion('2.0');

echo $clone->getProtocolVersion(); // '2.0'
```

### `withStatus()`

Devuelve una instancia con el código de estado especificado y, opcionalmente, la frase de razón. If no reason is defined, the reason string will come from the IANA HTTP Status Code Registry, as defined in the [RFC 7231][rfc-7231].

```php
<?php

use Phalcon\Http\Message\Response;

$response  = new Request();

echo $response->getStatusCode();   // 200
echo $response->getReasonPhrase(); // OK

$clone = $response->withStatus(203, 'Something Else');

echo $response->getStatusCode();   // 203
echo $response->getReasonPhrase(); // 'Something Else'
```

### `withUri()`

Devuelve una instancia con la URI `UriInterface` proporcionada. Este método por defecto actualiza la cabecera `Host` de la petición devuelta si la URI contiene un componente servidor. Si la URI no contiene un componente servidor, cualquier cabecera `Host` preexistente será transferida a la petición devuelta.

Puede optar por preservar el estado original de la cabecera `Host` asignando `true` a `$preserveHost`. Cuando `$preserveHost` es `true`, este método interactúa con la cabecera `Host` de la siguiente manera:

- Si la cabecera `Host` no está o está vacía, y la nueva URI contiene un componente servidor, este método actualizará la cabecera `Host` en la petición devuelta.
- Si la cabecera `Host` no está o está vacía, y la nueva URI no contiene un componente servidor, este método no actualizará la cabecera `Host` en la petición devuelta.
- Si la cabecera `Host` está presente y no está vacía, este método no actualizará la cabecera `Host` en la petición devuelta.

```php
<?php

use Phalcon\Http\Message\Response;

$query   = 'https://phalcon.io';
$uri     = new Uri($query);
$request = new Response();

$clone = $request->withUri($uri);

echo $clone->getUri(); // UriInterface: 'https://phalcon.io'
```

### `withoutHeader()`

Devuelve una instancia sin la cabecera especificada.

```php
<?php

use Phalcon\Http\Message\Response;

$jwtToken = 'abc.def.ghi';

$response = new Response(
    null,
    200,
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => [
            'application/json',
        ],
    ]
);

var_dump(
    $response->getHeaders()
);
// [
//     'Authorization' => 'Bearer abc.def.ghi',
//     'Content-Type'  => [
//         'application/json',
//     ],
// ]

$clone = $response->withoutHeader('Content-Type');

var_dump(
    $clone->getHeaders()
);
// [
//     'Authorization' => 'Bearer abc.def.ghi',
// ]
```

[php-fig]: https://www.php-fig.org/
[psr-7]: https://www.php-fig.org/psr/psr-7/
[http-message-response]: api/phalcon_http#http-message-response
[http-message-response]: api/phalcon_http#http-message-response
[rfc-7231]: https://tools.ietf.org/html/rfc7231#section-6
[http-message-exception-invalidargumentexception]: api/phalcon_http#http-message-exception-invalidargumentexception
