Tutorial 7: Créer une application REST API
==========================================

Dans ce tutoriel, nous allons montrer comment créer une simple application qui fourni une API RESTful_ en utilisant les
méthodes HTTP suivantes :

* GET pour récupérer et chercher les données
* POST pour ajouter des données
* PUT pour modifier les données
* DELETE pour supprimer les données

Définir l'API
-------------
L'API comprends les méthodes suivantes :

+--------+----------------------------+----------------------------------------------------------+
| Method |  URL                       | Action                                                   |
+========+============================+==========================================================+
| GET    | /api/robots                | Récupérer tous les robots                                |
+--------+----------------------------+----------------------------------------------------------+
| GET    | /api/robots/search/Astro   | Cherche les robots ayant 'Astro' dans leur nom           |
+--------+----------------------------+----------------------------------------------------------+
| GET    | /api/robots/2              | Récupèrer les robots à partir de leur clé primaire       |
+--------+----------------------------+----------------------------------------------------------+
| POST   | /api/robots                | Ajouter un nouveau robot                                 |
+--------+----------------------------+----------------------------------------------------------+
| PUT    | /api/robots/2              | Modifier les robots à partir de leur clé primaire        |
+--------+----------------------------+----------------------------------------------------------+
| DELETE | /api/robots/2              | Supprimer les robots à partir de leur clé primaire       |
+--------+----------------------------+----------------------------------------------------------+

Créer l'application
-------------------
Comme l'application est relativement simple, nous n'allons pas implémenter un environnement MVC complet. Dans notre cas
nous allons utiliser une :doc:`micro application <micro>`.

La structure de fichier suivante sera largement suffisante :

.. code-block:: php

    my-rest-api/
        models/
            Robots.php
        index.php
        .htaccess

Tout d'abord nous avons besoin d'un .htaccess qui va contenir toutes les règles de réécriture d'URL pour notre
fichier index.php :

.. code-block:: apacheconf

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

Ensuite dans notre fichier index.php, on ajoute ceci :

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;

    $app = new Micro();

    // Define the routes here

    $app->handle();

Maintenant, nous allons créer les routes comme défini au dessus (le tableau) :

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;

    $app = new Micro();

    // Retrieves all robots
    $app->get(
        "/api/robots",
        function () {

        }
    );

    // Searches for robots with $name in their name
    $app->get(
        "/api/robots/search/{name}",
        function ($name) {

        }
    );

    // Retrieves robots based on primary key
    $app->get(
        "/api/robots/{id:[0-9]+}",
        function ($id) {

        }
    );

    // Adds a new robot
    $app->post(
        "/api/robots",
        function () {

        }
    );

    // Updates robots based on primary key
    $app->put(
        "/api/robots/{id:[0-9]+}",
        function () {

        }
    );

    // Deletes robots based on primary key
    $app->delete(
        "/api/robots/{id:[0-9]+}",
        function () {

        }
    );

    $app->handle();

Chaque route est définie avec une méthode qui a le même nom que la requête HTTP. Le premier paramètre est le modèle de la route
suivi par une fonction anonyme. La route suivante :code:`'/api/robots/{id:[0-9]+}'`,
par exemple, prends un paramètre ID qui doit nécessairement avoir un format numérique.

Quand une requête URI corresponds à une route défini, l'application exécute la fonction anonyme qui lui est liée.

Créer un Model
--------------
Notre API fournit des informations sur les 'robots', ces données doivent donc être enregistrées dans une base de données. Le model suivant nous permet
d'accéder à la table comme si c'était un objet. Nous avons implémenté quelques règles en utilisant des validateurs.
Ainsi nous serons tranquilles car les données respecteront toujours les conditions nécessaires pour notre
application :

.. code-block:: php

    <?php

    namespace Store\Toys;

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
                    [
                        "field"  => "type",
                        "domain" => [
                            "droid",
                            "mechanical",
                            "virtual",
                        ]
                    )
                )
            );

            // Robot name must be unique
            $this->validate(
                new Uniqueness(
                    [
                        "field"   => "name",
                        "message" => "The robot name must be unique",
                    ]
                )
            );

            // Year cannot be less than zero
            if ($this->year < 0) {
                $this->appendMessage(
                    new Message("The year cannot be less than zero")
                );
            }

            // Check if any messages have been produced
            if ($this->validationHasFailed() === true) {
                return false;
            }
        }
    }

Maintenant nous devons mettre en place la connexion qui sera utilisée par le model and load it within our app :

.. code-block:: php

    <?php

    use Phalcon\Loader;
    use Phalcon\Mvc\Micro;
    use Phalcon\Di\FactoryDefault;
    use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

    // Use Loader() to autoload our model
    $loader = new Loader();

    $loader->registerNamespaces(
        [
            "Store\\Toys" => __DIR__ . "/models/",
        ]
    );

    $loader->register();

    $di = new FactoryDefault();

    // Set up the database service
    $di->set(
        "db",
        function () {
            return new PdoMysql(
                [
                    "host"     => "localhost",
                    "username" => "asimov",
                    "password" => "zeroth",
                    "dbname"   => "robotics",
                ]
            );
        }
    );

    // Create and bind the DI to the application
    $app = new Micro($di);

Récupérer les données
---------------------
Le premier gestionnaire que l'on a implémenté est celui qui retourne tous les robots à partir d'une méthode GET. Utilisons PHQL pour
exécuter une simple requête qui retourne les résultats sous forme de JSON :

.. code-block:: php

    <?php

    // Retrieves all robots
    $app->get(
        "/api/robots",
        function () use ($app) {
            $phql = "SELECT * FROM Store\\Toys\\Robots ORDER BY name";

            $robots = $app->modelsManager->executeQuery($phql);

            $data = [];

            foreach ($robots as $robot) {
                $data[] = [
                    "id"   => $robot->id,
                    "name" => $robot->name,
                ];
            }

            echo json_encode($data);
        }
    );

:doc:`PHQL <phql>`, nous permet d'écrire des requêtes en utilisant un dialect SQL haut niveau et orienté objet qui va
traduire la syntaxe SQL des requêtes en fonction du système de base de données que l'on utilise. Le mot clé "use" dans la
fonction anonyme nous permet de passer des variable golables sous forme locale facilement.

La recherche par nom ressemblera à cela :

.. code-block:: php

    <?php

    // Searches for robots with $name in their name
    $app->get(
        "/api/robots/search/{name}",
        function ($name) use ($app) {
            $phql = "SELECT * FROM Store\\Toys\\Robots WHERE name LIKE :name: ORDER BY name";

            $robots = $app->modelsManager->executeQuery(
                $phql,
                [
                    "name" => "%" . $name . "%"
                ]
            );

            $data = [];

            foreach ($robots as $robot) {
                $data[] = [
                    "id"   => $robot->id,
                    "name" => $robot->name,
                ];
            }

            echo json_encode($data);
        }
    );

Chercher avec l'identifiant "id" est relativement identique, dans notre cas, nous allons notifier l'utilisateur si le robot n'existe pas :

.. code-block:: php

    <?php

    use Phalcon\Http\Response;

    // Retrieves robots based on primary key
    $app->get(
        "/api/robots/{id:[0-9]+}",
        function ($id) use ($app) {
            $phql = "SELECT * FROM Store\\Toys\\Robots WHERE id = :id:";

            $robot = $app->modelsManager->executeQuery(
                $phql,
                [
                    "id" => $id,
                ]
            )->getFirst();



            // Create a response
            $response = new Response();

            if ($robot === false) {
                $response->setJsonContent(
                    [
                        "status" => "NOT-FOUND"
                    ]
                );
            } else {
                $response->setJsonContent(
                    [
                        "status" => "FOUND",
                        "data"   => [
                            "id"   => $robot->id,
                            "name" => $robot->name
                        ]
                    ]
                );
            }

            return $response;
        }
    );

Ajouter des données
-------------------
Prenons la données comme une chaine JSON que l'on insert dans le corps de la requête. Nous allons utiliser PHQL pour l'insertion :

.. code-block:: php

    <?php

    use Phalcon\Http\Response;

    // Adds a new robot
    $app->post(
        "/api/robots",
        function () use ($app) {
            $robot = $app->request->getJsonRawBody();

            $phql = "INSERT INTO Store\\Toys\\Robots (name, type, year) VALUES (:name:, :type:, :year:)";

            $status = $app->modelsManager->executeQuery(
                $phql,
                [
                    "name" => $robot->name,
                    "type" => $robot->type,
                    "year" => $robot->year,
                ]
            );

            // Create a response
            $response = new Response();

            // Check if the insertion was successful
            if ($status->success() === true) {
                // Change the HTTP status
                $response->setStatusCode(201, "Created");

                $robot->id = $status->getModel()->id;

                $response->setJsonContent(
                    [
                        "status" => "OK",
                        "data"   => $robot,
                    ]
                );
            } else {
                // Change the HTTP status
                $response->setStatusCode(409, "Conflict");

                // Send errors to the client
                $errors = [];

                foreach ($status->getMessages() as $message) {
                    $errors[] = $message->getMessage();
                }

                $response->setJsonContent(
                    [
                        "status"   => "ERROR",
                        "messages" => $errors,
                    ]
                );
            }

            return $response;
        }
    );

Modifier les données
--------------------
La modification de données est similaire à l'insertion. L'ID passé en paramètre indique quel robot doit être modifié :

.. code-block:: php

    <?php

    use Phalcon\Http\Response;

    // Updates robots based on primary key
    $app->put(
        "/api/robots/{id:[0-9]+}",
        function ($id) use ($app) {
            $robot = $app->request->getJsonRawBody();

            $phql = "UPDATE Store\\Toys\\Robots SET name = :name:, type = :type:, year = :year: WHERE id = :id:";

            $status = $app->modelsManager->executeQuery(
                $phql,
                [
                    "id"   => $id,
                    "name" => $robot->name,
                    "type" => $robot->type,
                    "year" => $robot->year,
                ]
            );

            // Create a response
            $response = new Response();

            // Check if the insertion was successful
            if ($status->success() === true) {
                $response->setJsonContent(
                    [
                        "status" => "OK"
                    ]
                );
            } else {
                // Change the HTTP status
                $response->setStatusCode(409, "Conflict");

                $errors = [];

                foreach ($status->getMessages() as $message) {
                    $errors[] = $message->getMessage();
                }

                $response->setJsonContent(
                    [
                        "status"   => "ERROR",
                        "messages" => $errors,
                    ]
                );
            }

            return $response;
        }
    );

Supprimer des données
---------------------
La suppression de données est relativement identique à la modification. L'identifiant est aussi passé en paramètre pour indiquer quel robot doit être supprimé :

.. code-block:: php

    <?php

    use Phalcon\Http\Response;

    // Deletes robots based on primary key
    $app->delete(
        "/api/robots/{id:[0-9]+}",
        function ($id) use ($app) {
            $phql = "DELETE FROM Store\\Toys\\Robots WHERE id = :id:";

            $status = $app->modelsManager->executeQuery(
                $phql,
                [
                    "id" => $id,
                ]
            );

            // Create a response
            $response = new Response();

            if ($status->success() === true) {
                $response->setJsonContent(
                    [
                        "status" => "OK"
                    ]
                );
            } else {
                // Change the HTTP status
                $response->setStatusCode(409, "Conflict");

                $errors = [];

                foreach ($status->getMessages() as $message) {
                    $errors[] = $message->getMessage();
                }

                $response->setJsonContent(
                    [
                        "status"   => "ERROR",
                        "messages" => $errors,
                    ]
                );
            }

            return $response;
        }
    );

Tester notre application
------------------------
En utilisant curl_ nous allons tester chaque route de notre application et vérifier que les opérations fonctionnent correctement.

Récupérer tous les robots :

.. code-block:: bash

    curl -i -X GET http://localhost/my-rest-api/api/robots

    HTTP/1.1 200 OK
    Date: Tue, 21 Jul 2015 07:05:13 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 117
    Content-Type: text/html; charset=UTF-8

    [{"id":"1","name":"Robotina"},{"id":"2","name":"Astro Boy"},{"id":"3","name":"Terminator"}]

Chercher un robot par son nom :

.. code-block:: bash

    curl -i -X GET http://localhost/my-rest-api/api/robots/search/Astro

    HTTP/1.1 200 OK
    Date: Tue, 21 Jul 2015 07:09:23 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 31
    Content-Type: text/html; charset=UTF-8

    [{"id":"2","name":"Astro Boy"}]

Récupérer un robot par son ID :

.. code-block:: bash

    curl -i -X GET http://localhost/my-rest-api/api/robots/3

    HTTP/1.1 200 OK
    Date: Tue, 21 Jul 2015 07:12:18 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 56
    Content-Type: text/html; charset=UTF-8

    {"status":"FOUND","data":{"id":"3","name":"Terminator"}}

Insérer un nouveau robot :

.. code-block:: bash

    curl -i -X POST -d '{"name":"C-3PO","type":"droid","year":1977}'
        http://localhost/my-rest-api/api/robots

    HTTP/1.1 201 Created
    Date: Tue, 21 Jul 2015 07:15:09 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 75
    Content-Type: text/html; charset=UTF-8

    {"status":"OK","data":{"name":"C-3PO","type":"droid","year":1977,"id":"4"}}

Essayer d'insérer un nouveau robot avec le nom d'un robot existant :

.. code-block:: bash

    curl -i -X POST -d '{"name":"C-3PO","type":"droid","year":1977}'
        http://localhost/my-rest-api/api/robots

    HTTP/1.1 409 Conflict
    Date: Tue, 21 Jul 2015 07:18:28 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 63
    Content-Type: text/html; charset=UTF-8

    {"status":"ERROR","messages":["The robot name must be unique"]}

Modifier un robot avec un type inconnu :

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

Enfin, la suppresion de robots :

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
Comme nous l'abons vu, développer une API RESTful avec Phalcon est simple. Plus loin dans la documentation, nous expliqueront en détail comment
utiliser une micro application et nous aborderont aussi le langage :doc:`PHQL <phql>` plus en détail.

.. _curl: http://fr.wikipedia.org/wiki/CURL
.. _RESTful: http://fr.wikipedia.org/wiki/Representational_State_Transfer
