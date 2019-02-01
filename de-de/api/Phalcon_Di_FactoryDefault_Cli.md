---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Di\FactoryDefault\Cli'
---
# Class **Phalcon\Di\FactoryDefault\Cli**

*extends* class [Phalcon\Di\FactoryDefault](Phalcon_Di_FactoryDefault)

*implements* [Phalcon\DiInterface](Phalcon_DiInterface), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/di/factorydefault/cli.zep)

This is a variant of the standard Phalcon\Di. By default it automatically registers all the services provided by the framework. Thanks to this, the developer does not need to register each service individually. This class is specially suitable for CLI applications

## Methoden

public **__construct** ()

Phalcon\Di\FactoryDefault\Cli constructor

public **setInternalEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di](Phalcon_Di)

Legt den internen Eventmanager fest

public **getInternalEventsManager** () inherited from [Phalcon\Di](Phalcon_Di)

Gibt den internen Eventmanager zurück

public **set** (*mixed* $name, *mixed* $definition, [*mixed* $shared]) inherited from [Phalcon\Di](Phalcon_Di)

Registriert einen Dienst im Dienste-Container

public **setShared** (*mixed* $name, *mixed* $definition) inherited from [Phalcon\Di](Phalcon_Di)

Registriert einen immer geteilten Dienst im Dienste-Container

public **remove** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Entfernt einen Dienst aus dem Dienste-Container. Entfernt auch jede gemeinsame Instanz, die für den Dienst erstellt wurde

public **attempt** (*mixed* $name, *mixed* $definition, [*mixed* $shared]) inherited from [Phalcon\Di](Phalcon_Di)

Versuche, einen Dienst im Container Dienste zu registrieren. Ist nur erfolgreich, wenn ein Dienst mit dem gleichen Namen nicht bereits registriert wurde

public **setRaw** (*mixed* $name, [Phalcon\Di\ServiceInterface](Phalcon_Di_ServiceInterface) $rawDefinition) inherited from [Phalcon\Di](Phalcon_Di)

Sets a service using a raw Phalcon\Di\Service definition

public **getRaw** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Returns a service definition without resolving

public **getService** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Returns a Phalcon\Di\Service instance

public **get** (*mixed* $name, [*mixed* $parameters]) inherited from [Phalcon\Di](Phalcon_Di)

Resolves the service based on its configuration

public *mixed* **getShared** (*string* $name, [*array* $parameters]) inherited from [Phalcon\Di](Phalcon_Di)

Resolves a service, the resolved service is stored in the DI, subsequent requests for this service will return the same instance

public **has** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Check whether the DI contains a service by a name

public **wasFreshInstance** () inherited from [Phalcon\Di](Phalcon_Di)

Check whether the last service obtained via getShared produced a fresh instance or an existing one

public **getServices** () inherited from [Phalcon\Di](Phalcon_Di)

Return the services registered in the DI

public **offsetExists** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Check if a service is registered using the array syntax

public **offsetSet** (*mixed* $name, *mixed* $definition) inherited from [Phalcon\Di](Phalcon_Di)

Allows to register a shared service using the array syntax

```php
<?php

$di["request"] = new \Phalcon\Http\Request();

```

public **offsetGet** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Allows to obtain a shared service using the array syntax

```php
<?php

var_dump($di["request"]);

```

public **offsetUnset** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Entfernt einen Dienst aus dem Dienste-Container mit der Array-syntax

public **__call** (*mixed* $method, [*mixed* $arguments]) inherited from [Phalcon\Di](Phalcon_Di)

Magic method to get or set services using setters/getters

public **register** ([Phalcon\Di\ServiceProviderInterface](Phalcon_Di_ServiceProviderInterface) $provider) inherited from [Phalcon\Di](Phalcon_Di)

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

public static **setDefault** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di](Phalcon_Di)

Set a default dependency injection container to be obtained into static methods

public static **getDefault** () inherited from [Phalcon\Di](Phalcon_Di)

Gibt den zuletzt erstellten DI zurück

public static **reset** () inherited from [Phalcon\Di](Phalcon_Di)

Setzt die interne Standard DI zurück

public **loadFromYaml** (*mixed* $filePath, [*array* $callbacks]) inherited from [Phalcon\Di](Phalcon_Di)

Lädt Dienste aus einer Yaml-Datei.

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

Und die Dienste können in der Datei angegeben werden als:

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

public **loadFromPhp** (*mixed* $filePath) inherited from [Phalcon\Di](Phalcon_Di)

Lädt Dienste aus einer Php Konfigurations-Datei.

```php
<?php

$di->loadFromPhp("path/services.php");

```

Und die Dienste können in der Datei angegeben werden als:

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

protected **loadFromConfig** ([Phalcon\Config](Phalcon_Config) $config) inherited from [Phalcon\Di](Phalcon_Di)

Lädt Dienste aus einem Config-Object.