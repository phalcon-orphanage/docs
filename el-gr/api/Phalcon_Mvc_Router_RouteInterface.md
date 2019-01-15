* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Mvc\Router\RouteInterface'

* * *

# Interface **Phalcon\Mvc\Router\RouteInterface**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/router/routeinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Methods

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

abstract public **getName** ()

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