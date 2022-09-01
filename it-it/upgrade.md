---
layout: default
language: 'it-it'
version: '5.0'
title: 'Upgrade Guide'
keywords: 'upgrade, v3, v4, v5'
---

# Upgrade Guide
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

# Upgrading to V5
So you have decided to upgrade to v5! **Congratulations**!!

Phalcon v5 contains a lot of changes in components and interfaces. Upgrading is going to be a time-consuming task, depending on how big and complex your application is. We hope that this document will make your upgrade journey smoother and also offer insight as to why certain changes were made and how it will help the framework in the future.

We will outline the areas that you need to pay attention to and make necessary changes so that your code can run as smoothly as it has been with v4. Although the changes are significant, it is more of a methodical task than a daunting one.

## Requirements
### PHP 7.4
Phalcon v5 supports only PHP 7.4 and above. PHP 7.4 [active support][php-support] expired roughly a month before the release of Phalcon 5, but support for security patches etc. will continue until November 2022. After that time, we will drop support for PHP 7.4 also.

Since Phalcon 4, we have been following the PHP releases and adjusting Phalcon accordingly to work with those releases.

### Installation
Phalcon can be installed using PECL.

```bash
pecl install phalcon-5.0.0
```

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

You will need to add the following line to your `php.ini` (in some cases both the CLI and web versions of it)

```bash
extension=phalcon.so
```

Check the module

```bash
php -m | grep phalcon
```

If the above does not work, check the `php.ini` that your CLI is looking for. If you are using `phpinfo()` and a web browser to check if Phalcon has been loaded, make sure that your `php.ini` file that your web server is looking for contains the `extension=phalcon.so`. You will need to restart your web server after you added the new line in `php.ini`.

- - -

## General Notes

One of the biggest changes with this release is that we no longer have top level classes. All top level classes have been moved into relevant namespaces (except `Phalcon\Tag`). For instance `Phalcon\Loader` has been moved to `Phalcon\Autoload\Loader`. This change was necessary for the future expansion of the project.

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
| `Phalcon\Text`       | Removed in favor of `Phalcon\Support\Helper` |
| `Phalcon\Url`        | `Phalcon\Mvc\Url`                            |
| `Phalcon\Validation` | `Phalcon\Filter\Validation`                  |
| `Phalcon\Version`    | `Phalcon\Support\Version`                    |

## Changes

### Acl

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](acl)

The [ACL](acl) component has had some methods and components renamed. The functionality remains the same as in previous versions.

- Renamed `Phalcon\Acl\ComponentAware` to `Phalcon\Acl\ComponentAwareInterface`
- Renamed `Phalcon\Acl\RoleAware` to `Phalcon\Acl\RoleAwareInterface`

#### `Acl\Adapter\Memory` - `Acl\Adapter\AdapterInterface`
- Added `getInheritedRoles()` to return an array of the inherited roles in the adapter.

---

### Annotations

![](/assets/images/status-no-changes-blue.svg) [![](/assets/images/status-docs.svg)](annotations)

---

### Application

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](application)

#### `Phalcon\Application\AbstractApplication`
- The `getEventsManager()` now returns a `Phalcon\Events\ManagerInterface` or `null`

---

### Assets

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](assets)

The [Assets](assets) component has had changes to the interface as well as some methods were renamed. The functionality remains the same as in previous versions.

#### `Phalcon\Assets\Asset`
- `getAssetKey()` now uses `sha256` to compute the key
- Renamed `getLocal()` to `isLocal()`
- Renamed `setLocal()` to `setIsLocal()`

#### `Phalcon\Assets\Collection`
- The class now uses `ArrayIterator` instead of `Iterator`
- Renamed `getLocal()` to `isLocal()`
- Renamed `setLocal()` to `setIsLocal()`
- Renamed `getTargetLocal()` to `getTargetIsLocal()`
- Renamed `setTargetLocal()` to `setTargetIsLocal()`
- Removed `getPosition()`, `current()`, `key()`, `next()`, `rewind()`, `valid()`

#### `Phalcon\Assets\Inline`
- `getAssetKey()` now uses `sha256` to compute the key

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

---

### Autoload

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](autoload)

The [Autoload\Loader](autoload) component has been moved from the parent namespace. Some method names have been changed and new functionality introduced.

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

---

### Cache

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](cache)

The [Cache](cache) component has been moved to the `Cache` namespace.

#### `Phalcon\Cache\AdapterFactory`
- The constructor now requires a `Phalcon\Storage\SerializerFactory` to be passed as the first parameter
- The `getAdapters()` protected method has been renamed to `getServices()`
- A new protected method `getExceptionClass()` was introduced to return the exception class to throw from this factory when necessary

#### `Phalcon\Cache\CacheFactory`
- A new protected method `getExceptionClass()` was introduced to return the exception class to throw from this factory when necessary

#### `Phalcon\Cache\Cache`
- Moved `Phalcon\Cache` to `Phalcon\Cache\Cache`
- The component has been refactored and the dependency to `PSR` has been removed. [more](cache)

#### `Phalcon\Cache\CacheInterface`
- A new interface has been introduced (`Phalcon\Cache\CacheInterface`) to offer more flexibility when extending the cache object.

---

### Cli

![](/assets/images/status-no-changes-blue.svg) [![](/assets/images/status-docs.svg)](application-cli)

---

### Collection

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](support-collection)

The [Collection](support-collection) component has been moved to the `Support` namespace. [more](#support)

---

### Config

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](config)

The [Config](config) component has been moved to the `Config` namespace.

#### `Phalcon\Config\Config`
- Moved `Phalcon\Config` to `Phalcon\Config\Config`

#### `Phalcon\Config\ConfigInterface`
- A new interface has been introduced (`Phalcon\Config\ConfigInterface`) to offer more flexibility when extending the config object.

---

### Container

![](/assets/images/status-changes-required-red.svg)

The `Container` component has been removed from the framework. It is in our roadmap to develop a new container that will support auto wiring, as well as providers. Additionally, the container will be designed and implemented in such a way that could be used as a PSR-11 container (with the help of a Proxy class).

---

### Crypt

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](encryption-crypt)

The [Crypt](encryption-crypt) component has been moved to the `Encryption` namespace. [more](encryption-crypt)

---

### DataMapper

![](/assets/images/status-no-changes-blue.svg) [![](/assets/images/status-docs.svg)](datamapper)

---

### Db

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](db-layer)

---

#### `Phalcon\Db\Adapter\Pdo\AbstractPdo`
- Changed `connect(array descriptor = null): bool` to `connect(array descriptor = []): void`
- Changed `execute(string $sqlStatement, $bindParams = null, $bindTypes = null): bool` to `execute(string $sqlStatement, array $bindParams = [], array $bindTypes = []) -> bool`
- Changed `getErrorInfo()` to `getErrorInfo(): array`
- Changed `getInternalHandler(): \PDO` to `getInternalHandler(): mixed`
- Changed `lastInsertId($sequenceName = null): int | bool` to `lastInsertId(string $name = null) -> string | bool`
- Changed `query(string $sqlStatement, $bindParams = null, $bindTypes = null): ResultInterface | bool` to `query(string $sqlStatement, array $bindParams = [], array $bindTypes = []): ResultInterface | bool`

#### `Phalcon\Db\Adapter\Pdo\Mysql`
- Changed bind type for `Column::TYPE_BIGINT` to be `Column::BIND_PARAM_STR`
- Added bind type for `Column::TYPE_BINARY` to cater for `VARBINARY` and `BINARY` fields
- Added support for comments

#### `Phalcon\Db\Adapter\Pdo\Postgresql`
- Changed bind type for `Column::TYPE_BIGINT` to be `Column::BIND_PARAM_STR`
- Added support for comments

#### `Phalcon\Db\Adapter\AbstractAdapter`
- Changed property `connectionId` to `int`
- Added property `realSqlStatement` to store the real SQL statement executed
- Changed `delete($table, $whereCondition = null, $placeholders = null, $dataTypes = null): bool` to `delete($table, string $whereCondition = null, array $placeholders = [], array $dataTypes = []): bool`
- Changed `fetchAll(string $sqlQuery, int $fetchMode = Enum::FETCH_ASSOC, $bindParams = null, $bindTypes = null): array` to `fetchAll(string $sqlQuery, int $fetchMode = Enum::FETCH_ASSOC, array $bindParams = [], array $bindTypes = []): array`
- Changed `fetchOne(string $sqlQuery, $fetchMode = Enum::FETCH_ASSOC, $bindParams = null, $bindTypes = null): array` to `fetchOne(string $sqlQuery, $fetchMode = Enum::FETCH_ASSOC, array $bindParams = [], array $bindTypes = []): array`
- Changed `getEventsManager(): ManagerInterface` to `getEventsManager(): ManagerInterface | null`
- Added `getSQLVariables(): array` to return the SQL variables used
- Added `supportsDefaultValue(): bool` to allow checking for adapters that support the `DEFAULT` keyword

#### `Phalcon\Db\Adapter\AdapterInterface`
- Changed `close(): bool` to `close(): void`
- Changed `connect(array $descriptor = null): bool` to `connect(array $descriptor = []): void`
- Changed `delete($table, $whereCondition = null, $placeholders = null, $dataTypes = null): bool` to `delete($table, string $whereCondition = null, array $placeholders = [], array $dataTypes = []): bool`
- Changed `execute(string $sqlStatement, $placeholders = null, $dataTypes = null): bool` to `execute(string $sqlStatement, array $bindParams = [], array $bindTypes = []): bool`
- Changed `fetchAll(string $sqlQuery, int $fetchMode = 2, $placeholders = null): array` to `fetchAll(string $sqlQuery, int $fetchMode = 2, array $bindParams = [], array $bindTypes = []): array`
- Changed `fetchOne(string $sqlQuery, int $fetchMode = 2, $placeholders = null): array;` to `fetchOne(string $sqlQuery, int $fetchMode = 2, array $bindParams = [], array $bindTypes = []): array`
- Added `getDefaultValue(): RawValue`
- Changed `getInternalHandler(): \PDO` to `getInternalHandler(): mixed`
- Changed `lastInsertId($sequenceName = null): int | bool` to `lastInsertId(string $name = null) -> string | bool`
- Changed `query(string $sqlStatement, $bindParams = null, $bindTypes = null): ResultInterface | bool` to `query(string $sqlStatement, array $bindParams = [], array $bindTypes = []): ResultInterface | bool`
- Added `supportsDefaultValue(): bool`

#### `Phalcon\Db\Adapter\PdoFactory`
- Added `getExceptionClass()` to return the exception class for the factory
- Renamed `getAdapters()` to `getServices()`

#### `Phalcon\Db\Dialect\*`
- Added support for comments
- Added support for `SMALLINT` for Postgresql

#### `Phalcon\Db\Result\ResultPdo`
- Renamed `Phalcon\Db\Result\Pdo` to `Phalcon\Db\Result\ResultPdo`

#### `Phalcon\Db\Column`
- Added support for comments
- Added `TYPE_BINARY` constant
- Added `TYPE_VARBINARY` constant
- Added `getComment(): string | null`

#### `Phalcon\Db\DialectInterface`
- Changed `getSqlExpression(array $expression, string $escapeChar = null, $bindCounts = null): string;` to `getSqlExpression(array $expression, string $escapeChar = null, array $bindCounts = []): string`

#### `Phalcon\Db\Dialect`
- Changed `getColumnList(array $columnList, string $escapeChar = null, $bindCounts = null): string` to `getColumnList(array $columnList, string $escapeChar = null, array $bindCounts = []): string`
- Changed `getSqlColumn($column, string $escapeChar = null, $bindCounts = null): string` to `getSqlColumn($column, string $escapeChar = null, array $bindCounts = []): string`
- Changed `getSqlExpression(array $expression, string $escapeChar = null, $bindCounts = null): string;` to `getSqlExpression(array $expression, string $escapeChar = null, array $bindCounts = []): string`

#### `Phalcon\Db\Exception`
- Changed `Phalcon\Db\Exception` to extend `\Exception`

#### `Phalcon\Db\Profiler`
- Changed `Phalcon\Db\Profiler` to use `hrtime()` internally to calculate metrics

#### `Phalcon\Db\ResultInterface`
- Changed `dataSeek(long $number)` to `dataseek(int $number)`

---

### Debug

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](support-debug)

The [Debug](support-debug) component has been moved to the `Support` namespace. [more](#support)

---

### Di

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](di)

The [Di](di) component has been moved to the `Di` namespace.

#### `Phalcon\Di\Di`
- Moved `Phalcon\Di` to `Phalcon\Di\Di`
- The `tag` service now returns an instance of `Phalcon\Html\TagFactory`
- The (new) `helper` service returns an instance of `Phalcon\Support\HelperFactory`

---

### Dispatcher

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](dispatcher)

#### `Phalcon\Dispatcher\AbstractDispatcher`
- Changed `getEventsManager(): ManagerInterface` to `getEventsManager(): ManagerInterface | null`

#### `Phalcon\Dispatcher\Exception`
- Changed `Phalcon\Dispatcher\Exception` to extend `\Exception`

---

### Domain

![](/assets/images/status-no-changes-blue.svg) [![](/assets/images/status-docs.svg)](domain)

---

### Encryption

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](encryption-crypt)

#### `Phalcon\Encryption\Crypt`
- Moved `Phalcon\Crypt` to `Phalcon\Encryption\Crypt`
- Two new constants introduced `DEFAULT_ALGORITHM = "sha256"` and `DEFAULT_CIPHER = "aes-256-cfb"`
- The `__construct` now sets `useSigning` as `true` (previously `false`)
- The `__construct` accepts a third parameter (`null` by default), which is a `Phalcon\Encryption\Crypt\PadFactory`

```php 
use Phalcon\Encryption\Crypt;
use Phalcon\Encryption\Crypt\PadFactory;

$padFactory = new PadFactory();
$crypt      = new Crypt("aes-256-cfb", true, $padFactory);
```

If no `padFactory` is passed, a new one will be created in the component.

- `Phalcon\Encryption\Crypt::getAvailableHashAlgos()` was renamed to `Phalcon\Encryption\Crypt::getAvailableHashAlgorithms()`
- `Phalcon\Encryption\Crypt::getHashAlgo()` was renamed to `Phalcon\Encryption\Crypt::getHashAlgorithm()`
- `Phalcon\Encryption\Crypt::setHashAlgo()` was renamed to `Phalcon\Encryption\Crypt::setHashAlgorithm()`

#### `Phalcon\Encryption\Crypt\CryptInterface`
- Moved `Phalcon\Crypt\CryptInterface` to `Phalcon\Encryption\Crypt\CryptInterface`
- Changed `Phalcon\Encryption\Crypt\CryptInterface::decryptBase64()` to accept a `string` variable as the `key`
- Changed `Phalcon\Encryption\Crypt\CryptInterface::encryptBase64()` to accept a `string` variable as the `key`
- Added `Phalcon\Encryption\Crypt\CryptInterface::useSigning(bool useSigning)`

#### `Phalcon\Encryption\Crypt\Exception\Exception`
- Moved `Phalcon\Crypt\Exception` to `Phalcon\Encryption\Crypt\Exception\Exception`

#### `Phalcon\Encryption\Crypt\Exception\Mismatch`
- Moved `Phalcon\Crypt\Mismatch` to `Phalcon\Encryption\Crypt\Exception\Mismatch`

#### `Phalcon\Encryption\Crypt`
- Moved from `Phalcon\Crypt`

#### `Phalcon\Encryption\PadFactory`
- Added `Phalcon\Encryption\PadFactory` to allow for different padding schemes during encryption and decryption of data

#### `Phalcon\Encryption\Padding\*`
- Added `Phalcon\Encryption\Padding\PadInterface` to allow for custom padding classes
- Added `Phalcon\Encryption\Padding\Ansi`
- Added `Phalcon\Encryption\Padding\Iso10126`
- Added `Phalcon\Encryption\Padding\IsoIek`
- Added `Phalcon\Encryption\Padding\Noop`
- Added `Phalcon\Encryption\Padding\Pkcs7`
- Added `Phalcon\Encryption\Padding\Space`
- Added `Phalcon\Encryption\Padding\Zero`

---

### Escaper

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](html-escaper)

The [Escaper](html-escaper) component has been moved to the `Html` namespace. [more](#html)

---

### Events

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](events)

#### `Phalcon\Events\AbstractEventsAware`
- Added abstract `Phalcon\Events\AbstractEventsAware`

#### `Phalcon\Events\Event`
- Changed `public function __construct(string $type, object $source, $data = null, bool $cancelable = true)` to `__construct(string $type, $source = null, $data = null, bool $cancelable = true)` (`$source` is now nullable)

#### `Phalcon\Events\Exception`
- Changed `Phalcon\Events\Exception` to extend `\Exception`

#### `Phalcon\Events\Manager`
- Added `isValidHandler(): bool` to return if the internal handler is valid or not

---

### Exception

![](/assets/images/status-changes-required-red.svg)

#### `Phalcon\Exception`
The class has been removed.

---

### Factory

![](/assets/images/status-changes-required-red.svg)

#### `Phalcon\Factory\AbstractConfigFactory`
- Added abstract `Phalcon\Factory\AbstractConfigFactory` to check configuration elements

#### `Phalcon\Factory\AbstractFactory`
- Changed `init()` to read from `getServices()`

#### `Phalcon\Factory\Exception`
- Changed `Phalcon\Factory\Exception` to extend `\Exception`

---

### Filter

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](filter-filter)

The [Filter](filter-filter) component has been moved to the `Filter` namespace.

#### `Phalcon\Filter\Filter`
- Moved `Phalcon\Filter` to `Phalcon\Filter\Filter`

#### `Phalcon\Filter\Exception`
- Changed `Phalcon\Filter\Exception` to extend `\Exception`

#### `Phalcon\Filter\Factory`
- Changed `getAdapters()` to `getServices()`

#### `Phalcon\Filter\Filter`
- Added `__call()` to allow using filter names as methods i.e. `$filter->upper($input)`

#### `Phalcon\Filter\Validation`
- Added `getValueByEntity()` and `getValueByData()` for more options to retrieve data

#### `Phalcon\Filter\Validation\Validator\Exception`
- Changed `Phalcon\Filter\Validation\Validator\Exception` to extend `\Exception`

#### `AbstractValidator.zep`
- Added the ability to define `allowEmpty` to any validator (in the parameters)

#### `Phalcon\Filter\Validation\Exception`
- Changed `Phalcon\Filter\Validation\Exception` to extend `\Exception`

#### `Phalcon\Filter\Validation\ValidationInterface`
- Changed `add(string $field, ValidatorInterface $validator): <ValidationInterface` to `add($field, ValidatorInterface $validator): <ValidationInterface`
- Changed `rule(string $field, ValidatorInterface $validator): <ValidationInterface` to `rule($field, ValidatorInterface $validator): <ValidationInterface`

#### `Phalcon\Filter\Validation\ValidatorFactory`
- Changed `getAdapters()` to `getServices()`

---

### Flash

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](flash)

#### `Phalcon\Flash\AbstractFlash`
- Added the ability to define CSS icon classes (`setCssIconClasses()`)
- Changed `getTemplate(string $cssClasses): string` to `getTemplate(string $cssClasses, string $cssIconClasses): string`

#### `Phalcon\Flash\Exception`
- Changed `Phalcon\Flash\Exception` to extend `\Exception`

#### `Phalcon\Flash\Session`
- Added `SESSION_KEY` constant
- Changed `has($type = null): bool` to `has(string $type = null): bool`
- Changed `message(string $type, string $message): string | null` to `message(string $type, $message): string | null`

---

### Forms

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](forms)

`Phalcon\Forms\Element\*` classes now use the new `Phalcon\Html\TagFactory` to generate HTML code. As a result, the functionality has changed slightly. The main difference is that a `Phalcon\Html\TagFactory` has to be set in the form object, so that elements can be rendered. If the `Phalcon\Html\TagFactory` is not set, then the component will search the Di container (`Phalcon\Di\DiInterface`) for a service with the name `tag`. If you are using `Phalcon\Di\FactoryDefault` as your container, then the `tag` service is already defined for you.

#### `Phalcon\Forms\Element\AbstractElement`
- Added `getTagFactory()` to return the `Phalcon\Html\TagFactory` object used internally, as well as `setTagFactory(TagFactory $tagFactory): AbstractElement` to set it.

#### `Phalcon\Forms\Element\Check`
#### `Phalcon\Forms\Element\Radio`
- The classes now use the `Phalcon\Html\Helper\Input\Checkbox` and `Phalcon\Html\Helper\Input\Radio` respectively. The classes use `checked` and `unchecked` parameters to set the state of each control. If the `checked` parameter is identical to the `$value` then the control will be checked. If the `unchecked` parameter is present, it will be set if the `$value` is not the same as the `checked` parameter. [more](html-tagfactory)

---

### Helper

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](support-helper)

The [Helper](support-helper) component has been moved to the `Support` namespace. [more](#support)

---

### Html

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](html)

#### `Phalcon\Html\Escaper`
- Moved `Phalcon\Escaper` to `Phalcon\Html\Escaper`
- Changed the `flags` property that controls the flags for `htmlspecialchars()` is set to `11` which corresponds to `ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401`.
- Method names changed to be more verbose.
  - Added `attributes(string input)` for escaping HTML attributes (replaces `escapeHtmlAttr()`)
  - Added `css(string $input)` for escaping CSS (replaces `escapeCss()`
  - Added `html(string $input = null)` for escaping HTML (replaces `escapeHtml()`)
  - Added `js(string $input)` for escaping JS (replaces `escapeJs()`)
  - Added `setFlags(int $flags)` to set the flags `htmlspecialchars()` (replaces `setHtmlQuoteType()`)
  - Added `url(string $input)` for escaping URL strings (replaces `escapeUrl()`)
  - `escapeCss()` now raises a deprecated warning
  - `escapeJs()` now raises a deprecated warning
  - `escapeHtml()` now raises a deprecated warning
  - `escapeUrl()` now raises a deprecated warning
  - `setHtmlQuoteType()` now raises a deprecated warning

#### `Phalcon\Html\Escaper\EscaperInterface`
- Moved `Phalcon\Escaper\EscaperInterface` to `Phalcon\Html\Escaper\EscaperInterface`
- Added `attributes(string input)`
- Added `css(string $input)`
- Added `html(string $input = null)`
- Added `js(string $input)`
- Added `setFlags(int $flags)`
- Added `url(string $input)`
- Removed `escapeCss()`
- Removed `escapeJs()`
- Removed `escapeHtml()`
- Removed `escapeUrl()`
- Removed `setHtmlQuoteType()`

#### `Phalcon\Html\Escaper\Exception`
- This class has been moved to this namespace `Phalcon\Escaper`.
- Changed `Phalcon\Html\Escaper\Exception` to extend `\Exception`

#### `Phalcon\Html\Helper`
- Moved `Phalcon\Helper` to `Phalcon\Html\Helper`
- The component has been refactored and offers more functionality now. [more](html-tagfactory)

#### `Phalcon\Html\Link`
- The component has been refactored and the dependency to `PSR` has been removed. [more](html-link)

#### `Phalcon\Html\TagFactory`
- Added `__call(string $name, array $arguments)` to allow calling helper objects as methods. [more](html-tagfactory)
- Added `has(string $name) -> bool` Added `set(string $name, mixed $method): void`
- The `getAdapters()` protected method has been renamed to `getServices()`
- A new protected method `getExceptionClass()` was introduced to return the exception class to throw from this factory when necessary

#### `Phalcon\Html\Exception`
- Changed `Phalcon\Html\Exception` to extend `\Exception`

---

### Http

![](/assets/images/status-changes-required-red.svg)

#### `Phalcon\Http\Cookie`
- Changed `__construct()` and made `$httpOnly = false`

#### `Phalcon\Http\Cookie\Escaper`
- Changed `Phalcon\Http\Request\Exception` to extend `\Exception`

#### `Phalcon\Http\Message`
- The namespace has been removed

#### `Phalcon\Http\Request`
- Added `getPreferredIsoLocaleVariant(): string` to return the preferred ISO locale variant.

#### `Phalcon\Http\Request\Exception`
- Changed `Phalcon\Http\Cookie\Exception` to extend `\Exception`

#### `Phalcon\Http\Response\Cookie`
- Added `isSent(): bool` to return if the cookie has been sent or not

#### `Phalcon\Http\Response\Headers`
- Added `isSent(): bool` to return if the headers have been sent or not

#### `Phalcon\Http\Response\Exception`
- Changed `Phalcon\Http\Response\Exception` to extend `\Exception`

#### `Phalcon\Http\Server`
- The namespace has been removed

---

### Image

![](/assets/images/status-no-changes-blue.svg) [![](/assets/images/status-docs.svg)](datamapper)

---

### Loader

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](autoload)

The class has been moved to the `Phalcon\Autoload` namespace [more](#autoload)

---

### Logger

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](logger)

The [Logger](logger) component has been moved to the `Logger` namespace.

#### `Phalcon\Logger\Logger`
- Moved `Phalcon\Logger` to `Phalcon\Logger\Logger`
- The component has been refactored and the dependency to `PSR` has been removed. [more](logger)
- The interface method calls are much stricter now.

#### `Phalcon\Logger\AbstractLogger`
- Added `Phalcon\Logger\AbstractLogger` with common functionality, to be used by packages that wish to alter interfaces to the logger while keeping the same functionality (see [proxy-psr3][proxy-psr3])

#### `Phalcon\Logger\Adapter\Stream`
- Failing to write to the file will throw a `LogicException` instead of `UnexpectedValueException`

#### `Phalcon\Logger\Formatter\FormatterInterface`
- Changed `process(Item $item): string` (previously it returned `array|string`)

#### `Phalcon\Logger\Formatter\Json`
- Changed `format()` to encode JSON with the following options by default: `JSON_HEX_TAG`, `JSON_HEX_APOS`, `JSON_HEX_AMP`, `JSON_HEX_QUOT`, `JSON_UNESCAPED_SLASHES`, `JSON_THROW_ON_ERROR`,

#### `Phalcon\Logger\AdapterFactory`
- The constructor now requires a `Phalcon\Storage\SerializerFactory` to be passed as the first parameter
- The `getAdapters()` protected method has been renamed to `getServices()`
- A new protected method `getExceptionClass()` was introduced to return the exception class to throw from this factory when necessary

#### `Phalcon\Logger\Exception`
- Changed `Phalcon\Logger\Exception` to extend `\Exception`

#### `Phalcon\Logger\Item`
- Changed `__construct(string $message, string $levelName, int $level, DateTimeImmutable $dateTime, array $context = [])` (`dateTtime` accepts a `DateTimeImmutable` object)

#### `Phalcon\Logger\LoggerInterface`
- A new interface has been introduced (`Phalcon\Logger\LoggerInterface`) to offer more flexibility when extending the cache object.

---

### Messages

![](/assets/images/status-changes-required-red.svg)

#### `Phalcon\Messages\Exception`
- Changed `Phalcon\Messages\Exception` to extend `\Exception`

---

### Mvc

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](mvc)

#### `Phalcon\Mvc\Micro\Collection`
- Changed the methods to accept a `callable` as the `$handler` instead of mixed
  - `delete(string $routePattern, callable $handler, string $name = null)`
  - `get(string $routePattern, callable $handler, string $name = null)`
  - `head(string $routePattern, callable $handler, string $name = null)`
  - `map(string $routePattern, callable $handler, string $name = null)`
  - `mapVia(string $routePattern, callable $handler, mixed $method, string $name = null)`
  - `options(string $routePattern, callable $handler, string $name = null)`
  - `patch(string $routePattern, callable $handler, string $name = null)`
  - `post(string $routePattern, callable $handler, string $name = null)`
  - `put(string $routePattern, callable $handler, string $name = null)`

#### `Phalcon\Mvc\Micro\Exception`
- Changed `Phalcon\Mvc\Micro\Exception` to extend `\Exception`

#### `Phalcon\Mvc\Model\MetaData\Strategy\Annotations`
- `Phalcon\Mvc\Model\MetaData\Strategy\Annotations::getMetaData()` will now return a string instead of an integer when encountering `BIGINT` fields

#### `Phalcon\Mvc\Model\MetaData\Stream`
- Changed the constructor to accept an array `__construct(array $options = [])`

#### `Phalcon\Mvc\Model\Query\BuilderInterface`
- Corrected `having()` signature `having(string $conditions, array $bindParams = [], array $bindTypes = [])`
- Changed `orderBy()` to accept an array or a string `orderBy(array | string $orderBy)`

#### `Phalcon\Mvc\Model\Resultset\Complex`
- Changed `current()` to return `mixed`
- Added `__serialize()` and `__unserialize()` methods

#### `Phalcon\Mvc\Model\Resultset\Simple`
- Changed the constructor to accept `mixed` for `$cache` : `__construct(mixed $columnMap, mixed $model, mixed $result, mixed $cache = null, bool $keepSnapshots = false)`
- Added `__serialize()` and `__unserialize()` methods

#### `Phalcon\Mvc\Model\CriteriaInterface`
- Corrected `where()` signature `where(string $conditions, mixed $bindParams = null, mixed $bindTypes = null)`

#### `Phalcon\Mvc\Model\Exception`
- Changed `Phalcon\Mvc\Model\Exception` to extend `\Exception`

#### `Phalcon\Mvc\Model\ManagerInterface`
- Changed `$options` parameter to be an array:
    - `addBelongsTo(ModelInterface $model, mixed $fields, string $referencedModel, mixed $referencedFields, array options = []): RelationInterface`
    - `addHasMany(ModelInterface $model, mixed $fields, string $referencedModel, mixed $referencedFields, array options = []): RelationInterface`
    - `addHasOne(ModelInterface $model, mixed $fields, string $referencedModel, mixed $referencedFields, array options = []): RelationInterface`
    - `addHasOneThrough(ModelInterface $model, mixed $fields, string $intermediateModel, mixed $intermediateFields, mixed $intermediateReferencedFields, string $referencedModel, mixed $referencedFields, array options = []): RelationInterface`
    - `addHasManyToMany(ModelInterface $model, mixed $fields, string $intermediateModel, mixed $intermediateFields, mixed $intermediateReferencedFields, string $referencedModel, mixed $referencedFields, array options = []): RelationInterface`
- Changed `getModelSchema(ModelInterface $model)` to return `string` or `null`
- Renamed:
    - `existsBelongsTo()` to `hasBelongsTo()`
    - `existsMany()` to `hasHasMany()`
    - `existsOne()` to `hasHasOne()`
    - `existsOneThrough()` to `hasHasOneThrough()`
    - `existsManyToMany()` to `hasHasManyToMany()`

#### `Phalcon\Mvc\Model\Manager`
- Changed `getEventsManager()` to return `EventManagerInterface` or `null`
- Changed `getModelSchema(ModelInterface $model)` to return `string` or `null`
- Changed `$options` parameter to be an array:
  - `addBelongsTo(ModelInterface $model, mixed $fields, string $referencedModel, mixed $referencedFields, array options = []): RelationInterface`
  - `addHasMany(ModelInterface $model, mixed $fields, string $referencedModel, mixed $referencedFields, array options = []): RelationInterface`
  - `addHasOne(ModelInterface $model, mixed $fields, string $referencedModel, mixed $referencedFields, array options = []): RelationInterface`
  - `addHasOneThrough(ModelInterface $model, mixed $fields, string $intermediateModel, mixed $intermediateFields, mixed $intermediateReferencedFields, string $referencedModel, mixed $referencedFields, array options = []): RelationInterface`
  - `addHasManyToMany(ModelInterface $model, mixed $fields, string $intermediateModel, mixed $intermediateFields, mixed $intermediateReferencedFields, string $referencedModel, mixed $referencedFields, array options = []): RelationInterface`
- Marked as `@deprecated`:
  - `existsBelongsTo()`
  - `existsMany()`
  - `existsOne()`
  - `existsOneThrough()`
  - `existsManyToMany()`
- Added (replacing the `exists*` methods):
  - `hasBelongsTo()`
  - `hasHasMany()`
  - `hasHasOne()`
  - `hasHasOneThrough()`
  - `hasHasManyToMany()`
- Added `getBuilder()` to return the builder that was created with `createBuilder()` (or `null`)

#### `Phalcon\Mvc\Model\ResultsetInterface`
- `getCache()` now returns `null` or an object (`mixed`)

#### `Phalcon\Mvc\Model\Resultset`
- `__construct()` accepts an object in the `$cache` parameter. The object has implement `Phalcon\Cache\CacheInterface` or `Psr\SimpleCache\CacheInterface`
- `getCache()` now returns `null` or an object (`mixed`)

#### `Phalcon\Mvc\Router`
- Changed `add()`,  `addConnect()`, `addDelete()`, `addGet()`, `addHead()`, `addOptions()`, `addPatch()`, `addPost()`, `addPurge()`, `addPut()`, `addTrace()`, `attach()` to accept `int` as `$position`
- Changed `getEventsManager()` to return `ManagerInterface` or `null`

#### `Phalcon\Mvc\RouterInterface`
- Changed `add()`,  `addConnect()`, `addDelete()`, `addGet()`, `addHead()`, `addOptions()`, `addPatch()`, `addPost()`, `addPurge()`, `addPut()`, `addTrace()`, `attach()` to accept `int` as `$position`

#### `Phalcon\Mvc\Router\Exception`
- Changed `Phalcon\Mvc\Router\Exception` to extend `\Exception`

#### `Phalcon\Mvc\Router\RouteInterface`
-  `getHostname()` now returns `string` or `null`
-  `getName()` now returns `string` or `null`

#### `Phalcon\Mvc\Router\Route`
- `beforeMatch(callable $callback): RouteInterface` now accepts a `callable`
-  `getHostname()` now returns `string` or `null`
-  `getName()` now returns `string` or `null`

#### `Phalcon\Mvc\ModelInterface`
- Changed `average(array $parameters = [])` to accept an array
- Changed `cloneResultset()` to default `keepSnapshots = false`
- Changed `findFirst(mixed $parameters = null): mixed | null` to return `null` instead of `false`
- Changed `getSchema(): string | null` to return `string` or `null`

#### `Phalcon\Mvc\View`
- Marked as `@deprecated` `exists()`
- Added `has()` (replacing the `exists()` method)

#### `Phalcon\Mvc\View\Exception`
- Changed `Phalcon\Mvc\View\Exception` to extend `\Exception`

#### `Phalcon\Mvc\View\Engine\Volt\Compiler`
- Removed `compileCache()`

#### `Phalcon\Mvc\Url`
- Moved from `Phalcon\Url`

#### `Phalcon\Mvc\Url\Exception`
- Moved from `Phalcon\Url\Exception`
- Changed `Phalcon\Mvc\Url\Exception` to extend `\Exception`

#### `Phalcon\Mvc\Url\UrlInterface`
- Moved from `Phalcon\Url\UrlInterface`

---

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](pagination)

#### `Phalcon\Paginator\Exception`
- Changed `Phalcon\Paginator\Exception` to extend `\Exception`

#### `Phalcon\Paginator\PaginatorFactory`
- The `getAdapters()` protected method has been renamed to `getServices()`
- A new protected method `getExceptionClass()` was introduced to return the exception class to throw from this factory when necessary

---

### Registry

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](support-registry)

The [Registry](support-registry) component has been moved to the `Support` namespace. [more](#support)

---

### Security

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](encryption-security)

The [Security](encryption-security) component has been moved to the `Encryption` namespace. [more](#encryption)

---

### Session

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](session)

#### `Phalcon\Session\Adapter\AbstractAdapter`
- Changed `gc(int $maxlifetime): int | bool` to accept only `int` for the parameter

#### `Phalcon\Session\Adapter\Noop`
- Changed `gc(int $maxlifetime): int | bool` to accept only `int` for the parameter

#### `Phalcon\Session\Adapter\Stream`
- Changed `__construct()` to throw an exception if the save path is empty

#### `Phalcon\Session\BagInterface`
- Added interface for `Phalcon\Session\Bag`

#### `Phalcon\Session\Exception`
- Changed `Phalcon\Session\Exception` to extend `\Exception`

---

### Storage

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](storage)

#### `Phalcon\Storage\Adapter\AdapterInterface`
- Added `setForever(string $key, mixed $value):` to set an item in the store forever

#### `Phalcon\Storage\Adapter\Apcu`
- Added `setForever(string $key, mixed $value):` to set an item in the store forever

#### `Phalcon\Storage\Adapter\Libmemcached`
- Added `setForever(string $key, mixed $value):` to set an item in the store forever

#### `Phalcon\Storage\Adapter\Memory`
- Added `setForever(string $key, mixed $value):` to set an item in the store forever

#### `Phalcon\Storage\Adapter\Redis`
- Added `setForever(string $key, mixed $value):` to set an item in the store forever
- Added `timeout`, `connectTimeout`, `retryInterval` and `readTimeout` for constructor options

#### `Phalcon\Storage\Adapter\Stream`
- Added `setForever(string $key, mixed $value):` to set an item in the store forever

#### `Phalcon\Storage\Serializer\AbstractSerializer`
- Added `__serialize()` and `__unserialize()` methods
- Added `isSuccess(): bool` to return when the data was serialized/unserialized successfully

#### `Phalcon\Storage\Serializer\Base64`
- Changed `unserialize` to set the data to an empty string in case of a failure

#### `Phalcon\Storage\Serializer\Igbinary`
- Changed `unserialize` to set the data to an empty string in case of a failure

#### `Phalcon\Storage\Serializer\Msgpack`
- Changed `unserialize` to set the data to an empty string in case of a failure

#### `Phalcon\Storage\Serializer\Php`
- Changed `unserialize` to set the data to an empty string in case of a failure

#### `Phalcon\Storage\Serializer\*`
- Added stub serializers for Memcached and Redis when in need to use the built-in serializers for those storages:
  - `Phalcon\Storage\Serializer\MemcachedIgbinary`
  - `Phalcon\Storage\Serializer\MemcachedJson`
  - `Phalcon\Storage\Serializer\MemcachedPhp`
  - `Phalcon\Storage\Serializer\RedisIgbinary`
  - `Phalcon\Storage\Serializer\RedisJson`
  - `Phalcon\Storage\Serializer\RedisMsgpack`
  - `Phalcon\Storage\Serializer\RedisNone`
  - `Phalcon\Storage\Serializer\RedisPhp`

#### `Phalcon\Storage\Exception`
- Changed `Phalcon\Storage\Exception` to extend `\Exception`

#### `Phalcon\Storage\AdapterFactory`
- The `getAdapters()` protected method has been renamed to `getServices()`
- A new protected method `getExceptionClass()` was introduced to return the exception class to throw from this factory when necessary

#### `Phalcon\Storage\SerializerFactory`
- The `getAdapters()` protected method has been renamed to `getServices()`
- A new protected method `getExceptionClass()` was introduced to return the exception class to throw from this factory when necessary

---

### Support

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](support-collection)

The `Support` namespace contains classes that are used throughout the framework. The classes moved here are:
- [Collection](support-collection)
- [Debug](support-debug)
- [Helper](support-helper)
- [Registry](support-registry)

#### `Phalcon\Support\Collection`
- Moved `Phalcon\Collection` to `Phalcon\Support\Collection`
- `get()` will return the `defaultValue` if the `key` is not set. It will also return the `defaultValue` if the `key` is set and the value is `null`. This aligns with the 3.x behavior.

#### `Phalcon\Support\Collection\CollectionInterface`
- A new interface has been introduced (`Phalcon\Support\Collection\CollectionInterface`) to offer more flexibility when extending the collection object.

#### `Phalcon\Support\Collection\ReadOnlyCollection`
- This class has been renamed from `ReadOnly` in order to avoid collisions with PHP 8.x reserved words.

#### `Phalcon\Support\Debug\Exception`
- Changed `Phalcon\Support\Debug\Exception` to extend `\Exception`

#### `Phalcon\Support\Helper\Exception`
- Changed `Phalcon\Support\Helper\Exception` to extend `\Exception`

#### `Phalcon\Helper\*`
- `Arr`, `Fs`, `Json`, `Number` and `Str` static classes have been removed and replaced with one class per method in the relevant namespace. For example `Phalcon\Helper\Arr::has()` is not `Phalcon\Support\Helper\Arr\Has::__invoke()`
- Added `Phalcon\Support\Helper\HelperFactory` service locator to easily create objects from the `Phalcon\Support\Helper` namespace
- Added `__call()` in `Phalcon\Support\Helper\HelperFactory` to offer an easier access to objects i.e. `$this->helperFactory->dirFromFile()`

---

### Tag

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](tag)

Note, this component will be removed in future versions of the framework.

#### `Phalcon\Tag`
- Added `preload(mixed $parameters): string` to parse preloading link headers

---

### Text

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](support-helper)

The `Phalcon\Text` component has been deprecated. It has been replaced with the `Phalcon\Support\HelperFactory`. [more](#support)

---

### Translate

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](translate)

#### `Phalcon\Translate\Adapter\AbstractAdapter`
- Changed `__construct(InterpolatorFactory $interpolator, array $options = []` to default to an empty array for `$options`

#### `Phalcon\Translate\Adapter\Csv`
- Marked as `@deprecated` `exists()`
- Added `has()`

#### `Phalcon\Translate\Adapter\Gettext`
- Marked as `@deprecated` `exists()`
- Added `has()`

#### `Phalcon\Translate\Adapter\NativeArray`
- Marked as `@deprecated` `exists()`
- Added `has()`
- Added `toArray()` to return the translation array back

#### `Phalcon\Translate\Exception`
- Changed `Phalcon\Translate\Exception` to extend `\Exception`

#### `Phalcon\Translate\InterpolatorFactory`
- The `getAdapters()` protected method has been renamed to `getServices()`
- A new protected method `getExceptionClass()` was introduced to return the exception class to throw from this factory when necessary

#### `Phalcon\Translate\TranslateFactory`
- The `getAdapters()` protected method has been renamed to `getServices()`
- A new protected method `getExceptionClass()` was introduced to return the exception class to throw from this factory when necessary

---

### Url

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](mvc-url)

The [Url](mvc-url) component has been moved to the `Mvc` namespace. [more](#mvc)

---

### Validation

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](filter-validation)

The [Validation](filter-validation) component has been moved to the `Filter` namespace. [more](#filter)

---

### Version

![](/assets/images/status-changes-required-red.svg) [![](/assets/images/status-docs.svg)](support-version)

The [Version](support-version) component has been moved to the `Support` namespace. [more](#support)


[php-support]: https://www.php.net/supported-versions.php
[proxy-psr3]: https://github.com/phalcon/proxy-psr3
[zephir-phar]: https://github.com/phalcon/zephir/releases
