Урок 7: Создание простейшего REST API
=====================================

В этом уроке мы объясним, как создать простейшее приложение, предоставляющее RESTful_ API с использованием
различных HTTP методов:

* GET для получения и поиска данных
* POST для добавления данных
* PUT для обновления данных
* DELETE для удаления данных

Определение API
---------------
Наше API содержит следующие методы:

+--------+----------------------------+----------------------------------------------------------+
| Метод  |  URL                       | Действие                                                 |
+========+============================+==========================================================+
| GET    | /api/robots                | Возвращает всех роботов                                  |
+--------+----------------------------+----------------------------------------------------------+
| GET    | /api/robots/search/Astro   | Производит поиск роботов с "Astro" в имени               |
+--------+----------------------------+----------------------------------------------------------+
| GET    | /api/robots/2              | Возвращает робота по его первичному ключу                |
+--------+----------------------------+----------------------------------------------------------+
| POST   | /api/robots                | Добавляет нового робота                                  |
+--------+----------------------------+----------------------------------------------------------+
| PUT    | /api/robots/2              | Обновляет робота по его первичному ключу                 |
+--------+----------------------------+----------------------------------------------------------+
| DELETE | /api/robots/2              | Удаляет робота по его первичному ключу                   |
+--------+----------------------------+----------------------------------------------------------+

Создание приложения
-------------------
Поскольку приложение очень простое, мы не будем включать полное MVC окружение для его разработки. В этом случае для
достижения нашей цели мы будем использовать :doc:`микроприложение <micro>`.

Такой структуры файлов будет более чем достаточно:

.. code-block:: php

    my-rest-api/
        models/
            Robots.php
        index.php
        .htaccess

Прежде всего, нам понадобится файл .htaccess, который содержит все правила перенаправления URI на файл index.php.
Для нашего приложения он будет таким:

.. code-block:: apacheconf

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

После этого создаём файл index.php:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;

    $app = new Micro();

    // Тут определяются маршруты

    $app->handle();

Теперь мы пропишем маршруты, как определили выше:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;

    $app = new Micro();

    // Получение всех роботов
    $app->get(
        "/api/robots",
        function () {

        }
    );

    // Поиск роботов с $name в названии
    $app->get(
        "/api/robots/search/{name}",
        function ($name) {

        }
    );

    // Получение робота по первичному ключу
    $app->get(
        "/api/robots/{id:[0-9]+}",
        function ($id) {

        }
    );

    // Добавление нового робота
    $app->post(
        "/api/robots",
        function () {

        }
    );

    // Обновление робота по первичному ключу
    $app->put(
        "/api/robots/{id:[0-9]+}",
        function () {

        }
    );

    // Удаление робота по первичному ключу
    $app->delete(
        "/api/robots/{id:[0-9]+}",
        function () {

        }
    );

    $app->handle();

Каждый маршрут задан с помощью метода с таким же названием, что и HTTP метод. В качестве первого параметра мы передаём шаблон маршрута,
вторым — обработчик, который в нашем случае является анонимной функцией. Такой маршрут, как :code:`'/api/robots/{id:[0-9]+}'`
однозначно устанавливает, что параметр "id" должен быть числом.

Когда определено соответствие маршрутов запрашиваемым URI, тогда приложение выполняет соответствующие им обработчики.

Создание модели
---------------
Наше API предоставляет информацию о "роботах", хранящуюся в базе данных. Описанная ниже модель позволяет нам
получить доступ к таблице объектно-ориентированным путём. Мы реализуем немного бизнес-правил, используя встроенные валидаторы
с простейшими проверками. Мы делаем это, чтобы иметь уверенность в том, что сохраняемые данные отвечают требованиям нашего
приложения:

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
            // Тип робота должен быть: droid, mechanical или virtual
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

            // Имя робота должно быть уникальным
            $this->validate(
                new Uniqueness(
                    [
                        "field"   => "name",
                        "message" => "Имя робота должно быть уникальным",
                    ]
                )
            );

            // Год не может быть меньше нуля
            if ($this->year < 0) {
                $this->appendMessage(
                    new Message("Год не может быть меньше нуля")
                );
            }

            // Проверяем, были ли получены какие-либо сообщения при валидации
            if ($this->validationHasFailed() === true) {
                return false;
            }
        }
    }

Теперь мы должны настроить соединение с базой данных, чтобы использовать его в этой модели:

.. code-block:: php

    <?php

    use Phalcon\Loader;
    use Phalcon\Mvc\Micro;
    use Phalcon\Di\FactoryDefault;
    use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

    // Используем Loader() для автозагрузки нашей модели
    $loader = new Loader();

    $loader->registerNamespaces(
        [
            "Store\\Toys" => __DIR__ . "/models/",
        ]
    );

    $loader->register();

    $di = new FactoryDefault();

    // Настраиваем сервис базы данных
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

    // Создаем и привязываем DI к приложению
    $app = new Micro($di);

Получение данных
----------------
Сначала мы реализуем обработчик, который отвечает на GET-запрос и возвращает всех доступных роботов. Для выполнения
этой задачи будем использовать PHQL, который будет возвращать результат выполнения простого запроса в формате JSON:

.. code-block:: php

    <?php

    // Получение всех роботов
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

:doc:`PHQL <phql>` позволяет нам писать запросы с помощью высокоуровневого, объектно-ориентированного SQL-диалекта,
которые внутри него будут переведены в правильные SQL-операторы в зависимости от используемой СУБД. "use" в
определении анонимной функции позволяет нам легко передать некоторые переменные из глобальной области видимости в локальную.

Обработчик поиска по названию будет выглядеть следующим образом:

.. code-block:: php

    <?php

    // Поиск роботов с $name в названии
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

В нашем случае поиск по полю "id" очень похож, кроме того, мы сообщаем, найден робот или нет:

.. code-block:: php

    <?php

    use Phalcon\Http\Response;

    // Получение робота по первичному ключу
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



            // Формируем ответ
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

Вставка данных
--------------
Получая данные в виде JSON-строки, вставленной в тело запроса, мы точно так же используем PHQL для вставки:

.. code-block:: php

    <?php

    use Phalcon\Http\Response;

    // Добавление нового робота
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

            // Формируем ответ
            $response = new Response();

            // Проверяем, что вставка произведена успешно
            if ($status->success() === true) {
                // Меняем HTTP статус
                $response->setStatusCode(201, "Created");

                $robot->id = $status->getModel()->id;

                $response->setJsonContent(
                    [
                        "status" => "OK",
                        "data"   => $robot,
                    ]
                );
            } else {
                // Меняем HTTP статус
                $response->setStatusCode(409, "Conflict");

                // Отправляем сообщение об ошибке клиенту
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

Обновление данных
-----------------
Обновление данных аналогично их вставке. Полученный параметр "id" сообщает о том, информацию о каком роботе необходимо обновить:

.. code-block:: php

    <?php

    use Phalcon\Http\Response;

    // Обновление робота по первичному ключу
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

            // Формируем ответ
            $response = new Response();

            // Проверяем, что обновление произведено успешно
            if ($status->success() === true) {
                $response->setJsonContent(
                    [
                        "status" => "OK"
                    ]
                );
            } else {
                // Меняем HTTP статус
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

Удаление данных
---------------
Удаление очень похоже на обновление. Полученный параметр "id" сообщает о том, какого робота необходимо удалить:

.. code-block:: php

    <?php

    use Phalcon\Http\Response;

    // Удаление робота по первичному ключу
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

            // Формируем ответ
            $response = new Response();

            if ($status->success() === true) {
                $response->setJsonContent(
                    [
                        "status" => "OK"
                    ]
                );
            } else {
                // Меняем HTTP статус
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

Тестирование приложения
-----------------------
Используя curl_ мы протестируем все маршруты нашего приложения для проверки правильности его функционирования.

Получение всех роботов:

.. code-block:: bash

    curl -i -X GET http://localhost/my-rest-api/api/robots

    HTTP/1.1 200 OK
    Date: Tue, 21 Jul 2015 07:05:13 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 117
    Content-Type: text/html; charset=UTF-8

    [{"id":"1","name":"Robotina"},{"id":"2","name":"Astro Boy"},{"id":"3","name":"Terminator"}]

Поиск робота по имени:

.. code-block:: bash

    curl -i -X GET http://localhost/my-rest-api/api/robots/search/Astro

    HTTP/1.1 200 OK
    Date: Tue, 21 Jul 2015 07:09:23 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 31
    Content-Type: text/html; charset=UTF-8

    [{"id":"2","name":"Astro Boy"}]

Получение робота по id:

.. code-block:: bash

    curl -i -X GET http://localhost/my-rest-api/api/robots/3

    HTTP/1.1 200 OK
    Date: Tue, 21 Jul 2015 07:12:18 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 56
    Content-Type: text/html; charset=UTF-8

    {"status":"FOUND","data":{"id":"3","name":"Terminator"}}

Добавление робота:

.. code-block:: bash

    curl -i -X POST -d '{"name":"C-3PO","type":"droid","year":1977}'
        http://localhost/my-rest-api/api/robots

    HTTP/1.1 201 Created
    Date: Tue, 21 Jul 2015 07:15:09 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 75
    Content-Type: text/html; charset=UTF-8

    {"status":"OK","data":{"name":"C-3PO","type":"droid","year":1977,"id":"4"}}

Попытка добавить робота с уже существующим именем:

.. code-block:: bash

    curl -i -X POST -d '{"name":"C-3PO","type":"droid","year":1977}'
        http://localhost/my-rest-api/api/robots

    HTTP/1.1 409 Conflict
    Date: Tue, 21 Jul 2015 07:18:28 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 63
    Content-Type: text/html; charset=UTF-8

    {"status":"ERROR","messages":["Имя робота должно быть уникальным"]}

Или обновление робота с неизвестным типом:

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

И, наконец, удаление робота:

.. code-block:: bash

    curl -i -X DELETE http://localhost/my-rest-api/api/robots/4

    HTTP/1.1 200 OK
    Date: Tue, 21 Jul 2015 08:49:29 GMT
    Server: Apache/2.2.22 (Unix) DAV/2
    Content-Length: 15
    Content-Type: text/html; charset=UTF-8

    {"status":"OK"}

Заключение
----------
Как видно, с помощью Phalcon легко разработать RESTful API. Позже мы подробно объясним в документации как
использовать микроприложения и язык :doc:`PHQL <phql>`.

.. _curl: http://ru.wikipedia.org/wiki/CURL
.. _RESTful: http://ru.wikipedia.org/wiki/REST
