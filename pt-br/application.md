---
layout: default
language: 'pt-br'
version: '4.0'
title: 'Application'
keywords: 'application, mvc, controllers'
---

# Application

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

[Phalcon\Mvc\Application](api/phalcon_mvc#mvc-application) is a component that encapsulates all the complex operations behind instantiating every component required to run an MVC application. This is a full stack application integrated with all the additional services required to allow the MVC pattern to operate as desired.

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;

$container   = new FactoryDefault();
$application = new Application($container);

try {
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo $e->getMessage();
}
```

## Methods

```php
public function __construct(
    DiInterface $container = null
)
```

Constructor. Accepts a DI container with relevant services

```php
public function getDefaultModule(): string
```

Returns the default module name

```php
public function getEventsManager(): ManagerInterface
```

Returns the internal event manager

```php
public function getModule(
    string $name
): array | object
```

Gets the module definition registered in the application via module name

```php
public function getModules(): array
```

Return the modules registered in the application

```php
public function registerModules(
    array $modules, 
    bool $merge = false
): AbstractApplication
```

Register an array of modules present in the application

```php
$this->registerModules(
    [
        "front" => [
            "className" => \Multi\Front\Module::class,
            "path"      => "../apps/front/Module.php",
        ],
        "back" => [
            "className" => \Multi\Back\Module::class,
            "path"      => "../apps/back/Module.php",
        ],
    ]
);
```

```php
public function setDefaultModule(
    string $defaultModule
): AbstractApplication
```

Sets the module name to be used if the router doesn't return a valid module

```php
public function setEventsManager(
    ManagerInterface $eventsManager
): void
```

Sets the events manager

```php
public function handle(
    string $uri
): ResponseInterface | bool
```

Handles a MVC request. Accepts the server URI (usually `$_SERVER['REQUEST_URI`]`)

```php
public function sendCookiesOnHandleRequest(
    bool $sendCookies
): Application
```

Enables or disables sending cookies by each request handling

```php
public function sendHeadersOnHandleRequest(
    bool $sendHeaders
): Application
```

Enables or disables sending headers by each request handling

```php
public function useImplicitView(
    bool $implicitView
): Application
```

This is enabled by default. The view is implicitly buffering all the output. You can fully disable the view component using this method

## Activation

[Phalcon\Mvc\Application](api/phalcon_mvc#mvc-application) performs all the work necessary to glue all the necessary components together so that the application can run. There are several ways that you can bootstrap your application. The most common way to bootstrap the application is:

```php
<?php

use Phalcon\Di\FactoryDefault();
use Phalcon\Mvc\Application;

$container = new FactoryDefault();

// Services
// ...

$application = new Application($container);

try {
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
```

The core of all the work of the controller occurs when `handle()` is invoked:

```php
<?php

$response = $application->handle(
    $_SERVER["REQUEST_URI"]
);
```

## Manual Bootstrapping

If you do not wish to use [Phalcon\Mvc\Application](api/phalcon_mvc#mvc-application), the code above can be changed as follows:

```php
<?php

use Phalcon\Di\FactoryDefault();
use Phalcon\Mvc\Application;

$container = new FactoryDefault();

$router = $container['router'];

$router->handle(
    $_SERVER["REQUEST_URI"]
);

$view = $container['view'];

$dispatcher = $container['dispatcher'];

$dispatcher->setControllerName(
    $router->getControllerName()
);

$dispatcher->setActionName(
    $router->getActionName()
);

$dispatcher->setParams(
    $router->getParams()
);

// View
$view->start();

// Dispatcher
$dispatcher->dispatch();

// View 
$view->render(
    $dispatcher->getControllerName(),
    $dispatcher->getActionName(),
    $dispatcher->getParams()
);

// View
$view->finish();

$response = $container['response'];

$response->setContent(
    $view->getContent()
);

$response->send();
```

The following replacement of [Phalcon\Mvc\Application](api/phalcon_mvc#mvc-application) does not have the `view`, making it suitable for REST API applications:

```php
<?php

use Phalcon\Di\FactoryDefault();
use Phalcon\Http\ResponseInterface;
use Phalcon\Mvc\Application;

$container = new FactoryDefault();

$router = $container['router'];

$router->handle(
    $_SERVER["REQUEST_URI"]
);

$dispatcher = $container['dispatcher'];

$dispatcher->setControllerName(
    $router->getControllerName()
);

$dispatcher->setActionName(
    $router->getActionName()
);

$dispatcher->setParams(
    $router->getParams()
);

$dispatcher->dispatch();

$response = $dispatcher->getReturnedValue();

if ($response instanceof ResponseInterface) {
    $response->send();
}
```

Another way that catches exceptions generated in the dispatcher forwarding to other actions consequently is as follows:

```php
<?php

use Phalcon\Di\FactoryDefault();
use Phalcon\Http\ResponseInterface;
use Phalcon\Mvc\Application;

$container = new FactoryDefault();

// Get the 'router' service
$router = $container['router'];

$router->handle(
    $_SERVER["REQUEST_URI"]
);

$dispatcher = $container['dispatcher'];

$dispatcher->setControllerName(
    $router->getControllerName()
);

$dispatcher->setActionName(
    $router->getActionName()
);

$dispatcher->setParams(
    $router->getParams()
);

try {
    $dispatcher->dispatch();
} catch (Exception $e) {
    // 503
    $dispatcher->setControllerName('errors');
    $dispatcher->setActionName('action503');

    $dispatcher->dispatch();
}

$response = $dispatcher->getReturnedValue();

if ($response instanceof ResponseInterface) {
    $response->send();
}
```

Depending on your application needs, you might want to have full control of what should be instantiated or not, or replace certain components with those of your own to extend the default functionality. The bootstrapping method you choose depends on the needs of your application.

## Single - Multi Module

[Phalcon\Mvc\Application](api/phalcon_mvc#mvc-application) offers two ways of MVC structures: Single and Multi module.

### Single Module

Single module MVC applications consist of one module only. Namespaces can be used but are not necessary. The structure of such application is usually as follows:

    single/
        app/
            controllers/
            models/
            views/
        public/
            css/
            img/
            js/
    

If namespaces are not used, the following bootstrap file could be used:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\View;

$loader = new Loader();
$loader->registerDirs(
    [
        '../apps/controllers/',
        '../apps/models/',
    ]
);

$loader->register();

$container = new FactoryDefault();

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(
            '../apps/views/'
        );

        return $view;
    }
);

$application = new Application($container);

try {
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo $e->getMessage();
}
```

If namespaces are used, the bootstrap changes slightly:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;

$loader = new Loader();
$loader->registerNamespaces(
    [
        'Single\Controllers' => '../apps/controllers/',
        'Single\Models'      => '../apps/models/',
    ]
);

$loader->register();

$container = new FactoryDefault();

$container->set(
    'dispatcher',
    function () {
        $dispatcher = new Dispatcher();
        $dispatcher->setDefaultNamespace(
            'Single\Controllers'
        );

        return $dispatcher;
    }
);

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(
            '../apps/views/'
        );

        return $view;
    }
);

$application = new Application($container);

try {
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo $e->getMessage();
}
```

### Multi Module

A multi-module application uses the same document root for more than one module. Modules are groups of components/files that offer functionality but increase maintainability and isolate functionality if necessary. Each module must implement the [Phalcon\Mvc\ModuleDefinitionInterface](api/phalcon_mvc#mvc-moduledefinitioninterface), to ensure proper functionality. A sample directory structure can be seen below:

    multiple/
      apps/
        front/
           controllers/
           models/
           views/
           Module.php
        back/
           controllers/
           models/
           views/
           Module.php
      public/
        css/
        img/
        js/
    

Each subdirectory in `apps/` directory have its own MVC structure. A `Module.php` file is present in each module directory, to configure specific settings of each module, such as autoloaders, custom services etc.

```php
<?php

namespace Multi\Back;

use Phalcon\Loader;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(
        DiInterface $container = null
    )
    {
        $loader = new Loader();
        $loader->registerNamespaces(
            [
                'Multi\Back\Controllers' => '../apps/back/controllers/',
                'Multi\Back\Models'      => '../apps/back/models/',
            ]
        );

        $loader->register();
    }

    public function registerServices(DiInterface $container)
    {
        // Registering a dispatcher
        $container->set(
            'dispatcher',
            function () {
                $dispatcher = new Dispatcher();
                $dispatcher->setDefaultNamespace(
                    'Multi\Back\Controllers'
                );

                return $dispatcher;
            }
        );

        // Registering the view component
        $container->set(
            'view',
            function () {
                $view = new View();
                $view->setViewsDir(
                    '../apps/back/views/'
                );

                return $view;
            }
        );
    }
}
```

A slightly modified bootstrap file is required for a a multi module MVC architecture

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Router;

$container = new FactoryDefault();

$container->set(
    'router',
    function () {
        $router = new Router();

        $router->setDefaultModule('front');

        $router->add(
            '/login',
            [
                'module'     => 'back',
                'controller' => 'login',
                'action'     => 'index',
            ]
        );

        $router->add(
            '/admin/products/:action',
            [
                'module'     => 'back',
                'controller' => 'products',
                'action'     => 1,
            ]
        );

        $router->add(
            '/products/:action',
            [
                'controller' => 'products',
                'action'     => 1,
            ]
        );

        return $router;
    }
);

$application = new Application($container);

$application->registerModules(
    [
        'front' => [
            'className' => \Multi\Front\Module::class,
            'path'      => '../apps/front/Module.php',
        ],
        'back'  => [
            'className' => \Multi\Back\Module::class,
            'path'      => '../apps/back/Module.php',
        ]
    ]
);

try {
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo $e->getMessage();
}
```

If you want to keep the module configuration in your bootstrap file, you can use an anonymous function to register the module.

```php
<?php

use Phalcon\Mvc\View;

$view = new View();

// ...

$application->registerModules(
    [
        'front' => function ($container) use ($view) {
            $container->setShared(
                'view',
                function () use ($view) {
                    $view->setViewsDir(
                        '../apps/front/views/'
                    );

                    return $view;
                }
            );
        },
        'back' => function ($container) use ($view) {
            $container->setShared(
                'view',
                function () use ($view) {
                    $view->setViewsDir(
                        '../apps/back/views/'
                    );

                    return $view;
                }
            );
        }
    ]
);
```

When [Phalcon\Mvc\Application](api/phalcon_mvc#mvc-application) has modules registered, it is essential that every matched route returns a valid module. Each registered module has an associated class exposing methods for the module setup.

Module definition classes must implement two methods: - `registerAutoloaders()` and - `registerServices()`

These will be called by the [Phalcon\Mvc\Application](api/phalcon_mvc#mvc-application) accordingly.

## Exceptions

Any exceptions thrown in the [Phalcon\Mvc\Application](api/phalcon_mvc#mvc-application) component will be of type [Phalcon\Mvc\Application\Exception](api/phalcon_mvc#mvc-application-exception) or [Phalcon\Application\Exception](api/phalcon_application#application-exception). You can use this exception to selectively catch exceptions thrown only from this component.

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Application\Exception;

try {
    $container   = new FactoryDefault();

    // ...

    $application = new Application($container);
    $application->registerModules(
        [
            'front' => false,
        ]
    );

    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (Exception $e) {
    echo $e->getMessage();
}
```

## Events

[Phalcon\Mvc\Application](api/phalcon_mvc#mvc-application) is able to send events to the [EventsManager](events) (if it is present). Events are triggered using the type `application`. The following events are supported:

| Event Name            | Triggered                                                    |
| --------------------- | ------------------------------------------------------------ |
| `boot`                | Executed when the application handles its first request      |
| `beforeStartModule`   | Before initialize a module, only when modules are registered |
| `afterStartModule`    | After initialize a module, only when modules are registered  |
| `beforeHandleRequest` | Before execute the dispatch loop                             |
| `afterHandleRequest`  | After execute the dispatch loop                              |

The following example demonstrates how to attach listeners to this component:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager;

$manager = new Manager();

$application->setEventsManager($manager);

$manager->attach(
    'application',
    function (Event $event, $application) {
        // ...
    }
);
```

## External Resources

* [MVC examples on GitHub](https://github.com/phalcon/mvc)