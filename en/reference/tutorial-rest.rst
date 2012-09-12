Tutorial 3: Creating a Simple REST API
======================================
In this tutorial, we explain how to create a simple application that provides a RESTful_ API using the different HTTP methods:

* GET to retrieve and search data
* POST to add data
* PUT to update data
* DELETE to delete data

Defining the API
----------------

The API consists of the following methods:

+--------+----------------------------+----------------------------------------------------------+
| Method |  URL                       | Action                                                   |
+========+============================+==========================================================+
| GET    | /api/robots                | Retrieves all robots                                     |
+--------+----------------------------+----------------------------------------------------------+
| GET    | /api/robots/search/Astro   | Searches for robots with ‘Astro’ in their name           |
+--------+----------------------------+----------------------------------------------------------+
| GET    | /api/robots/2              | Retrieves robots based on primary key                    |
+--------+----------------------------+----------------------------------------------------------+
| POST   | /api/robots                | Adds a new robot                                         |
+--------+----------------------------+----------------------------------------------------------+
| PUT    | /api/robots/2              | Updates robots based on primary key                      |
+--------+----------------------------+----------------------------------------------------------+
| DELETE | /api/robots/2              | Deletes robots based on primary key                      |
+--------+----------------------------+----------------------------------------------------------+

Creating the Application
------------------------
As the application is so simple, we will not implement any full MVC environment to develop it. In this case, we use a :doc:`micro application <micro>` to meet our goal.

The following file structure is more than enough:

.. code-block:: php

    my-rest-api/
        models/
            Robots.php
        index.php
        .htaccess

First, we need an .htaccess file that contains all the rules to rewrite the URIs to the index.php file, that is our application:

.. code-block:: apacheconf

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

Then, in the index.php file we create the following:

.. code-block:: php

    <?php

    $app = new \Phalcon\Mvc\Micro();

    //define the routes here

    $app->handle();

Now we will create the routes as we defined above:

.. code-block:: php

    <?php

    $app = new Phalcon\Mvc\Micro();

    //Retrieves all robots
    $app->get('/api/robots', function() {

    });

    //Searches for robots with $name in their name
    $app->get('/api/robots/search/{name}', function($name) {

    });

    //Retrieves robots based on primary key
    $app->get('/api/robots/{id:[0-9]+}', function($id) {

    });

    //Adds a new robot
    $app->post('/api/robots', function() {

    });

    //Updates robots based on primary key
    $app->put('/api/robots/{id:[0-9]+}', function() {

    });

    //Deletes robots based on primary key
    $app->delete('/api/robots/{id:[0-9]+}', function() {

    });

    $app->handle();

Each route is defined with a method with the same name as the HTTP method, as first parameter we pass a route pattern, followed by a handler. In this case
the handler is an anonymous function. The following route: '/api/robots/{id:[0-9]+}', by example, explicitly set that the "id" parameter must have a numeric format.

When a defined route matches the requested URI then the application will execute the corresponding handler.

Creating a Model
----------------
Our API provides information about robots, these data are stored in a database. The following model allows us to access that table in an object oriented way:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

    }

Now, we must set up a connection to be used by this model:

.. code-block:: php

    <?php

    $di = new \Phalcon\DI\FactoryDefault();

    //Set up the database service
    $di->set('db', function(){
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => "localhost",
            "username" => "asimov",
            "password" => "zeroth",
            "dbname" => "robotics"
        ));
    });

    $app = new \Phalcon\Mvc\Micro();

    //Bind the DI to the application
    $app->setDI($di);

Retrieving Data
---------------
The first "handler" that we will implement is which by method GET returns all available robots. Let's use PHQL to perform this simple query returning the results as JSON:

.. code-block:: php

    <?php

    //Retrieves all robots
    $app->get('/api/robots', function() use ($app) {

        $phql = "SELECT * FROM Robots ORDER BY name";
        $robots = $app->modelsManager->executeQuery($phql);

        $data = array();
        foreach($robots as $robot){
            $data[] = array(
                'id' => $robot->id,
                'name' => $robot->name,
            );
        }

        echo json_encode($data);

    });

:doc:`PHQL <phql>`, allow us to write queries using a high level, object oriented SQL dialect that internally
translates to the right SQL statements depending on the database system we are using. The clause "use" in the anonymous function allows
 us to pass variables from global to local scope easily.

The searching by name handler would look like:

.. code-block:: php

    <?php

    //Searches for robots with $name in their name
    $app->get('/api/robots/search/{name}', function($name) use ($app) {

        $phql = "SELECT * FROM Robots WHERE name LIKE :name: ORDER BY name";
        $robots = $app->modelsManager->executeQuery($phql, array(
            'name' => '%'.$name.'%'
        ));

        $data = array();
        foreach($robots as $robot){
            $data[] = array(
                'id' => $robot->id,
                'name' => $robot->name,
            );
        }

        echo json_encode($data);

    });

Searching by the field "id" it's quite similar, in this case, we're also notifying if the robot was found or not:

.. code-block:: php

    <?php

    //Retrieves robots based on primary key
    $app->get('/api/robots/{id:[0-9]+}', function($id) use ($app) {

        $phql = "SELECT * FROM Robots WHERE id = :id:";
        $robot = $app->modelsManager->executeQuery($phql, array(
            'id' => $id
        ))->getFirst();

        if ($robot==false) {
            $response = array('status' => 'NOT-FOUND');
        } else {
            $response = array(
                'status' => 'FOUND',
                'data' => array(
                    'id' => $robot->id,
                    'name' => $robot->name
                )
            );
        }

        echo json_encode($response);
    });

Inserting Data
--------------




.. _RESTful : http://en.wikipedia.org/wiki/Representational_state_transfer