<div class='article-menu'>
  <ul>
    <li>
      <a href="#di-service-location">Dependency Injection / Service Location</a> <ul>
        <li>
          <a href="#di-explained">DI explained</a>
        </li>
        <li>
          <a href="#registering-services">Registering services in the Container</a> <ul>
            <li>
              <a href="#simple-registration">Simple Registration</a> <ul>
                <li>
                  <a href="#simple-registration-string">String</a>
                </li>
                <li>
                  <a href="#class-instances">Class instances</a>
                </li>
                <li>
                  <a href="#closures-anonymous-functions">Closures/Anonymous functions</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#complex-registration">Complex Registration</a> <ul>
                <li>
                  <a href="#constructor-injection">Constructor Injection</a>
                </li>
                <li>
                  <a href="#setter-injection">Setter Injection</a>
                </li>
                <li>
                  <a href="#properties-injection">Properties Injection</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#array-syntax">Array Syntax</a>
            </li>
            <li>
              <a href="#loading-from-yaml">Loading from YAML</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#resolving-services">Resolving Services</a> <ul>
            <li>
              <a href="#events">Events</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#shared-services">Shared services</a>
        </li>
        <li>
          <a href="#manipulating-services-individually">Manipulating services individually</a>
        </li>
        <li>
          <a href="#instantiating-classes-service-container">Instantiating classes via the Service Container</a>
        </li>
        <li>
          <a href="#automatic-injecting-di-itself">Automatic Injecting of the DI itself</a>
        </li>
        <li>
          <a href="#organizing-services-files">Organizing services in files</a>
        </li>
        <li>
          <a href="#accessing-di-static-way">Accessing the DI in a static way</a>
        </li>
        <li>
          <a href="#factory-default-di">Factory Default DI</a>
        </li>
        <li>
          <a href="#service-name-conventions">Service Name Conventions</a>
        </li>
        <li>
          <a href="#service-provider">Service Providers</a>
        </li>
        <li>
          <a href="#implementing-your-own-di">Implementing your own DI</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='di-service-location'></a>

# Dependency Injection / Service Location

<a name='di-explained'></a>

## DI explained

The following example is a bit long, but it attempts to explain why Phalcon uses service location and dependency injection. First, let's assume we are developing a component called `SomeComponent`. This performs some task. Our component has a dependency, that is a connection to a database.

In this first example, the connection is created inside the component. Although this is a perfectly valid implementation, it is impartical, due to the fact that we cannot change the connection parameters or the type of the database system because the component only works as created.

```php
<?php

class SomeComponent
{
    /**
     * The instantiation of the connection is hardcoded inside
     * the component, therefore it's difficult replace it externally
     * or change its behavior
     */
    public function someDbTask()
    {
        $connection = new Connection(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'invo',
            ]
        );

        // ...
    }
}

$some = new SomeComponent();

$some->someDbTask();
```

To solve this shortcoming, we have created a setter that injects the dependency externally before using it. This is also a valid implementation but has its shortcomings:

```php
<?php

class SomeComponent
{
    private $connection;

    /**
     * Sets the connection externally
     *
     * @param Connection $connection
     */
    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function someDbTask()
    {
        $connection = $this->connection;

        // ...
    }
}

$some = new SomeComponent();

// Create the connection
$connection = new Connection(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'secret',
        'dbname'   => 'invo',
    ]
);

// Inject the connection in the component
$some->setConnection($connection);

$some->someDbTask();
```

Now consider that we use this component in different parts of the application and then we will need to create the connection several times before passing it to the component. Using a global registry pattern, we can store the connection object there and reuse it whenever we need it.

```php
<?php

class Registry
{
    /**
     * Returns the connection
     */
    public static function getConnection()
    {
        return new Connection(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'invo',
            ]
        );
    }
}

class SomeComponent
{
    protected $connection;

    /**
     * Sets the connection externally
     *
     * @param Connection $connection
     */
    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function someDbTask()
    {
        $connection = $this->connection;

        // ...
    }
}

$some = new SomeComponent();

// Pass the connection defined in the registry
$some->setConnection(Registry::getConnection());

$some->someDbTask();
```

Now, let's imagine that we must implement two methods in the component, the first always needs to create a new connection and the second always needs to use a shared connection:

```php
<?php

class Registry
{
    protected static $connection;

    /**
     * Creates a connection
     *
     * @return Connection
     */
    protected static function createConnection(): Connection
    {
        return new Connection(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'invo',
            ]
        );
    }

    /**
     * Creates a connection only once and returns it
     *
     * @return Connection
     */
    public static function getSharedConnection(): Connection
    {
        if (self::$connection === null) {
            self::$connection = self::createConnection();
        }

        return self::$connection;
    }

    /**
     * Always returns a new connection
     *
     * @return Connection
     */
    public static function getNewConnection(): Connection
    {
        return self::createConnection();
    }
}

class SomeComponent
{
    protected $connection;

    /**
     * Sets the connection externally
     *
     * @param Connection $connection
     */
    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * This method always needs the shared connection
     */
    public function someDbTask()
    {
        $connection = $this->connection;

        // ...
    }

    /**
     * This method always needs a new connection
     *
     * @param Connection $connection
     */
    public function someOtherDbTask(Connection $connection)
    {

    }
}

$some = new SomeComponent();

// This injects the shared connection
$some->setConnection(
    Registry::getSharedConnection()
);

$some->someDbTask();

// Here, we always pass a new connection as parameter
$some->someOtherDbTask(
    Registry::getNewConnection()
);
```

So far we have seen how dependency injection solved our problems. Passing dependencies as arguments instead of creating them internally in the code makes our application more maintainable and decoupled. However, in the long-term, this form of dependency injection has some disadvantages.

For instance, if the component has many dependencies, we will need to create multiple setter arguments to pass the dependencies or create a constructor that pass them with many arguments, additionally creating dependencies before using the component, every time, makes our code not as maintainable as we would like:

```php
<?php

// Create the dependencies or retrieve them from the registry
$connection = new Connection();
$session    = new Session();
$fileSystem = new FileSystem();
$filter     = new Filter();
$selector   = new Selector();

// Pass them as constructor parameters
$some = new SomeComponent($connection, $session, $fileSystem, $filter, $selector);

// ... Or using setters
$some->setConnection($connection);
$some->setSession($session);
$some->setFileSystem($fileSystem);
$some->setFilter($filter);
$some->setSelector($selector);
```

Think if we had to create this object in many parts of our application. In the future, if we do not require any of the dependencies, we need to go through the entire code base to remove the parameter in any constructor or setter where we injected the code. To solve this, we return again to a global registry to create the component. However, it adds a new layer of abstraction before creating the object:

```php
<?php

class SomeComponent
{
    // ...

    /**
     * Define a factory method to create SomeComponent instances injecting its dependencies
     */
    public static function factory()
    {
        $connection = new Connection();
        $session    = new Session();
        $fileSystem = new FileSystem();
        $filter     = new Filter();
        $selector   = new Selector();

        return new self($connection, $session, $fileSystem, $filter, $selector);
    }
}
```

Now we find ourselves back where we started, we are again building the dependencies inside of the component! We must find a solution that keeps us from repeatedly falling into bad practices.

A practical and elegant way to solve these problems is using a container for dependencies. The containers act as the global registry that we saw earlier. Using the container for dependencies as a bridge to obtain the dependencies allows us to reduce the complexity of our component:

```php
<?php

use Phalcon\Di;
use Phalcon\DiInterface;

class SomeComponent
{
    protected $di;

    public function __construct(DiInterface $di)
    {
        $this->di = $di;
    }

    public function someDbTask()
    {
        // Get the connection service
        // Always returns a new connection
        $connection = $this->di->get('db');
    }

    public function someOtherDbTask()
    {
        // Get a shared connection service,
        // this will return the same connection every time
        $connection = $this->di->getShared('db');

        // This method also requires an input filtering service
        $filter = $this->di->get('filter');
    }
}

$di = new Di();

// Register a 'db' service in the container
$di->set(
    'db',
    function () {
        return new Connection(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'invo',
            ]
        );
    }
);

// Register a 'filter' service in the container
$di->set(
    'filter',
    function () {
        return new Filter();
    }
);

// Register a 'session' service in the container
$di->set(
    'session',
    function () {
        return new Session();
    }
);

// Pass the service container as unique parameter
$some = new SomeComponent($di);

$some->someDbTask();
```

The component can now simply access the service it requires when it needs it, if it does not require a service it is not even initialized, saving resources. The component is now highly decoupled. For example, we can replace the manner in which connections are created, their behavior or any other aspect of them and that would not affect the component.

`Phalcon\Di` is a component implementing Dependency Injection and Location of services and it's itself a container for them.

Since Phalcon is highly decoupled, `Phalcon\Di` is essential to integrate the different components of the framework. The developer can also use this component to inject dependencies and manage global instances of the different classes used in the application.

Basically, this component implements the [Inversion of Control](http://en.wikipedia.org/wiki/Inversion_of_control) pattern. Applying this, the objects do not receive their dependencies using setters or constructors, but requesting a service dependency injector. This reduces the overall complexity since there is only one way to get the required dependencies within a component.

Additionally, this pattern increases testability in the code, thus making it less prone to errors.

<a name='registering-services'></a>

## Registering services in the Container

The framework itself or the developer can register services. When a component A requires component B (or an instance of its class) to operate, it can request component B from the container, rather than creating a new instance component B.

This way of working gives us many advantages:

- We can easily replace a component with one created by ourselves or a third party.
- We have full control of the object initialization, allowing us to set these objects, as needed before delivering them to components.
- We can get global instances of components in a structured and unified way.

Services can be registered using several types of definitions:

<a name='simple-registration'></a>

### Simple Registration

As seen before, there are several ways to register services. These we call simple:

<a name='simple-registration-string'></a>

#### String

This type expects the name of a valid class, returning an object of the specified class, if the class is not loaded it will be instantiated using an auto-loader. This type of definition does not allow to specify arguments for the class constructor or parameters:

```php
<?php

// Return new Phalcon\Http\Request();
$di->set(
    'request',
    'Phalcon\Http\Request'
);
```

<a name='class-instances'></a>

#### Class instances

This type expects an object. Due to the fact that object does not need to be resolved as it is already an object, one could say that it is not really a dependency injection, however it is useful if you want to force the returned dependency to always be the same object/value:

```php
<?php

use Phalcon\Http\Request;

// Return new Phalcon\Http\Request();
$di->set(
    'request',
    new Request()
);
```

<a name='closures-anonymous-functions'></a>

#### Closures/Anonymous functions

This method offers greater freedom to build the dependency as desired, however, it is difficult to change some of the parameters externally without having to completely change the definition of dependency:

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

$di->set(
    'db',
    function () {
        return new PdoMysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'blog',
            ]
        );
    }
);
```

Some of the limitations can be overcome by passing additional variables to the closure's environment:

```php
<?php

use Phalcon\Config;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

$config = new Config(
    [
        'host'     => '127.0.0.1',
        'username' => 'user',
        'password' => 'pass',
        'dbname'   => 'my_database',
    ]
);

// Using the $config variable in the current scope
$di->set(
    'db',
    function () use ($config) {
        return new PdoMysql(
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
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

$di->set(
    'config',
    function () {
        return new Config(
            [
                'host'     => '127.0.0.1',
                'username' => 'user',
                'password' => 'pass',
                'dbname'   => 'my_database',
            ]
        );
    }
);

// Using the 'config' service from the DI
$di->set(
    'db',
    function () {
        $config = $this->get('config');

        return new PdoMysql(
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

<a name='complex-registration'></a>

### Complex Registration

If it is required to change the definition of a service without instantiating/resolving the service, then, we need to define the services using the array syntax. Define a service using an array definition can be a little more verbose:

```php
<?php

use Phalcon\Logger\Adapter\File as LoggerFile;

// Register a service 'logger' with a class name and its parameters
$di->set(
    'logger',
    [
        'className' => 'Phalcon\Logger\Adapter\File',
        'arguments' => [
            [
                'type'  => 'parameter',
                'value' => '../apps/logs/error.log',
            ]
        ]
    ]
);

// Using an anonymous function
$di->set(
    'logger',
    function () {
        return new LoggerFile('../apps/logs/error.log');
    }
);
```

Both service registrations above produce the same result. The array definition however, allows for alteration of the service parameters if needed:

```php
<?php

// Change the service class name
$di
    ->getService('logger')
    ->setClassName('MyCustomLogger');

// Change the first parameter without instantiating the logger
$di
    ->getService('logger')
    ->setParameter(
        0,
        [
            'type'  => 'parameter',
            'value' => '../apps/logs/error.log',
        ]
    );
```

In addition by using the array syntax you can use three types of dependency injection:

<a name='constructor-injection'></a>

#### Constructor Injection

This injection type passes the dependencies/arguments to the class constructor. Let's pretend we have the following component:

```php
<?php

namespace SomeApp;

use Phalcon\Http\Response;

class SomeComponent
{
    /**
     * @var Response
     */
    protected $response;

    protected $someFlag;



    public function __construct(Response $response, $someFlag)
    {
        $this->response = $response;
        $this->someFlag = $someFlag;
    }
}
```

The service can be registered this way:

```php
<?php

$di->set(
    'response',
    [
        'className' => 'Phalcon\Http\Response'
    ]
);

$di->set(
    'someComponent',
    [
        'className' => 'SomeApp\SomeComponent',
        'arguments' => [
            [
                'type' => 'service',
                'name' => 'response',
            ],
            [
                'type'  => 'parameter',
                'value' => true,
            ],
        ]
    ]
);
```

The service 'response' (`Phalcon\Http\Response`) is resolved to be passed as the first argument of the constructor, while the second is a boolean value (true) that is passed as it is.

<a name='setter-injection'></a>

#### Setter Injection

Classes may have setters to inject optional dependencies, our previous class can be changed to accept the dependencies with setters:

```php
<?php

namespace SomeApp;

use Phalcon\Http\Response;

class SomeComponent
{
    /**
     * @var Response
     */
    protected $response;

    protected $someFlag;



    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    public function setFlag($someFlag)
    {
        $this->someFlag = $someFlag;
    }
}
```

A service with setter injection can be registered as follows:

```php
<?php

$di->set(
    'response',
    [
        'className' => 'Phalcon\Http\Response',
    ]
);

$di->set(
    'someComponent',
    [
        'className' => 'SomeApp\SomeComponent',
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
                'method'    => 'setFlag',
                'arguments' => [
                    [
                        'type'  => 'parameter',
                        'value' => true,
                    ]
                ]
            ]
        ]
    ]
);
```

<a name='properties-injection'></a>

#### Properties Injection

A less common strategy is to inject dependencies or parameters directly into public attributes of the class:

```php
<?php

namespace SomeApp;

use Phalcon\Http\Response;

class SomeComponent
{
    /**
     * @var Response
     */
    public $response;

    public $someFlag;
}
```

A service with properties injection can be registered as follows:

```php
<?php

$di->set(
    'response',
    [
        'className' => 'Phalcon\Http\Response',
    ]
);

$di->set(
    'someComponent',
    [
        'className'  => 'SomeApp\SomeComponent',
        'properties' => [
            [
                'name'  => 'response',
                'value' => [
                    'type' => 'service',
                    'name' => 'response',
                ],
            ],
            [
                'name'  => 'someFlag',
                'value' => [
                    'type'  => 'parameter',
                    'value' => true,
                ],
            ]
        ]
    ]
);
```

Supported parameter types include the following:

<table>
  <tr>
    <th>
      Type
    </th>
    
    <th>
      Description
    </th>
    
    <th>
      Example
    </th>
  </tr>
  
  <tr>
    <td>
      parameter
    </td>
    
    <td>
      Represents a literal value to be passed as parameter
    </td>
    
    <td>
      <pre><code>php['type' =&gt; 'parameter', 'value' =&gt; 1234]</code></pre>
    </td>
  </tr>
  
  <tr>
    <td>
      service
    </td>
    
    <td>
      Represents another service in the service container
    </td>
    
    <td>
      <pre><code>php['type' =&gt; 'service', 'name' =&gt; 'request']</code></pre>
    </td>
  </tr>
  
  <tr>
    <td>
      instance
    </td>
    
    <td>
      Represents an object that must be built dynamically
    </td>
    
    <td>
      <pre><code>php['type' =&gt; 'instance', 'className' =&gt; 'DateTime', 'arguments' =&gt; ['now']]</code></pre>
    </td>
  </tr>
</table>

Resolving a service whose definition is complex may be slightly slower than simple definitions seen previously. However, these provide a more robust approach to define and inject services.

Mixing different types of definitions is allowed, everyone can decide what is the most appropriate way to register the services according to the application needs.

<a name='array-syntax'></a>

### Array Syntax

The array syntax is also allowed to register services:

```php
<?php

use Phalcon\Di;
use Phalcon\Http\Request;

// Create the Dependency Injector Container
$di = new Di();

// By its class name
$di['request'] = 'Phalcon\Http\Request';

// Using an anonymous function, the instance will be lazy loaded
$di['request'] = function () {
    return new Request();
};

// Registering an instance directly
$di['request'] = new Request();

// Using an array definition
$di['request'] = [
    'className' => 'Phalcon\Http\Request',
];
```

In the examples above, when the framework needs to access the request data, it will ask for the service identified as 'request' in the container. The container in turn will return an instance of the required service. A developer might eventually replace a component when he/she needs.

Each of the methods (demonstrated in the examples above) used to set/register a service has advantages and disadvantages. It is up to the developer and the particular requirements that will designate which one is used.

Setting a service by a string is simple, but lacks flexibility. Setting services using an array offers a lot more flexibility, but makes the code more complicated. The lambda function is a good balance between the two, but could lead to more maintenance than one would expect.

`Phalcon\Di` offers lazy loading for every service it stores. Unless the developer chooses to instantiate an object directly and store it in the container, any object stored in it (via array, string, etc.) will be lazy loaded i.e. instantiated only when requested.

<a name='loading-from-yaml'></a>

### Loading services from YAML files

This feature will let you set your services in `yaml` files or just in plain php. For example you can load services using a `yaml` file like this:

```yaml
config:
  className: \Phalcon\Config
  shared: true
```

```php
<?php

use Phalcon\Di;

$di = new Di();
$di->loadFromYaml('services.yml');
$di->get('config'); // will properly return config service
```

<a name='resolving-services'></a>

## Resolving Services

Obtaining a service from the container is a matter of simply calling the 'get' method. A new instance of the service will be returned:

```php
$request = $di->get('request');
```

Or by calling through the magic method:

```php
$request = $di->getRequest();
```

Or using the array-access syntax:

```php
$request = $di['request'];
```

Arguments can be passed to the constructor by adding an array parameter to the method 'get':

```php
<?php

// new MyComponent('some-parameter', 'other')
$component = $di->get(
    'MyComponent',
    [
        'some-parameter',
        'other',
    ]
);
```

<a name='envents'></a>

### Events

`Phalcon\Di` is able to send events to an :doc:`EventsManager <events>` if it is present. Events are triggered using the type 'di'. Some events when returning boolean false could stop the active operation. The following events are supported:

| Event Name           | Triggered                                                                                                       | Can stop operation? | Triggered on |
| -------------------- | --------------------------------------------------------------------------------------------------------------- |:-------------------:|:------------:|
| beforeServiceResolve | Triggered before resolve service. Listeners receive the service name and the parameters passed to it.           |         No          |  Listeners   |
| afterServiceResolve  | Triggered after resolve service. Listeners receive the service name, instance, and the parameters passed to it. |         No          |  Listeners   |

<a name='shared-services'></a>

## Shared services

Services can be registered as 'shared' services this means that they always will act as [singletons](http://en.wikipedia.org/wiki/Singleton_pattern). Once the service is resolved for the first time the same instance of it is returned every time a consumer retrieve the service from the container:

```php
<?php

use Phalcon\Session\Adapter\Files as SessionFiles;

// Register the session service as 'always shared'
$di->setShared(
    'session',
    function () {
        $session = new SessionFiles();

        $session->start();

        return $session;
    }
);

// Locates the service for the first time
$session = $di->get('session');

// Returns the first instantiated object
$session = $di->getSession();
```

An alternative way to register shared services is to pass 'true' as third parameter of 'set':

```php
<?php

// Register the session service as 'always shared'
$di->set(
    'session',
    function () {
        // ...
    },
    true
);
```

If a service isn't registered as shared and you want to be sure that a shared instance will be accessed every time the service is obtained from the DI, you can use the 'getShared' method:

```php
$request = $di->getShared('request');
```

<a name='manipulating-services-individually'></a>

## Manipulating services individually

Once a service is registered in the service container, you can retrieve it to manipulate it individually:

```php
    <?php

    use Phalcon\Http\Request;

    // Register the 'request' service
    $di->set('request', 'Phalcon\Http\Request');

    // Get the service
    $requestService = $di->getService('request');

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

<a name='instantiating-classes-service-container'></a>

## Instantiating classes via the Service Container

When you request a service to the service container, if it can't find out a service with the same name it'll try to load a class with the same name. With this behavior we can replace any class by another simply by registering a service with its name:

```php
<?php

// Register a controller as a service
$di->set(
    'IndexController',
    function () {
        $component = new Component();

        return $component;
    },
    true
);

// Register a controller as a service
$di->set(
    'MyOtherComponent',
    function () {
        // Actually returns another component
        $component = new AnotherComponent();

        return $component;
    }
);

// Create an instance via the service container
$myComponent = $di->get('MyOtherComponent');
```

You can take advantage of this, always instantiating your classes via the service container (even if they aren't registered as services). The DI will fallback to a valid autoloader to finally load the class. By doing this, you can easily replace any class in the future by implementing a definition for it.

<a name='automatic-injecting-di-itself'></a>

## Automatic Injecting of the DI itself

If a class or component requires the DI itself to locate services, the DI can automatically inject itself to the instances it creates, to do this, you need to implement the `Phalcon\Di\InjectionAwareInterface` in your classes:

```php
<?php

use Phalcon\DiInterface;
use Phalcon\Di\InjectionAwareInterface;

class MyClass implements InjectionAwareInterface
{
    /**
     * @var DiInterface
     */
    protected $di;


    public function setDi(DiInterface $di)
    {
        $this->di = $di;
    }

    public function getDi()
    {
        return $this->di;
    }
}
```

Then once the service is resolved, the `$di` will be passed to `setDi()` automatically:

```php
<?php

// Register the service
$di->set('myClass', 'MyClass');

// Resolve the service (NOTE: $myClass->setDi($di) is automatically called)
$myClass = $di->get('myClass');
```

<a name='organizing-services-files'></a>

## Organizing services in files

You can better organize your application by moving the service registration to individual files instead of doing everything in the application's bootstrap:

```php
<?php

$di->set(
    'router',
    function () {
        return include '../app/config/routes.php';
    }
);
```

Then in the file (`'../app/config/routes.php'`) return the object resolved:

```php
<?php

$router = new MyRouter();

$router->post('/login');

return $router;
```

<a name='accessing-di-static-way'></a>

## Accessing the DI in a static way

If needed you can access the latest DI created in a static function in the following way:

```php
<?php

use Phalcon\Di;

class SomeComponent
{
    public static function someMethod()
    {
        // Get the session service
        $session = Di::getDefault()->getSession();
    }
}
```

<a name='service-providers'></a>

## Service Providers

Using the `ServiceProviderInterface` you now register services by context. You can move all your `$di->set()` calls to classes like this:

```php
<?php

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;
use Phalcon\Di;
use Phalcon\Config\Adapter\Ini;

class SomeServiceProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di)
    {
        $di->set(
            'config', 
            function () {
                return new Ini('config.ini');
            }
        );
    }
}

$di = new Di();
$di->register(new SomeServiceProvider());
var_dump($di->get('config')); // will return properly our config
```

<a name='factory-default-di'></a>

## Factory Default DI

Although the decoupled character of Phalcon offers us great freedom and flexibility, maybe we just simply want to use it as a full-stack framework. To achieve this, the framework provides a variant of `Phalcon\Di` called `Phalcon\Di\FactoryDefault`. This class automatically registers the appropriate services bundled with the framework to act as full-stack.

```php
<?php

use Phalcon\Di\FactoryDefault;

$di = new FactoryDefault();
```

<a name='service-name-conventions'></a>

## Service Name Conventions

Although you can register services with the names you want, Phalcon has a several naming conventions that allow it to get the the correct (built-in) service when you need it.

| Service Name       | Description                           | Default                                     | Shared |
| ------------------ | ------------------------------------- | ------------------------------------------- |:------:|
| assets             | Assets Manager                        | `Phalcon\Assets\Manager`                  |  Yes   |
| annotations        | Annotations Parser                    | `Phalcon\Annotations\Adapter\Memory`     |  Yes   |
| cookies            | HTTP Cookies Management Service       | `Phalcon\Http\Response\Cookies`          |  Yes   |
| crypt              | Encrypt/Decrypt data                  | `Phalcon\Crypt`                            |  Yes   |
| db                 | Low-Level Database Connection Service | `Phalcon\Db`                               |  Yes   |
| dispatcher         | Controllers Dispatching Service       | `Phalcon\Mvc\Dispatcher`                  |  Yes   |
| eventsManager      | Events Management Service             | `Phalcon\Events\Manager`                  |  Yes   |
| escaper            | Contextual Escaping                   | `Phalcon\Escaper`                          |  Yes   |
| flash              | Flash Messaging Service               | `Phalcon\Flash\Direct`                    |  Yes   |
| flashSession       | Flash Session Messaging Service       | `Phalcon\Flash\Session`                   |  Yes   |
| filter             | Input Filtering Service               | `Phalcon\Filter`                           |  Yes   |
| modelsCache        | Cache backend for models cache        | None                                        |   No   |
| modelsManager      | Models Management Service             | `Phalcon\Mvc\Model\Manager`              |  Yes   |
| modelsMetadata     | Models Meta-Data Service              | `Phalcon\Mvc\Model\MetaData\Memory`     |  Yes   |
| request            | HTTP Request Environment Service      | `Phalcon\Http\Request`                    |  Yes   |
| response           | HTTP Response Environment Service     | `Phalcon\Http\Response`                   |  Yes   |
| router             | Routing Service                       | `Phalcon\Mvc\Router`                      |  Yes   |
| security           | Security helpers                      | `Phalcon\Security`                         |  Yes   |
| session            | Session Service                       | `Phalcon\Session\Adapter\Files`          |  Yes   |
| sessionBag         | Session Bag service                   | `Phalcon\Session\Bag`                     |  Yes   |
| tag                | HTML generation helpers               | `Phalcon\Tag`                              |  Yes   |
| transactionManager | Models Transaction Manager Service    | `Phalcon\Mvc\Model\Transaction\Manager` |  Yes   |
| url                | URL Generator Service                 | `Phalcon\Mvc\Url`                         |  Yes   |
| viewsCache         | Cache backend for views fragments     | None                                        |   No   |

<a name='implementing-your-own-di'></a>

## Implementing your own DI

The `Phalcon\DiInterface` interface must be implemented to create your own DI replacing the one provided by Phalcon or extend the current one.