---
layout: default
language: 'pl-pl'
version: '5.0'
title: 'Upgrade Guide'
keywords: 'upgrade, v3, v4'
---

# Upgrade Guide
- - -

# Upgrading to V5
So you have decided to upgrade to v5! **Congratulations**!!

Phalcon v5 contains a lot of changes in components and interfaces. Upgrading is going to be a time-consuming task, depending on how big and complex your application is. We hope that this document will make your upgrade journey smoother and also offer insight as to why certain changes were made and how it will help the framework in the future.

We will outline the areas that you need to pay attention to and make necessary changes so that your code can run as smoothly as it has been with v4. Although the changes are significant, it is more of a methodical task than a daunting one.

## Requirements
### PHP 7.4
Phalcon v5 supports only PHP 7.4 and above. PHP 7.4 [active support][php-support] expired roughly a month before the release of Phalcon 5, but support for Security patches etc. will continue until November 2022. After that time, we will drop support for PHP 7.4 also.

Since Phalcon 4, we have been following the PHP releases and adjusting Phalcon accordingly to work with those releases.

<a name='psr'></a>

### PSR
Phalcon requires the PSR extension. The extension can be installed with PECL:

```bash
pecl install psr
```

If you do not wish to install it with PECL, you can download and compile OSR from [this][psr-extension] GitHub repository. Installation instructions are available in the `README` of the repository. Once the extension has been compiled and is available in your system, you will need to load it to your `php.ini`. You will need to add this line:

```ini
extension=psr.so
```

before

```ini
extension=phalcon.so
```

Alternatively some distributions add a number prefix on `ini` files. If that is the case, choose a high number for Phalcon (e.g. `50-phalcon.ini`).

### Installation
Phalcon can be installed using PECL.

```bash
pecl install phalcon-5.0.0
```

> It is important to check your `php.ini` file (both for your web server and CLI) and make sure that phalcon is loaded after psr. Your php.ini should look something like this:
> 
> `extension=psr.so`
> 
> `extension=phalcon.so` 
> 
> {: .alert .alert-warning }

**Alternative installation**

Download the latest `zephir.phar` from [here][zephir-phar]. Add it to a folder that can be accessed by your system.

Clone the repository

```bash
git clone https://github.com/phalcon/cphalcon
```

Compile Phalcon

```bash
cd cphalcon/
git checkout tags/5.0.0 ./
zephir fullclean
zephir build
```

Check the module

```bash
php -m | grep phalcon
```

- - -

## General Notes

One of the biggest changes with this release is that we no longer have top level classes. All top level classes have been moved into relevant namespaces. For instance `Phalcon\Loader` has been moved to `Phalcon\Autoload\Loader`. This change was necessary for the future expansion of the project.

**Summary**

| v4                    | v5                                             |
| --------------------- | ---------------------------------------------- |
| `Phalcon\Cache`      | `Phalcon\Cache\Cache`                        |
| `Phalcon\Collection` | `Phalcon\Support\Collection`                 |
| `Phalcon\Config`     | `Phalcon\Config\Config`                      |
| `Phalcon\Container`  | `Phalcon\Container\Container`                |
| `Phalcon\Crypt`      | `Phalcon\Encryption\Crypt`                   |
| `Phalcon\Debug`      | `Phalcon\Support\Debug`                      |
| `Phalcon\Di`         | `Phalcon\Di\Di`                              |
| `Phalcon\Escaper`    | `Phalcon\Html\Escaper`                       |
| `Phalcon\Exception`  | Removed                                        |
| `Phalcon\Filter`     | `Phalcon\Filter\Filter`                      |
| `Phalcon\Helper`     | Removed in favor of `Phalcon\Support\Helper` |
| `Phalcon\Loader`     | `Phalcon\Autoload\Loader`                    |
| `Phalcon\Logger`     | `Phalcon\Logger\Logger`                      |
| `Phalcon\Kernel`     | Removed                                        |
| `Phalcon\Registry`   | `Phalcon\Support\Registry`                   |
| `Phalcon\Security`   | `Phalcon\Encryption\Security`                |
| `Phalcon\Tag`        | Removed in favor of `Phalcon\Html\Helper`    |
| `Phalcon\Text`       | Removed in favor of `Phalcon\Support\Helper` |
| `Phalcon\Url`        | `Phalcon\Mvc\Url`                            |
| `Phalcon\Validation` | `Phalcon\Filter\Validation`                  |
| `Phalcon\Version`    | `Phalcon\Support\Version`                    |

## Changes

### Acl

> Status: **changes required**
> 
> Usage: [ACL Documentation](acl) 
> 
> {: .alert .alert-warning }

The [ACL](acl) component has had some methods and components renamed. The functionality remains the same as in previous versions.

- Renamed `Phalcon\Acl\ComponentAware` to `Phalcon\Acl\ComponentAwareInterface`
- Renamed `Phalcon\Acl\RoleAware` to `Phalcon\Acl\RoleAwareInterface`

### `Acl\Adapter\Memory` - `Acl\Adapter\AdapterInterface`
- Added `getInheritedRoles()` to return an array of the inherited roles in the adapter.

### Annotations

> Status: **no changes**
> 
> Usage: [Annotations Documentation](annotations) 
> 
> {: .alert .alert-info }

### Application

> Status: **no changes**
> 
> Usage: [Application Documentation](application) 
> 
> {: .alert .alert-info }

The `getEventsManager()` now returns a `Phalcon\Events\ManagerInterface` or `null`

### Assets

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

The [Assets](assets) component has had changes to the interface as well as some methods were renamed. The functionality remains the same as in previous versions.

#### `Phalcon\Assets\Asset`
- `getAssetKey()` now uses `sha1` to compute the key
- Renamed `getLocal()` to `isLocal()`
- Renamed `setLocal()` to `setIsLocal()`

#### `Phalcon\Assets\Collection`
- The class now uses `ArrayIterator` instead of `Iterator
- Renamed `getLocal()` to `isLocal()`
- Renamed `setLocal()` to `setIsLocal()`
- Renamed `getTargetLocal()` to `getTargetIsLocal()`
- Renamed `setTargetLocal()` to `setTargetIsLocal()`
- Removed `getPosition()`, `current()`, `key()`, `next()`, `rewind()`, `valid()`

#### `Phalcon\Assets\Inline`
- `getAssetKey()` now uses `sha1` to compute the key

#### `Phalcon\Assets\Manager`
- `__construct()` requires a `Phalcon\Html\TagFactory` as the first parameter

```php
public function __construct(Phalcon\Html\TagFactory $tagFactory, array $options = [])
```

- `addCss()` now requires `$local` to be `bool` and `$attributes` to be an array

```php
public function addCss(
    string $path,
    bool $local = true,
    bool $filter = true,
    array $attributes = [],
    string $version = null,
    bool $autoVersion = false
): Manager
```

- `addInlineCss()` now requires `$filter` to be `bool` and `$attributes` to be an array

```php 
public function addInlineCss(
    string $content,
    bool $filter = true,
    array $attributes = []
): Manager 
```

- `addJs()` now requires `$local` to be `bool` and `$attributes` to be an array

```php
public function addJs(
    string $path,
    bool $local = true,
    bool $filter = true,
    array $attributes = [],
    string $version = null,
    bool $autoVersion = false
): Manager
```

- `addInlineJs()` now requires `$filter` to be `bool` and `$attributes` to be an array

```php 
public function addInlineJs(
    string $content,
    bool $filter = true,
    array $attributes = []
): Manager 
```

- Added `has()` method to return if a collection exists

### Cache

> Status: **changes required**
> 
> Usage: [Cache Documentation](cache) 
> 
> {: .alert .alert-warning }

The [Cache](cache) component has been moved to the `Cache` namespace.

#### `Phalcon\Cache\AdapterFactory`
- The constructor now requires a `Phalcon\Storage\SerializerFactory` to be passed as the first parameter
- The `getAdapters()` protected method has been renamed to `getServices()`
- A new protected method `getExceptionClass()` was introduced to return the exception class to throw from this factory when necessary

#### `Phalcon\Cache\CacheFactory`
- A new protected method `getExceptionClass()` was introduced to return the exception class to throw from this factory when necessary

#### `Phalcon\Cache\Cache`
- Moved `Phalcon\Cache` to `Phalcon\Cache\Cache`

### Cli

> Status: **no changes**
> 
> Usage: [Cli Documentation](cli) 
> 
> {: .alert .alert-info }


Collection

> Status: **changes required**
> 
> Usage: [Collection Documentation](collection) 
> 
> {: .alert .alert-warning }

Config

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Container

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

DataMapper

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Db

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Di

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Dispatcher

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Domain

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Encryption

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Events

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Factory

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Filtr

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Flash

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Forms

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Html

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Http

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Image

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Loader

> Status: **changes required**
> 
> Usage: [Loader Documentation](loader) 
> 
> {: .alert .alert-warning }

The [Loader](loader) component has been moved to the `Autoload` namespace. Some method names have been changed and new functionality introduced.

#### `Phalcon\Autoload\Loader`
- `__construct(bool $isDebug = false)` The constructor now accepts a boolean, which allows the loader to collect and store debug information during the discovery and loading process of files, classes etc. If the variable is set to `true`, `getDebug()` will return an array with all the debugging information during the autoload operation. This mode is only for debugging purposes and must not be used in production environments.

```php

use Phalcon\Autoload\Loader;
use Adapter\Another;

$loader = new Loader(true);

$loader
    ->addNamespace('Base', './Namespaces/Base/')
    ->addNamespace('Adapter', './Namespaces/Adapter/')
    ->addNamespace('Namespaces', './Namespaces/')
;

$loader->autoload(Another::class);

var_dump($loader->getDebug());

// [
//     'Loading: Adapter\Another',
//     'Class: 404: Adapter\Another',
//     'Require: 404: ./Namespaces/Adapter/Another.php',
//     'Require: ./Namespaces/Another.php',
//     'Namespace: Namespaces\Adapter - ./Namespaces/Another.php',
// ];
```

- `add*` methods have been introduced to help with the setup of the autoloader
  - `addClass(string $name, string $file): Loader`
  - `addDirectory(string $directory): Loader`
  - `addExtension(string $extension): Loader`
  - `addFile(string $file): Loader`
  - `addNamespace(string $name, string|array $directories, bool $prepend = false): Loader`
- `getCheckedPath()` now returns either a string or a `null` (if not populated yet)
- `getDebug()` returns an array of debug information, if the Loader has been instantiated with `$isDebug = true`
- `getDirs()` has been renamed to `getDirectories()`
- `getFoundPath()` now returns either a string or a `null` (if not populated yet)
- `registerClasses()` has been renamed to `setClasses()`
- `registerDirs()` has been renamed to `setDirectories()`
- `registerExtensions()` has been renamed to `setExtensions()`
- `setExtensions()` now accepts a second parameter (`bool` `$merge`) which allows you to merge the data set with what is already set in the Loader
- `registerFiles()` has been renamed to `setFiles()`
- `registerNamespaces()` has been renamed to `setNamespaces()`




Logger

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Messages

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Mvc

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Paginator

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Session

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Storage

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Support

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Tag

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Translate

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Tag.zep

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }



[php-support]: https://www.php.net/supported-versions.php
[psr-extension]: https://github.com/jbboehr/php-psr
[zephir-phar]: https://github.com/phalcon/zephir/releases
