マイクロアプリケーション
========================

マイクロフレームワークライクなアプリケーションを構築することができます。
PHPアプリケーションを最小のコードで書くことが可能です。
マイクロアプリケーションは、小規模アプリケーションやAPI、プロトタイプを実装するのに適切です。

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

マイクロアプリケーションの作成
------------------------------
:doc:`Phalcon\\Mvc\\Micro <../api/Phalcon_Mvc_Micro>` は、マイクロアプリケーションを実装するためのクラスです。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;

    $app = new Micro();

ルーティングの設定
------------------
オブジェクトのインスタンスを作成したら、いくつかのルーティングを設定する必要があります。
:doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>` は、ルーティングを管理します。
ルートは、常に/から開始しなければいけません。ルートを設定する際に、HTTPメソッドを任意に制限することができます。
指定したHTTPメソッドに一致したリクエストがあった場合にのみ、正しくルーティングされます。
以下の例では、GETメソッドのルーティングの設定方法を表記しています。

.. code-block:: php

    <?php

    $app->get(
        "/say/hello/{name}",
        function ($name) {
            echo "<h1>Hello! $name</h1>";
        }
    );

"get"メソッドは、HTTPメソッドのGETであることを指しています。:code:`/say/hello/{name}` というルートは、:code:`{$name}` というパラメータを持っています。
このパラメータは、無名関数で設定されているハンドラーに渡されます。ハンドラーは、ルートが一致した場合のみ実行されます。
以下の例では、何種類かあるハンドラーの設定方法を表記しています。

.. code-block:: php

    <?php

    // 関数を使う
    function say_hello($name) {
        echo "<h1>Hello! $name</h1>";
    }

    $app->get(
        "/say/hello/{name}",
        "say_hello"
    );

    // 静的メソッドを使う
    $app->get(
        "/say/hello/{name}",
        "SomeClass::someSayMethod"
    );

    // オブジェクト内のメソッドを使う
    $myController = new MyController();
    $app->get(
        "/say/hello/{name}",
        [
            $myController,
            "someAction"
        ]
    );

    // 無名関数
    $app->get(
        "/say/hello/{name}",
        function ($name) {
            echo "<h1>Hello! $name</h1>";
        }
    );

:doc:`Phalcon\\Mvc\\Micro <../api/Phalcon_Mvc_Micro>` はHTTPメソッドを指定するためのメソッドを提供しています。
ルートは以下のように制限できます。

.. code-block:: php

    <?php

    // HTTP メソッドが GET の場合
    $app->get(
        "/api/products",
        "get_products"
    );

    // HTTP メソッドが POST の場合
    $app->post(
        "/api/products/add",
        "add_product"
    );

    // HTTP メソッドが PUT の場合
    $app->put(
        "/api/products/update/{id}",
        "update_product"
    );

    // HTTP メソッドが DELETE の場合
    $app->delete(
        "/api/products/remove/{id}",
        "delete_product"
    );

    // HTTP メソッドが OPTIONS の場合
    $app->options(
        "/api/products/info/{id}",
        "info_product"
    );

    // HTTP メソッドが PATCH の場合
    $app->patch(
        "/api/products/update/{id}",
        "info_product"
    );

    // HTTP メソッドが GET または POST の場合
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

パラメータ付きのルーティング
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
パラメータ付きのルートは、上記の例のように簡単に設定できます。パラメータ名は括弧で括る必要があります。
パラメータのフォーマットは正規表現を使用して設定できます。

.. code-block:: php

    <?php

    // This route have two parameters and each of them have a format
    $app->get(
        "/posts/{year:[0-9]+}/{title:[a-zA-Z\-]+}",
        function ($year, $title) {
            echo "<h1>Title: $title</h1>";
            echo "<h2>Year: $year</h2>";
        }
    );

トップルート
^^^^^^^^^^^^^^
通常、アプリケーションのトップルートは、/となり、ほとんどの場合、GETメソッドにてアクセスされると思います。

.. code-block:: php

    <?php

    // This is the start route
    $app->get(
        "/",
        function () {
            echo "<h1>Welcome!</h1>";
        }
    );

Rewriteルール
^^^^^^^^^^^^^
URisのrewriteは、以下のようにApacheで制限します。

.. code-block:: apacheconf

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

レスポンス
----------------------
ハンドラーの中では自由にレスポンスを設定できます。直接出力したり、テンプレートエンジンを使用したり、ビューをインクルードしたり、JSONを返したり、など。

.. code-block:: php

    <?php

    // Direct output
    $app->get(
        "/say/hello",
        function () {
            echo "<h1>Hello! $name</h1>";
        }
    );

    // Requiring another file
    $app->get(
        "/show/results",
        function () {
            require "views/results.php";
        }
    );

    // Returning JSON
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

レスポンスについての詳細は、:doc:`"response" <response>` を参照してください。

.. code-block:: php

    <?php

    $app->get(
        "/show/data",
        function () use ($app) {
            // Set the Content-Type header
            $app->response->setContentType("text/plain");

            $app->response->sendHeaders();

            // Print a file
            readfile("data.txt");
        }
    );

レスポンスオブジェクトを作成して、ハンドラーから返す方法もあります。

.. code-block:: php

    <?php

    $app->get(
        "/show/data",
        function () {
            // Create a response
            $response = new Phalcon\Http\Response();

            // Set the Content-Type header
            $response->setContentType("text/plain");

            // Pass the content of a file
            $response->setContent(file_get_contents("data.txt"));

            // Return the response
            return $response;
        }
    );

リダイレクト
-------------------
リダイレクトによって、別のルートへフォワードすることができます。

.. code-block:: php

    <?php

    // This route makes a redirection to another route
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

ルーティングのURL生成
--------------------------
:doc:`Phalcon\\Mvc\\Url <url>` では、設定したルーティングに基づいてURLを作成できます。
これを使用するためには、ルートに名前を定義する必要があります。

.. code-block:: php

    <?php

    // Set a route with the name "show-post"
    $app->get(
        "/blog/{year}/{title}",
        function ($year, $title) use ($app) {
            // ... Show the post here
        }
    )->setName("show-post");

    // Produce a URL somewhere
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

Interacting with the Dependency Injector
----------------------------------------
In the micro application, a :doc:`Phalcon\\Di\\FactoryDefault <di>` services container is created implicitly; additionally you
can create outside the application a container to manipulate its services:

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

The array-syntax is allowed to easily set/get services in the internal services container:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;
    use Phalcon\Db\Adapter\Pdo\Mysql as MysqlAdapter;

    $app = new Micro();

    // Setup the database service
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

Not-Found ハンドラ
------------------
未定義のルートにアクセスした場合、マイクロアプリケーションでは、"Not-Found"ハンドラーが実行されます。

.. code-block:: php

    <?php

    $app->notFound(
        function () use ($app) {
            $app->response->setStatusCode(404, "Not Found");

            $app->response->sendHeaders();

            echo "This is crazy, but this page was not found!";
        }
    );

マイクロアプリケーションにおけるモデル
--------------------------------------
マイクロアプリケーションで、:doc:`Models <models>` が使用することができます。
モデルは自動読み込みで行う必要があります。

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

マイクロアプリケーション イベント
---------------------------------
:doc:`Phalcon\\Mvc\\Micro <../api/Phalcon_Mvc_Micro>` is able to send events to the :doc:`EventsManager <events>` (if it is present).
Events are triggered using the type "micro". The following events are supported:

+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| Event Name          | Triggered                                                                                                                  | Can stop operation?  |
+=====================+============================================================================================================================+======================+
| beforeHandleRoute   | The main method is just called, at this point the application doesn't know if there is some matched route                  | Yes                  |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| beforeExecuteRoute  | A route has been matched and it contains a valid handler, at this point the handler has not been executed                  | Yes                  |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| afterExecuteRoute   | Triggered after running the handler                                                                                        | No                   |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| beforeNotFound      | Triggered when any of the defined routes match the requested URI                                                           | Yes                  |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| afterHandleRoute    | Triggered after completing the whole process in a successful way                                                           | Yes                  |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| afterBinding        | Triggered after models are bound but before executing the handler                                                          | Yes                  |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+

In the following example, we explain how to control the application security using events:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    // Create a events manager
    $eventsManager = new EventsManager();

    $eventsManager->attach(
        "micro:beforeExecuteRoute",
        function (Event $event, $app) {
            if ($app->session->get("auth") === false) {
                $app->flashSession->error("The user isn't authenticated");

                $app->response->redirect("/");

                $app->response->sendHeaders();

                // Return (false) stop the operation
                return false;
            }
        }
    );

    $app = new Micro();

    // Bind the events manager to the app
    $app->setEventsManager($eventsManager);

ミドルウェアイベント
--------------------
In addition to the events manager, events can be added using the methods 'before', 'after' and 'finish':

.. code-block:: php

    <?php

    $app = new Phalcon\Mvc\Micro();

    // Executed before every route is executed
    // Return false cancels the route execution
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
            // This is executed after the route is executed
            echo json_encode($app->getReturnedValue());
        }
    );

    $app->finish(
        function () use ($app) {
            // This is executed when the request has been served
        }
    );

You can call the methods several times to add more events of the same type:

.. code-block:: php

    <?php

    $app->finish(
        function () use ($app) {
            // First 'finish' middleware
        }
    );

    $app->finish(
        function () use ($app) {
            // Second 'finish' middleware
        }
    );

Code for middlewares can be reused using separate classes:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro\MiddlewareInterface;

    /**
     * CacheMiddleware
     *
     * Caches pages to reduce processing
     */
    class CacheMiddleware implements MiddlewareInterface
    {
        public function call($application)
        {
            $cache  = $application["cache"];
            $router = $application["router"];

            $key = preg_replace("/^[a-zA-Z0-9]/", "", $router->getRewriteUri());

            // Check if the request is cached
            if ($cache->exists($key)) {
                echo $cache->get($key);

                return false;
            }

            return true;
        }
    }

Then add the instance to the application:

.. code-block:: php

    <?php

    $app->before(
        new CacheMiddleware()
    );

以下のミドルウェアイベントが利用可能です。

+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| Event Name          | Triggered                                                                                                                  | Can stop operation?  |
+=====================+============================================================================================================================+======================+
| before              | Before executing the handler. It can be used to control the access to the application                                      | Yes                  |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| after               | Executed after the handler is executed. It can be used to prepare the response                                             | No                   |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| finish              | Executed after sending the response. It can be used to perform clean-up                                                    | No                   |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| afterBinding        | After models are bound and before executing the handler.                                                                   | Yes
        |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+

ハンドラでコントローラの使用
-----------------------------
:code:`Mvc\Micro` を使用した中規模アプリケーションでは、コントローラーを使用する場合があると思います。
:doc:`Phalcon\\Mvc\\Micro\\Collection <../api/Phalcon_Mvc_Micro_Collection>` を使用することによって、コントローラーのグルーピングができます。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro\Collection as MicroCollection;

    $posts = new MicroCollection();

    // Set the main handler. ie. a controller instance
    $posts->setHandler(
        new PostsController()
    );

    // Set a common prefix for all routes
    $posts->setPrefix("/posts");

    // Use the method 'index' in PostsController
    $posts->get("/", "index");

    // Use the method 'show' in PostsController
    $posts->get("/show/{slug}", "show");

    $app->mount($posts);

'PostsController'を以下の例のように記載します。

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

上記の例では、コントローラーを直接インスタンス生成していますが、コレクションを使用すると遅延ロードすることができます。
つまり、ルートが一致した場合のみ、コントローラーがロードされます。

.. code-block:: php

    <?php

    $posts->setHandler("PostsController", true);
    $posts->setHandler("Blog\Controllers\PostsController", true);

レスポンスのリターン
--------------------
ハンドラーは、:doc:`Phalcon\\Http\\Response <response>` を使用した生のレスポンスを返したり、または、ビューなどのインターフェイスコンポーネントを返したりすると思います。
ハンドラーによってレスポンスが返されるとき、アプリケーションによって自動的にそれが送信されます。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;
    use Phalcon\Http\Response;

    $app = new Micro();

    // Return a response
    $app->get(
        "/welcome/index",
        function () {
            $response = new Response();

            $response->setStatusCode(401, "Unauthorized");

            $response->setContent("Access is not authorized");

            return $response;
        }
    );

ビューのレンダリング
--------------------
:doc:`Phalcon\\Mvc\\View\\Simple <views>` はビューをレンダリングするために使用します。

.. code-block:: php

    <?php

    $app = new Phalcon\Mvc\Micro();

    $app["view"] = function () {
        $view = new \Phalcon\Mvc\View\Simple();

        $view->setViewsDir("app/views/");

        return $view;
    };

    // Return a rendered view
    $app->get(
        "/products/show",
        function () use ($app) {
            // Render app/views/products/show.phtml passing some variables
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

関連ソース
---------------
* :doc:`Creating a Simple REST API <tutorial-rest>` is a tutorial that explains how to create a micro application to implement a RESTful web service.
* `Stickers Store <http://store.phalconphp.com>`_ is a very simple micro-application making use of the micro-mvc approach [`Github <https://github.com/phalcon/store>`_].
