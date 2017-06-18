Understanding How Phalcon Applications Work
===========================================

如果你已经看过了 :doc:`tutorial <tutorial>` 或者已经通过 :doc:`Phalcon Devtools <tools>` 生成了代码，
你将很容易识别以下的启动文件：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Application;

    // 注册自动加载器
    // ...

    // 注册服务
    // ...

    // 处理请求
    $application = new Application($di);

    try {
        $response = $application->handle();

        $response->send();
    } catch (\Exception $e) {
        echo "Exception: ", $e->getMessage();
    }

控制器中全部核心的工作都会在handle()被回调时触发执行。

.. code-block:: php

    <?php

    $response = $application->handle();

手动启动（Manual bootstrapping）
--------------------------------
如果你不想使用 :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` ，以上的代码可以改成这样：

.. code-block:: php

    <?php

    // 获取 'router' 服务
    $router = $di["router"];

    $router->handle();

    $view = $di["view"];

    $dispatcher = $di["dispatcher"];

    // 传递路由的相关数据传递给调度器

    $dispatcher->setControllerName(
        $router->getControllerName()
    );

    $dispatcher->setActionName(
        $router->getActionName()
    );

    $dispatcher->setParams(
        $router->getParams()
    );

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

    $response = $di["response"];

    // 传递视图内容给响应对象
    $response->setContent(
        $view->getContent()
    );

    // Send the response
    $response->send();

以下代码替换了 :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` ，虽然缺少了视图组件，
但却更适合Rest风格的API接口：

.. code-block:: php

    <?php

    use Phalcon\Http\ResponseInterface;

    // 获取 'router' 服务
    $router = $di["router"];

    $router->handle();

    $dispatcher = $di["dispatcher"];

    // 传递路由的相关数据传递给调度器

    $dispatcher->setControllerName(
        $router->getControllerName()
    );

    $dispatcher->setActionName(
        $router->getActionName()
    );

    $dispatcher->setParams(
        $router->getParams()
    );

    // 请求调度
    $dispatcher->dispatch();

    // 获取最后的返回结果
    $response = $dispatcher->getReturnedValue();

    // 判断结果是否是 'response' 对象
    if ($response instanceof ResponseInterface) {
        // 发送响应
        $response->send();
    }

另外一个修改就是在分发器中对抛出异常的捕捉可以将请求转发到其他的操作：

.. code-block:: php

    <?php

    use Phalcon\Http\ResponseInterface;

    // 获取 'router' 服务
    $router = $di["router"];

    $router->handle();

    $dispatcher = $di["dispatcher"];

    // 传递路由的相关数据传递给调度器

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
        // 请求调度
        $dispatcher->dispatch();
    } catch (Exception $e) {
        // An exception has occurred, dispatch some controller/action aimed for that

        // Pass the processed router parameters to the dispatcher
        $dispatcher->setControllerName("errors");
        $dispatcher->setActionName("action503");

        // Dispatch the request
        $dispatcher->dispatch();
    }

    // 获取最后的返回结果
    $response = $dispatcher->getReturnedValue();

    // 判断结果是否是 'response' 对象
    if ($response instanceof ResponseInterface) {
        // 发送响应
        $response->send();
    }

尽管上面的代码比使用 :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` 而需要的代码远远要累赘得很，
但它为启动你的应用提供了一个可修改、可定制化的途径。
因为根据你的项目需要，你可以想对实例什么和不实例化什么进行完全的控制，或者想用你自己的组件来替代那些确定和必须的组件从而扩展默认的功能。
