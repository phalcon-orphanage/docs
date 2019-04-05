---
layout: default
language: 'ja-jp'
version: '4.0'
---
# Tutorial - REST

* * *

## Creating a Simple REST API

In this tutorial, we will explain how to create a simple application that provides a [RESTful](https://en.wikipedia.org/wiki/Representational_state_transfer) API using the different HTTP methods:

* `GET` データの取得と検索
* `POST` データの追加
* `PUT` データの更新
* `DELETE` データの削除

## Defining the API

The API consists of the following methods:

| メソッド     | URL                      | Action                 |
| -------- | ------------------------ | ---------------------- |
| `GET`    | /api/robots              | すべてのロボットを取得します。        |
| `GET`    | /api/robots/search/Astro | 名前が 'Astro' のロボットを検索   |
| `GET`    | /api/robots/2            | プライマリーキーが2のロボットを取得します。 |
| `POST`   | /api/robots              | robotを追加               |
| `PUT`    | /api/robots/2            | プライマリーキーが2のロボットを更新します。 |
| `DELETE` | /api/robots/2            | プライマリーキーが2のロボットを削除します。 |

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

// ここでルートを定義

$app->handle();
```

Now we will create the routes as we defined above:

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

// 全ての robots を取得
$app->get(
    '/api/robots',
    function () {
        // 全 robot を取得する操作
    }
);

// 名前が $name である robotを検索
$app->get(
    '/api/robots/search/{name}',
    function ($name) {
        // 名前が $name である robotを検索する操作
    }
);

// プライマリーキーで robotを指定して取得
$app->get(
    '/api/robots/{id:[0-9]+}',
    function ($id) {
        // プライマリーキーが $idの robotを指定して取得する操作
    }
);

// 新しいrobotの追加
$app->post(
    '/api/robots',
    function () {
        // 新しいrobotを追加する操作
    }
);

// プライマリーキーで指定したrobotを更新する
$app->put(
    '/api/robots/{id:[0-9]+}',
    function ($id) {
        // プライマリーキーが $id のrobotを更新する
    }
);

// プライマリーキーで指定したrobotを削除する
$app->delete(
    '/api/robots/{id:[0-9]+}',
    function ($id) {
        // プライマリーキーが $id のrobotを削除する
    }
);

$app->handle();
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

Now, we must set up a connection to be used by this model and load it within our app `index.php`:

```php
<?php

use Phalcon\Loader;
use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

// Loader() を使って私達のモデルをオートロードします。
$loader = new Loader();

$loader->registerNamespaces(
    [
        'Store\Toys' => __DIR__ . '/models/',
    ]
);

$loader->register();

$di = new FactoryDefault();

// データベースサービスのセットアップ
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

// DI を作成し、アプリケーションにバインド
$app = new Micro($di);
```

## Retrieving Data

The first `handler` that we will implement is which by method GET returns all available robots. Let's use PHQL to perform this simple query returning the results as JSON. `index.php`

```php
<?php

// ロボットの取得
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

// ロボットの検索(その名前を $name で検索)
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

// プライマリーキーでロボットを取得
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



        // レスポンスを作成
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

// 新しいロボットの追加
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

        // レスポンスの作成
        $response = new Response();

        // 挿入が成功したかを確認
        if ($status->success() === true) {
            // HTTPステータスの変更
            $response->setStatusCode(201, 'Created');

            $robot->id = $status->getModel()->id;

            $response->setJsonContent(
                [
                    'status' => 'OK',
                    'data'   => $robot,
                ]
            );
        } else {
            // HTTPステータスの変更
            $response->setStatusCode(409, 'Conflict');

            // クライアントにエラーを送信
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

// プライマリーキーで指定したロボットを更新する
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

        // レスポンスの作成
        $response = new Response();

        // この挿入が成功したか確認する
        if ($status->success() === true) {
            $response->setJsonContent(
                [
                    'status' => 'OK'
                ]
            );
        } else {
            // HTTP ステータスの変更
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

// プライマリーキーによってロボットを削除する
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

        // レスポンスの作成
        $response = new Response();

        if ($status->success() === true) {
            $response->setJsonContent(
                [
                    'status' => 'OK'
                ]
            );
        } else {
            // HTTPステータスの変更
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

    CREATE DATABASE `robotics`;
    CREATE TABLE `robotics`.`robots` (
     `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
     `name` varchar(200) COLLATE utf8_bin NOT NULL,
     `type` varchar(200) COLLATE utf8_bin NOT NULL,
     `year` smallint(2) unsigned NOT NULL,
     PRIMARY KEY (`id`)
    )
    

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