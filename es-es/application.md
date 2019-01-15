* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Aplicaciones MVC

All the hard work behind orchestrating the operation of MVC in Phalcon is normally done by [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application). Este componente encapsula todas las operaciones complejas en el fondo, crear instancias de cada componente necesario e integrándolo con el proyecto para permitir que el patrón MVC funcione como se desee.

El siguiente código bootstrap es típico para una aplicación de Phalcon:

```php
<?php

use Phalcon\Mvc\Application;

// Registro de autoloaders
// ...

// Registro de servicios
// ...

// Gestionamos la consulta
$application = new Application($di);

try {
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
```

El núcleo de todo el trabajo del controlador se produce cuando se llama a `handle()`:

```php
<?php

$response = $application->handle();
```

<a name='manual-bootstrapping'></a>

## Arranque manual

If you do not wish to use [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application), the code above can be changed as follows:

```php
<?php

// Obtenemos el servicio router
$router = $di['router'];

$router->handle();

$view = $di['view'];

$dispatcher = $di['dispatcher'];

// Pasamos los parámetros procesados por el router al dispatcher

$dispatcher->setControllerName(
    $router->getControllerName()
);

$dispatcher->setActionName(
    $router->getActionName()
);

$dispatcher->setParams(
    $router->getParams()
);

// Iniciamos la vista
$view->start();

// Despachamos la consulta
$dispatcher->dispatch();

// Generamos las vistas relacionadas
$view->render(
    $dispatcher->getControllerName(),
    $dispatcher->getActionName(),
    $dispatcher->getParams()
);

// Finalizamos la vista
$view->finish();

$response = $di['response'];

// Pasamos el resultado de la vista al response
$response->setContent(
    $view->getContent()
);

// Enviamos al respuesta
$response->send();
```

The following replacement of [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application) lacks of a view component making it suitable for Rest APIs:

```php
<?php

use Phalcon\Http\ResponseInterface;

// Obtenemos el servicio 'router' 
$router = $di['router'];

$router->handle();

$dispatcher = $di['dispatcher'];

// Pasamos los parámetros procesados del router al dispatcher

$dispatcher->setControllerName(
    $router->getControllerName()
);

$dispatcher->setActionName(
    $router->getActionName()
);

$dispatcher->setParams(
    $router->getParams()
);

// Despachamos la consulta
$dispatcher->dispatch();

// Obtenemos el valor retornado en la última acción ejecutada
$response = $dispatcher->getReturnedValue();

// Chequeamos si la acción retorno un objeto 'response'
if ($response instanceof ResponseInterface) {
    // Enviamos la respuesta
    $response->send();
}
```

Otra alternativa es capturar excepciones producidas en el dispatcher y reenviarlas a otras acciones:

```php
<?php

use Phalcon\Http\ResponseInterface;

// Obtenemos el servicio 'router' 
$router = $di['router'];

$router->handle();

$dispatcher = $di['dispatcher'];

// Pasamos los parámetros procesados por el router al dispatcher

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
    // Despachamos la consulta
    $dispatcher->dispatch();
} catch (Exception $e) {
    // Ocurrió una excepción, despachar un controller/action 

    // Seteamos el controller y action para mostrar errores
    $dispatcher->setControllerName('errors');
    $dispatcher->setActionName('action503');

    // Despachamos la consulta
    $dispatcher->dispatch();
}

// Obtenemos el valor retornado del último action ejecutado
$response = $dispatcher->getReturnedValue();

// Chequeamos si retorno un objecto 'response'
if ($response instanceof ResponseInterface) {
    // Enviar respuesta
    $response->send();
}
```

Although the above implementations are a lot more verbose than the code needed while using [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application), offers an alternative in bootstrapping your application. Dependiendo de sus necesidades, puede tener el control total de lo que debe ser instanciado o no, o cambiar determinados componentes por unos propios para ampliar la funcionalidad predeterminada.

<a name='single-vs-module'></a>

## Aplicaciones simples o multi módulo

Con este componente se pueden ejecutar varios tipos de estructuras MVC:

<a name='single'></a>

### Módulo simple

Son aplicaciones MVC simples que solo consisten de un módulo. Los espacios de nombres se pueden utilizar pero no son necesarios. Una aplicación como esta tendría la siguiente estructura de archivos:

```php
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

Si no se usan espacios de nombres, podría utilizarse el siguiente archivo bootstrap para iniciar la aplicación MVC:

```php
<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;

$loader = new Loader();

$loader->registerDirs(
    [
        '../apps/controllers/',
        '../apps/models/',
    ]
);

$loader->register();

$di = new FactoryDefault();

// Registramos el componente 'view'
$di->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../apps/views/');

        return $view;
    }
);

$application = new Application($di);

try {
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo $e->getMessage();
}
```

Si se utilizan espacios de nombres, pueden utilizarse el siguiente bootstrap:

```php
<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;

$loader = new Loader();

// Usar autoloading con espacio de nombres
$loader->registerNamespaces(
    [
        'Single\Controllers' => '../apps/controllers/',
        'Single\Models'      => '../apps/models/',
    ]
);

$loader->register();

$di = new FactoryDefault();

// Registramos el namespace por defecto de los controllers
$di->set(
    'dispatcher',
    function () {
        $dispatcher = new Dispatcher();

        $dispatcher->setDefaultNamespace('Single\Controllers');

        return $dispatcher;
    }
);

// Registramos el componente 'view'
$di->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../apps/views/');

        return $view;
    }
);

$application = new Application($di);

try {
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo $e->getMessage();
}
```

<a name='module'></a>

### Multi módulos

Una aplicación de varios módulos utiliza la misma raíz del documento para más de un módulo. En este caso puede utilizarse la siguiente estructura de archivos:

```php
multiple/
  apps/
    frontend/
       controllers/
       models/
       views/
       Module.php
    backend/
       controllers/
       models/
       views/
       Module.php
  public/
    css/
    img/
    js/
```

Cada directorio en apps/ tienen su propia estructura MVC. Un archivo Module.php está presente para configurar las opciones específicas de cada módulo como cargadores o servicios personalizados:

```php
<?php

namespace Multiple\Backend;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    /**
     * Registrar autoloader específicos del módulo
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces(
            [
                'Multiple\Backend\Controllers' => '../apps/backend/controllers/',
                'Multiple\Backend\Models'      => '../apps/backend/models/',
            ]
        );

        $loader->register();
    }

    /**
     * Registrar servicios específicos del módulo
     */
    public function registerServices(DiInterface $di)
    {
        // Registramos un dispatcher
        $di->set(
            'dispatcher',
            function () {
                $dispatcher = new Dispatcher();

                $dispatcher->setDefaultNamespace('Multiple\Backend\Controllers');

                return $dispatcher;
            }
        );

        // Registramos un componente 'view'
        $di->set(
            'view',
            function () {
                $view = new View();

                $view->setViewsDir('../apps/backend/views/');

                return $view;
            }
        );
    }
}
```

Un archivo bootstrap especial es necesario para cargar toda la arquitectura MVC de varios módulos:

```php
<?php

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;

$di = new FactoryDefault();

// Especificar las rutas de los módulos
$di->set(
    'router',
    function () {
        $router = new Router();

        $router->setDefaultModule('frontend');

        $router->add(
            '/login',
            [
                'module'     => 'backend',
                'controller' => 'login',
                'action'     => 'index',
            ]
        );

        $router->add(
            '/admin/products/:action',
            [
                'module'     => 'backend',
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

// Crear una aplicación
$application = new Application($di);

// Registrar los módulos instalados
$application->registerModules(
    [
        'frontend' => [
            'className' => 'Multiple\Frontend\Module',
            'path'      => '../apps/frontend/Module.php',
        ],
        'backend'  => [
            'className' => 'Multiple\Backend\Module',
            'path'      => '../apps/backend/Module.php',
        ]
    ]
);

try {
    // Manejar la consulta
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo $e->getMessage();
}
```

Si desea mantener la configuración del módulo en el archivo bootstrap puede utilizar una funciones anónimas para registrar el módulo:

```php
<?php

use Phalcon\Mvc\View;

// Creamos el componente 'view'
$view = new View();

// Definimos las opciones del componente 'view'
// ...

// Registrar módulos instalados
$application->registerModules(
    [
        'frontend' => function ($di) use ($view) {
            $di->setShared(
                'view',
                function () use ($view) {
                    $view->setViewsDir('../apps/frontend/views/');

                    return $view;
                }
            );
        },
        'backend' => function ($di) use ($view) {
            $di->setShared(
                'view',
                function () use ($view) {
                    $view->setViewsDir('../apps/backend/views/');

                    return $view;
                }
            );
        }
    ]
);
```

When [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application) have modules registered, always is necessary that every matched route returns a valid module. Cada módulo registrado tiene asociada una clase con funciones para configurar el módulo en sí. Each module class definition must implement two methods: `registerAutoloaders()` and `registerServices()`, they will be called by [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application) according to the module to be executed.

<a name='events'></a>

## Eventos de la aplicación

[Phalcon\Mvc\Application](api/Phalcon_Mvc_Application) is able to send events to the [EventsManager](/4.0/en/events) (if it is present). Los eventos se desencadenan mediante el tipo `application`. Son soportados los siguientes eventos:

| Nombre de evento      | Disparado                                                                   |
| --------------------- | --------------------------------------------------------------------------- |
| `boot`                | Cuando la aplicación gestiona su primer solicitud                           |
| `beforeStartModule`   | Antes de inicializar un módulo, sólo cuando los módulos están registrados   |
| `afterStartModule`    | Después de inicializar un módulo, sólo cuando los módulos están registrados |
| `beforeHandleRequest` | Antes de ejecutar el bucle dispatch                                         |
| `afterHandleRequest`  | Después de ejecutar el bucle dispatch                                       |

En el ejemplo siguiente se muestra cómo adjuntar oyentes (listeners) a este componente:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

$eventsManager = new EventsManager();

$application->setEventsManager($eventsManager);

$eventsManager->attach(
    'application',
    function (Event $event, $application) {
        // ...
    }
);
```

<a name='resources'></a>

## Recursos externos

* [Ejemplos MVC en Github](https://github.com/phalcon/mvc)