---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Mvc\Router\Annotations'
---
# Class **Phalcon\Mvc\Router\Annotations**

*extends* class [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Mvc\RouterInterface](Phalcon_Mvc_RouterInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/router/annotations.zep)

Ein Router, welcher die Routen Anmerkungen aus Klassen/Ressourcen ermittelt

```php
<?php

use Phalcon\Mvc\Router\Annotations;

$di->setShared(
    "router",
    function() {
        // Anmerkungen router benutzen
        $router = new Annotations(false);

        // Das macht dasselbe wie oben, aber nur , wenn die uri mit /robots beginnt
        $router->addResource("Robots", "/robots");

        return $router;
    }
);

```

## Konstanten

*integer* **URI_SOURCE_GET_URL**

*integer* **URI_SOURCE_SERVER_REQUEST_URI**

*integer* **POSITION_FIRST**

*integer* **POSITION_LAST**

## Methoden

public **addResource** (*mixed* $handler, [*mixed* $prefix])

Fügt eine Ressource dem Anmerkungen Handler hinzu. Eine Ressource ist eine Klasse, welche routing Anmerkungen enthält

public **addModuleResource** (*mixed* $module, *mixed* $handler, [*mixed* $prefix])

Fügt eine Ressource dem Anmerkungen Handler hinzu. Eine Ressource ist eine Klasse, welche routing Anmerkungen enthält. Die Klasse ist in einem Modul hinterlegt

public **handle** ([*mixed* $uri])

Produce the routing parameters from the rewrite information

public **processControllerAnnotation** (*mixed* $handler, [Phalcon\Annotations\Annotation](Phalcon_Annotations_Annotation) $annotation)

Sucht nach Anmerkungen im Controller-docblock

public **processActionAnnotation** (*mixed* $module, *mixed* $namespaceName, *mixed* $controller, *mixed* $action, [Phalcon\Annotations\Annotation](Phalcon_Annotations_Annotation) $annotation)

Sucht nach Anmerkungen in den öffentlichen Methoden des Controllers

public **setControllerSuffix** (*mixed* $controllerSuffix)

Ändert die Controller-Klasse-Endung

public **setActionSuffix** (*mixed* $actionSuffix)

Ändert die Aktion-Methode-Endung

public **getResources** ()

Die registrierten Ressourcen zurückgeben

public **__construct** ([*mixed* $defaultRoutes]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Phalcon\Mvc\Router constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Sets the dependency injector

public **getDI** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Returns the internal dependency injector

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Legt den Event-manager fest

public **getEventsManager** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Gibt den internen Eventmanager zurück

public **getRewriteUri** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Get rewrite info. This info is read from $_GET["_url"]. This returns '/' if the rewrite information cannot be read

public **setUriSource** (*mixed* $uriSource) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Sets the URI source. One of the URI_SOURCE_* constants

```php
<?php

$router->setUriSource(
    Router::URI_SOURCE_SERVER_REQUEST_URI
);

```

public **removeExtraSlashes** (*mixed* $remove) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Set whether router must remove the extra slashes in the handled routes

public **setDefaultNamespace** (*mixed* $namespaceName) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Sets the name of the default namespace

public **setDefaultModule** (*mixed* $moduleName) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Legt den Namen des Standardmoduls fest

public **setDefaultController** (*mixed* $controllerName) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Legt den Standardnamen des controllers fest

public **setDefaultAction** (*mixed* $actionName) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Legt den Standard Aktions Name fest

public **setDefaults** (*array* $defaults) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

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

public **getDefaults** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Returns an array of default parameters

public **add** (*mixed* $pattern, [*mixed* $paths], [*mixed* $httpMethods], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Adds a route to the router without any HTTP constraint

```php
<?php

use Phalcon\Mvc\Router;

$router->add("/about", "About::index");
$router->add("/about", "About::index", ["GET", "POST"]);
$router->add("/about", "About::index", ["GET", "POST"], Router::POSITION_FIRST);

```

public **addGet** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is GET

public **addPost** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is POST

public **addPut** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is PUT

public **addPatch** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is PATCH

public **addDelete** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is DELETE

public **addOptions** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Add a route to the router that only match if the HTTP method is OPTIONS

public **addHead** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is HEAD

public **addPurge** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is PURGE (Squid and Varnish support)

public **addTrace** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is TRACE

public **addConnect** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is CONNECT

public **mount** ([Phalcon\Mvc\Router\GroupInterface](Phalcon_Mvc_Router_GroupInterface) $group) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Mounts a group of routes in the router

public **notFound** (*mixed* $paths) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Set a group of paths to be returned when none of the defined routes are matched

public **clear** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Removes all the pre-defined routes

public **getNamespaceName** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Returns the processed namespace name

public **getModuleName** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Returns the processed module name

public **getControllerName** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Returns the processed controller name

public **getActionName** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Returns the processed action name

public **getParams** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Returns the processed parameters

public **getMatchedRoute** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Gibt die Route zurück, welche auf die verarbeitete URI passt

public **getMatches** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Gibt die Sub-Ausdrücke in einem passenden regulären Ausdruck zurück

public **wasMatched** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Überprüft, ob der Router mit einem definierten routen übereinstimmt

public **getRoutes** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Gibt alle im router definierten Routen zurück

public **getRouteById** (*mixed* $id) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Gibt ein Routenobjekt anhand der id zurück

public **getRouteByName** (*mixed* $name) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Gibt ein Routenobjekt anhand des Namens zurück

public **isExactControllerName** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Returns whether controller name should not be mangled