---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Application'
---
# Abstract class **Phalcon\Application**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/application.zep)

Base class for Phalcon\Cli\Console and Phalcon\Mvc\Application.

## Methoden

public **__construct** ([[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector])

Phalcon\Application Constructor

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Legt den Event-manager fest

public **getEventsManager** ()

Gibt den internen Eventmanager zurück

public **registerModules** (*array* $modules, [*mixed* $merge])

Registrieren Sie ein Array von Modulen, welche in der Anwendung vorhanden sind

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

Liefert die Module, welche in der Anwendung registriert sind

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

Magische Methode __get