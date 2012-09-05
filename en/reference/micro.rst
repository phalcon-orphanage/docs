Micro Applications
==================
With Phalcon you can create "Micro-Framework like" applications. By doing this, you only need to write a minimal amount of code to create a PHP application. Micro applications are very suitable to create small applications, apis, prototypes in a practical and comfortable way.

Creating a Micro Application
----------------------------
:doc:`Phalcon\\Mvc\\Micro <../api/Phalcon_Mvc_Micro>` is the class responsible for coordinating the implementation of micro applications.

.. code-block:: php

    <?php

    $app = new Phalcon\Mvc\Micro();

Defining routes
---------------
The next step is add some routes to the application. Routing is internally managed by :doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>`. Routes must always start with /. We could add a HTTP method constraint to a route, this means that the route will only be matched if the HTTP method with what the request was made is the same. The following example shows how to define a route for the method GET:

.. code-block:: php

    <?php

    $app->get('/say/hello/{name}', function ($name) {
        echo "<h1>Hello! $name</h1>";
    });

The "get" method indicates that the associated HTTP method is GET. The route /say/hello/{name} also have a parameter {$name} that is passed directly to the route handler. Handlers are executed when a route is matched. A handler could be any callable thing in the PHP userland. The following examples shows how to defined different types of handlers:

.. code-block:: php

    <?php

    //With a function
    function say_hello($name) {
        echo "<h1>Hello! $name</h1>";
    }

    $app->get('/say/hello/{name}', "say_hello");

    //With a static method
    $app->get('/say/hello/{name}', "SomeClass::someSayMethod");

    //With a method in an object
    $myController = new MyController();
    $app->get('/say/hello/{name}', array($this, "myController"));

    //Anonymous function
    $app->get('/say/hello/{name}', function ($name) {
        echo "<h1>Hello! $name</h1>";
    });

Routes with Parameters
^^^^^^^^^^^^^^^^^^^^^^
Define parameters in routes as easy as we saw. We only must enclose the parameter name in brackets. We can force the parameter has a format based on a regular expression and so be sure that the data has the correct data type.

.. code-block:: php

    <?php

    $app->get('/posts/{year:[0-9]+}/{title:[a-zA-Z\-]+}', function ($year, $title) {
        echo "<h1>Title: $title</h1>";
        echo "<h2>Year: $year</h2>";
    });

Start Route
^^^^^^^^^^^
Normally, the start route in your application will the / route. And, it usually is accessed by method GET. This is how you can define the default route in your application:

.. code-block:: php

    <?php

    $app->get('/', function () {
        echo "<h1>Welcome!</h1>";
    });

.. code-block:: php

    <?php

    $app->post('/store/something', function () use ($app) {

        $name = $app->request->getPost('name');

        echo "<h1>Hello! $name</h1>";

    });

Not-Found Handler
-----------------
When a user access a route that isn't defined the micro application will try to execute the "Not-Found" handler. You can define it as follows:

.. code-block:: php

    <?php

    $app->notFound(function () use ($app) {
        $app->response->setStatusCode(404, "Not Found")->sendHeaders();
        echo 'This is crazy, but this page was not found!';
    });
