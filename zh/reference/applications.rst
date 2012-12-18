MVC Applications
================
在 Phalcon 中，所有复杂的MVC相关工作都是由 :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` 来完成的。该组件封装了所有复杂的后台操作，包括每一个组件的实例化，组件之间的集成等。

Single or Multi Module Applications
-----------------------------------
使用此组件，您可以运行不同类型的MVC结构：

Single Module
^^^^^^^^^^^^^
单MVC应用程序只包含一个module，可以使用命名空间，但不是必需的。这样的应用程序的文件结构如下：

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

如果不使用命名空间，引导文件被用来协调MVC流程：

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

    // Registering the view component
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

如果使用命名空间，引导文件可以这样做：

.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();

    // Use autoloading with namespaces prefixes
    $loader->registerNamespaces(
        array(
            'Single\Controllers' => '../apps/controllers/',
            'Single\Models'      => '../apps/models/',
        )
    )->register();

    $di = new \Phalcon\DI\FactoryDefault();

    // Register the dispatcher setting a Namespace for controllers
    // Pay special attention to the double slashes at the end of the
    // parameter used in the setDefaultNamespace function
    $di->set('dispatcher', function() {
        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $dispatcher->setDefaultNamespace('Single\Controllers\\');
        return $dispatcher;
    });

    // Registering the view component
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


Multi Module
^^^^^^^^^^^^
一个multi-module(多模块)的应用程序是指使用相同的Document Root，但有超过一个module。在这种情况下，程序的文件结构如下：

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

在 apps/ 目录下的每个目录都有自己的MVC结构，Module.php是每个Module特定的设置：

.. code-block:: php

    <?php

    namespace Multiple\Backend;

    use Phalcon\Mvc\ModuleDefinitionInterface;

    class Module implements ModuleDefinitionInterface
    {

        /**
         * Register a specific autoloader for the module
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
         * Register specific services for the module
         */
        public function registerServices($di)
        {

            //Registering a dispatcher
            $di->set('dispatcher', function() {
                $dispatcher = new \Phalcon\Mvc\Dispatcher();
                $dispatcher->setDefaultNamespace("Multiple\Backend\Controllers\\");
                return $dispatcher;
            });

            //Registering the view component
            $di->set('view', function() {
                $view = new \Phalcon\Mvc\View();
                $view->setViewsDir('../apps/backend/views/');
                return $view;
            });
        }

    }

一个特殊的引导文件，用以载入 multi-module MVC 结构：

.. code-block:: php

    <?php

    $di = new \Phalcon\DI\FactoryDefault();

    //Specify routes for modules
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

        //Create an application
        $application = new \Phalcon\Mvc\Application();
        $application->setDI($di);

        // Register the installed modules
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

        //Handle the request
        echo $application->handle()->getContent();

    } catch(Phalcon\Exception $e){
        echo $e->getMessage();
    }

如果你想把配置文件完全写入到引导文件，你可以使用一个匿名函数的方式来注册 Module :

.. code-block:: php

    <?php

    //Creating a view component
    $view = new \Phalcon\Mvc\View();

    // Register the installed modules
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

当 :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` Module注册后，每个匹配的route都必须返回一个有效的module。注册的module都有一个相关的类，用于设置module本身提供的功能。每个module类都必须实现 registerAutoloaders() 和 registerServices() 这两个方法，:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` 将调用它们执行要执行的module。

了解默认行为
----------------------------------
如果你一直关注  :doc:`tutorial <tutorial>` 或 使用 :doc:`Phalcon Devtools <tools>` 生成过代码，你可能会熟悉以下的引导文件：

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

所有控制器工作的核心是 handle()方法被调用：

.. code-block:: php

    <?php

    echo $application->handle()->getContent();

如果您不希望使用 :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` ，上面的代码可以修改如下：

.. code-block:: php

    <?php

    // Request the services from the services container
    $router = $di->get('router');
    $router->handle();

    $view = $di->getShared('view');

    $dispatcher = $di->get('dispatcher');

    // Pass the proccessed router parameters to the dispatcher
    $dispatcher->setControllerName($router->getControllerName());
    $dispatcher->setActionName($router->getActionName());
    $dispatcher->setParams($router->getParams());

    // Start the view
    $view->start();

    // Dispatch the request
    $dispatcher->dispatch();

    // Render the related views
    $view->render(
        $dispatcher->getControllerName(),
        $dispatcher->getActionName(),
        $dispatcher->getParams()
    );

    // Finish the view
    $view->finish();

    $response = $di->get('response');

    // Pass the output of the view to the response
    $response->setContent($view->getContent());

    // Send the request headers
    $response->sendHeaders();

    // Print the response
    echo $response->getContent();

尽管上面的代码显得比使用 :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` 罗唆，但它提供了一种替代bootstrap文件的方式。根据你的需要，你可能希望完全掌握哪些类应该被实例化，或使用自己的组件来扩展默认的功能。

Application Events
------------------
:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` 能够将事件发送到 :doc:`EventsManager <events>`，事件管理器通过触发 "application"来实现，支持以下的事件：

+---------------------+--------------------------------------------------------------+
| Event Name          | Triggered                                                    |
+=====================+==============================================================+
| beforeStartModule   | Before initialize a module, only when modules are registered |
+---------------------+--------------------------------------------------------------+
| afterStartModule    | After initialize a module, only when modules are registered  |
+---------------------+--------------------------------------------------------------+
| beforeHandleRequest | Before execute the dispatch loop                             |
+---------------------+--------------------------------------------------------------+
| afterHandleRequest  | After execute the dispatch loop                              |
+---------------------+--------------------------------------------------------------+

下面的示例演示如何在此组件上添加监听器：

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

相关资源
------------------

* `MVC examples on Github <https://github.com/phalcon/mvc>`_
