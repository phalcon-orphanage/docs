---
layout: default
language: 'es-es'
version: '4.0'
title: 'Tutorial - REST'
keywords: 'tutorial, tutorial rest, api, rest, paso a paso, micro'
---

# Tutorial - REST

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg) ![](/assets/images/level-beginner.svg)

## Resumen

En este tutorial, aprenderá cómo crear una aplicación simple que ofrezca un API [RESTful](https://es.wikipedia.org/wiki/Transferencia_de_Estado_Representacional) usando diferentes métodos HTTP:

* `GET` para recuperar y buscar datos
* `POST` para agregar datos
* `PUT` para actualizar datos
* `DELETE` para borrar datos

> **NOTA**: Esta es sólo una aplicación de ejemplo. Carece de muchas características como autenticación, autorización, saneamiento de la entrada y gestión de errores, por nombras algunas. Por favor, úsela como un *set* de construcción para su aplicación, o como tutorial para comprender cómo puede construir un API REST con Phalcon. También puede echar un vistazo al proyecto <rest-api>. 
{: .alert .alert-warning }

## Métodos

La API consiste en los siguientes métodos:

| Método   | URL                        | Acción                                      |
| -------- | -------------------------- | ------------------------------------------- |
| `GET`    | `/api/robots`              | Obtiene todos los robots                    |
| `GET`    | `/api/robots/search/Astro` | Buscar robots con 'Astro' en su nombre      |
| `GET`    | `/api/robots/2`            | Obtiene robots basados en la clave primaria |
| `POST`   | `/api/robots`              | Añade robot                                 |
| `PUT`    | `/api/robots/2`            | Actualiza robot basado en la clave primaria |
| `DELETE` | `/api/robots/2`            | Elimina robot basado en la clave primaria   |

## Aplicación

Como la aplicación es sencilla, no implementaremos ningún entorno MVC completo para desarrollarla. En este caso, usaremos una [micro aplicación](application-micro) para nuestras necesidades. La estructura de la aplicación es la siguiente:

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

La mayor parte de nuestro código se colocará en `index.php`.

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

$app->handle(
    $_SERVER["REQUEST_URI"]
);
```

Ahora necesitamos crear las rutas, para que la aplicación pueda entender qué hacer cuando los usuarios finales interactúan con nuestra aplicación. El fichero `index.php` cambia a:

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

A medida que añadimos las rutas, usamos los métodos HTTP reales como nombres de los métodos llamados en el objeto aplicación. Esto nos permite fácilmente definir puntos de escucha para la aplicación basados en esos métodos HTTP.

El primer parámetro de cada método de llamada es la ruta y el segundo es el manejador, es decir, qué hacemos cuando el usuario llama a esa ruta. En nuestro ejemplo tenemos funciones anónimas definidas para cada manejador. Para la siguiente ruta:

    /api/robots/{id:[0-9]+}
    

explícitamente establecemos el parámetro `id` para que sea un número. Cuando una ruta definida coincide con la URI solicitada, entonces se ejecuta el manejador (función anónima) correspondiente.

## Modelos

Para esta aplicación almacenamos y manipulamos `Robots` en la base de datos. Para acceder a la tabla necesitamos un modelo. La clase siguiente nos permite acceder a cada registro de la tabla de una forma orientada a objetos. También hemos implementado reglas de negocio, usando validadores integrados. Al hacerlo, tenemos una gran confianza de que los datos guardados cumplen los requerimientos de nuestra aplicación. Este fichero de modelo se debe crear en el directorio `my-rest-api/models`.

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

        // Validate the validator
        return $this->validate($validator);
    }
}
```

Adjuntamos tres validadores al modelo. El primero comprueba el tipo de robot. Que debe ser `droid`, `mechanical` o `virtual`. Cualquier otro valor hará que el validador devuelva `false` y la operación (insert/update) fallará. El segundo validador comprueba la unicidad del nombre de nuestro robot. El último validador comprueba el campo `year` para que sea un número positivo.

## Base de Datos

Necesitamos conectar nuestra aplicación a la base de datos. Para este ejemplo vamos a usar la popular MariaDB o variantes similares como MySQL, Aurora, etc. Además de la configuración de base de datos, vamos a configurar el autocargador, para que nuestra aplicación sepa donde buscar los ficheros requeridos.

Estos cambios deben hacerse en el fichero `index.php`.

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

## Operaciones

### Obtener

El primer `manejador` que implementaremos es el que obtiene datos de la base de datos, cuando se hace la petición usando el método HTTP `GET`. El punto de acceso devolverá todos los registros de la base de datos usando una consulta PHQL y devolverá los resultados en JSON.

El manejador para `get()` y `/api/robots` se hace:

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

[PHQL](db-phql), nos permite escribir consultas usando un dialecto SQL de alto nivel, orientado a objetos, que internamente traduce sus consultas a las sentencias SQL correctas dependiendo del sistema de base de datos usado. La sentencia `use` en la función anónima ofrece inyección de objetos desde el ámbito local a la función anónima.

### Obtener - Texto

Podemos obtener robots usando su nombre o una parte de su nombre. Esta característica de búsqueda también será un `get()` en lo que respecta al método HTTP y se vinculará al punto de acceso `/api/robots/search/{name}`. La implementación es similar a la anterior. Sólo necesitamos cambiar ligeramente la consulta.

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

### Obtener - `id`

Para obtener un robot usando su `id` es similar a las operaciones anteriores. Sólo necesitaremos ajustar la consulta que ejecutamos contra la base de datos. El método HTTP usado será también `get()` y el punto de acceso será `/api/robots/{id:[0-9]+}`. Para este manejador, también reportamos de vuelta si el robot no se ha encontrado.

El `index.php` cambia otra vez:

```php
<?php

use Phalcon\Http\Response;

$app->get(
    '/api/robots/{id:[0-9]+}',
    function ($id) use ($app) {
        $phql = 'SELECT * '
              . 'FROM MyApp\Models\Robots '
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

### Insertar

Nuestro diseño permite a los usuarios enviar datos que podamos insertar en la base de datos. El método HTTP usado es `post()` al punto de acceso `/api/robots`. Esperamos que los datos se envíen como una cadena JSON.

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

Después de ejecutar la consulta contra nuestra base de datos, usando PHQL, creamos un nuevo objeto `Response`. Si la consulta se ejecuta correctamente, manipulamos la respuesta para tener un código de estado de `201` y un texto `Created`. Finalmente, actualizamos el `id` del registro creado recientemente, y enviamos el robot de vuelta con la respuesta.

Si algo sale mal, cambiamos el código de estado de la respuesta a `409` con el texto `Conflict` y recopilamos todos los errores que se han producido en la operación de base de datos. Entonces enviamos esos mensajes de error de vuelta con la respuesta.

## Actualizar

Actualizar datos es similar a insertarlos. Para esta operación usamos el método HTTP `put()` y el punto de acceso `/api/robots/{id:[0-9]+}`. El parámetro `id` pasado en la URL es el id del robot a actualizar. Los datos enviados están en formato JSON.

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

La operación es muy similar a la que hemos usado al insertar datos. Si la operación de actualización es correcta, enviamos de vuelta una carga útil JSON con `OK`.

Si algo sale mal, cambiamos el código de estado de la respuesta a `409` con el texto `Conflict` y recopilamos todos los errores que se han producido en la operación de base de datos. Entonces enviamos esos mensajes de error de vuelta con la respuesta.

## Eliminar

Eliminar es prácticamente idéntico al proceso de `actualizar`. Para esta operación usamos el método HTTP `delete()` y el punto de acceso `/api/robots/{id:[0-9]+}`. El parámetro `id` pasado en la URL es el id del robot a borrar.

El `index.php` cambia otra vez:

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

Si la operación de borrado es correcta, devolvemos una carga útil JSON con `OK`.

Si algo sale mal, cambiamos el código de estado de la respuesta a `409` con el texto `Conflict` y recopilamos todos los errores que se han producido en la operación de base de datos. Entonces enviamos esos mensajes de error de vuelta con la respuesta.

## Esquema

Para crear la tabla en nuestra base de datos, necesitamos usar las siguientes consultas SQL:

    create database `robotics`;
    
    create table `robotics`.`robots` (
     `id`    int(10)      unsigned         not null auto_increment,
     `name`  varchar(200) collate utf8_bin not null,
     `type`  varchar(20)  collate utf8_bin not null,
     `year`  smallint(4)  unsigned         not null,
     PRIMARY KEY (`id`)
    )
    

## Ejecutar

Por supuesto, puede configurar su servidor web para ejecutar su aplicación. Para instrucciones de configuración puede consultar el documento [configuración de servidor web](webserver-setup). Si quiere usar el servidor PHP integrado, necesitará crear un fichero llamado `.htrouter` como sigue:

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

y luego ejecutar el siguiente comando:

    $(which php) -S localhost:8000 -t / .htrouter.php
    

## Pruebas

Hay numerosas suites de pruebas que puede usar para testear esta aplicación. Usaremos [curl](https://en.wikipedia.org/wiki/CURL) en cada ruta, para verificar la operación apropiada.

**Obtener** todos los robots:

```bash
curl -i -X GET https://localhost/my-rest-api/api/robots

HTTP/1.1 200 OK
Date: Wed, 25 Dec 2019 01:02:03 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 117
Content-Type: text/html; charset=UTF-8

[{"id":"1","name":"Robotina"},{"id":"2","name":"Astro Boy"},{"id":"3","name":"Terminator"}]
```

**Buscar** un robot por su nombre:

```bash
curl -i -X GET https://localhost/my-rest-api/api/robots/search/Astro

HTTP/1.1 200 OK
Date: Wed, 25 Dec 2019 01:02:03 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 31
Content-Type: text/html; charset=UTF-8

[{"id":"2","name":"Astro Boy"}]
```

**Obtener** un robot por su id:

```bash
curl -i -X GET https://localhost/my-rest-api/api/robots/3

HTTP/1.1 200 OK
Date: Wed, 25 Dec 2019 01:02:03 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 56
Content-Type: text/html; charset=UTF-8

{"status":"FOUND","data":{"id":"3","name":"Terminator"}}
```

**Insertar** un nuevo robot:

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

Intente insertar un nuevo robot con el nombre de un robot existente:

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

**Actualizar** un robot con un tipo desconocido:

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

**Eliminar** un robot:

```bash
curl -i -X DELETE https://localhost/my-rest-api/api/robots/4

HTTP/1.1 200 OK
Date: Wed, 25 Dec 2019 01:02:03 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 15
Content-Type: text/html; charset=UTF-8

{"status":"OK"}
```
