# Clase **Phalcon\\Loader**

*implementa* [Phalcon\Events\EventsAwareInterface](/en/3.2/api/Phalcon_Events_EventsAwareInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/loader.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Este componente ayuda a cargar automáticamente las clases de tu proyecto basándose en algunas convenciones

```php
<?php

use Phalcon\Loader;

// Crear el  auto cargador
$loader = new Loader();

// Registrar algunos espacios de nombres
$loader->registerNamespaces(
    [
        "Example\\Base"    => "vendor/example/base/",
        "Example\\Adapter" => "vendor/example/adapter/",
        "Example"          => "vendor/example/",
    ]
);

// Registrear el auto cargador
$loader->register();

// Al requerir esta clase incluirá automáticamente el archivo vendor/example/adapter/Some.php
$adapter = new \Example\Adapter\Some();

```

## Métodos

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.2/api/Phalcon_Events_ManagerInterface) $eventsManager)

Establece el gestor de eventos

public **getEventsManager** ()

Devuelve el gestor de eventos internos

public **setExtensions** (*array* $extensions)

Establece un conjunto de extensiones de archivo que el cargador debe probar en cada intento de localizar el archivo

public **getExtensions** ()

Devuelve las extensiones de archivo registradas en el cargador

public **registerNamespaces** (*array* $namespaces, [*mixed* $merge])

Registra los nombres de espacios y sus directorios relacionados

protected **prepareNamespace** (*array* $namespace)

...

public **getNamespaces** ()

Devuelve los espacios de nombres registrados actualmente en el auto cargador

public **registerDirs** (*array* $directories, [*mixed* $merge])

Registra los directorios en los que se pueden localizar las clases "no encontradas"

public **getDirs** ()

Devuelve los directorios registrados actualmente en el auto cargador

public **registerFiles** (*array* $files, [*mixed* $merge])

Registra archivos que son "no clases" y por lo tanto necesitan un "require". Esto es muy útil para incluir archivos que sólo tienen funciones

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