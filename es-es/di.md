---
layout: default
language: 'es-es'
version: '4.0'
title: 'Inyección de Dependencias'
keywords: 'dependency injection, di, ioc'
---

# Dependency Injection / Service Location

* * *

![](/assets/images/document-status-under-review-red.svg)

## DI explained

The following example is a bit long, but it attempts to explain why Phalcon uses service location and dependency injection. First, let's assume we are developing a component called `SomeComponent`. This performs some task. Our component has a dependency, that is a connection to a database.

In this first example, the connection is created inside the component. Although this is a perfectly valid implementation, it is impractical, due to the fact that we cannot change the connection parameters or the type of the database system because the component only works as created.

```php
<?php

class SomeComponent
{
    /**
     * La instancia de la conexión está codificada dentro
     * del componente, por lo tanto, es difícil reemplazarla externamente
     * o cambiar su comportamiento
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
     * Configurar la conexión externamente
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

// Crear la conexión
$connection = new Connection(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'secret',
        'dbname'   => 'invo',
    ]
);

// Inyectar la conexión en el componente
$some->setConnection($connection);

$some->someDbTask();
```

Now consider that we use this component in different parts of the application and then we will need to create the connection several times before passing it to the component. Using a global registry pattern, we can store the connection object there and reuse it whenever we need it.

```php
<?php

class Registry
{
    /**
     * Retornar la conexión
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
     * Establecer la conexión externamente
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

// Pasamos la conexión definida en el registro
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
     * Crea una conexión
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
     * Crea una conexión una sola vez y la devuelve
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
     * Siempre regresa una nueva conexión
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
     * Establece una conexión externa
     *
     * @param Connection $connection
     */
    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Este método siempre regresa una conexión compartida
     */
    public function someDbTask()
    {
        $connection = $this->connection;

        // ...
    }

    /**
     * Este método siempre necesita una nueva conexión
     *
     * @param Connection $connection
     */
    public function someOtherDbTask(Connection $connection)
    {

    }
}

$some = new SomeComponent();

// Esto inyecta una conexión compartida
$some->setConnection(
    Registry::getSharedConnection()
);

$some->someDbTask();

// Siempre pasamos una nueva conexión como parámetro
$some->someOtherDbTask(
    Registry::getNewConnection()
);
```

So far we have seen how dependency injection solved our problems. Passing dependencies as arguments instead of creating them internally in the code makes our application more maintainable and decoupled. However, in the long-term, this form of dependency injection has some disadvantages.

For instance, if the component has many dependencies, we will need to create multiple setter arguments to pass the dependencies or create a constructor that pass them with many arguments, additionally creating dependencies before using the component, every time, makes our code not as maintainable as we would like:

```php
<?php

// Crear dependencias u obtenerlas del registro
$connection = new Connection();
$session    = new Session();
$fileSystem = new FileSystem();
$filter     = new Filter();
$selector   = new Selector();

// Pasarlas después como parámetros del constructor
$some = new SomeComponent($connection, $session, $fileSystem, $filter, $selector);

// ... O utilizando setters
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
     * Definir un método factory para crear instancias de SomeComponent e inyectar las dependencias
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
use Phalcon\Di\DiInterface;

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

[Phalcon\Di](api/Phalcon_Di) is a component implementing Dependency Injection and Location of services and it's itself a container for them.

Since Phalcon is highly decoupled, [Phalcon\Di](api/Phalcon_Di) is essential to integrate the different components of the framework. The developer can also use this component to inject dependencies and manage global instances of the different classes used in the application.

Basically, this component implements the [Inversion of Control](https://en.wikipedia.org/wiki/Inversion_of_control) pattern. Applying this, the objects do not receive their dependencies using setters or constructors, but requesting a service dependency injector. This reduces the overall complexity since there is only one way to get the required dependencies within a component.

Additionally, this pattern increases testability in the code, thus making it less prone to errors.

## Registering services in the Container

The framework itself or the developer can register services. When a component A requires component B (or an instance of its class) to operate, it can request component B from the container, rather than creating a new instance component B.

This way of working gives us many advantages:

* Podemos fácilmente reemplazar un componente con uno creado por nosotros mismos o por un tercero.
* Tenemos control total de la inicialización del objeto, lo que nos permite definir estos objetos según sea necesario antes de entregarlos a los componentes.
* Podemos obtener instancias globales de los componentes en forma estructurada y unificada.

Services can be registered using several types of definitions:

### Simple Registration

As seen before, there are several ways to register services. These we call simple:

#### String

This type expects the name of a valid class, returning an object of the specified class, if the class is not loaded it will be instantiated using an auto-loader. This type of definition does not allow to specify arguments for the class constructor or parameters:

```php
<?php

// Retorna new Phalcon\Http\Request();
$di->set(
    'request',
    'Phalcon\Http\Request'
);
```

#### Class instances

This type expects an object. Due to the fact that object does not need to be resolved as it is already an object, one could say that it is not really a dependency injection, however it is useful if you want to force the returned dependency to always be the same object/value:

```php
<?php

use Phalcon\Http\Request;

// Retorna new Phalcon\Http\Request();
$di->set(
    'request',
    new Request()
);
```

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

// Utilizando la variable $config en el ámbito actual
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

// Usando el servicio 'config' desde el DI
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

### Complex Registration

If it is required to change the definition of a service without instantiating/resolving the service, then, we need to define the services using the array syntax. Define a service using an array definition can be a little more verbose:

```php
<?php

use Phalcon\Logger\Adapter\File as LoggerFile;

// Register a service 'logger' with a class name and its parameters
$di->set(
    'logger',
    [
        'className' => LoggerFile::class,
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

// Cambiar el nombre de clase del servicio
$di
    ->getService('logger')
    ->setClassName('MyCustomLogger');

// Cambiar el primer parámetro sin instanciar al logger
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
        'className' => \Phalcon\Http\Response::class
    ]
);

$di->set(
    'someComponent',
    [
        'className' => \SomeApp\SomeComponent::class,
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

The service 'response' ([Phalcon\Http\Response](api/Phalcon_Http_Response)) is resolved to be passed as the first argument of the constructor, while the second is a boolean value (true) that is passed as it is.

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
        'className' => \Phalcon\Http\Response::class,
    ]
);

$di->set(
    'someComponent',
    [
        'className' => \SomeApp\SomeComponent::class,
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
        'className' => \Phalcon\Http\Response::class,
    ]
);

$di->set(
    'someComponent',
    [
        'className'  => \SomeApp\SomeComponent::class,
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

| Tipo      | Descripción                                                    | Ejemplo                                                                                     |
| --------- | -------------------------------------------------------------- | ------------------------------------------------------------------------------------------- |
| parameter | Representa un valor literal que se pasa como parámetro         | `['type' => 'parameter', 'value' => 1234]`                                            |
| service   | Representa otro servicio en el contenedor de servicio          | `['type' => 'service', 'name' => 'request']`                                          |
| instance  | Representa un objeto que debe ser construido de forma dinámica | `['type' => 'instance', 'className' => \DateTime::class, 'arguments' => ['now']]` |

Resolving a service whose definition is complex may be slightly slower than simple definitions seen previously. However, these provide a more robust approach to define and inject services.

Mixing different types of definitions is allowed, everyone can decide what is the most appropriate way to register the services according to the application needs.

### Array Syntax

The array syntax is also allowed to register services:

```php
<?php

use Phalcon\Di;
use Phalcon\Http\Request;

// Create the Dependency Injector Container
$di = new Di();

// By its class name
$di['request'] = Request::class;

// Using an anonymous function, the instance will be lazy loaded
$di['request'] = function () {
    return new Request();
};

// Registering an instance directly
$di['request'] = new Request();

// Using an array definition
$di['request'] = [
    'className' => Request::class,
];
```

In the examples above, when the framework needs to access the request data, it will ask for the service identified as 'request' in the container. The container in turn will return an instance of the required service. A developer might eventually replace a component when he/she needs.

Each of the methods (demonstrated in the examples above) used to set/register a service has advantages and disadvantages. It is up to the developer and the particular requirements that will designate which one is used.

Setting a service by a string is simple, but lacks flexibility. Setting services using an array offers a lot more flexibility, but makes the code more complicated. The lambda function is a good balance between the two, but could lead to more maintenance than one would expect.

[Phalcon\Di](api/Phalcon_Di) offers lazy loading for every service it stores. Unless the developer chooses to instantiate an object directly and store it in the container, any object stored in it (via array, string, etc.) will be lazy loaded i.e. instantiated only when requested.

### Cargando servicios desde archivos YAML

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
$di->get('config'); // Se obtendrá el servicio config
```

> This approach requires that the module Yaml be installed. Please refer to [this](https://php.net/manual/book.yaml.php) for more information.
{: .alert .alert-danger }

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
    \MyComponent::class,
    [
        'some-parameter',
        'other',
    ]
);
```

### Eventos

[Phalcon\Di](api/Phalcon_Di) is able to send events to an [EventsManager](events) if it is present. Events are triggered using the type 'di'. Algunos eventos cuando se devuelva `false` podrían detener la operación activa. Son soportados los siguientes eventos:

| Nombre de evento       | Disparado                                                                                                       | ¿Detiene la operación? | Activa en |
| ---------------------- | --------------------------------------------------------------------------------------------------------------- |:----------------------:|:---------:|
| `afterServiceResolve`  | Triggered after resolve service. Listeners receive the service name, instance, and the parameters passed to it. |           No           |  Oyentes  |
| `beforeServiceResolve` | Triggered before resolve service. Listeners receive the service name and the parameters passed to it.           |           No           |  Oyentes  |

## Shared services

Services can be registered as 'shared' services this means that they always will act as \[singletons\]\[singletons\]. Once the service is resolved for the first time the same instance of it is returned every time a consumer retrieve the service from the container:

```php
<?php

use Phalcon\Session\Adapter\Files as SessionFiles;

// Registrar el servicio de sesión como 'siempre compartido'
$di->setShared(
    'session',
    function () {
        $session = new SessionFiles();

        $session->start();

        return $session;
    }
);

// Obtenemos el servicio por primera vez
$session = $di->get('session');

// Retorna el primer objecto instanciado
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

## Manipulating services individually

Once a service is registered in the service container, you can retrieve it to manipulate it individually:

```php
    <?php

    use Phalcon\Http\Request;

    // Registrar el servicio 'request'
    $di->set('request', 'Phalcon\Http\Request');

    // Obtener el servicio
    $requestService = $di->getService('request');

    // Cambiar la definición
    $requestService->setDefinition(
        function () {
            return new Request();
        }
    );

    // Compartir el servicio
    $requestService->setShared(true);

    // Resolver el servicio(retorna una instancia de Phalcon\Http\Request)
    $request = $requestService->resolve();
```

## Instantiating classes via the Service Container

When you request a service to the service container, if it can't find out a service with the same name it'll try to load a class with the same name. With this behavior we can replace any class by another simply by registering a service with its name:

```php
<?php

// Registrar un controlador como un servicio
$di->set(
    'IndexController',
    function () {
        $component = new Component();

        return $component;
    },
    true
);

// Registrar un controlador como un servicio
$di->set(
    'MyOtherComponent',
    function () {
        // Actualmente retorna otro componente
        $component = new AnotherComponent();

        return $component;
    }
);

// Crear una instancia a través del contenedor de servicios
$myComponent = $di->get('MyOtherComponent');
```

You can take advantage of this, always instantiating your classes via the service container (even if they aren't registered as services). The DI will fallback to a valid autoloader to finally load the class. By doing this, you can easily replace any class in the future by implementing a definition for it.

## Automatic Injecting of the DI itself

If a class or component requires the DI itself to locate services, the DI can automatically inject itself to the instances it creates, to do this, you need to implement the [Phalcon\Di\InjectionAwareInterface](api/Phalcon_Di_InjectionAwareInterface) in your classes:

```php
<?php

use Phalcon\Di\DiInterface;
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

    public function getDi(): DiInterface
    {
        return $this->di;
    }
}
```

Then once the service is resolved, the `$di` will be passed to `setDi()` automatically:

```php
<?php

// Registrar el servicio
$di->set('myClass', 'MyClass');

// Resolver el servicio (NOTA: $myClass->setDi($di) es llamado automáticamente)
$myClass = $di->get('myClass');
```

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

## Accessing the DI in a static way

If needed you can access the latest DI created in a static function in the following way:

```php
<?php

use Phalcon\Di;

class SomeComponent
{
    public static function someMethod()
    {
        // Obtener el servicio de sesión
        $session = Di::getDefault()->getSession();
    }
}
```

## Proveedores de Servicio

Using the `ServiceProviderInterface` you now register services by context. You can move all your `$di->set()` calls to classes like this:

```php
<?php

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Di\DiInterface;
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

## Factory Default DI

Although the decoupled character of Phalcon offers us great freedom and flexibility, maybe we just simply want to use it as a full-stack framework. To achieve this, the framework provides a variant of [Phalcon\Di](api/Phalcon_Di) called [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault). This class automatically registers the appropriate services bundled with the framework to act as full-stack.

```php
<?php

use Phalcon\Di\FactoryDefault;

$di = new FactoryDefault();
```

## Service Name Conventions

Although you can register services with the names you want, Phalcon has a several naming conventions that allow it to get the the correct (built-in) service when you need it.

| Nombre del servicio | Descripción                                           | Predeterminado                                                                         | Compartido |
| ------------------- | ----------------------------------------------------- | -------------------------------------------------------------------------------------- |:----------:|
| assets              | Gestión de Activos (Assets)                           | [Phalcon\Assets\Manager](api/Phalcon_Assets_Manager)                                 |     Si     |
| annotations         | Analizador de anotaciones                             | [Phalcon\Annotations\Adapter\Memory](api/Phalcon_Annotations_Adapter_Memory)        |     Si     |
| cookies             | Servicio de gestión de Cookies HTTP                   | [Phalcon\Http\Response\Cookies](api/Phalcon_Http_Response_Cookies)                  |     Si     |
| crypt               | Encriptar/Desencriptar datos                          | [Phalcon\Crypt](api/Phalcon_Crypt)                                                    |     Si     |
| db                  | Servicio de conexión de base de datos de bajo nivel   | [Phalcon\Db](api/Phalcon_Db)                                                          |     Si     |
| dispatcher          | Servicio de despacho de controladores                 | [Phalcon\Mvc\Dispatcher](api/Phalcon_Mvc_Dispatcher)                                 |     Si     |
| eventsManager       | Servicio de gestión de eventos                        | [Phalcon\Events\Manager](api/Phalcon_Events_Manager)                                 |     Si     |
| escaper             | Contextual Escaping                                   | [Phalcon\Escaper](api/Phalcon_Escaper)                                                |     Si     |
| flash               | Servicio de mensajería Flash                          | [Phalcon\Flash\Direct](api/Phalcon_Flash_Direct)                                     |     Si     |
| flashSession        | Servicio de mensajería Flash en sesión                | [Phalcon\Flash\Session](api/Phalcon_Flash_Session)                                   |     Si     |
| filter              | Servicio de filtrado de entrada                       | [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator)                     |     Si     |
| modelsCache         | Cache de modelos para cacheos en Backend              | Nada                                                                                   |     No     |
| modelsManager       | Servicio de gestión de modelos                        | [Phalcon\Mvc\Model\Manager](api/Phalcon_Mvc_Model_Manager)                          |     Si     |
| modelsMetadata      | Servicio de metadatos de modelos                      | [Phalcon\Mvc\Model\MetaData\Memory](api/Phalcon_Mvc_Model_MetaData_Memory)         |     Si     |
| request             | Servicio de entorno de solicitud HTTP                 | [Phalcon\Http\Request](api/Phalcon_Http_Request)                                     |     Si     |
| response            | Servicio de entorno de respuesta HTTP                 | [Phalcon\Http\Response](api/Phalcon_Http_Response)                                   |     Si     |
| router              | Servicio de enrutamiento                              | [Phalcon\Mvc\Router](api/Phalcon_Mvc_Router)                                         |     Si     |
| security            | Ayudantes de seguridad                                | [Phalcon\Security](api/Phalcon_Security)                                              |     Si     |
| session             | Servicio de sesión                                    | [Phalcon\Session\Adapter\Files](api/Phalcon_Session_Adapter_Files)                  |     Si     |
| sessionBag          | Servicio de bolsa de sesión                           | [Phalcon\Session\Bag](api/Phalcon_Session_Bag)                                       |     Si     |
| tag                 | Ayudantes de generación de HTML                       | [Phalcon\Tag](api/Phalcon_Tag)                                                        |     Si     |
| transactionManager  | Servicio de administrador de transacciones de modelos | [Phalcon\Mvc\Model\Transaction\Manager](api/Phalcon_Mvc_Model_Transaction_Manager) |     Si     |
| url                 | Servicio de generador de URL                          | [Phalcon\Url](api/Phalcon_Url)                                                        |     Si     |
| viewCache           | Backend de cache para cache de fragmentos de vista    | Nada                                                                                   |     No     |

## Implementing your own DI

The [Phalcon\Di\DiInterface](api/Phalcon_DiInterface) interface must be implemented to create your own DI replacing the one provided by Phalcon or extend the current one.