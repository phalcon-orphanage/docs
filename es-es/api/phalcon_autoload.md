---
layout: default
language: 'es-es'
version: '5.0'
title: 'Phalcon\Autoload'
---

* [Phalcon\Autoload\Exception](#autoload-exception)
* [Phalcon\Autoload\Loader](#autoload-loader)

<h1 id="autoload-exception">Class Phalcon\Autoload\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Autoload/Exception.zep)

| Namespace  | Phalcon\Autoload | | Extends    | \Exception |

Exceptions thrown in Phalcon\Autoload will use this class



<h1 id="autoload-loader">Class Phalcon\Autoload\Loader</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Autoload/Loader.zep)

| Namespace  | Phalcon\Autoload | | Uses       | Phalcon\Events\AbstractEventsAware | | Extends    | AbstractEventsAware |

The Phalcon Autoloader provides an easy way to automatically load classes (namespaced or not) as well as files. It also features extension loading, allowing the user to autoload files with different extensions than .php.


## Propiedades
```php
/**
 * @var string|null
 */
protected checkedPath;

/**
 * @var array
 */
protected classes;

/**
 * @var array
 */
protected debug;

/**
 * @var array
 */
protected directories;

/**
 * @var array
 */
protected extensions;

/**
 * @var string|callable
 */
protected fileCheckingCallback = is_file;

/**
 * @var array
 */
protected files;

/**
 * @var string|null
 */
protected foundPath;

/**
 * @var bool
 */
protected isDebug = false;

/**
 * @var bool
 */
protected isRegistered = false;

/**
 * @var array
 */
protected namespaces;

```

## Métodos

```php
public function __construct( bool $isDebug = bool );
```
Loader constructor.


```php
public function addClass( string $name, string $file ): Loader;
```
Adds a class to the internal collection for the mapping


```php
public function addDirectory( string $directory ): Loader;
```
Adds a directory for the loaded files


```php
public function addExtension( string $extension ): Loader;
```
Adds an extension for the loaded files


```php
public function addFile( string $file ): Loader;
```
Adds a file to be added to the loader


```php
public function addNamespace( string $name, mixed $directories, bool $prepend = bool ): Loader;
```

```php
public function autoload( string $className ): bool;
```
Carga automáticamente las clases registradas


```php
public function getCheckedPath(): string | null;
```
Obtiene la ruta que está revisando el cargador para un ruta específica


```php
public function getClasses(): array;
```
Devuelve el mapa de clases que actualmente tiene registrado el auto cargador


```php
public function getDebug(): array;
```
Returns debug information collected


```php
public function getDirectories(): array;
```
Devuelve los directorios registrados actualmente en el autocargador


```php
public function getExtensions(): array;
```
Devuelve las extensiones de archivo registradas en el cargador


```php
public function getFiles(): array;
```
Devuelve los archivos registrados actualmente en el auto cargador


```php
public function getFoundPath(): string | null;
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
public function setClasses( array $classes, bool $merge = bool ): Loader;
```
Registra las clases y sus ubicaciones


```php
public function setDirectories( array $directories, bool $merge = bool ): Loader;
```
Registra los directorios en los que se pueden localizar las clases "no encontradas"


```php
public function setExtensions( array $extensions, bool $merge = bool ): Loader;
```
Establece un conjunto de extensiones de fichero que el cargador debe probar en cada intento de localizar el fichero


```php
public function setFileCheckingCallback( mixed $method = null ): Loader;
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
public function setFiles( array $files, bool $merge = bool ): Loader;
```
Registra ficheros que son "no clases" por lo tanto necesitan un "require". Esto es muy útil para incluir archivos que solo tienen funciones


```php
public function setNamespaces( array $namespaces, bool $merge = bool ): Loader;
```
Registra los espacios de nombres y sus directorios relacionados


```php
public function unregister(): Loader;
```
Anula el registro del método de autocarga


```php
protected function requireFile( string $file ): bool;
```
If the file exists, require it and return true; false otherwise
