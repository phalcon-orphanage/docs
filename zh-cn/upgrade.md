---
layout: default
language: 'zh-cn'
version: '5.0'
title: 'Upgrade Guide'
keywords: 'upgrade, v3, v4, v5'
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

One of the biggest changes with this release is that we no longer have top level classes. All top level classes have been moved into relevant namespaces (with the exception of `Phalcon\Tag`). For instance `Phalcon\Loader` has been moved to `Phalcon\Autoload\Loader`. This change was necessary for the future expansion of the project.

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

---

### Annotations

> Status: **no changes**
> 
> Usage: [Annotations Documentation](annotations) 
> 
> {: .alert .alert-info }

---

### Application

> Status: **no changes**
> 
> Usage: [Application Documentation](application) 
> 
> {: .alert .alert-info }

The `getEventsManager()` now returns a `Phalcon\Events\ManagerInterface` or `null`

---

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

---

### Autoload

> Status: **changes required**
> 
> Usage: [Autoload Documentation](autoload-loader) 
> 
> {: .alert .alert-warning }

The [Autoload\Loader](autoload-loader) component has been moved from the parent namespace. Some method names have been changed and new functionality introduced.

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

---

### Cli

> Status: **no changes**
> 
> Usage: [Cli Documentation](application-cli) 
> 
> {: .alert .alert-info }

---

### Collection

> Status: **changes required**
> 
> Usage: [Collection Documentation](support-collection) 
> 
> {: .alert .alert-warning }

The [Collection](support-collection) component has been moved to the `Support` namespace. [more](#support)

---

### Config

> Status: **changes required**
> 
> Usage: [Config Documentation](config) 
> 
> {: .alert .alert-warning }

The [Config](config) component has been moved to the `Config` namespace.

#### `Phalcon\Config\Config`
- Moved `Phalcon\Config` to `Phalcon\Config\Config`

#### `Phalcon\Config\ConfigInterface`
- A new interface has been introduced (`Phalcon\Config\ConfigInterface`) to offer more flexibility when extending the config object.

---

### Container

> Status: **changes required**
> 
> Usage: [Container Documentation](container) 
> 
> {: .alert .alert-warning }

The [Container](collection) component has been moved to the `Container` namespace.

#### `Phalcon\Container\Container`
- Moved `Phalcon\Container` to `Phalcon\Container\Container`

---

### Crypt

> Status: **changes required**
> 
> Usage: [Crypt Documentation](encryption-crypt) 
> 
> {: .alert .alert-warning }

The [Crypt](encryption-crypt) component has been moved to the `Encryption` namespace. [more](#encryption-crypt)

---

### DataMapper

> Status: **no changes**
> 
> Usage: [DataMapper Documentation](datamapper) 
> 
> {: .alert .alert-info }

---

Db

> Status: **changes required**
> 
> Usage: [Db Documentation](db-layer) 
> 
> {: .alert .alert-warning }

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

#### `Phalcon\Db\Adapter\Pdo\Mysql`
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

> Status: **changes required**
> 
> Usage: [Debug Documentation](support-debug) 
> 
> {: .alert .alert-warning }

The [Debug](support-debug) component has been moved to the `Support` namespace. [more](#support)

---

### Di

> Status: **changes required**
> 
> Usage: [Di Documentation](di) 
> 
> {: .alert .alert-warning }

The [Di](di) component has been moved to the `Di` namespace.

#### `Phalcon\Di\Di`
- Moved `Phalcon\Di` to `Phalcon\Di\Di`
- The `tag` service now returns an instance of `Phalcon\Html\TagFactory`
- The (new) `helper` service returns an instance of `Phalcon\Support\HelperFactory`

---

### Dispatcher

> Status: **no changes**
> 
> Usage: [Dispatcher Documentation](dispatcher) 
> 
> {: .alert .alert-info }

### `Phalcon\Dispatcher\AbstractDispatcher`
- Changed `getEventsManager(): ManagerInterface` to `getEventsManager(): ManagerInterface | null`

#### `Phalcon\Dispatcher\Exception`
- Changed `Phalcon\Dispatcher\Exception` to extend `\Exception`

---

### Domain

> Status: **no changes**
> 
> Usage: [Domain Documentation](domain) 
> 
> {: .alert .alert-info }

---

### Encryption

> Status: **changes required**
> 
> Usage: [Crypt Documentation](encryption-crypt), [Security Documentation](encryption-security). [JWT Documentation](encryption-security-jwt) 
> 
> {: .alert .alert-warning }

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

### `Phalcon\Encryption\PadFactory`
- Added `Phalcon\Encryption\PadFactory` to allow for different padding schemes during encryption and decryption of data

### `Phalcon\Encryption\Padding\*`
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

> Status: **changes required**
> 
> Usage: [Escaper Documentation](html-escaper) 
> 
> {: .alert .alert-warning }

The [Escaper](html-escaper) component has been moved to the `Html` namespace. [more](#html)

---

### Events

> Status: **changes required**
> 
> Usage: [Escaper Documentation](html-escaper) 
> 
> {: .alert .alert-warning }

#### `Phalcon\Events\AbstractEventsAware`
- Added abstract `Phalcon\Events\AbstractEventsAware`

#### `Phalcon\Events\Event`
- Changed `public function __construct(string $type, object $source, $data = null, bool $cancelable = true)` to `__construct(string $type, $source = null, $data = null, bool $cancelable = true)` (`$source` is now nullable)

#### `Phalcon\Events\Exception`
- Changed `Phalcon\Events\Exception` to extend `\Exception`

#### `Phalcon\Events\Manager`
- Added `isValidHandler(): bool` to return if the internal handler is valid or not

---

### 工厂

> Status: **changes required**
> 
> {: .alert .alert-warning }


#### `Phalcon\Factory\AbstractConfigFactory`
- Added abstract `Phalcon\Factory\AbstractConfigFactory` to check configuration elements

#### `Phalcon\Factory\AbstractFactory`
- Changed `init()` to read from `getServices()`

#### `Phalcon\Factory\Exception`
- Changed `Phalcon\Factory\Exception` to extend `\Exception`

---

### Filter

> Status: **changes required**
> 
> Usage: [Filter Documentation](filter-filter), [Validation Documentation](filter-validation) 
> 
> {: .alert .alert-warning }

#### `Phalcon\Filter`
- Moved under the `Filter` namespace

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

> Status: **changes required**
> 
> Usage: [Flash Documentation](flash) 
> 
> {: .alert .alert-warning }

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

_WIP_

Forms Helper Html Http Image Loader Logger Messages Mvc Paginator Security Session Storage Tag Translate Url Validation Cache.zep Collection.zep Config.zep Container.zep Crypt.zep Debug.zep Di.zep Escaper.zep Exception.zep Filter.zep Kernel.zep Loader.zep Logger.zep Registry.zep Security.zep Tag.zep Text.zep Url.zep Validation.zep Version.zep











---

Events

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

工厂

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets) 
> 
> {: .alert .alert-warning }

Filter

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

The [Loader](autoload-loader) component has been moved to the `Autoload` namespace. Some method names have been changed and new functionality introduced.















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

### Collection

> Status: **changes required**
> 
> Usage: [Collection Documentation](support-collection) 
> 
> {: .alert .alert-warning }

The [Collection](support-collection) component has been moved to the `Support` namespace.

#### `Phalcon\Support\Collection`
- Moved `Phalcon\Collection` to `Phalcon\Support\Collection`
- `get()` will return the `defaultValue` if the `key` is not set. It will also return the `defaultValue` if the `key` is set and the value is `null`. This aligns with the 3.x behavior.

#### `Phalcon\Support\Collection\CollectionInterface`
- A new interface has been introduced (`Phalcon\Support\Collection\CollectionInterface`) to offer more flexibility when extending the collection object.

#### `Phalcon\Support\Collection\ReadOnlyCollection`
- This class has been renamed from `ReadOnly` in order to avoid collisions with PHP 8.x reserved words.

---



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
