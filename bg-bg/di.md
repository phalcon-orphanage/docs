---
layout: default
language: 'en'
version: '4.0'
title: 'Dependency Injection / Service Locator'
keywords: 'dependency injection, di, ioc, service locator'
---

# Dependency Injection / Service Location

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

[Phalcon\Di](api/phalcon_di#di) is a container that stores services or components (classes). These services are available throughout the application and ease development. Let us assume we are developing a component called `InvoiceComponent` that performs some calculations for a customer's invoice. It requires a database connection to retrieve the `Invoice` record from the database.

Our component can be implemented as follows:

```php
<?php

use Phalcon\Db\Adapter\Mysql;

class InvoiceComponent
{
    public function calculate()
    {
        $connection = new Mysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'tutorial',
            ]
        );

        $invoice = $connection->exec(
            'SELECT * FROM Invoices WHERE inv_id = 1'
        );

        // ...
    }
}

$invoice = new InvoiceComponent();
$invoice->calculate();
```

We use the `calculate` method to get our data. Inside the method, we create a new database connection to MySQL with set credentials and after that we execute a query. Although this is a perfectly valid implementation, it is impractical and will hinder the maintenance of our application later on, due to the fact that our connection parameters or type of the database are hard coded in the component. If in the future we need to change those, we will have to change them in this component and any other component designed in this manner.

```php
<?php

use Phalcon\Db\Adapter\Mysql;

class InvoiceComponent
{
    private $connection;

    public function calculate()
    {
        $invoice = $this
            ->connection
            ->exec(
                'SELECT * FROM Invoices WHERE inv_id = 1'
            )
        ;

        // ...
    }

    public function setConnection(
        Mysql $connection
    ): InvoiceComponent {
        $this->connection = $connection;

        return $this;
    }
}

$connection = new Mysql(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'secret',
        'dbname'   => 'tutorial',
    ]
);

$invoice = new InvoiceComponent();
$invoice
    ->setConnection($connection)
    ->calculate()
;
```

To improve flexibility, we could create the database connection outside the component, and set it in the `InvoiceComponent` using a setter. Using this approach, we can *inject* the database connection to any component that requires it, using the setter. Again this is a perfectly valid implementation but it does have some shortcomings. We will need for instance to construct the database connection every time we need to use any of our components that require database connectivity.

In order to centralize this functionality, we can implement a global registry pattern and store the connection object there. After that we can reuse it wherever we need to.

```php
<?php

use Phalcon\Db\Adapter\Mysql;

class Registry
{
    public static function getConnection(): Mysql
    {
        return new Mysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'tutorial',
            ]
        );
    }
}

class InvoiceComponent
{
    private $connection;

    public function calculate()
    {
        $invoice = $this
            ->connection
            ->exec(
                'SELECT * FROM Invoices WHERE inv_id = 1'
            )
        ;

        // ...
    }

    public function setConnection(
        Mysql $connection
    ): InvoiceComponent {
        $this->connection = $connection;

        return $this;
    }
}

$invoice = new InvoiceComponent();
$invoice
    ->setConnection(Registry::getConnection())
    ->calculate()
;
```

The above implementation will create a new connection every time we call `getConnection` on the `Registry` component. To address this issue, we can modify our `Registry` class to store the database connection and reuse it.

```php
<?php

use Phalcon\Db\Adapter\Mysql;

class Registry
{
    protected static $connection;

    public static function getNewConnection(): Mysql
    {
        return self::createConnection();
    }

    public static function getSharedConnection(): Mysql
    {
        if (self::$connection === null) {
            self::$connection = self::createConnection();
        }

        return self::$connection;
    }

    protected static function createConnection(): Mysql
    {
        return new Mysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'tuturial',
            ]
        );
    }
}


class InvoiceComponent
{
    private $connection;

    public function calculate()
    {
        $invoice = $this
            ->connection
            ->exec(
                'SELECT * FROM Invoices WHERE inv_id = 1'
            )
        ;

        // ...
    }

    public function setConnection(
        Mysql $connection
    ): InvoiceComponent {
        $this->connection = $connection;

        return $this;
    }
}

$invoice = new InvoiceComponent();
$invoice
    ->setConnection(Registry::getSharedConnection())
    ->calculate()
;

$invoice = new InvoiceComponent();
$invoice
    ->setConnection(Registry::getNewConnection())
    ->calculate()
;
```

In the above example we changed the `Registry` class, exposing `getNewConnection` which creates a brand new database connection. It also exposes the `getSharedConnection` which will store the connection internally and reuse it for any other component that requires it.

Injecting dependencies to our components solves the issues outlined above. Passing dependencies as arguments instead of creating them internally in methods makes our code more maintainable and decoupled. However, in the long term, this form of dependency injection has some disadvantages. If for instance the component has many dependencies, we will need to create multiple setter arguments to pass the dependencies or create a constructor that will be used to pass all the dependencies required as arguments. We would also need to create those dependencies before using the component. This makes our code not as maintainable as we would like:

```php
<?php

$connection = new Connection();
$fileSystem = new FileSystem();
$filter     = new Filter();
$selector   = new Selector();
$session    = new Session();

$invoice =  new InvoiceComponent(
    $connection, 
    $session, 
    $fileSystem, 
    $filter, 
    $selector
);

$invoice
    ->setConnection($connection)
    ->setFileSystem($fileSystem)
    ->setFilter($filter)
    ->setSelector($selector)
    ->setSession($session)
;
```

The problem of maintainability arises though here. If we have to create this object in many parts of the application, we will need to perform the same initialization, injecting all the dependencies. If in the future we need to change any of our components to require additional dependencies we have to go through all the areas that we have used this component or others to adjust our code. To solve this issue, we will use the global registry class to create the component. However, this approach adds one more layer of abstraction before creating the object:

```php
<?php

class InvoiceComponent
{
    private $connection;
    private $fileSystem;
    private $filter;
    private $selector;
    private $session;

    public function __construct(
        Connection $connection,
        FileSystem $fileSystem,
        Filter $filter,
        Selector $selector,
        Session $session

    ) {
        $this->connection = $connection;
        $this->fileSystem = $fileSystem;
        $this->filter     = $filter;
        $this->selector   = $selector;
        $this->session    = $session;
    }

    public static function factory()
    {
        $connection = new Connection();
        $fileSystem = new FileSystem();
        $filter     = new Filter();
        $selector   = new Selector();
        $session    = new Session();

        return new self(
            $connection, 
            $fileSystem, 
            $filter, 
            $selector,
            $session 
        );
    }
}
```

We are now back where we started, instantiating dependencies within the component. To solve this issue we will use a container that can store all of our dependencies. This is a practical and elegant way. The container will act as the global registry that we investigated earlier. Using this container as a bridge to retrieve any dependencies, allows us to reduce the complexity of our component:

```php
<?php

use Phalcon\Db\Adapter\Mysql;
use Phalcon\Di;
use Phalcon\Di\DiInterface;

class InvoiceComponent
{
    protected $container;

    public function __construct(
        DiInterface $container
    ) {
        $this->container = $container;
    }

    public function calculate()
    {
        $connection = $this
            ->container
            ->get('db')
        ;
    }

    public function view($id)
    {
        $filter = $this
            ->container
            ->get('filter')
        ;

        $id = $filter->sanitize($id, null, 'int');

        $connection = $this
            ->container
            ->getShared('db')
        ;
    }
}

$container = new Di();
$container->set(
    'db',
    function () {
        return new Mysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'tutorial',
            ]
        );
    }
);

$container->set(
    'filter',
    function () {
        return new Filter();
    }
);

$container->set(
    'session',
    function () {
        return new Session();
    }
);

$invoice =  new InvoiceComponent($container);
$invoice->calculate();
```

The component now can simply access the dependencies it requires when it needs them. If a dependency is not required, it will not be initialized ensuring minimum usage of memory. Our component is now highly decoupled. For instance, if we change the database connection in any way, it will not affect the component, while as far as maintenance is concerned, we only need to change the code in one place.

[Phalcon\Di](api/phalcon_di#di) is a component implementing Dependency Injection and a Service Locator. Since Phalcon is highly decoupled, [Phalcon\Di](api/phalcon_di#di) is essential to integrate the different components of the framework. The developer can also use this component to inject dependencies and manage global instances of the different classes used in the application. It also implements the [Inversion of Control](https://en.wikipedia.org/wiki/Inversion_of_control) pattern. Because of this, the objects do not receive their dependencies using setters or constructors, but requesting a service dependency injector. This reduces the overall complexity since there is only one way to get the required dependencies within a component.

Additionally, this pattern increases testability in the code, thus making it less prone to errors.

## Methods

```php
public function __call(
    string $method, 
    array $arguments = []
): mixed | null
```

Magic method to get or set services using setters/getters

```php
public function attempt(
    string $name, 
    mixed definition, 
    bool shared = false
): ServiceInterface | bool
```

Attempts to register a service in the services container. Only is successful if a service hasn't been registered previously with the same name

```php
public function get(
    string $name, 
    mixed parameters = null
): mixed
```

Resolves the service based on its configuration

```php
public static function getDefault(): DiInterface | null
```

Return the latest DI created

```php
public function getInternalEventsManager(): ManagerInterface
```

Return the internal Events Manager

```php
public function getRaw(string $name): mixed
```

Returns a service definition without resolving

```php
public function getService(string $name): ServiceInterface
```

Returns a `Phalcon\Di\Service` instance

```php
public function getServices(): ServiceInterface[]
```

Return the services registered in the DI

```php
public function getShared( 
    string $name, 
    mixed parameters = null
): mixed
```

Returns a shared service. The service is first resolved, then the resolved service is stored in the DI. Subsequent requests for this service will return the same instance

```php
public function loadFromPhp(string $filePath)
```

Loads services from a php config file.

```php
// /app/config/services.php
return [
     'myComponent' => [
         'className' => '\Acme\Components\MyComponent',
         'shared'    => true,
     ],
     'group'       => [
         'className' => '\Acme\Group',
         'arguments' => [
             [
                 'type'    => 'service',
                 'service' => 'myComponent',
             ],
         ],
     ],
     'user'        => [
         'className' => '\Acme\User',
     ],
];

$container->loadFromPhp("/app/config/services.php");
```

```php
public function loadFromYaml(
    string $filePath, 
    array $callbacks = null
)
```

Loads services from a yaml file.

```php
// /app/config/services.yml
myComponent:
    className: \Acme\Components\MyComponent
    shared: true

group:
    className: \Acme\Group
    arguments:
        - type: service
          name: myComponent

user:
   className: \Acme\User


$container->loadFromYaml(
    "/app/config/services.yaml",
    [
        "!approot" => function ($value) {
            return dirname(__DIR__) . $value;
        }
    ]
);
```

```php
public function has(string $name): bool
```

Check whether the DI contains a service by a name

```php
public function offsetGet(mixed $name): mixed
```

Gets a shared service using the array syntax

```php
var_dump($container["request"]);
```

```php
public function offsetExists(mixed $name): bool
```

Check if a service is registered using the array syntax

```php
public function offsetSet(mixed $name, mixed $definition)
```

Allows to register a shared service using the array syntax

```php
$container["request"] = new \Phalcon\Http\Request();
```

```php
public function offsetUnset(mixed $name)
```

Removes a service from the services container using the array syntax

```php
public function register(ServiceProviderInterface $provider)
```

Registers a service provider.

```php
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class SomeServiceProvider implements ServiceProviderInterface
{
    public function register(DiInterface $container)
    {
        $container->setShared(
            'service',
            function () {
                // ...
            }
        );
    }
}
```

```php
public function remove(string $name)
```

Removes a service in the services container. It also removes any shared instance created for the service

```php
public static function reset()
```

Resets the internal default DI

```php
public function set(
    string $name, 
    mixed $definition, 
    bool $shared = false
): ServiceInterface
```

Registers a service in the services container

```php
public static function setDefault(<DiInterface> container)
* Set a default dependency injection container to be obtained into static
* methods
```

```php
public function setInternalEventsManager(
    ManagerInterface $eventsManager
)
```

Sets the internal event manager

```php
public function setService(
    string $name, 
    ServiceInterface $rawDefinition
): ServiceInterface
```

Sets a service using a raw Phalcon\Di\Service definition

```php
public function setShared(
    string $name, 
    mixed $definition
): ServiceInterface
```

Registers an *always shared* service in the services container

## Registering Services

The framework itself or the developer can register services. When a component A requires component B (or an instance of its class) to operate, it can request component B from the container, rather than creating a new instance component B.

This approach offers the following advantages: * We can easily replace a component with one created by ourselves or a third party. * We have full control of the object initialization, allowing us to set these objects as needed before delivering them to components. * We can get global instances of components in a structured and unified way.

Services can be registered using several types of definitions. Below we explore the different ways that services can be registered:

### String

This type expects the name of a valid class, returning an object of the specified class, if the class is not loaded it will be instantiated using an auto-loader. This type of definition does not allow to specify arguments for the class constructor or parameters:

```php
<?php

use Phalcon\Http\Request;

$container->set(
    'request',
    Request::class
);
```

### Class Instances

This type expects an object. Due to the fact that object does not need to be resolved as it is already an object, one could say that it is not really a dependency injection, however it is useful if you want to force the returned dependency to always be the same object/value:

```php
<?php

use Phalcon\Http\Request;

$container->set(
    'request',
    new Request()
);
```

### Closures

This method offers greater freedom to build the dependency as desired, however, it is difficult to change some of the parameters externally without having to completely change the definition of dependency:

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql;

$container->set(
    'db',
    function () {
        return new Mysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'tutorial',
            ]
        );
    }
);
```

Some of the limitations can be overcome by passing additional variables to the closure's environment:

```php
<?php

use Phalcon\Config;
use Phalcon\Db\Adapter\Pdo\Mysql;

$config = new Config(
    [
        'host'     => 'localhost',
        'username' => 'user',
        'password' => 'pass',
        'dbname'   => 'tutorial',
    ]
);

$container->set(
    'db',
    function () use ($config) {
        return new Mysql(
            [
                'host'     => $config->host,
                'username' => $config->username,
                'password' => $config->password,
                'dbname'   => $config->name,
            ]
        );
    }
);
```

You can also access other DI services using the `get()` method:

```php
<?php

use Phalcon\Config;
use Phalcon\Db\Adapter\Pdo\Mysql;

$container->set(
    'config',
    function () {
        return new Config(
            [
                'host'     => 'localhost',
                'username' => 'user',
                'password' => 'pass',
                'dbname'   => 'tutorial',
            ]
        );
    }
);

$container->set(
    'db',
    function () {
        $config = $this->get('config');

        return new Mysql(
            [
                'host'     => $config->host,
                'username' => $config->username,
                'password' => $config->password,
                'dbname'   => $config->name,
            ]
        );
    }
);
```

> NOTE: `$this` can be used inside a closure
{: .alert .alert-info }

### Complex Registration

If it is required to change the definition of a service without instantiating/resolving the service, then, we need to define the services using the array syntax. Define a service using an array definition can be a little more verbose:

```php
<?php

use Phalcon\Annotations\Adapter\Apcu;

$container->set(
    'annotations',
    [
        'className' => Apcu::class,
        'arguments' => [
            [
                'type'  => 'parameter',
                'name'  => 'prefix',
                'value' => 'my-prefix',
            ],
            [
                'type'  => 'parameter',
                'name'  => 'lifetime',
                'value' => 3600,
            ],
        ],
    ]
);


$container->set(
    'annotations',
    function () {
        return new Apcu(
            [
                'prefix'   => 'my-prefix',
                'lifetime' => 3600,
            ]
        );
    }
);
```

Both service registrations above produce the same result. The array definition however, allows you to change the service parameters if you need to:

```php
<?php

use Phalcon\Annotations\Adapter\Memory;

$container
    ->getService('annotations')
    ->setClassName(Memory::class)
;

$container
    ->getService('annotations')
    ->setParameter(
        1,
        [
            'type'  => 'parameter',
            'name'  => 'lifetime',
            'value' => 7200,
        ]
    );
```

### Injections

In addition by using the array syntax you can use three types of dependency injection:

#### Constructor Injection

This injection type passes the dependencies/arguments to the class constructor. Let's pretend we have the following component:

```php
<?php

namespace MyApp\Http;

use Phalcon\Http\Response;

class Responder
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * @var string
     */
    protected $contentType;

    public function __construct(Response $response, string $contentType)
    {
        $this->response    = $response;
        $this->contentType = $contentType;
    }
}
```

The service can be registered as follows:

```php
<?php

use MyApp\Http\Responder;
use Phalcon\Http\Response;

$container->set(
    'response',
    [
        'className' => Response::class
    ]
);

$container->set(
    'my-responder',
    [
        'className' => Responder::class,
        'arguments' => [
            [
                'type' => 'service',
                'name' => 'response',
            ],
            [
                'type'  => 'parameter',
                'value' => 'application/json',
            ],
        ]
    ]
);
```

The service `response` ([Phalcon\Http\Response](response) is resolved to be passed as the first argument of the constructor, while the second is a `string` value that is passed as it is.

#### Setter Injection

Classes may have setters to inject optional dependencies, our previous class can be changed to accept the dependencies with setters:

```php
<?php

namespace MyApp\Http;

use Phalcon\Http\Response;

class Responder
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * @var string
     */
    protected $contentType;

    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }
}
```

The above class can be registered as a service using the getter and setter:

```php
<?php

use MyApp\Http\Responder;
use Phalcon\Http\Response;

$container->set(
    'response',
    [
        'className' => Response::class,
    ]
);

$container->set(
    'my-responder',
    [
        'className' => Responder::class,
        'calls'     => [
            [
                'method'    => 'setResponse',
                'arguments' => [
                    [
                        'type' => 'service',
                        'name' => 'response',
                    ]
                ]
            ],
            [
                'method'    => 'setContentType',
                'arguments' => [
                    [
                        'type'  => 'parameter',
                        'value' => 'application/json',
                    ]
                ]
            ]
        ]
    ]
);
```

#### Properties Injection

A less common strategy is to inject dependencies or parameters directly into public attributes of the class:

```php
<?php

namespace MyApp\Http;

use Phalcon\Http\Response;

class Responder
{
    /**
     * @var Response
     */
    public $response;

    /**
     * @var string
     */
    public $contentType;
}
```

A service with properties injection can be registered as follows:

```php
<?php

use MyApp\Http\Responder;
use Phalcon\Http\Response;

$container->set(
    'response',
    [
        'className' => Response::class,
    ]
);

$container->set(
    'my-responder',
    [
        'className'  => Responder::class,
        'properties' => [
            [
                'name'  => 'response',
                'value' => [
                    'type' => 'service',
                    'name' => 'response',
                ],
            ],
            [
                'name'  => 'contentType',
                'value' => [
                    'type'  => 'parameter',
                    'value' => 'application/json',
                ],
            ]
        ]
    ]
);
```

Supported parameter types include the following:

| Type        | Description                                          | Example                                                                                     |
| ----------- | ---------------------------------------------------- | ------------------------------------------------------------------------------------------- |
| `instance`  | Represents an object that must be built dynamically  | `['type' => 'instance', 'className' => \DateTime::class, 'arguments' => ['now']]` |
| `parameter` | Represents a literal value to be passed as parameter | `['type' => 'parameter', 'value' => 1234]`                                            |
| `service`   | Represents another service in the service container  | `['type' => 'service', 'name' => 'request']`                                          |

Resolving a service whose definition is complex may be slightly slower than simple definitions seen previously. However, these provide a more robust approach to define and inject services. Mixing different types of definitions is allowed, and you can decide which way is the most appropriate for you to register the services according to the application needs.

### Array Syntax

The array syntax is also available to register services:

```php
<?php

use Phalcon\Di;
use Phalcon\Http\Request;

$container = new Di();

$container['request'] = Request::class;

$container['request'] = function () {
    return new Request();
};

$container['request'] = new Request();

$container['request'] = [
    'className' => Request::class,
];
```

In the examples above, when the framework needs to access the request data, it will ask for the service identified as `request` in the container. The container in turn will return an instance of the required service. The component can be easily replaced with a different class if a need arises.

As shown in the above examples, each of the ways used to set/register a service has advantages and disadvantages. It is up to the developer and the particular requirements that will designate which one is used. Setting a service by a string is simple, but lacks flexibility. Setting services using an array offers a lot more flexibility, but makes the code more complicated. The lambda function is a good balance between the two, but could lead to more maintenance than one would expect.

> **NOTE**: [Phalcon\Di](api/phalcon_di#di) offers lazy loading for every service it stores. Unless the developer chooses to instantiate an object directly and store it in the container, any object stored in it (via array, string, etc.) will be lazy loaded i.e. instantiated only when requested.
{: .alert .alert-info }

### Load From Config

**YAML**

This feature will load services by parsing a YAML file:

```yaml
; /app/config/services.yml
config:
  className: \Phalcon\Config
  shared: true
```

```php
<?php

use Phalcon\Di;

$container = new Di();
$container->loadFromYaml('services.yml');
$container->get('/app/config/services.yml');
```

> **NOTE**: This approach requires that the module Yaml be installed. Please refer to [this document](https://php.net/manual/book.yaml.php) for more information.
{: .alert .alert-danger }


**PHP**

You can also load services using a PHP array:

```php
// /app/config/services.php

use Phalcon\Config;

return [
    'config' => [
        'className' => Config::class,
        'shared'    => true,
    ],
];
```

```php
<?php

use Phalcon\Di;

$container = new Di();
$container->loadFromPhp('/app/config/services.php');
$container->get('config');
```

## Resolving Services

Obtaining a service from the container is a matter of simply calling the 'get' method. A new instance of the service will be returned:

```php
$request = $container->get('request');
```

Or by calling through the magic method:

```php
$request = $container->getRequest();
```

Or using the array-access syntax:

```php
$request = $container['request'];
```

Arguments can be passed to the constructor by adding an array parameter to the method 'get':

```php
<?php

use Phalcon\Annotations\Adapter\Stream;

$annotations = $container->get(
    Stream::class,
    [
        ['annotationsDir' => 'storage/cache/annotations'],
    ]
);
```

## Events

[Phalcon\Di](api/phalcon_di#di) is able to send events to an [EventsManager](events) if it is present. Events are triggered using the type `di`.

| Event Name             | Triggered                                                                                                       |
| ---------------------- | --------------------------------------------------------------------------------------------------------------- |
| `afterServiceResolve`  | Triggered after resolve service. Listeners receive the service name, instance, and the parameters passed to it. |
| `beforeServiceResolve` | Triggered before resolve service. Listeners receive the service name and the parameters passed to it.           |

## Shared Services

Services can be registered as `shared` services this means that they always will act as \[singletons\]\[singletons\]. Once the service is resolved for the first time the same instance of it is returned every time the service is retrieved from the container:

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$container->setShared(
    'session',
    function () {
        $session = new Manager();
        $files = new Stream(
            [
                'savePath' => '/tmp',
            ]
        );
        $session->setAdapter($files);
        $session->start();

        return $session;
    }
);

$session = $container->get('session');

$session = $container->getSession();
```

The first call to `get` in the container resolves the service and returns the object back. The subsequent call to `getSession` will return the same object.

An alternative way to register shared services is to pass `true` as third parameter of `set`:

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$container->set(
    'session',
    function () {
        $session = new Manager();
        $files = new Stream(
            [
                'savePath' => '/tmp',
            ]
        );
        $session->setAdapter($files);
        $session->start();

        return $session;
    },
    true
);

$session = $container->get('session');

$session = $container->getSession();
```

> **NOTE**: If a service is not registered as shared and you want to ensure that a shared instance will be accessed every time the service is retrieved from the DI, you can use the `getShared` method
{: .alert .alert-info }

```php
$request = $container->getShared('request');
```

## Manipulating Services

Once a service is registered in the service container, you can retrieve it to manipulate it individually:

```php
    <?php

    use Phalcon\Http\Request;

    // Register the 'request' service
    $container->set('request', 'Phalcon\Http\Request');

    // Get the service
    $requestService = $container->getService('request');

    // Change its definition
    $requestService->setDefinition(
        function () {
            return new Request();
        }
    );

    // Change it to shared
    $requestService->setShared(true);

    // Resolve the service (return a Phalcon\Http\Request instance)
    $request = $requestService->resolve();
```

## Instantiating Classes

When you request a service from the container, if it cannot be found by using the same name, it will try to load a class with the same name. This behavior allows you to replace any service with another, by simply registering a service with the common name:

```php
<?php

$container->set(
    'IndexController',
    function () {
        return new Component();
    },
    true
);

$container->set(
    'MyOtherComponent',
    function () {
        return new AnotherComponent();
    }
);

$component = $container->get('MyOtherComponent');
```

In the above example we are *replacing* the `IndexController` with a component of our choosing. Also

You can adjust your code to always instantiate your classes using the service container, even if they are not registered as services. The container will fall back to the autoloader you have defined to load the class itself. By using this technique, you can replace any class in the future by implementing a different definition for it.

## Automatic Injecting

If a class or component requires the DI itself to locate services, the DI can automatically inject itself to the instances it creates. To take advantage of this, all you need is to implement the [Phalcon\Di\InjectionAwareInterface](api/phalcon_di#di-injectionawareinterface) in your classes:

```php
<?php

use Phalcon\Di\DiInterface;
use Phalcon\Di\InjectionAwareInterface;

class InvoiceComponent implements InjectionAwareInterface
{
    /**
     * @var DiInterface
     */
    protected $container;

    public function setDi(DiInterface $container)
    {
        $this->container = $container;
    }

    public function getDi(): DiInterface
    {
        return $this->container;
    }
}
```

Then once the service is resolved, the `$container` will be passed to `setDi()` automatically:

```php
<?php

$container->set('inv-component', InvoiceComponent::class);

$invoiceComponent = $container->get('inv-component');
```

> **NOTE** `: $invoiceComponent->setDi($container) is automatically called)
{: .alert .alert-info }

For your convenience you can also extend the [Phalcon\Di\AbstractInjectionAware](api/phalcon_di#di-abstractinjectionaware) class which contains the above code and exposes the protected `$container` property for you to use.

```php
<?php

use Phalcon\Di\DiInterface;
use Phalcon\Di\AbstractInjectionAware;

class InvoiceComponent extends AbstractInjectionAware
{

}
```

## Organizing Services in Files

You can better organize your application by moving the service registration to individual files instead of register everything in the application's bootstrap:

```php
<?php

$container->set(
    'router',
    function () {
        return include '/app/config/routes.php';
    }
);
```

Then in the file (`'/app/config/routes.php'`) return the object resolved:

```php
<?php

use Phalcon\Mvc\Router();

$router = new Router(false);

$router->post('/login');

return $router;
```

## Static Access

The [Phalcon\Di](api/phalcon_di#di) offers the convenient `getDefault()` static method, which returns the latest container created. This allows you to access the container even from static classes:

```php
<?php

use Phalcon\Di;

class InvoicesComponent
{
    public static function calculate()
    {
        $connection = Di::getDefault()->getDb();
    }
}
```

## Service Providers

Another method of registering services is by putting each service in its own file and registering all the services one after another with a simple loop. Each file will contain a class or `Provider` that implements the [Phalcon\Di\ServiceProviderInterface](api/phalcon_di#di-serviceproviderinterface). The reason you might want to do this is to have tiny files, each handling one service registration which will offer great flexibility, short code and finally the ability to add/remove services whenever you wish to, without having to sift through a large file such as your bootstap.

**Example**

`app/config/providers.php`

```php
<?php

return [
    MyApp\Providers\ConfigProvider::class,
    MyApp\Providers\RegistryProvider::class,
    MyApp\Providers\LoggerProvider::class,
];    
```

`app/library/Providers/ConfigProvider.php`

```php
<?php

namespace MyApp\Providers;

use Phalcon\Config;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;

class ConfigProvider implements ServiceProviderInterface
{
    /**
     * @param DiInterface $container
     */
    public function register(DiInterface $container)
    {
        $container->setShared(
            'config',
            function () {
                $data = require 'app/config/config.php';

                return new Config($data);
            }
        );
    }
}
```

`app/library/Providers/RegistryProvider.php`

```php
<?php

namespace MyApp\Providers;

use Phalcon\Config;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;
use Phalcon\Registry;
use function microtime;

class RegistryProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     *
     * @param DiInterface $container
     */
    public function register(DiInterface $container)
    {
        /** @var Config $config */
        $config  = $container->getShared('config');
        $devMode = $config->path('app.devMode', false);

        $container->setShared(
            'registry',
            function () use ($devMode) {
                $registry = new Registry();
                $registry->offsetSet('devMode', $devMode);
                $registry->offsetSet('execution', microtime(true));

                return $registry;
            }
        );
    }
}
```

`app/library/Providers/LoggerProvider.php` ```php <?php

namespace MyApp\Providers;

use Phalcon\Di\ServiceProviderInterface; use Phalcon\DiInterface; use Phalcon\Logger; use Phalcon\Logger\Adapter\Stream;

class LoggerProvider implements ServiceProviderInterface { use LoggerTrait;

    /**
     * @param DiInterface $container
     *
     * @throws \Exception
     */
    public function register(DiInterface $container)
    {
        $container->setShared(
            'logger', 
            function () {
                $adapter = new Stream('/storage/logs/main.log');
    
                return new Logger(
                    'messages',
                    [
                        'main' => $adapter,
                    ]
                );
            }
        );
    }
    

}

    <br />Now we can register all the services with a simple loop:
    
    ```php
    <?php
    
    use Phalcon\Di;
    
    $services = include('app/config/providers.php');
    
    $container = new Di();
    
    foreach ($services as $service) {
        $container->register(new $service());
    }
    

## Factory Default

For convenience to developers, the [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) is available with several preset services for you. Nothing stops you from registering all the services your application requires one by one. However, you can use the [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault), which contains a list of services ready to be used. The list of services registered allows you to have a container suitable for a full stack application.

> **NOTE** Since the services are always lazy loaded, instantiating the [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) container will not consume more memory than a [Phalcon\Di](api/phalcon_di#di) one.
{: .alert .alert-info }

```php
<?php

use Phalcon\Di\FactoryDefault;

$container = new FactoryDefault();
```

The services registered in the [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) are:

| Name                 | Object                                                              | Shared | Description                  |
| -------------------- | ------------------------------------------------------------------- | ------ | ---------------------------- |
| `annotations`        | [Phalcon\Annotations\Adapter\Memory](annotations)                | Yes    | Annotations parser           |
| `assets`             | [Phalcon\Assets\Manager](assets)                                  | Yes    | Assets manager               |
| `crypt`              | [Phalcon\Crypt](crypt)                                             | Yes    | Encrypt/Decrypt              |
| `cookies`            | [Phalcon\Http\Response\Cookies](response#cookies)                | Yes    | HTTP Cookies manager         |
| `db`                 | [Phalcon\Db](db-layer)                                             | Yes    | Database connection          |
| `dispatcher`         | [Phalcon\Mvc\Dispatcher](dispatcher)                              | Yes    | Dispatcher                   |
| `escaper`            | [Phalcon\Escaper](escaper)                                         | Yes    | Escaper                      |
| `eventsManager`      | [Phalcon\Events\Manager](events)                                  | Yes    | Events Manager               |
| `flash`              | [Phalcon\Flash\Direct](flash)                                     | Yes    | Flash Messaging              |
| `flashSession`       | [Phalcon\Flash\Session](flash)                                    | Yes    | Flash Session Messaging      |
| `filter`             | [Phalcon\Filter](filter)                                           | Yes    | Filtering / Sanitizing       |
| `modelsCache`        |                                                                     |        | Cache backend for models     |
| `modelsManager`      | [Phalcon\Mvc\Model\Manager](db-models)                           | Yes    | Models Management            |
| `modelsMetadata`     | [Phalcon\Mvc\Model\MetaData\Memory](db-models-metadata)         | No     | Models MetaData              |
| `request`            | [Phalcon\Http\Request](request)                                   | Yes    | HTTP Request                 |
| `response`           | [Phalcon\Http\Response](response)                                 | Yes    | HTTP Response                |
| `router`             | [Phalcon\Mvc\Router](routing)                                     | Yes    | Router                       |
| `security`           | [Phalcon\Security](security)                                       | Yes    | Security                     |
| `session`            |                                                                     |        | Session Service              |
| `sessionBag`         | [Phalcon\Session\Bag](session#bag)                                | Yes    | Session Bag service          |
| `tag`                | [Phalcon\Tag](tag)                                                 | Yes    | HTML Tag helpers             |
| `transactionManager` | [Phalcon\Mvc\Model\Transaction\Manager](db-models-transactions) | Yes    | Database Transaction Manager |
| `url`                | [Phalcon\Url](url)                                                 | Yes    | URL Generation               |

The above names are used throughout the framework. For instance the `db` service is used within the `transactionManager` service. You can replace these components with the ones you prefer by just registering your component with the same name as the ones listed above.

## Exceptions

Any exceptions thrown in the DI container will be either [Phalcon\Di\Exception](api/phalcon_di#di-exception) or [Phalcon\Di\ServiceResolutionException](api/phalcon_di#di-exception-serviceresolutionexception). You can use this exception to selectively catch exceptions thrown only from this component.

```php
<?php

use Phalcon\Di;
use Phalcon\Di\Exception;

try {
    $container = new Di();
    $component = $container->get('unknown-service');
} catch (Exception $ex) {
    echo $ex->getMessage();
}
```

## Custom

The [Phalcon\Di\DiInterface](api/phalcon_di#di-diinterface) interface must be implemented to create your own DI replacing the one provided by Phalcon or extend the current one. You can also utilize the [Phalcon\Di\ServiceInterface](api/phalcon_di#di-serviceinterface) to create your own implementations of services and how they resolve in the DI container.