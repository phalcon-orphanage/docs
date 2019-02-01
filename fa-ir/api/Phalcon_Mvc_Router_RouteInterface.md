---
layout: article
language: 'fa-ir'
version: '4.0'
title: 'Phalcon\Mvc\Router\RouteInterface'
---
# Interface **Phalcon\Mvc\Router\RouteInterface**

[سورس کد در گیت هاب](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/router/routeinterface.zep)

## روش ها

abstract public **setHostname** (*mixed* $hostname)

...

abstract public **getHostname** ()

...

abstract public **compilePattern** (*mixed* $pattern)

...

abstract public **via** (*mixed* $httpMethods)

...

abstract public **reConfigure** (*mixed* $pattern, [*mixed* $paths])

...

عمومی انتزاعی **دریافت نام** ()

...

abstract public **setName** (*mixed* $name)

...

abstract public **setHttpMethods** (*mixed* $httpMethods)

...

abstract public **getRouteId** ()

...

abstract public **getPattern** ()

...

abstract public **getCompiledPattern** ()

...

abstract public **getPaths** ()

...

abstract public **getReversedPaths** ()

...

abstract public **getHttpMethods** ()

...

abstract public static **reset** ()

...