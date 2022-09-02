---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Loader'
---

* [Phalcon\Loader](#loader)
* [Phalcon\Loader\Exception](#loader-exception)

<h1 id="loader">Class Phalcon\Loader</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Loader.zep)

| Namespace | Phalcon | | Uses | Phalcon\Loader\Exception, Phalcon\Events\ManagerInterface, Phalcon\Events\EventsAwareInterface | | Implements | EventsAwareInterface |

Este componente ayuda a cargar automáticamente las clases de tu proyecto basándose en algunas convenciones

```php
use Phalcon\Loader;

// Creates the autoloader
$loader = new Loader();

// Register some namespaces
$loader->registerNamespaces(
    [
        "Example\\Base"    => "vendor/example/base/",
        "Example\\Adapter" => "vendor/example/adapter/",
        "Example"          => "vendor/example/",
    ]
);

// Register autoloader
$loader->register();

// Requiring this class will automatically include file vendor/example/adapter/Some.php
$adapter = new \Example\Adapter\Some();
```

## Propiedades

```php
//
protected checkedPath;

/**
 * @var array
 */
protected classes;

/**
 * @var array
 */
protected directories;

//
protected eventsManager;

/**
 * @var array
 */
protected extensions;

//
protected fileCheckingCallback = is_file;

/**
 * @var array
 */
protected files;

/**
 * @var bool
 */
protected foundPath;

/**
 * @var array
 */
protected namespaces;

/**
 * @var bool
 */
protected registered = false;

```

## Métodos

```php
public function autoLoad( string $className ): bool;
```

Carga automáticamente las clases registradas

```php
public function getCheckedPath(): string;
```

Obtiene la ruta que está revisando el cargador para un ruta específica

```php
public function getClasses(): array;
```

Devuelve el mapa de clases que actualmente tiene registrado el auto cargador

```php
public function getDirs(): array;
```

Devuelve los directorios registrados actualmente en el autocargador

```php
public function getEventsManager(): ManagerInterface;
```

Devuelve el administrador de eventos interno

```php
public function getExtensions(): array;
```

Devuelve las extensiones de archivo registradas en el cargador

```php
public function getFiles(): array;
```

Devuelve los archivos registrados actualmente en el auto cargador

```php
public function getFoundPath(): string;
```

Obtiene la ruta cuando una clase fue encontrada

```php
public function getNamespaces(): array;
```

Devuelve los espacios de nombres registrados actualmente en el autocargador

```php
public function loadFiles(): void;
```

Comprueba si un archivo existe y a continuación añade el archivo haciendo un `require` virtual

```php
public function register( bool $prepend = bool ): Loader;
```

Registrar el método de autocarga

```php
public function registerClasses( array $classes, bool $merge = bool ): Loader;
```

Registra las clases y sus ubicaciones

```php
public function registerDirs( array $directories, bool $merge = bool ): Loader;
```

Registra los directorios en los que se pueden localizar las clases "no encontradas"

```php
public function registerFiles( array $files, bool $merge = bool ): Loader;
```

Registra ficheros que son "no clases" por lo tanto necesitan un "require". Esto es muy útil para incluir archivos que solo tienen funciones

```php
public function registerNamespaces( array $namespaces, bool $merge = bool ): Loader;
```

Registra los espacios de nombres y sus directorios relacionados

```php
public function setEventsManager( ManagerInterface $eventsManager ): void;
```

Establece el administrador de eventos

```php
public function setExtensions( array $extensions ): Loader;
```

Establece un conjunto de extensiones de fichero que el cargador debe probar en cada intento de localizar el fichero

```php
public function setFileCheckingCallback( mixed $callback = null ): Loader;
```

Establece la función de retorno de la comprobación de fichero.

```php
// Default behavior.
$loader->setFileCheckingCallback("is_file");

// Faster than `is_file()`, but implies some issues if
// the file is removed from the filesystem.
$loader->setFileCheckingCallback("stream_resolve_include_path");

// Do not check file existence.
$loader->setFileCheckingCallback(null);
```

```php
public function unregister(): Loader;
```

Anula el registro del método de autocarga

```php
protected function prepareNamespace( array $namespaceName ): array;
```

<h1 id="loader-exception">Class Phalcon\Loader\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Loader/Exception.zep)

| Namespace | Phalcon\Loader | | Extends | \Phalcon\Exception |

Phalcon\Loader\Exception

Las excepciones lanzadas en Phalcon\Loader usarán esta clase
