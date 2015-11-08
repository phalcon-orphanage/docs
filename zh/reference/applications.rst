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
        array(
            '../apps/controllers/',
            '../apps/models/'
        )
    )->register();

    $di = new FactoryDefault();

    // 注册视图组件
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
        array(
            'Single\Controllers' => '../apps/controllers/',
            'Single\Models'      => '../apps/models/',
        )
    )->register();

    $di = new FactoryDefault();

    // 注册调度器，并设置控制器的默认命名空间
    $di->set('dispatcher', function () {
        $dispatcher = new Dispatcher();
        $dispatcher->setDefaultNamespace('Single\Controllers');
        return $dispatcher;
    });

    // 注册视图组件
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
         * 注册自定义服务
         */
        public function registerServices(DiInterface $di)
        {
            // Registering a dispatcher
            $di->set('dispatcher', function () {
                $dispatcher = new Dispatcher();
                $dispatcher->setDefaultNamespace("Multiple\Backend\Controllers");
                return $dispatcher;
            });

            // Registering the view component
            $di->set('view', function () {
                $view = new View();
                $view->setViewsDir('../apps/backend/views/');
                return $view;
            });
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

        // 创建应用
        $application = new Application($di);

        // 注册模块
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

        // 处理请求
        echo $application->handle()->getContent();

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

当 :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` 有多个模块注册时，通常
每个都是需要的，以便每一个被匹配到的路由都能返回一个有效的模块。每个已经注册的模块都有一个相关的类来提供建立和启动自身的函数。
而每个模块定义的类都必须实现registerAutoloaders()和registerServices()这两个方法，这两个函数会在模块即被执行时被
:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` 调用。

理解默认行为（Understanding the default behavior）
--------------------------------------------------
如果你已经看过了 :doc:`tutorial <tutorial>` 或者已经通过 :doc:`Phalcon Devtools <tools>` 生成了代码，
你将很容易识别以下的启动文件：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Application;

    try {

        // 注册自动加载器
        // ...

        // 注册服务
        // ...

        // 处理请求
        $application = new Application($di);

        echo $application->handle()->getContent();

    } catch (\Exception $e) {
        echo "Exception: ", $e->getMessage();
    }

控制器中全部核心的工作都会在handle()被回调时触发执行。

.. code-block:: php

    <?php

    echo $application->handle()->getContent();

手动启动（Manual bootstrapping）
--------------------------------
如果你不想使用 :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` ，以上的代码可以改成这样：

.. code-block:: php

    <?php

    // 获取 'router' 服务
    $router = $di['router'];

    $router->handle();

    $view = $di['view'];

    $dispatcher = $di['dispatcher'];

    // 传递路由的相关数据传递给调度器
    $dispatcher->setControllerName($router->getControllerName());
    $dispatcher->setActionName($router->getActionName());
    $dispatcher->setParams($router->getParams());

    // 启动视图
    $view->start();

    // 请求调度
    $dispatcher->dispatch();

    // 渲染相关视图
    $view->render(
        $dispatcher->getControllerName(),
        $dispatcher->getActionName(),
        $dispatcher->getParams()
    );

    // 完成视图
    $view->finish();

    $response = $di['response'];

    // 传递视图内容给响应对象
    $response->setContent($view->getContent());

    // 发送头信息
    $response->sendHeaders();

    // 输出响应内容
    echo $response->getContent();

以下代码替换了 :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` ，虽然缺少了视图组件，
但却更适合Rest风格的API接口：

.. code-block:: php

    <?php

    // 获取 'router' 服务
    $router = $di['router'];

    $router->handle();

    $dispatcher = $di['dispatcher'];

    // 传递路由的相关数据传递给调度器
    $dispatcher->setControllerName($router->getControllerName());
    $dispatcher->setActionName($router->getActionName());
    $dispatcher->setParams($router->getParams());

    // 请求调度
    $dispatcher->dispatch();

    // 获取最后的返回结果
    $response = $dispatcher->getReturnedValue();

    // 判断结果是否是 'response' 对象
    if ($response instanceof Phalcon\Http\ResponseInterface) {

        // 发送响应
        $response->send();
    }

另外一个修改就是在分发器中对抛出异常的捕捉可以将请求转发到其他的操作：

.. code-block:: php

    <?php

    // 获取 'router' 服务
    $router = $di['router'];

    $router->handle();

    $dispatcher = $di['dispatcher'];

    // 传递路由的相关数据传递给调度器
    $dispatcher->setControllerName($router->getControllerName());
    $dispatcher->setActionName($router->getActionName());
    $dispatcher->setParams($router->getParams());

    try {

        // 请求调度
        $dispatcher->dispatch();

    } catch (Exception $e) {

        // An exception has occurred, dispatch some controller/action aimed for that

        // Pass the processed router parameters to the dispatcher
        $dispatcher->setControllerName('errors');
        $dispatcher->setActionName('action503');

        // Dispatch the request
        $dispatcher->dispatch();
    }

    // 获取最后的返回结果
    $response = $dispatcher->getReturnedValue();

    // 判断结果是否是 'response' 对象
    if ($response instanceof Phalcon\Http\ResponseInterface) {

        // 发送响应
        $response->send();
    }

尽管上面的代码比使用 :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` 而需要的代码远远要累赘得很，
但它为启动你的应用提供了一个可修改、可定制化的途径。
因为根据你的项目需要，你可以想对实例什么和不实例化什么进行完全的控制，或者想用你自己的组件来替代那些确定和必须的组件从而扩展默认的功能。

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

    use Phalcon\Events\Manager as EventsManager;

    $eventsManager = new EventsManager();

    $application->setEventsManager($eventsManager);

    $eventsManager->attach(
        "application",
        function ($event, $application) {
            // ...
        }
    );

外部资源（External Resources）
------------------------------
* `Github上的MVC示例 <https://github.com/phalcon/mvc>`_
