* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Application'

* * *

# Abstract class **Phalcon\Application**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/application.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Base class for Phalcon\Cli\Console and Phalcon\Mvc\Application.

## Methods

public **__construct** ([[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector])

Phalcon\Application Constructor

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Sets the events manager

public **getEventsManager** ()

Returns the internal event manager

public **registerModules** (*array* $modules, [*mixed* $merge])

Register an array of modules present in the application

```php
<?php

$this->registerModules(
    [
        "frontend" => [
            "className" => "Multiple\Frontend\Module",
            "path"      => "../apps/frontend/Module.php",
        ],
        "backend" => [
            "className" => "Multiple\Backend\Module",
            "path"      => "../apps/backend/Module.php",
        ],
    ]
);

```

public **getModules** ()

Return the modules registered in the application

public **getModule** (*mixed* $name)

Gets the module definition registered in the application via module name

public **setDefaultModule** (*mixed* $defaultModule)

Sets the module name to be used if the router doesn't return a valid module

public **getDefaultModule** ()

Returns the default module name

abstract public **handle** ()

Handles a request

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Sets the dependency injector

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Returns the internal dependency injector

public **__get** (*string* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Magic method __get