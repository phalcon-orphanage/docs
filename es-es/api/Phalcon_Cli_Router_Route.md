---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Cli\Router\Route'
---
# Class **Phalcon\Cli\Router\Route**

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/router/route.zep)

Esta clase representa cada ruta agregada al enrutador

## Constantes

*string* **DEFAULT_DELIMITER**

## Métodos

public **__construct** (*string* $pattern, [*array* $paths])

Phalcon\Cli\Router\Route constructor

public **compilePattern** (*mixed* $pattern)

Reemplaza los marcadores de posición del patrón que devuelve una expresión PCRE regular válida

public *array* | *boolean* **extractNamedParams** (*string* $pattern)

Extrae parámetros de una cadena

public **reConfigure** (*string* $pattern, [*array* $paths])

Reconfigura la ruta agregando un nuevo patrón y un conjunto de rutas

public **getName** ()

Devuelve el nombre de la ruta

public **setName** (*mixed* $name)

Establece el nombre de la ruta

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

Devuelve la coincidencia del anterior callback si la hay

public **getRouteId** ()

Devuelve la identidad de la ruta

public **getPattern** ()

Devuelve el patrón de la ruta

public **getCompiledPattern** ()

Devuelve el patrón compilado de la ruta

public **getPaths** ()

Devuelve la ruta

public **getReversedPaths** ()

Devuelve las rutas usando posiciones como claves y nombres como valores

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **convert** (*string* $name, *callable* $converter)

Agrega un convertidor para realizar una transformación adicional para cierto parámetro

public **getConverters** ()

Devuelve el convertidor del router

public static **reset** ()

Restablece el generador de identificador de ruta interno

public static **delimiter** ([*mixed* $delimiter])

Establece el delimitador de enrutamiento

public static **getDelimiter** ()

Obtiene el delimitador de enrutamiento