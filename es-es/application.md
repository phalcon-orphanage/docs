---
layout: default
language: 'es-es'
version: '5.0'
title: 'Application'
upgrade: '#application'
keywords: 'aplicación, mvc, controladores'
---

# Application
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
[Phalcon\Mvc\Application][mvc-application] is a component that encapsulates all the complex operations behind instantiating every component required to run an MVC application. Esta es una aplicación de pila completa (*full stack*) integrada con todos los servicios adicionales necesarios para permitir que el patrón MVC funcione como se desee.


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
> **NOTE**: `handle()` accepts a URI and will not operate without it. You can pass the `$_SERVER["REQUEST_URI"]` as a parameter 
> 
> {: .alert .alert-warning }


## Métodos
```php
public function __construct(
    DiInterface $container = null
)
```
Constructor. Acepta un contenedor DI con los servicios relevantes

```php
public function getDefaultModule(): string
```
Devuelve el nombre de módulo por defecto

```php
public function getEventsManager(): ManagerInterface | null
```
Devuelve el administrador de eventos interno

```php
public function getModule(
    string $name
): array | object
```
Obtiene la definición de módulo registrada en la aplicación a través del nombre del módulo

```php
public function getModules(): array
```
Devuelve los módulos registrados en la aplicación

```php
public function registerModules(
    array $modules, 
    bool $merge = false
): AbstractApplication
```
Registra un vector de módulos presente en la aplicación

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
Establece el nombre del módulo que se utilizará si el router no devuelve un módulo válido

```php
public function setEventsManager(
    ManagerInterface $eventsManager
): void
```
Establece el administrador de eventos

```php
public function handle(
    string $uri
): ResponseInterface | bool
```
Handles an MVC request. Acepta la URL del servidor (normalmente `$_SERVER['REQUEST_URI`]`)

```php
public function sendCookiesOnHandleRequest(
    bool $sendCookies
): Application
```
Habilita o deshabilita el envío de cookies para cada gestión de petición

```php
public function sendHeadersOnHandleRequest(
    bool $sendHeaders
): Application
```
Habilita o deshabilita el envío de cabeceras para cada gestión de petición

```php
public function useImplicitView(
    bool $implicitView
): Application
```
Está habilitado por defecto. La vista está almacenando implícitamente en *buffer* toda la salida. Puede deshabilitar completamente el componente vista usando este método

## Activación
[Phalcon\Mvc\Application][mvc-application] performs all the work necessary to glue all the necessary components together so that the application can run. Hay varias maneras de arrancar su aplicación. La manera más común para arrancar la aplicación es:

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

El núcleo de todo el trabajo del controlador ocurre cuando se invoca `handle()`:

```php
<?php

$response = $application->handle(
    $_SERVER["REQUEST_URI"]
);
```

## Arranque manual
If you do not wish to use [Phalcon\Mvc\Application][mvc-application], the code above can be changed as follows:

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

The following replacement of [Phalcon\Mvc\Application][mvc-application] does not have the `view`, making it suitable for REST API applications:

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

Otra forma de capturar las excepciones generadas en la redirección a otras acciones en el despachador es la siguiente:

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

Dependiendo de las necesidades de su aplicación, podría querer tener el control total de lo que se debe instanciar o no, o sustituir ciertos componentes por los suyos propios para extender la funcionalidad predeterminada. El método de arranque que elija depende de las necesidades de su aplicación.

## Único - Multi Módulo
[Phalcon\Mvc\Application][mvc-application] offers two ways of MVC structures: Single and Multi module.

### Módulo Único
Las aplicaciones MVC de módulo único consisten en un sólo módulo. El espacio de nombres se puede usar pero no es necesario. La estructura de dicha aplicación suele ser la siguiente:

```
single/
    app/
        controllers/
        models/
        views/
    public/
        css/
        img/
        js/
```

Si no se usa espacio de nombres, se podría usar el siguiente fichero de arranque:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Loader\Loader;
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

Si se usa espacio de nombres, el arranque cambia claramente:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Loader\Loader;
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

### Multi Módulo
A multimodule application uses the same document root for more than one module. Los módulos son grupos de componentes/ficheros que ofrecen funcionalidad pero incrementan el mantenimiento y aíslan la funcionalidad si es necesario. Each module must implement the [Phalcon\Mvc\ModuleDefinitionInterface][mvc-moduledefinitioninterface], to ensure proper functionality. Una estructura de directorio de ejemplo puede verse a continuación:

```
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
```
Cada subdirectorio en el directorio `apps/` tiene su propia estructura MVC. Existe un fichero `Module.php` en cada directorio de módulo, para configurar ajustes específicos de cada módulo, como autocargadores, servicios personalizados, etc.

```php
<?php

namespace Multi\Back;

use Phalcon\Loader\Loader;
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
        // Dispatcher
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

        // View
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

A slightly modified bootstrap file is required for a multimodule MVC architecture

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

Si quiere mantener la configuración del módulo en su fichero de arranque, puede usar una función anónima para registrar el módulo.

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

When a [Phalcon\Mvc\Application][mvc-application] has modules registered, it is essential that every matched route returns a valid module. Cada módulo registrado tiene una clase asociada que expone métodos para la configuración del módulo.

Module definition classes must implement two methods:
- `registerAutoloaders()` and
- `registerServices()`

These will be called by the [Phalcon\Mvc\Application][mvc-application] accordingly.

## Excepciones
Any exceptions thrown in the [Phalcon\Mvc\Application][mvc-application] component will be of type [Phalcon\Mvc\Application\Exception][mvc-application-exception] or [Phalcon\Application\Exception][application-exception]. Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente.

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


## Eventos
[Phalcon\Mvc\Application][mvc-application] is able to send events to the [EventsManager](events) (if it is present). Los eventos son disparados usando el tipo `application`. Se soportan los siguientes eventos:

| Nombre de evento      | Disparado                                                                   |
| --------------------- | --------------------------------------------------------------------------- |
| `boot`                | Cuando la aplicación gestiona su primer solicitud                           |
| `beforeStartModule`   | Antes de inicializar un módulo, sólo cuando los módulos están registrados   |
| `afterStartModule`    | Después de inicializar un módulo, sólo cuando los módulos están registrados |
| `beforeHandleRequest` | Antes de ejecutar el bucle de despacho                                      |
| `afterHandleRequest`  | Después de ejecutar el bucle de despacho                                    |

En el ejemplo siguiente se muestra cómo adjuntar oyentes (listeners) a este componente:

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

## Recursos externos
* [Ejemplos MVC en GitHub](https://github.com/phalcon/mvc)

[application-exception]: api/phalcon_application#application-exception
[mvc-application]: api/phalcon_mvc#mvc-application
[mvc-application-exception]: api/phalcon_mvc#mvc-application-exception
[mvc-moduledefinitioninterface]: api/phalcon_mvc#mvc-moduledefinitioninterface
