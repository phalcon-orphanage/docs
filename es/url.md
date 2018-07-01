<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Generando Direcciones URL y Rutas</a> 
      <ul>
        <li>
          <a href="#base-uri">Configuración de un URI base</a>
        </li>
        <li>
          <a href="#generating-uri">Generando URIs</a>
        </li>
        <li>
          <a href="#urls-without-mod-rewrite">Produciendo URLs sin mod_rewrite</a>
        </li>
        <li>
          <a href="#urls-from-volt">Produciendo URLs desde Volt</a>
        </li>
        <li>
          <a href="#static-vs-dynamic-uri">Static vs. Dynamic URIs</a>
        </li>
        <li>
          <a href="#custom-url">Implementando tu Propio Generador de URLs</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Generar Direcciones URL y Rutas

`Phalcon\Mvc\Url` is the component responsible of generate URLs in a Phalcon application. It's capable of produce independent URLs based on routes.

<a name='base-uri'></a>

## Configuración de un URI base

Dependiendo del directorio del documento en el que esté instalada su aplicación, puede tener un URI base o no.

Por ejemplo, si el documento raíz es `es/var/www/htdocs` y su aplicación se instala en `en/var/www/htdocs/invo` entonces su baseUri será `/invo/`. Si usted está utilizando un VirtualHost o la aplicación se instala en la raíz del documento, su baseUri es `/`. Ejecute el siguiente código para saber el URI base detectado por Phalcon:

```php
<?php

use Phalcon\Mvc\Url;

$url = new Url();

echo $url->getBaseUri();
```

Por defecto, Phalcon puede detectar automáticamente su baseUri, pero si quieres mejorar el rendimiento de su aplicación se recomienda configurarlo manualmente:

```php
<?php

use Phalcon\Mvc\Url;

$url = new Url();

// Establecer una URI base relativa
$url->setBaseUri('/invo/');

// Establecer un dominio completo como URI base
$url->setBaseUri('//my.domain.com/');

// Establecer un dominio completo como URI base
$url->setBaseUri('http://my.domain.com/my-app/');
```

Generalmente, este componente debe estar registrado en el contenedor de inyección de dependencias, por lo que se puede establecer ahí mismo:

```php
<?php

use Phalcon\Mvc\Url;

$di->set(
    'url',
    function () {
        $url = new Url();

        $url->setBaseUri('/invo/');

        return $url;
    }
);
```

<a name='generating-uri'></a>

## Generando URIs

Si está utilizando un [Router](/[[language]]/[[version]]/routing) con su comportamiento por defecto, la aplicación es capaz de coincidir las rutas basadas en el patrón siguiente:

<div class="alert alert-info">
    <p>
        /:controller/:action/:params
    </p>
</div>

Por consiguiente es muy fácil crear rutas que satisfacen ese patrón (o cualquier otro patrón definido en el router) pasando una cadena para el método `get()`:

```php
<?php echo $url->get('products/save'); ?>
```

Note that isn't necessary to prepend the base URI. If you have named routes you can easily change it creating it dynamically. For Example if you have the following route:

```php
<?php

$router
    ->add(
        '/blog/{year}/{month}/{title}',
        [
            'controller' => 'posts',
            'action'     => 'show',
        ]
    )
    ->setName('show-post');
```

Puede generar una dirección URL de la siguiente manera:

```php
<?php

// Esto produce: /blog/2015/01/some-blog-post
$url->get(
    [
        'for'   => 'show-post',
        'year'  => '2015',
        'month' => '01',
        'title' => 'some-blog-post',
    ]
);
```

<a name='urls-without-mod-rewrite'></a>

## Produciendo URLs sin mod_rewrite

También puede utilizar este componente para crear URLs sin mod_rewrite:

```php
<?php

use Phalcon\Mvc\Url;

$url = new Url();

// Pasar el URI en $_GET['_url']
$url->setBaseUri('/invo/index.php?_url=/');

// Esto produce: /invo/index.php?_url=/products/save
echo $url->get('products/save');
```

También se puede utilizar `$_SERVER['REQUEST_URI']`:

```php
<?php

use Phalcon\Mvc\Url;

$url = new Url();

// Pasar el URI en $_GET['_url']
$url->setBaseUri('/invo/index.php?_url=/');

// Pasar el URI usando $_SERVER['REQUEST_URI']
$url->setBaseUri('/invo/index.php/');
```

En este caso, es necesario manejar manualmente el URI requerido en el enrutador:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

// ... Define routes

$uri = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']);

$router->handle($uri);
```

Las rutas producidas se verán de la siguiente manera:

```php
<?php

// Esto produce: /invo/index.php/products/save
echo $url->get('products/save');
```

<a name='urls-from-volt'></a>

## Produciendo URLs desde Volt

La función `url()` esta disponible en Volt para generar URLs usando este componente:

```twig
<a href='{{ url('posts/edit/1002') }}'>Editar</a>
```

Generar rutas estáticas:

```twig
<link rel='stylesheet' href='{{ static_url('css/style.css') }}' type='text/css' />
```

<a name='static-vs-dynamic-uri'></a>

## Static vs. Dynamic URIs

Este componente permite establecer una URI base diferente para los recursos estáticos en la aplicación:

```php
<?php

use Phalcon\Mvc\Url;

$url = new Url();

// Para las URIs dinámicas
$url->setBaseUri('/');

// Los recursos estáticos pasan por un CDN
$url->setStaticBaseUri('http://static.mywebsite.com/');
```

`Phalcon\Tag` solicitará ambos URIs, dinámicos y estáticos, usando este componente.

<a name='custom-url'></a>

## Implementando tu Propio Generador de URLs

Debe implementar la interfaz `Phalcon\Mvc\UrlInterface` para crear su propio generador URL reemplazando el proporcionado por Phalcon.