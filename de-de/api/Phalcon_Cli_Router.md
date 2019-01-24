---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Cli\Router'
---
# Class **Phalcon\Cli\Router**

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/router.zep)

Phalcon\Cli\Router is the standard framework router. Routing ist der Prozess, welcher die Kommandozeilen-Argumente in Parameter zerlegt, um zu bestimmen, welches Modul, Aufgabe oder Aktion dieser Aufgabe die Anfrage erhalten soll

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

## Methoden

public **__construct** ([*mixed* $defaultRoutes])

Phalcon\Cli\Router constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Sets the dependency injector

public **getDI** ()

Returns the internal dependency injector

public **setDefaultModule** (*mixed* $moduleName)

Legt den Namen des Standardmoduls fest

public **setDefaultTask** (*mixed* $taskName)

Legt den Standardnamen des controllers fest

public **setDefaultAction** (*mixed* $actionName)

Legt den Standard Aktions Name fest

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

Behandelt die routing-Informationen, die von Befehlszeilenargumenten übergeben wurde

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **add** (*string* $pattern, [*string/array* $paths])

Fügt eine Route zum Router hinzu

```php
<?php

$router->add("/about", "About::main");

```

public **getModuleName** ()

Gibt den verarbeiteten Modul Namen zurück

public **getTaskName** ()

Gibt den verarbeiteten Aufgaben Namen zurück

public **getActionName** ()

Gibt den verarbeiteten Aktion Namen zurück

public *array* **getParams** ()

Gibt die verarbeiteten zusätzliche Parameter zurück

public **getMatchedRoute** ()

Gibt die Route zurück, welche auf die verarbeitete URI passt

public *array* **getMatches** ()

Gibt die Sub-Ausdrücke in einem passenden regulären Ausdruck zurück

public **wasMatched** ()

Überprüft, ob der Router mit einem definierten routen übereinstimmt

public **getRoutes** ()

Gibt alle im router definierten Routen zurück

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **getRouteById** (*int* $id)

Gibt ein Routenobjekt anhand der id zurück

public **getRouteByName** (*mixed* $name)

Gibt ein Routenobjekt anhand des Namens zurück