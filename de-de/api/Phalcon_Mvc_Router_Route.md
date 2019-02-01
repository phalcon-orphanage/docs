---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Mvc\Router\Route'
---
# Class **Phalcon\Mvc\Router\Route**

*implements* [Phalcon\Mvc\Router\RouteInterface](Phalcon_Mvc_Router_RouteInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/router/route.zep)

Diese Klasse repräsentiert jede Route, welche dem Router hinzugefügt wurde

## Methoden

public **__construct** (*mixed* $pattern, [*mixed* $paths], [*mixed* $httpMethods])

Phalcon\Mvc\Router\Route constructor

public **compilePattern** (*mixed* $pattern)

Ersetzt Platzhalter aus Muster wieder und gibt einen gültigen PCRE regulären Ausdruck zurück

public **via** (*mixed* $httpMethods)

Legen Sie eine oder mehrere HTTP-Methoden fest, auf dass die passende Route beschränkt ist

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

Extrahiert Parameter aus einer Zeichenfolge

public **reConfigure** (*mixed* $pattern, [*mixed* $paths])

Konfiguriert die Route, unter Angabe eines neuen Musters und einigen Pfaden, neu

public static **getRoutePaths** ([*mixed* $paths])

Gibt routePaths zurück

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
        // Prüfen, ob der request per AJAX erfolgte
        if ($_SERVER["HTTP_X_REQUESTED_WITH"] === "xmlhttprequest") {
            return false;
        }

        return true;
    }
);

```

public **getBeforeMatch** ()

Liefert den "before match" Callback, falls vorhanden

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

Gibt die Routen-Id zurück

public **getPattern** ()

Gibt das Routen-Muster zurück

public **getCompiledPattern** ()

Gibt das compilierte Routen-Muster zurück

public **getPaths** ()

Gibt die Pfade zurück

public **getReversedPaths** ()

Gibt die Pfade mit Positionen als Schlüssel und Namen als Werte zurück

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

Fügt einen Konverter hinzu, um eine weitere Transformation für bestimmte Parameter auszuführen

public **getConverters** ()

Gibt den Router-Konverter zurück

public static **reset** ()

Setzt den internen Routen Id-Generator zurück