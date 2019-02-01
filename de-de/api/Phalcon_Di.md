---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Di'
---
# Class **Phalcon\Di**

*implements* [Phalcon\DiInterface](Phalcon_DiInterface), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/di.zep)

Phalcon\Di is a component that implements Dependency Injection/Service Location of services and it's itself a container for them.

Since Phalcon is highly decoupled, Phalcon\Di is essential to integrate the different components of the framework. The developer can also use this component to inject dependencies and manage global instances of the different classes used in the application.

Basically, this component implements the `Inversion of Control` pattern. Applying this, the objects do not receive their dependencies using setters or constructors, but requesting a service dependency injector. This reduces the overall complexity, since there is only one way to get the required dependencies within a component.

Darüber hinaus erhöht dieses Muster Testbarkeit im Code, so dass es weniger anfällig wird für Fehler.

```php
<?php

use Phalcon\Di;
use Phalcon\Http\Request;

$di = new Di();

// Eine Zeichenketten definition benutzen
$di->set("request", Request::class, true);

// Eine anonyme Funktion nutzen
$di->setShared(
    "request",
    function () {
        return new Request();
    }
);

$request = $di->getRequest();

```

## Methoden

public **__construct** ()

Phalcon\Di constructor

public **setInternalEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Legt den internen Eventmanager fest

public **getInternalEventsManager** ()

Gibt den internen Eventmanager zurück

public **set** (*mixed* $name, *mixed* $definition, [*mixed* $shared])

Registriert einen Dienst im Dienste-Container

public **setShared** (*mixed* $name, *mixed* $definition)

Registriert einen immer geteilten Dienst im Dienste-Container

public **remove** (*mixed* $name)

Entfernt einen Dienst aus dem Dienste-Container. Entfernt auch jede gemeinsame Instanz, die für den Dienst erstellt wurde

public **attempt** (*mixed* $name, *mixed* $definition, [*mixed* $shared])

Versuche, einen Dienst im Container Dienste zu registrieren. Ist nur erfolgreich, wenn ein Dienst mit dem gleichen Namen nicht bereits registriert wurde

public **setRaw** (*mixed* $name, [Phalcon\Di\ServiceInterface](Phalcon_Di_ServiceInterface) $rawDefinition)

Sets a service using a raw Phalcon\Di\Service definition

public **getRaw** (*mixed* $name)

Returns a service definition without resolving

public **getService** (*mixed* $name)

Returns a Phalcon\Di\Service instance

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

Entfernt einen Dienst aus dem Dienste-Container mit der Array-syntax

public **__call** (*mixed* $method, [*mixed* $arguments])

Magic method to get or set services using setters/getters

public **register** ([Phalcon\Di\ServiceProviderInterface](Phalcon_Di_ServiceProviderInterface) $provider)

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

public static **setDefault** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Set a default dependency injection container to be obtained into static methods

public static **getDefault** ()

Gibt den zuletzt erstellten DI zurück

public static **reset** ()

Setzt die interne Standard DI zurück

public **loadFromYaml** (*mixed* $filePath, [*array* $callbacks])

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

public **loadFromPhp** (*mixed* $filePath)

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

protected **loadFromConfig** ([Phalcon\Config](Phalcon_Config) $config)

Lädt Dienste aus einem Config-Object.