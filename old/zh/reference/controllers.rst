使用控制器（Using Controllers）
===============================

控制器提供了一堆可以被调用的方法，即：action。action是控制器中用于处理请求的方法。默认情况下，全部
控制器public的方法都会映射到action并且可以通过URL访问。action负责解释请求和创建响应。
通常，响应是以渲染的视图格式被创建，但也存在其他的方式来创建（译者注：如AJAX请求返回JSON格式的数据）。

例如，当你访问一个类似这样的URL时：http://localhost/blog/posts/show/2015/the-post-title，Phalcon默认会这样分解各个部分：

+-----------------+----------------+
| **Phalcon目录** | blog           |
+-----------------+----------------+
| **控制器**      | posts          |
+-----------------+----------------+
| **Action**      | show           |
+-----------------+----------------+
| **参数**        | 2015           |
+-----------------+----------------+
| **参数**        | the-post-title |
+-----------------+----------------+

这时，PostsController将会处理这个请求。在一个项目中，没有强制指定放置控制器的地方，这些控制器都可以
通过使用 :doc:`autoloaders <loader>` 来加载，所以你可以根据需要自由组件你的控制器。

控制器类必须以“Controller”为后缀，action则须以“Action”为后缀。一个控制器类的例子如下：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction($year, $postTitle)
        {

        }
    }

额外的URI参数定义为action的参数，以致这些参数可以简单地通过本地变量来获取。控制器
可以选择继承 :doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>` 。如果继承此基类，你的控制器类则能
轻松访问应用的各种服务。

没有默认缺省值的参数视为必须参数处理。可以像PHP那样为参数设定一个默认值：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction($year = 2015, $postTitle = "some default title")
        {

        }
    }

参数将会按路由传递和函数定义一样的顺序来赋值。你可以使用以下根据参数名称的方式来获取任意一个参数：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction()
        {
            $year      = $this->dispatcher->getParam("year");
            $postTitle = $this->dispatcher->getParam("postTitle");
        }
    }

循环调度（Dispatch Loop）
-------------------------
循环调度将会在分发器执行，直到没有action需要执行为止。在上面的例子中，只有一个action
被执行到。现在让我们来看下:code:`forward()``（转发）怎样才能在循环调度里提供一个更加复杂的操作流，从而将执行转发到
另一个controller/action。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction($year, $postTitle)
        {
            $this->flash->error(
                "You don't have permission to access this area"
            );

            // Forward flow to another action
            $this->dispatcher->forward(
                [
                    "controller" => "users",
                    "action"     => "signin",
                ]
            );
        }
    }

如果用户没有访问某个action的权限，那么请求将会被转发到Users控制器的signin行为。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UsersController extends Controller
    {
        public function indexAction()
        {

        }

        public function signinAction()
        {

        }
    }

对于“forwards”转发的次数没有限制，只要不会形成循环重定向即可，否则就意味着
你的应用将会停止（译者注：如果浏览器发现一个请求循环重定向时，会终止请求）。
如果在循环调度里面没有其他action可以分发，分发器将会自动调用由 :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` 管理的MVC的视图层。

初始化控制器（Initializing Controllers）
----------------------------------------
:doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>` 提供了初始化的函数，它会最先执行，并优于任何控制器
的其他action。不推荐使用“__construct"方法。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public $settings;

        public function initialize()
        {
            $this->settings = [
                "mySetting" => "value",
            ];
        }

        public function saveAction()
        {
            if ($this->settings["mySetting"] === "value") {
                // ...
            }
        }
    }

.. highlights::

    :code:`initialize()` 仅仅会在事件“beforeExecuteRoute”成功执行后才会被调用。这样可以避免
    在初始化中的应用逻辑在未鉴权的情况下无法执行。

如果你想在紧接着创建控制器对象的后面执行一些初始化的逻辑，你要实现:code:`onConstruct()`”方法：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function onConstruct()
        {
            // ...
        }
    }

.. highlights::

    需要注意的是，即使待执行的action在控制器不存在，或者用户没有
    访问到它（根据开发人员提供的自定义控制器接入），“onConstruct”都会被执行。

注入服务（Injecting Services）
------------------------------
如果控制器继承于 :doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>` ，那么它可以轻松访问
应用的服务容器。例如，如果我们类似这样注册了一个服务：

.. code-block:: php

    <?php

    use Phalcon\Di;

    $di = new Di();

    $di->set(
        "storage",
        function () {
            return new Storage(
                "/some/directory"
            );
        },
        true
    );

那么，我们可以通常多种方式来访问这个服务：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class FilesController extends Controller
    {
        public function saveAction()
        {
            // 以和服务相同名字的类属性访问
            $this->storage->save("/some/file");

            // 通过DI访问服务
            $this->di->get("storage")->save("/some/file");

            // 另一种方式：使用魔法getter来访问
            $this->di->getStorage()->save("/some/file");

            // 另一种方式：使用魔法getter来访问
            $this->getDi()->getStorage()->save("/some/file");

            // 使用数组下标
            $this->di["storage"]->save("/some/file");
        }
    }

如果你是把Phalcon作为全能(Full-Stack)框架来使用，你可以阅读框架中 :doc:`by default <di>` 提供的服务。

请求与响应（Request and Response）
----------------------------------
假设框架预先提供了一系列的注册的服务。我们这里将解释如何和HTTP环境进行关联和交互。
“request”服务包含了一个 :doc:`Phalcon\\Http\\Request <../api/Phalcon_Http_Request>` 的实例，
“response”服务则包含了一个 :doc:`Phalcon\\Http\\Response <../api/Phalcon_Http_Response>` 的实例，用来表示将要返回给客户端的内容。

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
            // 检查请求是否为POST
            if ($this->request->isPost()) {
                // 获取POST数据
                $customerName = $this->request->getPost("name");
                $customerBorn = $this->request->getPost("born");
            }
        }
    }

响应对象通常不会直接使用，但在action的执行前会被创建，有时候 - 如在
一个afterDispatch事件中 - 它对于直接访问响应非常有帮助：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function notFoundAction()
        {
            // 发送一个HTTP 404 响应的header
            $this->response->setStatusCode(404, "Not Found");
        }
    }

如需学习了解HTTP环境更多内容，请查看专题： :doc:`request <request>` 和 :doc:`response <response>` 。

会话数据（Session Data）
------------------------
会话可以帮助我们在多个请求中保持持久化的数据。你可以从任何控制器中访问 :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>`
以便封装需要进行持久化的数据。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UserController extends Controller
    {
        public function indexAction()
        {
            $this->persistent->name = "Michael";
        }

        public function welcomeAction()
        {
            echo "Welcome, ", $this->persistent->name;
        }
    }

在控制器中使用服务（Using Services as Controllers）
---------------------------------------------------
服务可以是控制器，控制器类通常会从服务容器中请求。据于此，
任何一个用其名字注册的类都可以轻易地用一个控制器来替换：

.. code-block:: php

    <?php

    // 将一个控制器作为服务进行注册
    $di->set(
        "IndexController",
        function () {
            $component = new Component();

            return $component;
        }
    );

    // 将一个命名空间下的控制器作为服务进行注册
    $di->set(
        "Backend\\Controllers\\IndexController",
        function () {
            $component = new Component();

            return $component;
        }
    );

控制器中的事件（Events in Controllers）
---------------------------------------
控制器会自动作为 :doc:`dispatcher <dispatching>` 事件的侦听者，使用这些事件并实现这些方法后，
你便可以实现对应被执行的action的before/after钩子函数：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function beforeExecuteRoute($dispatcher)
        {
            // 这个方法会在每一个能找到的action前执行
            if ($dispatcher->getActionName() === "save") {
                $this->flash->error(
                    "You don't have permission to save posts"
                );

                $this->dispatcher->forward(
                    [
                        "controller" => "home",
                        "action"     => "index",
                    ]
                );

                return false;
            }
        }

        public function afterExecuteRoute($dispatcher)
        {
            // 在找到的action后执行
        }
    }

.. _DRY: https://zh.wikipedia.org/wiki/%E4%B8%80%E6%AC%A1%E4%B8%94%E4%BB%85%E4%B8%80%E6%AC%A1
