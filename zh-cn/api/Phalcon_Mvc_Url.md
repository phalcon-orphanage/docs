---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Mvc\Url'
---
# Class **Phalcon\Mvc\Url**

*implements* [Phalcon\Mvc\UrlInterface](Phalcon_Mvc_UrlInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/url.zep)

在生成此组件帮助： Uri、 Url 和路径

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

## 方法

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Sets the DependencyInjector container

public **getDI** ()

Returns the DependencyInjector container

public **setBaseUri** (*mixed* $baseUri)

设置要生成的所有 Uri 的前缀

```php
<?php

$url->setBaseUri("/invo/");

$url->setBaseUri("/invo/index.php/");

```

public **setStaticBaseUri** (*mixed* $staticBaseUri)

为生成的所有静态 Url 设置前缀

```php
<?php

$url->setStaticBaseUri("/invo/");

```

public **getBaseUri** ()

Returns the prefix for all the generated urls. By default /

public **getStaticBaseUri** ()

Returns the prefix for all the generated static urls. By default /

public **setBasePath** (*mixed* $basePath)

设置为生成的所有路径的基本路径

```php
<?php

$url->setBasePath("/var/www/htdocs/");

```

public **getBasePath** ()

返回基路径

public **get** ([*mixed* $uri], [*mixed* $args], [*mixed* $local], [*mixed* $baseUri])

生成的 URL

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

为静态资源生成 URL

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

生成的本地路径