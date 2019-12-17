---
layout: default
language: 'it-it'
version: '4.0'
title: 'Tutorial - REST'
keywords: 'tutorial, rest tutorial, api, rest, step by step, micro'
---

# Tutorial - REST
<hr />
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview
The `REST API` application is an application that shows how you can create a [RESTful](https://en.wikipedia.org/wiki/Representational_state_transfer) API utilizing Phalcon. In this tutorial, we will use the [Micro](application-micro) application. We will also utilize \[Phinx\]\[phinx\] for our database migrations, \[JSON Web Tokens (JWT)\]\[jwt\] for authentication as well as \[JSON API\]\[jsonapi\] for the structured responses.

## Installation
## Structure
## Installation
## Dependencies
The application needs a minimum of PHP 7.2 and the following extensions available:
- curl
- json
- iconv
- igbinary
- mbstring
- memcached
- opcache
- pdo
- pdo_mysql
- phalcon
- session
- zip

The remaining dependencies for the project are installed using composer.

## Providers
Setting up the


## Controllers
## Models
## Routes

| Method | Description                                                                       |
|:------:| --------------------------------------------------------------------------------- |
| `GET`  | `/companies/`                                                                     |
| `GET`  | `/companies/`                                                                     |
| `POST` | `/companies/`                                                                     |
| `GET`  | `/companies/{recordId:[0-9]+}']`                                                  |
| `GET`  | `/companies/{recordId:[0-9]+}/{relationships:[a-zA-Z-,.]+}']`                     |
| `GET`  | `/companies/{recordId:[0-9]+}/relationships/{relationships:[a-zA-Z-,.]+}'`        |
| `GET`  | `/individuals/`                                                                   |
| `GET`  | `/individuals/{recordId:[0-9]+}']`                                                |
| `GET`  | `/individuals/{recordId:[0-9]+}/{relationships:[a-zA-Z-,.]+}']`                   |
| `GET`  | `/individuals/{recordId:[0-9]+}/relationships/{relationships:[a-zA-Z-,.]+}'`      |
| `GET`  | `/individual-types/`                                                              |
| `GET`  | `/individual-types/{recordId:[0-9]+}']`                                           |
| `GET`  | `/individual-types/{recordId:[0-9]+}/{relationships:[a-zA-Z-,.]+}']`              |
| `GET`  | `/individual-types/{recordId:[0-9]+}/relationships/{relationships:[a-zA-Z-,.]+}'` |
| `GET`  | `/products/`                                                                      |
| `GET`  | `/products/{recordId:[0-9]+}']`                                                   |
| `GET`  | `/products/{recordId:[0-9]+}/{relationships:[a-zA-Z-,.]+}']`                      |
| `GET`  | `/products/{recordId:[0-9]+}/relationships/{relationships:[a-zA-Z-,.]+}'`         |
| `GET`  | `/product-types/`                                                                 |
| `GET`  | `/product-types/{recordId:[0-9]+}']`                                              |
| `GET`  | `/product-types/{recordId:[0-9]+}/{relationships:[a-zA-Z-,.]+}']`                 |
| `GET`  | `/product-types/{recordId:[0-9]+}/relationships/{relationships:[a-zA-Z-,.]+}'`    |

## Middleware
### 404
### Authentication
### Tokens
### Verification
### Validation
### Response

## CLI




In this tutorial, we will explain how to create a simple application that provides a [RESTful](https://en.wikipedia.org/wiki/Representational_state_transfer) API using the different HTTP methods:

* `GET` to retrieve and search data
* `POST` to add data
* `PUT` to update data
* `DELETE` to delete data

## Defining the API
The API consists of the following methods:

| Method   | URL                      | Action                                         |
| -------- | ------------------------ | ---------------------------------------------- |
| `GET`    | /api/robots              | Retrieves all robots                           |
| `GET`    | /api/robots/search/Astro | Searches for robots with 'Astro' in their name |
| `GET`    | /api/robots/2            | Retrieves robots based on primary key          |
| `POST`   | /api/robots              | Adds a new robot                               |
| `PUT`    | /api/robots/2            | Updates robots based on primary key            |
| `DELETE` | /api/robots/2            | Deletes robots based on primary key            |

## Creating the Application
As the application is so simple, we will not implement any full MVC environment to develop it. In this case, we will use a [micro application](application-micro) to meet our goal.

The following file structure is more than enough:

```php
my-rest-api/
    models/
        Robots.php
    index.php
    .htaccess
```

First, we need a `.htaccess` file that contains all the rules to rewrite the request URIs to the `index.php` file (application entry-point):

```apacheconfig
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
</IfModule>
```

The bulk of our code will be placed in `index.php`. The file is created as follows:

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

// Define the routes here

$app->handle(
    $_SERVER["REQUEST_URI"]
);
```

Now we will create the routes as we defined above:

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

// Retrieves all robots
$app->get(
    '/api/robots',
    function () {
        // Operation to fetch all the robots
    }
);

// Searches for robots with $name in their name
$app->get(
    '/api/robots/search/{name}',
    function ($name) {
        // Operation to fetch robot with name $name
    }
);

// Retrieves robots based on primary key
$app->get(
    '/api/robots/{id:[0-9]+}',
    function ($id) {
        // Operation to fetch robot with id $id
    }
);

// Adds a new robot
$app->post(
    '/api/robots',
    function () {
        // Operation to create a fresh robot
    }
);

// Updates robots based on primary key
$app->put(
    '/api/robots/{id:[0-9]+}',
    function ($id) {
        // Operation to update a robot with id $id
    }
);

// Deletes robots based on primary key
$app->delete(
    '/api/robots/{id:[0-9]+}',
    function ($id) {
        // Operation to delete the robot with id $id
    }
);

$app->handle(
    $_SERVER["REQUEST_URI"]
);
```

Each route is defined with a method with the same name as the HTTP method, as first parameter we pass a route pattern, followed by a handler. In this case, the handler is an anonymous function. The following route: `/api/robots/{id:[0-9]+}`, by example, explicitly sets that the `id` parameter must have a numeric format.

When a defined route matches the requested URI then the application executes the corresponding handler.

## Creating a Model
Our API provides information about `robots`, these data are stored in a database. The following model allows us to access that table in an object-oriented way. We have implemented some business rules using built-in validators and simple validations. Doing this will give us the peace of mind that saved data meet the requirements of our application. This model file should be placed in your `Models` folder.

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\InclusionIn;

class Robots extends Model
{
    public function validation()
    {
        $validator = new Validation();

        // Type must be: droid, mechanical or virtual
        $validator->add(
            "type",
            new InclusionIn(
                [
                    'message' => 'Type must be "droid", "mechanical", or "virtual"',
                    'domain' => [
                        'droid',
                        'mechanical',
                        'virtual',
                    ],
                ]
            )
        );

        // Robot name must be unique
        $validator->add(
            'name',
            new Uniqueness(
                [
                    'field'   => 'name',
                    'message' => 'The robot name must be unique',
                ]
            )
        );

        // Year cannot be less than zero
        if ($this->year < 0) {
            $this->appendMessage(
                new Message('The year cannot be less than zero')
            );
        }

        // Check if any messages have been produced
        if ($this->validationHasFailed() === true) {
            return false;
        }
    }
}
```

Now, we must set up a connection to be used by this model and load it within our app `index.php`:

```php
<?php

use Phalcon\Loader;
use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

// Use Loader() to autoload our model
$loader = new Loader();

$loader->registerNamespaces(
    [
        'Store\Toys' => __DIR__ . '/models/',
    ]
);

$loader->register();

$di = new FactoryDefault();

// Set up the database service
$di->set(
    'db',
    function () {
        return new PdoMysql(
            [
                'host'     => 'localhost',
                'username' => 'asimov',
                'password' => 'zeroth',
                'dbname'   => 'robotics',
            ]
        );
    }
);

// Create and bind the DI to the application
$app = new Micro($di);
```

## Retrieving Data
The first `handler` that we will implement is which by method GET returns all available robots. Let's use PHQL to perform this simple query returning the results as JSON. `index.php`

```php
<?php

// Retrieves all robots
$app->get(
    '/api/robots',
    function () use ($app) {
        $phql = 'SELECT * FROM Store\Toys\Robots ORDER BY name';

        $robots = $app->modelsManager->executeQuery($phql);

        $data = [];

        foreach ($robots as $robot) {
            $data[] = [
                'id'   => $robot->id,
                'name' => $robot->name,
            ];
        }

        echo json_encode($data);
    }
);
```

[PHQL](db-phql), allow us to write queries using a high-level, object-oriented SQL dialect that internally translates to the right SQL statements depending on the database system we are using. The clause `use` in the anonymous function allows us to pass some variables from the global to local scope easily.

The searching by name handler would look like `index.php`:

```php
<?php

// Searches for robots with $name in their name
$app->get(
    '/api/robots/search/{name}',
    function ($name) use ($app) {
        $phql = 'SELECT * FROM Store\Toys\Robots WHERE name LIKE :name: ORDER BY name';

        $robots = $app->modelsManager->executeQuery(
            $phql,
            [
                'name' => '%' . $name . '%'
            ]
        );

        $data = [];

        foreach ($robots as $robot) {
            $data[] = [
                'id'   => $robot->id,
                'name' => $robot->name,
            ];
        }

        echo json_encode($data);
    }
);
```

Searching by the field `id` it's quite similar, in this case, we're also notifying if the robot was found or not `index.php`:

```php
<?php

use Phalcon\Http\Response;

// Retrieves robots based on primary key
$app->get(
    '/api/robots/{id:[0-9]+}',
    function ($id) use ($app) {
        $phql = 'SELECT * FROM Store\Toys\Robots WHERE id = :id:';

        $robot = $app->modelsManager->executeQuery(
            $phql,
            [
                'id' => $id,
            ]
        )->getFirst();



        // Create a response
        $response = new Response();

        if ($robot === false) {
            $response->setJsonContent(
                [
                    'status' => 'NOT-FOUND'
                ]
            );
        } else {
            $response->setJsonContent(
                [
                    'status' => 'FOUND',
                    'data'   => [
                        'id'   => $robot->id,
                        'name' => $robot->name
                    ]
                ]
            );
        }

        return $response;
    }
);
```

## Inserting Data
Taking the data as a JSON string inserted in the body of the request, we also use PHQL for insertion `index.php`:

```php
<?php

use Phalcon\Http\Response;

// Adds a new robot
$app->post(
    '/api/robots',
    function () use ($app) {
        $robot = $app->request->getJsonRawBody();

        $phql = 'INSERT INTO Store\Toys\Robots (name, type, year) VALUES (:name:, :type:, :year:)';

        $status = $app->modelsManager->executeQuery(
            $phql,
            [
                'name' => $robot->name,
                'type' => $robot->type,
                'year' => $robot->year,
            ]
        );

        // Create a response
        $response = new Response();

        // Check if the insertion was successful
        if ($status->success() === true) {
            // Change the HTTP status
            $response->setStatusCode(201, 'Created');

            $robot->id = $status->getModel()->id;

            $response->setJsonContent(
                [
                    'status' => 'OK',
                    'data'   => $robot,
                ]
            );
        } else {
            // Change the HTTP status
            $response->setStatusCode(409, 'Conflict');

            // Send errors to the client
            $errors = [];

            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(
                [
                    'status'   => 'ERROR',
                    'messages' => $errors,
                ]
            );
        }

        return $response;
    }
);
```

## Updating Data
The data update is similar to insertion. The `id` passed as parameter indicates what robot must be updated `index.php`:

```php
<?php

use Phalcon\Http\Response;

// Updates robots based on primary key
$app->put(
    '/api/robots/{id:[0-9]+}',
    function ($id) use ($app) {
        $robot = $app->request->getJsonRawBody();

        $phql = 'UPDATE Store\Toys\Robots SET name = :name:, type = :type:, year = :year: WHERE id = :id:';

        $status = $app->modelsManager->executeQuery(
            $phql,
            [
                'id'   => $id,
                'name' => $robot->name,
                'type' => $robot->type,
                'year' => $robot->year,
            ]
        );

        // Create a response
        $response = new Response();

        // Check if the insertion was successful
        if ($status->success() === true) {
            $response->setJsonContent(
                [
                    'status' => 'OK'
                ]
            );
        } else {
            // Change the HTTP status
            $response->setStatusCode(409, 'Conflict');

            $errors = [];

            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(
                [
                    'status'   => 'ERROR',
                    'messages' => $errors,
                ]
            );
        }

        return $response;
    }
);
```

## Deleting Data
The data delete is similar to update. The `id` passed as parameter indicates what robot must be deleted `index.php`:

```php
<?php

use Phalcon\Http\Response;

// Deletes robots based on primary key
$app->delete(
    '/api/robots/{id:[0-9]+}',
    function ($id) use ($app) {
        $phql = 'DELETE FROM Store\Toys\Robots WHERE id = :id:';

        $status = $app->modelsManager->executeQuery(
            $phql,
            [
                'id' => $id,
            ]
        );

        // Create a response
        $response = new Response();

        if ($status->success() === true) {
            $response->setJsonContent(
                [
                    'status' => 'OK'
                ]
            );
        } else {
            // Change the HTTP status
            $response->setStatusCode(409, 'Conflict');

            $errors = [];

            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(
                [
                    'status'   => 'ERROR',
                    'messages' => $errors,
                ]
            );
        }

        return $response;
    }
);
```

## Creating database
Now we will create database for our application. Run SQL queries as follows:
```
CREATE DATABASE `robotics`;
CREATE TABLE `robotics`.`robots` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(200) COLLATE utf8_bin NOT NULL,
 `type` varchar(200) COLLATE utf8_bin NOT NULL,
 `year` smallint(2) unsigned NOT NULL,
 PRIMARY KEY (`id`)
)
```

## Testing our Application
Using [curl](https://en.wikipedia.org/wiki/CURL) we'll test every route in our application verifying its proper operation.

Obtain all the robots:

```bash
curl -i -X GET https://localhost/my-rest-api/api/robots

HTTP/1.1 200 OK
Date: Tue, 21 Jul 2015 07:05:13 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 117
Content-Type: text/html; charset=UTF-8

[{"id":"1","name":"Robotina"},{"id":"2","name":"Astro Boy"},{"id":"3","name":"Terminator"}]
```

Search a robot by its name:

```bash
curl -i -X GET https://localhost/my-rest-api/api/robots/search/Astro

HTTP/1.1 200 OK
Date: Tue, 21 Jul 2015 07:09:23 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 31
Content-Type: text/html; charset=UTF-8

[{"id":"2","name":"Astro Boy"}]
```

Obtain a robot by its id:

```bash
curl -i -X GET https://localhost/my-rest-api/api/robots/3

HTTP/1.1 200 OK
Date: Tue, 21 Jul 2015 07:12:18 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 56
Content-Type: text/html; charset=UTF-8

{"status":"FOUND","data":{"id":"3","name":"Terminator"}}
```

Insert a new robot:

```bash
curl -i -X POST -d '{"name":"C-3PO","type":"droid","year":1977}'
    https://localhost/my-rest-api/api/robots

HTTP/1.1 201 Created
Date: Tue, 21 Jul 2015 07:15:09 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 75
Content-Type: text/html; charset=UTF-8

{"status":"OK","data":{"name":"C-3PO","type":"droid","year":1977,"id":"4"}}
```

Try to insert a new robot with the name of an existing robot:

```bash
curl -i -X POST -d '{"name":"C-3PO","type":"droid","year":1977}'
    https://localhost/my-rest-api/api/robots

HTTP/1.1 409 Conflict
Date: Tue, 21 Jul 2015 07:18:28 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 63
Content-Type: text/html; charset=UTF-8

{"status":"ERROR","messages":["The robot name must be unique"]}
```

Or update a robot with an unknown type:

```bash
curl -i -X PUT -d '{"name":"ASIMO","type":"humanoid","year":2000}'
    https://localhost/my-rest-api/api/robots/4

HTTP/1.1 409 Conflict
Date: Tue, 21 Jul 2015 08:48:01 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 104
Content-Type: text/html; charset=UTF-8

{"status":"ERROR","messages":["Value of field 'type' must be part of
    list: droid, mechanical, virtual"]}
```

Finally, delete a robot:

```bash
curl -i -X DELETE https://localhost/my-rest-api/api/robots/4

HTTP/1.1 200 OK
Date: Tue, 21 Jul 2015 08:49:29 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 15
Content-Type: text/html; charset=UTF-8

{"status":"OK"}
```
