---
layout: default
language: 'es-es'
version: '4.0'
title: 'Petición HTTP (PSR-7)'
keywords: 'psr-7, http, petición http'
---

# Petición HTTP (PSR-7)

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

[Phalcon\Http\Message\Request](api/phalcon_http#http-message-request) es una implementación de la interfaz de mensajería HTTP [PSR-7](https://www.php-fig.org/psr/psr-7/) definida por [PHP-FIG](https://www.php-fig.org/).

![](/assets/images/implements-psr--7-blue.svg)

Esta implementación ha sido creada para establecer un estándar entre las implementaciones de middleware. A menudo, las aplicaciones necesitan enviar peticiones a destinos externos. Para lograrlo, puede usar el objeto [Phalcon\Http\Message\Request](api/phalcon_http#http-message-request). A cambio, nuestra aplicación recibirá un objeto respuesta.

> **NOTA** Phalcon no le restringe a usar un cliente HTTP específico. Cualquier cliente compatible PSR-7 funcionará con este componente, con lo que podrá realizar sus peticiones.
{: .alert .alert-info }

> 
> **NOTA**: En los ejemplos siguientes, `$httpClient` es el cliente de tu elección que implementa PSR-7. 
{: .alert .alert-info }

```php
<?php

use Phalcon\Http\Message\Request;
use Phalcon\Http\Message\Uri;

$request = new Request();
$uri     = new Uri('https://api.phalcon.io/companies/1');

$jwtToken = 'abc.def.ghi';

$request = $request
   ->withMethod('POST')
   ->withHeader('Authorization', 'Bearer ' . $jwtToken)
   ->withHeader('Content-Type', 'application/json')
;

$result = $httpClient->send($request);
```

Creamos un nuevo objeto [Phalcon\Http\Message\Request](api/phalcon_http#http-message-request) y un nuevo objeto [Phalcon\Http\Message\Uri](api/phalcon_http#http-message-uri) con la URL destino. A continuación, definimos el método (`POST`) y cabeceras adicionales que necesitamos enviar con nuestra petición. El cliente envía la petición usando el objeto petición.

El ejemplo anterior se puede implementar usando únicamente parámetros del constructor:

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => 'application/json',
    ]
);

$result = $httpClient->send($request);
```

El objeto creado [Request](api/phalcon_http#http-message-request) es inmutable, lo que significa que nunca cambiará. Cualquier llamada a los métodos con prefijo `with*` devolverán un clon del objeto para mantener la inmutabilidad, siguiendo el estándar.

## Constructor

```php
public function __construct(
    [string $method = "GET" 
    [, mixed $uri = null 
    [, mixed $body = "php://temp" 
    [, array $headers = [] ]]]]
)
```

El constructor acepta parámetros que le permiten crear el objeto con ciertas propiedades rellenadas. Puede definir el método HTTP destino, la URL, el cuerpo y las cabeceras. Todos los parámetros son opcionales.

- `method` - Por defecto `GET`. Los métodos soportados son: `GET`, `CONNECT`, `DELETE`, `HEAD`, `OPTIONS`, `PATCH`, `POST`, `PUT`, `TRACE`
- `uri` - Una instancia de [Phalcon\Http\Message\Uri](api/phalcon_http#http-message-uri) o una URL.
- `body` - Por defecto `php://memory`. El método acepta un objeto que implemente la interfaz `StreamInterface` o una cadena como nombre del flujo. El modo por defecto para el flujo es `w+b`. Si se pasa un flujo no válido, se lanzará [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception)
- `headers` - Un vector clave valor, con la clave como nombre de la cabecera y el valor como valor de la cabecera.

## Getters

### `getBody()`

Devuelve el cuerpo como un objeto `StreamInterface`

```php
<?php

use Phalcon\Http\Message\Request;
use Phalcon\Http\Message\Stream;

$jwtToken = 'abc.def.ghi';
$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
    $stream,
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => 'application/json',
    ]
);

echo $request->getBody(); // '/assets/stream/mit.txt'
```

### `getHeader()`

Devuelve un vector con todos los valores del nombre de la cabecera indicada insensible a mayúsculas y minúsculas. Si el parámetro de la cadena que representa el nombre de la cabecera solicitada no existe, se devuelve un vector vacío.

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => 'application/json',
    ]
);

echo $request->getHeader('content-Type'); // ['application/json']
echo $request->getHeader('unknown');      // []
```

### `getHeaderLine()`

Devuelve todos los valores del nombre de la cabecera dada insensible a mayúsculas y minúsculas como una cadena concatenada usando coma. Si el parámetro cadena que representa el nombre de la cabecera solicitada no existe, se devuelve una cadena vacía.

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => [
            'application/json',
            'application/html',
        ],
    ]
);

echo $request->getHeaderLine('content-Type'); // 'application/json,application/html'
```

### `getHeaders()`

Devuelve un vector con todos los valores de la cabecera del mensaje. Las claves representan el nombre de la cabecera que será enviada, y cada valor es un vector de cadenas asociadas a dicha cabecera. Aunque los nombres de las cabeceras son insensibles a mayúsculas y minúsculas, este método los mantiene tal y como están especificados en las cabeceras originalmente.

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => [
            'application/json',
            'application/html',
        ],
    ]
);

var_dump(
    $request->getHeaders()
);
// [
//     'Authorization' => 'Bearer abc.def.ghi',
//     'Content-Type'  => [
//         'application/json',
//         'application/html',
//     ],
// ]

```

### `getMethod()`

Devuelve el método como cadena

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => 'application/json',
    ]
);

echo $request->getMethod(); // POST
```

### `getProtocolVersion()`

Devuelve la versión del protocolo como cadena (por defecto `1.1`)

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => 'application/json',
    ]
);

echo $request->getProtocolVersion(); // '1.1'
```

### `getRequestTarget()`

Devuelve una cadena que representa el objetivo de la petición del mensaje tal y como aparecerá (para clientes), como apareció en la petición (para servidores), o como fue especificada en la instancia (ver `withRequestTarget()`). En la mayoría de casos, será el el origen del formulario de la URI compuesta, a menos que se especifique un valor para la implementación concreta (ver `withRequestTarget()`).

```php
<?php

use Phalcon\Http\Message\Request;

$request = new Request();
$request = $request->withRequestTarget('/test');

echo $request->getRequestTarget(); // '/test'
```

### `getUri()`

Devuelve la Uri como un objeto `UriInterface`

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => 'application/json',
    ]
);

echo $request->getUri(); // UriInterface : https://api.phalcon.io/companies/1
```

## Existencia

### `hasHeader()`

Comprueba si existe una cabecera por el nombre dado insensible a mayúsculas y minúsculas. Devuelve `true` si se ha encontrado la cabecera, `false` en caso contrario

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => [
            'application/json',
            'application/html',
        ],
    ]
);

echo $request->hasHeader('content-type'); // true
```

## With

El objeto `Request` es inmutable. Sin embargo, hay una serie de métodos que le permiten inyectar datos en él. El objeto devuelto es un clon del original.

### `withAddedHeader()`

Devuelve una instancia con una cabecera adicional añadida con el valor dado. Se mantendrán los valores existentes para la cabecera especificada. El nuevo o nuevos valores serán añadidos a la lista existente. Si la cabecera no existía previamente, será añadida. Lanza [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) con nombres de cabecera o valores inválidos. Los valores de la cabecera pueden ser una cadena o un vector de cadenas.

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => [
            'application/json',
        ],
    ]
);

var_dump(
    $request->getHeaders()
);
// [
//     'Authorization' => 'Bearer abc.def.ghi',
//     'Content-Type'  => [
//         'application/json',
//     ],
// ]

$clone = $request
    ->withAddedHeader(
        'Content-Type', 
        [
            'application/html'
        ]
    );

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

Devuelve una instancia con el cuerpo del mensaje especificado, que implementa `StreamInterface`. Lanza [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) cuando el cuerpo no es válido.

```php
<?php

use Phalcon\Http\Message\Request;
use Phalcon\Http\Message\Stream;

$jwtToken = 'abc.def.ghi';
$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => 'application/json',
    ]
);

$clone = $request->withBody($stream);

echo $clone->getBody(); // '/assets/stream/mit.txt'
```

### `withHeader()`

Devuelve una instancia con el valor proporcionado reemplazando la cabecera especificada. Mientras que los nombres de cabecera son insensibles a mayúsculas, esta función mantendrá las mayúsculas y minúsculas de la cabecera, y se devolverán con `getHeaders()`. Lanza [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) con nombres de cabecera o valores inválidos.

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
    ]
);

var_dump(
    $request->getHeaders()
);
// [
//     'Authorization' => 'Bearer abc.def.ghi',
// ]

$clone = $request->withAddedHeader(
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

### `withMethod()`

Devuelve una instancia con el método HTTP proporcionado como cadena. Lanza [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) para métodos HTTP inválidos.

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => 'application/json',
    ]
);

echo $request->getMethod(); // POST

$clone = $request->withMethod('GET');

echo $clone->getMethod(); // GET
```

### `withProtocolVersion()`

Devuelve una instancia con la versión del protocolo HTTP especificado (como cadena).

```php
<?php

use Phalcon\Http\Message\Request;

$request  = new Request();

echo $request->getProtocolVersion(); // '1.1'

$clone = $request->withProtocolVersion('2.0');

echo $clone->getProtocolVersion(); // '2.0'
```

### `withRequestTarget()`

Devuelve una instancia con la petición-destino especificada.

```php
<?php

use Phalcon\Http\Message\Request;

$request = new Request();

echo $request->getRequestTarget(); // "/"

$clone = $request->withRequestTarget('/test');

echo $clone->getRequestTarget(); // '/test'
```

### `withUri()`

Devuelve una instancia con la URI `UriInterface` proporcionada. Este método por defecto actualiza la cabecera `Host` de la petición devuelta si la URI contiene un componente servidor. Si la URI no contiene un componente servidor, cualquier cabecera `Host` preexistente será transferida a la petición devuelta.

Puede optar por preservar el estado original de la cabecera `Host` asignando `true` a `$preserveHost`. Cuando `$preserveHost` es `true`, este método interactúa con la cabecera `Host` de la siguiente manera:

- Si la cabecera `Host` no está o está vacía, y la nueva URI contiene un componente servidor, este método actualizará la cabecera `Host` en la petición devuelta.
- Si la cabecera `Host` no está o está vacía, y la nueva URI no contiene un componente servidor, este método no actualizará la cabecera `Host` en la petición devuelta.
- Si la cabecera `Host` está presente y no está vacía, este método no actualizará la cabecera `Host` en la petición devuelta.

```php
<?php

use Phalcon\Http\Message\Request;

$query   = 'https://phalcon.io';
$uri     = new Uri($query);
$request = new Request();

$clone = $request->withUri($uri);

echo $clone->getRequestTarget(); // 'https://phalcon.io'
```

### `withoutHeader()`

Devuelve una instancia sin la cabecera especificada.

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';

$request = new Request(
    'POST',
    'https://api.phalcon.io/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => [
            'application/json',
        ],
    ]
);

var_dump(
    $request->getHeaders()
);
// [
//     'Authorization' => 'Bearer abc.def.ghi',
//     'Content-Type'  => [
//         'application/json',
//     ],
// ]

$clone = $request->withoutHeader('Content-Type');

var_dump(
    $clone->getHeaders()
);
// [
//     'Authorization' => 'Bearer abc.def.ghi',
// ]
```
