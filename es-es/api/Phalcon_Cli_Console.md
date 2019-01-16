* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Cli\Console'

* * *

# Class **Phalcon\Cli\Console**

*extends* abstract class [Phalcon\Application](Phalcon_Application)

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/cli/console.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

This component allows to create CLI applications using Phalcon

## Métodos

public **addModules** (*array* $modules)

Merge modules with the existing ones

```php
<?php

$application->addModules(
    [
        "admin" => [
            "className" => "Multiple\Admin\Module",
            "path"      => "../apps/admin/Module.php",
        ],
    ]
);

```

public **handle** ([*array* $arguments])

Handle the whole command-line tasks

public **setArgument** ([*array* $arguments], [*mixed* $str], [*mixed* $shift])

Set an specific argument

public **__construct** ([[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector]) inherited from [Phalcon\Application](Phalcon_Application)

Phalcon\Application

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Application](Phalcon_Application)

Establece el administrador de eventos

public **getEventsManager** () inherited from [Phalcon\Application](Phalcon_Application)

Devuelve el administrador de eventos interno

public **registerModules** (*array* $modules, [*mixed* $merge]) inherited from [Phalcon\Application](Phalcon_Application)

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

public **getModules** () inherited from [Phalcon\Application](Phalcon_Application)

Return the modules registered in the application

public **getModule** (*mixed* $name) inherited from [Phalcon\Application](Phalcon_Application)

Gets the module definition registered in the application via module name

public **setDefaultModule** (*mixed* $defaultModule) inherited from [Phalcon\Application](Phalcon_Application)

Sets the module name to be used if the router doesn't return a valid module

public **getDefaultModule** () inherited from [Phalcon\Application](Phalcon_Application)

Returns the default module name

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Sets the dependency injector

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Returns the internal dependency injector

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Magic method __get