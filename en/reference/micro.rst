Micro Applications
==================
With Phalcon you can create "Micro-Framework like" applications. By doing this, you only need to write a minimal amount of code to create a
PHP application. Micro applications are suitable to small applications, APIs and prototypes in a practical way.

.. code-block:: php

    <?php

    $app = new Phalcon\Mvc\Micro();

    $app->get('/say/welcome/{name}', function ($name) {
        echo "<h1>Welcome $name!</h1>";
    });

    $app->handle();

Creating a Micro Application
----------------------------
:doc:`Phalcon\\Mvc\\Micro <../api/Phalcon_Mvc_Micro>` is the class responsible for implementing a micro application.

.. code-block:: php

    <?php

    $app = new Phalcon\Mvc\Micro();

Defining routes
---------------
After instantiating the object, you will need to add some routes. Routing is internally managed by :doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>`.
Routes must always start with /. A HTTP method constraint to a route can be added, so as to instruct the route to match only the requests matched to the HTTP methods. The following example shows how to define a route for the method GET:

.. code-block:: php

    <?php

    $app->get('/say/hello/{name}', function ($name) {
        echo "<h1>Hello! $name</h1>";
    });

The "get" method indicates that the associated HTTP method is GET. The route /say/hello/{name} also has a parameter {$name} that is passed directly to the route handler. Handlers are executed when a route is matched. A handler could be any callable item in the PHP userland. The following example shows how to defined different types of handlers:

.. code-block:: php

    <?php

    // With a function
    function say_hello($name) {
        echo "<h1>Hello! $name</h1>";
    }

    $app->get('/say/hello/{name}', "say_hello");

    // With a static method
    $app->get('/say/hello/{name}', "SomeClass::someSayMethod");

    // With a method in an object
    $myController = new MyController();
    $app->get('/say/hello/{name}', array($this, "myController"));

    //Anonymous function
    $app->get('/say/hello/{name}', function ($name) {
        echo "<h1>Hello! $name</h1>";
    });

:doc:`Phalcon\\Mvc\\Micro <../api/Phalcon_Mvc_Micro>` provides a set of methods to define the HTTP method (or methods) which the route is constrained for:

.. code-block:: php

    <?php

    //Matches if the HTTP method is GET
    $app->get('/api/products', "get_products");

    //Matches if the HTTP method is POST
    $app->post('/api/products/add', "add_product");

    //Matches if the HTTP method is PUT
    $app->put('/api/products/update/{id}', "update_product");

    //Matches if the HTTP method is DELETE
    $app->put('/api/products/remove/{id}', "delete_product");

    //Matches if the HTTP method is OPTIONS
    $app->options('/api/products/info/{id}', "info_product");

    //Matches if the HTTP method is GET or POST
    $app->map('/repos/store/refs')->via(array('GET', 'POST'));


Routes with Parameters
^^^^^^^^^^^^^^^^^^^^^^
Defining parameters in routes as very easy as demonstrated above. The parameter name has to be enclosed in brackets. Parameter formatting is also available using regular expressions to ensure consistency of data. This is demonstrated in the example below:

.. code-block:: php

    <?php

    //This route have two parameters and each of them have a format
    $app->get('/posts/{year:[0-9]+}/{title:[a-zA-Z\-]+}', function ($year, $title) {
        echo "<h1>Title: $title</h1>";
        echo "<h2>Year: $year</h2>";
    });

Starting Route
^^^^^^^^^^^^^^
Normally, the starting route in an application will be the / route, and it will more frequent than not be accessed by the method GET. This scenario is coded as follows:

.. code-block:: php

    <?php

    //This is the start route
    $app->get('/', function () {
        echo "<h1>Welcome!</h1>";
    });

Rewrite Rules
^^^^^^^^^^^^^
The following rules can be used together with Apache to rewrite the URis:

.. code-block:: apacheconf

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

Working with Responses
----------------------
You are free to produce any kind of responses in a handler: directly make an output, use a template engine, include a view, return a json, etc.:

.. code-block:: php

    <?php

    //Direct output
    $app->get('/say/hello', function () {
        echo "<h1>Hello! $name</h1>";
    });

    //Requiring another file
    $app->get('/show/results', function () {
        require 'views/results.php';
    });

    //Returning a JSON
    $app->get('/get/some-json', function () {
        echo json_encode(array("some", "important", "data"));
    });

In addition to that, you have access to the service :doc:`"response" <response>`, with which you can manipulate better the response:

.. code-block:: php

    <?php

    $app->get('/show/data', function () use ($app) {

        //Set the Content-Type header
        $app->response->setContentType('text/plain')->sendHeaders();

        //Print a file
        readfile("data.txt");

    });

Making redirections
-------------------
Redirections could be performed to forward the execution flow to another route:

.. code-block:: php

    <?php

    //This route makes a redirection to another route
    $app->post('/old/welcome', function () use ($app) {
        $app->response->redirect("new/welcome");
    });

    $app->post('/new/welcome', function () use ($app) {
        echo 'This is the new Welcome';
    });

Generating URLs for Routes
--------------------------
:doc:`Phalcon\\Mvc\\Url <url>` can be used to produce URLs based on the defined routes. You need to set up a name for the route, by this way the "url" service can produce the corresponding URL:

.. code-block:: php

    <?php

    //Set a route with the name "show-post"
    $app->get('/blog/{year}/{title}', function ($year, $title) use ($app) {

        //.. show the post here

    })->setName('show-post');

    //produce a url somewhere
    $app->get('/', function() use ($app){

        echo $app->url->get(array(
            'for' => 'show-post',
            'title' => 'php-is-a-great-framework',
            'year' => 2012
        ));

    });


Interacting with the Dependency Injector
----------------------------------------
In the micro application, a :doc:`Phalcon\\DI\\FactoryDefault <di>` services container is created implicitly, additionally you can create outside of the application a container to
manipulate its services:

.. code-block:: php

    <?php

    $di = new \Phalcon\DI\FactoryDefault();

    $di->set('config', function() {
        return new \Phalcon\Config\Adapter\Ini("config.ini");
    });

    $app = new Phalcon\Mvc\Micro();

    $app->setDI($di);

    $app->get('/', function () use ($app) {
        //Read a setting from the config
        echo $app->config->app_name;
    });

    $app->post('/contact', function () use ($app) {
        $app->flash->success('Yes!, the contact was made!');
    });


Not-Found Handler
-----------------
When a user tries to access a route that is not defined, the micro application will try to execute the "Not-Found" handler. An example of that behavior is below:

.. code-block:: php

    <?php

    $app->notFound(function () use ($app) {
        $app->response->setStatusCode(404, "Not Found")->sendHeaders();
        echo 'This is crazy, but this page was not found!';
    });

Models in Micro Applications
----------------------------
:doc:`Models <models>` can be used transparently in Micro Applications, only is required an autoloader to load models:

.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();

    $loader->registerDirs(array(
        __DIR__.'/models/'
    ))->register();

    $app = new \Phalcon\Mvc\Micro();

    $app->get('/products/find', function(){

        foreach (Products::find() as $product) {
            echo $product->name, '<br>';
        }

    });

    $app->handle();

Micro Application Events
------------------------
:doc:`Phalcon\\Mvc\\Micro <../api/Phalcon_Mvc_Micro>` is able to send events to the :doc:`EventsManager <events>` (if it is present). Events are triggered using the type "micro". The following events are supported:

+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| Event Name          | Triggered                                                                                                                  | Can stop operation?  |
+=====================+============================================================================================================================+======================+
| beforeHandleRoute   | The main method is just called, at this point the application don't know if there is some matched route                    | Yes                  |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| beforeExecuteRoute  | A route has been matched and it contains a valid handler, at this point the handler has not been executed                  | Yes                  |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| afterExecuteRoute   | Triggered after running the handler                                                                                        | No                   |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| beforeNotFound      | Triggered when any of the defined routes match the requested URI                                                           | Yes                  |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| afterHandleRoute    | Triggered after completing the whole process in a successful way                                                           | Yes                  |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+

In the following example, we explain how to control the application security using events:

.. code-block:: php

    <?php

    //Create a events manager
    $eventManager = \Phalcon\Events\Manager();

    //Listen all the application events
    $eventManager->attach('micro', function($event, $app) {

        if ($event->getType() == 'beforeExecuteRoute') {
            if ($app->session->get('auth') == false) {
                $app->flashSession->error("The user isn't authenticated");
                $app->response->redirect("/");
            }
        }

    });

    $app = new Phalcon\Mvc\Micro();

    //Bind the events manager to the app
    $app->setEventsManager($eventsManager);

