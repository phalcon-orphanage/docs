Interface **Phalcon\\Mvc\\Router\\RouteInterface**
==================================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/router/routeinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **__construct** (*unknown* $pattern, [*unknown* $paths], [*unknown* $httpMethods])

...


abstract public  **compilePattern** (*unknown* $pattern)

...


abstract public  **via** (*unknown* $httpMethods)

...


abstract public  **reConfigure** (*unknown* $pattern, [*unknown* $paths])

...


abstract public  **getName** ()

...


abstract public  **setName** (*unknown* $name)

...


abstract public  **setHttpMethods** (*unknown* $httpMethods)

...


abstract public  **getRouteId** ()

...


abstract public  **getPattern** ()

...


abstract public  **getCompiledPattern** ()

...


abstract public  **getPaths** ()

...


abstract public  **getReversedPaths** ()

...


abstract public  **getHttpMethods** ()

...


abstract public static  **reset** ()

...


