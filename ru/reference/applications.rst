MVC Приложения
==============
Всю тяжелую работу при планировании работы MVC в Phalcon обычно выполняет :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`.
Этот компонент инкапсулирует все сложные задачи необходимые изнутри, создаёт компоненты и интегрирует их в проект
для реализации шаблона MVC по своему желанию.

Одно или Мульти - модульные приложения
--------------------------------------
С помощью этого компонета можно запускать разные типы MVC приложений.

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

    $loader = new \Phalcon\Loader();

    $loader->registerDirs(
        array(
            '../apps/controllers/',
            '../apps/models/'
        )
    )->register();

    $di = new \Phalcon\DI\FactoryDefault();

    // Регистрация компонента представлений
    $di->set('view', function() {
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../apps/views/');
        return $view;
    });

    try {
        $application = new \Phalcon\Mvc\Application();
        $application->setDI($di);
        echo $application->handle()->getContent();
    } catch(Phalcon\Exception $e) {
        echo $e->getMessage();
    }

Если же используются пространства имён, то файл может быть таким:

.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();

    // Использование автозагрузки по преффиксу пространства имён
    $loader->registerNamespaces(
        array(
            'Single\Controllers' => '../apps/controllers/',
            'Single\Models'      => '../apps/models/',
        )
    )->register();

    $di = new \Phalcon\DI\FactoryDefault();

    // Регистрация диспетчера пространства имён для контроллеров
    // Обратите внимание на двойной слеш в конце
    // параметра используемого в функции setDefaultNamespace
    $di->set('dispatcher', function() {
        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $dispatcher->setDefaultNamespace('Single\Controllers\\');
        return $dispatcher;
    });

    // Регистрация компонента представлений
    $di->set('view', function() {
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../apps/views/');
        return $view;
    });

    try {
        $application = new \Phalcon\Mvc\Application();
        $application->setDI($di);
        echo $application->handle()->getContent();
    } catch(Phalcon\Exception $e){
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

Каждый каталог в apps/ содержит собственную MVC структуру. Файл Module.php внутри каждого такого каталога сделан для настройки параметров
каждого модуля, таких как автозагрузка и настраиваемые сервисы.

.. code-block:: php

    <?php

    namespace Multiple\Backend;

    use Phalcon\Mvc\ModuleDefinitionInterface;

    class Module implements ModuleDefinitionInterface
    {

        /**
         * Регистрация автозагрузчика, специфичного для текущего модуля
         */
        public function registerAutoloaders()
        {

            $loader = new \Phalcon\Loader();

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
        public function registerServices($di)
        {

            // Регистрация диспетчера
            $di->set('dispatcher', function() {
                $dispatcher = new \Phalcon\Mvc\Dispatcher();
                $dispatcher->setDefaultNamespace("Multiple\Backend\Controllers\\");
                return $dispatcher;
            });

            // Регистрация компонента представлений
            $di->set('view', function() {
                $view = new \Phalcon\Mvc\View();
                $view->setViewsDir('../apps/backend/views/');
                return $view;
            });
        }

    }

Для загрузки мультимодульных MVC приложений можно использовать такой файл автозагрузки:

.. code-block:: php

    <?php

    $di = new \Phalcon\DI\FactoryDefault();

    // Специфичные роуты для модуля
    $di->set('router', function () {

        $router = new \Phalcon\Mvc\Router();

        $router->setDefaultModule("frontend");

        $router->add(
            "/login",
            array(
                'module'     => 'backend',
                'controller' => 'login',
                'action'     => 'index',
            )
        );

        $router->add(
            "/admin/products/:action",
            array(
                'module'     => 'backend',
                'controller' => 'products',
                'action'     => 1,
            )
        );

        $router->add(
            "/products/:action",
            array(
                'controller' => 'products',
                'action'     => 1,
            )
        );

        return $router;

    });

    try {

        // Создание приложения
        $application = new \Phalcon\Mvc\Application();
        $application->setDI($di);

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

    } catch(Phalcon\Exception $e){
        echo $e->getMessage();
    }

Если вы хотите разместить в файле загрузки модуль с конфигурацией, вы можете использовать анонимную функцию для его регистрации:

.. code-block:: php

    <?php

    // Создание компонента представлений
    $view = new \Phalcon\Mvc\View();

    // Регистрация установленых модулей
    $application->registerModules(
        array(
            'frontend' => function($di) use ($view) {
                $di->setShared('view', function() use ($view) {
                    $view->setViewsDir('../apps/frontend/views/');
                    return $view;
                });
            },
            'backend' => function($di) use ($view) {
                $di->setShared('view', function() use ($view) {
                    $view->setViewsDir('../apps/frontend/views/');
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

    try {

        // Register autoloaders
        //...

        // Register services
        //...

        // Handle the request
        $application = new \Phalcon\Mvc\Application();
        $application->setDI($di);
        echo $application->handle()->getContent();

    } catch (\Phalcon\Exception $e) {
        echo "PhalconException: ", $e->getMessage();
    }

Ядро выполняет основную работу по запуску контроллера, при вызыве handle():

.. code-block:: php

    <?php

    echo $application->handle()->getContent();

Если вы не хотите использовать :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`, код выше может можно изменить вот так:

.. code-block:: php

    <?php

    // Запускаем  сервис из контернейра сервисов
    $router = $di->get('router');
    $router->handle();

    $view = $di->getShared('view');

    $dispatcher = $di->get('dispatcher');

    // Передаём обработанные параметры моршрутизатора в диспетчер
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

    $response = $di->get('response');

    // Передаём результат для ответа
    $response->setContent($view->getContent());

    // Отправляем заголовки
    $response->sendHeaders();

    // Выводим ответ
    echo $response->getContent();

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
| beforeStartModule   | До инициализации зарегистрированного модуля                  |
+---------------------+--------------------------------------------------------------+
| afterStartModule    | После инициализации зарегистрированнного модуля              |
+---------------------+--------------------------------------------------------------+
| beforeHandleRequest | До выполнения цукла диспетчера                               |
+---------------------+--------------------------------------------------------------+
| afterHandleRequest  | После выполнения цикла диспетчера                            |
+---------------------+--------------------------------------------------------------+

В примере ниже показано как указать обработчика событий в компоненте:

.. code-block:: php

    <?php

    $eventsManager = new Phalcon\Events\Manager();

    $application->setEventsManager($eventsManager);

    $eventsManager->attach(
        "application",
        function($event, $application) {
            // ...
        }
    );

Внешние источники
-----------------

* `Примеры MVC Github <https://github.com/phalcon/mvc>`_
