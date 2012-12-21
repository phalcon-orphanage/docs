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

在上述的例子中，该路由并没有定义"controller" 和 "action"部分。这两部分被固定值("posts" 和 "show")取代。用户并不知道使用的是哪个控制器。在控制器内部，可以通过以下方式访问这些参数：

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

请注意，上述示例中传递的参数是使用dispatcher获取的。此外，也有另一种方法来创建命名参数作为模式的一部分：

.. code-block:: php

    <?php

    $router->add(
        "/documentation/{chapter}/{name}.{type:[a-z]+}",
        array(
            "controller" => "documentation",
            "action"     => "show"
        )
    );

你可以按上面的例子一样的方式获取他们的值：

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
如果你不喜欢使用一个数组的形式来定义路由，可以使用另一种语法。下面的示例产生相同的结果：

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
你可以在路由定义中包含module，这适合多个module的应用程序。定义路由也可以使用缺省设置：

.. code-block:: php

    <?php

    $router = new Phalcon\Mvc\Router(false);

    $router->add('/:module/:controller/:action/:params', array(
        'module' => 1,
        'controller' => 2,
        'action' => 3,
        'params' => 4
    ));

在这种情况下，URL部分必须包含module的名称。例如，下面的URL：/admin/users/edit/sonny,将被解析为：

+------------+---------------+
| Module     | admin         |
+------------+---------------+
| Controller | users         |
+------------+---------------+
| Action     | edit          |
+------------+---------------+
| Parameter  | sonny         |
+------------+---------------+

或者，你也可以绑定特定的module到路由上：

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

也可绑定到特定的命名空间上：

.. code-block:: php

    <?php

    $router->add("/:namespace/login", array(
        'namespace' => 1,
        'controller' => 'login',
        'action' => 'index'
    ));

controller也可指定全称：

.. code-block:: php

    <?php

    $router->add("/login", array(
        'controller' => 'Backend\Controllers\Login',
        'action' => 'index'
    ));

HTTP Method Restrictions
^^^^^^^^^^^^^^^^^^^^^^^^
当你使用add()方法添加一个路由时，该路由将应用到所有HTTP方法上。有时候，我们想要限制到一个特定的HTTP方法，比如创建一个RESTful的应用程序时：

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
现在，我们需要定义一个路由，以检查定义的路由是否匹配给定的URL。默认情况下，路由的URI可以通过 $_GET['url'] 这个变量获得，Phalcon可以使用下列URL重写规则很好的工作：

.. code-block:: apacheconf

    RewriteEngine On
    RewriteCond   %{REQUEST_FILENAME} !-d
    RewriteCond   %{REQUEST_FILENAME} !-f
    RewriteRule   ^(.*)$ index.php?_url=/$1 [QSA,L]

下面的示例将展示如果使用此组件：

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
每个被添加的路由都存储到对象 :doc:`Phalcon\\Mvc\\Router\\Route <../api/Phalcon_Mvc_Router_Route>` 中，这个类封装了路由的细节。例如，我们可以给应用程序中的路由设置一个唯一的名称。如果你想创建URLs,这将非常有用。

.. code-block:: php

    <?php

    $route = $router->add("/posts/{year}/{title}", "Posts::show");

    $route->setName("show-posts");

    //or just

    $router->add("/posts/{year}/{title}", "Posts::show")->setName("show-posts");

然后，我们可以使用 :doc:`Phalcon\\Mvc\\Url <../api/Phalcon_Mvc_Url>` 组件通过路由的名称创建一个路由：

.. code-block:: php

    <?php

    // returns /posts/2012/phalcon-1-0-released
    $url->get(array("for" => "show-posts", "year" => "2012", "title" => "phalcon-1-0-released"));

用法示例
--------------
下面是自定义路由的例子：

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
    请注意，因为控制器和命名空间允许使用正规表达式，因此，一些攻击都可能会反过来推导出文件系统中未经授权的文件。一个安全的正则表达式： /([a-zA-Z0-9\_\-]+)

Default Behavior
----------------
:doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>` 有一个默认提供了一个非常简单的路由，总是匹配这样的模式：/:controller/:action/:params 。

例如，对于URL *http://phalconphp.com/documentation/show/about.html* ，路由将按如下方式解析：

+------------+---------------+
| Controller | documentation |
+------------+---------------+
| Action     | show          |
+------------+---------------+
| Parameter  | about.html    |
+------------+---------------+

如果你不想在应用程序中使用路由的默认行为，你可以创建一个路由，并把false参数传递给它：

.. code-block:: php

    <?php

    // Create the router without default routes
    $router = new \Phalcon\Mvc\Router(false);

Setting default paths
---------------------
你可以对module,controller,action设置默认值，当在路由中找不到路径时，它将自动填充它：

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

译者注：比如一个单module的站点，URL：http://site/，其中没有controller和action，那么默认它将访问 http://site/index/index

Testing your routes
-------------------
由于此组件不存在依赖关系，你可以创建一个文件来测试你的路由，如下所示：

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
Phalcon 还提供了 :doc:`Phalcon\\Mvc\\RouterInterface <../api/Phalcon_Mvc_RouterInterface>` 接口用来实现自定义路由。

.. _PCRE regular expressions: http://www.php.net/manual/en/book.pcre.php

