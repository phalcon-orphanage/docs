* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Devolviendo Respuestas

Parte del ciclo HTTP es devolver las respuestas a los clientes. [Phalcon\Http\Response](api/Phalcon_Http_Response) is the Phalcon component designed to achieve this task. Las respuestas HTTP generalmente están compuestas por cabeceras y un cuerpo. El siguiente es un ejemplo básico de uso:

```php
<?php

use Phalcon\Http\Response;

// Obteniendo una instancia de respuesta
$response = new Response();

// Establecer el código de estado
$response->setStatusCode(404, 'Not Found');

// Establecer el contenido de la respuesta
$response->setContent("Lo sentimos, la página no existe");

// Enviar la respuesta al cliente
$response->send();
```

Si usted está usando el MVC de forma completa, no necesita crear las respuestas manualmente. Sin embargo, si usted necesita devolver una respuesta directamente desde la acción de un controlador siga este ejemplo:

```php
<?php

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

class FeedController extends Controller
{
    public function getAction()
    {
        // Obtener una instancia de respuesta
        $response = new Response();

        $feed = // ... Cargar aquí el feed

        // Establecer el contenido de la respuesta
        $response->setContent(
            $feed->asString()
        );

        // Devolver la respuesta
        return $response;
    }
}
```

<a name='working-with-headers'></a>

## Trabajando con Cabeceras

Las cabeceras son una parte importante de la respuesta HTTP. Contiene información útil sobre el estado de respuesta como el estado HTTP, el tipo de respuesta y mucho más.

Se puede configurar los encabezados de la siguiente manera:

```php
<?php

// Establecer encabezados por su nombre
$response->setHeader('Content-Type', 'application/pdf');
$response->setHeader('Content-Disposition', "attachment; filename='downloaded.pdf'");

// Establecer una cabecera en crudo
$response->setRawHeader('HTTP/1.1 200 OK');
```

A [Phalcon\Http\Response\Headers](api/Phalcon_Http_Response_Headers) bag internally manages headers. This class retrieves the headers before sending it to client:

```php
<?php

// Obtener la bolsa de cabeceras
$headers = $response->getHeaders();

// Obtener una cabecera por su nombre
$contentType = $headers->get('Content-Type');
```

<a name='redirections'></a>

## Haciendo redirecciones

With [Phalcon\Http\Response](api/Phalcon_Http_Response) you can also execute HTTP redirections:

```php
<?php

// Redirect to the default URI
$response->redirect();

// Redirect to the local base URI
$response->redirect('posts/index');

// Redirect to an external URL
$response->redirect('https://en.wikipedia.org', true);

// Redirect specifying the HTTP status code
$response->redirect('https://www.example.com/new-location', true, 301);
```

All internal URIs are generated using the [url](/4.0/en/url) service (by default [Phalcon\Mvc\Url](api/Phalcon_Mvc_Url)). Este ejemplo demuestra cómo puede redirigir utilizando una ruta que ha definido en su aplicación:

```php
<?php

// Redireccionar basado en una ruta con nombre
return $response->redirect(
    [
        'for'        => 'index-lang',
        'lang'       => 'jp',
        'controller' => 'index',
    ]
);
```

Even if there is a view associated with the current action, it will not be rendered since `redirect` disables the view.

<a name='http-cache'></a>

## Caché HTTP

Una de las formas más fáciles de mejorar el rendimiento en nuestras aplicaciones y reducir el trafico es utilizando el cache HTTP. Los nevadores modernos soportan el cacheo HTTP y es una de las razones por la que mucho sitios web son tan rápidos.

La memoria caché HTTP se puede modificar en los siguientes valores de encabezado enviados por la aplicación al publicar una página por primera vez:

* **`Expires:`** con este encabezado, la aplicación puede establecer una fecha en el futuro o en el pasado que indique al navegador cuándo debe caducar la página.
* **`Cache-Control:`** este encabezado permite especificar cuánto tiempo una página debe considerarse como fresca en el navegador.
* **`Last-Modified:`** este encabezado le dice al navegador cuál fue la última vez que se actualizó el sitio, evitando que la página se vuelva a cargar.
* **`ETag:`** un etag es un identificador único que se debe ser creado incluyendo el tiempo de modificación de la página actual.

<a name='http-cache-expiration-time'></a>

### Estableciendo el tiempo de expiración

La fecha de vencimiento o expiración es una de las maneras más fáciles y efectivas de almacenar en caché una página en el cliente (navegador). A partir de la fecha actual, agregamos la cantidad de tiempo que la página se almacenará en el caché del navegador. Hasta que caduque esta fecha, no se solicitará contenido nuevo desde el servidor:

```php
<?php

$expiryDate = new DateTime();
$expiryDate->modify('+2 months');

$response->setExpires($expiryDate);
```

El componente respuesta muestra automáticamente la fecha en la zona horaria GMT como se esperaba en un encabezado Expires.

Si especificamos este valor en una fecha pasada, el navegador siempre actualizará la página consultada:

```php
<?php

$expiryDate = new DateTime();
$expiryDate->modify('-10 minutes');

$response->setExpires($expiryDate);
```

Los navegadores confían en el reloj del cliente para evaluar si esta fecha ha pasado o no. El reloj del cliente se puede modificar para hacer que las páginas caduquen y esto puede representar una limitación para este mecanismo de caché.

<a name='http-cache-control'></a>

### Cache-Control

Este encabezado proporciona una forma más segura de almacenar en caché las páginas servidas. Simplemente debemos especificar un tiempo en segundos que indique al navegador cuánto tiempo debe mantener la página en su caché:

```php
<?php

// Comenzando desde ahora, almacenar en cache esta página por un día
$response->setHeader('Cache-Control', 'max-age=86400');
```

El efecto opuesto (evitar que la página se cachee) se logra de esta manera:

```php
<?php

// Nunca almacenar en cache la página entregada
$response->setHeader('Cache-Control', 'private, max-age=0, must-revalidate');
```

<a name='http-cache-etag'></a>

### E-Tag

Un `entity-tag` o `E-tag` es un identificador único que ayuda al navegador a darse cuenta si la página ha cambiado o no entre dos solicitudes. El identificador debe calcularse teniendo en cuenta que esto debe cambiar si el contenido publicado anteriormente ha cambiado:

```php
<?php

// Calcular el E-Tag basado en el tiempo de modificación de las últimas noticias
$mostRecentDate = News::maximum(
    [
        'column' => 'created_at'
    ]
);

$eTag = md5($mostRecentDate);

// Enviar una cabecera E-Tag
$response->setHeader('E-Tag', $eTag);
```