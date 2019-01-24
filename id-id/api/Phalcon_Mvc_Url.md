---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Url'
---
# Class **Phalcon\Mvc\Url**

*implements* [Phalcon\Mvc\UrlInterface](Phalcon_Mvc_UrlInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/url.zep)

This components helps in the generation of: URIs, URLs and Paths

```php
<?php

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

## Metode

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Menetapkan kontainer Injector Ketergantungan

publik **mendapatkanDI** ()

Mengembalikan kontainer DependencyInjector

public **setBaseUri** (*mixed* $baseUri)

Menetapkan awalan untuk semua URI yang akan dihasilkan

```php
<?php

$url->setBaseUri("/invo/");

$url->setBaseUri("/invo/index.php/");

```

public **setStaticBaseUri** (*mixed* $staticBaseUri)

Menetapkan awalan untuk semua URL statis yang dihasilkan

```php
<?php

$url->setStaticBaseUri("/invo/");

```

public **getBaseUri** ()

Returns the prefix for all the generated urls. By default /

public **getStaticBaseUri** ()

Returns the prefix for all the generated static urls. By default /

public **setBasePath** (*mixed* $basePath)

Menetapkan jalur dasar untuk semua jalur yang dihasilkan

```php
<?php

$url->setBasePath("/var/www/htdocs/");

```

public **getBasePath** ()

Mengembalikan jalur dasar

public **get** ([*mixed* $uri], [*mixed* $args], [*mixed* $local], [*mixed* $baseUri])

Generates a URL

```php
<?php

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

public **getStatic** ([*mixed* $uri])

Menghasilkan URL untuk sumber daya statis

```php
<?php

// Generate a URL for a static resource
echo $url->getStatic("img/logo.png");

// Generate a URL for a static predefined route
echo $url->getStatic(
    [
        "for" => "logo-cdn",
    ]
);

```

public **path** ([*mixed* $path])

Generates a local path