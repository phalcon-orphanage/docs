---
layout: default
language: 'es-es'
version: '4.0'
title: 'Respuesta HTTP'
keywords: 'http, respuesta http, respuesta'
---

# Componente Respuesta

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

[Phalcon\Http\Response](api/phalcon_http#http-response) es un componente que encapsula la respuesta HTTP actual por la aplicación al usuario. La carga útil que se devuelve normalmente son cabeceras y contenido. Tenga en cuenta que esto no es *solo* la carga útil de la respuesta actual. El componente actúa como constructor de la respuesta y como cliente HTTP para enviar la respuesta de vuelta al que llama. Siempre puede usar [Phalcon\Http\Message\Response](api/phalcon_http#http-message-response) para una respuesta compatible con PSR-7 y usar un cliente como Guzzle para enviarla de vuelta al que llama.

```php
<?php

use Phalcon\Http\Response;

// Getting a response instance
$response = new Response();

$response->setStatusCode(404, 'Not Found');
$response->setContent("Sorry, the page doesn't exist");
$response->send();
```

El ejemplo anterior demuestra cómo podemos enviar una página 404 de vuelta al usuario.

El componente implementa los interfaces [Phalcon\Http\ResponseInterface](api/phalcon_http#http-responseinterface), [Phalcon\Di\InjectionAware](api/phalcon_di#di-injectionawareinterface) y [Phalcon\Events\EventsAware](api/phalcon_events#events-eventsawareinterface).

Después de la instanciación, puede usar el constructor para establecer su contenido, el código así como el estado si lo necesita.

```php
<?php

use Phalcon\Http\Response;

// Getting a response instance
$response = new Response(
    "Sorry, the page doesn't exist",
    404, 
    'Not Found'
);

$response->send();
```

Después de configurar toda la información necesaria, podemos llamar al método `send()` para enviar la respuesta de vuelta. Sin embargo, hay instancias que debido a errores o al flujo trabajo de la aplicación, nuestra respuesta podría haber sido ya enviada de vuelta al que llama. Por lo tanto, llamar a `send()` mostrará en pantalla el temido mensaje `cabeceras ya enviadas`.

Para evitar esto podemos usar el método `isSent()` para comprobar si la respuesta ya ha enviado los datos de vuelta al que llama.

```php
<?php

use Phalcon\Http\Response;

// Getting a response instance
$response = new Response(
    "Sorry, the page doesn't exist",
    404, 
    'Not Found'
);

if (true !== $response->isSent()) {
    $response->send();
}
```

## Getters

[Phalcon\Http\Response](api/phalcon_http#http-response) ofrece varios *getters*, lo que le permite recuperar información sobre la respuesta basándose en las necesidades de su aplicación. Los siguiente *getters* están disponibles: - `getContent(): string` - Devuelve el cuerpo de la respuesta HTTP. - `getHeaders(): HeadersInterface` - Devuelve el objeto de cabeceras, conteniendo las cabeceras establecidas por el usuario. - `getReasonPhrase(): string | null` - Devuelve la frase de razón (ej. `Not Found`). El texto devuelto es uno de los especificados en el documento [Códigos de Estado HTTP IANA](https://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml). - `getStatusCode(): int | null` - Devuelve el código de estado (ej. `200`).

## Contenido

Hay un número de métodos disponible que le permiten establecer el contenido o cuerpo de la respuesta. `setContent()` es el método usado más a menudo.

```php
<?php

use Phalcon\Http\Response;

// Getting a response instance
$response = new Response();

$response->setContent("<h1>Hello World!</h1>");
$response->send();
```

También puede acompañarlo con `setContentLength()` que le permite establecer el tamaño o número de bytes que tiene la respuesta, así como `setContentType()` que le dice al destinatario qué tipo de datos es. Esto es especialmente práctico de usar, porque el destinatario (a menudo un navegador) tratará los diferentes tipos de contenido de forma diferente.

> **NOTA**: Todos los *setters* devuelve el objeto de respuesta de vuelta para que sean encadenables, ofreciendo un interfaz más fluido
{: .alert .alert-info }

**Ejemplos**

Fichero PDF:

```php
<?php

use Phalcon\Http\Response;

$response = new Response();
$contents = file_get_contents('/app/storage/files/invoice.pdf');

$response
    ->setContent($contents)
    ->setContentType('application/pdf')
    ->setHeader(
        'Content-Disposition', 
        "attachment; filename='downloaded.pdf'"
    )
    ->send()
;
```

JSON:

```php
<?php

use Phalcon\Http\Response;

$response = new Response();
$contents = [
    'invoice' => [
        'id'    => 12345,
        'name'  => 'invoice.pdf',
        'date'  => '2019-01-01 01:02:03',
        'owner' => 'admin',
    ]   
];

$response
    ->setJsonContent($contents)
    ->send();
```

Tenga en cuenta que en el ejemplo JSON anterior usamos `setJsonContent()` en lugar de `setContent()`. `setJsonContent()` le permite enviar una carga útil al método y automaticamente establecerá la cabecera del tipo de contenido a `application/json` y llamará `json_encode` sobre la carga útil. También puede pasar opciones y profundidad como los últimos dos parámetros del método, que será usado internamente por [json_encode](https://www.php.net/manual/en/function.json-encode.php):

```php
<?php

use Phalcon\Http\Response;

$response = new Response();
$contents = [
    'invoice' => [
        'id'    => 12345,
        'name'  => 'invoice.pdf',
        'date'  => '2019-01-01 01:02:03',
        'owner' => 'admin',
    ]   
];

$response
    ->setJsonContent($contents, JSON_PRETTY_PRINT, 512)
    ->send();
```

Para aplicaciones que necesitan añadir contenido a la respuesta basándose en ciertos criterios (por ejemplo varias sentencias `if`), puede usar el método `appendContent()`, que justo añadirá el nuevo contenido al existente almacenado en el componente.

## Cabeceras

Las cabeceras HTTP son una parte muy importante de la respuesta HTTP, ya que contienen información sobre la respuesta. Información como el estado, tipo de contenido, cache, etc. está envuelto en las cabeceras. El objeto [Phalcon\Http\Response](api/phalcon_http#http-response) ofrece métodos que le permiten manipular esas cabeceras basadas en el flujo de trabajo y necesidades de su aplicación.

Establecer las cabeceras usando el objeto respuesta sólo requiere llamar al método `setHeader()`.

```php
<?php

use Phalcon\Http\Response;

$response = new Response();

$response
    ->setHeader(
        'Content-Type', 
        'application/pdf'
    )
    ->setHeader(
        'Content-Disposition', 
        "attachment; filename='downloaded.pdf'"
    )
;

$response->setRawHeader('HTTP/1.1 200 OK');
```

También puede usar el método `setRawHeader()` para establecer la cabecera usando la sintaxis en bruto.

Puede comprobar si existe una cabecera usando `hasHeader()`, eliminarla usando el método `removeHeader()`, o limpiar las cabeceras completamente usando `resetHeaders()`.

```php
<?php

use Phalcon\Http\Response;

$response = new Response();

$response->setHeader(
    'Content-Type', 
    'application/pdf'
);

if (true === $response->hasHeader('Content-Type')) {
    $response->removeHeader('Content-Type');
}

$response->resetHeaders();
```

Si lo necesita, también puede enviar de vuelta sólo las cabeceras al que llama usando `sendHeaders()`

```php
<?php

use Phalcon\Http\Response;

$response = new Response();

$response->setHeader(
    'Content-Type', 
    'application/pdf'
);

$response->sendHeaders();
```

El objeto [Phalcon\Http\Response](api/phalcon_http#http-response) también envuelve el objeto de colección [Phalcon\Http\Response\Headers](api/phalcon_http#http-response-headers) automáticamente, que ofrece más métodos para manipulación de cabeceras. Puede instanciar un objeto [Phalcon\Http\Response\Headers](api/phalcon_http#http-response-headers) o cualquier objeto que implemente [Phalcon\Http\Response\HeadersInterface](api/phalcon_http#http-response-headersinterface) y entonces establecerlo en la respuesta usando `setHeaders()`:

```php
<?php

use Phalcon\Http\Response;
use Phalcon\Http\Response\Headers;

$response = new Response();
$headers  = new Headers();

$headers
    ->set(
        'Content-Type', 
        'application/pdf'
    )
    ->set(
        'Content-Disposition', 
        "attachment; filename='downloaded.pdf'"
    )
;

$response->setHeaders($headers);
```

> **NOTA**: Tenga en cuenta que usar `setHeaders()` une las cabeceras pasadas con las ya presentes en el objeto de respuesta. El método no limpiará las cabeceras antes de establecerlas. Para llamar las cabeceras necesita llamar `reset()` primero (o `resetHeaders()` en el objeto respuesta).
{: .alert .alert-warning }

El objeto [Phalcon\Http\Response\Headers](api/phalcon_http#http-response-headers) ofrece los siguiente métodos, que le permiten manipular cabeceras:

* `get( string $name ): string | bool` - Obtiene un valor de cabecera del objeto
* `has( string $name ): bool` - Comprueba si una cabecera ya existe en la respuesta
* `remove( string $header )` - Elimina una cabecera de la respuesta
* `reset()` - Resetea todas las cabeceras
* `send(): bool` - Envía las cabeceras al cliente
* `set( string $name, string $value )` - Configura una cabecera para ser enviada al final de la respuesta
* `setRaw( string $header )` Configura una cabecera en bruto para ser enviada al final de la respuesta
* `toArray(): array` - Devuelve las cabeceras actuales como vector

```php
<?php

use Phalcon\Http\Response;

$response = new Response();
$headers  = $response->getHeaders();

$headers->set('Content-Type', 'application/json');

$response->setHeaders($headers);
```

## Cookies

[Phalcon\Http\Response](api/phalcon_http#http-response) ofrece una colección para almacenar y manipular cookies. Entonces puede enviar esas cookies de vuelta con la respuesta.

Para configurar las cookies, necesitará instanciar un objeto [Phalcon\Http\Response\Cookies](api/phalcon_http#http-response-cookies) o cualquier objeto que implemente [Phalcon\Http\Response\CookiesInterface](api/phalcon_http#http-response-cookiesinterface).

```php
<?php

use Phalcon\Http\Response;
use Phalcon\Http\Response\Cookies;

$response = new Response();
$cookies  = new Cookies();

$response->setCookies($cookies);
```

Para obtener las cookies configuradas por el usuario puede usar el método `getCookies()` del objeto [Phalcon\Http\Response](api/phalcon_http#http-response). El método devuelve un objeto de colección [Phalcon\Http\Response\Cookies](api/phalcon_http#http-response-cookies). Puede configurar las cookies en el objeto respuesta usando `setCookies()`, como se muestra arriba, y luego usar `sendCookies()` para enviarlas de vuelta al que invocante.

### `SameSite`

Si está usando PHP 7.3 o posterior puede configurar `SameSite` como un elemento del vector `options` (último parámetro del constructor) o usando `setOptions()`. Es su responsabilidad asignar un valor válido para `SameSite` (como `Strict`, `Lax` etc.)

```php
<?php

use Phalcon\Http\Cookie;

$cookie  = new Cookie(
    'my-cookie',                   // name
    1234,                          // value
    time() + 86400,                // expires
    "/",                           // path
    true,                          // secure
    ".phalcon.io",                 // domain
    true,                          // httponly
    [                              // options
        "samesite" => "Strict",    // 
    ]                              // 
);
```

> **NOTA**: Si su contenedor DI contiene el servicio `session`, las cookies se almacenarán en la sesión automáticamente. Si no, no serán almacenadas, y usted será responsable de persistirlas si lo desea.
{: .alert .alert-info } 

### Encriptación

La colección de cookies se registra automáticamente como parte del servicio `response` que se registra en el contenedor DI. Por defecto, las cookies se encriptan automáticamente antes de enviarlas al cliente y se desencriptan cuando regresan del usuario.

Para poder configurar la clave de firma usada para generar un mensaje puede configurarla en el constructor:

```php
<?php 

use Phalcon\Http\Response;
use Phalcon\Http\Response\Cookies;

$response = new Response();
$signKey  = "#1dj8$=dp?.ak//j1V$~%*0XaK\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\\\x5c";

$cookies  = new Cookies(true, $signKey);

$response->setCookies($cookies);
```

o si quiere puede usar el método `setSignKey()`:

```php
<?php 

use Phalcon\Http\Response;
use Phalcon\Http\Response\Cookies;

$response = new Response();
$signKey  = "#1dj8$=dp?.ak//j1V$~%*0XaK\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\\\x5c";

$cookies  = new Cookies();

$cookies->setSignKey($signKey);

$response->setCookies($cookies);
```

> **NOTA**: `signKey` **DEBE** tener al menos 32 caracteres de longitud, y siempre ayuda si se ha generado usando un pseudo generador aleatorio criptográficamente seguro. Siempre puede usar el componente `Crypt` para generar una buena `signKey`.
{: .alert .alert-danger }


> 
> **NOTA**: Las cookies pueden contener estructuras complejas como información de servicio, conjuntos de resultados, etc. Como resultado, enviar cookies sin encriptación a clientes podría exponer detalles de la aplicación que puede ser usada por los atacantes para comprometer la aplicación y el sistema subyacente. Si no desea usar encriptación, podría enviar sólo identificadores únicos que se podrían vincular a una tabla de base de datos que almacena información más compleja que puede usar su aplicación. 
{: .alert .alert-danger }

### Métodos

Hay varios métodos disponibles para ayudarle a recuperar datos del componente:

* `delete( string $name ): bool` - Elimina una cookie por nombre. Este método **no elimina** las cookies del superglobal `$_COOKIE`
* `get( string $name ): CookieInterface` - Obtiene una cookie por nombre. Comprueba la colección interna y si se encuentra la cookie, la devolverá. Si no se encuentra, recogerá la cookie del superglobal, creará un objeto y luego lo devolverá. **no** lo almacenará en la colección interna porque de lo contrario se enviará dos veces.
* `getCookies(): array` - Devuelve un vector con todas las cookies disponibles en el objeto
* `has( string $name ): bool` - Comprueba la colección interna de cookies **o** el superglobal `$_COOKIE`. Devuelve `true` si la cookie existe en alguna colección, `false` en caso contrario.
* `isUsingEncryption(): bool` - Comprueba si la colección está encriptando/desencriptando cookies automáticamente.
* `reset(): CookiesInterface` - Restablece todas las cookies configuradas de la colección interna
* `send(): bool` - Envía todas las cookies al cliente. Las cookies no se envían si las cabeceras ya se han enviado durante la petición actual
* `setSignKey( string $signKey = null ): CookieInterface` - Establece la clave de firma de cookies. Si se establece en `NULL` se deshabilita la firma.
* `useEncryption( bool $useEncryption ): CookiesInterface` - Establece si las cookies en la bolsa se deben encriptar/desencriptar automáticamente
* `set()` - Configura una cookie para enviarse al final de la petición.

`set(): CookiesInterface` acepta los parámetros siguientes: - `string $name` - El nombre de la cookie - `mixed $value = null` - El valor de la cookie - `int $expire = 0` - La expiración de la cookie - `string $path = "/"` - La ruta de la cookie - `bool $secure = null` - Si la cookie es segura o no - `string $domain = null` - El dominio de la cookie - `bool $httpOnly = null` - Si establecer sólo http o no

```php
<?php

use Phalcon\Http\Response\Cookies;

$now = new DateTimeImmutable();
$tomorrow = $now->modify('tomorrow');

$cookies = new Cookies();
$cookies->set(
    'remember-me',
    json_encode(
        [
            'user_id' => 1,
        ]
    ),
    (int) $tomorrow->format('U')
);
```

## Archivos

El método ayudante `setFileToSend()` le permite fácilmente configurar un fichero para enviarse de vuelta al invocante usando el objeto de respuesta. Esto es particularmente útil cuando queremos introducir la funcionalidad de descarga de ficheros en nuestra aplicación.

El método acepta los siguientes parámetros: - `filePath` - string - La ruta donde reside el fichero - `attachmentName` - string - el nombre con el que el navegador guardará el fichero - `attachment` - bool - si es un adjunto o no (configura cabeceras)

```php
<?php

use Phalcon\Http\Response;

$response = new Response();
$contents = file_get_contents();

$response
    ->setFileToSend(
        '/app/storage/files/invoice.pdf',
        'downloaded.pdf',
        true
    )
    ->send()
;
```

En el ejemplo anterior, establecemos donde viven los ficheros (`/app/storage/files/invoice.pdf`). El segundo parámetro establecerá el nombre del fichero (cuando se descarga por el navegador) a `downloaded.pdf`. El tercer parámetro indica al componente que establezca las cabeceras relevantes para que ocurra la descarga. Estas son:

* `Content-Description: File Transfer`
* `Content-Type: application/octet-stream"`
* `Content-Disposition: attachment; filename=downloaded.pdf;"`
* `Content-Transfer-Encoding: binary"`

Cuando se llama a `send()`, se leerá el fichero usando [readfile()](https://www.php.net/manual/en/function.readfile.php) y los contenidos serán enviados de vuelta al invocante.

## Redirecciones

Con [Phalcon\Http\Response](api/phalcon_http#http-response) también puede ejecutar redirecciones HTTP.

**Ejemplos**

Redirigir al URI por defecto

```php
<?php 

use Phalcon\Http\Response;

$response = new Response();

$response->redirect();
```

Redirige a `posts/index`

```php
<?php 

use Phalcon\Http\Response;

$response = new Response();

$response->redirect('posts/index');
```

Redirigir a una URI externa (fíjese que el segundo parámetro está establecido a `true`)

```php
<?php 

use Phalcon\Http\Response;

$response = new Response();

$response->redirect('https://en.wikipedia.org', true);
```

Redirigir a una URI externa con un código de estado HTTP, útil para redirecciones permanentes o temporales.

```php
<?php 

use Phalcon\Http\Response;

$response = new Response();

$response->redirect('https://www.example.com/new-location', true, 301);
```

Todas las URIs internas son generadas usando el servicio <url> (por defecto [Phalcon\Url](api/phalcon_url)). Este ejemplo demuestra como puede redirigir usando una ruta definida en su aplicación:

```php
<?php 

use Phalcon\Http\Response;

$response = new Response();

return $response->redirect(
    [
        'for'        => 'index-lang',
        'lang'       => 'jp',
        'controller' => 'index',
    ]
);
```

> **NOTA**: Incluso si hay una vista asociada a la acción actual, no será renderizada ya que `redirect` deshabilita la vista.
{: .alert .alert-warning }

## Caché HTTP

Una de las formas más fáciles de mejorar el rendimiento de su aplicación y reducir el tráfico es usando el Caché HTTP. El objeto [Phalcon\Http\Response](api/phalcon_http#http-response) expone métodos que ayudan con esta tarea.

> **NOTA**: Dependiendo de las necesidades de su aplicación, podría no querer controlar el caché HTTP usando Phalcon. Hay varios servicios disponibles en Internet que le pueden ayudar con eso y podrían potencialmente ser más baratos y fáciles de mantener (BitMitigate, Varnish, etc.). Implementando Caché HTTP en su aplicación, definitivamente ayudará pero tendrá un pequeño impacto en el rendimiento de su aplicación. Depende de usted decidir qué estrategia es la mejor para su aplicación y audiencia.
{: .alert .alert-info } 

El Caché HTTP se implementa configurando ciertas cabeceras en la respuesta. El caché se establece (usando las cabeceras) en la primera visita del usuario a nuestra aplicación. Las siguientes cabeceras ayudan con el Caché HTTP: * `Expires:` - Establece la fecha de expiración de la página. Una vez que expira la página, el navegador solicitará una copia fresca de la página vs. usar la cacheada. * `Cache-Control:` - Cuánto tiempo se considera que una página es *fresca* en el navegador. * `Last-Modified:` - Cuándo fue la última vez que esta página fue modificada por la aplicación (evita recargar). * `ETag:` - También conocido como *entity tag*, es un identificador único para cada página, creado usando la marca de tiempo de modificación. * `304:` - Envía un `not modified` de vuelta

### `Expires`

La fecha de expiración es una de las formas más fáciles y efectivas de cachear una página en el cliente (navegador). A partir de la fecha actual añadimos la cantidad de tiempo en que la página se almacenará en el caché del navegador. El navegador no solicitará una copia de esta página hasta que el tiempo expire.

```php
<?php

use Phalcon\Http\Response;

$response   = new Response();
$expiryDate = new DateTime();

$expiryDate->modify('+2 months');

$response->setExpires($expiryDate);
```

El componente [Phalcon\Http\Response](api/phalcon_http#http-response) automáticamente formatea la fecha a la zona horaria `GMT` como espera la cabecera `Expires` header. Independientemente de la zona horaria de su aplicación, el componente primero convierte el tiempo a `UTC` y luego establece la cabecera `Expires`. Establecer la expiración con una fecha pasada indicará al navegador que siempre solicite una copia fresca de la página. Esto es particularmente útil si queremos forzar que los navegadores del cliente soliciten una nueva copia de nuestra página.

```php
<?php

use Phalcon\Http\Response;

$response   = new Response();
$expiryDate = new DateTime();

$expiryDate->modify('-10 minutes');

$response->setExpires($expiryDate);
```

> **NOTA**: Los navegadores confían en el reloj de la máquina del cliente para identificar si la fecha ha pasado o no. Por lo tanto, este mecanismo de cacheado tiene algunas limitaciones que el desarrollador debe tener en cuenta (diferentes zonas horarias, desviación del reloj, etc.)
{: .alert .alert-warning }

### `Cache-Control`

Esta cabecera proporciona algo mejor para cachear las páginas servidas. Simplemente especificamos un tiempo en segundos, indicando al navegador que nuestro contenido está cacheado durante esa cantidad de tiempo.

```php
<?php

use Phalcon\Http\Response;

$response = new Response();

$response->setHeader(
    'Cache-Control', 
    'max-age=86400'
);
```

Si no quiere llamar a `setHeaders()`, y método útil está disponible para usted `setCache()` que establece `Cache-Control` por usted.

```php
<?php

use Phalcon\Http\Response;

$response = new Response();

// $response->setHeader('Cache-Control', 'max-age=86400');
$response->setCache(86400);
```

Para invalidar lo anterior o indicar al navegador que siempre solicite una copia fresca de la página, podemos hacer lo siguiente:

```php
<?php

use Phalcon\Http\Response;

$response = new Response();

$response->setHeader(
    'Cache-Control', 
    'private, max-age=0, must-revalidate'
);
```

### `Last-Modified`

También podemos usar el método `setLastModified()` para indicar al navegador cuándo una página fue modificada por última vez. Esta cabecera es menos precisa que la cabecera `E-Tag` pero puede usarse como mecanismo de respaldo.

```php
<?php

use Phalcon\Http\Response;

$response   = new Response();
$expiryDate = new DateTime();

$expiryDate->modify('+2 months');

$response->setLastModified($expiryDate);
```

El componente [Phalcon\Http\Response](api/phalcon_http#http-response) automáticamente formatea la fecha a la zona horaria `GMT` como espera la cabecera `Last-Modified`. Independientemente de la zona horaria de su aplicación, el componente primero convierte la fecha a `UTC` y luego establece la cabecera `Last-Modified`. Establecer la expiración con una fecha pasada indicará al navegador que siempre solicite una copia fresca de la página. Esto es particularmente útil si queremos forzar que los navegadores del cliente soliciten una nueva copia de nuestra página.

```php
<?php

use Phalcon\Http\Response;

$response   = new Response();
$expiryDate = new DateTime();

$expiryDate->modify('-10 minutes');

$response->setLastModified($expiryDate);
```

### `E-Tag`

Un `entity-tag` o `E-tag` es un identificador único que ayuda al navegador a identificar si la página ha cambiado o no entre peticiones. El identificador se calcula normalmente teniendo en cuenta la fecha de última modificación, el contenido y otros parámetros de identificación de la página:

```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Http\Response;

$response = new Response();

$mostRecentDate = Invoices::maximum(
    [
        'column' => 'inv_created_date',
    ]
);

$eTag = sha1($mostRecentDate);

$response->setHeader('E-Tag', $eTag);
```

### `304`

Generar una respuesta `not-modified` también ayuda con el cacheado, indicando al navegador que los contenidos no se han modificado, y por lo tanto se debería usar la copia de los datos cacheada localmente en el navegador.

```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Http\Response;

$response = new Response();

$response->setNotModified();
```

## Inyección de Dependencias

El objeto [Phalcon\Http\Response](api/phalcon_http#http-response) implementa el interfaz [Phalcon\Di\InjectionAwareInterface](api/phalcon_di#di-injectionawareinterface). Como resultado, el contenedor DI está disponible y puede ser recuperado usando el método `getDI()`. Un contenedor también puede ser establecido usando el método `setDI()`.

Si ha usado el contenedor DI [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) para su aplicación, el servicio ya está registrado para usted. Puede acceder a él usando el nombre `response`. El siguiente ejemplo muestra el uso en un controlador

```php
<?php

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

/**
 * Class PostsController
 * 
 * @property Response $response
 */
class PostsController extends Controller
{
    public function uploadAction()
    {
        return $this
            ->response
            ->setStatusCode(404, 'Not Found')
            ->setContent("Sorry, the page doesn't exist")
            ->send();
    }
}
```

## Eventos

El objeto [Phalcon\Http\Response](api/phalcon_http#http-response) implementa las interfaces [Phalcon\Events\EventsAware](api/phalcon_events#events-eventsawareinterface). Como resultado `getEventsManager()` y `setEventsManager()` están disponibles para usar.

| Evento              | Descripción                                       | Puede parar la operación |
| ------------------- | ------------------------------------------------- |:------------------------:|
| `afterSendHeaders`  | Se dispara después de que se envíen las cabeceras |            No            |
| `beforeSendHeaders` | Se dispara antes de que se envíen las cabeceras   |            Si            |
