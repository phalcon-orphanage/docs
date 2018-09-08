# Class **Phalcon\\Mvc\\Url**

*implements* [Phalcon\Mvc\UrlInterface](/en/3.2/api/Phalcon_Mvc_UrlInterface), [Phalcon\Di\InjectionAwareInterface](/en/3.2/api/Phalcon_Di_InjectionAwareInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/url.zep" class="btn btn-default btn-sm">Source on GitHub</a>

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

## Methods

public **setDI** ([Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector)

Sets the DependencyInjector container

public **getDI** ()

Returns the DependencyInjector container

public **setBaseUri** (*mixed* $baseUri)

Sets a prefix for all the URIs to be generated

```php
<?php

$url->setBaseUri("/invo/");

$url->setBaseUri("/invo/index.php/");

```

public **setStaticBaseUri** (*mixed* $staticBaseUri)

Sets a prefix for all static URLs generated

```php
<?php

$url->setStaticBaseUri("/invo/");

```

public **getBaseUri** ()

Returns the prefix for all the generated urls. By default /

public **getStaticBaseUri** ()

Returns the prefix for all the generated static urls. By default /

public **setBasePath** (*mixed* $basePath)

Sets a base path for all the generated paths

```php
<?php

$url->setBasePath("/var/www/htdocs/");

```

public **getBasePath** ()

Returns the base path

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

Generates a URL for a static resource

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