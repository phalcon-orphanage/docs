---
layout: article
language: 'fr-fr'
version: '4.0'
title: 'Phalcon\Mvc\Router\Route'
---
# Class **Phalcon\Mvc\Router\Route**

*implements* [Phalcon\Mvc\Router\RouteInterface](Phalcon_Mvc_Router_RouteInterface)

[Source sur GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/router/route.zep)

Cette classe représente chaque route a ajouté le routeur

## Méthodes

public **__construct** (*mixed* $pattern, [*mixed* $paths], [*mixed* $httpMethods])

Phalcon\Mvc\Router\Route constructor

public **compilePattern** (*mixed* $pattern)

Replaces placeholders from pattern returning a valid PCRE regular expression

public **via** (*mixed* $httpMethods)

Set one or more HTTP methods that constraint the matching of the route

```php
<?php

$route->via("GET");

$route->via(
    [
        "GET",
        "POST",
    ]
);

```

public **extractNamedParams** (*mixed* $pattern)

Extraits de paramètres à partir d'une chaîne

public **reConfigure** (*mixed* $pattern, [*mixed* $paths])

Reconfigurer la route de l'ajout d'un nouveau modèle et un ensemble de chemins

public static **getRoutePaths** ([*mixed* $paths])

Returns routePaths

public **getName** ()

Retourne le nom de l'itinéraire

public **setName** (*mixed* $name)

Sets the route's name

```php
<?php

$router->add(
    "/about",
    [
        "controller" => "about",
    ]
)->setName("about");

```

public **beforeMatch** (*mixed* $callback)

Sets a callback that is called if the route is matched. The developer can implement any arbitrary conditions here If the callback returns false the route is treated as not matched

```php
<?php

$router->add(
    "/login",
    [
        "module"     => "admin",
        "controller" => "session",
    ]
)->beforeMatch(
    function ($uri, $route) {
        // Check if the request was made with Ajax
        if ($_SERVER["HTTP_X_REQUESTED_WITH"] === "xmlhttprequest") {
            return false;
        }

        return true;
    }
);

```

public **getBeforeMatch** ()

Renvoie l '"avant match" rappel si tout

public **match** (*mixed* $callback)

Allows to set a callback to handle the request directly in the route

```php
<?php

$router->add(
    "/help",
    []
)->match(
    function () {
        return $this->getResponse()->redirect("https://support.google.com/", true);
    }
);

```

public **getMatch** ()

Returns the 'match' callback if any

public **getRouteId** ()

Returns the route's id

public **getPattern** ()

Returns the route's pattern

public **getCompiledPattern** ()

Returns the route's compiled pattern

public **getPaths** ()

Returns the paths

public **getReversedPaths** ()

Retourne les chemins à l'aide de postes clés et les noms comme des valeurs

public **setHttpMethods** (*mixed* $httpMethods)

Sets a set of HTTP methods that constraint the matching of the route (alias of via)

```php
<?php

$route->setHttpMethods("GET");
$route->setHttpMethods(["GET", "POST"]);

```

public **getHttpMethods** ()

Returns the HTTP methods that constraint matching the route

public **setHostname** (*mixed* $hostname)

Sets a hostname restriction to the route

```php
<?php

$route->setHostname("localhost");

```

public **getHostname** ()

Returns the hostname restriction if any

public **setGroup** ([Phalcon\Mvc\Router\GroupInterface](Phalcon_Mvc_Router_GroupInterface) $group)

Sets the group associated with the route

public **getGroup** ()

Returns the group associated with the route

public **convert** (*mixed* $name, *mixed* $converter)

Ajoute un convertisseur pour effectuer une transformation supplémentaire pour certains paramètres

public **getConverters** ()

Returns the router converter

public static **reset** ()

Réinitialise la voie interne id du générateur