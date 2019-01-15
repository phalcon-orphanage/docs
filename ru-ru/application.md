* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# MVC приложения

All the hard work behind orchestrating the operation of MVC in Phalcon is normally done by [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application). This component encapsulates all the complex operations required in the background, instantiating every component needed and integrating it with the project, to allow the MVC pattern to operate as desired.

The following bootstrap code is typical for a Phalcon application:

```php
<?php

use Phalcon\Mvc\Application;

// Регистрация автозагрузчиков
// ...

// Регистрация сервисов
// ...

// Обработка запроса
$application = new Application($di);

try {
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
```

The core of all the work of the controller occurs when `handle()` is invoked:

```php
<?php

$response = $application->handle();
```

<a name='manual-bootstrapping'></a>

## Ручная обработка

If you do not wish to use [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application), the code above can be changed as follows:

```php
<?php

// Получить сервис 'router'
$router = $di['router'];

$router->handle();

$view = $di['view'];

$dispatcher = $di['dispatcher'];

// Посылаем обработанные параметры маршрута в диспетчер

$dispatcher->setControllerName(
    $router->getControllerName()
);

$dispatcher->setActionName(
    $router->getActionName()
);

$dispatcher->setParams(
    $router->getParams()
);

// Запускаем отображение вид
$view->start();

// Доставляем запрос
$dispatcher->dispatch();

// Отображаем соответствующие виды
$view->render(
    $dispatcher->getControllerName(),
    $dispatcher->getActionName(),
    $dispatcher->getParams()
);

// Заканчиваем отображение вида
$view->finish();

$response = $di['response'];

// Передаем вывод из вида в ответ
$response->setContent(
    $view->getContent()
);

// Отсылаем ответ
$response->send();
```

The following replacement of [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application) lacks of a view component making it suitable for Rest APIs:

```php
<?php

use Phalcon\Http\ResponseInterface;

// Получение сервиса 'router'
$router = $di['router'];

$router->handle();

$dispatcher = $di['dispatcher'];

// Передача обработанных параметров маршрута в диспетчер

$dispatcher->setControllerName(
    $router->getControllerName()
);

$dispatcher->setActionName(
    $router->getActionName()
);

$dispatcher->setParams(
    $router->getParams()
);

// Доставка запроса
$dispatcher->dispatch();

// Получение значения, которое вернуло последнее выполненное действие
$response = $dispatcher->getReturnedValue();

// Проверка является ли возвращенное значение объектом 'response'
if ($response instanceof ResponseInterface) {
    // Send the response
    $response->send();
}
```

Yet another alternative that catch exceptions produced in the dispatcher forwarding to other actions consequently:

```php
<?php

use Phalcon\Http\ResponseInterface;

// Получение сервиса 'router'
$router = $di['router'];

$router->handle();

$dispatcher = $di['dispatcher'];

// Передача обработанных параметров маршрута диспетчеру

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
    // Доставка запроса
    $dispatcher->dispatch();
} catch (Exception $e) {
    // Произошло исключение, доставка контроллеру/методу предназначенному для этого

    // Передача обработанных параметров маршрута диспетчеру
    $dispatcher->setControllerName('errors');
    $dispatcher->setActionName('action503');

    // доставка запроса
    $dispatcher->dispatch();
}

// Получение возвращаемого значения из последнего выполненного действия
$response = $dispatcher->getReturnedValue();

// Проверка является ли возвращенное значение объектом 'response'
if ($response instanceof ResponseInterface) {
    // Send the response
    $response->send();
}
```

Although the above implementations are a lot more verbose than the code needed while using [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application), offers an alternative in bootstrapping your application. Depending on your needs, you might want to have full control of what should be instantiated or not, or replace certain components with those of your own to extend the default functionality.

<a name='single-vs-module'></a>

## Одномодульные и многомодульные приложения

With this component you can run various types of MVC structures:

<a name='single'></a>

### Одномодульное приложение

Single MVC applications consist of one module only. Namespaces can be used but are not necessary. An application like this would have the following file structure:

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

If namespaces are not used, the following bootstrap file could be used to orchestrate the MVC flow:

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

// Регистрация view компонента
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

If namespaces are used, the following bootstrap can be used:

```php
<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;

$loader = new Loader();

// Использование автозагрузчика с префиксами пространств имён
$loader->registerNamespaces(
    [
        'Single\Controllers' => '../apps/controllers/',
        'Single\Models'      => '../apps/models/',
    ]
);

$loader->register();

$di = new FactoryDefault();

// Регистрация пространства имён по умолчанию для контроллеров
$di->set(
    'dispatcher',
    function () {
        $dispatcher = new Dispatcher();

        $dispatcher->setDefaultNamespace('Single\Controllers');

        return $dispatcher;
    }
);

// Регистрация компонента представлений
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

### Многомодульное приложение

A multi-module application uses the same document root for more than one module. In this case the following file structure can be used:

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

Each directory in apps/ have its own MVC structure. A Module.php is present to configure specific settings of each module like autoloaders or custom services:

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
     * Регистрация специфичного автозагрузчика для модуля
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
     * Регистрация специфичных сервисов для модуля
     */
    public function registerServices(DiInterface $di)
    {
        // Registering a dispatcher
        $di->set(
            'dispatcher',
            function () {
                $dispatcher = new Dispatcher();

                $dispatcher->setDefaultNamespace('Multiple\Backend\Controllers');

                return $dispatcher;
            }
        );

        // Регистрация компонента представлений
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

A special bootstrap file is required to load a multi-module MVC architecture:

```php
<?php

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;

$di = new FactoryDefault();

// Указываем маршруты для модулей
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

// Создание приложения
$application = new Application($di);

// Регистрация установленных модулей
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
    // Обработка запроса
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo $e->getMessage();
}
```

If you want to maintain the module configuration in the bootstrap file you can use an anonymous function to register the module:

```php
<?php

use Phalcon\Mvc\View;

// Создание компонента представлений
$view = new View();

// Установка опций для компонента представлений
// ...

// Регистрация установленных модулей
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

When [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application) have modules registered, always is necessary that every matched route returns a valid module. Each registered module has an associated class offering functions to set the module itself up. Each module class definition must implement two methods: `registerAutoloaders()` and `registerServices()`, they will be called by [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application) according to the module to be executed.

<a name='events'></a>

## События приложения

[Phalcon\Mvc\Application](api/Phalcon_Mvc_Application) is able to send events to the [EventsManager](/4.0/en/events) (if it is present). Events are triggered using the type `application`. Поддерживаются следующие типы событий:

| Название события      | Срабатывает                                              |
| --------------------- | -------------------------------------------------------- |
| `boot`                | Выполняется, когда приложение обрабатывает первый запрос |
| `beforeStartModule`   | До инициализации зарегистрированного модуля              |
| `afterStartModule`    | После инициализации зарегистрированного модуля           |
| `beforeHandleRequest` | До выполнения цикла диспетчера                           |
| `afterHandleRequest`  | После выполнения цикла диспетчера                        |

В следующем примере показано, как назначить слушателей к компоненту:

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

## Дополнительная литература

* [Примеры MVC приложений на GitHub](https://github.com/phalcon/mvc)