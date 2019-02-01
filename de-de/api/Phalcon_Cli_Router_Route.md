---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Cli\Router\Route'
---
# Class **Phalcon\Cli\Router\Route**

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/router/route.zep)

Diese Klasse repräsentiert jede Route, welche dem Router hinzugefügt wurde

## Konstanten

*string* **DEFAULT_DELIMITER**

## Methoden

public **__construct** (*string* $pattern, [*array* $paths])

Phalcon\Cli\Router\Route constructor

public **compilePattern** (*mixed* $pattern)

Ersetzt Platzhalter aus Muster wieder und gibt einen gültigen PCRE regulären Ausdruck zurück

public *array* | *boolean* **extractNamedParams** (*string* $pattern)

Extrahiert Parameter aus einer Zeichenfolge

public **reConfigure** (*string* $pattern, [*array* $paths])

Konfiguriert die Route, unter Angabe eines neuen Musters und einigen Pfaden, neu

public **getName** ()

Gibt den Routen-Namen zurück

public **setName** (*mixed* $name)

Legt den Routen-Namen fest

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

Liefert den "before match" Callback, falls vorhanden

public **getRouteId** ()

Gibt die Routen-Id zurück

public **getPattern** ()

Gibt das Routen-Muster zurück

public **getCompiledPattern** ()

Gibt das compilierte Routen-Muster zurück

public **getPaths** ()

Gibt die Pfade zurück

public **getReversedPaths** ()

Gibt die Pfade mit Positionen als Schlüssel und Namen als Werte zurück

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **convert** (*string* $name, *callable* $converter)

Fügt einen Konverter hinzu, um eine weitere Transformation für bestimmte Parameter auszuführen

public **getConverters** ()

Gibt den Router-Konverter zurück

public static **reset** ()

Setzt den internen Routen Id-Generator zurück

public static **delimiter** ([*mixed* $delimiter])

Legt das Routing Trennzeichen fest

public static **getDelimiter** ()

Gibt das Routing Trennzeichen zurück