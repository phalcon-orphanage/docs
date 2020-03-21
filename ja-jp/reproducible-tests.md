---
layout: default
language: 'ja-jp'
version: '4.0'
title: '再現テスト'
keywords: 'tests, testing, reproducible tests'
---

# 再現テスト

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

> **NOTE**: If you have found a bug, you can open an issue in [GitHub](https://github.com/phalcon/cphalcon/issues). Along with your description of the bug, you will need to provide as much information as possible so that the core team can reproduce the behavior you are experiencing. The best way to do this is to create a test that fails, showcasing the behavior. If the bug you found is in an application that is publicly available in a repository, please provide also the link for this repository. You can also use a [Gist](https://gist.github.com/) to post any code you want to share with us.
{:.alert .alert-info}

## Creating a Small Script

A small PHP file can be used to showcase how to reproduce the issue:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Di\Injectable;
use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Files;
use Phalcon\Http\Response\Cookies;

$container = new FactoryDefault();

// Register your custom services
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

### Database

> **NOTE**: Remember to include the register information for your `db` service, i.e. adapter, connection parameters etc.
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

### Single/Multi-Module Applications

> **NOTE**: Remember to add to the script how you are creating the `Phalcon\Mvc\Application` instance and how you register your modules
{:.alert .alert-info}

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;

$container = new FactoryDefault();

// other services

$application = new Application();

$application->setDI($container);

// register modules if any

$response = $application->handle(
    $_SERVER["REQUEST_URI"]
);

echo $response->getContent();
```

Include models and controllers as part of the test:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model;

$container = new FactoryDefault();

// other services

$application = new Application();

$application->setDI($container);

class IndexController extends Controller
{
    public function indexAction() { 
          /* your content here */
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

### Micro Application

For micro applications, you can use the skeleton script below:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;

$container = new FactoryDefault();

// other services

$application = new Micro($container);

// define your routes here

$application->handle(
    $_SERVER["REQUEST_URI"]
);
```

### ORM

> **NOTE**: You can provide your own database schema or even better, use any of the existing schemas in our testing suite (located in `tests/_data/assets/db/schemas/` in the repository).
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