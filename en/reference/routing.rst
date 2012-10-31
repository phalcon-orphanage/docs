Routing
=======
The router component allows defining routes that are mapped to controllers or handlers that should receive
the request. A router simply parses a URI to determine this information. The router has two modes: MVC
mode and match-only mode. The first mode is ideal for working with MVC applications.

Defining Routes
---------------
:doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>` provides advanced routing capabilities. In MVC mode,
you can define routes and map them to controllers/actions that you require. A route is defined as follows:

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

The method add() receives as first parameter a pattern and optionally a set of paths as second parameter.
In this case if the URI is exactly: /admin/users/my-profile, then the "users" controller with its action "profile"
will be executed. Currently, the router does not execute the controller and action, it only collects this
information to inform the correct component (ie. :doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>`)
that this is controller/action it should to execute.

An application can have many paths, define routes one by one can be a cumbersome task. In these cases we can
create more flexible routes:

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

In the example above, using wildcards we make a route valid for many URIs. For example, by accessing the
following URL (/admin/users/a/delete/dave/301) then:

+------------+---------------+
| Controller | users         |
+------------+---------------+
| Action     | delete        |
+------------+---------------+
| Parameter  | dave          |
+------------+---------------+
| Parameter  | 301           |
+------------+---------------+

The method add() receives a pattern that optionally could have predefined placeholders and regular expression
modifiers. All the routing patterns must start with a slash character (/). The regular expression syntax used
is the same as the `PCRE regular expressions`_. Note that, it is not necessary to add regular expression
delimiters. All routes patterns are case-insensitive.

The second parameter defines how the matched parts should bind to the controller/action/parameters. Matching
parts are placeholders or subpatterns delimited by parentheses (round brackets). In the above example, the
first subpattern matched (:controller) is the controller part of the route, the second the action and so on.

These placeholders help writing regular expressions that are more readable for developers and easier
to understand. The following placeholders are supported:

+--------------+--------------------+--------------------------------------------------------------------+
| Placeholder  | Regular Expression | Usage                                                              |
+==============+====================+====================================================================+
| /:module     | /([a-zA-Z0-9\_]+)  | Matches a valid module name with alpha-numeric characters only     |
+--------------+--------------------+--------------------------------------------------------------------+
| /:controller | /([a-zA-Z0-9\_]+)  | Matches a valid controller name with alpha-numeric characters only |
+--------------+--------------------+--------------------------------------------------------------------+
| /:action     | /([a-zA-Z0-9\_]+)  | Matches a valid action name with alpha-numeric characters only     |
+--------------+--------------------+--------------------------------------------------------------------+
| /:params     | (/.*)*             | Matches a list of optional words separated by slashes              |
+--------------+--------------------+--------------------------------------------------------------------+

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

.. _PCRE regular expressions: http://www.php.net/manual/en/book.pcre.php



