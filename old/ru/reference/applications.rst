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
        [
            "../apps/controllers/",
            "../apps/models/",
        ]
    );

    $loader->register();

    $di = new FactoryDefault();

    // Регистрация компонента представлений
    $di->set(
        "view",
        function () {
            $view = new View();

            $view->setViewsDir("../apps/views/");

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
        [
            "Single\\Controllers" => "../apps/controllers/",
            "Single\\Models"      => "../apps/models/",
        ]
    );

    $loader->register();

    $di = new FactoryDefault();

    // Регистрация диспетчера c пространством имён для контроллеров
    $di->set(
        "dispatcher",
        function () {
            $dispatcher = new Dispatcher();

            $dispatcher->setDefaultNamespace("Single\\Controllers");

            return $dispatcher;
        }
    );

    // Регистрация компонента представлений
    $di->set(
        "view",
        function () {
            $view = new View();

            $view->setViewsDir("../apps/views/");

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
        public function registerAutoloaders(DiInterface $di = null)
        {
            $loader = new Loader();

            $loader->registerNamespaces(
                [
                    "Multiple\\Backend\\Controllers" => "../apps/backend/controllers/",
                    "Multiple\\Backend\\Models"      => "../apps/backend/models/",
                ]
            );

            $loader->register();
        }

        /**
         * Регистрация специфичных сервисов для модуля
         */
        public function registerServices(DiInterface $di)
        {
            // Регистрация диспетчера
            $di->set(
                "dispatcher",
                function () {
                    $dispatcher = new Dispatcher();

                    $dispatcher->setDefaultNamespace("Multiple\\Backend\\Controllers");

                    return $dispatcher;
                }
            );

            // Регистрация компонента представлений
            $di->set(
                "view",
                function () {
                    $view = new View();

                    $view->setViewsDir("../apps/backend/views/");

                    return $view;
                }
            );
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
    $di->set(
        "router",
        function () {
            $router = new Router();

            $router->setDefaultModule("frontend");

            $router->add(
                "/login",
                [
                    "module"     => "backend",
                    "controller" => "login",
                    "action"     => "index",
                ]
            );

            $router->add(
                "/admin/products/:action",
                [
                    "module"     => "backend",
                    "controller" => "products",
                    "action"     => 1,
                ]
            );

            $router->add(
                "/products/:action",
                [
                    "controller" => "products",
                    "action"     => 1,
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
            "frontend" => [
                "className" => "Multiple\\Frontend\\Module",
                "path"      => "../apps/frontend/Module.php",
            ],
            "backend"  => [
                "className" => "Multiple\\Backend\\Module",
                "path"      => "../apps/backend/Module.php",
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
        [
            "frontend" => function ($di) use ($view) {
                $di->setShared(
                    "view",
                    function () use ($view) {
                        $view->setViewsDir("../apps/frontend/views/");

                        return $view;
                    }
                );
            },
            "backend" => function ($di) use ($view) {
                $di->setShared(
                    "view",
                    function () use ($view) {
                        $view->setViewsDir("../apps/backend/views/");

                        return $view;
                    }
                );
            }
        ]
    );

Когда :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` зарегистрирует модули, всегда необходимо
чтобы каждая регистрация возвращала существующий модуль. Каждый зарегистрированный модуль должен иметь соответствующий класс
и функцию для настройки самого модуля. Каждый модуль должен обязательно содержать два методы: registerAutoloaders() и registerServices(),
они будут автоматически вызваны :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` при выполнении модуля.

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

    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    $eventsManager = new EventsManager();

    $application->setEventsManager($eventsManager);

    $eventsManager->attach(
        "application",
        function (Event $event, $application) {
            // ...
        }
    );

Внешние источники
-----------------
* `Примеры MVC Github <https://github.com/phalcon/mvc>`_
