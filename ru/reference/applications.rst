MVC Приложения
==============

Всю тяжелую работу при планировании работы MVC в Phalcon обычно выполняет
:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`.
Этот компонент инкапсулирует все сложные задачи необходимые изнутри, создаёт компоненты и интегрирует их в проект
для реализации шаблона MVC по своему желанию.

Одномодульные и мультимодульные приложения
------------------------------------------
С помощью этого компонента можно запускать разные типы MVC приложений.

Одномодульные
^^^^^^^^^^^^^
Одномодульное MVC приложение состоит лишь из одного модуля. Можно использовать пространства имён, но необязательно.
Такое приложение может иметь такую структуру:

.. code-block:: php

    single/
        app/
            controllers/
            models/
            views/
        public/
            css/
            img/
            js/

Если не используется пространство имён, то в качестве файла загрузки MVC можно использовать:

.. code-block:: php

    <?php

    use Phalcon\Loader;
    use Phalcon\Mvc\View;
    use Phalcon\Mvc\Application;
    use Phalcon\Di\FactoryDefault;

    $loader = new Loader();

    $loader->registerDirs(
        array(
            '../apps/controllers/',
            '../apps/models/'
        )
    )->register();

    $di = new FactoryDefault();

    // Регистрация компонента представлений
    $di->set('view', function () {
        $view = new View();
        $view->setViewsDir('../apps/views/');
        return $view;
    });

    try {

        $application = new Application($di);

        echo $application->handle()->getContent();

    } catch (\Exception $e) {
        echo $e->getMessage();
    }

Если же используются пространства имён, то файл может быть таким:

.. code-block:: php

    <?php

    use Phalcon\Loader;
    use Phalcon\Mvc\View;
    use Phalcon\Mvc\Dispatcher;
    use Phalcon\Mvc\Application;
    use Phalcon\Di\FactoryDefault;

    $loader = new Loader();

    // Использование автозагрузки по префиксу пространства имён
    $loader->registerNamespaces(
        array(
            'Single\Controllers' => '../apps/controllers/',
            'Single\Models'      => '../apps/models/',
        )
    )->register();

    $di = new FactoryDefault();

    // Регистрация диспетчера c пространством имён для контроллеров
    $di->set('dispatcher', function () {
        $dispatcher = new Dispatcher();
        $dispatcher->setDefaultNamespace('Single\Controllers');
        return $dispatcher;
    });

    // Регистрация компонента представлений
    $di->set('view', function () {
        $view = new View();
        $view->setViewsDir('../apps/views/');
        return $view;
    });

    try {

        $application = new Application($di);

        echo $application->handle()->getContent();

    } catch (\Exception $e) {
        echo $e->getMessage();
    }

Мультимодульные
^^^^^^^^^^^^^^^
Мультимодульное приложение использует единый корень документов для нескольких модулей приложения. Файловая структура тогда может быть такой:

.. code-block:: php

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

Каждый каталог в apps/ содержит собственную MVC структуру. Файл Module.php внутри такого каталога создан для настройки параметров этого модуля,
таких как автозагрузка и настраиваемые сервисы.

.. code-block:: php

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
         * Регистрация автозагрузчика, специфичного для текущего модуля
         */
        public function registerAutoloaders()
        {
            $loader = new Loader();

            $loader->registerNamespaces(
                array(
                    'Multiple\Backend\Controllers' => '../apps/backend/controllers/',
                    'Multiple\Backend\Models'      => '../apps/backend/models/',
                )
            );

            $loader->register();
        }

        /**
         * Регистрация специфичных сервисов для модуля
         */
        public function registerServices(DiInterface $di)
        {
            // Регистрация диспетчера
            $di->set('dispatcher', function () {
                $dispatcher = new Dispatcher();
                $dispatcher->setDefaultNamespace("Multiple\Backend\Controllers");
                return $dispatcher;
            });

            // Регистрация компонента представлений
            $di->set('view', function () {
                $view = new View();
                $view->setViewsDir('../apps/backend/views/');
                return $view;
            });
        }
    }

Для загрузки мультимодульных MVC приложений можно использовать такой файл автозагрузки:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;
    use Phalcon\Mvc\Application;
    use Phalcon\Di\FactoryDefault;

    $di = new FactoryDefault();

    // Специфичные роуты для модуля
    // More information how to set the router up https://docs.phalconphp.com/ru/latest/reference/routing.html
    $di->set('router', function () {

        $router = new Router();

        $router->setDefaultModule("frontend");

        $router->add(
            "/login",
            array(
                'module'     => 'backend',
                'controller' => 'login',
                'action'     => 'index'
            )
        );

        $router->add(
            "/admin/products/:action",
            array(
                'module'     => 'backend',
                'controller' => 'products',
                'action'     => 1
            )
        );

        $router->add(
            "/products/:action",
            array(
                'controller' => 'products',
                'action'     => 1
            )
        );

        return $router;
    });

    try {

        // Создание приложения
        $application = new Application($di);

        // Регистрация установленных модулей
        $application->registerModules(
            array(
                'frontend' => array(
                    'className' => 'Multiple\Frontend\Module',
                    'path'      => '../apps/frontend/Module.php',
                ),
                'backend'  => array(
                    'className' => 'Multiple\Backend\Module',
                    'path'      => '../apps/backend/Module.php',
                )
            )
        );

        // Обработка запроса
        echo $application->handle()->getContent();

    } catch (\Exception $e) {
        echo $e->getMessage();
    }

Если вы хотите разместить в файле загрузки модуль с конфигурацией, вы можете использовать анонимную функцию для его регистрации:

.. code-block:: php

    <?php

    use Phalcon\Mvc\View;

    // Создание компонента представлений
    $view = new View();

    // Установка параметров компонента представлений
    // ...

    // Регистрация установленных модулей
    $application->registerModules(
        array(
            'frontend' => function ($di) use ($view) {
                $di->setShared('view', function () use ($view) {
                    $view->setViewsDir('../apps/frontend/views/');
                    return $view;
                });
            },
            'backend' => function ($di) use ($view) {
                $di->setShared('view', function () use ($view) {
                    $view->setViewsDir('../apps/backend/views/');
                    return $view;
                });
            }
        )
    );

Когда :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` зарегистрирует модули, всегда необходимо
чтобы каждая регистрация возвращала существующий модуль. Каждый зарегистрированный модуль должен иметь соответствующий класс
и функцию для настройки самого модуля. Каждый модуль должен обязательно содержать два методы: registerAutoloaders() и registerServices(),
они будут автоматически вызваны :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` при выполнении модуля.

Понятие поведения по умолчанию
------------------------------
Если вы смотрели :doc:`руководство <tutorial>` или сгенерировали код используя :doc:`Инструменты разработчика <tools>`,
вы можете узнать следующий код:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Application;

    try {

        // Регистрация автозагрузчика
        // ...

        // Регистрация сервисов
        // ...

        // Обработка запроса
        $application = new Application($di);

        echo $application->handle()->getContent();

    } catch (\Exception $e) {
        echo "Exception: ", $e->getMessage();
    }

Ядро выполняет основную работу по запуску контроллера, при вызове handle():

.. code-block:: php

    <?php

    echo $application->handle()->getContent();

Ручная начальная загрузка
-------------------------
Если вы не хотите использовать :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`, код выше можно изменить вот так:

.. code-block:: php

    <?php

    // Получаем  сервис из контейнера сервисов
    $router = $di['router'];

    $router->handle();

    $view = $di['view'];

    $dispatcher = $di['dispatcher'];

    // Передаём обработанные параметры маршрутизатора в диспетчер
    $dispatcher->setControllerName($router->getControllerName());
    $dispatcher->setActionName($router->getActionName());
    $dispatcher->setParams($router->getParams());

    // Запускаем представление
    $view->start();

    // Выполняем запрос
    $dispatcher->dispatch();

    // Выводим необходимое представление
    $view->render(
        $dispatcher->getControllerName(),
        $dispatcher->getActionName(),
        $dispatcher->getParams()
    );

    // Завершаем работу представления
    $view->finish();

    $response = $di['response'];

    // Передаём результат для ответа
    $response->setContent($view->getContent());

    // Отправляем заголовки
    $response->sendHeaders();

    // Выводим ответ
    echo $response->getContent();

The following replacement of :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` lacks of a view component making it suitable for Rest APIs:

.. code-block:: php

    <?php

    // Get the 'router' service
    $router = $di['router'];

    $router->handle();

    $dispatcher = $di['dispatcher'];

    // Pass the processed router parameters to the dispatcher
    $dispatcher->setControllerName($router->getControllerName());
    $dispatcher->setActionName($router->getActionName());
    $dispatcher->setParams($router->getParams());

    // Dispatch the request
    $dispatcher->dispatch();

    // Get the returned value by the last executed action
    $response = $dispatcher->getReturnedValue();

    // Check if the action returned is a 'response' object
    if ($response instanceof Phalcon\Http\ResponseInterface) {

        // Send the response
        $response->send();
    }

Yet another alternative that catch exceptions produced in the dispatcher forwarding to other actions consequently:

.. code-block:: php

    <?php

    // Get the 'router' service
    $router = $di['router'];

    $router->handle();

    $dispatcher = $di['dispatcher'];

    // Pass the processed router parameters to the dispatcher
    $dispatcher->setControllerName($router->getControllerName());
    $dispatcher->setActionName($router->getActionName());
    $dispatcher->setParams($router->getParams());

    try {

        // Dispatch the request
        $dispatcher->dispatch();

    } catch (Exception $e) {

        // An exception has occurred, dispatch some controller/action aimed for that

        // Pass the processed router parameters to the dispatcher
        $dispatcher->setControllerName('errors');
        $dispatcher->setActionName('action503');

        // Dispatch the request
        $dispatcher->dispatch();
    }

    // Get the returned value by the last executed action
    $response = $dispatcher->getReturnedValue();

    // Check if the action returned is a 'response' object
    if ($response instanceof Phalcon\Http\ResponseInterface) {

        // Send the response
        $response->send();
    }

Несмотря на то, что этот код более многословен чем код при использовании :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`,
он предоставляет альтернативу для запуска вашего приложения. В зависимости от своих потребностей, вы, возможно, захотите иметь полный контроль
того будет ли создан ответ или нет, или захотите заменить определённые компоненты на свои, либо расширить их функциональность.

События приложения
------------------
:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` может вызывать события :doc:`EventsManager <events>`
(если они присутствуют). События запускаются с помощью типа "application". Поддерживаются следующие события:

+---------------------+--------------------------------------------------------------+
| Название события    | Выполняется при                                              |
+=====================+==============================================================+
| boot                | Executed when the application handles its first request      |
+---------------------+--------------------------------------------------------------+
| beforeStartModule   | До инициализации зарегистрированного модуля                  |
+---------------------+--------------------------------------------------------------+
| afterStartModule    | После инициализации зарегистрированного модуля               |
+---------------------+--------------------------------------------------------------+
| beforeHandleRequest | До выполнения цикла диспетчера                               |
+---------------------+--------------------------------------------------------------+
| afterHandleRequest  | После выполнения цикла диспетчера                            |
+---------------------+--------------------------------------------------------------+

В примере ниже показано, как указать обработчика событий в компоненте:

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager;

    $eventsManager = new EventsManager();

    $application->setEventsManager($eventsManager);

    $eventsManager->attach(
        "application",
        function ($event, $application) {
            // ...
        }
    );

Внешние источники
-----------------
* `Примеры MVC Github <https://github.com/phalcon/mvc>`_
