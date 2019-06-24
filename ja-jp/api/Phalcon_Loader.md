---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Loader'
---

* [Phalcon\Loader](#Loader)
* [Phalcon\Loader\Exception](#Loader_Exception)

<h1 id="Loader">Class Phalcon\Loader</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/loader.zep)

| Namespace | Phalcon | | Uses | Phalcon\Loader\Exception, Phalcon\Events\ManagerInterface, Phalcon\Events\EventsAwareInterface | | Implements | EventsAwareInterface |

This component helps to load your project classes automatically based on some conventions

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

## Properties

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

## メソッド

```php
public function autoLoad( string $className ): bool;
```

Autoloads the registered classes

```php
public function getCheckedPath(): string;
```

Get the path the loader is checking for a path

```php
public function getClasses(): array;
```

Returns the class-map currently registered in the autoloader

```php
public function getDirs(): array;
```

Returns the directories currently registered in the autoloader

```php
public function getEventsManager(): ManagerInterface;
```

内部イベントマネージャーを返します

```php
public function getExtensions(): array;
```

Returns the file extensions registered in the loader

```php
public function getFiles(): array;
```

Returns the files currently registered in the autoloader

```php
public function getFoundPath(): string;
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
public function registerClasses( array $classes, bool $merge = bool ): Loader;
```

Register classes and their locations

```php
public function registerDirs( array $directories, bool $merge = bool ): Loader;
```

Register directories in which "not found" classes could be found

```php
public function registerFiles( array $files, bool $merge = bool ): Loader;
```

Registers files that are "non-classes" hence need a "require". This is very useful for including files that only have functions

```php
public function registerNamespaces( array $namespaces, bool $merge = bool ): Loader;
```

Register namespaces and their related directories

```php
public function setEventsManager( mixed $eventsManager ): void;
```

イベントマネージャーをセットします

```php
public function setExtensions( array $extensions ): Loader;
```

Sets an array of file extensions that the loader must try in each attempt to locate the file

```php
public function setFileCheckingCallback( mixed $callback = null ): Loader;
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
public function unregister(): Loader;
```

Unregister the autoload method

```php
protected function prepareNamespace( array $namespaceName ): array;
```

//

<h1 id="Loader_Exception">Class Phalcon\Loader\Exception</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/loader/exception.zep)

| Namespace | Phalcon\Loader | | Extends | \Phalcon\Exception |

Phalcon\Loader\Exception

Exceptions thrown in Phalcon\Loader will use this class