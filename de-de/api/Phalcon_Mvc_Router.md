---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Mvc\Router'
---
# Class **Phalcon\Mvc\Router**

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Mvc\RouterInterface](Phalcon_Mvc_RouterInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/router.zep)

Phalcon\Mvc\Router is the standard framework router. Routing is the process of taking a URI endpoint (that part of the URI which comes after the base URL) and decomposing it into parameters to determine which module, controller, and action of that controller should receive the request

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

## Konstanten

*integer* **URI_SOURCE_GET_URL**

*integer* **URI_SOURCE_SERVER_REQUEST_URI**

*integer* **POSITION_FIRST**

*integer* **POSITION_LAST**

## Methoden

public **__construct** ([*mixed* $defaultRoutes])

Phalcon\Mvc\Router constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Sets the dependency injector

public **getDI** ()

Returns the internal dependency injector

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Legt den Event-manager fest

public **getEventsManager** ()

Gibt den internen Eventmanager zurück

public **getRewriteUri** ()

Get rewrite info. This info is read from $_GET["_url"]. This returns '/' if the rewrite information cannot be read

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

Legt den Namen des Standardmoduls fest

public **setDefaultController** (*mixed* $controllerName)

Legt den Standardnamen des controllers fest

public **setDefaultAction** (*mixed* $actionName)

Legt den Standard Aktions Name fest

public **setDefaults** (*array* $defaults)

Sets an array of default paths. If a route is missing a path the router will use the defined here This method must not be used to set a 404 route

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

public **mount** ([Phalcon\Mvc\Router\GroupInterface](Phalcon_Mvc_Router_GroupInterface) $group)

Mounts a group of routes in the router

public **notFound** (*mixed* $paths)

Set a group of paths to be returned when none of the defined routes are matched

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

Gibt die Route zurück, welche auf die verarbeitete URI passt

public **getMatches** ()

Gibt die Sub-Ausdrücke in einem passenden regulären Ausdruck zurück

public **wasMatched** ()

Überprüft, ob der Router mit einem definierten routen übereinstimmt

public **getRoutes** ()

Gibt alle im router definierten Routen zurück

public **getRouteById** (*mixed* $id)

Gibt ein Routenobjekt anhand der id zurück

public **getRouteByName** (*mixed* $name)

Gibt ein Routenobjekt anhand des Namens zurück

public **isExactControllerName** ()

Returns whether controller name should not be mangled