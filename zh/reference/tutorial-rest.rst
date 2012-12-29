教程 3: 创建 RESTful风格 API
======================================
在本节教程中，我们将展示如何使用不同的HTTP方法创建一个简单的 RESTful_ 风格的API。

* 使用HTTP GET方法获取以及检索数据
* 使用HTTP POST方法添加数据
* 使用HTTP PUT方法更新数据
* 使用HTTP DELETE方法删除数据

Defining the API
----------------

API包括以下方法：

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

创建应用
------------------------
RESTful风格的应用程序非常简单，我们用不着使用完整的MVC环境来开发它。在这种情况下，我们只要使用 :doc:`micro application <micro>` 就可以了。

下面的文件结构足够了：

.. code-block:: php

    my-rest-api/
        models/
            Robots.php
        index.php
        .htaccess

首先，我们需要创建一个.htaccess的文件，包含index.php文件的全部重写规则，下面示例就是此文件的全部：

译者注：使用.htaccess文件，前提是指定了你使用的是Apache WEB Sever.

.. code-block:: apacheconf

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

然后，我们按以下方式创建 index.php 文件：

.. code-block:: php

    <?php

    $app = new \Phalcon\Mvc\Micro();

    //define the routes here

    $app->handle();

现在，我们按我们上面的定义创建路由规则：

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

每个API方法都需要定义一个与定义的HTTP方法相同名称的路由规则，第一个参数传递路由规则，第二个是处理程序，在这种情况下，处理程序是一个匿名函数。路由规则  '/api/robots/{id:[0-9]+}'，明确设置'id'参数必须是一个数字。

当用户请求匹配上已定义的路由时，应用程序将执行相应的处理程序。

创建模型(Model)
----------------
API需要提供robots的相关信息，这些数据都存储在数据库中。下面的模型使我们以一种面向对象的方式访问数据表。我们需要使用内置的验证器实现一些业务规则。这样做，会使我们对数据更安全的存储放心，以达到我们想要实现的目的：

.. code-block:: php

    <?php

    use \Phalcon\Mvc\Model\Message;
    use \Phalcon\Mvc\Model\Validator\InclusionIn;
    use \Phalcon\Mvc\Model\Validator\Uniqueness;

    class Robots extends \Phalcon\Mvc\Model
    {

        public function validation()
        {
            //Type must be: droid, mechanical or virtual
            $this->validate(new InclusionIn(
                array(
                    "field"  => "type",
                    "domain" => array("droid", "mechanical", "virtual")
                )
            ));

            //Robot name must be unique
            $this->validate(new Uniqueness(
                array(
                    "field"   => "name",
                    "message" => "The robot name must be unique"
                )
            ));

            //Year cannot be less than zero
            if ($this->year < 0) {
                $this->appendMessage(new Message("The year cannot be less than zero"));
            }

            //Check if any messages have been produced
            if ($this->validationHasFailed() == true) {
                return false;
            }
        }

    }

现在，我们来创建数据库连接以便使用这个模型：

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

获取数据
---------------
第一个"handler"实现通过HTTP GET获取所有可用的robots。让我们使用PHQL执行一个简单的数据查询，并返回JSON数据格式：

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

:doc:`PHQL <phql>`,根据我们使用的数据库系统，允许我们使用面向对象的SQL方言，在内部将其转化为普通的SQL语言，此例使用"use"关键词的匿名函数，允许从整体到局部传递变量。

译者注：不了解匿名函数及use语法的，请查看PHP 5.4版本的文档（具体是5.3开始，还是5.4开始我也不太清楚，就不查证了）。

处理程序看起来像这样：

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

通过字段"id"检索与上例相当类似，在这种情况下，如果没有检索到，会提示未找到。

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

插入数据
--------------
客户端提交JSON包装的字符串，我们也使用PHQL插入：

.. code-block:: php

    <?php

    //Adds a new robot
    $app->post('/api/robots', function() use ($app) {

        $robot = json_decode($app->request->getRawBody());

        $phql = "INSERT INTO Robots (name, type, year) VALUES (:name:, :type:, :year:)";

        $status = $app->modelsManager->executeQuery($phql, array(
            'name' => $robot->name,
            'type' => $robot->type,
            'year' => $robot->year
        ));

        //Check if the insertion was successfull
        if($status->success()==true){

            $robot->id = $status->getModel()->id;

            $response = array('status' => 'OK', 'data' => $robot);

        } else {

            //Change the HTTP status
            $this->response->setStatusCode(500, "Internal Error")->sendHeaders();

            //Send errors to the client
            $errors = array();
            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response = array('status' => 'ERROR', 'messages' => $errors);

        }

        echo json_encode($response);

    });

更新数据
-------------
更新数据非常类似于插入数据。传递的"id"参数指明哪个robots将被更新：

.. code-block:: php

    <?php

    //Updates robots based on primary key
    $app->put('/api/robots/{id:[0-9]+}', function($id) use($app) {

        $robot = json_decode($app->request->getRawBody());

        $phql = "UPDATE Robots SET name = :name:, type = :type:, year = :year: WHERE id = :id:";
        $status = $app->modelsManager->executeQuery($phql, array(
            'id' => $id,
            'name' => $robot->name,
            'type' => $robot->type,
            'year' => $robot->year
        ));

        //Check if the insertion was successfull
        if($status->success()==true){

            $response = array('status' => 'OK');

        } else {

            //Change the HTTP status
            $this->response->setStatusCode(500, "Internal Error")->sendHeaders();

            $errors = array();
            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response = array('status' => 'ERROR', 'messages' => $errors);

        }

        echo json_encode($response);

    });

删除数据
-------------
删除数据非常类似于更新数据。传递的"id"参数指明哪个robot被删除：

.. code-block:: php

    <?php

    //Deletes robots based on primary key
    $app->delete('/api/robots/{id:[0-9]+}', function($id) use ($app) {

        $phql = "DELETE FROM Robots WHERE id = :id:";
        $status = $app->modelsManager->executeQuery($phql, array(
            'id' => $id
        ));
        if($status->success()==true){

            $response = array('status' => 'OK');

        } else {

            //Change the HTTP status
            $this->response->setStatusCode(500, "Internal Error")->sendHeaders();

            $errors = array();
            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response = array('status' => 'ERROR', 'messages' => $errors);

        }

        echo json_encode($response);

    });

测试应用
-----------------------
使用 curl_ 可以测试应用程序中每个操作的正确性：

获取所有robots:

.. code-block:: bash

    curl -i -X GET http://localhost/my-rest-api/api/robots

    HTTP/1.1 200 OK
    Date: Wed, 12 Sep 2012 07:05:13 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 117
    Content-Type: text/html; charset=UTF-8

    [{"id":"1","name":"Robotina"},{"id":"2","name":"Astro Boy"},{"id":"3","name":"Terminator"}]

通过名称查找robot:

.. code-block:: bash

    curl -i -X GET http://localhost/my-rest-api/api/robots/search/Astro

    HTTP/1.1 200 OK
    Date: Wed, 12 Sep 2012 07:09:23 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 31
    Content-Type: text/html; charset=UTF-8

    [{"id":"2","name":"Astro Boy"}]

通过 id 查找 robot:

.. code-block:: bash

    curl -i -X GET http://localhost/my-rest-api/api/robots/3

    HTTP/1.1 200 OK
    Date: Wed, 12 Sep 2012 07:12:18 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 56
    Content-Type: text/html; charset=UTF-8

    {"status":"FOUND","data":{"id":"3","name":"Terminator"}}

插入一个新的robot:

.. code-block:: bash

    curl -i -X POST -d '{"name":"C-3PO","type":"droid","year":1977}'
        http://localhost/my-rest-api/api/robots

    HTTP/1.1 200 OK
    Date: Wed, 12 Sep 2012 07:15:09 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 75
    Content-Type: text/html; charset=UTF-8

    {"status":"OK","data":{"name":"C-3PO","type":"droid","year":1977,"id":"4"}}

尝试插入一个与存在的robot相同名称的robot:

.. code-block:: bash

    curl -i -X POST -d '{"name":"C-3PO","type":"droid","year":1977}'
        http://localhost/my-rest-api/api/robots

    HTTP/1.1 500 Internal Error
    Date: Wed, 12 Sep 2012 07:18:28 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 63
    Content-Type: text/html; charset=UTF-8

    {"status":"ERROR","messages":["The robot name must be unique"]}

或者使用错误的type值更新一个robot:

.. code-block:: bash

    curl -i -X PUT -d '{"name":"ASIMO","type":"humanoid","year":2000}'
        http://localhost/my-rest-api/api/robots/4

    HTTP/1.1 500 Internal Error
    Date: Wed, 12 Sep 2012 08:48:01 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 104
    Content-Type: text/html; charset=UTF-8

    {"status":"ERROR","messages":["Value of field 'type' must be part of
        list: droid, mechanical, virtual"]}

最后，测试删除一个robot数据：

.. code-block:: bash

    curl -i -X DELETE http://localhost/my-rest-api/api/robots/4

    HTTP/1.1 200 OK
    Date: Wed, 12 Sep 2012 08:49:29 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 15
    Content-Type: text/html; charset=UTF-8

    {"status":"OK"}

结论
----------
正如你所看到的那样，使用Phalcon开发RESTful风格的API相当容易。在接下来的文档中，我们会具体讲解如何开发微应用(micro applications)以及如何使用 :doc:`PHQL <phql>` 。

.. _curl : http://en.wikipedia.org/wiki/CURL
.. _RESTful : http://en.wikipedia.org/wiki/Representational_state_transfer