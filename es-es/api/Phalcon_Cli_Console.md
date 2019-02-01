---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Cli\Console'
---
# Class **Phalcon\Cli\Console**

*extends* abstract class [Phalcon\Application](Phalcon_Application)

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/console.zep)

Este componente permite crear aplicaciones CLI usando Phalcon

## Métodos

public **addModules** (*array* $modules)

Fusiona módulos con los ya existente

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

Maneja todas las tareas de línea de comando

public **setArgument** ([*array* $arguments], [*mixed* $str], [*mixed* $shift])

Establece un argumento en específico

public **__construct** ([[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector]) inherited from [Phalcon\Application](Phalcon_Application)

Phalcon\Application

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Application](Phalcon_Application)

Establece el administrador de eventos

public **getEventsManager** () inherited from [Phalcon\Application](Phalcon_Application)

Devuelve el administrador de eventos interno

public **registerModules** (*array* $modules, [*mixed* $merge]) inherited from [Phalcon\Application](Phalcon_Application)

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

public **getModules** () inherited from [Phalcon\Application](Phalcon_Application)

Devuelve los módulos registrados en la aplicación

public **getModule** (*mixed* $name) inherited from [Phalcon\Application](Phalcon_Application)

Obtiene la definición de módulo registrada en la aplicación vía nombre del módulo

public **setDefaultModule** (*mixed* $defaultModule) inherited from [Phalcon\Application](Phalcon_Application)

Configura el nombre del módulo para ser usado si el router no devuelve un módulo válido

public **getDefaultModule** () inherited from [Phalcon\Application](Phalcon_Application)

Devuelve el nombre de módulo por defecto

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Configura el inyector de dependencia

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Devuelve el inyector de dependencias interno

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Magic method __get