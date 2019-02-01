---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Mvc\Router\Group'
---
# Class **Phalcon\Mvc\Router\Group**

*implements* [Phalcon\Mvc\Router\GroupInterface](Phalcon_Mvc_Router_GroupInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/router/group.zep)

Helper-Klasse zum Erstellen einer Gruppe von Routen mit gemeinsamen Merkmalen

```php
<?php

$router = new \Phalcon\Mvc\Router();

//Erstellt eine Gruppe mit gemeinsamen Modul und Controller
$blog = new Group(
    [
        "module"     => "blog",
        "controller" => "index",
    ]
);

//Alle Routen starten mit /blog
$blog->setPrefix("/blog");

//Eine Route zur Gruppe hinzufügen
$blog->add(
    "/save",
    [
        "action" => "save",
    ]
);

//Eine weitere Route der Gruppe hinzufügen
$blog->add(
    "/edit/{id}",
    [
        "action" => "edit",
    ]
);

//Diese Route führt zu einem anderen Controller als dem Standard
$blog->add(
    "/blog",
    [
        "controller" => "about",
        "action"     => "index",
    ]
);

//Die Gruppe dem Router hinzufügen
$router->mount($blog);

```

## Methoden

public **__construct** ([*mixed* $paths])

Phalcon\Mvc\Router\Group constructor

public **setHostname** (*mixed* $hostname)

Stellen Sie eine Hostnamen Einschränkung für alle Routen im

public **getHostname** ()

Gibt die Hostname-Beschränkung zurück

public **setPrefix** (*mixed* $prefix)

Legt einen gemeinsamen uri Präfix für alle Routen in der Gruppe fest

public **getPrefix** ()

Gibt das gemeinsame Präfix für alle Routen zurück

public **beforeMatch** (*mixed* $beforeMatch)

Sets a callback that is called if the route is matched. The developer can implement any arbitrary conditions here If the callback returns false the route is treated as not matched

public **getBeforeMatch** ()

Liefert den "before match" Callback, falls vorhanden

public **setPaths** (*mixed* $paths)

Legt einen gemeinsamen Pfad für alle Routen in der Gruppe fest

public **getPaths** ()

Gibt die gemeinsamen Pfade für diese Gruppe zurück

public **getRoutes** ()

Gibt die für diese Gruppe festgelegten routen zurück

public **add** (*mixed* $pattern, [*mixed* $paths], [*mixed* $httpMethods])

Fügt eine Route dem Router hinzu, welche auf jede HTTP Methode gültig ist

```php
<?php

$router->add("/about", "About::index");

```

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addGet** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is GET

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addPost** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is POST

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addPut** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is PUT

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addPatch** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is PATCH

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addDelete** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is DELETE

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addOptions** (*string* $pattern, [*string/array* $paths])

Add a route to the router that only match if the HTTP method is OPTIONS

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addHead** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is HEAD

public **clear** ()

Removes all the pre-defined routes

protected **_addRoute** (*mixed* $pattern, [*mixed* $paths], [*mixed* $httpMethods])

Fügt eine Route hinzu, welche die gemeinsame Attribute nutzt