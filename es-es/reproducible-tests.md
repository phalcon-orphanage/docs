---
layout: default
language: 'es-es'
version: '4.0'
title: 'Pruebas Reproducibles'
keywords: 'pruebas, test, testing, pruebas reproducibles'
---

# Pruebas Reproducibles

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

> **NOTA**: En caso de encontrar un error se puede reportar en [GitHub](https://github.com/phalcon/cphalcon/issues). Acompañado por la descripción del error y todos los detalles posibles de tal manera que el equipo principal pueda reproducirlo. La mejor forma de hacerlo es creando una prueba que falle: así se demuestra el error. Si el error se encuentra en una aplicación de dominio público en un repositorio, es pertinente incluir el enlace. También se puede utilizar un [Gist](https://gist.github.com/) para publicar el código relevante para el equipo principal.
{:.alert .alert-info}

## Creando un pequeño script

La prueba para demostrar el error se puede crear en unas cuantas líneas de PHP, por ejemplo:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Di\Injectable;
use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Files;
use Phalcon\Http\Response\Cookies;

$container = new FactoryDefault();

// Registro de los servicios
$container['session'] = function() {
    $session = new Manager();
    $adapter = new Files(
        [
            'save_path' => '/tmp',
         ]
    );

    $session->setHandler($adapter);

    $session->start();

    return $session;
};

$container['cookies'] = function() {
    $cookies = new Cookies();

    $cookies->useEncryption(false);

    return $cookies;
};

class SomeClass extends Injectable
{
    public function someMethod()
    {
        $cookies = $this->getDI()->getCookies();

        $cookies->set(
            'mycookie',
            'test',
            time() + 3600,
            '/'
        );
    }
}

$class = new MyClass();

$class->setDI($container);

$class->someMethod();

$container['cookies']->send();

var_dump($_SESSION);
var_dump($_COOKIE);
```

### Base de Datos

> **NOTA**: Es importante incluir toda la información de registro del servicio de la base de datos (`db`), tales como adaptador, parámetros de conexión, etc.
{:.alert .alert-info}

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql;

$container = new FactoryDefault();

$container->setShared(
    'db', 
    function () {
        return new Mysql(
            [
                'host'     => '127.0.0.1',
                'username' => 'root',
                'password' => '',
                'dbname'   => 'test',
                'charset'  => 'utf8',
            ]
        );
    }
);

$result = $container['db']->query('SELECT * FROM customers');
```

### Aplicaciones simples o multi módulo

> **NOTA**: Es importante incluir la instancia de `Phalcon\Mvc\Application` que se está utilizando al igual que la forma en que se están registrando los módulos
{:.alert .alert-info}

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;

$container = new FactoryDefault();

// otros servicios

$application = new Application();

$application->setDI($container);

// registro de módulos (si los hay)

$response = $application->handle(
    $_SERVER["REQUEST_URI"]
);

echo $response->getContent();
```

Incluye modelos y controladores como parte de la prueba:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model;

$container = new FactoryDefault();

// otros servicios

$application = new Application();

$application->setDI($container);

class IndexController extends Controller
{
    public function indexAction() { 
          /* contenido */
    }
}

class Users extends Model
{
}

$response = $application->handle(
    $_SERVER["REQUEST_URI"]
);

echo $response->getContent();
```

### Micro Aplicación

En caso de que se trate de una microaplicación, se puede utilizar la siguiente estructura:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;

$container = new FactoryDefault();

// otros servicios

$application = new Micro($container);

// definición de las rutas

$application->handle(
    $_SERVER["REQUEST_URI"]
);
```

### Mapeo objeto-relacional (ORM, siglas en inglés)

> **NOTA**: Para la prueba se puede incluir el esquema de la base de datos o, mejor aún, se puede utilizar alguno de los esquemas disponibles en nuestra suite de pruebas ubicada en `tests/_data/assets/db/schemas/` en el repositorio.
{:.alert .alert-info}

```php
<?php

use Phalcon\Di;
use Phalcon\Db\Adapter\Pdo\Mysql as Connection;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use Phalcon\Mvc\Model\Metadata\Memory as ModelsMetaData;

$eventsManager = new EventsManager();
$container     = new Di();
$connection    = new Connection(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname'   => 'test',
    ]
);

$connection->setEventsManager($eventsManager);

$eventsManager->attach(
    'db:beforeQuery',
    function ($event, $connection) {
        echo $connection->getSqlStatement(), '<br>' . PHP_EOL;
    }
);

$container['db']             = $connection;
$container['modelsManager']  = new ModelsManager();
$container['modelsMetadata'] = new ModelsMetadata();

if (true !== $connection->tableExists('user', 'test')) {
    $connection->execute(
        'CREATE TABLE user (id integer primary key auto_increment, email varchar(120) not null)'
    );
}

class User extends Model
{
    public $id;

    public $email;

    public static function createNewUserReturnId()
    {
        $newUser = new User();

        $newUser->email = 'test';

        if (false === $newUser->save()) {
            return false;
        }

        return $newUser->id;
    }
}

echo User::createNewUserReturnId();
```
