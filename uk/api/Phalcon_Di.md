# Class **Phalcon\\Di**

*implements* [Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface), [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/di.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Phalcon\\Di is a component that implements Dependency Injection/Service Location of services and it's itself a container for them.

Since Phalcon is highly decoupled, Phalcon\\Di is essential to integrate the different components of the framework. The developer can also use this component to inject dependencies and manage global instances of the different classes used in the application.

Basically, this component implements the `Inversion of Control` pattern. Applying this, the objects do not receive their dependencies using setters or constructors, but requesting a service dependency injector. This reduces the overall complexity, since there is only one way to get the required dependencies within a component.

Additionally, this pattern increases testability in the code, thus making it less prone to errors.

```php
<?php

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

## Methods

public **__construct** ()

Phalcon\\Di constructor

public **setInternalEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.2/api/Phalcon_Events_ManagerInterface) $eventsManager)

Sets the internal event manager

public **getInternalEventsManager** ()

Returns the internal event manager

public **set** (*mixed* $name, *mixed* $definition, [*mixed* $shared])

Registers a service in the services container

public **setShared** (*mixed* $name, *mixed* $definition)

Registers an "always shared" service in the services container

public **remove** (*mixed* $name)

Removes a service in the services container It also removes any shared instance created for the service

public **attempt** (*mixed* $name, *mixed* $definition, [*mixed* $shared])

Attempts to register a service in the services container Only is successful if a service hasn't been registered previously with the same name

public **setRaw** (*mixed* $name, [Phalcon\Di\ServiceInterface](/en/3.2/api/Phalcon_Di_ServiceInterface) $rawDefinition)

Sets a service using a raw Phalcon\\Di\\Service definition

public **getRaw** (*mixed* $name)

Returns a service definition without resolving

public **getService** (*mixed* $name)

Returns a Phalcon\\Di\\Service instance

public **get** (*mixed* $name, [*mixed* $parameters])

Resolves the service based on its configuration

public *mixed* **getShared** (*string* $name, [*array* $parameters])

Resolves a service, the resolved service is stored in the DI, subsequent requests for this service will return the same instance

public **has** (*mixed* $name)

Check whether the DI contains a service by a name

public **wasFreshInstance** ()

Check whether the last service obtained via getShared produced a fresh instance or an existing one

public **getServices** ()

Return the services registered in the DI

public **offsetExists** (*mixed* $name)

Check if a service is registered using the array syntax

public **offsetSet** (*mixed* $name, *mixed* $definition)

Allows to register a shared service using the array syntax

```php
<?php

$di["request"] = new \Phalcon\Http\Request();

```

public **offsetGet** (*mixed* $name)

Allows to obtain a shared service using the array syntax

```php
<?php

var_dump($di["request"]);

```

public **offsetUnset** (*mixed* $name)

Removes a service from the services container using the array syntax

public **__call** (*mixed* $method, [*mixed* $arguments])

Magic method to get or set services using setters/getters

public **register** ([Phalcon\Di\ServiceProviderInterface](/en/3.2/api/Phalcon_Di_ServiceProviderInterface) $provider)

Registers a service provider.

```php
<?php

use Phalcon\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class SomeServiceProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di)
    {
        $di->setShared('service', function () {
            // ...
        });
    }
}

```

public static **setDefault** ([Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector)

Set a default dependency injection container to be obtained into static methods

public static **getDefault** ()

Return the latest DI created

public static **reset** ()

Resets the internal default DI

public **loadFromYaml** (*mixed* $filePath, [*array* $callbacks])

Loads services from a yaml file.

```php
<?php

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
<?php

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

public **loadFromPhp** (*mixed* $filePath)

Loads services from a php config file.

```php
<?php

$di->loadFromPhp("path/services.php");

```

And the services can be specified in the file as:

```php
<?php

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

protected **loadFromConfig** ([Phalcon\Config](/en/3.2/api/Phalcon_Config) $config)

Loads services from a Config object.