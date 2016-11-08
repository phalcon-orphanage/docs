路由（Routing）
===============

The router component allows you to define routes that are mapped to controllers or handlers that should receive
the request. A router simply parses a URI to determine this information. The router has two modes: MVC
mode and match-only mode. The first mode is ideal for working with MVC applications.

路由器组件用来定义处理接收到的请求的路由，指向相应的控制器或者处理程序。路由器只是简单解析一个URI获取这些信息。
路由器有两种模式：MVC模式以及匹配模式。第一种模式主要适合MVC应用。

定义路由（Defining Routes）
---------------------------
:doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>` provides advanced routing capabilities. In MVC mode,
you can define routes and map them to controllers/actions that you require. A route is defined as follows:

:doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>` 提供高级路由支持。在MVC模式下，你可以定义路由并映射向需要的控制器/动作。
一个路由定义方法如下所示：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    // Create the router
    $router = new Router();

    // Define a route
    $router->add(
        "/admin/users/my-profile",
        [
            "controller" => "users",
            "action"     => "profile",
        ]
    );

    // Another route
    $router->add(
        "/admin/users/change-password",
        [
            "controller" => "users",
            "action"     => "changePassword",
        ]
    );

    $router->handle();

add() 方法接受一个匹配模式作为第一个参数，一组可选的路径作为第二个参数。如上，如果URI就是/admin/users/my-profile的话，
那么 "users" 控制的 "profile" 方法将被调用。当然路由器并不马上就调用这个方法，它只是收集这些信息并且通知相应的组件（
比如  :doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>` ）应该调用这个控制器的这个动作。

一个应用程序可以由很多路径，一个一个定义是一个非常笨重的工作。这种情况下我们可以创建一个更加灵活的路由：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    // Create the router
    $router = new Router();

    // Define a route
    $router->add(
        "/admin/:controller/a/:action/:params",
        [
            "controller" => 1,
            "action"     => 2,
            "params"     => 3,
        ]
    );

在上面的例子中我们通过使用通配符定义了一个可以匹配多个URI的路由，比如，访问这个URL（/admin/users/a/delete/dave/301），那么：

+------------+---------------+
| Controller | users         |
+------------+---------------+
| Action     | delete        |
+------------+---------------+
| Parameter  | dave          |
+------------+---------------+
| Parameter  | 301           |
+------------+---------------+

The :code:`add()` method receives a pattern that can optionally have predefined placeholders and regular expression
modifiers. All the routing patterns must start with a forward slash character (/). The regular expression syntax used
is the same as the `PCRE regular expressions`_. Note that, it is not necessary to add regular expression
delimiters. All route patterns are case-insensitive.

The second parameter defines how the matched parts should bind to the controller/action/parameters. Matching
parts are placeholders or subpatterns delimited by parentheses (round brackets). In the example given above, the
first subpattern matched (:code:`:controller`) is the controller part of the route, the second the action and so on.

These placeholders help writing regular expressions that are more readable for developers and easier
to understand. The following placeholders are supported:

+----------------------+-----------------------------+--------------------------------------------------------------------------------------------------------+
| Placeholder          | Regular Expression          | Usage                                                                                                  |
+======================+=============================+========================================================================================================+
| :code:`/:module`     | :code:`/([a-zA-Z0-9\_\-]+)` | Matches a valid module name with alpha-numeric characters only                                         |
+----------------------+-----------------------------+--------------------------------------------------------------------------------------------------------+
| :code:`/:controller` | :code:`/([a-zA-Z0-9\_\-]+)` | Matches a valid controller name with alpha-numeric characters only                                     |
+----------------------+-----------------------------+--------------------------------------------------------------------------------------------------------+
| :code:`/:action`     | :code:`/([a-zA-Z0-9\_]+)`   | Matches a valid action name with alpha-numeric characters only                                         |
+----------------------+-----------------------------+--------------------------------------------------------------------------------------------------------+
| :code:`/:params`     | :code:`(/.*)*`              | Matches a list of optional words separated by slashes. Only use this placeholder at the end of a route |
+----------------------+-----------------------------+--------------------------------------------------------------------------------------------------------+
| :code:`/:namespace`  | :code:`/([a-zA-Z0-9\_\-]+)` | Matches a single level namespace name                                                                  |
+----------------------+-----------------------------+--------------------------------------------------------------------------------------------------------+
| :code:`/:int`        | :code:`/([0-9]+)`           | Matches an integer parameter                                                                           |
+----------------------+-----------------------------+--------------------------------------------------------------------------------------------------------+

Controller names are camelized, this means that characters (:code:`-`) and (:code:`_`) are removed and the next character
is uppercased. For instance, some_controller is converted to SomeController.

Since you can add many routes as you need using the :code:`add()` method, the order in which routes are added indicate
their relevance, latest routes added have more relevance than first added. Internally, all defined routes
are traversed in reverse order until :doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>` finds the
one that matches the given URI and processes it, while ignoring the rest.

参数名称（Parameters with Names）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
下面的例子演示了如何定义路由参数:

.. code-block:: php

    <?php

    $router->add(
        "/news/([0-9]{4})/([0-9]{2})/([0-9]{2})/:params",
        [
            "controller" => "posts",
            "action"     => "show",
            "year"       => 1, // ([0-9]{4})
            "month"      => 2, // ([0-9]{2})
            "day"        => 3, // ([0-9]{2})
            "params"     => 4, // :params
        ]
    );

在上述示例中，路由规则里并没有定义 "controller" 或者 "action" 部分。它们已经被路由替换为("posts" and "show")。
用户不会知道请求当中实际分发到的是哪个控制器。在控制器内部，可以通过如下方式来接收参数:

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
            // Get "year" parameter
            $year = $this->dispatcher->getParam("year");

            // Get "month" parameter
            $month = $this->dispatcher->getParam("month");

            // Get "day" parameter
            $day = $this->dispatcher->getParam("day");

            // ...
        }
    }

Note that the values of the parameters are obtained from the dispatcher. This happens because it is the
component that finally interacts with the drivers of your application. Moreover, there is also another
way to create named parameters as part of the pattern:

.. code-block:: php

    <?php

    $router->add(
        "/documentation/{chapter}/{name}.{type:[a-z]+}",
        [
            "controller" => "documentation",
            "action"     => "show",
        ]
    );

You can access their values in the same way as before:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class DocumentationController extends Controller
    {
        public function showAction()
        {
            // Get "name" parameter
            $name = $this->dispatcher->getParam("name");

            // Get "type" parameter
            $type = $this->dispatcher->getParam("type");

            // ...
        }
    }

短语法（Short Syntax）
^^^^^^^^^^^^^^^^^^^^^^
If you don't like using an array to define the route paths, an alternative syntax is also available.
The following examples produce the same result:

.. code-block:: php

    <?php

    // Short form
    $router->add(
        "/posts/{year:[0-9]+}/{title:[a-z\-]+}",
        "Posts::show"
    );

    // Array form
    $router->add(
        "/posts/([0-9]+)/([a-z\-]+)",
        [
           "controller" => "posts",
           "action"     => "show",
           "year"       => 1,
           "title"      => 2,
        ]
    );

混合使用数组和短语法（Mixing Array and Short Syntax）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Array and short syntax can be mixed to define a route, in this case note that named parameters automatically
are added to the route paths according to the position on which they were defined:

.. code-block:: php

    <?php

    // First position must be skipped because it is used for
    // the named parameter 'country'
    $router->add(
        "/news/{country:[a-z]{2}}/([a-z+])/([a-z\-+])",
        [
            "section" => 2, // Positions start with 2
            "article" => 3,
        ]
    );

路由到模块（Routing to Modules）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
你可以在路由规则中包含模块。这种用法特别适合于多模块的应用程序。It's possible define a default route that includes a module wildcard:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    $router = new Router(false);

    $router->add(
        "/:module/:controller/:action/:params",
        [
            "module"     => 1,
            "controller" => 2,
            "action"     => 3,
            "params"     => 4,
        ]
    );

在上述示例中，URL中必须总是含有模块名才能进行路由解析。比如URL: /admin/users/edit/sonny, 将会被路由解析为:

+------------+---------------+
| Module     | admin         |
+------------+---------------+
| Controller | users         |
+------------+---------------+
| Action     | edit          |
+------------+---------------+
| Parameter  | sonny         |
+------------+---------------+

你也可以将特定的路由规则绑定到特定的模块:

.. code-block:: php

    <?php

    $router->add(
        "/login",
        [
            "module"     => "backend",
            "controller" => "login",
            "action"     => "index",
        ]
    );

    $router->add(
        "/products/:action",
        [
            "module"     => "frontend",
            "controller" => "products",
            "action"     => 1,
        ]
    );

Or bind them to specific namespaces:

.. code-block:: php

    <?php

    $router->add(
        "/:namespace/login",
        [
            "namespace"  => 1,
            "controller" => "login",
            "action"     => "index",
        ]
    );

Namespaces/class names must be passed separated:

.. code-block:: php

    <?php

    $router->add(
        "/login",
        [
            "namespace"  => "Backend\\Controllers",
            "controller" => "login",
            "action"     => "index",
        ]
    );

限制 HTTP 请求传入方式（HTTP Method Restrictions）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
当使用 :code:`add()` 方法来添加路由规则时, 这条路由规则可以支持HTTP协议的任何数据传输方法。
有时我们需要限制路由规则只能匹配HTTP协议的某个方法，这在创建 RESTful 风格的应用程序时特别有用:

.. code-block:: php

    <?php

    // This route only will be matched if the HTTP method is GET
    $router->addGet(
        "/products/edit/{id}",
        "Products::edit"
    );

    // This route only will be matched if the HTTP method is POST
    $router->addPost(
        "/products/save",
        "Products::save"
    );

    // This route will be matched if the HTTP method is POST or PUT
    $router->add(
        "/products/update",
        "Products::update"
    )->via(
        [
            "POST",
            "PUT",
        ]
    );

使用转换（Using conversors）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Conversors allow you to freely transform the route's parameters before passing them to the dispatcher.
The following examples show how to use them:

.. code-block:: php

    <?php

    // The action name allows dashes, an action can be: /products/new-ipod-nano-4-generation
    $route = $router->add(
        "/products/{slug:[a-z\-]+}",
        [
            "controller" => "products",
            "action"     => "show",
        ]
    );

    $route->convert(
        "slug",
        function ($slug) {
            // Transform the slug removing the dashes
            return str_replace("-", "", $slug);
        }
    );

Another use case for conversors is binding a model into a route. This allows the model to be passed into the defined action directly:

.. code-block:: php

    <?php

    // This example works off the assumption that the ID is being used as parameter in the url: /products/4
    $route = $router->add(
        "/products/{id}",
        [
            "controller" => "products",
            "action"     => "show",
        ]
    );

    $route->convert(
        "id",
        function ($id) {
            // Fetch the model
            return Product::findFirstById($id);
        }
    );

路由分组（Groups of Routes）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
If a set of routes have common paths they can be grouped to easily maintain them:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;
    use Phalcon\Mvc\Router\Group as RouterGroup;

    $router = new Router();

    // Create a group with a common module and controller
    $blog = new RouterGroup(
        [
            "module"     => "blog",
            "controller" => "index",
        ]
    );

    // All the routes start with /blog
    $blog->setPrefix("/blog");

    // Add a route to the group
    $blog->add(
        "/save",
        [
            "action" => "save",
        ]
    );

    // Add another route to the group
    $blog->add(
        "/edit/{id}",
        [
            "action" => "edit",
        ]
    );

    // This route maps to a controller different than the default
    $blog->add(
        "/blog",
        [
            "controller" => "blog",
            "action"     => "index",
        ]
    );

    // Add the group to the router
    $router->mount($blog);

You can move groups of routes to separate files in order to improve the organization and code reusing in the application:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router\Group as RouterGroup;

    class BlogRoutes extends RouterGroup
    {
        public function initialize()
        {
            // Default paths
            $this->setPaths(
                [
                    "module"    => "blog",
                    "namespace" => "Blog\\Controllers",
                ]
            );

            // All the routes start with /blog
            $this->setPrefix("/blog");

            // Add a route to the group
            $this->add(
                "/save",
                [
                    "action" => "save",
                ]
            );

            // Add another route to the group
            $this->add(
                "/edit/{id}",
                [
                    "action" => "edit",
                ]
            );

            // This route maps to a controller different than the default
            $this->add(
                "/blog",
                [
                    "controller" => "blog",
                    "action"     => "index",
                ]
            );
        }
    }

Then mount the group in the router:

.. code-block:: php

    <?php

    // Add the group to the router
    $router->mount(
        new BlogRoutes()
    );

匹配路由（Matching Routes）
---------------------------
A valid URI must be passed to the Router so that it can process it and find a matching route.
By default, the routing URI is taken from the :code:`$_GET["_url"]` variable that is created by the rewrite engine
module. A couple of rewrite rules that work very well with Phalcon are:

.. code-block:: apacheconf

    RewriteEngine On
    RewriteCond   %{REQUEST_FILENAME} !-d
    RewriteCond   %{REQUEST_FILENAME} !-f
    RewriteRule   ^((?s).*)$ index.php?_url=/$1 [QSA,L]

In this configuration, any requests to files or folders that don't exist will be sent to index.php.

The following example shows how to use this component in stand-alone mode:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    // Creating a router
    $router = new Router();

    // Define routes here if any
    // ...

    // Taking URI from $_GET["_url"]
    $router->handle();

    // Or Setting the URI value directly
    $router->handle("/employees/edit/17");

    // Getting the processed controller
    echo $router->getControllerName();

    // Getting the processed action
    echo $router->getActionName();

    // Get the matched route
    $route = $router->getMatchedRoute();

路由命名（Naming Routes）
-------------------------
Each route that is added to the router is stored internally as a :doc:`Phalcon\\Mvc\\Router\\Route <../api/Phalcon_Mvc_Router_Route>` object.
That class encapsulates all the details of each route. For instance, we can give a name to a path to identify it uniquely in our application.
This is especially useful if you want to create URLs from it.

.. code-block:: php

    <?php

    $route = $router->add(
        "/posts/{year}/{title}",
        "Posts::show"
    );

    $route->setName("show-posts");

Then, using for example the component :doc:`Phalcon\\Mvc\\Url <../api/Phalcon_Mvc_Url>` we can build routes from its name:

.. code-block:: php

    <?php

    // Returns /posts/2012/phalcon-1-0-released
    echo $url->get(
        [
            "for"   => "show-posts",
            "year"  => "2012",
            "title" => "phalcon-1-0-released",
        ]
    );

范例（Usage Examples）
----------------------
The following are examples of custom routes:

.. code-block:: php

    <?php

    // Matches "/system/admin/a/edit/7001"
    $router->add(
        "/system/:controller/a/:action/:params",
        [
            "controller" => 1,
            "action"     => 2,
            "params"     => 3,
        ]
    );

    // Matches "/es/news"
    $router->add(
        "/([a-z]{2})/:controller",
        [
            "controller" => 2,
            "action"     => "index",
            "language"   => 1,
        ]
    );

    // Matches "/es/news"
    $router->add(
        "/{language:[a-z]{2}}/:controller",
        [
            "controller" => 2,
            "action"     => "index",
        ]
    );

    // Matches "/admin/posts/edit/100"
    $router->add(
        "/admin/:controller/:action/:int",
        [
            "controller" => 1,
            "action"     => 2,
            "id"         => 3,
        ]
    );

    // Matches "/posts/2015/02/some-cool-content"
    $router->add(
        "/posts/([0-9]{4})/([0-9]{2})/([a-z\-]+)",
        [
            "controller" => "posts",
            "action"     => "show",
            "year"       => 1,
            "month"      => 2,
            "title"      => 4,
        ]
    );

    // Matches "/manual/en/translate.adapter.html"
    $router->add(
        "/manual/([a-z]{2})/([a-z\.]+)\.html",
        [
            "controller" => "manual",
            "action"     => "show",
            "language"   => 1,
            "file"       => 2,
        ]
    );

    // Matches /feed/fr/le-robots-hot-news.atom
    $router->add(
        "/feed/{lang:[a-z]+}/{blog:[a-z\-]+}\.{type:[a-z\-]+}",
        "Feed::get"
    );

    // Matches /api/v1/users/peter.json
    $router->add(
        "/api/(v1|v2)/{method:[a-z]+}/{param:[a-z]+}\.(json|xml)",
        [
            "controller" => "api",
            "version"    => 1,
            "format"     => 4,
        ]
    );

.. highlights::

    Beware of characters allowed in regular expression for controllers and namespaces. As these
    become class names and in turn they're passed through the file system could be used by attackers to
    read unauthorized files. A safe regular expression is: :code:`/([a-zA-Z0-9\_\-]+)`

默认行为（Default Behavior）
----------------------------
:doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>` has a default behavior that provides a very simple routing that
always expects a URI that matches the following pattern: /:controller/:action/:params

For example, for a URL like this *http://phalconphp.com/documentation/show/about.html*, this router will translate it as follows:

+------------+---------------+
| Controller | documentation |
+------------+---------------+
| Action     | show          |
+------------+---------------+
| Parameter  | about.html    |
+------------+---------------+

If you don't want the router to have this behavior, you must create the router passing :code:`false` as the first parameter:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    // Create the router without default routes
    $router = new Router(false);

设置默认路由（Setting the default route）
-----------------------------------------
When your application is accessed without any route, the '/' route is used to determine what paths must be used to show the initial page
in your website/application:

.. code-block:: php

    <?php

    $router->add(
        "/",
        [
            "controller" => "index",
            "action"     => "index",
        ]
    );

没有找到路径（Not Found Paths）
-------------------------------
If none of the routes specified in the router are matched, you can define a group of paths to be used in this scenario:

.. code-block:: php

    <?php

    // Set 404 paths
    $router->notFound(
        [
            "controller" => "index",
            "action"     => "route404",
        ]
    );

This is typically for an Error 404 page.

设置默认路径（Setting default paths）
-------------------------------------
It's possible to define default values for the module, controller or action. When a route is missing any of
those paths they can be automatically filled by the router:

可以为通用路径中的 module, controller, action 定义默认值。当一个路由缺少其中任何一项时，路由器可以自动用默认值填充：

.. code-block:: php

    <?php

    // Setting a specific default
    $router->setDefaultModule("backend");
    $router->setDefaultNamespace("Backend\\Controllers");
    $router->setDefaultController("index");
    $router->setDefaultAction("index");

    // Using an array
    $router->setDefaults(
        [
            "controller" => "index",
            "action"     => "index",
        ]
    );

处理结尾额外的斜杆（Dealing with extra/trailing slashes）
---------------------------------------------------------
Sometimes a route could be accessed with extra/trailing slashes.
Those extra slashes would lead to produce a not-found status in the dispatcher.
You can set up the router to automatically remove the slashes from the end of handled route:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    $router = new Router();

    // Remove trailing slashes automatically
    $router->removeExtraSlashes(true);

Or, you can modify specific routes to optionally accept trailing slashes:

.. code-block:: php

    <?php

    // The [/]{0,1} allows this route to have optionally have a trailing slash
    $router->add(
        "/{language:[a-z]{2}}/:controller[/]{0,1}",
        [
            "controller" => 2,
            "action"     => "index",
        ]
    );

匹配回调函数（Match Callbacks）
-------------------------------
Sometimes, routes should only be matched if they meet specific conditions.
You can add arbitrary conditions to routes using the :code:`beforeMatch()` callback.
If this function return :code:`false`, the route will be treated as non-matched:

.. code-block:: php

    <?php

    $route = $router->add("/login",
        [
            "module"     => "admin",
            "controller" => "session",
        ]
    );

    $route->beforeMatch(
        function ($uri, $route) {
            // Check if the request was made with Ajax
            if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest") {
                return false;
            }

            return true;
        }
    );

You can re-use these extra conditions in classes:

.. code-block:: php

    <?php

    class AjaxFilter
    {
        public function check()
        {
            return $_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest";
        }
    }

And use this class instead of the anonymous function:

.. code-block:: php

    <?php

    $route = $router->add(
        "/get/info/{id}",
        [
            "controller" => "products",
            "action"     => "info",
        ]
    );

    $route->beforeMatch(
        [
            new AjaxFilter(),
            "check"
        ]
    );

As of Phalcon 3, there is another way to check this:

.. code-block:: php

    <?php

    $route = $router->add(
        "/login",
        [
            "module"     => "admin",
            "controller" => "session",
        ]
    );

    $route->beforeMatch(
        function ($uri, $route) {
            /**
             * @var string $uri
             * @var \Phalcon\Mvc\Router\Route $route
             * @var \Phalcon\DiInterface $this
             * @var \Phalcon\Http\Request $request
             */
            $request = $this->getShared("request");

            // Check if the request was made with Ajax
            return $request->isAjax();
        }
    );

限制主机名（Hostname Constraints）
----------------------------------
The router allows you to set hostname constraints, this means that specific routes or a group of routes can be restricted
to only match if the route also meets the hostname constraint:

.. code-block:: php

    <?php

    $route = $router->add(
        "/login",
        [
            "module"     => "admin",
            "controller" => "session",
            "action"     => "login",
        ]
    );

    $route->setHostName("admin.company.com");

The hostname can also be passed as a regular expressions:

.. code-block:: php

    <?php

    $route = $router->add(
        "/login",
        [
            "module"     => "admin",
            "controller" => "session",
            "action"     => "login",
        ]
    );

    $route->setHostName("([a-z]+).company.com");

In groups of routes you can set up a hostname constraint that apply for every route in the group:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router\Group as RouterGroup;

    // Create a group with a common module and controller
    $blog = new RouterGroup(
        [
            "module"     => "blog",
            "controller" => "posts",
        ]
    );

    // Hostname restriction
    $blog->setHostName("blog.mycompany.com");

    // All the routes start with /blog
    $blog->setPrefix("/blog");

    // Default route
    $blog->add(
        "/",
        [
            "action" => "index",
        ]
    );

    // Add a route to the group
    $blog->add(
        "/save",
        [
            "action" => "save",
        ]
    );

    // Add another route to the group
    $blog->add(
        "/edit/{id}",
        [
            "action" => "edit",
        ]
    );

    // Add the group to the router
    $router->mount($blog);

URI 来源（URI Sources）
-----------------------
By default the URI information is obtained from the :code:`$_GET["_url"]` variable, this is passed by the Rewrite-Engine to
Phalcon, you can also use :code:`$_SERVER["REQUEST_URI"]` if required:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    // ...

    // Use $_GET["_url"] (default)
    $router->setUriSource(
        Router::URI_SOURCE_GET_URL
    );

    // Use $_SERVER["REQUEST_URI"]
    $router->setUriSource(
        Router::URI_SOURCE_SERVER_REQUEST_URI
    );

Or you can manually pass a URI to the :code:`handle()` method:

.. code-block:: php

    <?php

    $router->handle("/some/route/to/handle");

测试路由（Testing your routes）
-------------------------------
Since this component has no dependencies, you can create a file as shown below to test your routes:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    // These routes simulate real URIs
    $testRoutes = [
        "/",
        "/index",
        "/index/index",
        "/index/test",
        "/products",
        "/products/index/",
        "/products/show/101",
    ];

    $router = new Router();

    // Add here your custom routes
    // ...

    // Testing each route
    foreach ($testRoutes as $testRoute) {
        // Handle the route
        $router->handle($testRoute);

        echo "Testing ", $testRoute, "<br>";

        // Check if some route was matched
        if ($router->wasMatched()) {
            echo "Controller: ", $router->getControllerName(), "<br>";
            echo "Action: ", $router->getActionName(), "<br>";
        } else {
            echo "The route wasn't matched by any route<br>";
        }

        echo "<br>";
    }

注解路由（Annotations Router）
------------------------------
这个组件利用集成的注解服务 :doc:`annotations <annotations>` 提供了一个路由定义的变体。通过这个策略，你可以直接在书写控制器
的时候编写路由，而不需要一个一个在服务注册的时候添加。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router\Annotations as RouterAnnotations;

    $di["router"] = function () {
        // Use the annotations router. We're passing false as we don't want the router to add its default patterns
        $router = new RouterAnnotations(false);

        // Read the annotations from ProductsController if the URI starts with /api/products
        $router->addResource("Products", "/api/products");

        return $router;
    };

注解通过如下的方式定义：

.. code-block:: php

    <?php

    /**
     * @RoutePrefix("/api/products")
     */
    class ProductsController
    {
        /**
         * @Get(
         *     "/"
         * )
         */
        public function indexAction()
        {

        }

        /**
         * @Get(
         *     "/edit/{id:[0-9]+}",
         *     name="edit-robot"
         * )
         */
        public function editAction($id)
        {

        }

        /**
         * @Route(
         *     "/save",
         *     methods={"POST", "PUT"},
         *     name="save-robot"
         * )
         */
        public function saveAction()
        {

        }

        /**
         * @Route(
         *     "/delete/{id:[0-9]+}",
         *     methods="DELETE",
         *     conversors={
         *         id="MyConversors::checkId"
         *     }
         * )
         */
        public function deleteAction($id)
        {

        }

        public function infoAction($id)
        {

        }
    }

只有标记了格式正确的注解的方法才能被用作路由。Phalcon支持如下注解：

+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| 名称         | 描述                                                                                              | 用法                                                                       |
+==============+===================================================================================================+============================================================================+
| RoutePrefix  | A prefix to be prepended to each route URI. This annotation must be placed at the class' docblock | :code:`@RoutePrefix("/api/products")`                                      |
+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Route        | This annotation marks a method as a route. This annotation must be placed in a method docblock    | :code:`@Route("/api/products/show")`                                       |
+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Get          | This annotation marks a method as a route restricting the HTTP method to GET                      | :code:`@Get("/api/products/search")`                                       |
+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Post         | This annotation marks a method as a route restricting the HTTP method to POST                     | :code:`@Post("/api/products/save")`                                        |
+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Put          | This annotation marks a method as a route restricting the HTTP method to PUT                      | :code:`@Put("/api/products/save")`                                         |
+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Delete       | This annotation marks a method as a route restricting the HTTP method to DELETE                   | :code:`@Delete("/api/products/delete/{id}")`                               |
+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Options      | This annotation marks a method as a route restricting the HTTP method to OPTIONS                  | :code:`@Option("/api/products/info")`                                      |
+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+

用来添加路由的注解支持如下参数：

+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| 名称         | 描述                                                                                              | 用法                                                                       |
+==============+===================================================================================================+============================================================================+
| methods      | Define one or more HTTP method that route must meet with                                          | :code:`@Route("/api/products", methods={"GET", "POST"})`                   |
+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| name         | Define a name for the route                                                                       | :code:`@Route("/api/products", name="get-products")`                       |
+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| paths        | An array of paths like the one passed to :code:`Phalcon\Mvc\Router::add()`                        | :code:`@Route("/posts/{id}/{slug}", paths={module="backend"})`             |
+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| conversors   | A hash of conversors to be applied to the parameters                                              | :code:`@Route("/posts/{id}/{slug}", conversors={id="MyConversor::getId"})` |
+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+

如果路由对应的控制器属于一个模块，使用 :code:`addModuleResource()` 效果更佳：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router\Annotations as RouterAnnotations;

    $di["router"] = function () {
        // Use the annotations router
        $router = new RouterAnnotations(false);

        // Read the annotations from Backend\Controllers\ProductsController if the URI starts with /api/products
        $router->addModuleResource("backend", "Products", "/api/products");

        return $router;
    };

注册路由实例（Registering Router instance）
-------------------------------------------
You can register router during service registration with Phalcon dependency injector to make it available inside the controllers.

You need to add code below in your bootstrap file (for example index.php or app/config/services.php if you use `Phalcon Developer Tools <http://phalconphp.com/en/download/tools>`_)

.. code-block:: php

    <?php

    /**
     * Add routing capabilities
     */
    $di->set(
        "router",
        function () {
            require __DIR__ . "/../app/config/routes.php";

            return $router;
        }
    );

You need to create app/config/routes.php and add router initialization code, for example:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    $router = new Router();

    $router->add(
        "/login",
        [
            "controller" => "login",
            "action"     => "index",
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

自定义路由（Implementing your own Router）
------------------------------------------
The :doc:`Phalcon\\Mvc\\RouterInterface <../api/Phalcon_Mvc_RouterInterface>` interface must be implemented to create your own router replacing
the one provided by Phalcon.

.. _PCRE regular expressions: http://www.php.net/manual/en/book.pcre.php
