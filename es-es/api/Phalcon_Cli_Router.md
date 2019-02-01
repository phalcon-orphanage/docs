---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Cli\Router'
---
# Class **Phalcon\Cli\Router**

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/router.zep)

Phalcon\Cli\Router is the standard framework router. Enrutamiento es el proceso de tomar una línea de comandos y argumentos descomponiéndolo en parámetros para determinar qué módulo, tarea y la acción de esa tarea debe recibir la solicitud

```php
<?php

$router = new \Phalcon\Cli\Router();

$router->handle(
    [
        "module" => "main",
        "task"   => "videos",
        "action" => "process",
    ]
);

echo $router->getTaskName();

```

## Métodos

public **__construct** ([*mixed* $defaultRoutes])

Phalcon\Cli\Router constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Configura el inyector de dependencia

public **getDI** ()

Devuelve el inyector de dependencias interno

public **setDefaultModule** (*mixed* $moduleName)

Establece el nombre del módulo predeterminado

public **setDefaultTask** (*mixed* $taskName)

Establece el nombre predeterminado del controlador

public **setDefaultAction** (*mixed* $actionName)

Establece el nombre de acción predeterminado

public **setDefaults** (*array* $defaults)

Sets an array of default paths. If a route is missing a path the router will use the defined here This method must not be used to set a 404 route

```php
<?php

$router->setDefaults(
    [
        "module" => "common",
        "action" => "index",
    ]
);

```

public **handle** ([*array* $arguments])

Maneja la información de enrutamiento recibida de los argumentos de la línea de comando

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **add** (*string* $pattern, [*string/array* $paths])

Adiciona una ruta al enrutador

```php
<?php

$router->add("/about", "About::main");

```

public **getModuleName** ()

Devuelve el nombre del módulo procesado

public **getTaskName** ()

Devuelve el nombre de tarea procesada

public **getActionName** ()

Devuelve el nombre de la acción procesada

public *array* **getParams** ()

Devuelve los parámetros extra procesados

public **getMatchedRoute** ()

Devuelve la ruta que coincide con el URI manejado

public *array* **getMatches** ()

Devuelve las sub expresiones en la expresión regular combinada

public **wasMatched** ()

Comprueba si el enrutador coincide con alguna de las rutas definidas

public **getRoutes** ()

Devuelve todas las rutas definidas en el enrutador

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **getRouteById** (*int* $id)

Devuelve un objeto de ruta por su identidad

public **getRouteByName** (*mixed* $name)

Devuelve un objeto de ruta por su nombre