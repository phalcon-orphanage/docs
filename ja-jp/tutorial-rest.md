* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='basic'></a>

# チュートリアル: 単純な REST API の作成

In this tutorial, we will explain how to create a simple application that provides a [RESTful](https://en.wikipedia.org/wiki/Representational_state_transfer) API using the different HTTP methods:

* `GET` データの取得と検索
* `POST` データの追加
* `PUT` データの更新
* `DELETE` データの削除

<a name='definitions'></a>

## API の定義

APIは、以下のメソッドで構成されています:

| メソッド     | URL                      | Action                 |
| -------- | ------------------------ | ---------------------- |
| `GET`    | /api/robots              | すべてのロボットを取得します。        |
| `GET`    | /api/robots/search/Astro | 名前が 'Astro' のロボットを検索   |
| `GET`    | /api/robots/2            | プライマリーキーが2のロボットを取得します。 |
| `POST`   | /api/robots              | robotを追加               |
| `PUT`    | /api/robots/2            | プライマリーキーが2のロボットを更新します。 |
| `DELETE` | /api/robots/2            | プライマリーキーが2のロボットを削除します。 |

<a name='implementation'></a>

## アプリケーションの作成

As the application is so simple, we will not implement any full MVC environment to develop it. In this case, we will use a [micro application](/4.0/en/application-micro) to meet our goal.

以下のファイル構造で十分です。

```php
my-rest-api/
    models/
        Robots.php
    index.php
    .htaccess
```

まず、リクエストURIを`index.php`ファイル（アプリケーションのエントリポイント）に書き換えるための、すべてのルールを含む`.htaccess`ファイルが必要です:

```apacheconfig
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
</IfModule>
```

コードの大半は`index.php`に配置されます。このファイルは次のように作成されます:

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

// ここでルートを定義

$app->handle();
```

上で定義した、ルートを作成します:

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

各ルートは、HTTPメソッドと同じ名前のメソッドで定義されます。最初のパラメータとしてルートパターンを渡し、その後にハンドラが続きます。 この場合、ハンドラーは無名関数です。 次のルート: `/api/robots/{id:[0-9]+}`を例にすると、 `id` パラメーターが数値形式でなければならないことを明示的にしています。

定義されたルートがこの要求されたURIにマッチするとき、このアプリケーションは相当するハンドラを実行します。

<a name='models'></a>

## Modelの作成

私達のAPIは`robots`の情報を提供します。これらのデータはデータベースに保存されています。 次のモデルでは、オブジェクト指向の方法でテーブルにアクセスできます。 ビルドインのバリデーターとシンプルなバリデーターを使って、いくつかのビジネスルールを実装しました。 こうすることで、アプリケーションの要件を満たすようにデータを保存できます。 このモデルファイルは、`Models` フォルダーに配置する必要があります。

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

このモデルで使用されるコネクションを設定し、アプリ内でロードする必要があります[ファイル: `index.php`]:

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

<a name='retrieving-data'></a>

## データの取得

私達が実装する、最初の `handler` は、GETメソッドで利用可能なすべてのロボットを返します。 結果を JSON として返す単純なクエリを実行する PHQL を使いましょう。 [ファイル: `index.php`]

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

[PHQL](/4.0/en/db-phql), allow us to write queries using a high-level, object-oriented SQL dialect that internally translates to the right SQL statements depending on the database system we are using. 無名関数の`use`句によって簡単にグローバルスコープからローカルスコープへ変数をいくつか渡すことができます。

nameハンドラによる検索は次のようになります。[ファイル: `index.php`]:

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

フィールド`id`での検索とよく似ており、今回の場合はロボットが見つかったかどうかを通知します [ファイル: `index.php`]:

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

<a name='inserting-data'></a>

## Inserting Data

リクエストのボディに挿入されたJSON文字列として与えらえたデータを使って、挿入用のPHQLを使用します [ファイル: `index.php`]:

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

<a name='updating-data'></a>

## Updating Data

データの更新は挿入と似ています。パラメータとして渡されるこの`id`はどのロボットを更新すべきかを示しています [ファイル:`index.php`]:

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

<a name='deleting-data'></a>

## Deleting Data

データの削除は更新と似ています。パラメータとして渡されるこの`id`はどのロボットを削除すべきかを示しています [ファイル:`index.php`]:

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

## データベースの作成

Now we will create database for our application. Run SQL queries as follows:

    CREATE DATABASE `robotics`;
    CREATE TABLE `robotics`.`robots` (
     `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
     `name` varchar(200) COLLATE utf8_bin NOT NULL,
     `type` varchar(200) COLLATE utf8_bin NOT NULL,
     `year` smallint(2) unsigned NOT NULL,
     PRIMARY KEY (`id`)
    )
    

<a name='testing'></a>

## アプリケーションのテスト

Using [curl](https://en.wikipedia.org/wiki/CURL) we'll test every route in our application verifying its proper operation.

全てのロボットの取得:

```bash
curl -i -X GET https://localhost/my-rest-api/api/robots

HTTP/1.1 200 OK
Date: Tue, 21 Jul 2015 07:05:13 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 117
Content-Type: text/html; charset=UTF-8

[{"id":"1","name":"Robotina"},{"id":"2","name":"Astro Boy"},{"id":"3","name":"Terminator"}]
```

名前でロボットを検索:

```bash
curl -i -X GET https://localhost/my-rest-api/api/robots/search/Astro

HTTP/1.1 200 OK
Date: Tue, 21 Jul 2015 07:09:23 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 31
Content-Type: text/html; charset=UTF-8

[{"id":"2","name":"Astro Boy"}]
```

Idでロボットを取得:

```bash
curl -i -X GET https://localhost/my-rest-api/api/robots/3

HTTP/1.1 200 OK
Date: Tue, 21 Jul 2015 07:12:18 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 56
Content-Type: text/html; charset=UTF-8

{"status":"FOUND","data":{"id":"3","name":"Terminator"}}
```

新しいロボットの挿入:

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

既存のロボットの名前で新しいロボットの挿入:

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

種類がunknownのロボットの更新:

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

最後に、ロボットの削除:

```bash
curl -i -X DELETE https://localhost/my-rest-api/api/robots/4

HTTP/1.1 200 OK
Date: Tue, 21 Jul 2015 08:49:29 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 15
Content-Type: text/html; charset=UTF-8

{"status":"OK"}
```

<a name='conclusion'></a>

## Conclusion

As we saw, developing a [RESTful](https://en.wikipedia.org/wiki/Representational_state_transfer) API with Phalcon is easy using [micro applications](/4.0/en/application-micro) and [PHQL](/4.0/en/db-phql).