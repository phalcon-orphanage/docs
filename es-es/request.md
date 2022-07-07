---
layout: default
language: 'es-es'
version: '5.0'
upgrade: '#request'
title: 'Petición HTTP'
keywords: 'http, petición http, petición'
---

# Componente Petición
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
[Phalcon\Http\Request][http-request] is a component that encapsulates the actual HTTP request (usually originated by a browser) and sent to our application. The [Phalcon\Http\Request][http-request] object is a simple value object that is passed between the dispatcher and controller classes, wrapping the HTTP request environment. También ofrece fácil acceso a la información como datos de la cabecera, ficheros, métodos, variables, etc.

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

// POST
if (true === $request->isPost()) {
    // AJAX
    if (true === $request->isAjax()) {
        // ....
    }
}
```

## Obteniendo Valores
PHP automatically fills the superglobal arrays [$_GET][get], [$_POST][post] and [$_REQUEST][request] depending on the type of the request. Estos vectores contienen los valores presentes en los formularios enviados o los parámetros enviados vía URL. The variables in the arrays are never sanitized and can contain illegal characters or even malicious code, which can lead to [SQL injection][sql-injection] or [Cross Site Scripting (XSS)][xss] attacks.

[Phalcon\Http\Request][http-request] allows you to access the values stored in the [$_GET][get], [$_POST][post] and [$_REQUEST][request] arrays and sanitize or filter them with the [filter](filter-filter) service.

There are 5 methods that allow you to retrieve submitted data from a request:
- `get()`
- `getQuery()`
- `getPost()`
- `getPut()`
- `getServer()`

All (except `getServer()`) accept the following parameters:
- `name` the name of the value to get
- `filters` (array/string) the sanitizers to apply to the value
- `defaultValue` returned if the element is not defined (`null`)
- `notAllowEmpty` if set (default) and the value is empty, the `defaultValue` will be returned; otherwise `null`
- `noRecursive` applies the sanitizers recursively in the value (if value is an array)

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$request->get(
    $name = null,            // string
    $filters = null,         // mixed
    $defaultValue = null,    // mixed
    $notAllowEmpty = false,  // bool
    $noRecursive = false     // bool
): mixed
```

`getServer()` acepta sólo una variable `name` (string), que representa la variable con el nombre del servidor que necesita recuperar.

### $_REQUEST
The [$_REQUEST][request] superglobal contains an associative array that contains the contents of [$_GET][get], [$_POST][post] and [$_COOKIE][cookie]. You can retrieve the data stored in the array by calling the `get()` method in the [Phalcon\Http\Request][http-request] object as follows:

**Examples** Get the `userEmail` field from the `$_REQUEST` superglobal:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->get('userEmail');
```

Obtiene el campo `userEmail` del superglobal `$_REQUEST`. Sanea el valor con el saneador `email`:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->get('userEmail', 'email', 'some@example.com');
```

Obtiene el campo `userEmail` del superglobal `$_REQUEST`. No lo sanea. Si el parámetro es nulo, devuelve el valor por defecto:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->get('userEmail', null, 'some@example.com');
```

### $_GET
The [$_GET][get] superglobal contains an associative array that contains the variables passed to the current script via URL parameters (also known as the query string). Puede recuperar los datos almacenados en el vector llamando al método `getQuery()` de la siguiente manera:

**Examples** Get the `userEmail` field from the `$_GET` superglobal:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->getQuery('userEmail');
```

Obtiene el campo `userEmail` del superglobal `$_GET`. Sanea el valor con el saneador `email`:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->getQuery('userEmail', 'email', 'some@example.com');
```

Obtiene el campo `userEmail` del superglobal `$_GET`. No lo sanea. Si el parámetro es nulo, devuelve el valor por defecto:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->getQuery('userEmail', null, 'some@example.com');
```


### $_POST
The [$_POST][post] superglobal contains an associative array that contains the variables passed to the current script via the HTTP POST method when using `application/x-www-form-urlencoded` or `multipart/form-data` as the HTTP `Content-Type` in the request. Puede recuperar los datos almacenados en el vector llamando al método `getPost()` de la siguiente manera:

**Examples** Get the `userEmail` field from the `$_POST` superglobal:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->getPost('userEmail');
```

Obtiene el campo `userEmail` del superglobal `$_POST`. Sanea el valor con el saneador `email`:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->getPost('userEmail', 'email', 'some@example.com');
```

Obtiene el campo `userEmail` del superglobal `$_POST`. No lo sanea. Si el parámetro es nulo, devuelve el valor por defecto:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->getPost('userEmail', null, 'some@example.com');
```

### Put
El objeto petición analiza el flujo PUT que se ha recibido internamente. Puede recuperar los datos almacenados en el vector llamando al método `getPut()` de la siguiente manera:

**Examples** Get the `userEmail` field from the `PUT` stream:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->getPut('userEmail');
```

Obtiene el campo `userEmail` del flujo `PUT`. Sanea el valor con el saneador `email`:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->getPut('userEmail', 'email', 'some@example.com');
```

Obtiene el campo `userEmail` del flujo `PUT`. No lo sanea. Si el parámetro es nulo, devuelve el valor por defecto:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$email = $request->getPut('userEmail', null, 'some@example.com');
```

### $_SERVER
The [$_SERVER][server] superglobal contains an array containing information such as headers, paths, and script locations. Puede recuperar los datos almacenados en el vector llamando al método `getServer()` de la siguiente manera:

**Examples** Get the `SERVER_NAME` value from the `$_SERVER` superglobal:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$name = $request->getServer('SERVER_NAME');
```

## Saneadores Preestablecidos
Es relativamente común que ciertos campos usen el mismo nombre a lo largo de su aplicación. Un campo publicado desde un formulario en su aplicación puede tener el mismo nombre y función que otro formulario en un área distinta. Ejemplos de este comportamiento podrían ser los campos `id`, `nombre` etc.

To make the sanitization process easier, when retrieving such fields, [Phalcon\Http\Request][http-request] offers a method to define those sanitizing filters based on HTTP methods when setting up the object.

```php
<?php

use Phalcon\Di;
use Phalcon\Filter;
use Phalcon\Http\Request;

$container = new Di();

$container->set(
    'request',
    function () {
        $request = new Request();
        $request
            ->setParameterFilters(
                'id', 
                Filter::FILTER_ABSINT, 
                [
                    'post'
                ]
            )
            ->setParameterFilters(
                'name', 
                [
                    'trim', 
                    'string'
                ], 
                [
                    'post'
                ]
            )
        ;

        return $request;
    }
);

```

Lo anterior saneará automáticamente cualquier parámetro publicado desde un formulario que tenga un nombre `id` o `name` con sus respectivos filtros. Sanitization takes place when calling the following methods (one per HTTP method)
- `getFilteredPost()`
- `getFilteredPut()`
- `getFilteredQuery()`

Estos métodos aceptan los mismos parámetros que `getPost()`, `getPut()` y `getQuery()` pero sin el parámetro `$filter`.

## Controladores
If you use the [Phalcon\Di\FactoryDefault][di-factorydefault] container, the [Phalcon\Http\Request][http-request] is already registered for you. El lugar más común para acceder el entorno de la petición es en una acción de un controlador. To access the [Phalcon\Http\Request][http-request] object from a controller you will need to use the `$this->request` public property of the controller:

```php
<?php

use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;

/**
 * Class PostsController
 * 
 * @property Request $request
 */
class PostsController extends Controller
{
    public function saveAction()
    {
        // Check if request has made with POST
        if (true === $this->request->isPost()) {
            // Access POST data
            $customerName = $this
                ->request
                ->getPost('name');
            $customerBorn = $this
                ->request
                ->getPost('born', 'string', '1984');
        }
    }
}
```

## Operaciones de Comprobación
The [Phalcon\Http\Request][http-request] component contains a number of methods that help you check the current operation. Por ejemplo, si quiere comprobar si se ha realizado una solicitud en particular usando AJAX, puede hacerlo usando el método `isAjax()`. Todos los métodos llevan el prefijo `is`.
- `isAjax()`: Checks whether request has been made using AJAX
- `isConnect()`: Checks whether HTTP method is CONNECT
- `isDelete()`: Checks whether HTTP method is DELETE
- `isGet()`: Checks whether HTTP method is GET
- `isHead()`: Checks whether HTTP method is HEAD
- `isMethod()`: Check if HTTP method match any of the passed methods
- `isOptions()`: Checks whether HTTP method is OPTIONS
- `isPatch()`: Checks whether HTTP method is PATCH
- `isPost()`: Checks whether HTTP method is POST
- `isPurge()`: Checks whether HTTP method is PURGE (Squid and Varnish support)
- `isPut()`: Checks whether HTTP method is PUT
- `isSecure()`: Checks whether request has been made using any secure layer
- `isSoap()`: Checks whether request has been made using SOAP
- `isTrace()`: Checks whether HTTP method is TRACE
- `isValidHttpMethod()`: Checks if a method is a valid HTTP method

## Comprobar Existencia
Hay un número de métodos disponibles que le permiten comprobar la existencia de elementos de la solicitud. Estos métodos llevan el prefijo `has`. Dependiendo del método utilizado, puede comprobar si existe un elemento en el `$_REQUEST`, `$_GET`, `$_POST`, `$_SERVER`, `$_FILES`, caché PUT y los encabezados de solicitud.
- `has()`: Checks whether the $_REQUEST superglobal has a certain element
- `hasFiles()`: Checks whether the request has any uploaded files
- `hasHeader()`: Checks whether the headers have a certain element
- `hasPost()`: Checks whether $_POST superglobal has a certain element
- `hasPut()`: Checks whether the PUT data has a certain element
- `hasQuery()`: Checks whether $_GET superglobal has a certain element
- `hasServer()`: Checks whether $_SERVER superglobal has a certain element
- `numFiles()`: Returns the number of files present in the request

## Información de la Petición
The [Phalcon\Http\Request][http-request] object offers methods that provide additional information regarding the request.
### Autenticación
- `getBasicAuth()`: Obtiene información de autenticación aceptada por el navegador/cliente
- `getDigestAuth()`: Obtiene información de autenticación aceptada por el navegador/cliente

### Cliente
- `getClientAddress()`: Obtiene la dirección IPv4 del cliente más probable
- `getClientCharsets()`: Obtiene un vector de conjuntos de caracteres y sus cualidades aceptado por el navegador/cliente
- `getUserAgent()`: Obtiene el agente HTTP del usuario usado para hacer la petición
- `getHTTPReferer()`: Obtiene la página web que hace referencia a la petición activa

### Contenido
- `getAcceptableContent()`: Obtiene un vector con tipos mime y sus cualidades aceptadas por el navegador/cliente
- `getBestAccept()`: Obtiene los mejores tipos mime aceptados por el navegador/cliente
- `getContentType()`: Obtiene el tipo de contenido que ha enviado la petición
- `getJsonRawBody()`: Obtiene el JSON sin procesar del cuerpo de la petición HTTP
- `getRawBody()`: Obtiene el cuerpo de la petición HTTP sin procesar

### i18n
- `getBestCharset()`: Obtiene el mejor conjunto de caracteres aceptados por el navegador/cliente
- `getBestLanguage()`: Obtiene el mejor idioma aceptado por el navegador/cliente
- `getLanguages()`: Obtiene un vector de idiomas y sus cualidades aceptadas por el navegador/cliente

### Servidor
- `getPort()`: Obtiene información sobre el puerto sobre el que se ha hecho la petición
- `getServerAddress()`: Obtiene la dirección IP activa del servidor
- `getServerName()`: Obtiene el nombre del servidor activo
- `getScheme()`: Obtiene el esquema HTTP (http/https)
- `getURI()`: Obtiene la URI HTTP que ha hecho la solicitud. Si se pasa `true` como parámetro, la parte de consulta no se devolverá

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

if ($request->isAjax()) {
    echo 'The request was made with Ajax';
}

// Check the request layer
if ($request->isSecure()) {
    echo 'The request was made using a secure layer';
}
```

Algunos métodos:

```php
$ipAddress = $request->getServerAddress();
```
Obtiene la dirección IP del servidor. ie. `192.168.0.100`

```php
$ipAddress = $request->getClientAddress();
```
Get the client's IP address ie. `201.245.53.51`

```php
$userAgent = $request->getUserAgent();
```
Obtiene el Agente del Usuario (`HTTP_USER_AGENT`)

```php
$contentType = $request->getAcceptableContent();
```
Obtiene el mejor contenido aceptable por el navegador. ej text/xml

```php
$charset = $request->getBestCharset();
```
Obtiene el mejor conjunto de caracteres aceptado por el navegador. ie. `utf-8`

```php
$language = $request->getBestLanguage();
```
Obtiene el mejor idioma aceptado configurado en el navegador. ie. `en-us`


### Método
`getMethod()` devuelve método HTTP que ha hecho la petición. Si la cabecera `X-HTTP-Method-Override` está establecida, y si el método es `POST`, entonces se usa para determinar el método HTTP "real" deseado. El parámetro `_method` de la petición también se puede usar para determinar el método HTTP, se tiene que llamar a `setHttpMethodParameterOverride(true)`. El método siempre devuelve una cadena en mayúsculas.

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

// POST
$_SERVER['REQUEST_METHOD'] = 'POST';
echo $request->getMethod();

/**
 * header('X-HTTP-Method-Override: GET');
 */ 
$_SERVER['REQUEST_METHOD'] = 'POST';
$request->setHttpMethodParameterOverride(true);
echo $request->getMethod();

// GET
$_SERVER['REQUEST_METHOD'] = 'POST';
$_REQUEST['_method']       = 'GET';
$request->setHttpMethodParameterOverride(true);
echo $request->getMethod();
```

## Inyección de Dependencias
The [Phalcon\Http\Request][http-request] object implements the [Phalcon\Di\InjectionAwareInterface][di-injectionawareinterface] interface. Como resultado, el contenedor DI está disponible y puede ser recuperado usando el método `getDI()`. Un contenedor también puede ser establecido usando el método `setDI()`.

## Trabajando con Cabeceras
Las cabeceras de solicitud contienen información útil, permitiéndole tomar los pasos necesarios para enviar la respuesta adecuada de vuelta al usuario. The [Phalcon\Http\Request][http-request] exposes the `getHeader()` and `getHeaders()` methods.

```php
<?php

use Phalcon\Http\Request;

$request = new Request;

$_SERVER["HTTP_HOST"] = "example.com";
$request->getHttpHost(); // example.com

$_SERVER["HTTP_HOST"] = "example.com:8080";
$request->getHttpHost(); // example.com:8080

$request->setStrictHostCheck(true);
$_SERVER["HTTP_HOST"] = "ex=am~ple.com";
$request->getHttpHost(); // UnexpectedValueException

$_SERVER["HTTP_HOST"] = "ExAmPlE.com";
$request->getHttpHost(); // example.com
```

El método `getHttpHost()` devolverá el nombre del servidor usado por la petición. The method will try to find host name in following order:
- `$_SERVER["HTTP_HOST"]`
- `$_SERVER["SERVER_NAME"]`
- `$_SERVER["SERVER_ADDR"]`

Opcionalmente `getHttpHost()` valida y realizar una comprobación estricta del nombre del servidor. Para conseguirlo, puede usar el método `setStrictHostCheck()`.

## Ficheros Subidos
Otra tarea común es la subida de ficheros. [Phalcon\Http\Request][http-request] offers an object-oriented way work with files. For the whole upload process to work, you will need to make the necessary changes to your `php.ini` (see [php-uploads][php-uploads]).

```php
<?php

use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;

/**
 * Class PostsController
 * 
 * @property Request $request
 */
class PostsController extends Controller
{
    public function uploadAction()
    {
        // if ($this->request->numFiles() > 0) {
        if ($this->request->hasFiles()) {
            $files = $this->request->getUploadedFiles();

            foreach ($files as $file) {
                echo $file->getName(), ' ', $file->getSize(), '\n';

                $file->moveTo(
                    'files/' . $file->getName()
                );
            }
        }
    }
}
```

Each object returned by `Phalcon\Http\Request::getUploadedFiles()` is an instance of the [Phalcon\Http\Request\File][http-request-file] which implements the [Phalcon\Http\Request\FileInterface][http-request-fileinterface] class. Usar el vector superglobal `$_FILES` ofrece el mismo comportamiento. [Phalcon\Http\Request\File][http-request-file] encapsulates only the information related to each file uploaded with the request.

`getUploadedFiles()` acepta dos parámetros.
- `$onlySuccessful`: Contains only successful uploads
- `$namedKeys`: Returns the array with named keys obtained by the upload process

The method returns an array of [Phalcon\Http\Request\File][http-request-file] objects. Cada objeto ofrece las siguientes propiedades y métodos, que le permiten trabajar con los ficheros subidos:

- `getError()` (string) - Devuelve cualquier error que haya ocurrido con este fichero
- `getExtension()` (string) - Devuelve la extensión del fichero
- `getKey()` (string) - Devuelve la clave interna del fichero
- `getName()` (string) - Devuelve el nombre real del fichero subido
- `getRealType()` (string) - Devuelve el tipo mime real del fichero subido usando finfo
- `getSize()` (int) - Devuelve el tamaño del fichero subido
- `getTempName()` (string) - Devuelve el nombre temporal del fichero subido
- `getType()` (string) - Devuelve el tipo mime informado por el navegador. El tipo mime no es completamente seguro, use `getRealType()` en su lugar
- `isUploadedFile()` (bool) - Comprueba si el fichero ha sido subido vía `POST`.
- `moveTo(string $destination)` (bool) - Mueve el fichero temporal a un destino dentro de la aplicación

## Inyección de Dependencias
The [Phalcon\Http\Request][http-request] object implements the [Phalcon\Di\InjectionAwareInterface][di-injectionawareinterface] interface. Como resultado, el contenedor DI está disponible y puede ser recuperado usando el método `getDI()`. Un contenedor también puede ser establecido usando el método `setDI()`.

## Eventos
 The [Phalcon\Http\Request][http-request] object implements the [Phalcon\Events\EventsAware][events-eventsawareinterface] interfaces. Como resultado `getEventsManager()` y `setEventsManager()` están disponibles para usar.

| Evento                       | Descripción                                                | Puede parar la operación |
| ---------------------------- | ---------------------------------------------------------- |:------------------------:|
| `afterAuthorizationResolve`  | Se dispara cuando la autorización se ha resuelto           |            No            |
| `beforeAuthorizationResolve` | Se dispara antes de que la autorización haya sido resuelta |            Si            |

Cuando se usa la autorización HTTP, la cabecera `Authorization` tiene el siguiente formato:

```text
Authorization: <type> <credentials>
```

donde `<type>` es un tipo de autenticación. Un tipo común es `Basic`. Additional authentication types are described in [IANA registry of Authentication schemes][iana] and [Authentication for AWS servers (AWS4-HMAC-SHA256)][aws-auth]. In most use cases the authentication type is:
* `AWS4-HMAC-SHA256`
* `Básico`
* `Bearer`
* `Digest`
* `HOBA`
* `Mutual`
* `Negotiate`
* `OAuth`
* `SCRAM-SHA-1`
* `SCRAM-SHA-256`
* `vapid`

Puede usar los eventos `request:beforeAuthorizationResolve` y `request:afterAuthorizationResolve` para realizar operaciones adicionales antes o después de que la autorización se resuelva.

`request:beforeAuthorizationResolve` recibe el vector `SERVER` con la clave `server` como segundo parámetro del evento.

`request:afterAuthorizationResolve` recibe el vector `SERVER` con la clave `server` así como también las cabeceras con la clave `headers`.

Se requiere una resolución personalizada de autorizaciones.

Ejemplo sin usar la resolución personalizada de autorizaciones:
```php
<?php

use Phalcon\Http\Request;

$_SERVER['HTTP_AUTHORIZATION'] = 'Enigma Secret';

$request = new Request();
print_r($request->getHeaders());
```

Resultado:

```bash
Array
(
    [Authorization] => Enigma Secret
)

Type: Enigma
Credentials: Secret
```

Ejemplo usando la resolución personalizada de autorización:
```php
<?php

use Phalcon\Di;
use Phalcon\Events\Event;
use Phalcon\Http\Request;
use Phalcon\Events\Manager;

class NegotiateAuthorizationListener
{
    public function afterAuthorizationResolve(Event $event, Request $request, array $data)
    {
        if (empty($data['server']['CUSTOM_KERBEROS_AUTH'])) {
            return false;
        }

        list($type,) = explode(
            ' ', 
            $data['server']['CUSTOM_KERBEROS_AUTH'], 
            2
        );

        if (!$type || stripos($type, 'negotiate') !== 0) {
            return false;
        }

        return [
           'Authorization'=> $data['server']['CUSTOM_KERBEROS_AUTH'],
        ];
    }
}

$_SERVER['CUSTOM_KERBEROS_AUTH'] = 'Negotiate '
                                 . 'a87421000492aa874209af8bc028';

$di = new Di();

$di->set(
    'eventsManager',
    function () {
        $manager = new Manager();

        $manager->attach(
            'request',
            new NegotiateAuthorizationListener()
        );

        return $manager;
    }
);

$request = new Request();

$request->setDI($di);

print_r(
    $request->getHeaders()
);
```

Resultado:

```bash
Array
(
    [Authorization] => Negotiate a87421000492aa874209af8bc028
)

Type: Negotiate
Credentials: a87421000492aa874209af8bc028
```

[aws-auth]: https://docs.aws.amazon.com/AmazonS3/latest/API/sigv4-auth-using-authorization-header.html
[cookie]: https://www.php.net/manual/en/reserved.variables.cookies.php
[get]: https://www.php.net/manual/en/reserved.variables.get.php
[iana]: https://www.iana.org/assignments/http-authschemes/http-authschemes.xhtml
[php-uploads]: https://www.php.net/manual/en/ini.core.php#ini.file-uploads
[post]: https://www.php.net/manual/en/reserved.variables.post.php
[request]: https://www.php.net/manual/en/reserved.variables.request.php
[server]: https://www.php.net/manual/en/reserved.variables.server.php
[sql-injection]: https://en.wikipedia.org/wiki/SQL_injection
[xss]: https://en.wikipedia.org/wiki/Cross-site_scripting
[http-request]: api/phalcon_http#http-request
[http-request-file]: api/phalcon_http#http-request-file
[http-request-fileinterface]: api/phalcon_http#http-request-fileinterface
[di-injectionawareinterface]: api/phalcon_di#di-injectionawareinterface
[di-factorydefault]: api/phalcon_di#di-factorydefault
[events-eventsawareinterface]: api/phalcon_events#events-eventsawareinterface
