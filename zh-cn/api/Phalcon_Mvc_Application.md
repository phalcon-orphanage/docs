* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Mvc\Application'

* * *

# Class **Phalcon\Mvc\Application**

*extends* abstract class [Phalcon\Application](Phalcon_Application)

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/application.zep" class="btn btn-default btn-sm">源码在GitHub</a>

This component encapsulates all the complex operations behind instantiating every component needed and integrating it with the rest to allow the MVC pattern to operate as desired.

```php
<?php

use Phalcon\Mvc\Application;

class MyApp extends Application
{
    /**
     * Register the services here to make them general or register
     * in the ModuleDefinition to make them module-specific
     */
    protected function registerServices()
    {

    }

    /**
     * This method registers all the modules in the application
     */
    public function main()
    {
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
    }
}

$application = new MyApp();

$application->main();

```

## 方法

public **useImplicitView** (*mixed* $implicitView)

By default. The view is implicitly buffering all the output You can full disable the view component using this method

public **handle** ([*mixed* $uri])

Handles a MVC request

public **__construct** ([[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector]) inherited from [Phalcon\Application](Phalcon_Application)

Phalcon\Application

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Application](Phalcon_Application)

设置事件管理器

public **getEventsManager** () inherited from [Phalcon\Application](Phalcon_Application)

返回内部事件管理器

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