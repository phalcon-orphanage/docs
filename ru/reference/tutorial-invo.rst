Урок 2: Introducing INVO
========================

Во втором уроке мы создадим более сложное приложение с помощью Phalcon. INVO это одно из приложений, которое мы создали в качестве примера. INVO это небольшой сайт, который позволяет своим пользователям создавать счета и выполнять другие задачи для управления своими клиентами и продуктами. Полный код проекта можно клонировать из Github_.

INVO использует `Bootstrap`_ в качестве фронтенд-фреймворка. Кроме того, приложение не будет генерировать счета, оно служит для понимая того, как работает фреймворк.

Структура проекта
-----------------
После того как вы склонируете проект в корневой каталог вы увидите следующую структуру:

.. code-block:: bash

    invo/
        app/
            config/
            controllers/
            library/
            forms/
            models/
            plugins/
            views/
        public/
            bootstrap/
            css/
            js/
        schemas/

Как вы уже знаете, Phalcon не навязывает определенную структуру файлов и каталогов для разработки приложений. Этот проект обеспечивает простую стуктуру MVC и корневой каталог public.

После того, как вы откроете приложение в браузере http://localhost/invo вы увидите что-то вроде этого:

.. figure:: ../_static/img/invo-1.png
   :align: center

Приложение состоит из двух частей, фронтенд - внешняя часть, где поситители могут получить информацию о INVO и запросить контактные данные. И бэкенд - административную панель, где зарегистрированный пользователь может управлять своими продуктами и клиентами.

Маршрутизация
-------------
INVO использует стандартный маршрутизатор основанный на встроенном компоненте Route. Эти маршруты соответствуют следующим шаблонам: /:controller/:action/:params. Первая часть URI является контроллером, вторая имя действия и остальные параметры.

Маршрут /session/register выполняет контроллер SessionController и его действие registerAction.

Конфигурация
------------
INVO имеет конфигурационный файл, который устанавливает общие параметры приложения. Этот файл загружается в самом начале
загрузочного файла (public/index.php):

.. code-block:: php

    <?php

    use Phalcon\Config\Adapter\Ini as ConfigIni;

    // ...

    // Read the configuration
    $config = new ConfigIni(APP_PATH . 'app/config/config.ini');

:doc:'Phalcon\\Config <config>' позволяет нам манипулировать файлами в объектно-ориентированного подхода. Файл конфигурации
содержит следующие настройки:

.. code-block:: ini

    [database]
    host     = localhost
    username = root
    password = secret
    name     = invo

    [application]
    controllersDir = app/controllers/
    modelsDir      = app/models/
    viewsDir       = app/views/
    pluginsDir     = app/plugins/
    formsDir       = app/forms/
    libraryDir     = app/library/
    baseUri        = /invo/

Phalcon не имеет каких-либо предопределенных соглашений о конфигурациях. Разделы помогут нам организовать необходимые параметры. В этом файле три секции, которые мы будем использовать позже.

Автозагрузчики
--------------
Второе, что видно в в загрузочном файле (public/index.php) это автозагрузчик.

.. code-block:: php

    <?php

    /**
     * Auto-loader configuration
     */
    require APP_PATH . 'app/config/loader.php';

Автозагрузчик регистрирует набор каталогов, где приложение будет искать необходимые классы.

.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();

    // We're a registering a set of directories taken from the configuration file
    $loader->registerDirs(
        array(
            APP_PATH . $config->application->controllersDir,
            APP_PATH . $config->application->pluginsDir,
            APP_PATH . $config->application->libraryDir,
            APP_PATH . $config->application->modelsDir,
            APP_PATH . $config->application->formsDir,
        )
    )->register();

Обратите внимание на регистрацию каталогов в файле конфигураций.
Единтсвенная директория которая не была зарегистрирована с помощью автозагрузчика это viewsDir, потому что она не содержит классов, только HTML + PHP файлы.
Also, note that we have using a constant called APP_PATH, this constant is defined in the bootstrap
(public/index.php) to allow us have a reference to the root of our project:

.. code-block:: php

    <?php

    // ...

    define('APP_PATH', realpath('..') . '/');

Registering services
--------------------
Another file that is required in the bootstrap is (app/config/services.php). This file allow
us to organize the services that INVO does use.

.. code-block:: php

    <?php

    /**
     * Load application services
     */
    require APP_PATH . 'app/config/services.php';

Service registration is achieved as in the previous tutorial, making use of a closure to lazily loads
the required components:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Url as UrlProvider;

    // ...

    /**
     * The URL component is used to generate all kind of URLs in the application
     */
    $di->set('url', function () use ($config) {
        $url = new UrlProvider();

        $url->setBaseUri($config->application->baseUri);

        return $url;
    });

We will discuss this file in depth later.

Обработка запроса
-----------------
Пойдем дальше, в конце файла, запрос окончательно обрабатывается с помощью Phalcon\\Mvc\\Application,
этот класс инициализирует и выполняет все что нужно для работы приложения:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Application;

    // ...

    $app = new Application($di);

    echo $app->handle()->getContent();

Инъекция зависимостей
---------------------
Посмотрите на первую строку кода на предыдущем блоке, переменная $app получает еще одну переменную $di в своем конструкторе.
Каков смысл этой переменной? Phalcon - слабо связанный фрэймворк, так что нам нужен компонент, который действует как клей, чтобы все работало вместе.
Этот компонент - Phalcon\\DI. Это контейнер, обеспечивающий все связи между частями необходимыми в приложении.

Есть много способов регистрации сервисов в контейнере. В INVO большинство услуг были зарегистрированы с использованием скрытых функций.  Благодаря этому, объекты создаются простейшим образом, уменьшеая ресурсы необходимые для приложения.

Например, в следующем фрагменте, регистрации сессии, анонимная функция будет вызвана только когда приложение требует доступа к данным сессии:

.. code-block:: php

    <?php

    use Phalcon\Session\Adapter\Files as Session;

    // ...

    // Начать сессию в первый раз, когда какой нибудь компонент запросит сервис сессий.
    $di->set('session', function () {
        $session = new Session();

        $session->start();

        return $session;
    });

Здесь мы можем менять адаптер, выполнить дополнительную инициализацию и многое другое. Обратите внимание, метод был зарегистрирован с помощью имени  "session". Это соглашение позволит фрэймворку идентифицировать активный метод в контейнере.

Запрос имеет множество методов, регистрация каждого метода может быть трудоемкой задачей. По этой причине,
фрэймворк обеспечивает вариант Phalcon\\DI вызывая Phalcon\\DI\\FactoryDefault задачей которого является регистрация
всех методов необходимых фрэймворку.

.. code-block:: php

    <?php

    use Phalcon\DI\FactoryDefault;

    // ...

    // FactoryDefault Обеспечивает автоматическую регистрацию
    // полного набора методов необходимых фреймворку
    $di = new FactoryDefault();

Он регистрирует большинство методов, предусмотренных фрэймворком как стандартные. Если нам надо переопределить
какой либо из методов, мы можем просто определить его снова, как мы делали выше с методом "session".
Это причина существования переменной $di.

In next chapter, we will see how to authentication and authorization is implemented in INVO.

.. _Github: https://github.com/phalcon/invo
.. _Bootstrap: http://getbootstrap.com/
