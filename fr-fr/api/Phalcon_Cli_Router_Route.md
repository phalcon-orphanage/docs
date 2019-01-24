---
layout: article
language: 'fr-fr'
version: '4.0'
title: 'Phalcon\Cli\Router\Route'
---
# Class **Phalcon\Cli\Router\Route**

[Source sur GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/router/route.zep)

Cette classe représente chaque route a ajouté le routeur

## Constantes

*string* **DEFAULT_DELIMITER**

## Méthodes

public **__construct** (*string* $pattern, [*array* $paths])

Phalcon\Cli\Router\Route constructor

public **compilePattern** (*mixed* $pattern)

Replaces placeholders from pattern returning a valid PCRE regular expression

public *array* | *boolean* **extractNamedParams** (*string* $pattern)

Extraits de paramètres à partir d'une chaîne

public **reConfigure** (*string* $pattern, [*array* $paths])

Reconfigurer la route de l'ajout d'un nouveau modèle et un ensemble de chemins

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

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **beforeMatch** (*callback* $callback)

Sets a callback that is called if the route is matched. The developer can implement any arbitrary conditions here If the callback returns false the route is treated as not matched

public *mixed* **getBeforeMatch** ()

Renvoie l '"avant match" rappel si tout

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

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **convert** (*string* $name, *callable* $converter)

Ajoute un convertisseur pour effectuer une transformation supplémentaire pour certains paramètres

public **getConverters** ()

Returns the router converter

public static **reset** ()

Réinitialise la voie interne id du générateur

public static **delimiter** ([*mixed* $delimiter])

Définir le routage délimiteur

public static **getDelimiter** ()

Get routing delimiter