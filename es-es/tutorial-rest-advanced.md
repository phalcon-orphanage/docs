---
layout: default
language: 'es-es'
version: '4.0'
title: 'Tutorial - REST'
keywords: 'tutorial, tutorial rest, api, rest, paso a paso, micro'
---

# Tutorial - REST
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen
La aplicación `REST API` es una aplicación que muestra cómo puede crear una API [RESTful](https://en.wikipedia.org/wiki/Representational_state_transfer) usando Phalcon. En este tutorial, usamos la aplicación [Micro](application-micro). También usaremos \[Phinx\]\[phinx\] para las migraciones de nuestra base de datos, \[JSON Web Tokens (JWT)\]\[jwt\] para autenticación así como \[JSON API\]\[jsonapi\] para las respuestas estructuradas.

## Instalación
## Estructura
## Instalación
## Dependencias
La aplicación necesita un mínimo de PHP 7.2 y las siguientes extensiones disponibles:
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

Las dependencias restantes para el proyecto se instalan usando composer.

## Proveedores
Configurando el


## Controladores
## Modelos
## Rutas

| Método | Descripción                                                                       |
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
### Autenticación
### Tokens
### Verificación
### Validación
### Respuesta

## CLI




En este tutorial, explicaremos cómo crear una aplicación simple que proporcione una API [RESTful](https://es.wikipedia.org/wiki/Transferencia_de_Estado_Representacional) usando los diferentes métodos HTTP:

* `GET` para recuperar y buscar datos
* `POST` para agregar datos
* `PUT` para actualizar datos
* `DELETE` para borrar datos

## Definiendo la API
La API consiste en los siguientes métodos:

| Método   | URL                      | Acción                                              |
| -------- | ------------------------ | --------------------------------------------------- |
| `GET`    | /api/robots              | Recupera todos los robots                           |
| `GET`    | /api/robots/search/Astro | Busca robots con 'Astro' en su nombre               |
| `GET`    | /api/robots/2            | Recupera robots basados en la clave primaria        |
| `POST`   | /api/robots              | Añade un nuevo robot                                |
| `PUT`    | /api/robots/2            | Actualiza los robots basándose en la clave primaria |
| `DELETE` | /api/robots/2            | Borra robots basándose en la clave primaria         |

## Creando la Aplicación
Como la aplicación es muy simple, no implementaremos ningún entorno MVC completo para desarrollarla. En este caso, usaremos una [aplicación micro](application-micro) para alcanzar nuestro objetivo.

Las siguiente estructura de ficheros es más que suficiente:

```php
my-rest-api/
    models/
        Robots.php
    index.php
    .htaccess
```

Primero, necesitamos un fichero `.htaccess` que contenta todas las reglas para reescribir las URIs de la petición al fichero `index.php` (punto de entrada de la aplicación):

```apacheconfig
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
</IfModule>
```

La mayor parte de nuestro código se colocará en `index.php`. El fichero se crea como sigue:

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

// Define the routes here

$app->handle(
    $_SERVER["REQUEST_URI"]
);
```

Ahora crearemos las rutas como las hemos definido antes:

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

Cada ruta se define con un método con el mismo nombre que el método HTTP, como primer parámetro pasamos un patrón de ruta, seguido por un manejador. En este caso, el manejador es una función anónima. La siguiente ruta: `/api/robots/{id:[0-9]+}`, por ejemplo, establece explícitamente que el parámetro `id` debe ser de tipo numérico.

Cuando una ruta definida coincide con la URI solicitada entonces la aplicación ejecuta el correspondiente manejador.

## Creando un modelo
Nuestra API proporciona información sobre `robots`, estos datos se almacenan en una base de datos. El siguiente modelo nos permite acceder a esa tabla de una forma orientada a objetos. Hemos implementado algunas reglas de negocio usando validadores integrados y validaciones simples. Haciendo esto tendremos la tranquilidad de que los datos guardados cumple los requerimientos de nuestra aplicación. Este fichero de modelo debería colocarse en su carpeta `Models`.

```php
<?php

namespace Store\Toys;

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

        // Validate the valididator
        return $this->validate($validator);
    }
}
```

Ahora, debemos configurar una conexión para ser usada por este modelo y cargarla dentro de nuestra aplicación `index.php`:

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

## Recuperando Datos
El primer `manejador` que implementaremos es por el método GET que devuelve todos los robots disponibles. Usemos PHQL para realizar esta consulta simple devolviendo los resultados como JSON.

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

[PHQL](db-phql), nos permite escribir consultas usando un dialecto SQL de alto nivel orientado a objetos que internamente traduce a sentencias SQL válidas dependiendo del sistema de base de datos que estemos usando. La cláusula `use` en las funciones anónimas nos permite pasar algunas variables del ámbito global al local más fácilmente.

La búsqueda por gestor de nombre se vería como:

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

Buscando por el campo `id` es bastante similar, en este caso, también estamos notificando si el robot se ha encontrado o no:

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

## Insertando Datos
Tomando los datos como una cadena JSON insertada en el cuerpo de la solicitud, también utilizamos PHQL para la inserción:

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

## Actualizando Datos
La actualización de los datos es similar a la inserción. El `id` pasado como parámetro indica qué robot debe ser actualizado:

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

## Borrando datos
El borrado de datos es similar a la actualización. El `id` pasado como parámetro indica qué robot debe ser borrado:

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

## Creando la base de datos
Ahora crearemos la base de datos de nuestra aplicación. Ejecute las consultas SQL como sigue:
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

## Probando nuestra Aplicación
Usando [curl](https://es.wikipedia.org/wiki/CURL) prbaremos cada ruta de nuestra aplicación verificando su correcto funcionamiento.

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

O actualizar un robot con un tipo incorrecto:

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

Finalmente, borramos un robot:

```bash
curl -i -X DELETE https://localhost/my-rest-api/api/robots/4

HTTP/1.1 200 OK
Date: Tue, 21 Jul 2015 08:49:29 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 15
Content-Type: text/html; charset=UTF-8

{"status":"OK"}
```
