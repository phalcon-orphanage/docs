---
layout: default
language: 'ko-kr'
version: '4.0'
title: 'Phalcon\Loader'
---

* [Phalcon\Loader](#loader)
* [Phalcon\Loader\Exception](#loader-exception)

<h1 id="loader">Class Phalcon\Loader</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Loader.zep)

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

## Methods

Autoloads the registered classes

```php
public function autoLoad( string $className ): bool;
```

Get the path the loader is checking for a path

```php
public function getCheckedPath(): string;
```

Returns the class-map currently registered in the autoloader

```php
public function getClasses(): array;
```

Returns the directories currently registered in the autoloader

```php
public function getDirs(): array;
```

Returns the internal event manager

```php
public function getEventsManager(): ManagerInterface;
```

Returns the file extensions registered in the loader

```php
public function getExtensions(): array;
```

Returns the files currently registered in the autoloader

```php
public function getFiles(): array;
```

Get the path when a class was found

```php
public function getFoundPath(): string;
```

Returns the namespaces currently registered in the autoloader

```php
public function getNamespaces(): array;
```

Checks if a file exists and then adds the file by doing virtual require

```php
public function loadFiles(): void;
```

Register the autoload method

```php
public function register( bool $prepend = bool ): Loader;
```

Register classes and their locations

```php
public function registerClasses( array $classes, bool $merge = bool ): Loader;
```

Register directories in which "not found" classes could be found

```php
public function registerDirs( array $directories, bool $merge = bool ): Loader;
```

Registers files that are "non-classes" hence need a "require". This is very useful for including files that only have functions

```php
public function registerFiles( array $files, bool $merge = bool ): Loader;
```

Register namespaces and their related directories

```php
public function registerNamespaces( array $namespaces, bool $merge = bool ): Loader;
```

Sets the events manager

```php
public function setEventsManager( ManagerInterface $eventsManager ): void;
```

Sets an array of file extensions that the loader must try in each attempt to locate the file

```php
public function setExtensions( array $extensions ): Loader;
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
public function setFileCheckingCallback( mixed $callback = null ): Loader;
```

Unregister the autoload method

```php
public function unregister(): Loader;
```

```php
protected function prepareNamespace( array $namespaceName ): array;
```

<h1 id="loader-exception">Class Phalcon\Loader\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Loader/Exception.zep)

| Namespace | Phalcon\Loader | | Extends | \Phalcon\Exception |

Phalcon\Loader\Exception

Exceptions thrown in Phalcon\Loader will use this class