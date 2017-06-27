# Class **Phalcon\\Mvc\\Router\\Annotations**

*extends* class [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

*implements* [Phalcon\Events\EventsAwareInterface](/en/3.1.2/api/Phalcon_Events_EventsAwareInterface), [Phalcon\Mvc\RouterInterface](/en/3.1.2/api/Phalcon_Mvc_RouterInterface), [Phalcon\Di\InjectionAwareInterface](/en/3.1.2/api/Phalcon_Di_InjectionAwareInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/router/annotations.zep" class="btn btn-default btn-sm">Source on GitHub</a>

A router that reads routes annotations from classes/resources

```php
<?php

use Phalcon\Mvc\Router\Annotations;

$di->setShared(
    "router",
    function() {
        // Use the annotations router
        $router = new Annotations(false);

        // This will do the same as above but only if the handled uri starts with /robots
        $router->addResource("Robots", "/robots");

        return $router;
    }
);

```

## Constants

*integer* **URI_SOURCE_GET_URL**

*integer* **URI_SOURCE_SERVER_REQUEST_URI**

*integer* **POSITION_FIRST**

*integer* **POSITION_LAST**

## Methods

public **addResource** (*mixed* $handler, [*mixed* $prefix])

Adds a resource to the annotations handler A resource is a class that contains routing annotations

public **addModuleResource** (*mixed* $module, *mixed* $handler, [*mixed* $prefix])

Adds a resource to the annotations handler A resource is a class that contains routing annotations The class is located in a module

public **handle** ([*mixed* $uri])

Produce the routing parameters from the rewrite information

public **processControllerAnnotation** (*mixed* $handler, [Phalcon\Annotations\Annotation](/en/3.1.2/api/Phalcon_Annotations_Annotation) $annotation)

Checks for annotations in the controller docblock

public **processActionAnnotation** (*mixed* $module, *mixed* $namespaceName, *mixed* $controller, *mixed* $action, [Phalcon\Annotations\Annotation](/en/3.1.2/api/Phalcon_Annotations_Annotation) $annotation)

Checks for annotations in the public methods of the controller

public **setControllerSuffix** (*mixed* $controllerSuffix)

Changes the controller class suffix

public **setActionSuffix** (*mixed* $actionSuffix)

Changes the action method suffix

public **getResources** ()

Return the registered resources

public **__construct** ([*mixed* $defaultRoutes]) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Phalcon\\Mvc\\Router constructor

public **setDI** ([Phalcon\DiInterface](/en/3.1.2/api/Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Sets the dependency injector

public **getDI** () inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Returns the internal dependency injector

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.1.2/api/Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Sets the events manager

public **getEventsManager** () inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Returns the internal event manager

public **getRewriteUri** () inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Get rewrite info. This info is read from $_GET["_url"]. This returns '/' if the rewrite information cannot be read

public **setUriSource** (*mixed* $uriSource) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Sets the URI source. One of the URI_SOURCE_* constants

```php
<?php

$router->setUriSource(
    Router::URI_SOURCE_SERVER_REQUEST_URI
);

```

public **removeExtraSlashes** (*mixed* $remove) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Set whether router must remove the extra slashes in the handled routes

public **setDefaultNamespace** (*mixed* $namespaceName) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Sets the name of the default namespace

public **setDefaultModule** (*mixed* $moduleName) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Sets the name of the default module

public **setDefaultController** (*mixed* $controllerName) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Sets the default controller name

public **setDefaultAction** (*mixed* $actionName) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Sets the default action name

public **setDefaults** (*array* $defaults) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

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

public **getDefaults** () inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Returns an array of default parameters

public **add** (*mixed* $pattern, [*mixed* $paths], [*mixed* $httpMethods], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Adds a route to the router without any HTTP constraint

```php
<?php

use Phalcon\Mvc\Router;

$router->add("/about", "About::index");
$router->add("/about", "About::index", ["GET", "POST"]);
$router->add("/about", "About::index", ["GET", "POST"], Router::POSITION_FIRST);

```

public **addGet** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is GET

public **addPost** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is POST

public **addPut** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is PUT

public **addPatch** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is PATCH

public **addDelete** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is DELETE

public **addOptions** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Add a route to the router that only match if the HTTP method is OPTIONS

public **addHead** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is HEAD

public **addPurge** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is PURGE (Squid and Varnish support)

public **addTrace** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is TRACE

public **addConnect** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is CONNECT

public **mount** ([Phalcon\Mvc\Router\GroupInterface](/en/3.1.2/api/Phalcon_Mvc_Router_GroupInterface) $group) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Mounts a group of routes in the router

public **notFound** (*mixed* $paths) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Set a group of paths to be returned when none of the defined routes are matched

public **clear** () inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Removes all the pre-defined routes

public **getNamespaceName** () inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Returns the processed namespace name

public **getModuleName** () inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Returns the processed module name

public **getControllerName** () inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Returns the processed controller name

public **getActionName** () inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Returns the processed action name

public **getParams** () inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Returns the processed parameters

public **getMatchedRoute** () inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Returns the route that matches the handled URI

public **getMatches** () inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Returns the sub expressions in the regular expression matched

public **wasMatched** () inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Checks if the router matches any of the defined routes

public **getRoutes** () inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Returns all the routes defined in the router

public **getRouteById** (*mixed* $id) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Returns a route object by its id

public **getRouteByName** (*mixed* $name) inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Returns a route object by its name

public **isExactControllerName** () inherited from [Phalcon\Mvc\Router](/en/3.1.2/api/Phalcon_Mvc_Router)

Returns whether controller name should not be mangled