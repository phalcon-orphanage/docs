---
layout: default
language: 'en'
version: '4.0'
title: 'Phalcon\Di'
---

* [Phalcon\Di](#di)
* [Phalcon\Di\AbstractInjectionAware](#di-abstractinjectionaware)
* [Phalcon\Di\DiInterface](#di-diinterface)
* [Phalcon\Di\Exception](#di-exception)
* [Phalcon\Di\Exception\ServiceResolutionException](#di-exception-serviceresolutionexception)
* [Phalcon\Di\FactoryDefault](#di-factorydefault)
* [Phalcon\Di\FactoryDefault\Cli](#di-factorydefault-cli)
* [Phalcon\Di\Injectable](#di-injectable)
* [Phalcon\Di\InjectionAwareInterface](#di-injectionawareinterface)
* [Phalcon\Di\Service](#di-service)
* [Phalcon\Di\Service\Builder](#di-service-builder)
* [Phalcon\Di\ServiceInterface](#di-serviceinterface)
* [Phalcon\Di\ServiceProviderInterface](#di-serviceproviderinterface)

<h1 id="di">Class Phalcon\Di</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Di.zep)

| Namespace | Phalcon | | Uses | Phalcon\Di\Service, Phalcon\Di\DiInterface, Phalcon\Di\Exception, Phalcon\Di\Exception\ServiceResolutionException, Phalcon\Config\Adapter\Php, Phalcon\Config\Adapter\Yaml, Phalcon\Di\ServiceInterface, Phalcon\Events\ManagerInterface, Phalcon\Di\InjectionAwareInterface, Phalcon\Di\ServiceProviderInterface | | Implements | DiInterface |

Phalcon\Di is a component that implements Dependency Injection/Service Location of services and it's itself a container for them.

Since Phalcon is highly decoupled, Phalcon\Di is essential to integrate the different components of the framework. The developer can also use this component to inject dependencies and manage global instances of the different classes used in the application.

Basically, this component implements the `Inversion of Control` pattern. Applying this, the objects do not receive their dependencies using setters or constructors, but requesting a service dependency injector. This reduces the overall complexity, since there is only one way to get the required dependencies within a component.

Additionally, this pattern increases testability in the code, thus making it less prone to errors.

```php
use Phalcon\Di;
use Phalcon\Http\Request;

$di = new Di();

// Using a string definition
$di->set("request", Request::class, true);

// Using an anonymous function
$di->setShared(
    "request",
    function () {
        return new Request();
    }
);

$request = $di->getRequest();
```

## Properties

```php
/**
 * List of registered services
 */
protected services;

/**
 * List of shared instances
 */
protected sharedInstances;

/**
 * Events Manager
 *
 * @var ManagerInterface
 */
protected eventsManager;

/**
 * Latest DI build
 */
protected static _default;

```

## Methods

Magic method to get or set services using setters/getters

```php
public function __call( string $method, array $arguments = [] ): mixed | null;
```

Phalcon\Di constructor

```php
public function __construct();
```

Attempts to register a service in the services container Only is successful if a service hasn't been registered previously with the same name

```php
public function attempt( string $name, mixed $definition, bool $shared = bool ): ServiceInterface | bool;
```

Resolves the service based on its configuration

```php
public function get( string $name, mixed $parameters = null ): mixed;
```

Return the latest DI created

```php
public static function getDefault(): DiInterface | null;
```

Returns the internal event manager

```php
public function getInternalEventsManager(): ManagerInterface;
```

Returns a service definition without resolving

```php
public function getRaw( string $name ): mixed;
```

Returns a Phalcon\Di\Service instance

```php
public function getService( string $name ): ServiceInterface;
```

Return the services registered in the DI

```php
public function getServices(): ServiceInterface[];
```

Resolves a service, the resolved service is stored in the DI, subsequent requests for this service will return the same instance

```php
public function getShared( string $name, mixed $parameters = null ): mixed;
```

Check whether the DI contains a service by a name

```php
public function has( string $name ): bool;
```

Loads services from a php config file.

```php
$di->loadFromPhp("path/services.php");
```

And the services can be specified in the file as:

```php
return [
     'myComponent' => [
         'className' => '\Acme\Components\MyComponent',
         'shared' => true,
     ],
     'group' => [
         'className' => '\Acme\Group',
         'arguments' => [
             [
                 'type' => 'service',
                 'service' => 'myComponent',
             ],
         ],
     ],
     'user' => [
         'className' => '\Acme\User',
     ],
];
```

@link https://docs.phalcon.io/en/latest/reference/di.html

```php
public function loadFromPhp( string $filePath ): void;
```

Loads services from a yaml file.

```php
$di->loadFromYaml(
    "path/services.yaml",
    [
        "!approot" => function ($value) {
            return dirname(__DIR__) . $value;
        }
    ]
);
```

And the services can be specified in the file as:

```php
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
```

@link https://docs.phalcon.io/en/latest/reference/di.html

```php
public function loadFromYaml( string $filePath, array $callbacks = null ): void;
```

Check if a service is registered using the array syntax

```php
public function offsetExists( mixed $name ): bool;
```

Allows to obtain a shared service using the array syntax

```php
var_dump($di["request"]);
```

```php
public function offsetGet( mixed $name ): mixed;
```

Allows to register a shared service using the array syntax

```php
$di["request"] = new \Phalcon\Http\Request();
```

```php
public function offsetSet( mixed $name, mixed $definition ): void;
```

Removes a service from the services container using the array syntax

```php
public function offsetUnset( mixed $name ): void;
```

Registers a service provider.

```php
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class SomeServiceProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di)
    {
        $di->setShared(
            'service',
            function () {
                // ...
            }
        );
    }
}
```

```php
public function register( ServiceProviderInterface $provider ): void;
```

Removes a service in the services container It also removes any shared instance created for the service

```php
public function remove( string $name ): void;
```

Resets the internal default DI

```php
public static function reset(): void;
```

Registers a service in the services container

```php
public function set( string $name, mixed $definition, bool $shared = bool ): ServiceInterface;
```

Set a default dependency injection container to be obtained into static methods

```php
public static function setDefault( DiInterface $container ): void;
```

Sets the internal event manager

```php
public function setInternalEventsManager( ManagerInterface $eventsManager );
```

Sets a service using a raw Phalcon\Di\Service definition

```php
public function setService( string $name, ServiceInterface $rawDefinition ): ServiceInterface;
```

Registers an "always shared" service in the services container

```php
public function setShared( string $name, mixed $definition ): ServiceInterface;
```

Loads services from a Config object.

```php
protected function loadFromConfig( Config $config ): void;
```

<h1 id="di-abstractinjectionaware">Abstract Class Phalcon\Di\AbstractInjectionAware</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Di/AbstractInjectionAware.zep)

| Namespace | Phalcon\Di | | Implements | InjectionAwareInterface |

This abstract class offers common access to the DI in a class

## Properties

```php
/**
 * Dependency Injector
 *
 * @var DiInterface
 */
protected container;

```

## Methods

Returns the internal dependency injector

```php
public function getDI(): DiInterface;
```

Sets the dependency injector

```php
public function setDI( DiInterface $container ): void;
```

<h1 id="di-diinterface">Interface Phalcon\Di\DiInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Di/DiInterface.zep)

| Namespace | Phalcon\Di | | Uses | ArrayAccess | | Extends | ArrayAccess |

Interface for Phalcon\Di

## Methods

Attempts to register a service in the services container Only is successful if a service hasn't been registered previously with the same name

```php
public function attempt( string $name, mixed $definition, bool $shared = bool ): ServiceInterface | bool;
```

Resolves the service based on its configuration

```php
public function get( string $name, mixed $parameters = null ): mixed;
```

Return the last DI created

```php
public static function getDefault(): DiInterface | null;
```

Returns a service definition without resolving

```php
public function getRaw( string $name ): mixed;
```

Returns the corresponding Phalcon\Di\Service instance for a service

```php
public function getService( string $name ): ServiceInterface;
```

Return the services registered in the DI

```php
public function getServices(): ServiceInterface[];
```

Returns a shared service based on their configuration

```php
public function getShared( string $name, mixed $parameters = null ): mixed;
```

Check whether the DI contains a service by a name

```php
public function has( string $name ): bool;
```

Removes a service in the services container

```php
public function remove( string $name ): void;
```

Resets the internal default DI

```php
public static function reset(): void;
```

Registers a service in the services container

```php
public function set( string $name, mixed $definition, bool $shared = bool ): ServiceInterface;
```

Set a default dependency injection container to be obtained into static methods

```php
public static function setDefault( DiInterface $container ): void;
```

Sets a service using a raw Phalcon\Di\Service definition

```php
public function setService( string $name, ServiceInterface $rawDefinition ): ServiceInterface;
```

Registers an "always shared" service in the services container

```php
public function setShared( string $name, mixed $definition ): ServiceInterface;
```

<h1 id="di-exception">Class Phalcon\Di\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Di/Exception.zep)

| Namespace | Phalcon\Di | | Extends | \Phalcon\Exception |

Exceptions thrown in Phalcon\Di will use this class

<h1 id="di-exception-serviceresolutionexception">Class Phalcon\Di\Exception\ServiceResolutionException</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Di/Exception/ServiceResolutionException.zep)

| Namespace | Phalcon\Di\Exception | | Extends | \Phalcon\Di\Exception |

Phalcon\Di\Exception\ServiceResolutionException

<h1 id="di-factorydefault">Class Phalcon\Di\FactoryDefault</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Di/FactoryDefault.zep)

| Namespace | Phalcon\Di | | Uses | Phalcon\Filter\FilterFactory | | Extends | \Phalcon\Di |

This is a variant of the standard Phalcon\Di. By default it automatically registers all the services provided by the framework. Thanks to this, the developer does not need to register each service individually providing a full stack framework

## Methods

Phalcon\Di\FactoryDefault constructor

```php
public function __construct();
```

<h1 id="di-factorydefault-cli">Class Phalcon\Di\FactoryDefault\Cli</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Di/FactoryDefault/Cli.zep)

| Namespace | Phalcon\Di\FactoryDefault | | Uses | Phalcon\Di\FactoryDefault, Phalcon\Di\Service, Phalcon\Filter\FilterFactory | | Extends | FactoryDefault |

Phalcon\Di\FactoryDefault\Cli

This is a variant of the standard Phalcon\Di. By default it automatically registers all the services provided by the framework. Thanks to this, the developer does not need to register each service individually. This class is specially suitable for CLI applications

## Methods

Phalcon\Di\FactoryDefault\Cli constructor

```php
public function __construct();
```

<h1 id="di-injectable">Abstract Class Phalcon\Di\Injectable</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Di/Injectable.zep)

| Namespace | Phalcon\Di | | Uses | Phalcon\Di, Phalcon\Session\BagInterface | | Implements | InjectionAwareInterface |

This class allows to access services in the services container by just only accessing a public property with the same name of a registered service

@property \Phalcon\Mvc\Dispatcher|\Phalcon\Mvc\DispatcherInterface $dispatcher @property \Phalcon\Mvc\Router|\Phalcon\Mvc\RouterInterface $router @property \Phalcon\Url|\Phalcon\Url\UrlInterface $url @property \Phalcon\Http\Request|\Phalcon\Http\RequestInterface $request @property \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface $response @property \Phalcon\Http\Response\Cookies|\Phalcon\Http\Response\CookiesInterface $cookies @property \Phalcon\Filter $filter @property \Phalcon\Flash\Direct $flash @property \Phalcon\Flash\Session $flashSession @property \Phalcon\Session\ManagerInterface $session @property \Phalcon\Events\Manager|\Phalcon\Events\ManagerInterface $eventsManager @property \Phalcon\Db\Adapter\AdapterInterface $db @property \Phalcon\Security $security @property \Phalcon\Crypt|\Phalcon\CryptInterface $crypt @property \Phalcon\Tag $tag @property \Phalcon\Escaper|\Phalcon\Escaper\EscaperInterface $escaper @property \Phalcon\Annotations\Adapter\Memory|\Phalcon\Annotations\Adapter $annotations @property \Phalcon\Mvc\Model\Manager|\Phalcon\Mvc\Model\ManagerInterface $modelsManager @property \Phalcon\Mvc\Model\MetaData\Memory|\Phalcon\Mvc\Model\MetadataInterface $modelsMetadata @property \Phalcon\Mvc\Model\Transaction\Manager|\Phalcon\Mvc\Model\Transaction\ManagerInterface $transactionManager @property \Phalcon\Assets\Manager $assets @property \Phalcon\Di|\Phalcon\Di\DiInterface $di @property \Phalcon\Session\Bag|\Phalcon\Session\BagInterface $persistent @property \Phalcon\Mvc\View|\Phalcon\Mvc\ViewInterface $view

## Properties

```php
/**
 * Dependency Injector
 *
 * @var DiInterface
 */
protected container;

```

## Methods

Magic method __get

```php
public function __get( string $propertyName ): mixed | null;
```

Magic method __isset

```php
public function __isset( string $name ): bool;
```

Returns the internal dependency injector

```php
public function getDI(): DiInterface;
```

Sets the dependency injector

```php
public function setDI( DiInterface $container ): void;
```

<h1 id="di-injectionawareinterface">Interface Phalcon\Di\InjectionAwareInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Di/InjectionAwareInterface.zep)

| Namespace | Phalcon\Di |

This interface must be implemented in those classes that uses internally the Phalcon\Di that creates them

## Methods

Returns the internal dependency injector

```php
public function getDI(): DiInterface;
```

Sets the dependency injector

```php
public function setDI( DiInterface $container ): void;
```

<h1 id="di-service">Class Phalcon\Di\Service</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Di/Service.zep)

| Namespace | Phalcon\Di | | Uses | Closure, Phalcon\Di\Exception\ServiceResolutionException, Phalcon\Di\Service\Builder | | Implements | ServiceInterface |

Represents individually a service in the services container

```php
$service = new \Phalcon\Di\Service(
    "request",
    \Phalcon\Http\Request::class
);

$request = service->resolve();
```

## Properties

```php
//
protected definition;

/**
 * @var bool
 */
protected resolved = false;

/**
 * @var bool
 */
protected shared = false;

//
protected sharedInstance;

```

## Methods

Phalcon\Di\Service

```php
final public function __construct( mixed $definition, bool $shared = bool );
```

Returns the service definition

```php
public function getDefinition(): mixed;
```

Returns a parameter in a specific position

```php
public function getParameter( int $position );
```

Returns true if the service was resolved

```php
public function isResolved(): bool;
```

Check whether the service is shared or not

```php
public function isShared(): bool;
```

Resolves the service

```php
public function resolve( mixed $parameters = null, DiInterface $container = null ): mixed;
```

Set the service definition

```php
public function setDefinition( mixed $definition ): void;
```

Changes a parameter in the definition without resolve the service

```php
public function setParameter( int $position, array $parameter ): ServiceInterface;
```

Sets if the service is shared or not

```php
public function setShared( bool $shared ): void;
```

Sets/Resets the shared instance related to the service

```php
public function setSharedInstance( mixed $sharedInstance ): void;
```

<h1 id="di-service-builder">Class Phalcon\Di\Service\Builder</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Di/Service/Builder.zep)

| Namespace | Phalcon\Di\Service | | Uses | Phalcon\Di\DiInterface, Phalcon\Di\Exception |

Phalcon\Di\Service\Builder

This class builds instances based on complex definitions

## Methods

Builds a service using a complex service definition

```php
public function build( DiInterface $container, array $definition, mixed $parameters = null );
```

<h1 id="di-serviceinterface">Interface Phalcon\Di\ServiceInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Di/ServiceInterface.zep)

| Namespace | Phalcon\Di |

Represents a service in the services container

## Methods

Returns the service definition

```php
public function getDefinition(): mixed;
```

Returns a parameter in a specific position

```php
public function getParameter( int $position );
```

Returns true if the service was resolved

```php
public function isResolved(): bool;
```

Check whether the service is shared or not

```php
public function isShared(): bool;
```

Resolves the service

```php
public function resolve( mixed $parameters = null, DiInterface $container = null ): mixed;
```

Set the service definition

```php
public function setDefinition( mixed $definition );
```

Changes a parameter in the definition without resolve the service

```php
public function setParameter( int $position, array $parameter ): ServiceInterface;
```

Sets if the service is shared or not

```php
public function setShared( bool $shared );
```

<h1 id="di-serviceproviderinterface">Interface Phalcon\Di\ServiceProviderInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Di/ServiceProviderInterface.zep)

| Namespace | Phalcon\Di |

Should be implemented by service providers, or such components, which register a service in the service container.

```php
namespace Acme;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class SomeServiceProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di)
    {
        $di->setShared(
            'service',
            function () {
                // ...
            }
        );
    }
}
```

## Methods

Registers a service provider.

```php
public function register( DiInterface $di ): void;
```