* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

If you have found a bug it is important to add relevant reproducibility information to your issue to allow us to reproduce the bug and fix it quicker. If you have the application publicly on Github please submit the repository address along with the issue description. You can also use [Gist](https://gist.github.com/) to post any code you want to share with us.

<a name="overview"></a>

## Creating a small script

A small single-file script is usually the best way to reproduce a problem:

```php
<?php

$di = new Phalcon\DI\FactoryDefault();

//Register your custom services
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

Depending on your application, you can use these skeletons in order to create your own script and reproduce the bug:

<a name="database"></a>

### База данных

Remember to add to the script how you registered the database service:

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

### Single/Multi-Module applications

Remember to add to the script how you are creating the Phalcon\Mvc\Application instance:

```php
<?php

$di  = new \Phalcon\DI\FactoryDefault();

//other services

$app = new \Phalcon\Mvc\Application();
$app->setDi($di);

//register modules if any

echo $app->handle->getContent()

```

Include models and controllers as part of the test:

```php
<?php

$di  = new \Phalcon\DI\FactoryDefault();

//other services

$app = new \Phalcon\Mvc\Application();
$app->setDi($di);

class IndexController extends Phalcon\Mvc\Controller
{
    public function indexAction() { 
          /* your content here */
    }
}

class Users extends Phalcon\Mvc\Model
{
}

echo $app->handle->getContent()

```

<a name="micro"></a>

### Micro application

Follow this structure to create the script:

```php
<?php

$di = new \Phalcon\DI\FactoryDefault();

$app = new \Phalcon\Mvc\Micro($di);

//define your routes here

$app->handle();
```

<a name="orm"></a>

### ORM

You can provide your own database schema or even better use any of the phalcon test [databases](https://github.com/phalcon/cphalcon/tree/master/unit-tests/schemas). Follow this structure to create the script:

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