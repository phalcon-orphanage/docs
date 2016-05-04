Tutorial 7: Creating a Simple REST API
======================================

In this tutorial, we will explain how to create a simple application that provides a RESTful_ API using the
different HTTP methods:

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
As the application is so simple, we will not implement any full MVC environment to develop it. In this case,
we will use a :doc:`micro application <micro>` to meet our goal.

The following file structure is more than enough:

.. code-block:: php

    my-rest-api/
        models/
            Robots.php
        index.php
        .htaccess

First, we need an .htaccess file that contains all the rules to rewrite the URIs to the index.php file,
that is our application:

.. code-block:: apacheconf

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

Then, in the index.php file we create the following:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;

    $app = new Micro();

    // Define the routes here

    $app->handle();

Now we will create the routes as we defined above:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;

    $app = new Micro();

    // Retrieves all robots
    $app->get('/api/robots', function () {

    });

    // Searches for robots with $name in their name
    $app->get('/api/robots/search/{name}', function ($name) {

    });

    // Retrieves robots based on primary key
    $app->get('/api/robots/{id:[0-9]+}', function ($id) {

    });

    // Adds a new robot
    $app->post('/api/robots', function () {

    });

    // Updates robots based on primary key
    $app->put('/api/robots/{id:[0-9]+}', function () {

    });

    // Deletes robots based on primary key
    $app->delete('/api/robots/{id:[0-9]+}', function () {

    });

    $app->handle();

Each route is defined with a method with the same name as the HTTP method, as first parameter we pass a route pattern,
followed by a handler. In this case, the handler is an anonymous function. The following route: :code:`'/api/robots/{id:[0-9]+}'`,
by example, explicitly sets that the "id" parameter must have a numeric format.

When a defined route matches the requested URI then the application executes the corresponding handler.

Creating a Model
----------------
Our API provides information about 'robots', these data are stored in a database. The following model allows us to
access that table in an object-oriented way. We have implemented some business rules using built-in validators
and simple validations. Doing this will give us the peace of mind that saved data meet the requirements of our
application:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;
    use Phalcon\Mvc\Model\Message;
    use Phalcon\Mvc\Model\Validator\Uniqueness;
    use Phalcon\Mvc\Model\Validator\InclusionIn;

    class Robots extends Model
    {
        public function validation()
        {
            // Type must be: droid, mechanical or virtual
            $this->validate(
                new InclusionIn(
                    array(
                        "field"  => "type",
                        "domain" => array(
                            "droid",
                            "mechanical",
                            "virtual"
                        )
                    )
                )
            );

            // Robot name must be unique
            $this->validate(
                new Uniqueness(
                    array(
                        "field"   => "name",
                        "message" => "The robot name must be unique"
                    )
                )
            );

            // Year cannot be less than zero
            if ($this->year < 0) {
                $this->appendMessage(new Message("The year cannot be less than zero"));
            }

            // Check if any messages have been produced
            if ($this->validationHasFailed() == true) {
                return false;
            }
        }
    }

Now, we must set up a connection to be used by this model and load it within our app:

.. code-block:: php

    <?php

    use Phalcon\Loader;
    use Phalcon\Mvc\Micro;
    use Phalcon\Di\FactoryDefault;
    use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

    // Use Loader() to autoload our model
    $loader = new Loader();

    $loader->registerDirs(
        array(
            __DIR__ . '/models/'
        )
    )->register();

    $di = new FactoryDefault();

    // Set up the database service
    $di->set('db', function () {
        return new PdoMysql(
            array(
                "host"     => "localhost",
                "username" => "asimov",
                "password" => "zeroth",
                "dbname"   => "robotics"
            )
        );
    });

    // Create and bind the DI to the application
    $app = new Micro($di);

Retrieving Data
---------------
The first "handler" that we will implement is which by method GET returns all available robots. Let's use PHQL to
perform this simple query returning the results as JSON:

.. code-block:: php

    <?php

    // Retrieves all robots
    $app->get('/api/robots', function () use ($app) {

        $phql = "SELECT * FROM Robots ORDER BY name";
        $robots = $app->modelsManager->executeQuery($phql);

        $data = array();
        foreach ($robots as $robot) {
            $data[] = array(
                'id'   => $robot->id,
                'name' => $robot->name
            );
        }

        echo json_encode($data);
    });

:doc:`PHQL <phql>`, allow us to write queries using a high-level, object-oriented SQL dialect that internally
translates to the right SQL statements depending on the database system we are using. The clause "use" in the
anonymous function allows us to pass some variables from the global to local scope easily.

The searching by name handler would look like:

.. code-block:: php

    <?php

    // Searches for robots with $name in their name
    $app->get('/api/robots/search/{name}', function ($name) use ($app) {

        $phql = "SELECT * FROM Robots WHERE name LIKE :name: ORDER BY name";
        $robots = $app->modelsManager->executeQuery(
            $phql,
            array(
                'name' => '%' . $name . '%'
            )
        );

        $data = array();
        foreach ($robots as $robot) {
            $data[] = array(
                'id'   => $robot->id,
                'name' => $robot->name
            );
        }

        echo json_encode($data);
    });

Searching by the field "id" it's quite similar, in this case, we're also notifying if the robot was found or not:

.. code-block:: php

    <?php

    use Phalcon\Http\Response;

    // Retrieves robots based on primary key
    $app->get('/api/robots/{id:[0-9]+}', function ($id) use ($app) {

        $phql = "SELECT * FROM Robots WHERE id = :id:";
        $robot = $app->modelsManager->executeQuery($phql, array(
            'id' => $id
        ))->getFirst();

        // Create a response
        $response = new Response();

        if ($robot == false) {
            $response->setJsonContent(
                array(
                    'status' => 'NOT-FOUND'
                )
            );
        } else {
            $response->setJsonContent(
                array(
                    'status' => 'FOUND',
                    'data'   => array(
                        'id'   => $robot->id,
                        'name' => $robot->name
                    )
                )
            );
        }

        return $response;
    });

Inserting Data
--------------
Taking the data as a JSON string inserted in the body of the request, we also use PHQL for insertion:

.. code-block:: php

    <?php

    use Phalcon\Http\Response;

    // Adds a new robot
    $app->post('/api/robots', function () use ($app) {

        $robot = $app->request->getJsonRawBody();

        $phql = "INSERT INTO Robots (name, type, year) VALUES (:name:, :type:, :year:)";

        $status = $app->modelsManager->executeQuery($phql, array(
            'name' => $robot->name,
            'type' => $robot->type,
            'year' => $robot->year
        ));

        // Create a response
        $response = new Response();

        // Check if the insertion was successful
        if ($status->success() == true) {

            // Change the HTTP status
            $response->setStatusCode(201, "Created");

            $robot->id = $status->getModel()->id;

            $response->setJsonContent(
                array(
                    'status' => 'OK',
                    'data'   => $robot
                )
            );

        } else {

            // Change the HTTP status
            $response->setStatusCode(409, "Conflict");

            // Send errors to the client
            $errors = array();
            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(
                array(
                    'status'   => 'ERROR',
                    'messages' => $errors
                )
            );
        }

        return $response;
    });

Updating Data
-------------
The data update is similar to insertion. The "id" passed as parameter indicates what robot must be updated:

.. code-block:: php

    <?php

    use Phalcon\Http\Response;

    // Updates robots based on primary key
    $app->put('/api/robots/{id:[0-9]+}', function ($id) use ($app) {

        $robot = $app->request->getJsonRawBody();

        $phql = "UPDATE Robots SET name = :name:, type = :type:, year = :year: WHERE id = :id:";
        $status = $app->modelsManager->executeQuery($phql, array(
            'id' => $id,
            'name' => $robot->name,
            'type' => $robot->type,
            'year' => $robot->year
        ));

        // Create a response
        $response = new Response();

        // Check if the insertion was successful
        if ($status->success() == true) {
            $response->setJsonContent(
                array(
                    'status' => 'OK'
                )
            );
        } else {

            // Change the HTTP status
            $response->setStatusCode(409, "Conflict");

            $errors = array();
            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(
                array(
                    'status'   => 'ERROR',
                    'messages' => $errors
                )
            );
        }

        return $response;
    });

Deleting Data
-------------
The data delete is similar to update. The "id" passed as parameter indicates what robot must be deleted:

.. code-block:: php

    <?php

    use Phalcon\Http\Response;

    // Deletes robots based on primary key
    $app->delete('/api/robots/{id:[0-9]+}', function ($id) use ($app) {

        $phql = "DELETE FROM Robots WHERE id = :id:";
        $status = $app->modelsManager->executeQuery($phql, array(
            'id' => $id
        ));

        // Create a response
        $response = new Response();

        if ($status->success() == true) {
            $response->setJsonContent(
                array(
                    'status' => 'OK'
                )
            );
        } else {

            // Change the HTTP status
            $response->setStatusCode(409, "Conflict");

            $errors = array();
            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(
                array(
                    'status'   => 'ERROR',
                    'messages' => $errors
                )
            );
        }

        return $response;
    });

Testing our Application
-----------------------
Using curl_ we'll test every route in our application verifying its proper operation.

Obtain all the robots:

.. code-block:: bash

    curl -i -X GET http://localhost/my-rest-api/api/robots

    HTTP/1.1 200 OK
    Date: Tue, 21 Jul 2015 07:05:13 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 117
    Content-Type: text/html; charset=UTF-8

    [{"id":"1","name":"Robotina"},{"id":"2","name":"Astro Boy"},{"id":"3","name":"Terminator"}]

Search a robot by its name:

.. code-block:: bash

    curl -i -X GET http://localhost/my-rest-api/api/robots/search/Astro

    HTTP/1.1 200 OK
    Date: Tue, 21 Jul 2015 07:09:23 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 31
    Content-Type: text/html; charset=UTF-8

    [{"id":"2","name":"Astro Boy"}]

Obtain a robot by its id:

.. code-block:: bash

    curl -i -X GET http://localhost/my-rest-api/api/robots/3

    HTTP/1.1 200 OK
    Date: Tue, 21 Jul 2015 07:12:18 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 56
    Content-Type: text/html; charset=UTF-8

    {"status":"FOUND","data":{"id":"3","name":"Terminator"}}

Insert a new robot:

.. code-block:: bash

    curl -i -X POST -d '{"name":"C-3PO","type":"droid","year":1977}'
        http://localhost/my-rest-api/api/robots

    HTTP/1.1 201 Created
    Date: Tue, 21 Jul 2015 07:15:09 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 75
    Content-Type: text/html; charset=UTF-8

    {"status":"OK","data":{"name":"C-3PO","type":"droid","year":1977,"id":"4"}}

Try to insert a new robot with the name of an existing robot:

.. code-block:: bash

    curl -i -X POST -d '{"name":"C-3PO","type":"droid","year":1977}'
        http://localhost/my-rest-api/api/robots

    HTTP/1.1 409 Conflict
    Date: Tue, 21 Jul 2015 07:18:28 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 63
    Content-Type: text/html; charset=UTF-8

    {"status":"ERROR","messages":["The robot name must be unique"]}

Or update a robot with an unknown type:

.. code-block:: bash

    curl -i -X PUT -d '{"name":"ASIMO","type":"humanoid","year":2000}'
        http://localhost/my-rest-api/api/robots/4

    HTTP/1.1 409 Conflict
    Date: Tue, 21 Jul 2015 08:48:01 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 104
    Content-Type: text/html; charset=UTF-8

    {"status":"ERROR","messages":["Value of field 'type' must be part of
        list: droid, mechanical, virtual"]}

Finally, delete a robot:

.. code-block:: bash

    curl -i -X DELETE http://localhost/my-rest-api/api/robots/4

    HTTP/1.1 200 OK
    Date: Tue, 21 Jul 2015 08:49:29 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 15
    Content-Type: text/html; charset=UTF-8

    {"status":"OK"}

Conclusion
----------
As we have seen, develop a RESTful API with Phalcon is easy. Later in the documentation we'll explain in detail how to
use micro applications and the :doc:`PHQL <phql>` language.

.. _curl: http://en.wikipedia.org/wiki/CURL
.. _RESTful: http://en.wikipedia.org/wiki/Representational_state_transfer
