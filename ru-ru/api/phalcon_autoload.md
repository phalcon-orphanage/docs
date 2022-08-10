---
layout: default
language: 'ru-ru'
version: '5.0'
title: 'Phalcon\Autoload'
---

* [Phalcon\Autoload\Exception](#autoload-exception)
* [Phalcon\Autoload\Loader](#autoload-loader)

<h1 id="autoload-exception">Class Phalcon\Autoload\Exception</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Autoload/Exception.zep)

| Namespace  | Phalcon\Autoload | | Extends    | \Exception |

Exceptions thrown in Phalcon\Autoload will use this class



<h1 id="autoload-loader">Class Phalcon\Autoload\Loader</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Autoload/Loader.zep)

| Namespace  | Phalcon\Autoload | | Uses       | Phalcon\Events\AbstractEventsAware | | Extends    | AbstractEventsAware |

The Phalcon Autoloader provides an easy way to automatically load classes (namespaced or not) as well as files. It also features extension loading, allowing the user to autoload files with different extensions than .php.


## Properties
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

## Методы

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
Autoloads the registered classes


```php
public function getCheckedPath(): string | null;
```
Get the path the loader is checking for a path


```php
public function getClasses(): array;
```
Returns the class-map currently registered in the autoloader


```php
public function getDebug(): array;
```
Returns debug information collected


```php
public function getDirectories(): array;
```
Returns the directories currently registered in the autoloader


```php
public function getExtensions(): array;
```
Returns the file extensions registered in the loader


```php
public function getFiles(): array;
```
Returns the files currently registered in the autoloader


```php
public function getFoundPath(): string | null;
```
Get the path when a class was found


```php
public function getNamespaces(): array;
```
Returns the namespaces currently registered in the autoloader


```php
public function loadFiles(): void;
```
Checks if a file exists and then adds the file by doing virtual require


```php
public function register( bool $prepend = bool ): Loader;
```
Register the autoload method


```php
public function setClasses( array $classes, bool $merge = bool ): Loader;
```
Register classes and their locations


```php
public function setDirectories( array $directories, bool $merge = bool ): Loader;
```
Register directories in which "not found" classes could be found


```php
public function setExtensions( array $extensions, bool $merge = bool ): Loader;
```
Sets an array of file extensions that the loader must try in each attempt to locate the file


```php
public function setFileCheckingCallback( mixed $method = null ): Loader;
```
Sets the file check callback.

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
Registers files that are "non-classes" hence need a "require". This is very useful for including files that only have functions


```php
public function setNamespaces( array $namespaces, bool $merge = bool ): Loader;
```
Register namespaces and their related directories


```php
public function unregister(): Loader;
```
Unregister the autoload method


```php
protected function requireFile( string $file ): bool;
```
If the file exists, require it and return true; false otherwise
