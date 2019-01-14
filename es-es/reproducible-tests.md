* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

Si has encontrado un error, es importante agregar información reproducible pertinente a su problema para poder reproducir el error y solucionarlo más rápido. Si tienes la aplicación públicamente en Github por favor enviar la dirección del repositorio junto con la descripción del problema. También puede utilizar [Gist](https://gist.github.com/) para publicar cualquier código que desea compartir con nosotros.

<a name="overview"></a>

## Creando un pequeño script

Un archivo de código único y pequeño es generalmente la mejor manera de reproducir un problema:

```php
<?php

$di = new Phalcon\DI\FactoryDefault();

// Registrar un servicio personalizado
$di['session'] = function() {
    $session = new \Phalcon\Session\Adapter\Files();
    $session->start();
    return $session;
};

$di['cookies'] = function() {
    $cookies = new Phalcon\Http\Response\Cookies();
    $cookies->useEncryption(false);
    return $cookies;
};

class SomeClass extends \Phalcon\DI\Injectable
{
    public function someMethod()
    {
        $cookies = $this->getDI()->getCookies();
        $cookies->set("mycookie", "test", time() + 3600, "/");
    }
}

$c = new MyClass;
$c->setDI($di);
$c->someMethod();

$di['cookies']->send();

var_dump($_SESSION);
var_dump($_COOKIE);
```

Dependiendo de la aplicación, puede utilizar estos esqueletos para crear su propio código y reproducir el error:

<a name="database"></a>

### Base de Datos

No olvide añadir al código cómo has registrado el servicio de base de datos:

```php
<?php

$di = new Phalcon\DI\FactoryDefault();

$di->setShared('db', function () {
    return new \Phalcon\Db\Adapter\PDO\Mysql(array(
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'dbname'   => 'test',
        'charset'  => 'utf8',
    ));
});

$result = $di['db']->query('SELECT * FROM customers');

```

<a name="single-multi"></a>

### Aplicaciones simples o multi módulo

No olvide añadir al script cómo has creado la instancia de Phalcon\Mvc\Application:

```php
<?php

$di  = new \Phalcon\DI\FactoryDefault();

// otros servicios

$app = new \Phalcon\Mvc\Application();
$app->setDi($di);

// registrar módulos si los hay

echo $app->handle->getContent()

```

Incluye modelos y controladores como parte de la prueba:

```php
<?php

$di  = new \Phalcon\DI\FactoryDefault();

// otros servicios

$app = new \Phalcon\Mvc\Application();
$app->setDi($di);

class IndexController extends Phalcon\Mvc\Controller
{
    public function indexAction() { 
          /* Tú contenido aquí */
    }
}

class Users extends Phalcon\Mvc\Model
{
}

echo $app->handle->getContent()

```

<a name="micro"></a>

### Micro Aplicaciones

Sigue esta estructura para crear el script:

```php
<?php

$di = new \Phalcon\DI\FactoryDefault();

$app = new \Phalcon\Mvc\Micro($di);

// define tus rutas aquí

$app->handle();
```

<a name="orm"></a>

### ORM

Puede proporcionar su propio esquema de base de datos o incluso mejor, usar cualquiera de las [bases de datos](https://github.com/phalcon/cphalcon/tree/master/unit-tests/schemas) de prueba de Phalcon. Sigue esta estructura para crear el script:

```php
<?php

use Phalcon\DI;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Adapter\Pdo\Mysql as Connection;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use Phalcon\Mvc\Model\Metadata\Memory as ModelsMetaData;

$eventsManager = new EventsManager();

$di = new DI();

$connection = new Connection(array(
    "host" => "localhost",
    "username" => "root",
    "password" => "",
    "dbname" => "test"
));

$connection->setEventsManager($eventsManager);

$eventsManager->attach('db',
    function ($event, $connection) {
        switch ($event->getType()) {
            case 'beforeQuery':
                echo $connection->getSqlStatement(), "<br>\n";
                break;
        }
    }
);

$di['db'] = $connection;
$di['modelsManager'] = new ModelsManager();
$di['modelsMetadata'] = new ModelsMetadata();

if (!$connection->tableExists('user', 'test')) {
    $connection->execute('CREATE TABLE user (id integer primary key auto_increment, email varchar(120) not null)');
}

class User extends \Phalcon\Mvc\Model
{
    public $id;

    public $email;

    public static function myCustomUserCreator()
    {
        $newUser = new User();
        $newUser->email = 'test';
        if ($newUser->save() == false) {
            return false;
        }
        return $newUser->id;        
    }
}

echo User::myCustomUserCreator();
```