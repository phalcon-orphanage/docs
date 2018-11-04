<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">教程： 创建一个简单的 REST API</a>
      <ul>
        <li>
          <a href="#definitions">定义 API</a>
        </li>
        <li>
          <a href="#implementation">创建应用程序</a>
        </li>
        <li>
          <a href="#models">创建模型</a>
        </li>
        <li>
          <a href="#retrieving-data">检索数据</a>
        </li>
        <li>
          <a href="#inserting-data">插入数据</a>
        </li>
        <li>
          <a href="#updating-data">更新数据</a>
        </li>
        <li>
          <a href="#deleting-data">删除数据</a>
        </li>
        <li>
          <a href="#testing">测试我们的应用程序</a>
        </li>
        <li>
          <a href="#conclusion">结论</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='basic'></a>

# 教程： 创建一个简单的 REST API

在本教程中，我们会解释如何通过不同的HTTP访问方法来创建一个简单的[RESTful](http://en.wikipedia.org/wiki/Representational_state_transfer)风格的接口类型的应用程序：

* `GET` 要检索和搜索数据
* `POST`，以添加数据
* `PUT` 更新的数据
* `DELETE` 来删除数据

<a name='definitions'></a>

## 定义的 API

该 API 包括以下方法：

| 方法       | URL                      | 操作                                  |
| -------- | ------------------------ | ----------------------------------- |
| `GET`    | /api/robots              | 检索所有的机器人                            |
| `GET`    | /api/robots/search/Astro | 在他们的名字与 'Astro' 机器人搜索               |
| `GET`    | /api/robots/2            | 检索基于主键机器人                           |
| `POST`   | /api/robots              | 添加一个新的机器人                           |
| `PUT`    | /api/robots/2            | Updates robots based on primary key |
| `DELETE` | /api/robots/2            | 删除基于主键机器人                           |

<a name='implementation'></a>

## 创建应用程序

由于应用程序需求简单，我们不会实现完整的MVC环境来开发它。 在这种情况下，我们使用[micro application](/[[language]]/[[version]]/application-micro) 足以满足需求。

以下的文件结构足够了：

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

大部分的我们的代码将放置在 `index.php`。文件内容如下：

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

// 在这定义路由

$app->handle();
```

现在根据上面的需求来创建路由：

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

$app->handle();
```

每个路由使用与HTTP访问方式相同名称的方法进行定义。首选第一个参数为路由匹配参数，接下来的是处理访问。 在这种情况下，处理访问的是一个匿名函数。 以下路由：`/api/robots/{id:[0-9]+}`，以身作则，显式设置`id`参数必须为数字格式。

当定义的路由与访问与之匹配，应用会执行对应的处理。

<a name='models'></a>

## 创建模型

我们的 API 提供了关于 `robots` 的信息，这些信息都存储在数据库中。 下列的模型允许我们以面向对象的方式访问对应表。 我们通过使用框架自带的验证器和手动实现了一些简单的验证实现了业务规则。 这样做会让将会保存的数据符合我们的应用要求，将使我们安心。 此模型文件应放在 `Models` 文件夹中。

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness
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

现在，我们必须设置连接采用这种模式并加载它在我们的应用程序内 [文件： `index.php`]:

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

<a name='retrieving-data'></a>

## Retrieving Data

The first `handler` that we will implement is which by method GET returns all available robots. Let's use PHQL to perform this simple query returning the results as JSON. [File: `index.php`]

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

[PHQL](/[[language]]/[[version]]/db-phql), allow us to write queries using a high-level, object-oriented SQL dialect that internally translates to the right SQL statements depending on the database system we are using. The clause `use` in the anonymous function allows us to pass some variables from the global to local scope easily.

The searching by name handler would look like [File: `index.php`]:

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

Searching by the field `id` it's quite similar, in this case, we're also notifying if the robot was found or not [File: `index.php`]:

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

<a name='inserting-data'></a>

## Inserting Data

Taking the data as a JSON string inserted in the body of the request, we also use PHQL for insertion [File: `index.php`]:

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

<a name='updating-data'></a>

## Updating Data

The data update is similar to insertion. The `id` passed as parameter indicates what robot must be updated [File: `index.php`]:

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

<a name='deleting-data'></a>

## Deleting Data

The data delete is similar to update. The `id` passed as parameter indicates what robot must be deleted [File: `index.php`]:

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

<a name='testing'></a>

## Testing our Application

Using [curl](http://en.wikipedia.org/wiki/CURL) we'll test every route in our application verifying its proper operation.

Obtain all the robots:

```bash
curl -i -X GET http://localhost/my-rest-api/api/robots

HTTP/1.1 200 OK
Date: Tue, 21 Jul 2015 07:05:13 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 117
Content-Type: text/html; charset=UTF-8

[{"id":"1","name":"Robotina"},{"id":"2","name":"Astro Boy"},{"id":"3","name":"Terminator"}]
```

Search a robot by its name:

```bash
curl -i -X GET http://localhost/my-rest-api/api/robots/search/Astro

HTTP/1.1 200 OK
Date: Tue, 21 Jul 2015 07:09:23 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 31
Content-Type: text/html; charset=UTF-8

[{"id":"2","name":"Astro Boy"}]
```

Obtain a robot by its id:

```bash
curl -i -X GET http://localhost/my-rest-api/api/robots/3

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
    http://localhost/my-rest-api/api/robots

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
    http://localhost/my-rest-api/api/robots

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
    http://localhost/my-rest-api/api/robots/4

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
curl -i -X DELETE http://localhost/my-rest-api/api/robots/4

HTTP/1.1 200 OK
Date: Tue, 21 Jul 2015 08:49:29 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 15
Content-Type: text/html; charset=UTF-8

{"status":"OK"}
```

<a name='conclusion'></a>

## Conclusion

As we saw, developing a [RESTful](http://en.wikipedia.org/wiki/Representational_state_transfer) API with Phalcon is easy using [micro applications](/[[language]]/[[version]]/application-micro) and [PHQL](/[[language]]/[[version]]/db-phql).