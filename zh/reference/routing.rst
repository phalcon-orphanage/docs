路由器(Routing)
=============================
router组件允许定义用户请求对应到哪个控制器或Action。router解析 URI 以确定这些信息。路由器有两种模式：MVC模式和匹配模式(match-only)。第一种模式是使用MVC应用程序的理想选择。

Defining Routes
---------------
:doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>` 提供了一套先进的路由功能。在MVC模式中，你可以自定义路由规则，对应到你需要的 controllers/actions 上。路由的定义如下：

.. code-block:: php

    <?php

    // Create the router
    $router = new \Phalcon\Mvc\Router();

    //Define a route
    $router->add(
        "/admin/users/my-profile",
        array(
            "controller" => "users",
            "action"     => "profile",
        )
    );

    //Another route
    $router->add(
        "/admin/users/change-password",
        array(
            "controller" => "users",
            "action"     => "changePassword",
        )
    );

    $router->handle();

add() 方法接收两个参数，第一个参数是一个匹配字符串，第二个参数为一组可选的路径。在这种情况下，URI  /admin/users/my-profile， "users"代表控制器，"profile"代表Ation。目前，该路由器不并不执行控制器和Action,只为组件(如： :doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>`) 收集信息，然后由分发器决定是否立即执行。

应用程序可能有很多个不同的路径，如果一个一个的定义路由的话，会非常麻烦。在这种情况下，我们可以使用更灵活的方式创建route：

.. code-block:: php

    <?php

    // Create the router
    $router = new \Phalcon\Mvc\Router();

    //Define a route
    $router->add(
        "/admin/:controller/a/:action/:params",
        array(
            "controller" => 1,
            "action"     => 2,
            "params"     => 3,
        )
    );

在上面的例子中，我们使用通配符来匹配路由。例如，通过访问URL (/admin/users/a/delete/dave/301) ，解析为：

+------------+---------------+
| Controller | users         |
+------------+---------------+
| Action     | delete        |
+------------+---------------+
| Parameter  | dave          |
+------------+---------------+
| Parameter  | 301           |
+------------+---------------+

add()方法接收一个模式，可选择使用预定义占位符和正则表达式修饰符。所有的路由模式必须以斜线字符（/）开始。正则表达式语法使用与 `PCRE regular expressions`_ 相同的语法。需要注意的是，不必要添加正则表达式分隔符。所有的路由模式是不区分大小写的。

第二个参数定义了如何将匹配部分绑定到controller/action/parameters。匹配部分是占位符或团圆括号中的子模式。另外，在上述的例子中，第一个子模式匹配(:controller)，是route中控制器部分，第二个是action，等。

这些占位符使用正则表达式，更易读，更容易为开发人员理解。支持以下占位符：

+--------------+---------------------+--------------------------------------------------------------------+
| Placeholder  | Regular Expression  | Usage                                                              |
+==============+=====================+====================================================================+
| /:module     | /([a-zA-Z0-9\_\-]+) | Matches a valid module name with alpha-numeric characters only     |
+--------------+---------------------+--------------------------------------------------------------------+
| /:controller | /([a-zA-Z0-9\_\-]+) | Matches a valid controller name with alpha-numeric characters only |
+--------------+---------------------+--------------------------------------------------------------------+
| /:action     | /([a-zA-Z0-9\_]+)   | Matches a valid action name with alpha-numeric characters only     |
+--------------+---------------------+--------------------------------------------------------------------+
| /:params     | (/.*)*              | Matches a list of optional words separated by slashes              |
+--------------+---------------------+--------------------------------------------------------------------+
| /:namespace  | /([a-zA-Z0-9\_\-]+) | Matches a single level namespace name                              |
+--------------+---------------------+--------------------------------------------------------------------+
| /:int        | /([0-9]+)           | Matches an integer parameter                                       |
+--------------+---------------------+--------------------------------------------------------------------+

控制器名称采用驼峰书写规则，这意味着，字符 (-) 和 (_)将被移除，同时把下一个字符转化为大写字符。比如，some_controller被转化为SomeController。

Since you can add many routes as you need using add(), the order in which you add the routes indicates
their relevance, last routes added have more relevance than first added. Internally, all defined routes
are traversed in reverse order until :doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>` finds the
one that matches the given URI and processes it, while ignoring the rest.

Parameters with Names
^^^^^^^^^^^^^^^^^^^^^
The example below demonstrates how to define names to route parameters:

.. code-block:: php

    <?php

    $router->add(
        "/news/([0-9]{4})/([0-9]{2})/([0-9]{2})/:params",
        array(
        	"controller" => "posts",
        	"action"     => "show",
        	"year"       => 1, // ([0-9]{4})
        	"month"      => 2, // ([0-9]{2})
        	"day"        => 3, // ([0-9]{2})
        	"params"     => 4, // :params
        )
    );

In the above example, the route doesn't define a "controller" or "action" part. These parts are replaced
with fixed values ("posts" and "show"). The user will not know the controller that is really dispatched
by the request. Inside the controller, those named parameters can be accessed as follows:

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function showAction()
        {

            // Return "year" parameter
            $year = $this->dispatcher->getParam("year");

            // Return "month" parameter
            $month = $this->dispatcher->getParam("month");

            // Return "day" parameter
            $day = $this->dispatcher->getParam("day");

        }

    }

Note that the values ​​of the parameters are obtained from the dispatcher. This happens because it is the
component that finally interacts with the drivers of your application. Moreover, there is also another
way to create named parameters as part of the pattern:

.. code-block:: php

    <?php

    $router->add(
        "/documentation/{chapter}/{name}.{type:[a-z]+}",
        array(
            "controller" => "documentation",
            "action"     => "show"
        )
    );

You can access their values ​​in the same way as before:

.. code-block:: php

    <?php

    class DocumentationController extends \Phalcon\Mvc\Controller
    {

        public function showAction()
        {

            // Returns "name" parameter
            $year = $this->dispatcher->getParam("name");

            // Returns "type" parameter
            $year = $this->dispatcher->getParam("type");

        }

    }

Short Syntax
^^^^^^^^^^^^
If you don't like using an array to define the route paths, an alternative syntax is also available.
The following examples produce the same result:

.. code-block:: php

    <?php

    // Short form
    $router->add("/posts/{year:[0-9]+}/{title:[a-z\-]+}", "Posts::show");

    // Array form:
    $router->add(
        "/posts/([0-9]+)/([a-z\-]+)",
        array(
           "controller" => "posts",
           "action"     => "show",
           "year"       => 1,
           "title"      => 2,
        )
    );

Mixing Array and Short Syntax
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Array and short syntax can be mixed to define a route, in this case note that named parameters automatically
are added to the route paths according to the position on which they were defined:

.. code-block:: php

    <?php

    //First position must be skipped because it is used for
    //the named parameter 'country'
    $router->add('/news/{country:[a-z]{2}}/([a-z+])/([a-z\-+])',
        array(
            'section' => 2, //Positions start with 2
            'article' => 3
        )
    );

Routing to Modules
^^^^^^^^^^^^^^^^^^
You can define routes whose paths include modules. This is specially suitable to multi-module applications.
It's possible define a default route that includes a module wildcard:

.. code-block:: php

    <?php

    $router = new Phalcon\Mvc\Router(false);

    $router->add('/:module/:controller/:action/:params', array(
        'module' => 1,
        'controller' => 2,
        'action' => 3,
        'params' => 4
    ));

In this case, the route always must have the module name as part of the URL. For example, the following
URL: /admin/users/edit/sonny, will be processed as:

+------------+---------------+
| Module     | admin         |
+------------+---------------+
| Controller | users         |
+------------+---------------+
| Action     | edit          |
+------------+---------------+
| Parameter  | sonny         |
+------------+---------------+

Or you can bind specific routes to specific modules:

.. code-block:: php

    <?php

    $router->add("/login", array(
        'module' => 'backend',
        'controller' => 'login',
        'action' => 'index',
    ));

    $router->add("/products/:action", array(
        'module' => 'frontend',
        'controller' => 'products',
        'action' => 1,
    ));

Or bind them to specific namespaces:

.. code-block:: php

    <?php

    $router->add("/:namespace/login", array(
        'namespace' => 1,
        'controller' => 'login',
        'action' => 'index'
    ));

A controller can also be a full class name:

.. code-block:: php

    <?php

    $router->add("/login", array(
        'controller' => 'Backend\Controllers\Login',
        'action' => 'index'
    ));

HTTP Method Restrictions
^^^^^^^^^^^^^^^^^^^^^^^^
When you add a route using simply add(), the route will be enabled for any HTTP method. Sometimes we can restrict a route to a specific method,
this is especially useful when creating RESTful applications:

.. code-block:: php

    <?php

    // This route only will be matched if the HTTP method is GET
    $router->addGet("/products/edit/{id}", "Posts::edit");

    // This route only will be matched if the HTTP method is POST
    $router->addPost("/products/save", "Posts::save");

    // This route will be matched if the HTTP method is POST or PUT
    $router->add("/products/update")->via(array("POST", "PUT"));

Matching Routes
---------------
Now we must a URI to Router in order that it check which is the defined route that matches the given URI.
By default, the routing URI is taken from the $_GET['_url'] variable that is created by the rewrite engine
module. A couple of rewrite rules that work very well with Phalcon are:

.. code-block:: apacheconf

    RewriteEngine On
    RewriteCond   %{REQUEST_FILENAME} !-d
    RewriteCond   %{REQUEST_FILENAME} !-f
    RewriteRule   ^(.*)$ index.php?_url=/$1 [QSA,L]

The following example shows how to use this component:

.. code-block:: php

    <?php

    // Creating a router
    $router = new \Phalcon\Mvc\Router();

    // Define routes here if any
    // ...

    // Taking URI from $_GET["_url"]
    $router->handle();

    // or Setting the URI value directly
    $router->handle("/employees/edit/17");

    // Getting the processed controller
    echo $router->getControllerName();

    // Getting the processed action
    echo $router->getActionName();

    //Get the matched route
    $route = $router->getMatchedRoute();

Naming Routes
-------------
Each route that is added to the router is stored internally as an object :doc:`Phalcon\\Mvc\\Router\\Route <../api/Phalcon_Mvc_Router_Route>`.
That class encapsulates all the details of each route. For instance, we can give a name to a path to identify it uniquely in our application.
This is especially useful if you want to create URLs from it.

.. code-block:: php

    <?php

    $route = $router->add("/posts/{year}/{title}", "Posts::show");

    $route->setName("show-posts");

    //or just

    $router->add("/posts/{year}/{title}", "Posts::show")->setName("show-posts");

Then, using for example the component :doc:`Phalcon\\Mvc\\Url <../api/Phalcon_Mvc_Url>` we can build routes from its name:

.. code-block:: php

    <?php

    // returns /posts/2012/phalcon-1-0-released
    $url->get(array("for" => "show-posts", "year" => "2012", "title" => "phalcon-1-0-released"));

Usage Examples
--------------
The following are examples of custom routes:

.. code-block:: php

    <?php

    // matches "/system/admin/a/edit/7001"
    $router->add(
        "/system/:controller/a/:action/:params",
        array(
            "controller" => 1,
            "action"     => 2,
            "params"     => 3,
        )
    );

    // matches "/es/news"
    $router->add(
        "/([a-z]{2})/:controller",
        array(
            "controller" => 2,
            "action"     => "index",
            "language"   => 1,
        )
    );

    // matches "/es/news"
    $router->add(
        "/{language:[a-z]{2}}/:controller",
        array(
            "controller" => 2,
            "action"     => "index",
        )
    );

    // matches "/admin/posts/edit/100"
    $router->add(
        "/admin/:controller/:action/:int",
        array(
            "controller" => 1,
            "action"     => 2,
            "id"         => 3,
        )
    );

    // matches "/posts/2010/02/some-cool-content"
    $router->add(
        "/posts/([0-9]{4})/([0-9]{2})/([a-z\-]+)",
        array(
            "controller" => "posts",
            "action"     => "show",
            "year"       => 1,
            "month"      => 2,
            "title"      => 4,
        )
    );

    // matches "/manual/en/translate.adapter.html"
    $router->add(
        "/manual/([a-z]{2})/([a-z\.]+)\.html",
        array(
            "controller" => "manual",
            "action"     => "show",
            "language"   => 1,
            "file"       => 2,
        )
    );

    // matches /feed/fr/le-robots-hot-news.atom
    $router->add(
        "/feed/{lang:[a-z]+}/{blog:[a-z\-]+}\.{type:[a-z\-]+}",
        "Feed::get"
    );

.. highlights::
    Beware of characters allowed in regular expression for controllers and namespaces. As these
    become class names and in turn pass through the file system could be used by attackers to
    read unauthorized files. A safe regular expression is: /([a-zA-Z0-9\_\-]+)

Default Behavior
----------------
:doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>` has a default behavior providing a very simple routing that
always expects a URI that matches the following pattern: /:controller/:action/:params

For example, for a URL like this *http://phalconphp.com/documentation/show/about.html*, this router will translate it as follows:

+------------+---------------+
| Controller | documentation |
+------------+---------------+
| Action     | show          |
+------------+---------------+
| Parameter  | about.html    |
+------------+---------------+

If you don't want use this routes as default in your application, you must create the router passing false as parameter:

.. code-block:: php

    <?php

    // Create the router without default routes
    $router = new \Phalcon\Mvc\Router(false);

Setting default paths
---------------------
It's possible to define default values for common paths like module, controller or action. When a route is missing any of
those paths the component could automatically fill it:

.. code-block:: php

    <?php

    //Individually
    $router->setDefaultController("index");
    $router->setDefaultAction("index");

    //Using an array
    $router->setDefaults(array(
        "controller" => "index",
        "action" => "index"
    ));

Testing your routes
-------------------
Since this component has no dependencies, you can create a file as shown below to test your routes:

.. code-block:: php

    <?php

    //These routes simulate real URIs
    $testRoutes = array(
        '/',
        '/index',
        '/index/index',
        '/index/test',
        '/products',
        '/products/index/',
        '/products/show/101',
    );

    $router = new Phalcon\Mvc\Router();

    //Add here your custom routes

    //Testing each route
    foreach ($testRoutes as $testRoute) {

        //Handle the route
        $router->handle($testRoute);

        echo 'Testing ', $testRoute, '<br>';

        //Check if some route was matched
        if ($router->wasMatched()) {
            echo 'Controller: ', $router->getControllerName(), '<br>';
            echo 'Action: ', $router->getActionName(), '<br>';
        } else {
            echo 'The route wasn\'t matched by any route<br>';
        }
        echo '<br>';

    }

Implementing your own Router
----------------------------
The :doc:`Phalcon\\Mvc\\RouterInterface <../api/Phalcon_Mvc_RouterInterface>` interface must be implemented to create your own router replacing the one providing by Phalcon.

.. _PCRE regular expressions: http://www.php.net/manual/en/book.pcre.php

