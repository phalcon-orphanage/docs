---
layout: default
language: 'nl-nl'
version: '4.0'
title: 'Tutorial - REST'
keywords: 'tutorial, rest tutorial, api, rest, step by step, micro'
---

# Tutorial - REST

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg) ![](/assets/images/level-beginner.svg)

## Overview

In this tutorial, you will learn how to create a simple application that provides a [RESTful](https://en.wikipedia.org/wiki/Representational_state_transfer) API using different HTTP methods:

* `GET` to retrieve and search data
* `POST` to add data
* `PUT` to update data
* `DELETE` to delete data

> **NOTE**: This is just a sample application. It lacks a lot of features such as authentication, authorization, sanitization of input and error management to name a few. Please use it as a building block for your application, or as a tutorial to understand how you can build a REST API with Phalcon. You can also have a look at the <rest-api> project. 
{: .alert .alert-warning }

## Methoden

The API consists of the following methods:

| Method   | URL                        | Action                                     |
| -------- | -------------------------- | ------------------------------------------ |
| `GET`    | `/api/robots`              | Get all robots                             |
| `GET`    | `/api/robots/search/Astro` | Searches robots with 'Astro' in their name |
| `GET`    | `/api/robots/2`            | Get robots based on primary key            |
| `POST`   | `/api/robots`              | Add robot                                  |
| `PUT`    | `/api/robots/2`            | Update robot based on primary key          |
| `DELETE` | `/api/robots/2`            | Delete robot based on primary key          |

## Application

As the application is simple, we will not implement any full MVC environment to develop it. In this case, we will use a [micro application](application-micro) application for our needs. The structure of the application is as follows:

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

The bulk of our code will be placed in `index.php`.

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

$app->handle(
    $_SERVER["REQUEST_URI"]
);
```

Now we need to create the routes, so that the application can understand what to do when end users interact with our application. The `index.php` file changes to:

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

$app->get(
    '/api/robots',
    function () {
    }
);

$app->get(
    '/api/robots/search/{name}',
    function ($name) {
    }
);

$app->get(
    '/api/robots/{id:[0-9]+}
',
    function ($id) {
    }
);

$app->post(
    '/api/robots',
    function () {
    }
);

$app->put(
    '/api/robots/{id:[0-9]+}',
    function ($id) {
    }
);

$app->delete(
    '/api/robots/{id:[0-9]+}',
    function ($id) {
    }
);

$app->handle(
    $_SERVER["REQUEST_URI"]
);
```

As we add the routes, we use the actual HTTP methods as the names of the methods called in the application object. This allows us to easily define listening points for the application based on those HTTP methods.

The first parameter of each method call is the route and the second is the handler i.e. what do we do when the user calls that route. In our example we have anonymous functions defined for each handler. For the following route:

    /api/robots/{id:[0-9]+}
    

we explicitly set the `id` parameter to be a number. When a defined route matches the requested URI, then the corresponding handler (anonymous function) will be executed.

## Models

For this application we store and manipulate `Robots` in the database. To access the table we need a model. The class below, allows us to access each record of the table in an object oriented manner. We have also implemented business rules, using built-in validators. By doing so, we have high confidence that the data saved will meet the requirements of our application. This model file needs to be created in the `my-rest-api/models` directory.

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Messages\Message;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\InclusionIn;

class Robots extends Model
{
    public function validation()
    {
        $validator = new Validation();

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

        $validator->add(
            'name',
            new Uniqueness(
                [
                    'field'   => 'name',
                    'message' => 'The robot name must be unique',
                ]
            )
        );

        if ($this->year < 0) {
            $this->appendMessage(
                new Message('The year cannot be less than zero')
            );
        }

        if ($this->validationHasFailed() === true) {
            return false;
        }
    }
}
```

We attach three validators to the model. The first one checks the type of the robot. It must be `droid`, `mechanical` or `virtual`. Any other value will make the validator return `false` and the operation (insert/update) will fail. The second validator checks the uniqueness of the name for our robot. The last validator checks the `year` field to be a positive number.

## Database

We need to connect our application to the database. For this example we are going to use the popular MariaDB or similar variants such as MySQL, Aurora etc. In addition to the database setup, we are going to set up the autoloader, so that our application is aware of where to search for files required.

These changes need to be made in the `index.php` file.

```php
<?php

use Phalcon\Loader;
use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

$loader = new Loader();
$loader->registerNamespaces(
    [
        'MyApp\Models' => __DIR__ . '/models/',
    ]
);
$loader->register();

$container = new FactoryDefault();
$container->set(
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

$app = new Micro($container);
```

## Operations

### Get

The first `handler` that we will implement is the one that retrieves data from the database, when the request is made using the `GET` HTTP method. The endpoint will return all the records from the database using a PHQL query and returning the results in JSON.

The handler for `get()` and `/api/robots` becomes:

```php
<?php

$app->get(
    '/api/robots',
    function () use ($app) {
        $phql = 'SELECT id, name '
              . 'FROM MyApp\Models\Robots '
              . 'ORDER BY name'
        ;

        $robots = $app
            ->modelsManager
            ->executeQuery($phql)
        ;

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

[PHQL](db-phql), allows us to write queries using a high level, object oriented SQL dialect, that internally translates your query to the correct SQL statements depending on the database system used. The `use` statement in the anonymous function offers object injection from the local scope to the anonymous function.

### Get - Text

We can get robots using their name or part of their name. This search feature will also be a `get()` as far as HTTP method is concerned and it will tie to the `/api/robots/search/{name}` endpoint. The implementation is similar to the one above. We just need to change the query slightly.

```php
<?php

// Searches for robots with $name in their name
$app->get(
    '/api/robots/search/{name}',
    function ($name) use ($app) {
        $phql = 'SELECT * '
              . 'FROM MyApp\Models\Robots '
              . 'WHERE name '
              . 'LIKE :name: '
              . 'ORDER BY name'
        ;

        $robots = $app
            ->modelsManager
            ->executeQuery(
                $phql,
                [
                    'name' => '%' . $name . '%'
                ]
            )
        ;

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

### Get - `id`

To get a robot by using their `id` is similar to the above operations. We will just need to adjust the query that we run against the database. The HTTP method used will also be `get()` and the endpoint will be `/api/robots/{id:[0-9]+}`. For this handler, we are also reporting back if a robot has not been found.

The `index.php` changes again:

```php
<?php

use Phalcon\Http\Response;

$app->get(
    '/api/robots/{id:[0-9]+}',
    function ($id) use ($app) {
        $phql = 'SELECT * '
              . 'FROM MyApp\ModelsRobots '
              . 'WHERE id = :id:'
        ;

        $robot = $app
            ->modelsManager
            ->executeQuery(
                $phql,
                [
                    'id' => $id,
                ]
            )
            ->getFirst()
        ;

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

### Insert

Our design allows users to submit data so that we can insert them in the database. The HTTP method used is `post()` to the `/api/robots` endpoint. We expect the data to be submitted as a JSON string.

```php
<?php

use Phalcon\Http\Response;

$app->post(
    '/api/robots',
    function () use ($app) {
        $robot = $app->request->getJsonRawBody();
        $phql  = 'INSERT INTO MyApp\ModelsRobots '
               . '(name, type, year) '
               . 'VALUES '
               . '(:name:, :type:, :year:)'
        ;

        $status = $app
            ->modelsManager
            ->executeQuery(
                $phql,
                [
                    'name' => $robot->name,
                    'type' => $robot->type,
                    'year' => $robot->year,
                ]
            )
        ;

        $response = new Response();

        if ($status->success() === true) {
            $response->setStatusCode(201, 'Created');

            $robot->id = $status->getModel()->id;

            $response->setJsonContent(
                [
                    'status' => 'OK',
                    'data'   => $robot,
                ]
            );
        } else {
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

After we run the query against our database, using PHQL, we create a brand new `Response` object. If the query was executed correctly, we manipulate the response to have a status code of `201` and text `Created`. We finally update the `id` of the recently created record, and send the robot back with the response.

If something is wrong, we change the response status code to `409` with the text `Conflict` and collect all the errors that have been produced of the database operation. We then send those error messages back with the response.

## Update

Updating data is similar to inserting. For this operation we are using the `put()` HTTP method and the endpoint `/api/robots/{id:[0-9]+}`. The passed `id` parameter in the URL is the id of the robot to be updated. The data submitted is in JSON format.

```php
<?php

use Phalcon\Http\Response;

$app->put(
    '/api/robots/{id:[0-9]+}',
    function ($id) use ($app) {
        $robot = $app->request->getJsonRawBody();
        $phql  = 'UPDATE MyApp\Models\Robots '
               . 'SET name = :name:, type = :type:, year = :year: '
               . 'WHERE id = :id:';

        $status = $app
            ->modelsManager
            ->executeQuery(
                $phql,
                [
                    'id'   => $id,
                    'name' => $robot->name,
                    'type' => $robot->type,
                    'year' => $robot->year,
                ]
            )
        ;

        $response = new Response();

        if ($status->success() === true) {
            $response->setJsonContent(
                [
                    'status' => 'OK'
                ]
            );
        } else {
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

The operation is very similar to the one we use when inserting data. If the update operation is successful, we send back a JSON payload with `OK`.

If something is wrong, we change the response status code to `409` with the text `Conflict` and collect all the errors that have been produced of the database operation. We then send those error messages back with the response.

## Delete

Delete is nearly identical to the `update` process. For this operation we are using the `delete()` HTTP method and the endpoint `/api/robots/{id:[0-9]+}`. The passed `id` parameter in the URL is the id of the robot to be deleted.

The `index.php` changes again:

```php
<?php

use Phalcon\Http\Response;

// Deletes robots based on primary key
$app->delete(
    '/api/robots/{id:[0-9]+}',
    function ($id) use ($app) {
        $phql = 'DELETE '
              . 'FROM MyApp\Models\Robots '
              . 'WHERE id = :id:';

        $status = $app
            ->modelsManager
            ->executeQuery(
                $phql,
                [
                    'id' => $id,
                ]
            )
        ;

        $response = new Response();

        if ($status->success() === true) {
            $response->setJsonContent(
                [
                    'status' => 'OK'
                ]
            );
        } else {
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

If the delete operation is successful, we send back a JSON payload with `OK`.

If something is wrong, we change the response status code to `409` with the text `Conflict` and collect all the errors that have been produced of the database operation. We then send those error messages back with the response.

## Schema

In order to create the table in our database, we need to use the following SQL queries:

    create database `robotics`;
    
    create table `robotics`.`robots` (
     `id`    int(10)      unsigned         not null auto_increment,
     `name`  varchar(200) collate utf8_bin not null,
     `type`  varchar(20)  collate utf8_bin not null,
     `year`  smallint(4)  unsigned         not null,
     PRIMARY KEY (`id`)
    )
    

## Run

You can of course set up your web server to run your application. For setup instructions you can check the [webserver setup](webserver-setup) document. If you want to use the built-in PHP server, you will need to create a file called `.htrouter` as follows:

```php
<?php

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

$_GET['_url'] = $_SERVER['REQUEST_URI'];

require_once __DIR__ . '/index.php';
```

and then run the following command:

    $(which php) -S localhost:8000 -t / .htrouter.php
    

## Tests

There are numerous testing suites that you can use to test this application. We will use [curl](https://en.wikipedia.org/wiki/CURL) on every route, to verify proper operation.

**Get** all the robots:

```bash
curl -i -X GET https://localhost/my-rest-api/api/robots

HTTP/1.1 200 OK
Date: Wed, 25 Dec 2019 01:02:03 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 117
Content-Type: text/html; charset=UTF-8

[{"id":"1","name":"Robotina"},{"id":"2","name":"Astro Boy"},{"id":"3","name":"Terminator"}]
```

**Search** a robot by its name:

```bash
curl -i -X GET https://localhost/my-rest-api/api/robots/search/Astro

HTTP/1.1 200 OK
Date: Wed, 25 Dec 2019 01:02:03 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 31
Content-Type: text/html; charset=UTF-8

[{"id":"2","name":"Astro Boy"}]
```

**Get** a robot by its id:

```bash
curl -i -X GET https://localhost/my-rest-api/api/robots/3

HTTP/1.1 200 OK
Date: Wed, 25 Dec 2019 01:02:03 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 56
Content-Type: text/html; charset=UTF-8

{"status":"FOUND","data":{"id":"3","name":"Terminator"}}
```

**Insert** a new robot:

```bash
curl -i -X POST -d '{"name":"C-3PO","type":"droid","year":1977}' \
    https://localhost/my-rest-api/api/robots

HTTP/1.1 201 Created
Date: Wed, 25 Dec 2019 01:02:03 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 75
Content-Type: text/html; charset=UTF-8

{"status":"OK","data":{"name":"C-3PO","type":"droid","year":1977,"id":"4"}}
```

Try to insert a new robot with the name of an existing robot:

```bash
curl -i -X POST -d '{"name":"C-3PO","type":"droid","year":1977}' \
    https://localhost/my-rest-api/api/robots

HTTP/1.1 409 Conflict
Date: Wed, 25 Dec 2019 01:02:03 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 63
Content-Type: text/html; charset=UTF-8

{"status":"ERROR","messages":["The robot name must be unique"]}
```

**Update** a robot with an unknown type:

```bash
curl -i -X PUT -d '{"name":"ASIMO","type":"humanoid","year":2000}' \
    https://localhost/my-rest-api/api/robots/4

HTTP/1.1 409 Conflict
Date: Wed, 25 Dec 2019 01:02:03 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 104
Content-Type: text/html; charset=UTF-8

{"status":"ERROR","messages":["Value of field 'type' must be part of
    list: droid, mechanical, virtual"]}
```

**Delete** a robot:

```bash
curl -i -X DELETE https://localhost/my-rest-api/api/robots/4

HTTP/1.1 200 OK
Date: Wed, 25 Dec 2019 01:02:03 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 15
Content-Type: text/html; charset=UTF-8

{"status":"OK"}
```