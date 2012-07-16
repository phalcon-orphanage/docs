

Routing
=======
A router recognizes a URI and decompose it into parameters to determine which controller, andaction of that controller should receive the request. 

Default Behavior
----------------
Phalcon uses by default the router.When a  is used as bootstrap,a router of this kind is automatically instantiated inside it. Router_Rewrite is a very simple router that always expects a URI that match the following pattern:/:controller/:action/:params. For example, for a URL like this  *http://phalconphp.com/documentation/show/about.html* ,this router will decompose it as follows: The routing URI is always taken from the $_GET['_url'] variable that is created by the rewrite engine module.A couple of rewrite rules that work fine with Phalcon are: 

.. code-block:: php

    <?php

    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ index.php?_url=$1 [QSA,L]

Also, it's possible to replace this behavior by setting directly this value to Phalcon_Router_Rewrite:

.. code-block:: php

    <?php
    
    //Creating a router
    $router = new Phalcon_Router_Rewrite();
    
    //Taking URI from $_GET["_url"]
    $router->handle();
    
    //or Setting the URI value directly
    $router->handle("/doc/a/v");
    
    //Getting the processed controller
    echo $router->getControllerName();

This router is faster and simpler, it will provide you the lower overhead recognizing uris in yourapplications. 

Advanced Routing
----------------
Phalcon provides advanced routing capabilities by replacing the default router by arouter.When Phalcon_Router_Regex is used together with Apache, it's necessary to prepend a slash / to thebeginning of the rewrite subexpression ($1) to handle correctly the URIs: 

.. code-block:: php

    <?php

    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ index.php?_url=/$1 [QSA,L]

This router allow you to add many routes as you need. A route is defined in the following way:

.. code-block:: php

    <?php
    
    //Creating a router
    $router = new Phalcon_Router_Regex();
    
    $router->add("/admin/:controller/a/:action/:params", array(
        "controller" => 1,
        "action" => 2,
        "params" => 3,
    ));

The method add() receives a pattern that optionally could have predefined placeholders and regular expressionmodifiers. All the routing patterns must start with a slash character (/). The regular expression syntax used is the same as  `PCRE regular expressions <http://www.php.net/manual/en/book.pcre.php>`_ .Note that, it is not necessary to add regular expression delimiters, also all routes patterns are case-insensitive. The second parameter define how the matches parts should be binded to the controller/action/parameters.Matching parts are placeholders or subpatterns delimited by parentheses (round brackets). In the above example, the first subpattern matched (:controller) is the controller part of the route, the second the action and so on. The placeholders help writing regular expressions that are more readable. The following placeholdersare supported by default: You can add many routes as you need using add(), the order in which you add the routes indicate its relevance.Internally all defined routes are traversed until Router_Regex finds one that matches the given uri and then the others will be discarded. By default, if a route does not match any defined route, a fallback route will be tried: ^/:controller/:action/:params$giving to the router a similar behavior as Router_Rewrite. In addition to the standard routes parts (controller/action/params), with Router_Regex is possible to defineparameters based on the routes patterns. The below example shows how to give names to some of the parameters of the route: 

.. code-block:: php

    <?php

    $router->add("/news/([0-9]{4})/([0-9]{2})/([0-9]{2})/:params", array(
    	"controller" => "posts",
    	"action" => "show",
    	"year" => 1,
    	"month" => 2,
    	"day" => 3,
    	"params" => 4,
    ));

As you can see, the route doesn't define a "controller" or "action" part. Then, we are setting theseparts with fixed values ("posts" and "show"). The user will not know the controller that is really dispatched by the request. Inside the controller, those named-params could be easily accesed as follows: 

.. code-block:: php

    <?php
    
    class PostsController extends Phalcon_Controller
    {
    
      function indexAction()
      {
    
      }
    
      function showAction()
      {
    
        //Return "year" parameter
        $year = $this->_getParam("year");
    
        //Return "month" parameter
        $month = $this->_getParam("month");
    
        //Return "day" parameter
        $day = $this->_getParam("day");
    
      }
    
    }



Shortened Syntax
^^^^^^^^^^^^^^^^
You are not forced to use array as route paths as the alternative syntax is available,any of the following two forms are equivalent: 

.. code-block:: php

    <?php

    //Shortened form
    $router->add("/posts/{year:[0-9]+}/{title:[a-z\-]+}", "Posts::show");
    
    //Array form:
    $router->add("/posts/([0-9]+)/([a-z\-]+)", array(
    	"controller" => "posts",
    	"action" => "show",
    	"year" => 1,
    	"title" => 2
    ));



Examples
^^^^^^^^
The following are examples of custom routes:

.. code-block:: php

    <?php

    //matches "/system/admin/a/edit/7001"
    $router->add("/system/:controller/a/:action/:params", array(
        "controller" => 1,
        "action" => 2,
        "params" => 3,
    ));
    
    //matches "/es/news"
    $router->add("/([a-z]{2})/:controller", array(
        "controller" => 2,
        "action" => "index",
        "language" => 1
    ));
    
    //matches "/admin/posts/edit/100"
    $router->add("/admin/:controller/:action/:int", array(
        "controller" => 1,
        "action" => 2,
        "id" => 3
    ));
    
    //matches "/posts/2010/02/some-cool-content"
    $router->add("/posts/([0-9]{4})/([0-9]{2})/([a-z\-]+)", array(
        "controller" => "posts",
        "action" => "show",
        "year" => 1,
        "month" => 2,
        "title" => 4,
    ));
    
    //matches "/manual/en/translate.adapter.html"
    $router->add("/manual/([a-z]{2})/([a-z\.]+)\.html", array(
        "controller" => "manual",
        "action" => "show",
        "language" => 1,
        "file" => 2
    ));
    
    //matches /feed/fr/le-robots-hot-news.atom
    $router->add("/feed/{lang:[a-z]+}/{blog:[a-z\-]+}\.{type:[a-z\-]+}", "Feed::get");



Replacing Controller-Front Router
---------------------------------
If you are using the to orquestthe MVC control flow, you could replace the default router to define custom routes or alter its standard behavior: 

.. code-block:: php

    <?php
    
    try {
    
        $front = Phalcon_Controller_Front::getInstance();
    
        $router = new Phalcon_Router_Regex();
    
        $router->add("/login", array(
            "controller" => "users",
            "action" => "login"
        ));
    
        $router->add("/profile", array(
            "controller" => "users",
            "action" => "profile"
        ));
    
        $router->handle();
    
        $front->setRouter($router);
    
        $config = new Phalcon_Config_Adapter_Ini("/../app/config/config.ini");
        $front->setConfig($config);
    
        echo $front->dispatchLoop()->getContent();
    
    } catch(Phalcon_Exception $e) {
        echo "PhalconException: ", $e->getMessage();
    }

Also, to organize better your routes code could be placed in an external file toinclude in the bootstrap. 