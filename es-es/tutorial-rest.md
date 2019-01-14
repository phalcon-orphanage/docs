* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='basic'></a>

# Tutorial: Crear una API REST simple

In this tutorial, we will explain how to create a simple application that provides a [RESTful](https://en.wikipedia.org/wiki/Representational_state_transfer) API using the different HTTP methods:

* `GET` para recuperar y buscar datos
* `POST` para agregar datos
* `PUT` para actualizar datos
* `DELETE` para borrar datos

<a name='definitions'></a>

## Definición de la API

La API consta de los siguientes métodos:

| Método   | URL                      | Action                                          |
| -------- | ------------------------ | ----------------------------------------------- |
| `GET`    | /api/robots              | Recupera todos los robots                       |
| `GET`    | /api/robots/search/Astro | Busca robots que contienen 'Astro' en su nombre |
| `GET`    | /api/robots/2            | Recupera robots basados en la clave principal   |
| `POST`   | /api/robots              | Agrega un nuevo robot                           |
| `PUT`    | /api/robots/2            | Actualiza robots basados en la clave principal  |
| `DELETE` | /api/robots/2            | Elimina robots basados en la clave principal    |

<a name='implementation'></a>

## Creando la aplicación

As the application is so simple, we will not implement any full MVC environment to develop it. In this case, we will use a [micro application](/4.0/en/application-micro) to meet our goal.

La siguiente estructura de archivos es más que suficiente:

```php
my-rest-api/
    models/
        Robots.php
    index.php
    .htaccess
```

En primer lugar, necesitamos un archivo `.htaccess` que contiene todas las reglas para reescribir la solicitud URI hacia el archivo `index.php` (punto de entrada de la aplicación):

```apacheconfig
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
</IfModule>
```

La mayor parte de nuestro código se colocará en `index.php`. El archivo se crea de la sigue manera:

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

// Aquí definimos las rutas 

$app->handle();
```

Ahora vamos a crear las rutas como las hemos definido anteriormente:

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

// Recupera todos los robots
$app->get(
    '/api/robots',
    function () {
        // Operaciones para recuperar todos los robots
    }
);

// Buscar robots que contienen $name en su nombre
$app->get(
    '/api/robots/search/{name}',
    function ($name) {
        // Operaciones para recuperar robots con que contienen $name en su nombre
    }
);

// Recuperar robots basados en su clave primaria
$app->get(
    '/api/robots/{id:[0-9]+}',
    function ($id) {
        // Obtener un robot por su id $id
    }
);

// Agregar un nuevo robot
$app->post(
    '/api/robots',
    function () {
        // Operación para crear un nuevo robot
    }
);

// Actualizar robots basados en su clave primaria
$app->put(
    '/api/robots/{id:[0-9]+}',
    function ($id) {
        // Operación para actualizar el robot con id $id
    }
);

// Borrar robots basados en su clave primaria
$app->delete(
    '/api/robots/{id:[0-9]+}',
    function ($id) {
        // Operación para borrar el robot con id $id
    }
);

$app->handle();
```

Cada ruta se define con un método con el mismo nombre que el método HTTP, como primer parámetro que pasaremos un patrón de ruta, seguido por un controlador. En este caso, el controlador es una función anónima. La siguiente ruta: `/api/robots/{id:[0-9]+}`, por ejemplo, establece explícitamente que el parámetro `id` debe tener un formato numérico.

Cuando una ruta definida coincide con el identificador URI solicitando, entonces la aplicación ejecuta el controlador correspondiente.

<a name='models'></a>

## Creando un modelo

Nuestra API proporciona información sobre `robots`, estos datos están almacenados en una base de datos. El siguiente modelo nos permite acceder a la tabla de una manera orientada a objetos. Hemos implementado algunas reglas del negocio usando validadores incorporados y validaciones simples. Esto nos da la tranquilidad que guarda datos cumpliendo con los requisitos de nuestra aplicación. Este archivo de modelo debe colocarse en la carpeta `models`.

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

Ahora, debemos configurar una conexión para ser utilizada por este modelo y cargala dentro de nuestra aplicación [archivo: `index.php`]:

```php
<?php

use Phalcon\Loader;
use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

// Utilizar Loader para autocargar nuestros modelos
$loader = new Loader();

$loader->registerNamespaces(
    [
        'Store\Toys' => __DIR__ . '/models/',
    ]
);

$loader->register();

$di = new FactoryDefault();

// Configurar el servicio de base de datos
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

// Crear y enlazar el DI a la aplicación
$app = new Micro($di);
```

<a name='retrieving-data'></a>

## Recuperando Datos

El primer `controlador` que vamos a implementar es por el método GET que devuelve los robots disponibles. Vamos a utilizar PHQL para realizar esta consulta simple y devolver los resultados en formato JSON. [Archivo: `index.php`]

```php
<?php

// Recuperar todos los robots
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

[PHQL](/4.0/en/db-phql), allow us to write queries using a high-level, object-oriented SQL dialect that internally translates to the right SQL statements depending on the database system we are using. La cláusula `use` en la función anónima nos permite pasar algunas variables del ámbito global al local fácilmente.

El controlador de búsqueda por nombre se vería como [archivo: `index.php`]:

```php
<?php

// Busqueda de robots con $name en su nombre
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

Buscando por el campo `id` es bastante similar, en este caso, también estamos notificando si el robot se encontró o no [archivo: `index.php`]:

```php
<?php

use Phalcon\Http\Response;

// Recuperar robots basado en la clave primaria
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



        // Crear una respuesta
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

## Insertando datos

Tomando los datos como una cadena JSON insertada en el cuerpo de la solicitud, también utilizamos PHQL para la inserción [archivo: `index.php`]:

```php
<?php

use Phalcon\Http\Response;

// Agregar un nuevo robot
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

        // Crear una respuesta
        $response = new Response();

        // Comprobar si la inserción fue exitosa
        if ($status->success() === true) {
            // Cambiar el status de HTTP
            $response->setStatusCode(201, 'Creado');

            $robot->id = $status->getModel()->id;

            $response->setJsonContent(
                [
                    'status' => 'OK',
                    'data'   => $robot,
                ]
            );
        } else {
            // Cambiar el status de HTTP
            $response->setStatusCode(409, 'Conflicto');

            // Enviar errores al cliente
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

## Actualizando datos

La actualización de datos es similar a la inserción. El `id` como parámetro indica qué robot debe actualizarse [archivo: `index.php`]:

```php
<?php

use Phalcon\Http\Response;

// Actualizar robots basados en la clave primaria
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

        // Crear una respuesta
        $response = new Response();

        // Comprobar si la inserción fue exitosa
        if ($status->success() === true) {
            $response->setJsonContent(
                [
                    'status' => 'OK'
                ]
            );
        } else {
            // Cambiar el status de HTTP
            $response->setStatusCode(409, 'Conflicto');

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

## Borrando datos

La eliminación de datos es similar a actualizar. El `id` como parámetro indica qué robot debe ser eliminado [archivo: `index.php`]:

```php
<?php

use Phalcon\Http\Response;

// Borrando robots basados en la clave primaria
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

        // Crear una respuesta
        $response = new Response();

        if ($status->success() === true) {
            $response->setJsonContent(
                [
                    'status' => 'OK'
                ]
            );
        } else {
            // Cambiar el status de HTTP
            $response->setStatusCode(409, 'Conflicto');

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

## Creando una base de datos

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

## Probando nuestra aplicación

Using [curl](https://en.wikipedia.org/wiki/CURL) we'll test every route in our application verifying its proper operation.

Obtener todos los robots:

```bash
curl -i -X GET https://localhost/my-rest-api/api/robots

HTTP/1.1 200 OK
Date: Tue, 21 Jul 2015 07:05:13 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 117
Content-Type: text/html; charset=UTF-8

[{"id":"1","name":"Robotina"},{"id":"2","name":"Astro Boy"},{"id":"3","name":"Terminator"}]
```

Buscar un robot por su nombre:

```bash
curl -i -X GET https://localhost/my-rest-api/api/robots/search/Astro

HTTP/1.1 200 OK
Date: Tue, 21 Jul 2015 07:09:23 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 31
Content-Type: text/html; charset=UTF-8

[{"id":"2","name":"Astro Boy"}]
```

Obtener un robot por su id:

```bash
curl -i -X GET https://localhost/my-rest-api/api/robots/3

HTTP/1.1 200 OK
Date: Tue, 21 Jul 2015 07:12:18 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 56
Content-Type: text/html; charset=UTF-8

{"status":"FOUND","data":{"id":"3","name":"Terminator"}}
```

Insertar un nuevo robot:

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

Intentar insertar un nuevo robot con el nombre de un robot existente:

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

O actualizar un robot con un tipo desconocido:

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

Por último, eliminar un robot:

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

## Conclusión

As we saw, developing a [RESTful](https://en.wikipedia.org/wiki/Representational_state_transfer) API with Phalcon is easy using [micro applications](/4.0/en/application-micro) and [PHQL](/4.0/en/db-phql).