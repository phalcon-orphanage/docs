# Class **Phalcon\\Cli\\Console**

*extends* abstract class [Phalcon\Application](/en/3.1.2/api/Phalcon_Application)

*implements* [Phalcon\Di\InjectionAwareInterface](/en/3.1.2/api/Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](/en/3.1.2/api/Phalcon_Events_EventsAwareInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cli/console.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This component allows to create CLI applications using Phalcon

## Methods
public  **addModules** (*array* $modules)

Merge modules with the existing ones

```php
<?php

$application->addModules(
    [
        "admin" => [
            "className" => "Multiple\\Admin\\Module",
            "path"      => "../apps/admin/Module.php",
        ],
    ]
);

```

public  **handle** ([*array* $arguments])

Handle the whole command-line tasks

public  **setArgument** ([*array* $arguments], [*mixed* $str], [*mixed* $shift])

Set an specific argument

public  **__construct** ([[Phalcon\DiInterface](/en/3.1.2/api/Phalcon_DiInterface) $dependencyInjector]) inherited from [Phalcon\Application](/en/3.1.2/api/Phalcon_Application)

Phalcon\\Application

public  **setEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.1.2/api/Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Application](/en/3.1.2/api/Phalcon_Application)

Sets the events manager

public  **getEventsManager** () inherited from [Phalcon\Application](/en/3.1.2/api/Phalcon_Application)

Returns the internal event manager

public  **registerModules** (*array* $modules, [*mixed* $merge]) inherited from [Phalcon\Application](/en/3.1.2/api/Phalcon_Application)

Register an array of modules present in the application

```php
<?php

$this->registerModules(
    [
        "frontend" => [
            "className" => "Multiple\\Frontend\\Module",
            "path"      => "../apps/frontend/Module.php",
        ],
        "backend" => [
            "className" => "Multiple\\Backend\\Module",
            "path"      => "../apps/backend/Module.php",
        ],
    ]
);

```

public  **getModules** () inherited from [Phalcon\Application](/en/3.1.2/api/Phalcon_Application)

Return the modules registered in the application

public  **getModule** (*mixed* $name) inherited from [Phalcon\Application](/en/3.1.2/api/Phalcon_Application)

Gets the module definition registered in the application via module name

public  **setDefaultModule** (*mixed* $defaultModule) inherited from [Phalcon\Application](/en/3.1.2/api/Phalcon_Application)

Sets the module name to be used if the router doesn't return a valid module

public  **getDefaultModule** () inherited from [Phalcon\Application](/en/3.1.2/api/Phalcon_Application)

Returns the default module name

public  **setDI** ([Phalcon\DiInterface](/en/3.1.2/api/Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](/en/3.1.2/api/Phalcon_Di_Injectable)

Sets the dependency injector

public  **getDI** () inherited from [Phalcon\Di\Injectable](/en/3.1.2/api/Phalcon_Di_Injectable)

Returns the internal dependency injector

public  **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](/en/3.1.2/api/Phalcon_Di_Injectable)

Magic method __get

