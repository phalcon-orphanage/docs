---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Url'
---

* [Phalcon\Url](#url)
* [Phalcon\Url\Exception](#url-exception)
* [Phalcon\Url\UrlInterface](#url-urlinterface)

<h1 id="url">Class Phalcon\Url</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Url.zep)

| Namespace | Phalcon | | Uses | Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Mvc\RouterInterface, Phalcon\Mvc\Router\RouteInterface, Phalcon\Url\Exception, Phalcon\Url\UrlInterface | | Extends | AbstractInjectionAware | | Implements | UrlInterface |

Estos componentes ayudan en la generación de: URIs, URLs y rutas

```php
// Generate a URL appending the URI to the base URI
echo $url->get("products/edit/1");

// Generate a URL for a predefined route
echo $url->get(
    [
        "for"   => "blog-post",
        "title" => "some-cool-stuff",
        "year"  => "2012",
    ]
);
```

## Propiedades

```php
/**
 * @var null | string
 */
protected baseUri;

/**
 * @var null | string
 */
protected basePath;

/**
 * @var RouterInterface | null
 */
protected router;

/**
 * @var null | string
 */
protected staticBaseUri;

```

## Métodos

```php
public function __construct( RouterInterface $router = null );
```

```php
public function get( mixed $uri = null, mixed $args = null, bool $local = null, mixed $baseUri = null ): string;
```

Genera una URL

```php
// Generate a URL appending the URI to the base URI
echo $url->get("products/edit/1");

// Generate a URL for a predefined route
echo $url->get(
    [
        "for"   => "blog-post",
        "title" => "some-cool-stuff",
        "year"  => "2015",
    ]
);

// Generate a URL with GET arguments (/show/products?id=1&name=Carrots)
echo $url->get(
    "show/products",
    [
        "id"   => 1,
        "name" => "Carrots",
    ]
);

// Generate an absolute URL by setting the third parameter as false.
echo $url->get(
    "https://phalcon.io/",
    null,
    false
);
```

```php
public function getBasePath(): string;
```

Devuelve la ruta base

```php
public function getBaseUri(): string;
```

Devuelve el prefijo para todas las urls generadas. Por defecto /

```php
public function getStatic( mixed $uri = null ): string;
```

Genera una URL para un recurso estático

```php
// Generate a URL for a static resource
echo $url->getStatic("img/logo.png");

// Generate a URL for a static predefined route
echo $url->getStatic(
    [
        "for" => "logo-cdn",
    ]
);
```

```php
public function getStaticBaseUri(): string;
```

Devuelve el prefijo para todas las urls estáticas generadas. Por defecto /

```php
public function path( string $path = null ): string;
```

Genera una ruta local

```php
public function setBasePath( string $basePath ): UrlInterface;
```

Establece una ruta base para todas las rutas generadas

```php
$url->setBasePath("/var/www/htdocs/");
```

```php
public function setBaseUri( string $baseUri ): UrlInterface;
```

Establece un prefijo para todas las URIs a generar

```php
$url->setBaseUri("/invo/");

$url->setBaseUri("/invo/index.php/");
```

```php
public function setStaticBaseUri( string $staticBaseUri ): UrlInterface;
```

Establece un prefijo para todas las URLs estáticas generadas

```php
$url->setStaticBaseUri("/invo/");
```

<h1 id="url-exception">Class Phalcon\Url\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Url/Exception.zep)

| Namespace | Phalcon\Url | | Extends | \Phalcon\Exception |

Phalcon\Url\Exception

Las excepciones lanzadas en Phalcon\Url usarán esta clase

<h1 id="url-urlinterface">Interface Phalcon\Url\UrlInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Url/UrlInterface.zep)

| Namespace | Phalcon\Url |

Interfaz para Phalcon\Url\UrlInterface

## Métodos

```php
public function get( mixed $uri = null, mixed $args = null, bool $local = null ): string;
```

Genera una URL

```php
public function getBasePath(): string;
```

Devuelve una ruta base

```php
public function getBaseUri(): string;
```

Devuelve el prefijo para todas las urls generadas. Por defecto /

```php
public function path( string $path = null ): string;
```

Genera una ruta local

```php
public function setBasePath( string $basePath ): UrlInterface;
```

Establece una ruta base para todas las rutas generadas

```php
public function setBaseUri( string $baseUri ): UrlInterface;
```

Establece un prefijo para todas las urls generadas
