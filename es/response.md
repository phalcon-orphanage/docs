<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Devolviendo Respuestas</a> 
      <ul>
        <li>
          <a href="#working-with-headers">Trabajando con Cabeceras</a>
        </li>
        <li>
          <a href="#redirections">Haciendo redirecciones</a>
        </li>
        <li>
          <a href="#http-cache">Caché HTTP</a> 
          <ul>
            <li>
              <a href="#http-cache-expiration-time">Estableciendo el tiempo de expiración</a>
            </li>
            <li>
              <a href="#http-cache-control">Cache-Control</a>
            </li>
            <li>
              <a href="#http-cache-etag">E-Tag</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Devolviendo Respuestas

Parte del ciclo HTTP es devolver las respuestas a los clientes. `Phalcon\Http\Response` es el componente de Phalcon diseñado para lograr esta tarea. Las respuestas HTTP generalmente están compuestas por cabeceras y un cuerpo. El siguiente es un ejemplo básico de uso:

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

If you are using the full MVC stack there is no need to create responses manually. However, if you need to return a response directly from a controller's action follow this example:

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

Headers are an important part of the HTTP response. It contains useful information about the response state like the HTTP status, type of response and much more.

Se puede configurar los encabezados de la siguiente manera:

```php
<?php

// Establecer encabezados por su nombre
$response->setHeader('Content-Type', 'application/pdf');
$response->setHeader('Content-Disposition', "attachment; filename='downloaded.pdf'");

// Establecer una cabecera en crudo
$response->setRawHeader('HTTP/1.1 200 OK');
```

A `Phalcon\Http\Response\Headers` bag internally manages headers. This class retrieves the headers before sending it to client:

```php
<?php

// Obtener la bolsa de cabeceras
$headers = $response->getHeaders();

// Obtener una cabecera por su nombre
$contentType = $headers->get('Content-Type');
```

<a name='redirections'></a>

## Haciendo redirecciones

Con `Phalcon\Http\Response` también puede ejecutar redirecciones HTTP:

```php
<?php

// Redireccionar a la URI por defecto
$response->redirect();

// Redireccionar a la URI base local
$response->redirect('posts/index');

// Redireccionar a una URL externa
$response->redirect('http://en.wikipedia.org', true);

// Redireccionar especificando un código de estado HTTP
$response->redirect('http://www.example.com/new-location', true, 301);
```

Todas las URIs internas son generadas mediante el servicio [url](/[[language]]/[[version]]/url) (por defecto `Phalcon\Mvc\Url`). Este ejemplo demuestra cómo puede redirigir utilizando una ruta que ha definido en su aplicación:

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

Tenga en cuenta que una redirección no desactiva el componente de vista, por lo que si hay una vista asociada con la acción actual, se ejecutará de todos modos. Es posible desactivar la vista desde el controlador utilizando `$this->view->disable()`.

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

Browsers rely on the client's clock to assess if this date has passed or not. The client clock can be modified to make pages expire and this may represent a limitation for this cache mechanism.

<a name='http-cache-control'></a>

### Cache-Control

This header provides a safer way to cache the pages served. We simply must specify a time in seconds telling the browser how long it must keep the page in its cache:

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