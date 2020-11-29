---
layout: default
language: 'fr-fr'
version: '4.0'
title: 'Session'
keywords: 'session, session manager, session adapters, redis, libmemcached, none, stream'
---

# Session

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Vue d'ensemble

Sessions are used in PHP to persist data between requests. This enables developers to build better applications and increase the user experience. A very common usage of sessions is to keep whether a user is logged in or not. [Phalcon\Session\Manager](api/Phalcon_Session#session-manager) is an object oriented approach to handle sessions using Phalcon. There are several reasons to use this component instead of raw sessions or accessing the `$_SESSION` superglobal:

- You can easily isolate session data across applications on the same domain
- Intercept where session data is set/get in your application
- Change the session adapter according to the application needs

## Manager

[Phalcon\Session\Manager](api/Phalcon_Session#session-manager) is a component that allows you to manipulate sessions in your application. This manager accepts a an adapter which is the way the data will be communicated to a particular store.

> **NOTE**: PHP uses the term `handler` for the component that will be responsible for storing and retrieving the data. In `Phalcon\Session\Manager` we use the term `adapter`. So in order to set a *handler* in your session, for `Phalcon\Session\Manager` you need to call `setAdapter()`. The functionality is the same.
{: .alert .alert-warning }


```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);
$session->setAdapter($files);
```

First we need to create an adapter object. The object can be one of the adapters distributed with Phalcon (see below) but it can also be an object that implements [SessionHandlerInterface](https://www.php.net/manual/en/class.sessionhandlerinterface.php). Once we instantiate the new [Phalcon\Session\Manager](api/Phalcon_Session#session-manager) object and pass the adapter in it. After that you can start working with the session.

### Constructor

```php
public function __construct(array $options = [])
```

The constructor accepts an array of options that relate to the session. You can set a unique id for your session using `uniqueId` as a key and your chosen id string. This allows you to create more than one of these objects, each with its own unique id, if necessary. This parameter is optional, but it is advisable to set it always. Doing so will help you with potential session leaks.

### Start

In order to work with the session, you need to start it. `start()` performs this task. Usually this call is made when the component is registered or at the very top of your application's workflow. `start()` returns a boolean value indicating success or failure.

> **NOTE**: - If the session has already started, the call will return `true`. - If any headers have been sent, it will return `false` - If the adapter is not set, it will throw an exception - It will return the result of `session_start()`
{: .alert .alert-info } 

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);
$session->setAdapter($files);

$session->start();
```

### Destroy

Similarly, you can call `destroy()` to kill the session. Usually this happens when a user logs out.

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);
$session
    ->setAdapter($files)
    ->start();

// ....

$session->destroy();
```

### Exists

To check if your session has started, you can use `exists()`

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);

var_dump(
    $session->exists()
);
// `false`

$session
    ->setAdapter($files)
    ->start();

var_dump(
    $session->exists()
);
// `true`
```

### Regenerate Id

[Phalcon\Session\Manager](api/Phalcon_Session#session-manager) supports regenerating the session id. This allows you to replace the current session id with a new one and keep the current session information intact. To achieve this you can call `regenerateId()`. The method also accepts a `bool` parameter, which if `true` will instruct the component to remove old session file.

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);

$session
    ->setAdapter($files)
    ->start();

$session->regenerateId();
```

### Get

You can use `get()` to retrieve the contents stored in the session for a particular element passed as a string parameter. The component also supports the magic getter so you can retrieve it as a property of the manager.

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);

$session
    ->setAdapter($files)
    ->start();

echo $session->get('userId');
echo $session->userId;
```

### Has

You can use `has()` to check whether a particular element is stored in your session. The component also supports the magic `__isset`, allowing you to use PHP's `isset()` method if you want.

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);

$session
    ->setAdapter($files)
    ->start();

echo $session->has('userId');
var_dump(
    isset($session->userId)
);
```

### Id

You can also set the session id. The session id is set in a HTTP cookie. You can set the name by calling `setId()`. `getId()` is used to retrieve the session id.

> **NOTE**: You need call this method before calling `start()` for the id to take effect
{: .alert .alert-info }

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);
$session
    ->setAdapter($files)
    ->setId('phalcon-id')
    ->start();

echo $session->getId(); // 'phalcon-id'
```

### Name

Each session can have a name. The session name is set in a HTTP cookie. If this is not set, the `session.name` `php.ini` setting is used. You can set the name by calling `setName()`. `getName()` is used to retrieve the session name.

> **NOTE**: You need to call this method before calling `start()` for the name to take effect
{: .alert .alert-info }

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);
$session
    ->setAdapter($files)
    ->setName('phalcon-app')
    ->start();

echo $session->getName(); // 'phalcon-app'
```

### Options

You can set options for the manager by using `setOptions()`. The method accepts an array and in it you can set the `uniqueId` for the session. To get the options you can call `getOptions()` which will return the array of options stored in the manager.

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager('id-1');
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);
$session
    ->setAdapter($files)
    ->start();

$session->setOptions(
    [
        'uniqueId' => 'id-2'
    ]   
);
```

In the above example, after `setOptions()` is called with a new `uniqueId`, data will be stored using `id-2` now and anything stored before that will not be accessible until you change the key back to `id-1`.

### Set

You can use `set()` to store contents in your session. The method accepts a `string` as the name of the element and the value to be stored.. The component also supports the magic setter so you can set it as a property of the manager.

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);

$session
    ->setAdapter($files)
    ->start();

$session->set('userId', 12345);
$session->userId = 12345;
```

### Remove

To remove a stored element in the session, you need to call `remove()` with the name of the element. The component also supports the magic `__unset` so you can use PHP's `unset()` method if you want.

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);

$session
    ->setAdapter($files)
    ->start();

$session->remove('userId');
unset($session->userId);
```

## Adapters

### Libmemcached

[Phalcon\Session\Adapter\Libmemcached](api/Phalcon_Session#session-adapter-libmemcached) uses the [Phalcon\Storage\Adapter\Libmemcached](api/Phalcon_Storage#storage-adapter-libmemcached) internally to store data in Memcached. In order to use this adapter you need the settings for Memcached and a [Phalcon\Storage\AdapterFactory](api/Phalcon_Storage#storage-adapterfactory) object in order for the adapter to be created internally.

The available options for Memcached are: - `client` - client settings - `servers` - array of server data - `host` - the host - `port` - the port - `weight` - the weight for the server

```php
<?php

use Phalcon\Session\Adapter\Libmemcached;
use Phalcon\Session\Manager;
use Phalcon\Storage\AdapterFactory;
use Phalcon\Storage\SerializerFactory;

$options = [
    'client'  => [],
    'servers' => [
        [
            'host'   => '127.0.0.1',
            'port'   => 11211,
            'weight' => 0,
        ],
    ],
];

$session           = new Manager();
$serializerFactory = new SerializerFactory();
$factory           = new AdapterFactory($serializerFactory);
$libmemcached      = new Libmemcached($factory, $options);

$session
    ->setAdapter($libmemcached)
    ->start();
```

### Noop

[Phalcon\Session\Adapter\Noop](api/Phalcon_Session#session-adapter-noop) is an "empty" or `null` adapter. It can be used for testing, a joke for your colleagues or any other purpose that no session needs to be invoked.

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Noop;

$session = new Manager();
$session
    ->setAdapter(new Noop())
    ->start();
```

### Redis

[Phalcon\Session\Adapter\Redis](api/Phalcon_Session#session-adapter-redis) uses the [Phalcon\Storage\Adapter\Redis](api/Phalcon_Storage#storage-adapter-redis) internally to store data in Redis. In order to use this adapter you need the settings for Redis and a [Phalcon\Storage\AdapterFactory](api/Phalcon_Storage#storage-adapterfactory) object in order for the adapter to be created internally.

The available options for Redis are: - `host` - the host - `port` - the port - `index` - the index - `persistent` - whether to persist connections or not - `auth` - authentication parameters - `socket` - socket connection

```php
<?php

use Phalcon\Session\Adapter\Redis;
use Phalcon\Session\Manager;
use Phalcon\Storage\AdapterFactory;
use Phalcon\Storage\SerializerFactory;

$options = [
    'host'  => '127.0.0.1',
    'port'  => 6379,
    'index' => '1',
];

$session           = new Manager();
$serializerFactory = new SerializerFactory();
$factory           = new AdapterFactory($serializerFactory);
$redis             = new Redis($factory, $options);

$session
    ->setAdapter($redis)
    ->start();
```

### Stream

This adapter is the most common one, storing the session files on the file system. You need to create a [Phalcon\Session\Adapter\Stream](api/Phalcon_Session#session-adapter-stream) adapter with the `savePath` defined in the options. The path needs to be writeable by the web server, otherwise your sessions will not work.

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);

$session
    ->setAdapter($files)
    ->start();
```

### Custom

The adapters implement PHP's [SessionHandlerInterface](https://www.php.net/manual/en/class.sessionhandlerinterface.php). As a result you can create any adapter you need by extending this interface. You can also use any adapter that implements this interface and set the adapter to [Phalcon\Session\Manager](api/Phalcon_Session#session-manager). There are more adapters available for this components in the [Phalcon Incubator](https://github.com/phalcon/incubator/).

```php
<?php

namespace MyApp\Session\Adapter;

use SessionHandlerInterface;

class Custom extends SessionHandlerInterface
{
    /**
     * Close
     */
    public function close() -> bool;

    /**
     * Destroy
     */
    public function destroy($sessionId) -> bool;

    /**
     * Garbage Collector
     */
    public function gc($maxlifetime) -> bool;

    /**
     * Read
     */
    public function read($sessionId) -> string;

    /**
     * Open
     */
    public function open($savePath, $sessionName) -> bool;

    /**
     * Write
     */
    public function write($sessionId, $data) -> bool;
}
```

## Exceptions

Any exceptions thrown in the Session component will be of type [Phalcon\Session\Exception](api/Phalcon_Session#session-exception). It is thrown any session operation is not completed correctly. You can use these exceptions to selectively catch exceptions thrown only from this component.

```php
<?php

use Phalcon\Session\Exception;
use Phalcon\Session\Manager;
use Phalcon\Mvc\Controller;

/**
 * @property Manager $session
 */
class IndexController extends Controller
{
    public function index()
    {
        try {
            $this->session->set('key', 'value');
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
```

## Bag

[Phalcon\Session\Bag](api/Phalcon_Session#session-bag) is a component that helps separating session data into `namespaces`. This way you can create groups of session variables for your application. Setting data in the bag stores them automatically in the session:

```php
<?php

use Phalcon\Di;
use Phalcon\Session\Bag as SessionBag;

$container = new Di();
$user      = new SessionBag('user');

$user->setDI($container);

$user->name     = 'Dark Helmet';
$user->password = 12345;
```

## Dependency Injection

If you use the [Phalcon\Di\FactoryDefault](api/Phalcon_Di#di-factorydefault) container you can register your session manager. An example of the registration of the service as well as accessing it is below:

```php
<?php

use Phalcon\Di;
use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$container = new Di();

$container->set(
    'session',
    function () {
        $session = new Manager();
        $files = new Stream(
            [
                'savePath' => '/tmp',
            ]
        );

        $session
            ->setAdapter($files)
            ->start();

        return $session;
    }
);
```

After registering the manager you can access your session from controllers, views or any other components that extend [Phalcon\Di\Injectable](api/Phalcon_Di#di-injectable) as follows:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Session\Manager;

/**
 * @property Manager $session
 */
class InvoicesController extends Controller
{
    public function indexAction()
    {
        // Set a session variable
        $this->session->set('user-name', 'Dark Helmet');
    }
}
```

## Persistent Data

You can also inject the [Phalcon\Session\Bag](api/Phalcon_Session#session-bag) component. Doing so will help you isolate variables for every class without polluting the session. The component is registered automatically using the `persistent` property name. Anything set in `$this->persist` will only be available in each class itself, whereas if data is set in the session manager will be available throughout the application.

In a controller:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Session\Bag;
use Phalcon\Session\Manager;

/**
 * @property Bag     $persistent
 * @property Manager $session
 */
class InvoicesController extends Controller
{
    public function indexAction()
    {
        // Set a session variable
        $this->persistent->name = 'Dark Helmet';
        $this->session->name    = 'Princess Vespa';
    }

    public function echoAction()
    {
        // Set a session variable
        echo $this->persistent->name; // 'Dark Helmet';
        echo $this->session->name;    // 'Princess Vespa';
    }
}
```

In a component:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Session\Bag;
use Phalcon\Session\Manager;

/**
 * @property Bag     $persistent
 * @property Manager $session
 */
class InvoicesController extends Controller
{
    public function indexAction()
    {
        // Set a session variable
        $this->persistent->name = 'President Skroob';
    }

    public function echoAction()
    {
        // Set a session variable
        echo $this->persistent->name; // 'President Skroob';
        echo $this->session->name;    // 'Princess Vespa';
    }
}
```