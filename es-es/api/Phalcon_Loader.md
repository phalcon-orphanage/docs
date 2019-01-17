---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Loader'
---
# Class **Phalcon\Loader**

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/loader.zep)

Este componente ayuda a cargar automáticamente las clases de tu proyecto basándose en algunas convenciones

```php
<?php

use Phalcon\Loader;

// Creates the autoloader
$loader = new Loader();

// Register some namespaces
$loader->registerNamespaces(
    [
        "Example\Base"    => "vendor/example/base/",
        "Example\Adapter" => "vendor/example/adapter/",
        "Example"          => "vendor/example/",
    ]
);

// Register autoloader
$loader->register();

// Requiring this class will automatically include file vendor/example/adapter/Some.php
$adapter = new \Example\Adapter\Some();

```

## Métodos

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Establece el administrador de eventos

public **getEventsManager** ()

Devuelve el administrador de eventos interno

public **setExtensions** (*array* $extensions)

Establece un conjunto de extensiones de archivo que el cargador debe probar en cada intento de localizar el archivo

public **getExtensions** ()

Devuelve las extensiones de archivo registradas en el cargador

public **registerNamespaces** (*array* $namespaces, [*mixed* $merge])

Registra los nombres de espacios y sus directorios relacionados

public **setFileCheckingCallback** (*mixed* $callback = null): [Phalcon\Loader](Phalcon_Loader)

Sets the file check callback.

```php
<?php

// Default behavior.
$loader->setFileCheckingCallback("is_file");

// Faster than `is_file()`, but implies some issues if
// the file is removed from the filesystem.
$loader->setFileCheckingCallback("stream_resolve_include_path");

// Do not check file existence.
$loader->setFileCheckingCallback(null);
```

A [Phalcon\Loader\Exception](Phalcon_Loader_Exception) is thrown if the $callback parameter is not a `callable` or `null`;

protected **prepareNamespace** (*array* $namespace)

...

public **getNamespaces** ()

Devuelve los espacios de nombres registrados actualmente en el auto cargador

public **registerDirs** (*array* $directories, [*mixed* $merge])

Registra los directorios en los que se pueden localizar las clases "no encontradas"

public **getDirs** ()

Devuelve los directorios registrados actualmente en el auto cargador

public **registerFiles** (*array* $files, [*mixed* $merge])

Registers files that are "non-classes" hence need a "require". This is very useful for including files that only have functions

public **getFiles** ()

Devuelve los archivos registrados actualmente en el auto cargador

public **registerClasses** (*array* $classes, [*mixed* $merge])

Registra las clases y sus ubicaciones

public **getClasses** ()

Devuelve el mapa de clases que actualmente tiene registrado el auto cargador

public **register** ([*mixed* $prepend])

Registrar el método de auto carga

public **unregister** ()

Anula el registro el método de auto carga

public **loadFiles** ()

Comprueba si un archivo existe y a continuación agrega el archivo haciendo un require virtual

public **autoLoad** (*mixed* $className)

Carga automáticamente las clases registradas

public **getFoundPath** ()

Obtener la ruta cuando una clase fue encontrada

public **getCheckedPath** ()

Obtener la ruta que está revisando el cargador para un ruta específica