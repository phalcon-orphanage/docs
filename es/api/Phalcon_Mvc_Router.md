# Class **Phalcon\\Mvc\\Router**

*implements* [Phalcon\Di\InjectionAwareInterface](/en/3.2/api/Phalcon_Di_InjectionAwareInterface), [Phalcon\Mvc\RouterInterface](/en/3.2/api/Phalcon_Mvc_RouterInterface), [Phalcon\Events\EventsAwareInterface](/en/3.2/api/Phalcon_Events_EventsAwareInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/router.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Phalcon\\Mvc\\Router es el router de marco estándar. Enrutamiento es el proceso de tomar un punto final URI (la parte del URI que viene después de la URL base) y descomponiéndolo en parámetros para determinar qué módulo, controlador y la acción de ese controlador debería recibir la solicitud

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

$router->add(
    "/documentation/{chapter}/{name}\.{type:[a-z]+}",
    [
        "controller" => "documentation",
        "action"     => "show",
    ]
);

$router->handle();

echo $router->getControllerName();

```

## Constants

*integer* **URI_SOURCE_GET_URL**

*integer* **URI_SOURCE_SERVER_REQUEST_URI**

*integer* **POSITION_FIRST**

*integer* **POSITION_LAST**

## Methods

public **__construct** ([*mixed* $defaultRoutes])

Phalcon\\Mvc\\Router constructor

public **setDI** ([Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector)

Sets the dependency injector

public **getDI** ()

Returns the internal dependency injector

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.2/api/Phalcon_Events_ManagerInterface) $eventsManager)

Sets the events manager

public **getEventsManager** ()

Returns the internal event manager

public **getRewriteUri** ()

Obtener información de reescritura Esta información se lee de $_GET["_url"]. Esto devuelve '/' si la información de reescritura no se puede leer

public **setUriSource** (*mixed* $uriSource)

Sets the URI source. One of the URI_SOURCE_* constants

```php
<?php

$router->setUriSource(
    Router::URI_SOURCE_SERVER_REQUEST_URI
);

```

public **removeExtraSlashes** (*mixed* $remove)

Set whether router must remove the extra slashes in the handled routes

public **setDefaultNamespace** (*mixed* $namespaceName)

Sets the name of the default namespace

public **setDefaultModule** (*mixed* $moduleName)

Sets the name of the default module

public **setDefaultController** (*mixed* $controllerName)

Sets the default controller name

public **setDefaultAction** (*mixed* $actionName)

Sets the default action name

public **setDefaults** (*array* $defaults)

Establece una matriz de rutas predeterminadas. Si a una ruta le falta un camino, el router usará lo definido aquí Este método no debe usarse para establecer una ruta 404

```php
<?php

$router->setDefaults(
    [
        "module" => "common",
        "action" => "index",
    ]
);

```

public **getDefaults** ()

Returns an array of default parameters

public **handle** ([*mixed* $uri])

Handles routing information received from the rewrite engine

```php
<?php

// Read the info from the rewrite engine
$router->handle();

// Manually passing an URL
$router->handle("/posts/edit/1");

```

public **add** (*mixed* $pattern, [*mixed* $paths], [*mixed* $httpMethods], [*mixed* $position])

Adds a route to the router without any HTTP constraint

```php
<?php

use Phalcon\Mvc\Router;

$router->add("/about", "About::index");
$router->add("/about", "About::index", ["GET", "POST"]);
$router->add("/about", "About::index", ["GET", "POST"], Router::POSITION_FIRST);

```

public **addGet** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

Adds a route to the router that only match if the HTTP method is GET

public **addPost** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

Adds a route to the router that only match if the HTTP method is POST

public **addPut** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

Adds a route to the router that only match if the HTTP method is PUT

public **addPatch** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

Adds a route to the router that only match if the HTTP method is PATCH

public **addDelete** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

Adds a route to the router that only match if the HTTP method is DELETE

public **addOptions** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

Add a route to the router that only match if the HTTP method is OPTIONS

public **addHead** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

Adds a route to the router that only match if the HTTP method is HEAD

public **addPurge** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

Adds a route to the router that only match if the HTTP method is PURGE (Squid and Varnish support)

public **addTrace** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

Adds a route to the router that only match if the HTTP method is TRACE

public **addConnect** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

Adds a route to the router that only match if the HTTP method is CONNECT

public **mount** ([Phalcon\Mvc\Router\GroupInterface](/en/3.2/api/Phalcon_Mvc_Router_GroupInterface) $group)

Mounts a group of routes in the router

public **notFound** (*mixed* $paths)

Establezca un grupo de rutas que se devolverán cuando ninguna de las rutas definidas coincidan

public **clear** ()

Removes all the pre-defined routes

public **getNamespaceName** ()

Returns the processed namespace name

public **getModuleName** ()

Returns the processed module name

public **getControllerName** ()

Returns the processed controller name

public **getActionName** ()

Returns the processed action name

public **getParams** ()

Returns the processed parameters

public **getMatchedRoute** ()

Returns the route that matches the handled URI

public **getMatches** ()

Devuelve las expresiones secundarias en la expresión regular combinada

public **wasMatched** ()

Checks if the router matches any of the defined routes

public **getRoutes** ()

Returns all the routes defined in the router

public **getRouteById** (*mixed* $id)

Returns a route object by its id

public **getRouteByName** (*mixed* $name)

Returns a route object by its name

public **isExactControllerName** ()

Devuelve si el nombre del controlador no debe ser roto