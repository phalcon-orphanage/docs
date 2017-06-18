Micro Applications
==================

使用Phalcon框架开发者可以创建微框架应用。 这样开发者只需要书写极少的代码即可创建一个PHP应用。 微应用适用于书写小的应用， API或原型等

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;

    $app = new Micro();

    $app->get(
        "/say/welcome/{name}",
        function ($name) {
            echo "<h1>Welcome $name!</h1>";
        }
    );

    $app->handle();

创建微应用（Creating a Micro Application）
------------------------------------------
Phalcon中 使用 :doc:`Phalcon\\Mvc\\Micro <../api/Phalcon_Mvc_Micro>` 来实现微应用。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;

    $app = new Micro();

定义路由（Defining routes）
---------------------------
实例化后， 开发者需要添加一些路由规则。 Phalcon内部使用 :doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>` 来管理路由。 路由必须以 / 开头。
定义路由时通常会书写http方法约束， 这样路由规则只适用于那些和规则及htttp方法相匹配的路由。 下面的方法展示了如何定义了HTTP get方法路由：

.. code-block:: php

    <?php

    $app->get(
        "/say/hello/{name}",
        function ($name) {
            echo "<h1>Hello! $name</h1>";
        }
    );

get 方法指定了要匹配的请求方法。 路由规则 :code:`/say/hello/{name}` 中含有一个参数 :code:`{$name}`, 此参数会直接传递给路由的处理器（此处为匿名函数）。 路由规则匹配时处理器即会执行。
处理器是PHP中任何可以被调用的项。 下面的示例中展示了如何定义不同种类的处理器：

.. code-block:: php

    <?php

    //  函数
    function say_hello($name) {
        echo "<h1>Hello! $name</h1>";
    }

    $app->get(
        "/say/hello/{name}",
        "say_hello"
    );

    //  静态方法
    $app->get(
        "/say/hello/{name}",
        "SomeClass::someSayMethod"
    );

    //  对象内的方法
    $myController = new MyController();
    $app->get(
        "/say/hello/{name}",
        [
            $myController,
            "someAction"
        ]
    );

    // 匿名函数
    $app->get(
        "/say/hello/{name}",
        function ($name) {
            echo "<h1>Hello! $name</h1>";
        }
    );

:doc:`Phalcon\\Mvc\\Micro <../api/Phalcon_Mvc_Micro>` 提供了一系列的用于定义http方法的限定方法：

.. code-block:: php

    <?php

    // 匹配HTTP GET 方法：
    $app->get(
        "/api/products",
        "get_products"
    );

    // 匹配HTTP POST方法
    $app->post(
        "/api/products/add",
        "add_product"
    );

    // 匹配HTTP PUT 方法
    $app->put(
        "/api/products/update/{id}",
        "update_product"
    );

    // 匹配HTTP DELETE方法
    $app->delete(
        "/api/products/remove/{id}",
        "delete_product"
    );

    // 匹配HTTP OPTIONS方法
    $app->options(
        "/api/products/info/{id}",
        "info_product"
    );

    // 匹配HTTP PATCH方法
    $app->patch(
        "/api/products/update/{id}",
        "info_product"
    );

    // 匹配HTTP GET 或 POST方法
    $app->map(
        "/repos/store/refs",
        "action_product"
    )->via(
        [
            "GET",
            "POST",
        ]
    );

To access the HTTP method data :code:`$app` needs to be passed into the closure:

.. code-block:: php

    <?php

    // Matches if the HTTP method is POST
    $app->post(
        "/api/products/add",
        function () use ($app) {
            echo $app->request->getPost("productID");
        }
    );

路由参数（Routes with Parameters）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
如上面的例子中展示的那样在路由中定义参数是非常容易的。 参数名需要放在花括号内。 参数格式亦可使用正则表达式以确保数据一致性。 例子如下：

.. code-block:: php

    <?php

    // 此路由有两个参数每个参数有一格式
    $app->get(
        "/posts/{year:[0-9]+}/{title:[a-zA-Z\-]+}",
        function ($year, $title) {
            echo "<h1>Title: $title</h1>";
            echo "<h2>Year: $year</h2>";
        }
    );

起始路由（Starting Route）
^^^^^^^^^^^^^^^^^^^^^^^^^^
通常情况下， 应用一般由 / 路径开始访问， 当然此访问多为 GET方法。 这种情况代码如下：

.. code-block:: php

    <?php

    // 超始路由
    $app->get(
        "/",
        function () {
            echo "<h1>Welcome!</h1>";
        }
    );

重写规则（Rewrite Rules）
^^^^^^^^^^^^^^^^^^^^^^^^^
下面的规则用来实现apache重写：

.. code-block:: apacheconf

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

处理响应（Working with Responses）
----------------------------------
开发者可以在路由处理器中设置任务种类的响应：直接输出， 使用模板引擎， 包含视图， 返回json数据等。

.. code-block:: php

    <?php

    // 直接输出
    $app->get(
        "/say/hello",
        function () {
            echo "<h1>Hello! $name</h1>";
        }
    );

    // 包含其它文件
    $app->get(
        "/show/results",
        function () {
            require "views/results.php";
        }
    );

    // 返回JSON
    $app->get(
        "/get/some-json",
        function () {
            echo json_encode(
                [
                    "some",
                    "important",
                    "data",
                ]
            );
        }
    );

另外开发者还可以使用 :doc:`"response" <response>` ， 这样开发者可以更好的处理结果：

.. code-block:: php

    <?php

    $app->get(
        "/show/data",
        function () use ($app) {
            // 设置返回头部内容格式
            $app->response->setContentType("text/plain");

            $app->response->sendHeaders();

            // 输出文件内容
            readfile("data.txt");
        }
    );

或回复response对象：

.. code-block:: php

    <?php

    $app->get(
        "/show/data",
        function () {
            // 创建Response类实例
            $response = new Phalcon\Http\Response();

            // Set the Content-Type header 设置返回内容的类型
            $response->setContentType("text/plain");

            // 设置文件内容参数
            $response->setContent(file_get_contents("data.txt"));

            // 返回response实例对象
            return $response;
        }
    );

重定向（Making redirections）
-----------------------------
重定向用来在当前的处理中跳转到其它的处理流：

.. code-block:: php

    <?php

    // 此路由重定向到其它的路由
    $app->post("/old/welcome",
        function () use ($app) {
            $app->response->redirect("new/welcome");

            $app->response->sendHeaders();
        }
    );

    $app->post("/new/welcome",
        function () use ($app) {
            echo "This is the new Welcome";
        }
    );

根据路由生成 URL（Generating URLs for Routes）
-----------------------------------------------
Phalcon中使用 :doc:`Phalcon\\Mvc\\Url <url>` 来生成其它的基于路由的URL。 开发者可以为路由设置名字， 通过这种方式 "url" 服务可以产生相关的路由：

.. code-block:: php

    <?php

    // 设置名为 "show-post"的路由
    $app->get(
        "/blog/{year}/{title}",
        function ($year, $title) use ($app) {
            // ... Show the post here
        }
    )->setName("show-post");

    // 产生URL
    $app->get(
        "/",
        function () use ($app) {
            echo '<a href="', $app->url->get(
                [
                    "for"   => "show-post",
                    "title" => "php-is-a-great-framework",
                    "year"  => 2015
                ]
            ), '">Show the post</a>';
        }
    );

与依赖注入的交互（Interacting with the Dependency Injector）
------------------------------------------------------------
微应用中， :doc:`Phalcon\\Di\\FactoryDefault <di>` 是隐含生成的， 不过开发者可以明确的生成此类的实例以用来管理相关的服务：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;
    use Phalcon\Di\FactoryDefault;
    use Phalcon\Config\Adapter\Ini as IniConfig;

    $di = new FactoryDefault();

    $di->set(
        "config",
        function () {
            return new IniConfig("config.ini");
        }
    );

    $app = new Micro();

    $app->setDI($di);

    $app->get(
        "/",
        function () use ($app) {
            // Read a setting from the config
            echo $app->config->app_name;
        }
    );

    $app->post(
        "/contact",
        function () use ($app) {
            $app->flash->success("Yes!, the contact was made!");
        }
    );

服务容器中可以使用数据类的语法来设置或取服务实例：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;
    use Phalcon\Db\Adapter\Pdo\Mysql as MysqlAdapter;

    $app = new Micro();

    // 设置数据库服务实例
    $app["db"] = function () {
        return new MysqlAdapter(
            [
                "host"     => "localhost",
                "username" => "root",
                "password" => "secret",
                "dbname"   => "test_db"
            ]
        );
    };

    $app->get(
        "/blog",
        function () use ($app) {
            $news = $app["db"]->query("SELECT * FROM news");

            foreach ($news as $new) {
                echo $new->title;
            }
        }
    );

处理Not-Found（Not-Found Handler）
----------------------------------
当用户访问未定义的路由时， 微应用会试着执行 "Not-Found"处理器。 示例如下：

.. code-block:: php

    <?php

    $app->notFound(
        function () use ($app) {
            $app->response->setStatusCode(404, "Not Found");

            $app->response->sendHeaders();

            echo "This is crazy, but this page was not found!";
        }
    );

微应用中的模型（Models in Micro Applications）
----------------------------------------------
Phalcon中开发者可以直接使用 :doc:`Models <models>` ， 开发者只需要一个类自动加载器来加载模型：

.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();

    $loader->registerDirs(
        [
            __DIR__ . "/models/"
        ]
    )->register();

    $app = new \Phalcon\Mvc\Micro();

    $app->get(
        "/products/find",
        function () {
            $products = Products::find();

            foreach ($products as $product) {
                echo $product->name, "<br>";
            }
        }
    );

    $app->handle();

Inject model instances
----------------------
By using class :doc:`Phalcon\\Mvc\\Model\\Binder <../api/Phalcon_Mvc_Model_Binder>` you can inject model instances into your routes:

.. code-block:: php

     <?php

    $loader = new \Phalcon\Loader();

    $loader->registerDirs(
        [
            __DIR__ . "/models/"
        ]
    )->register();

    $app = new \Phalcon\Mvc\Micro();
    $app->setModelBinder(new \Phalcon\Mvc\Model\Binder());

    $app->get(
        "/products/{product:[0-9]+}",
        function (Products $product) {
            // do anything with $product object
        }
    );

    $app->handle();

.. highlights::

    Since Binder object is using internally Reflection Api which can be heavy there is ability to set cache. This can be done by
    using second argument in :code:`setModelBinder()` which can also accept service name or just by passing cache instance to :code:`Binder` constructor.

.. highlights::

    Currently the binder will only use the models primary key to perform a :code:`findFirst()` on.
    An example route for the above would be /products/1

微应用中的事件（Micro Application Events）
------------------------------------------
当有事件发生时 :doc:`Phalcon\\Mvc\\Micro <../api/Phalcon_Mvc_Micro>` 会发送事件到 :doc:`EventsManager <events>` 。 这里使用 "micro" 来绑定处理事件。 支持如下事件：

+---------------------+-------------------------------------------------------------------+----------------------+
| 事件名              |  如何触发                                                         | 是否可中断执行       |
+=====================+===================================================================+======================+
| beforeHandleRoute   |  处理方法调用之前执行， 此时应用程序还不知道是否存在匹配的路由    | 是                   |
+---------------------+-------------------------------------------------------------------+----------------------+
| beforeExecuteRoute  |  存在匹配的路由及相关的处理器， 不过处理器还未被执行              | 是                   |
+---------------------+-------------------------------------------------------------------+----------------------+
| afterExecuteRoute   |  处理器执行之后触发                                               | 否                   |
+---------------------+-------------------------------------------------------------------+----------------------+
| beforeNotFound      |  NotFound触发之前执行                                             | 是                   |
+---------------------+-------------------------------------------------------------------+----------------------+
| afterHandleRoute    |  处理器执行之后执行                                               | 是                   |
+---------------------+-------------------------------------------------------------------+----------------------+
| afterBinding        | Triggered after models are bound but before executing the handler  | 是                  |
+------------------------------------------------------------------------------------------+----------------------+

下面的例子中， 我们阐述了如何使用事件来控制应用的安全性:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    // 创建事件监听器
    $eventsManager = new EventsManager();

    $eventsManager->attach(
        "micro:beforeExecuteRoute",
        function (Event $event, $app) {
            if ($app->session->get("auth") === false) {
                $app->flashSession->error("The user isn't authenticated");

                $app->response->redirect("/");

                $app->response->sendHeaders();

                // 返回false来中止操作
                return false;
            }
        }
    );

    $app = new Micro();

    // 绑定事件管理器到应用
    $app->setEventsManager($eventsManager);

中间件事件（Middleware events）
-------------------------------
此外， 应用事件亦可使用 'before', 'after', 'finish'等来绑定：

.. code-block:: php

    <?php

    $app = new Phalcon\Mvc\Micro();

    // 每个路由匹配之前执行
    // 返回false来中止程序执行
    $app->before(
        function () use ($app) {
            if ($app["session"]->get("auth") === false) {
                $app["flashSession"]->error("The user isn't authenticated");

                $app["response"]->redirect("/error");

                // Return false stops the normal execution
                return false;
            }

            return true;
        }
    );

    $app->map(
        "/api/robots",
        function () {
            return [
                "status" => "OK",
            ];
        }
    );

    $app->after(
        function () use ($app) {
            // 路由处理器执行后执行
            echo json_encode($app->getReturnedValue());
        }
    );

    $app->finish(
        function () use ($app) {
            // 路由处理器执行后执行
        }
    );

开发者可以对同一事件注册多个处理器:

.. code-block:: php

    <?php

    $app->finish(
        function () use ($app) {
            // 第一个结束处理器
        }
    );

    $app->finish(
        function () use ($app) {
            // 第二个结束处理器
        }
    );

把这些代码放在另外的文件中以达到重用的目的:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro\MiddlewareInterface;

    /**
     * CacheMiddleware
     *
     * 使用缓存来提升性能
     */
    class CacheMiddleware implements MiddlewareInterface
    {
        public function call($application)
        {
            $cache  = $application["cache"];
            $router = $application["router"];

            $key = preg_replace("/^[a-zA-Z0-9]/", "", $router->getRewriteUri());

            // 检查请示是否被处理了
            if ($cache->exists($key)) {
                echo $cache->get($key);

                return false;
            }

            return true;
        }
    }

添加实例到应用:

.. code-block:: php

    <?php

    $app->before(
        new CacheMiddleware()
    );

支持如下的中间件事件：

+---------------------+-----------------------------------------------------+----------------------+
| 事件名              |  触发                                               | 是否可中止操作?      |
+=====================+=====================================================+======================+
| before              |  应用请求处理之前执行，常用来控制应用的访问权限     | Yes                  |
+---------------------+-----------------------------------------------------+----------------------+
| after               |  请求处理后执行，可以用来准备回复内容               | No                   |
+---------------------+-----------------------------------------------------+----------------------+
| finish              |  发送回复内容后执行， 可以用来执行清理工作          | No                   |
+---------------------+-----------------------------------------------------+----------------------+
| afterBinding        | After models are bound and before executing the handler.     | Yes                  |
+---------------------+-----------------------------------------------------+----------------------+

使用控制器处理（Using Controllers as Handlers）
-----------------------------------------------
中型的应用可以使用 :code:`Mvc\Micro` 来组织控制器中的处理器。 开发者也可以使用 :doc:`Phalcon\\Mvc\\Micro\\Collection <../api/Phalcon_Mvc_Micro_Collection>` 来对控制器中的处理器进行归组：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro\Collection as MicroCollection;

    $posts = new MicroCollection();

    // 设置主处理器，这里是控制器的实例
    $posts->setHandler(
        new PostsController()
    );

    // 对所有路由设置前缀
    $posts->setPrefix("/posts");

    //  使用PostsController中的index action
    $posts->get("/", "index");

    // 使用PostController中的show action
    $posts->get("/show/{slug}", "show");

    $app->mount($posts);

PostsController形如下：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function index()
        {
            // ...
        }

        public function show($slug)
        {
            // ...
        }
    }

上面的例子中，我们直接对控制器进行了实例化， 使用集合时Phalcon会提供了迟加载的能力， 这样程序只有在匹配路由时才加载控制器：

.. code-block:: php

    <?php

    $posts->setHandler('PostsController', true);
    $posts->setHandler('Blog\Controllers\PostsController', true);

返回响应（Returning Responses）
-------------------------------
处理器可能会返回原生的 :doc:`Phalcon\\Http\\Response <response>` 实例或实现了相关接口的组件。 当返回Response对象时， 应用会自动的把处理结果返回到客户端。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;
    use Phalcon\Http\Response;

    $app = new Micro();

    // 返回Response实例
    $app->get(
        "/welcome/index",
        function () {
            $response = new Response();

            $response->setStatusCode(401, "Unauthorized");

            $response->setContent("Access is not authorized");

            return $response;
        }
    );

渲染视图（Rendering Views）
---------------------------
:doc:`Phalcon\\Mvc\\View\\Simple <views>` 可用来渲染视图， 示例如下：

.. code-block:: php

    <?php

    $app = new Phalcon\Mvc\Micro();

    $app["view"] = function () {
        $view = new \Phalcon\Mvc\View\Simple();

        $view->setViewsDir("app/views/");

        return $view;
    };

    // 返回渲染过的视图
    $app->get(
        "/products/show",
        function () use ($app) {
            // 渲染视图时传递参数
            echo $app["view"]->render(
                "products/show",
                [
                    "id"   => 100,
                    "name" => "Artichoke"
                ]
            );
        }
    );

Please note that this code block uses :doc:`Phalcon\\Mvc\\View\\Simple <../api/Phalcon_Mvc_View_Simple>` which uses relative paths instead of controllers and actions.
If you would like to use :doc:`Phalcon\\Mvc\\View\\Simple <../api/Phalcon_Mvc_View_Simple>` instead, you will need to change the parameters of the :code:`render()` method:

.. code-block:: php

    <?php

    $app = new Phalcon\Mvc\Micro();

    $app["view"] = function () {
        $view = new \Phalcon\Mvc\View();

        $view->setViewsDir("app/views/");

        return $view;
    };

    // Return a rendered view
    $app->get(
        "/products/show",
        function () use ($app) {
            // Render app/views/products/show.phtml passing some variables
            echo $app["view"]->render(
                "products",
                "show",
                [
                    "id"   => 100,
                    "name" => "Artichoke"
                ]
            );
        }
    );

Error Handling
--------------
A proper response can be generated if an exception is raised in a micro handler:

.. code-block:: php

    <?php

    $app = new Phalcon\Mvc\Micro();

    $app->get(
        "/",
        function () {
            throw new \Exception("An error");
        }
    );

    $app->error(
        function ($exception) {
            echo "An error has occurred";
        }
    );

If the handler returns "false" the exception is stopped.

相关资源（Related Sources）
---------------------------
* :doc:`Creating a Simple REST API <tutorial-rest>` 例子中讲解了如何使用微应用来创建Restfull服务：
* `Stickers Store <http://store.phalconphp.com>`_ 也是一个简单的使用微应用的例子 [`Github <https://github.com/phalcon/store>`_].
