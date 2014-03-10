%{tutorial-rest_84d6814c39aad10b26d97af056279a18}%
======================================
%{tutorial-rest_26bb72e995bd5df1986ace55a4facb04}%

* {%tutorial-rest_32078862cbc89311a83ec70d9abbf16f%}
* {%tutorial-rest_d3b149cb8903daad9105cc68ffd1fa4c%}
* {%tutorial-rest_e8d6496eed740238d144e3a8e2e09685%}
* {%tutorial-rest_e24f21ea46ef329607ad132789e206e5%}

%{tutorial-rest_de7a3eed9a59d47b9d09135314d297b0}%
----------------
%{tutorial-rest_dc2ae90fdb0e1a1b5ed87ba88e60d3d6}%

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


%{tutorial-rest_5c324116ca038c813884951ceaef82a6}%
------------------------
%{tutorial-rest_2aa7d2a4a05106085cb78f9e0b8aaa07|:doc:`micro application <micro>`}%

%{tutorial-rest_3de37a33c247c456a388861f2bdcc755}%

.. code-block:: php

    my-rest-api/
        models/
            Robots.php
        index.php
        .htaccess


%{tutorial-rest_b52d147d1fe56301a39815a548fa9c8c}%

.. code-block:: apacheconf

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>


%{tutorial-rest_2de10b838279f7a1b98fbf81f84c855e}%

.. code-block:: php

    <?php

    $app = new \Phalcon\Mvc\Micro();

    //{%tutorial-rest_539b3e63c25aa801f010dbc03afd004b%}

    $app->handle();


%{tutorial-rest_c5bdd1dcaebc8333b5ee2aa4fdf59edb}%

.. code-block:: php

    <?php

    $app = new Phalcon\Mvc\Micro();

    //{%tutorial-rest_19ff92d2013609de09201b6a1442d60c%}
    $app->get('/api/robots', function() {

    });

    //{%tutorial-rest_fcccedd69d1b9bb08f7c0bc6ce78ff8e%}
    $app->get('/api/robots/search/{name}', function($name) {

    });

    //{%tutorial-rest_2ecc05873abdbd9f5c2f34228b8a100f%}
    $app->get('/api/robots/{id:[0-9]+}', function($id) {

    });

    //{%tutorial-rest_ba09a4f2dfcf0f791aa6a30cbda7f65a%}
    $app->post('/api/robots', function() {

    });

    //{%tutorial-rest_9f4ce8962a6eb3d3e4f77eb498535139%}
    $app->put('/api/robots/{id:[0-9]+}', function() {

    });

    //{%tutorial-rest_b9c7c89947c393f32a8ae30e2606925f%}
    $app->delete('/api/robots/{id:[0-9]+}', function() {

    });

    $app->handle();


%{tutorial-rest_190c1cf65b799928f06a3169276c224a}%

%{tutorial-rest_aff08db4a501b540bbefb8d4a7d06a4b}%

%{tutorial-rest_0199fa0781bc2af2736301fc88a34dff}%
----------------
%{tutorial-rest_248a5b13f805b6df66e79e4a4a6a80bb}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model,
        Phalcon\Mvc\Model\Message,
        Phalcon\Mvc\Model\Validator\InclusionIn,
        Phalcon\Mvc\Model\Validator\Uniqueness;

    class Robots extends Model
    {

        public function validation()
        {
            //{%tutorial-rest_5e65e76efd7358de97543f933cccef32%}
            $this->validate(new InclusionIn(
                array(
                    "field"  => "type",
                    "domain" => array("droid", "mechanical", "virtual")
                )
            ));

            //{%tutorial-rest_c096a65878ddaac4ce0b5ffc8753aa76%}
            $this->validate(new Uniqueness(
                array(
                    "field"   => "name",
                    "message" => "The robot name must be unique"
                )
            ));

            //{%tutorial-rest_5a50ccbf7dc2a5082848a95ef3713649%}
            if ($this->year < 0) {
                $this->appendMessage(new Message("The year cannot be less than zero"));
            }

            //{%tutorial-rest_76db80d81b38e1a1ddb78641d3191f9f%}
            if ($this->validationHasFailed() == true) {
                return false;
            }
        }

    }


%{tutorial-rest_27aad3837a5f3a11f2ca1050a32c6680}%

.. code-block:: php

    <?php

    // {%tutorial-rest_9c0e7e2aff8e1bbecc3e75d851f8c89b%}
    $loader = new \Phalcon\Loader();

    $loader->registerDirs(array(
        __DIR__ . '/models/'
    ))->register();

    $di = new \Phalcon\DI\FactoryDefault();

    //{%tutorial-rest_d4fdac308ee18799a8777c00c85cffcd%}
    $di->set('db', function(){
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => "localhost",
            "username" => "asimov",
            "password" => "zeroth",
            "dbname" => "robotics"
        ));
    });

    //{%tutorial-rest_cb96f1919ab7315846cc2ad0249ddcac%}
    $app = new \Phalcon\Mvc\Micro($di);


%{tutorial-rest_afcfb569def26d4afb31ed1fd293b041}%
---------------
%{tutorial-rest_e8decbd7ff3d33202bfa8c228b44d4b3}%

.. code-block:: php

    <?php

    //{%tutorial-rest_19ff92d2013609de09201b6a1442d60c%}
    $app->get('/api/robots', function() use ($app) {

        $phql = "SELECT * FROM Robots ORDER BY name";
        $robots = $app->modelsManager->executeQuery($phql);

        $data = array();
        foreach ($robots as $robot) {
            $data[] = array(
                'id' => $robot->id,
                'name' => $robot->name,
            );
        }

        echo json_encode($data);
    });

:doc:`PHQL <phql>`, allow us to write queries using a high-level, object-oriented SQL dialect that internally

%{tutorial-rest_c7b41850d249a062e80610b6dcca6b07}%

%{tutorial-rest_5d05802c2034051acc6e92d4c60d9413}%

.. code-block:: php

    <?php

    //{%tutorial-rest_fcccedd69d1b9bb08f7c0bc6ce78ff8e%}
    $app->get('/api/robots/search/{name}', function($name) use ($app) {

        $phql = "SELECT * FROM Robots WHERE name LIKE :name: ORDER BY name";
        $robots = $app->modelsManager->executeQuery($phql, array(
            'name' => '%' . $name . '%'
        ));

        $data = array();
        foreach ($robots as $robot) {
            $data[] = array(
                'id' => $robot->id,
                'name' => $robot->name,
            );
        }

        echo json_encode($data);

    });


%{tutorial-rest_12e76a2b259ba344f07fbe50be73c2e6}%

.. code-block:: php

    <?php

    //{%tutorial-rest_2ecc05873abdbd9f5c2f34228b8a100f%}
    $app->get('/api/robots/{id:[0-9]+}', function($id) use ($app) {

        $phql = "SELECT * FROM Robots WHERE id = :id:";
        $robot = $app->modelsManager->executeQuery($phql, array(
            'id' => $id
        ))->getFirst();

        //{%tutorial-rest_ea25894af54d5d28a23fb08f9f153999%}
        $response = new Phalcon\Http\Response();

        if ($robot == false) {
            $response->setJsonContent(array('status' => 'NOT-FOUND'));
        } else {
            $response->setJsonContent(array(
                'status' => 'FOUND',
                'data' => array(
                    'id' => $robot->id,
                    'name' => $robot->name
                )
            ));
        }

        return $response;
    });


%{tutorial-rest_d70f9732a93804895552d4041ad92122}%
--------------
%{tutorial-rest_ea7792bcb128f13873a0b38875008365}%

.. code-block:: php

    <?php

    //{%tutorial-rest_ba09a4f2dfcf0f791aa6a30cbda7f65a%}
    $app->post('/api/robots', function() use ($app) {

        $robot = $app->request->getJsonRawBody();

        $phql = "INSERT INTO Robots (name, type, year) VALUES (:name:, :type:, :year:)";

        $status = $app->modelsManager->executeQuery($phql, array(
            'name' => $robot->name,
            'type' => $robot->type,
            'year' => $robot->year
        ));

        //{%tutorial-rest_ea25894af54d5d28a23fb08f9f153999%}
        $response = new Phalcon\Http\Response();

        //{%tutorial-rest_f5c14028b1e679c69928688cc85a571c%}
        if ($status->success() == true) {

            //{%tutorial-rest_119ca4b05ef54588a2c7015f0293e6e1%}
            $response->setStatusCode(201, "Created");

            $robot->id = $status->getModel()->id;

            $response->setJsonContent(array('status' => 'OK', 'data' => $robot));

        } else {

            //{%tutorial-rest_119ca4b05ef54588a2c7015f0293e6e1%}
            $response->setStatusCode(409, "Conflict");

            //{%tutorial-rest_9b9c03a98a2fcb2d04f11a1d6ec7584c%}
            $errors = array();
            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(array('status' => 'ERROR', 'messages' => $errors));
        }

        return $response;
    });


%{tutorial-rest_7e95ceac582a15ef3f27c690a4862c5a}%
-------------
%{tutorial-rest_7ee3d9762d971ea9098b67c73223862a}%

.. code-block:: php

    <?php

    //{%tutorial-rest_9f4ce8962a6eb3d3e4f77eb498535139%}
    $app->put('/api/robots/{id:[0-9]+}', function($id) use($app) {

        $robot = $app->request->getJsonRawBody();

        $phql = "UPDATE Robots SET name = :name:, type = :type:, year = :year: WHERE id = :id:";
        $status = $app->modelsManager->executeQuery($phql, array(
            'id' => $id,
            'name' => $robot->name,
            'type' => $robot->type,
            'year' => $robot->year
        ));

        //{%tutorial-rest_ea25894af54d5d28a23fb08f9f153999%}
        $response = new Phalcon\Http\Response();

        //{%tutorial-rest_f5c14028b1e679c69928688cc85a571c%}
        if ($status->success() == true) {
            $response->setJsonContent(array('status' => 'OK'));
        } else {

            //{%tutorial-rest_119ca4b05ef54588a2c7015f0293e6e1%}
            $response->setStatusCode(409, "Conflict");

            $errors = array();
            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(array('status' => 'ERROR', 'messages' => $errors));
        }

        return $response;
    });


%{tutorial-rest_12f49100cf21592b1bed0daa5b42bcd9}%
-------------
%{tutorial-rest_a22e0afc3c116152d64bb2ffd8f8e2be}%

.. code-block:: php

    <?php

    //{%tutorial-rest_b9c7c89947c393f32a8ae30e2606925f%}
    $app->delete('/api/robots/{id:[0-9]+}', function($id) use ($app) {

        $phql = "DELETE FROM Robots WHERE id = :id:";
        $status = $app->modelsManager->executeQuery($phql, array(
            'id' => $id
        ));

        //{%tutorial-rest_ea25894af54d5d28a23fb08f9f153999%}
        $response = new Phalcon\Http\Response();

        if ($status->success() == true) {
            $response->setJsonContent(array('status' => 'OK'));
        } else {

            //{%tutorial-rest_119ca4b05ef54588a2c7015f0293e6e1%}
            $response->setStatusCode(409, "Conflict");

            $errors = array();
            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(array('status' => 'ERROR', 'messages' => $errors));

        }

        return $response;
    });


%{tutorial-rest_51eee60ebdb66fb5770c4b406440fa69}%
-----------------------
%{tutorial-rest_a444b76b57459a80926fdb40855d43a2}%

%{tutorial-rest_3d2d6a49b68a620826b98699fcf385c7}%

.. code-block:: bash

    curl -i -X GET http://{%tutorial-rest_41285e4a0ec6a25351e2d5edc06f7314%}

    HTTP/1.1 200 OK
    Date: Wed, 12 Sep 2012 07:05:13 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 117
    Content-Type: text/html; charset=UTF-8

    [{"id":"1","name":"Robotina"},{"id":"2","name":"Astro Boy"},{"id":"3","name":"Terminator"}]


%{tutorial-rest_bf489f2e18b48c2f62bc412fafde1f6e}%

.. code-block:: bash

    curl -i -X GET http://{%tutorial-rest_b6f9a34fc994c4ceb77dbc8ec3a3c2c0%}

    HTTP/1.1 200 OK
    Date: Wed, 12 Sep 2012 07:09:23 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 31
    Content-Type: text/html; charset=UTF-8

    [{"id":"2","name":"Astro Boy"}]


%{tutorial-rest_b9dffca52615184a38ea1e4489835f73}%

.. code-block:: bash

    curl -i -X GET http://{%tutorial-rest_9d198cf3c21c49511427348e222c8873%}

    HTTP/1.1 200 OK
    Date: Wed, 12 Sep 2012 07:12:18 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 56
    Content-Type: text/html; charset=UTF-8

    {"status":"FOUND","data":{"id":"3","name":"Terminator"}}


%{tutorial-rest_65b7312d59b7814f9bfa796c27ab68b6}%

.. code-block:: bash

    curl -i -X POST -d '{"name":"C-3PO","type":"droid","year":1977}'
        http://{%tutorial-rest_41285e4a0ec6a25351e2d5edc06f7314%}

    HTTP/1.1 201 Created
    Date: Wed, 12 Sep 2012 07:15:09 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 75
    Content-Type: text/html; charset=UTF-8

    {"status":"OK","data":{"name":"C-3PO","type":"droid","year":1977,"id":"4"}}


%{tutorial-rest_d4a9e00a9a3acabf59087aa2cf8fadba}%

.. code-block:: bash

    curl -i -X POST -d '{"name":"C-3PO","type":"droid","year":1977}'
        http://{%tutorial-rest_41285e4a0ec6a25351e2d5edc06f7314%}

    HTTP/1.1 409 Conflict
    Date: Wed, 12 Sep 2012 07:18:28 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 63
    Content-Type: text/html; charset=UTF-8

    {"status":"ERROR","messages":["The robot name must be unique"]}


%{tutorial-rest_f92c146e69ddce8c07d9e73c23321f2a}%

.. code-block:: bash

    curl -i -X PUT -d '{"name":"ASIMO","type":"humanoid","year":2000}'
        http://{%tutorial-rest_76e5a40776e0a1197e6a888715e1a49d%}

    HTTP/1.1 409 Conflict
    Date: Wed, 12 Sep 2012 08:48:01 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 104
    Content-Type: text/html; charset=UTF-8

    {"status":"ERROR","messages":["Value of field 'type' must be part of
        list: droid, mechanical, virtual"]}


%{tutorial-rest_b66492ddc59541e4dd170275cf479f68}%

.. code-block:: bash

    curl -i -X DELETE http://{%tutorial-rest_76e5a40776e0a1197e6a888715e1a49d%}

    HTTP/1.1 200 OK
    Date: Wed, 12 Sep 2012 08:49:29 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 15
    Content-Type: text/html; charset=UTF-8

    {"status":"OK"}


%{tutorial-rest_ee50f1d496b9cd00d5955f10f6dc7517}%
----------
%{tutorial-rest_d1768dfac9d235a51439b9396104e171|:doc:`PHQL <phql>`}%

