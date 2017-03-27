调度控制器（Dispatching Controllers）
=====================================

:doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>` 是MVC应用中负责实例化
控制器和执行在这些控制器上必要动作的组件。理解它的操作和能力将能帮助我们获得更多Phalcon框架提供的服务。

循环调度（The Dispatch Loop）
-----------------------------
在MVC流中，这是一个重要的处理环节，特别对于控制器这部分。这些处理
发生在控制调度器中。控制器的文件将会被依次读取、加载和实例化。然后指定的action将会被执行。
如果一个动作将这个流转发给了另一个控制器/动作，控制调度器将会再次启动。为了更好
解释这一点，以下示例怡到好处地说明了在  :doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>` 中的处理过程：

.. code-block:: php

    <?php

    // 循环调度
    while (!$finished) {
        $finished = true;

        $controllerClass = $controllerName . "Controller";

        // 通过自动加载器实例化控制器类
        $controller = new $controllerClass();

        // 执行action
        call_user_func_array(
            [
                $controller,
                $actionName . "Action"
            ],
            $params
        );

        // $finished应该重新加载以检测MVC流
        // 是否转发给了另一个控制器
        $finished = true;
    }

上面的代码缺少了验证，过滤器和额外的检查，但它演示了在调度器中正常的操作流。

循环调度事件（Dispatch Loop Events）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
:doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>` 可以发送事件给当前的 :doc:`EventsManager <events>` 。
事件会以“dispatch”类型被所触发。当返回false时有些事件可以终止当前激活的操作。已支持的事件如下：

+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| 事件名称             | 何时触发                                                                                                                                                                                                       | 此操作是否可终止？  | 触发于                |
+======================+================================================================================================================================================================================================================+=====================+=======================+
| beforeDispatchLoop   | 在进入循环调度前触发。此时，调度器不知道将要执行的控制器或者动作是否存在。调度器只知道路由传递过来的信息。                                                                                                     | 是                  | 侦听者                |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| beforeDispatch       | 在进入循环调度后触发。此时，调度器不知道将要执行的控制器或者动作是否存在。调度器只知道路由传递过来的信息。                                                                                                     | 是                  | 侦听者                |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| beforeExecuteRoute   | 在执行控制器/动作方法前触发。此时，调度器已经初始化了控制器并知道动作是否存在。                                                                                                                                | 是                  | 侦听者/控制器         |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| initialize           | 允许在请求中全局初始化控制器。                                                                                                                                                                                 | 否                  | 控制器                |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| afterExecuteRoute    | 在执行控制器/动作方法后触发。由于此操作不可终止，所以仅在执行动作后才使用此事件进行清理工作。                                                                                                                  | 否                  | 侦听者/控制器         |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| beforeNotFoundAction | 当控制器中的动作找不到时触发。                                                                                                                                                                                 | 是                  | 侦听者                |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| beforeException      | 在调度器抛出任意异常前触发。                                                                                                                                                                                   | 是                  | 侦听者                |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| afterDispatch        | 在执行控制器/动作方法后触发。由于此操作不可终止，所以仅在执行动作后才使用此事件进行清理工作。                                                                                                                  | 是                  | 侦听者                |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| afterDispatchLoop    | 在退出循环调度后触发。                                                                                                                                                                                         | 否                  | 侦听者                |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| afterBinding         | Triggered after models are bound but before executing route                                                                                                                                                        | 侦听者                  | Listeners/Controllers |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+

:doc:`INVO <tutorial-invo>` 这篇导读说明了如何从通过结合  :doc:`Acl <acl>` 实现的一个安全过滤器中获得事件调度的好处。

以下例子演示了如何将侦听者绑定到组件上：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    $di->set(
        "dispatcher",
        function () {
            // 创建一个事件管理
            $eventsManager = new EventsManager();

            // 为“dispatch”类型附上一个侦听者
            $eventsManager->attach(
                "dispatch",
                function (Event $event, $dispatcher) {
                    // ...
                }
            );

            $dispatcher = new MvcDispatcher();

            // 将$eventsManager绑定到视图组件
            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        },
        true
    );

一个实例化的控制器会自动作为事件调度的侦听者，所以你可以实现回调函数：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;
    use Phalcon\Mvc\Dispatcher;

    class PostsController extends Controller
    {
        public function beforeExecuteRoute(Dispatcher $dispatcher)
        {
            // 在每一个找到的动作前执行
        }

        public function afterExecuteRoute(Dispatcher $dispatcher)
        {
            // 在每一个找到的动作后执行
        }
    }

.. note:: Methods on event listeners accept an :doc:`Phalcon\\Events\\Event <../api/Phalcon_Events_Event>` object as their first parameter - methods in controllers do not.

转发到其他动作（Forwarding to other actions）
---------------------------------------------
循环调度允许我们转发执行流到另一个控制器/动作。这对于检查用户是否可以
访问页面，将用户重定向到其他屏幕或简单地代码重用都非常有用。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function saveAction($year, $postTitle)
        {
            // ... 储存一些产品并且转发用户

            // 将流转发到index动作
            $this->dispatcher->forward(
                [
                    "controller" => "posts",
                    "action"     => "index",
                ]
            );
        }
    }

请注意制造一个“forward”并不等同于制造一个HTTP的重定向。尽管这两者表面上最终效果都一样。
“forward”不会重新加载当前页面，全部的重定向都只发生在一个请求里面，而HTTP重定向则需要两次请求
才能完成这个流程。

更多转发示例：

.. code-block:: php

    <?php

    // 将流转发到当前控制器的另一个动作
    $this->dispatcher->forward(
        [
            "action" => "search"
        ]
    );

    // 将流转发到当前控制器的另一个动作
    // 传递参数
    $this->dispatcher->forward(
        [
            "action" => "search",
            "params" => [1, 2, 3]
        ]
    );

一个转发的动作可以接受以下参数：

+----------------+--------------------------------------------------------+
| 参数           | 触发                                                   |
+================+========================================================+
| controller     | 一个待转发且有效的控制器名字。                         |
+----------------+--------------------------------------------------------+
| action         | 一个待转发且有效的动作名字。                           |
+----------------+--------------------------------------------------------+
| params         | 一个传递给动作的数组参数。                             |
+----------------+--------------------------------------------------------+
| namespace      | 一个控制器对应的命名空间名字。                         |
+----------------+--------------------------------------------------------+

准备参数（Preparing Parameters）
--------------------------------
多得 :doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>` 提供的钩子函数， 你可以简单地
调整你的应用来匹配URL格式：

例如，你想把你的URL看起来像这样：http://example.com/controller/key1/value1/key2/value

默认下，参数会按URL传递的顺序传给对应的动作，你可以按期望来转换他们：

.. code-block:: php

    <?php

    use Phalcon\Dispatcher;
    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    $di->set(
        "dispatcher",
        function () {
            // 创建一个事件管理
            $eventsManager = new EventsManager();

            // 附上一个侦听者
            $eventsManager->attach(
                "dispatch:beforeDispatchLoop",
                function (Event $event, $dispatcher) {
                    $params = $dispatcher->getParams();

                    $keyParams = [];

                    // 用奇数参数作key，用偶数作值
                    foreach ($params as $i => $value) {
                        if ($i & 1) {
                            // Previous param
                            $key = $params[$i - 1];

                            $keyParams[$key] = $value;
                        }
                    }

                    // 重写参数
                    $dispatcher->setParams($keyParams);
                }
            );

            $dispatcher = new MvcDispatcher();

            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        }
    );

如果期望的链接是这样： http://example.com/controller/key1:value1/key2:value，那么就需要以下这样的代码：

.. code-block:: php

    <?php

    use Phalcon\Dispatcher;
    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    $di->set(
        "dispatcher",
        function () {
            // 创建一个事件管理
            $eventsManager = new EventsManager();

            // 附上一个侦听者
            $eventsManager->attach(
                "dispatch:beforeDispatchLoop",
                function (Event $event, $dispatcher) {
                    $params = $dispatcher->getParams();

                    $keyParams = [];

                    // 将每一个参数分解成key、值 对
                    foreach ($params as $number => $value) {
                        $parts = explode(":", $value);

                        $keyParams[$parts[0]] = $parts[1];
                    }

                    // 重写参数
                    $dispatcher->setParams($keyParams);
                }
            );

            $dispatcher = new MvcDispatcher();

            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        }
    );

获取参数（Getting Parameters）
------------------------------
当路由提供了命名的参数变量，你就可以在控制器、视图或者任何一个继承了
:doc:`Phalcon\\Di\\Injectable <../api/Phalcon_Di_Injectable>` 的组件中获得这些参数。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function saveAction()
        {
            // 从URL传递过来的参数中获取title
            // 或者在一个事件中准备
            $title = $this->dispatcher->getParam("title");

            // 从URL传递过来的参数中获取year
            // 或者在一个事件中准备并且进行过滤
            $year = $this->dispatcher->getParam("year", "int");

            // ...
        }
    }

准备行动（Preparing actions）
-----------------------------
你也可以为动作定义一个调度前的映射表。

转换动作名（Camelize action names）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
如果原始链接是：http://example.com/admin/products/show-latest-products，
例如你想把'show-latest-products'转换成'ShowLatestProducts'，
需要以下代码：

.. code-block:: php

    <?php

    use Phalcon\Text;
    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    $di->set(
        "dispatcher",
        function () {
            // 创建一个事件管理
            $eventsManager = new EventsManager();

            // Camelize动作
            $eventsManager->attach(
                "dispatch:beforeDispatchLoop",
                function (Event $event, $dispatcher) {
                    $dispatcher->setActionName(
                        Text::camelize($dispatcher->getActionName())
                    );
                }
            );

            $dispatcher = new MvcDispatcher();

            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        }
    );

删除遗留的扩展名（Remove legacy extensions）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
如果原始链接总是包含一个'.php'扩展名：

http://example.com/admin/products/show-latest-products.php
http://example.com/admin/products/index.php

你可以在调度对应的控制器/动作组前将它删除：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    $di->set(
        "dispatcher",
        function () {
            // 创建一个事件管理
            $eventsManager = new EventsManager();

            // 在调度前删除扩展
            $eventsManager->attach(
                "dispatch:beforeDispatchLoop",
                function (Event $event, $dispatcher) {
                    $action = $dispatcher->getActionName();

                    // 删除扩展
                    $action = preg_replace("/\.php$/", "", $action);

                    // 重写动作
                    $dispatcher->setActionName($action);
                }
            );

            $dispatcher = new MvcDispatcher();

            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        }
    );

注入模型实例（Inject model instances）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
在这个实例中，开发人员想要观察动作接收到的参数以便可以动态注入模型实例。

控制器看起来像这样：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        /**
         * 显示$post
         *
         * @param \Posts $post
         */
        public function showAction(Posts $post)
        {
            $this->view->post = $post;
        }
    }

'showAction'方法接收到一个 \Posts 模型的实例，开发人员可以
在调度动作和准备映射参数前进行观察：

.. code-block:: php

    <?php

    use Exception;
    use Phalcon\Mvc\Model;
    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;
    use ReflectionMethod;

    $di->set(
        "dispatcher",
        function () {
            // 创建一个事件管理
            $eventsManager = new EventsManager();

            $eventsManager->attach(
                "dispatch:beforeDispatchLoop",
                function (Event $event, $dispatcher) {
                    // 可能的控制器类名
                    $controllerName = $dispatcher->getControllerClass();

                    // 可能的方法名
                    $actionName = $dispatcher->getActiveMethod();

                    try {
                        // 从反射中获取将要被执行的方法
                        $reflection = new ReflectionMethod($controllerName, $actionName);

                        $parameters = $reflection->getParameters();


                        // 参数检查
                        foreach ($parameters as $parameter) {
                            // 获取期望的模型名字
                            $className = $parameter->getClass()->name;

                            // 检查参数是否为模型的实例
                            if (is_subclass_of($className, Model::class)) {
                                $model = $className::findFirstById($dispatcher->getParams()[0]);

                                // 根据模型实例重写参数
                                $dispatcher->setParams([$model]);
                            }
                        }
                    } catch (Exception $e) {
                        // 异常触发，类或者动作不存在？
                    }
                }
            );

            $dispatcher = new MvcDispatcher();

            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        }
    );

上面示例出于学术目的已经作了简化。
开发人员可以在执行动作前注入任何类型的依赖或者模型，以进行提高和强化。

From 3.1.x onwards the dispatcher also comes with an option to handle this internally for all models passed into a controller action by using :doc:`Phalcon\\Mvc\\Model\\Binder <../api/Phalcon_Mvc_Model_Binder>`.

.. code-block:: php

    use Phalcon\Mvc\Dispatcher;
    use Phalcon\Mvc\Model\Binder;

    $dispatcher = new Dispatcher();

    $dispatcher->setModelBinder(new Binder());

    return $dispatcher;

.. highlights::

    Since Binder object is using internally Reflection Api which can be heavy there is ability to set cache. This can be done by
    using second argument in :code:`setModelBinder()` which can also accept service name or just by passing cache instance to :code:`Binder` constructor.

It also introduces a new interface :doc:`Phalcon\\Mvc\\Model\\Binder\\BindableInterface <../api/Phalcon_Mvc_Model_Binder_BindableInterface>`
which allows you to define the controllers associated models to allow models binding in base controllers.

For example, you have a base CrudController which your PostsController extends from. Your CrudController looks something like this:

.. code-block:: php

    use Phalcon\Mvc\Controller;
    use Phalcon\Mvc\Model;

    class CrudController extends Controller
    {
        /**
         * Show action
         *
         * @param Model $model
         */
        public function showAction(Model $model)
        {
            $this->view->model = $model;
        }
    }

In your PostsController you need to define which model the controller is associated with. This is done by implementing the
:doc:`Phalcon\\Mvc\\Model\\Binder\\BindableInterface <../api/Phalcon_Mvc_Model_Binder_BindableInterface>`
which will add the :code:`getModelName()` method from which you can return the model name. It can return string with just one model name or associative array
where key is parameter name.

.. code-block:: php

    use Phalcon\Mvc\Model\Binder\BindableInterface;
    use Models\Posts;

    class PostsController extends CrudController implements BindableInterface
    {
        public static function getModelName()
        {
            return Posts::class;
        }
    }

By declaring the model associated with the PostsController the binder can check the controller for the :code:`getModelName()` method before passing
the defined model into the parent show action.

If your project structure does not use any parent controller you can of course still bind the model directly into the controller action:

.. code-block:: php

    use Phalcon\Mvc\Controller;
    use Models\Posts;

    class PostsController extends Controller
    {
        /**
         * Shows posts
         *
         * @param Posts $post
         */
        public function showAction(Posts $post)
        {
            $this->view->post = $post;
        }
    }

.. highlights::

    Currently the binder will only use the models primary key to perform a :code:`findFirst()` on.
    An example route for the above would be /posts/show/{1}

处理 Not-Found 错误（Handling Not-Found Exceptions）
----------------------------------------------------
使用 :doc:`EventsManager <events>` ，可以在调度器找不到对应的控制器/动作组时而抛出异常前，插入一个钩子：

.. code-block:: php

    <?php

    use Exception;
    use Phalcon\Dispatcher;
    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Mvc\Dispatcher\Exception as DispatchException;

    $di->setShared(
        "dispatcher",
        function () {
            // 创建一个事件管理
            $eventsManager = new EventsManager();

            // 附上一个侦听者
            $eventsManager->attach(
                "dispatch:beforeException",
                function (Event $event, $dispatcher, Exception $exception) {
                    // 处理404异常
                    if ($exception instanceof DispatchException) {
                        $dispatcher->forward(
                            [
                                "controller" => "index",
                                "action"     => "show404",
                            ]
                        );

                        return false;
                    }

                    // 代替控制器或者动作不存在时的路径
                    switch ($exception->getCode()) {
                        case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                        case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                            $dispatcher->forward(
                                [
                                    "controller" => "index",
                                    "action"     => "show404",
                                ]
                            );

                            return false;
                    }
                }
            );

            $dispatcher = new MvcDispatcher();

            // 将EventsManager绑定到调度器
            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        }
    );

当然，这个方法也可以移至独立的插件类中，使得在循环调度产生异常时可以有超过一个类执行需要的动作：

.. code-block:: php

    <?php

    use Exception;
    use Phalcon\Events\Event;
    use Phalcon\Mvc\Dispatcher;
    use Phalcon\Mvc\Dispatcher\Exception as DispatchException;

    class ExceptionsPlugin
    {
        public function beforeException(Event $event, Dispatcher $dispatcher, Exception $exception)
        {
            // Default error action
            $action = "show503";

            // 处理404异常
            if ($exception instanceof DispatchException) {
                $action = "show404";
            }

            $dispatcher->forward(
                [
                    "controller" => "index",
                    "action"     => $action,
                ]
            );

            return false;
        }
    }

.. highlights::

    仅仅当异常产生于调度器或者异常产生于被执行的动作时才会通知'beforeException'里面的事件。
    侦听者或者控制器事件中产生的异常则会重定向到最近的try/catch。

自定义调度器（Implementing your own Dispatcher）
------------------------------------------------
为了创建自定义调度器，必须实现  :doc:`Phalcon\\Mvc\\DispatcherInterface <../api/Phalcon_Mvc_DispatcherInterface>` 接口，
从而替换Phalcon框架默认提供的调度器。
