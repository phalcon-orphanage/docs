* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Generando Direcciones URL y Rutas

[Phalcon\Mvc\Url](api/Phalcon_Mvc_Url) is the component responsible of generate URLs in a Phalcon application. It's capable of produce independent URLs based on routes.

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

// Setting a relative base URI
$url->setBaseUri('/invo/');

// Setting a full domain as base URI
$url->setBaseUri('//my.domain.com/');

// Setting a full domain as base URI
$url->setBaseUri('https://my.domain.com/my-app/');
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

If you are using the [Router](/4.0/en/routing) with its default behavior, your application is able to match routes based on the following pattern:

<h5 class='alert alert-info'>/:controller/:action/:params </h5>

Por consiguiente es muy fácil crear rutas que satisfacen ese patrón (o cualquier otro patrón definido en el router) pasando una cadena para el método `get()`:

```php
<?php echo $url->get('products/save'); ?>
```

Tenga en cuenta que no es necesario anteponer el URI base. Si tiene rutas con nombre, puede cambiarlo fácilmente creándolo dinámicamente. Por ejemplo si tienes la siguiente ruta:

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

// ... Definir rutas

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
{% raw %}
<a href='{{ url('posts/edit/1002') }}'>Edit</a>
{% endraw %}
```

Generar rutas estáticas:

```twig
{% raw %}
<link rel='stylesheet' href='{{ static_url('css/style.css') }}' type='text/css' />
{% endraw %}
```

<a name='static-vs-dynamic-uri'></a>

## URI Estáticas vs Dinámicas

Este componente permite establecer una URI base diferente para los recursos estáticos en la aplicación:

```php
<?php

use Phalcon\Mvc\Url;

$url = new Url();

// Dynamic URIs are
$url->setBaseUri('/');

// Static resources go through a CDN
$url->setStaticBaseUri('https://static.mywebsite.com/');
```

[Phalcon\Tag](api/Phalcon_Tag) will request both dynamic and static URIs using this component.

<a name='custom-url'></a>

## Implementando tu Propio Generador de URLs

The [Phalcon\Mvc\UrlInterface](api/Phalcon_Mvc_UrlInterface) interface must be implemented to create your own URL generator replacing the one provided by Phalcon.