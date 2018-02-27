<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">MVC приложения</a> <ul>
        <li>
          <a href="#manual-bootstrapping">Ручная обработка</a>
        </li>
        <li>
          <a href="#single-vs-module">Одномодульные и многомодульные приложения</a> 
          <ul>
            <li>
              <a href="#single">Одномодульное приложение</a>
            </li>
            <li>
              <a href="#module">Многомодульное приложение</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#events">События приложения</a>
        </li>
        <li>
          <a href="#resources">Дополнительная литература</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# MVC приложения

Вся сложная работа по дирижированию работой MVC в Phalcon обычно выполняется с помощью `Phalcon\Mvc\Application`. Этот компонент инкапсулирует все сложные операции, требуемые в фоновом режиме, отвечает за создание каждого необходимого компонента и интеграцию его с проектом, позволяя паттерну MVC работать как положено.

Следующий код начальной загрузки является типичным для Phalcon приложения:

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

Основная работа контроллера происходит при вызове метода `handle()`:

```php
<?php

$response = $application->handle();
```

<a name='manual-bootstrapping'></a>

## Ручная обработка

Если вы не желаете использовать `Phalcon\Mvc\Application`, код выше должен быть изменен следующим образом:

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

Следующая доработка компонента view в `Phalcon\Mvc\Application`, делает его пригодным для Rest APIs:

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

Еще один вариант, который перехватывает исключения произведенные в диспетчере, пересылаемые в другие действия последовательно:

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

Хотя реализация выше является более подробной, чем код необходимый при использовании `Phalcon\Mvc\Application`, она предлагает альтернативу начальной загрузки вашего приложения. В зависимости от ваших нужд, вы можете захотеть иметь полный контроль над тем, что должно быть создано или нет, или заменить определенные компоненты своими для расширения функциональности по умолчанию.

<a name='single-vs-module'></a>

## Одномодульные и многомодульные приложения

С помощью этого компонента можно запускать разные типы MVC приложений:

<a name='single'></a>

### Одномодульное приложение

Одномодульное MVC приложение состоит лишь из одного модуля. Пространства имён могут быть использованы, но не являются обязательными. Такое приложение может иметь следующую структуру:

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

Если не используется пространство имён, то в качестве файла загрузки MVC можно использовать следующий подход:

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

Если же используются пространства имён, то инициализация приложения может быть реализована следующим образом:

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

Многомодульное приложение использует единый корень документов для нескольких модулей приложения. Файловая структура тогда может быть такой:

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

Каждый каталог в apps/ содержит собственную MVC структуру. Файл Module.php внутри такого каталога создан для настройки параметров этого модуля, таких как автозагрузка и настраиваемые сервисы:

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

Для загрузки многомодульных MVC приложений можно использовать такой файл автозагрузки:

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

Если вы желаете хранить конфигурацию модуля в загрузочном файле, можно использовать анонимную функцию для регистрации модуля:

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

Когда `Phalcon\Mvc\Application` зарегистрирует модули, каждый сопоставленный маршрут должен возвращать существующий модуль. Каждый зарегистрированный модуль должен иметь соответствующий класс и функцию для настройки самого модуля. Каждое определение класса модуля обязательно должно реализовать два метода: `registerAutoloaders()` и `registerServices()`, они будут автоматически вызваны `Phalcon\Mvc\Application` при выполнении модуля.

<a name='events'></a>

## События приложения

`Phalcon\Mvc\Application` может отправлять события в [EventsManager](/[[language]]/[[version]]/events) (если он присутствует). События вызываются с типом `application`. Поддерживаются следующие события:

| Название события      | Вызывается                                               |
| --------------------- | -------------------------------------------------------- |
| `boot`                | Выполняется, когда приложение обрабатывает первый запрос |
| `beforeStartModule`   | До инициализации зарегистрированного модуля              |
| `afterStartModule`    | После инициализации зарегистрированного модуля           |
| `beforeHandleRequest` | До выполнения цикла диспетчера                           |
| `afterHandleRequest`  | После выполнения цикла диспетчера                        |

Следующий пример демонстрирует, как прикрепить слушателей к этому компоненту:

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