Micro Applications
==================
With Phalcon you can create "Micro-Framework like" applications. By doing this, you only need to write a minimal amount of code to create a PHP application. Micro applications are suitable to small applications, APIs and prototypes in a practical way.

Creating a Micro Application
----------------------------
:doc:`Phalcon\\Mvc\\Micro <../api/Phalcon_Mvc_Micro>` is the class responsible for implementing a micro application.

.. code-block:: php

    <?php

    $app = new Phalcon\Mvc\Micro();

Defining routes
---------------
After instantiating the object, you will need to add some routes. Routing is internally managed by :doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>`. Routes must always start with /. A HTTP method constraint to a route can be added, so as to instruct the route to match only the requests matched to the HTTP methods. The following example shows how to define a route for the method GET:

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

Routes with Parameters
^^^^^^^^^^^^^^^^^^^^^^
Defining parameters in routes as very easy as demonstrated above. The parameter name has to be enclosed in brackets. Parameter formatting is also available using regular expressions to ensure consistency of data. This is demonstrated in the example below:

.. code-block:: php

    <?php

    $app->get('/posts/{year:[0-9]+}/{title:[a-zA-Z\-]+}', function ($year, $title) {
        echo "<h1>Title: $title</h1>";
        echo "<h2>Year: $year</h2>";
    });

Starting Route
^^^^^^^^^^^^^^
Normally, the starting route in an application will be the / route, and it will more frequent than not be accessed by the method GET. This scenario is coded as follows:

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
When a user tries to access a route that is not defined, the micro application will try to execute the "Not-Found" handler. An example of that behavior is below:

.. code-block:: php

    <?php

    $app->notFound(function () use ($app) {
        $app->response->setStatusCode(404, "Not Found")->sendHeaders();
        echo 'This is crazy, but this page was not found!';
    });
