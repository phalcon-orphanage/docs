# Class **Phalcon\\Mvc\\Micro**

*extends* abstract class [Phalcon\Di\Injectable](/en/3.2/api/Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](/en/3.2/api/Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](/en/3.2/api/Phalcon_Di_InjectionAwareInterface), [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/micro.zep" class="btn btn-default btn-sm">Source on GitHub</a>

With Phalcon you can create "Micro-Framework like" applications. By doing this, you only need to write a minimal amount of code to create a PHP application. Micro applications are suitable to small applications, APIs and prototypes in a practical way.

```php
<?php

$app = new \Phalcon\Mvc\Micro();

$app->get(
    "/say/welcome/{name}",
    function ($name) {
        echo "<h1>Welcome $name!</h1>";
    }
);

$app->handle();

```

## Methods

public **__construct** ([[Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector])

Phalcon\\Mvc\\Micro constructor

public **setDI** ([Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector)

Sets the DependencyInjector container

public [Phalcon\Mvc\Router\RouteInterface](/en/3.2/api/Phalcon_Mvc_Router_RouteInterface) **map** (*string* $routePattern, *callable* $handler)

Maps a route to a handler without any HTTP method constraint

public [Phalcon\Mvc\Router\RouteInterface](/en/3.2/api/Phalcon_Mvc_Router_RouteInterface) **get** (*string* $routePattern, *callable* $handler)

Maps a route to a handler that only matches if the HTTP method is GET

public [Phalcon\Mvc\Router\RouteInterface](/en/3.2/api/Phalcon_Mvc_Router_RouteInterface) **post** (*string* $routePattern, *callable* $handler)

Maps a route to a handler that only matches if the HTTP method is POST

public [Phalcon\Mvc\Router\RouteInterface](/en/3.2/api/Phalcon_Mvc_Router_RouteInterface) **put** (*string* $routePattern, *callable* $handler)

Maps a route to a handler that only matches if the HTTP method is PUT

public [Phalcon\Mvc\Router\RouteInterface](/en/3.2/api/Phalcon_Mvc_Router_RouteInterface) **patch** (*string* $routePattern, *callable* $handler)

Maps a route to a handler that only matches if the HTTP method is PATCH

public [Phalcon\Mvc\Router\RouteInterface](/en/3.2/api/Phalcon_Mvc_Router_RouteInterface) **head** (*string* $routePattern, *callable* $handler)

Maps a route to a handler that only matches if the HTTP method is HEAD

public [Phalcon\Mvc\Router\RouteInterface](/en/3.2/api/Phalcon_Mvc_Router_RouteInterface) **delete** (*string* $routePattern, *callable* $handler)

Maps a route to a handler that only matches if the HTTP method is DELETE

public [Phalcon\Mvc\Router\RouteInterface](/en/3.2/api/Phalcon_Mvc_Router_RouteInterface) **options** (*string* $routePattern, *callable* $handler)

Maps a route to a handler that only matches if the HTTP method is OPTIONS

public **mount** ([Phalcon\Mvc\Micro\CollectionInterface](/en/3.2/api/Phalcon_Mvc_Micro_CollectionInterface) $collection)

Mounts a collection of handlers

public [Phalcon\Mvc\Micro](/en/3.2/api/Phalcon_Mvc_Micro) **notFound** (*callable* $handler)

Sets a handler that will be called when the router doesn't match any of the defined routes

public [Phalcon\Mvc\Micro](/en/3.2/api/Phalcon_Mvc_Micro) **error** (*callable* $handler)

Sets a handler that will be called when an exception is thrown handling the route

public **getRouter** ()

Returns the internal router used by the application

public [Phalcon\Di\ServiceInterface](/en/3.2/api/Phalcon_Di_ServiceInterface) **setService** (*string* $serviceName, *mixed* $definition, [*boolean* $shared])

Sets a service from the DI

public **hasService** (*mixed* $serviceName)

Checks if a service is registered in the DI

public *object* **getService** (*string* $serviceName)

Obtains a service from the DI

public *mixed* **getSharedService** (*string* $serviceName)

Obtains a shared service from the DI

public *mixed* **handle** ([*string* $uri])

Handle the whole request

public **stop** ()

Stops the middleware execution avoiding than other middlewares be executed

public **setActiveHandler** (*callable* $activeHandler)

Sets externally the handler that must be called by the matched route

public *callable* **getActiveHandler** ()

Return the handler that will be called for the matched route

public *mixed* **getReturnedValue** ()

Returns the value returned by the executed handler

public *boolean* **offsetExists** (*string* $alias)

Check if a service is registered in the internal services container using the array syntax

public **offsetSet** (*string* $alias, *mixed* $definition)

Allows to register a shared service in the internal services container using the array syntax

```php
<?php

$app["request"] = new \Phalcon\Http\Request();

```

public *mixed* **offsetGet** (*string* $alias)

Allows to obtain a shared service in the internal services container using the array syntax

```php
<?php

var_dump(
    $app["request"]
);

```

public **offsetUnset** (*string* $alias)

Removes a service from the internal services container using the array syntax

public [Phalcon\Mvc\Micro](/en/3.2/api/Phalcon_Mvc_Micro) **before** (*callable* $handler)

Appends a before middleware to be called before execute the route

public [Phalcon\Mvc\Micro](/en/3.2/api/Phalcon_Mvc_Micro) **afterBinding** (*callable* $handler)

Appends a afterBinding middleware to be called after model binding

public [Phalcon\Mvc\Micro](/en/3.2/api/Phalcon_Mvc_Micro) **after** (*callable* $handler)

Appends an 'after' middleware to be called after execute the route

public [Phalcon\Mvc\Micro](/en/3.2/api/Phalcon_Mvc_Micro) **finish** (*callable* $handler)

Appends a 'finish' middleware to be called when the request is finished

public **getHandlers** ()

Returns the internal handlers attached to the application

public **getModelBinder** ()

Gets model binder

public **setModelBinder** ([Phalcon\Mvc\Model\BinderInterface](/en/3.2/api/Phalcon_Mvc_Model_BinderInterface) $modelBinder, [*mixed* $cache])

Sets model binder

```php
<?php

$micro = new Micro($di);
$micro->setModelBinder(new Binder(), 'cache');

```

public **getBoundModels** ()

Returns bound models from binder instance

public **getDI** () inherited from [Phalcon\Di\Injectable](/en/3.2/api/Phalcon_Di_Injectable)

Returns the internal dependency injector

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.2/api/Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](/en/3.2/api/Phalcon_Di_Injectable)

Sets the event manager

public **getEventsManager** () inherited from [Phalcon\Di\Injectable](/en/3.2/api/Phalcon_Di_Injectable)

Returns the internal event manager

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](/en/3.2/api/Phalcon_Di_Injectable)

Magic method __get