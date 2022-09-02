---
layout: default
title: 'Respuesta HTTP'
upgrade: '#http'
keywords: 'http, respuesta http, respuesta'
---

# Componente Respuesta
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen
[Phalcon\Http\Response][http-response] is a component that encapsulates the actual HTTP response by the application to the user. La carga útil que se devuelve normalmente son cabeceras y contenido. Note that this is not _only_ the actual response payload. The component acts as a constructor of the response and as an HTTP client to send the response back to the caller. You can always use the [Phalcon\Http\Message\Response][http-message-response] for a PSR-7 compatible response and use a client such as Guzzle to send it back to the caller.

```php
<?php

use Phalcon\Http\Response;

// Getting a response instance
$response = new Response();

$response->setStatusCode(404, 'Not Found');
$response->setContent("Sorry, the page doesn't exist");
$response->send();
```

The above example demonstrates how we can send a 404-page back to the user.

The component implements the [Phalcon\Http\ResponseInterface][http-responseinterface], [Phalcon\Di\InjectionAware][di-injectionawareinterface] and [Phalcon\Events\EventsAware][events-eventsawareinterface] interfaces.

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
The [Phalcon\Http\Response][http-response] offers several getters, allowing you to retrieve information regarding the response based on your application needs. The following getters are available:

| Nombre                           | Descripción                                                                                                                                  |
| -------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------- |
| `getContent(): string`           | Returns the HTTP response body.                                                                                                              |
| `getHeaders(): HeadersInterface` | Returns the headers object, containing headers set by the user.                                                                              |
| <code>getReasonPhrase(): string&#124;null</code>        | Returns the reason phrase (e.g. `Not Found`). The text returned is the one specified in the [IANA HTTP Status Codes][status-codes] document. |
| <code>getStatusCode(): int&#124;null</code>        | Returns the status code (e.g. `200`).                                                                                                        |


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

> **NOTE**: All setters return the response object back, so they are chainable, offering a more fluent interface 
> 
> {: .alert .alert-info }

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

Tenga en cuenta que en el ejemplo JSON anterior usamos `setJsonContent()` en lugar de `setContent()`. `setJsonContent()` allows us to send a payload to the method, and it will automatically set the content type header to `application/json` and call `json_encode` on the payload. You can also pass options and depth as the last two parameters of the method, which will be used by [json_encode][json-encode] internally:

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
Las cabeceras HTTP son una parte muy importante de la respuesta HTTP, ya que contienen información sobre la respuesta. Information such as the status, content type, cache etc. is wrapped in the headers. The [Phalcon\Http\Response][http-response] object offers methods that allow you to manipulate those headers based on your application workflow and needs.

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

The [Phalcon\Http\Response][http-response] object also wraps the [Phalcon\Http\Response\Headers][http-response-headers] collection object automatically, which offers more methods for header manipulation. You can instantiate a [Phalcon\Http\Response\Headers][http-response-headers] object or any object that implements the [Phalcon\Http\Response\HeadersInterface][http-response-headersinterface] and then set it in the response using `setHeaders()`:

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

> **NOTE**: Note that using `setHeaders()` merges the passed headers with the ones present in the response object already. El método no limpiará las cabeceras antes de establecerlas. Para llamar las cabeceras necesita llamar `reset()` primero (o `resetHeaders()` en el objeto respuesta). 
> 
> {: .alert .alert-warning }

The [Phalcon\Http\Response\Headers][http-response-headers] object offers the following methods, allowing you to manipulate headers:

| Nombre                               | Descripción                                             |
| ------------------------------------ | ------------------------------------------------------- |
| <code>get( string $name ): string&#124;bool</code>            | Gets a header value from the object                     |
| `has( string $name ): bool`          | Checks if a header already exists in the reponse        |
| `remove( string $header )`           | Removes a header from the response                      |
| `reset()`                            | Resets all headers                                      |
| `send(): bool`                       | Envía las cabeceras al cliente                          |
| `set( string $name, string $value )` | Sets a header to be sent at the end of the response     |
| `setRaw( string $header )`           | Sets a raw header to be sent at the end of the response |
| `toArray(): array`                   | Devuelve las cabeceras actuales como un vector          |

```php
<?php

use Phalcon\Http\Response;

$response = new Response();
$headers  = $response->getHeaders();

$headers->set('Content-Type', 'application/json');

$response->setHeaders($headers);
```

## Cookies
The [Phalcon\Http\Response][http-response] offers a collection to store and manipulate cookies. Entonces puede enviar esas cookies de vuelta con la respuesta.

To set up cookies you will need to instantiate a [Phalcon\Http\Response\Cookies][http-response-cookies] object or any object that implements the [Phalcon\Http\Response\CookiesInterface][http-response-cookiesinterface].

```php
<?php

use Phalcon\Http\Response;
use Phalcon\Http\Response\Cookies;

$response = new Response();
$cookies  = new Cookies();

$response->setCookies($cookies);
```

To get the cookies set by the user you can use the `getCookies()` method on the [Phalcon\Http\Response][http-response] object. The method returns a [Phalcon\Http\Response\Cookies][http-response-cookies] collection object. Puede configurar las cookies en el objeto respuesta usando `setCookies()`, como se muestra arriba, y luego usar `sendCookies()` para enviarlas de vuelta al que invocante.

### `SameSite`
If you are using PHP 7.3, or later you can set the `SameSite` as an element to the `options` array (last parameter of the constructor) or by using `setOptions()`. Es su responsabilidad asignar un valor válido para `SameSite` (como `Strict`, `Lax` etc.)

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

> **NOTE**: If your DI container contains the `session` service, the cookies will be stored in the session automatically. Si no, no serán almacenadas, y usted será responsable de persistirlas si lo desea. 
> 
> {: .alert .alert-info }

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

> **NOTE**: The `signKey` **MUST** be at least 32 characters long, and it always helps if it is generated using a cryptographically secure pseudo random generator. Siempre puede usar el componente `Crypt` para generar una buena `signKey`. 
> 
> {: .alert .alert-danger }


> **NOTE**: Cookies can contain complex structures such as service information, resultsets etc. Como resultado, enviar cookies sin encriptación a clientes podría exponer detalles de la aplicación que puede ser usada por los atacantes para comprometer la aplicación y el sistema subyacente. Si no desea usar encriptación, podría enviar sólo identificadores únicos que se podrían vincular a una tabla de base de datos que almacena información más compleja que puede usar su aplicación. 
> 
> {: .alert .alert-danger }

### Métodos

Hay varios métodos disponibles para ayudarle a recuperar datos del componente:

| Método                                                   | Descripción                                                                                                                                                                                                                                                                                  |
| -------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `delete( string $name ): bool`                           | Deletes a cookie by name. This method **does not remove** cookies from the `$_COOKIE` superglobal                                                                                                                                                                                            |
| `get( string $name ): CookieInterface`                   | Gets a cookie by name. Comprueba la colección interna y si se encuentra la cookie, la devolverá. Si no se encuentra, recogerá la cookie del superglobal, creará un objeto y luego lo devolverá. It **will not** store it in the internal collection because it will be sent twice otherwise. |
| `getCookies(): array`                                    | Returns an array of all available cookies in the object                                                                                                                                                                                                                                      |
| `has( string $name ): bool`                              | Checks the internal cookie collection **or** the `$_COOKIE` superglobal. Devuelve `true` si la cookie existe en alguna colección, `false` en caso contrario.                                                                                                                                 |
| `isUsingEncryption(): bool`                              | Returns if the collection is automatically encrypting/decrypting cookies.                                                                                                                                                                                                                    |
| `reset(): CookiesInterface`                              | Reset all set cookies from the internal collection                                                                                                                                                                                                                                           |
| `send(): bool`                                           | Sends all the cookies to the client. Las cookies no se envían si las cabeceras ya se han enviado durante la petición actual                                                                                                                                                                  |
| `setSignKey( string $signKey = null ): CookieInterface`  | Establece la clave de firma de la cookie. Si se establece en `NULL` se deshabilita la firma.                                                                                                                                                                                                 |
| `useEncryption( bool $useEncryption ): CookiesInterface` | Establece si las cookies de la bolsa se deben encriptar/desencriptar automáticamente                                                                                                                                                                                                         |
| `set()`                                                  | Establece una cookie para ser enviada al final de la petición                                                                                                                                                                                                                                |

`set(): CookiesInterface` accepts the following parameters:

| Método                   | Descripción                         |
| ------------------------ | ----------------------------------- |
| `string $name`           | The name of the cookie              |
| `mixed $value = null`    | The value of the cookie             |
| `int $expire = 0`        | The expiration of the cookie        |
| `string $path = "/"`     | The path of the cookie              |
| `bool $secure = null`    | Whether the cookie is secure or not |
| `string $domain = null`  | The domain of the cookie            |
| `bool $httpOnly = false` | Whether to set http only or not     |

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

The method accepts the following parameters:
- `filePath` - string - The path of where the file is
- `attachmentName` - string - the name that the browser will save the file as
- `attachment` - bool - whether this is an attachment or not (sets headers)

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

- `Content-Description: File Transfer`
- `Content-Type: application/octet-stream"`
- `Content-Disposition: attachment; filename=downloaded.pdf;"`
- `Content-Transfer-Encoding: binary"`

When calling `send()`, the file will be read using [readfile()][readfile] and the contents will be sent back to the caller.

## Redirecciones
With [Phalcon\Http\Response][http-response] you can also execute HTTP redirections.

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

Redirect to an external URI with an HTTP status code, handy for permanent or temporary redirections.

```php
<?php 

use Phalcon\Http\Response;

$response = new Response();

$response->redirect('https://www.example.com/new-location', true, 301);
```

All internal URIs are generated using the [url](mvc-url) service (by default [Phalcon\Url][url]). Este ejemplo demuestra como puede redirigir usando una ruta definida en su aplicación:

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

> **NOTE**: Even if there is a view associated with the current action, it will not be rendered since `redirect` disables the view. 
> 
> {: .alert .alert-warning }

## Caché HTTP
Una de las formas más fáciles de mejorar el rendimiento de su aplicación y reducir el tráfico es usando el Caché HTTP. The [Phalcon\Http\Response][http-response] object exposes methods that help with this task.

> **NOTE**: Depending on the needs of your application, you might not want to control HTTP caching using Phalcon. Hay varios servicios disponibles en Internet que le pueden ayudar con eso y podrían potencialmente ser más baratos y fáciles de mantener (BitMitigate, Varnish, etc.). Implementing HTTP Cache in your application will definitely help, but it will have a small impact in the performance of your application. Depende de usted decidir qué estrategia es la mejor para su aplicación y audiencia. 
> 
> {: .alert .alert-info }

El Caché HTTP se implementa configurando ciertas cabeceras en la respuesta. El caché se establece (usando las cabeceras) en la primera visita del usuario a nuestra aplicación. The following headers help with HTTP Cache:

| Nombre           | Descripción                                                                                                                            |
| ---------------- | -------------------------------------------------------------------------------------------------------------------------------------- |
| `Expires:`       | Set the expiration date of the page. Once the page expires the browser will request a fresh copy of the page vs. using the cached one. |
| `Cache-Control:` | How long is a page considered _fresh_ in the browser.                                                                                  |
| `Last-Modified:` | When was the last time that this page was modified by the application (avoids reloading).                                              |
| `ETag:`          | Also known as _entity tag_, is a unique identifier for each page, created using the modification timestamp.                            |
| `304:`           | Send a `not modified` back                                                                                                             |

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

The [Phalcon\Http\Response][http-response] component automatically formats the date to the `GMT` timezone as expected in an `Expires` header. Independientemente de la zona horaria de su aplicación, el componente primero convierte el tiempo a `UTC` y luego establece la cabecera `Expires`. Establecer la expiración con una fecha pasada indicará al navegador que siempre solicite una copia fresca de la página. Esto es particularmente útil si queremos forzar que los navegadores del cliente soliciten una nueva copia de nuestra página.

```php
<?php

use Phalcon\Http\Response;

$response   = new Response();
$expiryDate = new DateTime();

$expiryDate->modify('-10 minutes');

$response->setExpires($expiryDate);
```

> **NOTE**: Browsers rely on the client machine's clock to identify if the date has passed or not. Therefore, this caching mechanism has some limitations that the developer must account for (different timezones, clock skew etc.) 
> 
> {: .alert .alert-warning }

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

The [Phalcon\Http\Response][http-response] component automatically formats the date to the `GMT` timezone as expected in an `Last-Modified` header. Independientemente de la zona horaria de su aplicación, el componente primero convierte la fecha a `UTC` y luego establece la cabecera `Last-Modified`. Establecer la expiración con una fecha pasada indicará al navegador que siempre solicite una copia fresca de la página. Esto es particularmente útil si queremos forzar que los navegadores del cliente soliciten una nueva copia de nuestra página.

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
The [Phalcon\Http\Response][http-response] object implements the [Phalcon\Di\InjectionAwareInterface][di-injectionawareinterface] interface. Como resultado, el contenedor DI está disponible y puede ser recuperado usando el método `getDI()`. Un contenedor también puede ser establecido usando el método `setDI()`.


If you have used the [Phalcon\Di\FactoryDefault][di-factorydefault] DI container for your application, the service is already registered for you. Puede acceder a él usando el nombre `response`. El siguiente ejemplo muestra el uso en un controlador

```php
<?php

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

/**
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
 The [Phalcon\Http\Response][http-response] object implements the [Phalcon\Events\EventsAware][events-eventsawareinterface] interfaces. Como resultado `getEventsManager()` y `setEventsManager()` están disponibles para usar.


| Evento              | Descripción                                       | Puede parar la operación |
| ------------------- | ------------------------------------------------- |:------------------------:|
| `afterSendHeaders`  | Se dispara después de que se envíen las cabeceras |            No            |
| `beforeSendHeaders` | Se dispara antes de que se envíen las cabeceras   |            Si            |

[http-response]: api/phalcon_http#http-response
[http-response-cookies]: api/phalcon_http#http-response-cookies
[http-response-cookiesinterface]: api/phalcon_http#http-response-cookiesinterface
[http-response-headers]: api/phalcon_http#http-response-headers
[http-response-headersinterface]: api/phalcon_http#http-response-headersinterface
[http-responseinterface]: api/phalcon_http#http-responseinterface
[di-injectionawareinterface]: api/phalcon_di#di-injectionawareinterface
[di-injectionawareinterface]: api/phalcon_di#di-injectionawareinterface
[di-factorydefault]: api/phalcon_di#di-factorydefault
[url]: api/phalcon_mvc#mvc-url
[json-encode]: https://www.php.net/manual/en/function.json-encode.php
[status-codes]: https://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
[events-eventsawareinterface]: api/phalcon_events#events-eventsawareinterface
[readfile]: https://www.php.net/manual/en/function.readfile.php
[http-message-response]: api/phalcon_http#http-message-response
