教程 2：INVO简介（Tutorial 2: Introducing INVO）
========================================================

在第二部分，我们将会说明一个完整的应用用来加深Phalcon的开发。
INVO是我们创建的一个程序样本。INVO是一个简单的用来允许用户生成发票的网站，并且可以做其他的任务，比如管理他们的客户或者产品。你可以从 Github_ 中复制它的代码。

同样，INVO使用 `Bootstrap`_ 做的前端框架。虽然这个应用不能生成发票，但是它仍然可以作为一个例子来理解框架是如何工作的。

项目结构（Project Structure）
-----------------------------
一旦你从你的文档根目录复制了这个项目，你将会看到以下结构：

.. code-block:: bash

    invo/
        app/
            config/
            controllers/
            forms/
            library/
            logs/
            models/
            plugins/
            views/
        cache/
            volt/
        docs/
        public/
            css/
            fonts/
            js/
        schemas/

正如你所知道的，Phalcon不会强求应用程序使用特定的文件结构。 这个项目提供了一个简单的MVC模型和公共文档根目录。

一旦你打开浏览器输入 http://localhost/invo 浏览应用程序你将会看到下面这样：

.. figure:: ../_static/img/invo-1.png
   :align: center

这个应用分为两部分，一部分是前端，这个是一个公开的部分，浏览者可以接收关于INVO的信息，也可以请求联系人信息。第二部分是后端，一个管理员区域，一个注册用户可以管理他/她的产品和客户。

路由（Routing）
---------------
INVO使用内置的标准路由。  :doc:`Router <routing>` 组件. 路由符合以下格式：/:controller/:action/:params. 这就意味着第一部分URI是控制器，第二部分是方法，剩余的是参数。

下面的路由 `/session/register` 执行的是 SessionController 控制器和它的 registerAction方法。

配置（Configuration）
---------------------
INVO has a configuration file that sets general parameters in the application. This file is located at
app/config/config.ini and it's loaded in the very first lines of the application bootstrap (public/index.php):

.. code-block:: php

    <?php

    use Phalcon\Config\Adapter\Ini as ConfigIni;

    // ...

    // Read the configuration
    $config = new ConfigIni(APP_PATH . 'app/config/config.ini');

:doc:`Phalcon\\Config <config>` allows us to manipulate the file in an object-oriented way.
In this example, we're using a ini file as configuration, however, there are more adapters supported
for configuration files. The configuration file contains the following settings:

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

Phalcon hasn't any pre-defined convention settings. Sections help us to organize the options as appropriate.
In this file there are two sections to be used later "application" and "database".

自动加载（Autoloaders）
-----------------------
The second part that appears in the bootstrap file (public/index.php) is the autoloader:

.. code-block:: php

    <?php

    /**
     * Auto-loader configuration
     */
    require APP_PATH . 'app/config/loader.php';

The autoloader registers a set of directories in which the application will look for
the classes that it eventually will need.

.. code-block:: php

    <?php

    $loader = new Phalcon\Loader();

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

Note that the above code has registered the directories that were defined in the configuration file. The only
directory that is not registered is the viewsDir, because it contains HTML + PHP files but no classes.
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

Handling the Request
--------------------
If we skip to the end of the file (public/index.php), the request is finally handled by :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`
which initializes and executes all that is necessary to make the application run:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Application;

    // ...

    $app = new Application($di);

    echo $app->handle()->getContent();

依赖注入（Dependency Injection）
--------------------------------
Look at the first line of the code block above, the Application class constructor is receiving the variable
:code:`$di` as an argument. What is the purpose of that variable? Phalcon is a highly decoupled framework,
so we need a component that acts as glue to make everything work together. That component is :doc:`Phalcon\\Di <../api/Phalcon_Di>`.
It is a service container that also performs dependency injection and service location,
instantiating all components as they are needed by the application.

There are many ways of registering services in the container. In INVO, most services have been registered using
anonymous functions/closures. Thanks to this, the objects are instantiated in a lazy way, reducing the resources needed
by the application.

For instance, in the following excerpt the session service is registered. The anonymous function will only be
called when the application requires access to the session data:

.. code-block:: php

    <?php

    use Phalcon\Session\Adapter\Files as Session;

    // ...

    // Start the session the first time a component requests the session service
    $di->set('session', function () {
        $session = new Session();

        $session->start();

        return $session;
    });

Here, we have the freedom to change the adapter, perform additional initialization and much more. Note that the service
was registered using the name "session". This is a convention that will allow the framework to identify the active
service in the services container.

A request can use many services and registering each service individually can be a cumbersome task. For that reason,
the framework provides a variant of :doc:`Phalcon\\Di <../api/Phalcon_Di>` called :doc:`Phalcon\\Di\\FactoryDefault <../api/Phalcon_Di_FactoryDefault>` whose task is to register
all services providing a full-stack framework.

.. code-block:: php

    <?php

    use Phalcon\Di\FactoryDefault;

    // ...

    // The FactoryDefault Dependency Injector automatically registers the
    // right services providing a full-stack framework
    $di = new FactoryDefault();

It registers the majority of services with components provided by the framework as standard. If we need to override
the definition of some service we could just set it again as we did above with "session" or "url".
This is the reason for the existence of the variable :code:`$di`.

In next chapter, we will see how to authentication and authorization is implemented in INVO.

.. _Github: https://github.com/phalcon/invo
.. _Bootstrap: http://getbootstrap.com/
