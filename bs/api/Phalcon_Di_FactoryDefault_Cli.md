# Class **Phalcon\\Di\\FactoryDefault\\Cli**

*extends* class [Phalcon\Di\FactoryDefault](/en/3.2/api/Phalcon_Di_FactoryDefault)

*implements* [Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface), [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/di/factorydefault/cli.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This is a variant of the standard Phalcon\\Di. By default it automatically registers all the services provided by the framework. Thanks to this, the developer does not need to register each service individually. This class is specially suitable for CLI applications

## Methods

public **__construct** ()

Phalcon\\Di\\FactoryDefault\\Cli constructor

public **setInternalEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.2/api/Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Sets the internal event manager

public **getInternalEventsManager** () inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Returns the internal event manager

public **set** (*mixed* $name, *mixed* $definition, [*mixed* $shared]) inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Registers a service in the services container

public **setShared** (*mixed* $name, *mixed* $definition) inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Registers an "always shared" service in the services container

public **remove** (*mixed* $name) inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Removes a service in the services container It also removes any shared instance created for the service

public **attempt** (*mixed* $name, *mixed* $definition, [*mixed* $shared]) inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Attempts to register a service in the services container Only is successful if a service hasn't been registered previously with the same name

public **setRaw** (*mixed* $name, [Phalcon\Di\ServiceInterface](/en/3.2/api/Phalcon_Di_ServiceInterface) $rawDefinition) inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Sets a service using a raw Phalcon\\Di\\Service definition

public **getRaw** (*mixed* $name) inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Returns a service definition without resolving

public **getService** (*mixed* $name) inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Returns a Phalcon\\Di\\Service instance

public **get** (*mixed* $name, [*mixed* $parameters]) inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Resolves the service based on its configuration

public *mixed* **getShared** (*string* $name, [*array* $parameters]) inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Resolves a service, the resolved service is stored in the DI, subsequent requests for this service will return the same instance

public **has** (*mixed* $name) inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Check whether the DI contains a service by a name

public **wasFreshInstance** () inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Check whether the last service obtained via getShared produced a fresh instance or an existing one

public **getServices** () inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Return the services registered in the DI

public **offsetExists** (*mixed* $name) inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Check if a service is registered using the array syntax

public **offsetSet** (*mixed* $name, *mixed* $definition) inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Allows to register a shared service using the array syntax

```php
<?php

$di["request"] = new \Phalcon\Http\Request();

```

public **offsetGet** (*mixed* $name) inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Allows to obtain a shared service using the array syntax

```php
<?php

var_dump($di["request"]);

```

public **offsetUnset** (*mixed* $name) inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Removes a service from the services container using the array syntax

public **__call** (*mixed* $method, [*mixed* $arguments]) inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Magic method to get or set services using setters/getters

public **register** ([Phalcon\Di\ServiceProviderInterface](/en/3.2/api/Phalcon_Di_ServiceProviderInterface) $provider) inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

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

public static **setDefault** ([Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Set a default dependency injection container to be obtained into static methods

public static **getDefault** () inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Return the latest DI created

public static **reset** () inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Resets the internal default DI

public **loadFromYaml** (*mixed* $filePath, [*array* $callbacks]) inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

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

public **loadFromPhp** (*mixed* $filePath) inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

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

protected **loadFromConfig** ([Phalcon\Config](/en/3.2/api/Phalcon_Config) $config) inherited from [Phalcon\Di](/en/3.2/api/Phalcon_Di)

Loads services from a Config object.