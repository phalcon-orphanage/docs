---
layout: default
language: 'es-es'
version: '4.0'
title: 'Petición de Servidor HTTP (PSR-7)'
keywords: 'psr-7, http, petición servidor http'
---

# Petición de Servidor HTTP (PSR-7)
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen
[Phalcon\Http\Message\ServerRequest](api/phalcon_http#http-message-serverrequest) es una implementación de la interfaz de mensajería HTTP [PSR-7](https://www.php-fig.org/psr/psr-7/) definida por [PHP-FIG](https://www.php-fig.org/).

![](/assets/images/implements-psr--7-blue.svg)

Estas implementaciones de interfaz se han creado para establecer un estándar entre implementaciones middleware. Las aplicaciones a menudo necesitan recibir datos de fuentes externas, como de los usuarios que usan la aplicación. [Phalcon\Http\Message\ServerRequest](api/phalcon_http#http-message-serverrequest) representa una petición HTTP entrante del lado del servidor. Por especificación HTTP, esta interfaz incluye propiedades como las siguientes: Estas implementaciones de interfaz se han creado para establecer un estándar entre implementaciones middleware. Las aplicaciones a menudo necesitan recibir datos de fuentes externas, como de los usuarios que usan la aplicación. [Phalcon\Http\Message\ServerRequest](api/phalcon_http#http-message-serverrequest) representa una petición HTTP entrante del lado del servidor. Por la especificación HTTP, esta interfaz incluye propiedades como las siguientes:

- Cabeceras
- Método HTTP
- Cuerpo del mensaje
- Versión del protocolo
- URI

Adicionalmente, encapsula todos los datos que han llegado a la aplicación desde entornos CGI y/o PHP, incluyendo:

- Los valores representados en `$_SERVER`.
- Cualquier cookie proporcionada (generalmente mediante `$_COOKIE`)
- Parámetros de consulta (generalmente mediante `$_GET`, o extraídos mediante [parse_str()](https://www.php.net/manual/en/function.parse-str.php))
- Subir ficheros, si procede (representados en `$_FILES`)
- Parámetros del cuerpo no serializados (generalmente desde `$_POST`)

Los valores de `$_SERVER` son tratados como inmutables, ya que representan el estado de la aplicación en el momento de la petición; como tal, no se proporcionan métodos para permitir modificar estos valores. Los otros valores proporcionan estos métodos, que pueden ser restaurados desde `$_SERVER` o el cuerpo de la petición, y pueden necesitar tratamiento en la aplicación (ej., los parámetros del cuerpo pueden estar no serializados basados en el tipo de contenido).

Además, esta interfaz reconoce la utilidad de introspección de una petición para deducir y emparejar parámetros adicionales (ej: mediante coincidencia en la ruta de una URI, desencriptado de valores en cookies, deserializando contenido del cuerpo no codificado tipo formulario, coincidencia en las cabeceras de autorización de usuarios, etc.). Estos parámetros se almacenen en una propiedad "attributes".

```php
<?php

use Phalcon\Http\Message\ServerRequest;
use Phalcon\Http\Message\Uri;

$request = new Request();
$uri     = new Uri('https://api.phalcon.io/companies/1');

$request = new ServerRequest();
$request = $request
    ->withHeader('Content-Type', ['application/json'])
    ->withMethod('GET')
    ->withProtocolVersion('1.1')
    ->withUploadedFiles($_FILES)
    ->withUri($uri)
;
```

Estamos creando un nuevo objeto [Phalcon\Http\Message\ServerRequest](api/phalcon_http#http-message-serverrequest) y un nuevo objeto [Phalcon\Http\Message\Uri](api/phalcon_http#http-message-uri) con la URL destino. A continuación definimos el método (`GET`), una versión de protocolo, ficheros subidos y cabeceras adicionales.

El ejemplo anterior puede ser implementado usando únicamente los parámetros del constructor:

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest(
    'GET',
    'https://api.phalcon.io/companies/1',
    $_SERVER,
    'php://input',
    [
        'Content-Type'  => 'application/json',
    ],
    $_COOKIE,
    $_GET,
    $_FILES,
    'some body',
    '1.2'
);
```

El objeto creado [ServerRequest](api/phalcon_http#http-message-serverrequest) es inmutable, lo que significa que nunca cambiará. Cualquier llamada a los métodos con prefijo `with*` devolverá un clon del objeto para mantener la inmutabilidad, según el estándar.

## Constructor

```php
public function __construct(
    [string $method = "GET" 
    [, mixed $uri = null 
    [, array serverParams = [],
    [, mixed body = "php://input",
    [, mixed headers = [],
    [, array cookies = [],
    [, array queryParams = [],
    [, array uploadFiles = [],
    [, mixed parsedBody = null,
    [, string protocol = "1.1"]]]]]]]]]]
)
```
El constructor acepta parámetros permitiendo crear el objeto con ciertas propiedades rellenadas. Se pueden definir el método HTTP de destino, la URL, el cuerpo y las cabeceras. Todos los parámetros son opcionales.

- `method` - por defecto `GET`. Los métodos soportados son: `GET`, `CONNECT`, `DELETE`, `HEAD`, `OPTIONS`, `PATCH`, `POST`, `PUT`, `TRACE`
- `uri` - Una instancia de [Phalcon\Http\Message\Uri](api/phalcon_http#http-message-uri) o una URL.
- `serverParams` - Un vector clave valor, con la clave como nombre de la variable del servidor y el valor como valor del servidor
- `body` - Por defecto `php://input`. El método acepta un objeto que implemente el interfaz `StreamInterface` or una cadena como nombre del flujo. El modo por defecto para el flujo es `w+b`. Si se pasa un flujo inválido, se lanzará [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception)
- `headers` - Un vector clave valor, donde la clave es el nombre de la cabecera y el valor el valor de la cabecera.
- `cookies` - Un vector clave valor, con la clave como el nombre de la cookie y el valor el valor de la cookie.
- `queryParams` - Un vector clave valor, con la clave como nombre del parámetro de consulta y el valor como valor del parámetro de consulta.
- `uploadFiles` - Un vector con los ficheros subidos (`$_FILES`)
- `parsedBody` - El cuerpo analizado de la petición del servidor
- `protocol` - Una cadena representando el protocolo (`1.0`, `1.1`)

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest(
    'GET',
    'https://api.phalcon.io/companies/1',
    $_SERVER,
    'php://input',
    [
        'Content-Type'  => 'application/json',
    ],
    $_COOKIE,
    $_GET,
    $_FILES,
    'some body',
    '1.2'
);
```

## Getters

### `getAttribute()`

Devuelve un único atributo de la petición derivada. El método obtiene un único atributo como el producido por `getAttributes()`. El primer parámetro define el nombre del atributo que queremos obtener. También se puede indicar una segunda variable que puede ser usada como valor predeterminado, en caso de que el nombre del atributo solicitado no exista.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest();
$request = $request
    ->withAttribute('one', 'two')
;

echo $request->getAttribute('one');           // 'two'
echo $request->getAttribute('three', 'four'); // 'four'
```

### `getAttributes()`

Devuelve un vector con todos los atributos asociados a la petición. Estos "atributos" de la petición se pueden usar para permitir la inyección de cualquier parámetro derivado de la petición: ej., los resultados de operaciones de coincidencia en la ruta; los resultados desencriptando cookies; los resultados de deserializar cuerpos de mensaje no codificados como formulario; etc. Los atributos serán específicos de la aplicación y la petición, y pueden ser mutables.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest();
$request = $request
    ->withAttribute('one', 'two')
;

var_dump(
    $request->getAttributes()
);

// [
//     'one' => 'two',
// ]
```

### `getBody()`

Devuelve el cuerpo como un objeto `StreamInterface`

```php
<?php

use Phalcon\Http\Message\ServerRequest;
use Phalcon\Http\Message\Stream;

$jwtToken = 'abc.def.ghi';
$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$request = new ServerRequest('GET', null, [], $stream);

echo $request->getBody(); // '/assets/stream/mit.txt'
```

### `getCookieParams()`

Devuelve los cookies de la petición del servidor. El vector devuelto es compatible con la estructura de la variable superglobal `$_COOKIE`.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest(
    'GET',
    'https://api.phalcon.io/companies/1',
    [],
    'php://input',
    [],
    [
        'cookie-one' => 'cookie-value-one',
    ]
);

var_dump(
    $request->getCookieParams()
);

// [
//     'cookie-one' => 'cookie-value-one',
// ]
```

### `getHeader()`

Devuelve un vector con todos los valores de los nombres de las cabeceras pasadas insensibles a mayúsculas y minúsculas. Si el parámetro cadena con el nombre de la cabecera solicitada no existe, se devolverá un vector vacío.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request  = new ServerRequest(
    'POST',
    'https://api.phalcon.io/companies/1',
    [],
    'php://memory',
    [
        'Content-Type' => 'application/json',
    ]
);

echo $request->getHeader('content-Type'); // ['application/json']
echo $request->getHeader('unknown');      // []
```

### `getHeaderLine()`

Devuelve el valor de las cabeceras con los nombres de las cabeceras dadas insensibles concatenadas en una cadena usando una coma. Si el parámetro de cadena que representa el nombre de la cabecera solicitada no existe, se devuelve una cadena vacía.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request  = new ServerRequest(
    'POST',
    'https://api.phalcon.io/companies/1',
    [],
    'php://memory',
    [
        'Content-Type'  => [
            'application/json',
            'application/html',
        ],
    ]
);

echo $request->getHeaderLine('content-Type'); // 'application/json,application/html'
```

### `getHeaders()`

Devuelve un vector con todos los valores de la cabecera del mensaje. Las claves representan el nombre de la cabecera tal y como serán enviadas, y cada valor es un vector de cadenas asociadas con la cabecera. Mientras que los nombres de las cabeceras no distinguen mayúsculas y minúsculas, este método los mantiene tal y como fueron especificados originalmente.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request  = new ServerRequest(
    'POST',
    'https://api.phalcon.io/companies/1',
    [],
    'php://memory',
    [
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

use Phalcon\Http\Message\ServerRequest;

$request  = new ServerRequest('POST');

echo $request->getMethod(); // POST
```

### `getParsedBody()`

Devuelve cualquier parámetro proporcionado en el cuerpo de la petición. Si la petición `Content-Type` es `application/x-www-form-urlencoded` o `multipart/form-data`, y el método de la petición es `POST`, este método devolverá el contenido de `$_POST`. Sino, este método puede devolver cualquier resultado de deserializar el contenido del cuerpo de la petición; del análisis devuelve contenido estructurado, los tipos potenciales serán únicamente vectores u objetos. Si no hay contenido en el cuerpo, se devolverá `null`.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest(
    'POST',
    'https://api.phalcon.io/companies/1',
    $_SERVER,
    'php://input',
    [
        'Content-Type'  => 'application/x-www-form-urlencoded',
    ],
    $_COOKIE,
    $_GET,
    $_FILES,
    $_POST,
    '1.2'
);

var_dump(
    $this->getParsedBody()
);

// $_POST
```

### `getProtocolVersion()`

Devuelve la versión del protocolo como cadena (por defecto `1.1`)

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request  = new ServerRequest();

echo $request->getProtocolVersion(); // '1.1'
```

### `getQueryParams()`

Devuelve un vector con los parámetros de la cadena de consulta deserializada, si la hay. Hay que tener en cuenta que los parámetros de la consulta podrían no estar sincronizados con los parámetros de la URI o del servidor. Si necesita asegurarse que sólo está obteniendo los valores originales, puedes analizar la cadena de consulta desde `getUri()->getQuery()` o desde el parámetro de servidor `QUERY_STRING`.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest();
$request = $request->withQueryParams(
    [
        'param' => 'value',
    ]
);

var_dump(
    $request->getQueryParams()
);

// [
//     'param' => 'value',
// ]
```

### `getRequestTarget()`

Devuelve una cadena que representa el mensaje de la petición destino tal y como aparecerá (para los clientes), como apareció en la petición (para servidores), o como fue especificada en la instancia (ver `withRequestTarget()`). En la mayoría de casos, será la forma original de la URI compuesta, a no ser que se haya proporcionado un valor para la implementación determinada (ver `withRequestTarget()`).

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest();
$request = $request->withRequestTarget('/test');

echo $request->getRequestTarget(); // '/test'
```

### `getServerParams()`

Devuelve un vector de datos relacionados con el entorno de la petición entrante, normalmente derivado de la variable de PHP superglobal `$_SERVER`. Sin embargo, no se require que estos datos vengan de `$_SERVER`.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request  = new ServerRequest(
    'POST',
    'https://api.phalcon.io/companies/1',
    $_SERVER
);

var_dump(
    $this->getServerParams()
);

// $_POST

$request  = new ServerRequest(
    'POST',
    'https://api.phalcon.io/companies/1',
    [
        'param' => 'value',
    ]   
);

var_dump(
    $this->getServerParams()
);

// [
//     'param' => 'value',
// ]
```

### `getUploadedFiles()`

Devuelve un vector con los metadatos subidos como un árbol normalizado, donde cada hoja es una instancia de `Psr\Http\Message\UploadedFileInterface`. Estos valores pueden derivar de la variable superglobal `$_FILES` o del cuerpo del mensaje durante la instanciación o puede ser inyectado usando `withUploadedFiles()`. Si no hay datos, se devolverá un vector vacío.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest(
    'GET',
    'https://api.phalcon.io/companies/1',
    $_SERVER,
    'php://input',
    [
        'Content-Type'  => 'application/json',
    ],
    $_COOKIE,
    $_GET,
    $_FILES
);

var_dump(
    $this->getUploadedFiles()
);

// [
//     'my-form' => [
//         'details' => [
//             'invoice' => /* UploadedFileInterface instance */
//         ],
//     ],
// ]
```

### `getUri()`

De vuelve la Uri como un objeto `UriInterface`

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest(
    'POST',
    'https://api.phalcon.io/companies/1'
);

echo $request->getUri(); // UriInterface : https://api.phalcon.io/companies/1
```


## Existencia

### `hasHeader()`

Comprueba si existe una cabecera mediante el nombre dado sin distinguir mayúsculas y minúsculas. Devuelve `true` si se ha encontrado la cabecera, en caso contrario `false`

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$jwtToken = 'abc.def.ghi';

$request = new ServerRequest(
    'GET',
    'https://api.phalcon.io/companies/1',
    $_SERVER,
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
El objeto Request es inmutable. Sin embargo, hay un número de métodos que te permiten inyectar data en él. El objeto devuelto es un clon del original.

### `withAddedHeader()`

Devuelve una instancia con una cabecera adicional añadida con el valor dado. Se mantendrán los valores existentes para la cabecera especificada. El o los nuevos valores serán añadidos a la lista existente. Si la cabecera no existía previamente, será añadida. Lanza [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) para nombres de cabecera o valores inválidos. Los valores de la cabecera pueden ser una cadena o un vector de cadenas.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$jwtToken = 'abc.def.ghi';

$request = new ServerRequest(
    'GET',
    'https://api.phalcon.io/companies/1',
    $_SERVER,
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

### `withAttribute()`

Devuelve una instancia con el atributo especificado de la petición derivada. Este método permite establecer un único atributo de la petición derivada como se describe en `getAttributes()`.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest();

$clone = $request
    ->withAttribute(
        'attribute-name', 
        'attribute-value'
    );

var_dump(
    $clone->getAttributes()
);
// [
//     'attribute-name' => 'attribute-value',
// ]
```

### `withBody()`

Devuelve una instancia con el cuerpo del mensaje especificado que implementa `StreamInterface`. Lanza [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) cuando el cuerpo no es válido.

```php
<?php

use Phalcon\Http\Message\ServerRequest;
use Phalcon\Http\Message\Stream;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$request = new ServerRequest();

$clone = $request->withBody($stream);

echo $clone->getBody(); // '/assets/stream/mit.txt'
```

### `withCookieParams()`

Devuelve una instancia con las cookies especificadas. No es necesario que los datos vengan de la variable superglobal `$_COOKIE` superglobal, pero debe ser compatible con la estructura de `$_COOKIE`. Normalmente, estos datos serán inyectado en la instanciación. Este método no actualiza la cabecera `Cookie` relacionada con la instancia de la petición, ni los valores relacionados con los parámetros del servidor.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest();

$clone = $request
    ->withCookieParams(
        [
            'cookie-name' => 'cookie-value',
        ]
    );

var_dump(
    $clone->getCookieParams()
);
// [
//     'cookie-name' => 'cookie-value',
// ]
```

### `withHeader()`

Devuelve una instancia con el valor proporcionado sustituyendo la cabecera especificada. Mientras que el nombre de las cabeceras no es sensible a mayúsculas y minúsculas, esta función preservará las mayúsculas de la cabecera devueltas por `getHeaders()`. Lanza [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) para nombre de cabecera o valores inválidos.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$jwtToken = 'abc.def.ghi';

$request = new ServerRequest(
    'GET',
    'https://api.phalcon.io/companies/1',
    $_SERVER,
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

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest('POST');

echo $request->getMethod(); // POST

$clone = $request->withMethod('GET');

echo $clone->getMethod(); // GET
```

### `withParsedBody()`

Devuelve una instancia con los parámetros del cuerpo especificados. Si la petición `Content-Type` es `application/x-www-form-urlencoded` o `multipart/form-data`, y el método de la petición es `POST`, este método debería usarse únicamente para inyectar el contenido de `$_POST`. No es necesario que los datos vengan de `$_POST`, sino que serán el resultado de deserializar el contenido del cuerpo de la petición. Deserializado/análisis devuelve datos estructurados, y, como tal, éste método sólo acepta vectores u objetos, o un valor nulo si no hay nada disponible para analizar.

Por ejemplo, si la negociación del contenido detecta que los datos de la petición están en formato JSON, se podría usar este método para crear una instancia de la petición con los parámetros deserializados. Lanza [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) para tipos de argumento no soportados.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest();

$clone = $request->withParsedBody(
    [
        'one' => 'two',
    ]
);

echo $clone->getParsedBody(); 
```

### `withProtocolVersion()`

Devuelve una instancia con la versión del protocolo HTTP especificado (como cadena).

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest();

echo $request->getProtocolVersion(); // '1.1'

$clone = $request->withProtocolVersion('2.0');

echo $clone->getProtocolVersion(); // '2.0'
```

### `withQueryParams()`

Devuelve una instancia con los argumentos de la cadena de consulta especificados. Estos valores permanecen inmutables durante el trayecto de la petición entrante. Puede inyectar estos parámetros durante la instanciación, tanto desde la variable superglobal `$_GET`, como obtenido de algún otro valor como de la URI. En los casos donde los argumentos son analizados desde la URI, los datos son compatibles con lo que la función de PHP [parse_str()](https://www.php.net/manual/en/function.parse-str.php) podría devolver para fijarse en cómo se manejan los parámetros de consulta duplicados, y como se manejan los conjuntos anidados.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest();

$clone = $request->withQueryParams(
    [
        'one' => 'two',
    ]
);

var_dump(
    $clone->getQueryParams()
);

// [
//     'one' => 'two',
// ]
```

### `withRequestTarget()`

Devuelve una instancia con la petición-destino especificada.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest();

echo $request->getRequestTarget(); // "/"

$clone = $request->withRequestTarget('/test');

echo $clone->getRequestTarget(); // '/test'
```

## `withUploadedFiles()`

Crea una nueva instancia con los ficheros subidos especificados. Acepta un árbol de vectores de instancias `UploadedFileInterface`. Lanza [InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) si se indica una estructura inválida.

```php
<?php

use Phalcon\Http\Message\ServerRequest;
use Phalcon\Http\Message\UploadedFile;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$file = new UploadedFile(
    $stream,
    1234,
    UPLOAD_ERR_OK,
    'phalcon.txt'
);

$request = new ServerRequest();

$clone = $request
    ->withUploadedFiles(
        [
            'my-form' => [
                'details' => [
                    'invoice' => $file,
                ] 
            ]          
        ]           
    );

var_dump(
    $this->getUploadedFiles()
);

// [
//     'my-form' => [
//         'details' => [
//             'invoice' => /* UploadedFileInterface instance */
//         ],
//     ],
// ]
```

### `withUri()`

Devuelve una instancia con URI `UriInterface` proporcionada. Este método actualiza la cabecera `Host` de la petición devuelta por defecto si la URI contiene el componente servidor. Si la URI no contiene el componente servidor, cualquier cabecera `Host` preexistente será transferida a la petición devuelta.

Puedes optar por preservar el estado original de la cabecera `Host` estableciendo `$preserveHost` a `true`. Cuando `$preserveHost` se establece a `true`, este método interactúa con la cabecera `Host` de la siguiente manera:

- Si la cabecera `Host` no está o está vacía, y la nueva URI contiene un componente servidor, éste método actualizará la cabecera `Host` en la petición devuelta.
- Si la cabecera `Host` no está o está vacía, y la nueva URI no contiene un componente servidor, este método no actualizará la cabecera `Host` en la petición devuelta.
- Si la cabecera `Host` está presente y no está vacía, este método no actualizará la cabecera `Host` en la petición devuelta.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$query   = 'https://phalcon.io';
$uri     = new Uri($query);
$request = new ServerRequest();

$clone = $request->withUri($uri);

echo $clone->getRequestTarget(); // 'https://phalcon.io'
```

## `withoutAttribute()`

Devuelve una instancia que elimina el atributo especificado de la petición derivada. Este método permite quitar un único atributo de la petición derivada como se describe en `getAttributes()`.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$request = new ServerRequest();

$clone = $request
    ->withAttribute('one', 'two')
    ->withAttribute('three', 'four')
;

var_dump(
    $clone->getAttributes()
);
// [
//     'one'   => 'two',
//     'three' => 'four',
// ]


$newClone = $request
    ->withoutAttribute('one')
;

var_dump(
    $newClone->getAttributes()
);
// [
//     'three' => 'four',
// ]
```

### `withoutHeader()`

Devuelve una instancia sin la cabecera especificada.

```php
<?php

use Phalcon\Http\Message\ServerRequest;

$jwtToken = 'abc.def.ghi';

$request = new ServerRequest(
    'GET',
    'https://api.phalcon.io/companies/1',
    $_SERVER,
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
