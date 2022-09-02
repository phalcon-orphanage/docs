---
layout: default
language: 'es-es'
version: '4.0'
upgrade: '#request'
title: 'Petición HTTP'
keywords: 'http, petición http, petición'
---

# Componente Petición

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

[Phalcon\Http\Request](api/phalcon_http#http-request) es un componente que encapsula la petición HTTP actual (normalmente originada por el navegador) y enviada a nuestra aplicación. El objeto [Phalcon\Http\Request](api/phalcon_http#http-request) es un objeto de valor simple que se pasa entre las clases despachador y controlador, envolviendo el entorno de la petición HTTP. También ofrece fácil acceso a la información como datos de la cabecera, ficheros, métodos, variables, etc.

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

PHP automáticamente rellena los vectores superglobales [$_GET](https://www.php.net/manual/en/reserved.variables.get.php), [$_POST](https://www.php.net/manual/en/reserved.variables.post.php) y [$_REQUEST](https://www.php.net/manual/en/reserved.variables.request.php) dependiendo del tipo de la petición. Estos vectores contienen los valores presentes en los formularios enviados o los parámetros enviados vía URL. Las variables en los vectores nunca se sanean y pueden contener caracteres ilegales o incluso código malicioso, lo que puede permitir ataques de [inyección SQL](https://en.wikipedia.org/wiki/SQL_injection) o [Cross Site Scripting (XSS)](https://en.wikipedia.org/wiki/Cross-site_scripting).

[Phalcon\Http\Request](api/phalcon_http#http-request) le permite acceder a los valores almacenados en los vectores [$_GET](https://www.php.net/manual/en/reserved.variables.get.php), [$_POST](https://www.php.net/manual/en/reserved.variables.post.php) y [$_REQUEST](https://www.php.net/manual/en/reserved.variables.request.php) y sanearlos o filtrarlos con el servicio <filter>.

Hay 5 métodos que le permiten recuperar los datos enviados en una petición: - `get()` - `getQuery()` - `getPost()` - `getPut()` - `getServer()`

Todos (excepto `getServer()`) aceptan los siguientes parámetros: - `name` el nombre del valor a obtener - `filters` (array/string) los saneadores a aplicar al valor - `defaultValue` devuelto si el elemento no está definido (`null`) - `notAllowEmpty` si se esetablece (predeterminado) y el valor está vacío, se devolverá `defaultValue`; en caso contrario `null` - `noRecursive` aplica los saneadores recursivamente en el valor (si el valor es un vector)

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

El superglobal [$_REQUEST](https://www.php.net/manual/en/reserved.variables.request.php) contiene un vector asociativo que contiene el contenido de [$_GET](https://www.php.net/manual/en/reserved.variables.get.php), [$_POST](https://www.php.net/manual/en/reserved.variables.post.php) y [$_COOKIE](https://www.php.net/manual/en/reserved.variables.cookies.php). Puede recuperar los datos almacenados en el vector llamando al método `get()` en el objeto [Phalcon\Http\Request](api/phalcon_http#http-request) de la siguiente manera:

**Ejemplos** Obtiene el campo `userEmail` del superglobal `$_REQUEST`:

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

El superglobal [$_GET](https://www.php.net/manual/en/reserved.variables.get.php) contiene un vector asociativo que contiene las variables pasadas al *script* actual a través de parámetros en la URL (también conocido como cadena de consulta). Puede recuperar los datos almacenados en el vector llamando al método `getQuery()` de la siguiente manera:

**Ejemplos** Obtiene el campo `userEmail` del superglobal `$_GET`:

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

El superglobal [$_POST](https://www.php.net/manual/en/reserved.variables.post.php) contiene un vector asociativo que contiene las variables pasadas al *script* actual mediante el método HTTP POST cuando se usa `application/x-www-form-urlencoded` o `multipart/form-data` como HTTP `Content-Type` en la petición. Puede recuperar los datos almacenados en el vector llamando al método `getPost()` de la siguiente manera:

**Ejemplos** Obtiene el campo `userEmail` del superglobal `$_POST`:

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

**Ejemplos** Obtiene el campo `userEmail` del flujo `PUT`:

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

El superglobal [$_SERVER](https://www.php.net/manual/en/reserved.variables.server.php) contiene un vector que contiene información como cabeceras, rutas, y ubicaciones de *script*. Puede recuperar los datos almacenados en el vector llamando al método `getServer()` de la siguiente manera:

**Ejemplos** Obtiene el valor de `SERVER_NAME` del superglobal `$_SERVER`:

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

$name = $request->getServer('SERVER_NAME');
```

## Saneadores Preestablecidos

Es relativamente común que ciertos campos usen el mismo nombre a lo largo de su aplicación. Un campo publicado desde un formulario en su aplicación puede tener el mismo nombre y función que otro formulario en un área distinta. Ejemplos de este comportamiento podrían ser los campos `id`, `nombre` etc.

Para facilitar el proceso de saneamiento, cuando recuperamos dichos campos, [Phalcon\Http\Request](api/phalcon_http#http-request) ofrece un método para definir aquellos filtros de saneado basados en los métodos HTTP al configurar el objeto.

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

Lo anterior saneará automáticamente cualquier parámetro publicado desde un formulario que tenga un nombre `id` o `name` con sus respectivos filtros. El saneamiento tiene lugar cuando se llama a los siguientes métodos (uno por método HTTP) - `getFilteredPost()` - `getFilteredPut()` - `getFilteredQuery()`

Estos métodos aceptan los mismos parámetros que `getPost()`, `getPut()` y `getQuery()` pero sin el parámetro `$filter`.

## Controladores

Si usa el contenedor [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault), [Phalcon\Http\Request](api/phalcon_http#http-request) ya está registrado para usted. El lugar más común para acceder el entorno de la petición es en una acción de un controlador. Para acceder al objeto [Phalcon\Http\Request](api/phalcon_http#http-request) desde un controlador necesitará usar la propiedad pública `$this->request` del controlador:

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

El componente [Phalcon\Http\Request](api/phalcon_http#http-request) contiene un número de métodos que le ayudan a comprobar la operación actual. Por ejemplo, si quiere comprobar si se ha realizado una solicitud en particular usando AJAX, puede hacerlo usando el método `isAjax()`. Todos los métodos llevan el prefijo `is`. - `isAjax()`: comprueba si solicitud ha sido formulada utilizando AJAX - `isConnect()`: comprueba si el método HTTP es CONNECT - `isDelete()`: comprueba si método HTTP es DELETE - `isGet()`: comprueba si método HTTP es GET - `isHead()`: comprueba si método HTTP es HEAD - `isMethod()`: comprueba si el método HTTP coincide con ninguno de los métodos pasados - `isOptions()`: comprueba si el método HTTP es OPTIONS - `isPatch()`: comprueba si el método HTTP es PATCH - `isPost()`: comprueba si método HTTP es POST - `isPurge()`: comprueba si el método HTTP es PURGE (soporte para Squid y Varnish) - `isPut()`: comprueba si el método HTTP se PUT - `isSecure()`: comprueba si solicitud ha sido formulada con alguna capa segura - `isSoap()`: comprueba si solicitud ha sido formulada con SOAP - `isTrace()`: comprueba si método HTTP es TRACE - `isValidHttpMethod()`: comprueba si un método es un método HTTP válido

## Comprobar Existencia

Hay un número de métodos disponibles que le permiten comprobar la existencia de elementos de la solicitud. Estos métodos llevan el prefijo `has`. Dependiendo del método utilizado, puede comprobar si existe un elemento en el `$_REQUEST`, `$_GET`, `$_POST`, `$_SERVER`, `$_FILES`, caché PUT y los encabezados de solicitud. - `has()`: Comprueba si el superglobal $_REQUEST tiene un cierto elemento - `hasFiles()`: Comprueba si la petición tiene algún fichero subido - `hasHeader()`: Comprueba si las cabeceras tienen un cierto elemento - `hasPost()`: Comprueba si el superglobal $_POST tiene un cierto elemento - `hasPut()`: Comprueba si los datos PUT tienen un cierto elemento - `hasQuery()`: Comprueba si el superglobal $_GET tiene un cierto elemento - `hasServer()`: Comprueba si el superglobal $_SERVER tiene cierto elemento - `numFiles()`: Devuelve el número de ficheros presentes en la petición

## Información de la Petición

El objeto [Phalcon\Http\Request](api/phalcon_http#http-request) ofrece métodos que proveen información adicional respecto a la petición.

### Autenticación

* `getBasicAuth()`: Obtiene información de autenticación aceptada por el navegador/cliente
* `getDigestAuth()`: Obtiene información de autenticación aceptada por el navegador/cliente

### Cliente

* `getClientAddress()`: Obtiene la dirección IPv4 del cliente más probable
* `getClientCharsets()`: Obtiene un vector de conjuntos de caracteres y sus cualidades aceptado por el navegador/cliente
* `getUserAgent()`: Obtiene el agente HTTP del usuario usado para hacer la petición
* `getHTTPReferer()`: Obtiene la página web que hace referencia a la petición activa

### Contenido

* `getAcceptableContent()`: Obtiene un vector con tipos mime y sus cualidades aceptadas por el navegador/cliente
* `getBestAccept()`: Obtiene los mejores tipos mime aceptados por el navegador/cliente
* `getContentType()`: Obtiene el tipo de contenido que ha enviado la petición
* `getJsonRawBody()`: Obtiene el JSON sin procesar del cuerpo de la petición HTTP
* `getRawBody()`: Obtiene el cuerpo de la petición HTTP sin procesar

### i18n

* `getBestCharset()`: Obtiene el mejor conjunto de caracteres aceptados por el navegador/cliente
* `getBestLanguage()`: Obtiene el mejor idioma aceptado por el navegador/cliente
* `getLanguages()`: Obtiene un vector de idiomas y sus cualidades aceptadas por el navegador/cliente

### Servidor

* `getPort()`: Obtiene información sobre el puerto sobre el que se ha hecho la petición
* `getServerAddress()`: Obtiene la dirección IP activa del servidor
* `getServerName()`: Obtiene el nombre del servidor activo
* `getScheme()`: Obtiene el esquema HTTP (http/https)
* `getURI()`: Obtiene la URI HTTP que ha hecho la solicitud. Si se pasa `true` como parámetro, la parte de consulta no se devolverá

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

Obtiene la dirección IP del servidor. ej. `192.168.0.100`

```php
$ipAddress = $request->getClientAddress();
```

Obtiene la dirección IP del cliente, ej. `201.245.53.51`

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

Obtiene el mejor conjunto de caracteres aceptado por el navegador. ej. `utf-8`

```php
$language = $request->getBestLanguage();
```

Obtiene el mejor idioma aceptado configurado en el navegador. ej. `en-us`

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

El objeto [Phalcon\Http\Request](api/phalcon_http#http-request) implementa la interfaz [Phalcon\Di\InjectionAwareInterface](api/phalcon_di#di-injectionawareinterface). Como resultado, el contenedor DI está disponible y puede ser recuperado usando el método `getDI()`. Un contenedor también puede ser establecido usando el método `setDI()`.

## Trabajando con Cabeceras

Las cabeceras de solicitud contienen información útil, permitiéndole tomar los pasos necesarios para enviar la respuesta adecuada de vuelta al usuario. [Phalcon\Http\Request](api/phalcon_http#http-request) expone los métodos `getHeader()` y `getHeaders()`.

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

El método `getHttpHost()` devolverá el nombre del servidor usado por la petición. El método intentará encontrar el nombre del servidor en el siguiente orden: - `$_SERVER["HTTP_HOST"]` - `$_SERVER["SERVER_NAME"]` - `$_SERVER["SERVER_ADDR"]`

Opcionalmente `getHttpHost()` valida y realizar una comprobación estricta del nombre del servidor. Para conseguirlo, puede usar el método `setStrictHostCheck()`.

## Ficheros Subidos

Otra tarea común es la subida de ficheros. [Phalcon\Http\Request](api/phalcon_http#http-request) ofrece una forma de trabajar con ficheros orientada a objeto. Para que funcione todo el proceso de subida, necesitará hacer los cambios necesarios en su `php.ini` (ver [subidas-php](https://www.php.net/manual/en/ini.core.php#ini.file-uploads)).

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

Cada objeto devuelto por `Phalcon\Http\Request::getUploadedFiles()` es una instancia de [Phalcon\Http\Request\File](api/phalcon_http#http-request-file) que implementa la clase [Phalcon\Http\Request\FileInterface](api/phalcon_http#http-request-fileinterface). Usar el vector superglobal `$_FILES` ofrece el mismo comportamiento. [Phalcon\Http\Request\File](api/phalcon_http#http-request-file) encapsula sólo la información relacionada con cada fichero subido en la petición.

`getUploadedFiles()` acepta dos parámetros. - `$onlySuccessful`: Contiene sólo subidas correctas - `$namedKeys`: Devuelve el vector con claves nombradas obtenidas en el proceso de subida

El método devuelve un vector de objetos [Phalcon\Http\Request\File](api/phalcon_http#http-request-file). Cada objeto ofrece las siguientes propiedades y métodos, que le permiten trabajar con los ficheros subidos:

* `getError()` (string) - Devuelve cualquier error que haya ocurrido con este fichero
* `getExtension()` (string) - Devuelve la extensión del fichero
* `getKey()` (string) - Devuelve la clave interna del fichero
* `getName()` (string) - Devuelve el nombre real del fichero subido
* `getRealType()` (string) - Devuelve el tipo mime real del fichero subido usando finfo
* `getSize()` (int) - Devuelve el tamaño del fichero subido
* `getTempName()` (string) - Devuelve el nombre temporal del fichero subido
* `getType()` (string) - Devuelve el tipo mime informado por el navegador. El tipo mime no es completamente seguro, use `getRealType()` en su lugar
* `isUploadedFile()` (bool) - Comprueba si el fichero ha sido subido vía `POST`.
* `moveTo(string $destination)` (bool) - Mueve el fichero temporal a un destino dentro de la aplicación

## Inyección de Dependencias

El objeto [Phalcon\Http\Request](api/phalcon_http#http-request) implementa la interfaz [Phalcon\Di\InjectionAwareInterface](api/phalcon_di#di-injectionawareinterface). Como resultado, el contenedor DI está disponible y puede ser recuperado usando el método `getDI()`. Un contenedor también puede ser establecido usando el método `setDI()`.

## Eventos

El objeto [Phalcon\Http\Request](api/phalcon_http#http-request) implementa el interfaz [Phalcon\Events\EventsAware](api/phalcon_events#events-eventsawareinterface). Como resultado `getEventsManager()` y `setEventsManager()` están disponibles para usar.

| Evento                       | Descripción                                                | Puede parar la operación |
| ---------------------------- | ---------------------------------------------------------- |:------------------------:|
| `afterAuthorizationResolve`  | Se dispara cuando la autorización se ha resuelto           |            No            |
| `beforeAuthorizationResolve` | Se dispara antes de que la autorización haya sido resuelta |            Si            |

Cuando se usa la autorización HTTP, la cabecera `Authorization` tiene el siguiente formato:

```text
Authorization: <type> <credentials>
```

donde `<type>` es un tipo de autenticación. Un tipo común es `Basic`. Tipos de autenticación adicional se describen en el [registro de esquemas de Autenticación IANA](https://www.iana.org/assignments/http-authschemes/http-authschemes.xhtml) y [Autenticación para servidores AWS (AWS4-HMAC-SHA256)](https://docs.aws.amazon.com/AmazonS3/latest/API/sigv4-auth-using-authorization-header.html). En la mayoría de casos el tipo de autenticación es: * `AWS4-HMAC-SHA256` * `Basic` * `Bearer` * `Digest` * `HOBA` * `Mutual` * `Negotiate` * `OAuth` * `SCRAM-SHA-1` * `SCRAM-SHA-256` * `vapid`

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
