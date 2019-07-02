---
layout: default
language: 'el-gr'
version: '4.0'
title: 'Phalcon\Url'
---

* [Phalcon\Url](#url)
* [Phalcon\Url\Exception](#url-exception)
* [Phalcon\UrlInterface](#urlinterface)

<h1 id="url">Class Phalcon\Url</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/url.zep)

| Namespace | Phalcon | | Uses | Phalcon\DiInterface, Phalcon\UrlInterface, Phalcon\Url\Exception, Phalcon\Mvc\RouterInterface, Phalcon\Mvc\Router\RouteInterface, Phalcon\Di\InjectionAwareInterface | | Implements | UrlInterface, InjectionAwareInterface |

This components helps in the generation of: URIs, URLs and Paths

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

## Properties

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
 * @var <DiInterface>
 */
protected container;

//
protected router;

/**
 * @var null | string
 */
protected staticBaseUri;

```

## Methods

```php
public function get( mixed $uri = null, mixed $args = null, bool $local = null, mixed $baseUri = null ): string;
```

Generates a URL

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
    "https://phalconphp.com/",
    null,
    false
);
```

```php
public function getBasePath(): string;
```

Returns the base path

```php
public function getBaseUri(): string;
```

Returns the prefix for all the generated urls. By default /

```php
public function getDI(): DiInterface;
```

Returns the DependencyInjector container

```php
public function getStatic( mixed $uri = null ): string;
```

Generates a URL for a static resource

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

Returns the prefix for all the generated static urls. By default /

```php
public function path( string $path = null ): string;
```

Generates a local path

```php
public function setBasePath( string $basePath ): UrlInterface;
```

Sets a base path for all the generated paths

```php
$url->setBasePath("/var/www/htdocs/");
```

```php
public function setBaseUri( string $baseUri ): UrlInterface;
```

Sets a prefix for all the URIs to be generated

```php
$url->setBaseUri("/invo/");

$url->setBaseUri("/invo/index.php/");
```

```php
public function setDI( DiInterface $container ): void;
```

Sets the DependencyInjector container

```php
public function setStaticBaseUri( string $staticBaseUri ): UrlInterface;
```

Sets a prefix for all static URLs generated

```php
$url->setStaticBaseUri("/invo/");
```

<h1 id="url-exception">Class Phalcon\Url\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/url/exception.zep)

| Namespace | Phalcon\Url | | Extends | \Phalcon\Exception |

Phalcon\Url\Exception

Exceptions thrown in Phalcon\Url will use this class

<h1 id="urlinterface">Interface Phalcon\UrlInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/urlinterface.zep)

| Namespace | Phalcon |

Interface for Phalcon\UrlInterface

## Methods

```php
public function get( mixed $uri = null, mixed $args = null, bool $local = null ): string;
```

Generates a URL

@param string|array uri @param array|object args Optional arguments to be appended to the query string

```php
public function getBasePath(): string;
```

Returns a base path

```php
public function getBaseUri(): string;
```

Returns the prefix for all the generated urls. By default /

```php
public function path( string $path = null ): string;
```

Generates a local path

```php
public function setBasePath( string $basePath ): UrlInterface;
```

Sets a base paths for all the generated paths

```php
public function setBaseUri( string $baseUri ): UrlInterface;
```

Sets a prefix to all the urls generated