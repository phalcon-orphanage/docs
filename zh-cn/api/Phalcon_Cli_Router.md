* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Cli\Router'

* * *

# Class **Phalcon\Cli\Router**

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/cli/router.zep" class="btn btn-default btn-sm">源码在GitHub</a>

Phalcon\Cli\Router is the standard framework router. Routing is the process of taking a command-line arguments and decomposing it into parameters to determine which module, task, and action of that task should receive the request

```php
<?php

$router = new \Phalcon\Cli\Router();

$router->handle(
    [
        "module" => "main",
        "task"   => "videos",
        "action" => "process",
    ]
);

echo $router->getTaskName();

```

## 方法

public **__construct** ([*mixed* $defaultRoutes])

Phalcon\Cli\Router constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Sets the dependency injector

public **getDI** ()

Returns the internal dependency injector

public **setDefaultModule** (*mixed* $moduleName)

Sets the name of the default module

public **setDefaultTask** (*mixed* $taskName)

Sets the default controller name

public **setDefaultAction** (*mixed* $actionName)

Sets the default action name

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

public **handle** ([*array* $arguments])

Handles routing information received from command-line arguments

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **add** (*string* $pattern, [*string/array* $paths])

Adds a route to the router

```php
<?php

$router->add("/about", "About::main");

```

public **getModuleName** ()

Returns processed module name

public **getTaskName** ()

Returns processed task name

public **getActionName** ()

Returns processed action name

public *array* **getParams** ()

Returns processed extra params

public **getMatchedRoute** ()

Returns the route that matches the handled URI

public *array* **getMatches** ()

Returns the sub expressions in the regular expression matched

public **wasMatched** ()

Checks if the router matches any of the defined routes

public **getRoutes** ()

Returns all the routes defined in the router

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **getRouteById** (*int* $id)

Returns a route object by its id

public **getRouteByName** (*mixed* $name)

Returns a route object by its name