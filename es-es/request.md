* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Entorno de Consulta

Cada petición HTTP (normalmente originada por un navegador) contiene información adicional sobre la petición, tal como datos de cabecera, archivos, variables, etcétera. Una aplicación basada en web necesita analizar esa información para proporcionar la respuesta correcta al solicitante. [Phalcon\Http\Request](api/Phalcon_Http_Request) encapsulates the information of the request, allowing you to access it in an object-oriented way.

```php
<?php

use Phalcon\Http\Request;

// Obteniendo una instancia de la consulta
$request = new Request();

// Comprobar que la consulta este hecha por el método POST
if ($request->isPost()) {
    // Comprobar si la consulta esta hecha con Ajax
    if ($request->isAjax()) {
        echo 'La consulta fue hecha utilizando POST y AJAX';
    }
}
```

<a name='getting-values'></a>

## Obteniendo Valores

PHP automáticamente llena los arreglos superglobales `$_GET` y `$_POST` dependiendo del tipo de solicitud. Estos arrays contienen los valores presentes en los formularios o los parámetros enviados por la URL. The variables in the arrays are never sanitized and can contain illegal characters or even malicious code, which can lead to [SQL injection](https://en.wikipedia.org/wiki/SQL_injection) or [Cross Site Scripting (XSS)](https://en.wikipedia.org/wiki/Cross-site_scripting) attacks.

[Phalcon\Http\Request](api/Phalcon_Http_Request) allows you to access the values stored in the `$_REQUEST`, `$_GET` and `$_POST` arrays and sanitize or filter them with the [filter](/4.0/en/filter) service, (by default [Phalcon\Filter](api/Phalcon_Filter)). Los siguientes ejemplos ofrecen el mismo comportamiento:

```php
<?php

use Phalcon\Filter;

$filter = new Filter();

// Filtros aplicados manualmente
$email = $filter->sanitize($_POST['user_email'], 'email');

// Aplicando manualmente el filtro a un valor
$email = $filter->sanitize($request->getPost('user_email'), 'email');

// Aplicar automáticamente el filtro
$email = $request->getPost('user_email', 'email');

// Establecer un valor por defecto si el parámetro es nulo
$email = $request->getPost('user_email', 'email', 'some@example.com');

// Estableciendo un valor por defeccto si el parámetro es nulo sin filtrado
$email = $request->getPost('user_email', null, 'some@example.com');
```

<a name='controller-access'></a>

## Accediendo a la Consulta desde los Controladores

El lugar más común para acceder el ambiente de la petición es en una acción de un controlador. To access the [Phalcon\Http\Request](api/Phalcon_Http_Request) object from a controller you will need to use the `$this->request` public property of the controller:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function saveAction()
    {
        // Chequeamos si la consulta fue hecha por POST
        if ($this->request->isPost()) {
            // Accedemos al los datos POST
            $customerName = $this->request->getPost('name');
            $customerBorn = $this->request->getPost('born');
        }
    }
}
```

<a name='uploading-files'></a>

## Subiendo Archivos

Another common task is file uploading. [Phalcon\Http\Request](api/Phalcon_Http_Request) offers an object-oriented way to achieve this task:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function uploadAction()
    {
        // Comprobar si el usuario ha subido archivos
        if ($this->request->hasFiles()) {
            $files = $this->request->getUploadedFiles();

            // Imprimir el nombre real y el tamaño del archivo
            foreach ($files as $file) {
                // Imprimir detalles del archivo
                echo $file->getName(), ' ', $file->getSize(), '\n';

                // Mover el archivo dentro de la aplicación
                $file->moveTo(
                    'files/' . $file->getName()
                );
            }
        }
    }
}
```

Each object returned by `Phalcon\Http\Request::getUploadedFiles()` is an instance of the [Phalcon\Http\Request\File](api/Phalcon_Http_Request_File) class. Utilizar el arreglo superglobal `$_FILES` ofrece el mismo comportamiento. `Phalcon\Http\Request\File>` encapsulates only the information related to each file uploaded with the request.

<a name='working-with-headers'></a>

## Trabajando con Cabeceras

Como se mencionó anteriormente, los encabezados de las solicitudes contienen información útil que nos permite enviar la respuesta adecuada de nuevo al usuario. Los siguientes ejemplos muestran usos de esa información:

```php
<?php

// Obtener la cabecera Http-X-Requested-With
$requestedWith = $request->getHeader('HTTP_X_REQUESTED_WITH');

if ($requestedWith === 'XMLHttpRequest') {
    echo 'La consulta fue hecha con Ajax';
}

// Igual que lo anterior
if ($request->isAjax()) {
    echo 'La consulta fue hecha con Ajax';
}

// Comprobar la capa de la consulta
if ($request->isSecure()) {
    echo 'La consulta fue hecha utilizando una capa de seguridad';
}

// Obtener la dirección IP del servidor. Por ejemplo: 192.168.0.100
$ipAddress = $request->getServerAddress();

// Obtener la dirección IP del cliente. Por ejemplo: 201.245.53.51
$ipAddress = $request->getClientAddress();

// Obtener el agente del usuario (HTTP_USER_AGENT)
$userAgent = $request->getUserAgent();

// Obtener el mejor contenido aceptable por el navegador. Por ejemplo: text/xml
$contentType = $request->getAcceptableContent();

// Obtener el mejor conjunto de caracteres aceptados por el navegador. Por ejemplo, utf-8
$charset = $request->getBestCharset();

// Obtener el mejor idioma aceptado configurado por el navegador. Por ejemplo, en-us
$language = $request->getBestLanguage();

// Comprueba si existe una cabecera
if ($request->hasHeader('my-header')) {
    echo "María tenia un corderito";
}
```

<a name='events'></a>

## Eventos

Cuando usamos la autorización HTTP, la cabecera `Authorization` tiene el siguiente formato:

```text
Authorization: <type> <credentials>
```

donde `<type>` es un tipo de autenticación. El tipo común es `Basic`. Additional authentication types are described in [IANA registry of Authentication schemes](https://www.iana.org/assignments/http-authschemes/http-authschemes.xhtml) and [Authentication for AWS servers (AWS4-HMAC-SHA256)](https://docs.aws.amazon.com/AmazonS3/latest/API/sigv4-auth-using-authorization-header.html). En el 99.99% de los casos los tipos de autenticación son:

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

Se pueden utilizar los eventos `request:beforeAuthorizationResolve` y `request:afterAuthorizationResolve` para realizar operaciones adicionales antes o después de las resoluciones de autorización. Se requiere una resolución de autorizaciones personalizada.

Un ejemplo sin usar el solucionador de autorizaciones personalizado:

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

Un ejemplo usando el solucionador de autorizaciones personalizado:

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

        list($type,) = explode(' ', $data['server']['CUSTOM_KERBEROS_AUTH'], 2);

        if (!$type || stripos($type, 'negotiate') !== 0) {
            return false;
        }

        return [
           'Authorization'=> $data['server']['CUSTOM_KERBEROS_AUTH'],
        ];
    }
}

$_SERVER['CUSTOM_KERBEROS_AUTH'] = 'Negotiate a87421000492aa874209af8bc028';

$di = new Di();

$di->set('eventsManager', function () {
    $manager = new Manager();
    $manager->attach('request', new NegotiateAuthorizationListener());

    return $manager;
});

$request = new Request();
$request->setDI($di);

print_r($request->getHeaders());
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