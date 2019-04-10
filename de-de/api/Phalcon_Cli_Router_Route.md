---
layout: default
language: 'de-de'
version: '4.0'
title: 'Phalcon\Cli\Router\Route'
---
# Class **Phalcon\Cli\Router\Route**

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/router/route.zep)

This class represents every route added to the router

## Constants

*string* **DEFAULT_DELIMITER**

## Methods

public **__construct** (*string* $pattern, [*array* $paths])

Phalcon\Cli\Router\Route constructor

public **compilePattern** (*mixed* $pattern)

Replaces placeholders from pattern returning a valid PCRE regular expression

public *array* | *boolean* **extractNamedParams** (*string* $pattern)

Extracts parameters from a string

public **reConfigure** (*string* $pattern, [*array* $paths])

Reconfigure the route adding a new pattern and a set of paths

public *string* **getDescription** ()

Returns the route's description

public **getName** ()

Returns the route's name

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

Returns the 'before match' callback if any

public **getRouteId** ()

Returns the route's id

public **getPattern** ()

Returns the route's pattern

public **getCompiledPattern** ()

Returns the route's compiled pattern

public **getPaths** ()

Returns the paths

public **getReversedPaths** ()

Returns the paths using positions as keys and names as values

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **convert** (*string* $name, *callable* $converter)

Adds a converter to perform an additional transformation for certain parameter

public **getConverters** ()

Returns the router converter

public static **reset** ()

Resets the internal route id generator

public [Phalcon\Cli\Router\RouteInterface](Phalcon_Cli_Router_RouteInterface) **setDescription** (*string* $description)

Sets the route's description

public static **delimiter** ([*mixed* $delimiter])

Set the routing delimiter

public static **getDelimiter** ()

Get routing delimiter