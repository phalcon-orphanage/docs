Routing
=======
A router parses a URI to determine which controller, and action of that controller should receive the request. 

Default Behavior
----------------
Phalcon uses by default the :doc:`Phalcon_Router_Rewrite <../api/Phalcon_Router_Rewrite>` router. When a :doc:`Phalcon_Controller_Front <../api/Phalcon_Controller_Front>` is used as bootstrap, a router of this kind is automatically instantiated inside it. :doc:`Phalcon_Router_Rewrite <../api/Phalcon_Router_Rewrite>` is a very simple router that always expects a URI that matchex the following pattern: /:controller/:action/:params 

For example, for a URL like this *http://phalconphp.com/documentation/show/about.html*, this router will translate it as follows: 

+------------+---------------+
| Controller | documentation | 
+------------+---------------+
| Action     | show          | 
+------------+---------------+
| Parameter  | about.html    | 
+------------+---------------+

The routing URI is always taken from the $_GET['_url'] variable that is created by the rewrite engine module. A couple of rewrite rules that work very well with Phalcon are: 

.. code-block:: apacheconf

    RewriteEngine On
    RewriteCond   %{REQUEST_FILENAME} !-d
    RewriteCond   %{REQUEST_FILENAME} !-f
    RewriteRule   ^(.*)$ index.php?_url=$1 [QSA,L]

It is also possible to replace the behavior by setting this value directly to :doc:`Phalcon_Router_Rewrite <../api/Phalcon_Router_Rewrite>`:

.. code-block:: php

    <?php
    
    // Creating a router
    $router = new Phalcon_Router_Rewrite();
    
    // Taking URI from $_GET["_url"]
    $router->handle();
    
    // or Setting the URI value directly
    $router->handle("/doc/a/v");
    
    // Getting the processed controller
    echo $router->getControllerName();

:doc:`Phalcon_Router_Rewrite <../api/Phalcon_Router_Rewrite>` is a simple and fast component and its use is highly recommended, since it offers the lowest overhead while parsing the routes of your application. 

Advanced Routing
----------------
Phalcon provides advanced routing capabilities by replacing the default router with :doc:`Phalcon_Router_Regex <../api/Phalcon_Router_Regex>`. When :doc:`Phalcon_Router_Regex <../api/Phalcon_Router_Regex>` is used together with Apache, it's necessary to prepend a slash / to the beginning of the rewrite subexpression ($1) to handle the URIs correctly: 

.. code-block:: apacheconf

    RewriteEngine On
    RewriteCond   %{REQUEST_FILENAME} !-d
    RewriteCond   %{REQUEST_FILENAME} !-f
    RewriteRule   ^(.*)$ index.php?_url=/$1 [QSA,L]

This router allows you to add many routes as you need. A route is defined as follows:

.. code-block:: php

    <?php
    
    // Create the router
    $router = new Phalcon_Router_Regex();
    
    $router->add(
        "/admin/:controller/a/:action/:params", 
        array(
            "controller" => 1,
            "action"     => 2,
            "params"     => 3,
        )
    );

The method add() receives a pattern that optionally could have predefined placeholders and regular expression modifiers. All the routing patterns must start with a slash character (/). The regular expression syntax used is the same as the `PCRE regular expressions`_. Note that, it is not necessary to add regular expression delimiters. All routes patterns are case-insensitive. 

The second parameter defines how the matches parts should bind to the controller/action/parameters. Matching parts are placeholders or subpatterns delimited by parentheses (round brackets). In the above example, the first subpattern matched (:controller) is the controller part of the route, the second the action and so on. 

These placeholders help writing regular expressions that are more readable for developers and easier to understand. The following placeholders are supported: 

+--------------+--------------------+------------------------------------------------------------------+
| Placeholder  | Regular Expression | Usage                                                            | 
+==============+====================+==================================================================+
| /:controller | /([a-zA-Z0-9\_]+)  | Match a valid controller name with alpha-numeric characters only | 
+--------------+--------------------+------------------------------------------------------------------+
| /:action     | /([a-zA-Z0-9\_]+)  | Match a valid action name with alpha-numeric characters only     | 
+--------------+--------------------+------------------------------------------------------------------+
| /:params     | (/.*)*             | Match a list of optional words separated by slashes              | 
+--------------+--------------------+------------------------------------------------------------------+

Since you can add many routes as you need using add(), the order in which you add the routes indicates their relevance. Internally, all defined routes are traversed until :doc:`Phalcon_Router_Regex <../api/Phalcon_Router_Regex>` finds the one that matches the given URI and processes it, while ignoring the rest. 

By default, if a route does not match any defined route, the fallback route is: ^/:controller/:action/:params, effectively switching the behavior to the one of :doc:`Phalcon_Router_Rewrite <../api/Phalcon_Router_Rewrite>`. 

In addition to the standard route parts (controller/action/params), :doc:`Phalcon_Router_Regex <../api/Phalcon_Router_Regex>` also allows the definition of parameters based on the route pattern. The example below demonstrates how to define names to route parameters: 

.. code-block:: php

    <?php

    $router->add(
        "/news/([0-9]{4})/([0-9]{2})/([0-9]{2})/:params", 
        array(
        	"controller" => "posts",
        	"action"     => "show",
        	"year"       => 1,
        	"month"      => 2,
        	"day"        => 3,
        	"params"     => 4,
        )
    );

In the above example, the route doesn't define a "controller" or "action" part. These parts are replaced with fixed values ("posts" and "show"). The user will not know the controller that is really dispatched by the request. Inside the controller, those named parameters can be accessed as follows: 

.. code-block:: php

    <?php
    
    class PostsController extends Phalcon_Controller
    {
    
        function indexAction()
        {

        }

        function showAction()
        {

            // Return "year" parameter
            $year = $this->_getParam("year");

            // Return "month" parameter
            $month = $this->_getParam("month");

            // Return "day" parameter
            $day = $this->_getParam("day");

        }
    
    }

Short Syntax
^^^^^^^^^^^^^^^^
If you don't like using an array to define the route paths, an alternative syntax is also available. The following examples produce the same result:

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

Examples
^^^^^^^^
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


Replacing Controller-Front Router
---------------------------------
If you are using the :doc:`Phalcon_Controller_Front <../api/Phalcon_Controller_Front>` to create the MVC control flow, you could replace the default router to define custom routes or alter its standard behavior: 

.. code-block:: php

    <?php
    
    try {
    
        $front = Phalcon_Controller_Front::getInstance();
    
        $router = new Phalcon_Router_Regex();
    
        $router->add(
            "/login", 
            array(
                "controller" => "users",
                "action"     => "login"
            )
        );
    
        $router->add(
            "/profile", 
            array(
                "controller" => "users",
                "action"     => "profile"
            )
        );
    
        $router->handle();
    
        $front->setRouter($router);
    
        $config = new Phalcon_Config_Adapter_Ini("/../app/config/config.ini");
        $front->setConfig($config);
    
        echo $front->dispatchLoop()->getContent();
    
    } catch(Phalcon_Exception $e) {
        echo "PhalconException: ", $e->getMessage();
    }

You could also define your routes in a separate file and include it in the bootstrap for better organization. 

.. _PCRE regular expressions: http://www.php.net/manual/en/book.pcre.php



