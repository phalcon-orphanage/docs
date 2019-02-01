---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Application'
---
# Abstract class **Phalcon\Application**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/application.zep)

Base class for Phalcon\Cli\Console and Phalcon\Mvc\Application.

## Métodos

public **__construct** ([[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector])

Phalcon\Application Constructor

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Establece el administrador de eventos

public **getEventsManager** ()

Devuelve el administrador de eventos interno

public **registerModules** (*array* $modules, [*mixed* $merge])

Registra un arreglo de módulos presentes en la aplicación

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

Devuelve los módulos registrados en la aplicación

public **getModule** (*mixed* $name)

Obtiene la definición de módulo registrada en la aplicación vía nombre del módulo

public **setDefaultModule** (*mixed* $defaultModule)

Configura el nombre del módulo para ser usado si el router no devuelve un módulo válido

public **getDefaultModule** ()

Devuelve el nombre de módulo por defecto

abstract public **handle** ()

Maneja una solucitud

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Configura el inyector de dependencia

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Devuelve el inyector de dependencias interno

public **__get** (*string* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Magic method __get