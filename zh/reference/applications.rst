MVC 应用（MVC Applications）
============================

在Phalcon，策划MVC操作背后的全部困难工作通常都可以
通过 :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` 做到。这个组件封装了全部后端所需要的复杂
操作，实例化每一个需要用到的组件并与项目整合在一起，从而使得MVC模式可以如期地运行。

单模块或多模块应用（Single or Multi Module Applications）
---------------------------------------------------------
通过这个组件，你可以运行各式各样的MVC结构：

单模块（Single Module）
^^^^^^^^^^^^^^^^^^^^^^^
单一的MVC应用仅仅包含了一个模块。可以使用命名空间，但不是必需的。
这样类型的应用可能会有以下文件目录结构：

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

如果未使用命名空间，以下的启动文件可用于编排MVC工作流：

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

    // 注册视图组件
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

如果使用了命名空间，则可以使用以下启动文件（译者注：主要区别在于使用$loader的方式）：

.. code-block:: php

    <?php

    use Phalcon\Loader;
    use Phalcon\Mvc\View;
    use Phalcon\Mvc\Dispatcher;
    use Phalcon\Mvc\Application;
    use Phalcon\Di\FactoryDefault;

    $loader = new Loader();

    // 根据命名空间前缀加载
    $loader->registerNamespaces(
        [
            "Single\\Controllers" => "../apps/controllers/",
            "Single\\Models"      => "../apps/models/",
        ]
    );

    $loader->register();

    $di = new FactoryDefault();

    // 注册调度器，并设置控制器的默认命名空间
    $di->set(
        "dispatcher",
        function () {
            $dispatcher = new Dispatcher();

            $dispatcher->setDefaultNamespace("Single\\Controllers");

            return $dispatcher;
        }
    );

    // 注册视图组件
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

多模块（Multi Module）
^^^^^^^^^^^^^^^^^^^^^^
多模块的应用使用了相同的文档根目录但拥有多个模块。在这种情况下，可以使用以下的文件目录结构：

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

在apps/下的每一个目录都有自己的MVC结构。Module.php文件代表了各个模块不同的配置，如自动加载器和自定义服务：

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
         * 注册自定义加载器
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
         * 注册自定义服务
         */
        public function registerServices(DiInterface $di)
        {
            // Registering a dispatcher
            $di->set(
                "dispatcher",
                function () {
                    $dispatcher = new Dispatcher();

                    $dispatcher->setDefaultNamespace("Multiple\\Backend\\Controllers");

                    return $dispatcher;
                }
            );

            // Registering the view component
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

还需要一个指定的启动文件来加载多模块的MVC架构：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;
    use Phalcon\Mvc\Application;
    use Phalcon\Di\FactoryDefault;

    $di = new FactoryDefault();

    // 自定义路由
    // More information how to set the router up https://docs.phalconphp.com/zh/latest/reference/routing.html
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

    // 创建应用
    $application = new Application($di);

    // 注册模块
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

        // 处理请求
        $response = $application->handle();

        $response->send();
    } catch (\Exception $e) {
        echo $e->getMessage();
    }

如果你想在启动文件保持模块的配置，你可以使用匿名函数来注册对应的模块：

.. code-block:: php

    <?php

    use Phalcon\Mvc\View;

    // 创建视图组件
    $view = new View();

    // 设置视图组件相关选项
    // ...

    // Register the installed modules
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

当 :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` 有多个模块注册时，通常
每个都是需要的，以便每一个被匹配到的路由都能返回一个有效的模块。每个已经注册的模块都有一个相关的类来提供建立和启动自身的函数。
而每个模块定义的类都必须实现registerAutoloaders()和registerServices()这两个方法，这两个函数会在模块即被执行时被
:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` 调用。

应用事件（Application Events）
------------------------------
:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` 可以把事件发送到 :doc:`EventsManager <events>` （如果它激活的话）。
事件将被当作"application"类型被消费掉。目前已支持的事件如下：

+---------------------+--------------------------------------------------------------+
| 事件名称            | 消费于                                                       |
+=====================+==============================================================+
| boot                | 当应用处理它首个请求时被执行                                 |
+---------------------+--------------------------------------------------------------+
| beforeStartModule   | 在初始化模块之前，仅当模块被注册时                           |
+---------------------+--------------------------------------------------------------+
| afterStartModule    | 在初始化模块之后，仅当模块被注册时                           |
+---------------------+--------------------------------------------------------------+
| beforeHandleRequest | 在执行分发环前                                               |
+---------------------+--------------------------------------------------------------+
| afterHandleRequest  | 在执行分发环后                                               |
+---------------------+--------------------------------------------------------------+

以下示例演示了如何将侦听器绑定到组件：

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

外部资源（External Resources）
------------------------------
* `Github上的MVC示例 <https://github.com/phalcon/mvc>`_
