# Clase Abstracta **Phalcon\\Application**

*extends* abstract class [Phalcon\Di\Injectable](/en/3.1.2/api/Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](/en/3.1.2/api/Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](/en/3.1.2/api/Phalcon_Di_InjectionAwareInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/application.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Clase base para Phalcon\\Cli\\Console y Phalcon\\Mvc\\Application.

## Métodos

public **__construct** ([[Phalcon\DiInterface](/en/3.1.2/api/Phalcon_DiInterface) $dependencyInjector])

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.1.2/api/Phalcon_Events_ManagerInterface) $eventsManager)

Establece el gestor de eventos

public **getEventsManager** ()

Devuelve el gestor de eventos interno

public **registerModules** (*array* $modules, [*mixed* $merge])

Registra un arreglo de módulos presentes en la aplicación

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

public **getModules** ()

Devuelve los módulos registrados en la aplicación

public **getModule** (*mixed* $name)

Obtiene la definición de módulo registrada en la aplicación a través de nombre del módulo

public **setDefaultModule** (*mixed* $defaultModule)

Establece el nombre del módulo que se utilizará si el router no vuelve un módulo válido

public **getDefaultModule** ()

Devuelve el nombre del módulo predeterminado

abstract public **handle** ()

Maneja una solucitud

public **setDI** ([Phalcon\DiInterface](/en/3.1.2/api/Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](/en/3.1.2/api/Phalcon_Di_Injectable)

Establece el inyector de dependencias

public **getDI** () inherited from [Phalcon\Di\Injectable](/en/3.1.2/api/Phalcon_Di_Injectable)

Devuelve el inyector de dependencias interno

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](/en/3.1.2/api/Phalcon_Di_Injectable)

Método mágico __get