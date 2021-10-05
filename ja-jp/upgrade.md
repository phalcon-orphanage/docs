---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'アップグレードガイド'
keywords: 'upgrade, v3, v4'
---

# アップグレードガイド

* * *

# V4へのアップグレード

v4にアップグレードすることにしたのですね！ **おめでとうございます**!!

Phalcon v4 には、インターフェイスへの変更、厳格なタイプ、コンポーネントの削除、新しいコンポーネントの追加など、コンポーネントへの多くの変更が含まれています。 このドキュメントは、既存のPhalconアプリケーションをv4にアップグレードするのに役立ちます。 v3と同じようにコードをスムーズに実行できるように、変更を加える必要がある部分を中心に解説します。 変更は重要です。順序通りに作業すれば容易にできます。

## インストール要件

### PHP 7.2

Phalcon v4 は、 PHP 7.2 もしくはそれ以降のバージョンのみをサポートしています。 PHP 7.1 was released 2 years ago and its [active support](https://www.php.net/supported-versions.php) has lapsed, so we decided to follow actively supported PHP versions.

<a name='psr'></a>

### PSR

Phalcon には PSR 拡張機能が必要です。 拡張機能は、[こちら](https://github.com/jbboehr/php-psr) のGitHubリポジトリからダウンロードしてコンパイルできます。 拡張機能のインストール手順は、リポジトリの` README `に記載されています。 拡張機能をコンパイルしてシステムで使用可能になったら、それを` php.ini `でロードする必要があります。 下記のように、1行を追加してください。

```ini
extension=psr.so
```

変更前

```ini
extension=phalcon.so
```

一部のディストリビューションでは、` ini `ファイル名に数字のプレフィックスが追加される場合があります。 その場合は、大きい数値を指定してください(例：` 50-phalcon.ini `)。

### インストール

最新の `zephir.phar` を [からダウンロードする](https://github.com/phalcon/zephir/releases)。 システムからアクセスできるフォルダに追加します。

このリポジトリのクローンを作成

```bash
git clone https://github.com/phalcon/cphalcon
```

Phalconのコンパイル

```bash
cd cphalcon/
git checkout tags/v4.0.0 ./
zephir fullclean
zephir build
```

モジュールをチェック

```bash
php -m | grep phalcon
```

* * *

## 一般的なメモ

### アプリケーション

- `Phalcon\Mvc\Application`, `Phalcon\Mvc\Micro` と `Phalcon\Mvc\Router` はURI 処理を持つ必要があります。

### 例外

- catch `Exception` を `Throwable` に変更

* * *

# コンポーネント

## アクセス制御リスト(ACL)

> Status: **changes required**
> 
> 使用法: [ACL ドキュメント](acl)
{: .alert .alert-info }

[ACL](acl) コンポーネントにはいくつかのメソッドとコンポーネントの名前が変更されています。 機能は以前のバージョンと同じままです。

### 概要

ACL を動作させるために必要なコンポーネントの名前が変更されました。 特に、 `Resource` は、このコンポーネントが使用するすべての関連するインターフェイス、クラス、メソッド内の `Component` に改名されました。

- `Phalcon\Acl\Adapter\AbstractAdapter` を追加しました
- `Acl\Enum` を追加しました

- `Phalcon\Acl` を削除しました

- `Phalcon\Acl\Adapter` を削除しました

- `Phalcon\Acl\Resource` を `Phalcon\Acl\Component` にリネームしました

- `Phalcon\Acl\Resource` を `Phalcon\Acl\Component` にリネームしました
- `Phalcon\Acl\Resource` を `Phalcon\Acl\Component` にリネームしました
- `Phalcon\Acl\AdapterInterface::isResource` を `Phalcon\Acl\AdapterInterface::isComponent` にリネームしました。
- `Phalcon\Acl\AdapterInterface::addResource` を `Phalcon\Acl\AdapterInterface::addComponent` にリネームしました。
- Renamed `Phalcon\Acl\AdapterInterface::addResourceAccess` to `Phalcon\Acl\AdapterInterface::addComponentAccess`
- Renamed `Phalcon\Acl\AdapterInterface::dropResourceAccess` to `Phalcon\Acl\AdapterInterface::dropComponentAccess`
- Renamed `Phalcon\Acl\AdapterInterface::getActiveResource` to `Phalcon\Acl\AdapterInterface::getActiveComponent`
- Renamed `Phalcon\Acl\AdapterInterface::getResources` to `Phalcon\Acl\AdapterInterface::getComponents`
- Renamed `Phalcon\Acl\Adapter::getActiveResource` to `Phalcon\Acl\AdapterInterface::getActiveComponent`
- Renamed `Phalcon\Acl\Adapter\Memory::isResource` to `Phalcon\Acl\Adapter\Memory::isComponent`
- Renamed `Phalcon\Acl\Adapter\Memory::addResource` to `Phalcon\Acl\Adapter\Memory::addComponent`
- Renamed `Phalcon\Acl\Adapter\Memory::addResourceAccess` to `Phalcon\Acl\Adapter\Memory::addComponentAccess`
- Renamed `Phalcon\Acl\Adapter\Memory::dropResourceAccess` to `Phalcon\Acl\Adapter\Memory::dropComponentAccess`
- Renamed `Phalcon\Acl\Adapter\Memory::getResources` to `Phalcon\Acl\Adapter\Memory::getComponents`

### Acl\Adapter\Memory

- Added `getActiveKey`, `activeFunctionCustomArgumentsCount` and `getActiveFunction` to get latest key, number of custom arguments, and function used to acquire access
- Added `addOpertion` support multiple inherited

### Acl\Enum (Constants)

例:

```php
use Phalcon\Acl\Enum;

echo Enum::ALLOW; //prints 1
echo Enum::DENY;  //prints 0

```

* * *

## アセット

> Status: **changes required**
> 
> Usage: [Assets Documentation](assets)
{: .alert .alert-info }

CSS and JS filters have been removed from the [Assets](assets) component. Due to license limitations, the CSS and JS minifiers (filters) have been removed for v4. In future versions with the help of the community we can introduce these filters again. You can always implement your own using the supplied `Phalcon\Assets\FilterInterface`.

- Removed `Phalcon\Assets\Filters\CssMin`
- Removed `Phalcon\Assets\Filters\JsMin`
- Renamed `Phalcon\Assets\Resource` to `Phalcon\Assets\Asset`
- Renamed `Phalcon\Assets\ResourceInterface` to `Phalcon\Assets\AssetInterface`
- Renamed `Phalcon\Assets\Manager::addResource` to `Phalcon\Assets\Manager::addAsset`
- Renamed `Phalcon\Assets\Manager::addResourceByType` to `Phalcon\Assets\Manager::addAssetByType`
- Renamed `Phalcon\Assets\Manager::collectionResourcesByType` to `Phalcon\Assets\Manager::collectionAssetsByType`

* * *

## キャッシュ

> Status: **changes required**
> 
> Usage: [Cache Documentation](cache)
{: .alert .alert-info }

`xcache`, `apc` and `memcache` adapters have been deprecated and removed. The first two are not supported for PHP 7.2+. `apc` has been replaced with `apcu` and `memcache` can be replaced with the `libmemcached` one.

- Removed `Phalcon\Annotations\Adapter\Apc`
- Removed `Phalcon\Annotations\Adapter\Xcache`
- Removed `Phalcon\Cache\Backend\Apc`
- Removed `Phalcon\Cache\Backend\Memcache`
- Removed `Phalcon\Cache\Backend\Xcache`
- Removed `Phalcon\Mvc\Model\Metadata\Apc`
- Removed `Phalcon\Mvc\Model\Metadata\Memcache`
- Removed `Phalcon\Mvc\Model\Metadata\Xcache`

The `Cache` component has been rewritten to comply with [PSR-16](https://www.php-fig.org/psr/psr-16/). This allows you to use the [Phalcon\Cache](api/Phalcon_Cache) to any application that utilizes a [PSR-16](https://www.php-fig.org/psr/psr-16/) cache, not just Phalcon based ones.

In v3, the cache was split into two components, the Frontend and the Backend. This did create a bit of confusion but it was functional. In order to create a cache component you had to create the Frontend first and then inject that to the relevant Backend (which acted as an adapter also).

For v4, we rewrote the component completely. We first created a `Storage` class which is the basis of the Cache classes. We created Serializer classes whose sole responsibility is to serialize and unserialize the data before they are saved in the cache adapter and after they are retrieved. These classes are injected (based on the developer's choice) to an Adapter object which connects to a backend (`Memcached`, `Redis` etc.), while abiding by a common adapter interface.

The Cache class implements [PSR-16](https://www.php-fig.org/psr/psr-16/) and accepts an adapter in its constructor, which in turn is doing all the heavy lifting with connecting to the back end and manipulating data.

For a more detailed explanation on how the new Cache component works, please visit the relevant page in our documentation.

### キャッシュの作成

```php
<?php

use Phalcon\Cache;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Storage\Serializer\SerializerFactory;

$serializerFactory = new SerializerFactory();
$adapterFactory    = new AdapterFactory($serializerFactory);

$options = [
    'defaultSerializer' => 'Json',
    'lifetime'          => 7200
];

$adapter = $adapterFactory->newInstance('apcu', $options);

$cache = new Cache($adapter);
```

DIに登録する

```php
<?php

use Phalcon\Cache;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Storage\Serializer\SerializerFactory;

$container = new Di();

$container->set(
    'cache',
    function () {
        $options = [
            'defaultSerializer' => 'Json',
            'lifetime'          => 7200
        ];

        $adapter = (new AdapterFactory(new SerializerFactory()))
                    ->newInstance('apcu', $options); 

        return new Cache($adapter);
    }
);
```

* * *

## CLI

> Status: **changes required**
> 
> 使用法: [CLIドキュメント](cli)
{: .alert .alert-info }

### パラメータ

パラメータは MVC コントローラと同じように動作するようになりました。 以前は `$params` プロパティにすべて存在していましたが、適切に名前を付けることができます。

```php
use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function testAction(string $yourName, string $myName)
    {
        echo sprintf(
            'Hello %s!' . PHP_EOL,
            $yourName
        );

        echo sprintf(
            'Best regards, %s' . PHP_EOL,
            $myName
        );
    }
}
```

### Cli\Console

- Removed `Phalcon\Cli\Console::addModules` in favor of `Phalcon\Cli\Console::registerModules`

### Cli\Router\RouteInterface

- Added `delimiter`, `getDelimiter`

### Cli\Dispatcher

- Added `getTaskSuffix()`, `setTaskSuffix()`

### Cli\DispatcherInterface

- Added `setOptions`, `getOptions`

* * *

## コンテナ

- Added `Phalcon\Container`, a proxy container class to the `Phalcon\DI` implementing PSR-11

* * *

## デバッグ

- Removed `Phalcon\Debug::getMajorVersion`

* * *

## Db

- 大文字と小文字を区別しない列マップで値を見つけることができる設定`orm.case_insensive_column_map` のグローバル設定 を追加。 `\Phalcon\Mvc\Model::setup()` で `caseInsensiveColumnMap` キーを設定することで有効にすることもできます。
- `Phalcon\Db` 名前空間を削除しました。 `Phalcon\Db\AbstractDb` によって必要なメソッドと `Phalcon\Db\Enum` を定数に置き換えます。

```php
use Phalcon\Db\Enum;

echo Enum::FETCH_ASSOC;
```

### Db\AdapterInterface

- Added `fetchColumn`, `insertAsDict`, `updateAsDict`

### Db\Adapter\Pdo

- Mysqlアダプタにカラムタイプを追加しました。 The adapters support 
    - `TYPE_BIGINTEGER`
    - `TYPE_BIT`
    - `TYPE_BLOB`
    - `TYPE_BOOLEAN`
    - `TYPE_CHAR`
    - `TYPE_DATE`
    - `TYPE_DATETIME`
    - `TYPE_DECIMAL`
    - `TYPE_DOUBLE`
    - `TYPE_ENUM`
    - `TYPE_FLOAT`
    - `TYPE_INTEGER`
    - `TYPE_JSON`
    - `TYPE_JSONB`
    - `TYPE_LONGBLOB`
    - `TYPE_LONGTEXT`
    - `TYPE_MEDIUMBLOB`
    - `TYPE_MEDIUMINTEGER`
    - `TYPE_MEDIUMTEXT`
    - `TYPE_SMALLINTEGER`
    - `TYPE_TEXT`
    - `TYPE_TIME`
    - `TYPE_TIMESTAMP`
    - `TYPE_TINYBLOB`
    - `TYPE_TINYINTEGER`
    - `TYPE_TINYTEXT`
    - `TYPE_VARCHAR` Some adapters do not support certain types. For instance `JSON` is not supported for `Sqlite`. It will be automatically changed to `VARCHAR`.

### Db\DialectInterface

- Added `registerCustomFunction`, `getCustomFunctions`, `getSqlExpression`

### Db\Dialect\Postgresql

- Changed `addPrimaryKey` to make primary key constraints names unique by prefixing them with the table name.

* * *

## DI

### Di\ServiceInterface

- Added `getParameter`, `isResolved`

### Di\Service

- Changed `Phalcon\Di\Service` constructor to no longer takes the name of the service.

* * *

## ディスパッチャー

- `Phalcon\Dispatcher::setModelBinder()` を削除しました `Phalcon\Dispatcher::setModelBinder()`
- `getHandlerSuffix()`, `setHandlerSuffix()` を追加しました。

* * *

## イベント

### Events\ManagerInterface

- Added `hasListeners`

* * *

## Flash

- Flash Messenger にカスタムテンプレートを設定する機能を追加しました。
- コンストラクタは CSS クラスの配列を受け付けなくなりました。 コンポーネントのカスタム CSS クラスを設定するには `setCssClasses()` を使用する必要があります。
- The constructor now accepts an optional `Phalcon\Escaper` object, as well as a `Phalcon\Session\Manager` object (in the case of `Phalcon\Flash\Session`), in case you do not wish to use the DI and set it yourself.

* * *

## Filter

> Status: **changes required**
> 
> Usage: [Filter Documentation](filter)
{: .alert .alert-info }

サービスロケータを利用して、 `Filter` コンポーネントが書き換えられました。 Each sanitizer is now enclosed on its own class and lazy loaded to provide maximum performance and the lowest resource usage as possible.

### 概要

The `Phalcon\Filter` class has been rewritten to act as a service locator for different *sanitizers*. This object allows you to sanitize input as before using the `sanitize()` method.

The values sanitized are automatically cast to the relevant types. This is the default behavior for the `int`, `bool` and `float` filters.

When instantiating the filter object, it does not know about any sanitizers. You have two options:

#### Load All the Default Sanitizers

You can load all the Phalcon supplied sanitizers by utilizing the [Phalcon\Filter\FilterFactory](api/Phalcon_Filter#filter-filterfactory) component.

```php
<?php

use Phalcon\Filter\FilterFactory;

$factory = new FilterFactory();
$locator = $factory->newInstance();
```

Calling`newInstance()` will return a [Phalcon\Filter](api/Phalcon_Filter#filter) object with all the sanitizers registered. The sanitizers are lazy loaded so they are instantiated only when called from the locator.

#### Load Only Sanitizers You Want

You can instantiate the [Phalcon\Filter](api/Phalcon_Filter#filter) component and either use the `set()` method to set all the sanitizers you need, or pass an array in the constructor with the sanitizers you want to register.

### Using the `FactoryDefault`

If you use the [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault) container, then the [Phalcon\Filter](api/Phalcon_Filter#filter) is automatically loaded in the container. You can then continue to use the service in your controllers or components as you did before. The name of the service in the Di is `filter`, just as before.

Also components that utilize the filter service, such as the [Request](api/phalcon_http#http-request) object, transparently use the new filter locator. No additional changes required for those components.

### Using a Custom `Di`

If you have set up all the services in the [Phalcon\Di](api/Phalcon_Di) yourself and need the filter service, you will need to change its registration as follows:

```php
<?php

use Phalcon\Di;
use Phalcon\Filter\FilterFactory;

$container = new Di();

$container->set(
    'filter',
    function () {
        $factory = new FilterFactory();
        return $factory->newInstance();
    }
);
```

> **NOTE**: Note that even if you register the filter service manually, the **name** of the service must be **filter** so that other components can use it
{: .alert .alert-warning }

### 定数

The constants that the v3 `Phalcon\Filter` have somewhat changed.

#### Removed

- `FILTER_INT_CAST` (`int!`)
- `FILTER_FLOAT_CAST` (`float!`)

By default the service sanitizers cast the value to the appropriate type so these are obsolete

- `FILTER_APHANUM` has been removed - replaced by `FILTER_ALNUM`

#### Changed

- `FILTER_SPECIAL_CHARS` has changed been removed - replaced by `FILTER_SPECIAL`
- `FILTER_ALNUM` - replaced `FILTER_ALPHANUM`
- `FILTER_ALPHA` - sanitize only alpha characters
- `FILTER_BOOL` - sanitize boolean including "yes", "no", etc.
- `FILTER_LOWERFIRST` - sanitze using `lcfirst`
- `FILTER_REGEX` - sanitize based on a pattern (`preg_replace`)
- `FILTER_REMOVE` - sanitize by removing characters (`str_replace`)
- `FILTER_REPLACE` - sanitize by replacing characters (`str_replace`)
- `FILTER_SPECIAL` - replaced `FILTER_SPECIAL_CHARS`
- `FILTER_SPECIALFULL` - sanitize special chars (`filter_var`)
- `FILTER_UPPERFIRST` - sanitize using `ucfirst`
- `FILTER_UPPERWORDS` - sanitize using `ucwords`

* * *

## フォーム

### Forms\Form

- `Phalcon\Forms\Form::clear` will no longer call `Phalcon\Forms\Element::clear`, instead it will clear/set default value itself, and `Phalcon\Forms\Element::clear` will now call `Phalcon\Forms\Form::clear` if it’s assigned to the form, otherwise it will just clear itself.
- `Phalcon\Forms\Form::getValue` will now also try to get the value by calling `Tag::getValue` or element’s `getDefault` method before returning `null`, and `Phalcon\Forms\Element::getValue` calls `Tag::getDefault` only if it’s not added to the form.

* * *

## Html

### Html\Breadcrumbs　パンくずリスト

- `Phalcon\Html\Breadcrumbs`を追加。

### Html\Tag

- `Phalcon\Html\Tag`を追加しました。 将来のバージョンで `Phalcon\Tag` を置き換えます。 このコンポーネントは静的メソッド呼び出しを使用しません。

### Http\RequestInterface

- `isSecureRequest` を削除しました `isSecure`
- Removed `isSoapRequested` in favor of `isSoap`

### Http\Response

- Added `hasHeader()` method to `Phalcon\Http\Response` to provide the ability to check if a header exists.
- Added `Phalcon\Http\Response\Cookies::getCookies`
- Changed `setHeaders` now merges the headers with any pre-existing ones in the internal collection
- Added two new events `response::beforeSendHeaders` and `response::afterSendHeaders`

* * *

## 画像

- `Phalcon\Image\Enum` を追加しました
- `Phalcon\Image\Adapter` を `Phalcon\Image\Adapter\AbstractAdapter` にリネームしました
- `Phalcon\Image\Factory` を `Phalcon\Image\ImageFactory` にリネームしました
- `Phalcon\Image` を削除しました

## Image\Enum (Constants)

例:

```php
<?php

use Phalcon\Image\Enum;

// Resizing constraints
echo Enum::AUTO;    // prints 4
echo Enum::HEIGHT;  // prints  3
echo Enum::INVERSE; // prints  5
echo Enum::NONE;   // prints  1
echo Enum::PRECISE; // prints  6
echo Enum::TENSILE; // prints  7
echo Enum::WIDTH;   // prints  2

// Flipping directions
echo Enum::HORIZONTAL; // prints  11
echo Enum::VERTICAL;   // prints  12
```

* * *

## ログ

> Status: **changes required**
> 
> Usage: [Logger Documentation](logger)
{: .alert .alert-info }

`Logger` コンポーネントが [PSR-3](https://www.php-fig.org/psr/psr-3/) に準拠するように書き換えられました。 This allows you to use the [Phalcon\Logger](api/Phalcon_Logger) to any application that utilizes a [PSR-3](https://www.php-fig.org/psr/psr-3/) logger, not just Phalcon based ones.

v3では、ロガーはアダプタを同じコンポーネントに組み込んでいました。 したがって、本質的には、ロガーオブジェクトを作成する際には、開発者がロガー機能を持つアダプター(ファイル、ストリームなど)を作成していました。

For v4, we rewrote the component to implement only the logging functionality and to accept one or more adapters that would be responsible for doing the work of logging. This immediately offers compatibility with [PSR-3](https://www.php-fig.org/psr/psr-3/) and separates the responsibilities of the component. また、複数のアダプタへのロギングを実現できるように、複数のアダプタをロギングコンポーネントに簡単に接続する方法も提供します。 この実装を使用することで、このコンポーネントに必要なコードを削減し、古い `Logger\Multiple` コンポーネントを削除しました。

### ロガーコンポーネントの作成

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/logs/application.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

DIに登録する

```php
<?php

use Phalcon\Di;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$container = new Di();

$container->set(
    'logger',
    function () {
        $adapter = new Stream('/logs/application.log');
        $logger  = new Logger(
            'messages',
            [
                'main' => $adapter,
            ]
        );

        return $logger;
    }
);
```

### Multiple Loggers

`Phalcon\Logger\Multiple` コンポーネントが削除されました。 logger コンポーネントを使用して複数のアダプターを登録することで、同様の機能を実装できます。

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter1 = new Stream('/logs/first-log.log');
$adapter2 = new Stream('/remote/second-log.log');
$adapter3 = new Stream('/manager/third-log.log');

$logger = new Logger(
    'messages',
    [
        'local'   => $adapter1,
        'remote'  => $adapter2,
        'manager' => $adapter3,
    ]
);

// Log to all adapters
$logger->error('Something went wrong');
```

* * *

## Messages

- `Phalcon\Messages\Message` そして、その複数形の`Phalcon\Messages\Messages` コレクションは、モデルと検証のためのメッセージを処理する新しいコンポーネントです。 過去には検証用とモデル用の2つのコンポーネントがありました。 We have merged these two, so you should be getting back a `MessageInterface[]` back when calling `save` on a model or when retrieving validation messages. 
    - Changed `Phalcon\Mvc\Model` to use the `Phalcon\Messages\Message` object for its messages
    - Changed `Phalcon\Validation\*` to use the `Phalcon\Messages\Message` object for its messages

* * *

### トランザクション

Removed in version 4.0:

- Removed `$logger->begin()`
- Removed `$logger->commit()`

### Log Level

- Removed `$logger->setLogLevel()`

## モデル

> Status: **changes required**
> 
> Usage: [Models Documentation](db-models)
{: .alert .alert-info }

- You can no longer assign data to models while saving them

### Initialization

The `getSource()` method has been marked as `final`. As such you can no longer override this method in your model to set the corresponding table/source of the RDBMS. Instead, you can now use the `initialize()` method and `setSource()` to set the source of your model.

```php
<?php

use Phalcon\Mvc\Model;

class Users
{
    public function initialize()
    {
        $this->setSource('Users');
        // ....
    }
}
```

### Save

The `save()` method no longer accepts parameters to set data. You can use `assign` instead.

### Criteria

The second parameter of `Criteria::limit()` ('offset') must now be an integer or null. Previously there was no type requirement.

```php
$criteria->limit(10);

$criteria->limit(10, 5);

$criteria->limit(10, null);
```

* * *

## MVC

> Status: **changes required**
> 
> Usage: [MVC Documentation](mvc)
{: .alert .alert-info }

### Mvc\Collection

- Removed `Phalcon\Mvc\Collection::validationHasFailed`
- Removed calling `Phalcon\Mvc\Collection::validate` with object of type `Phalcon\Mvc\Model\ValidatorInterface`

### Mvc\Micro\Lazyloader

- Removed `__call` in favor of `callMethod`

### Mvc\Model

- Removed `Phalcon\Model::reset`
- Added `isRelationshipLoaded` to check if relationship is loaded
- Changed `Phalcon\Model::assign` parameters order to `$data`, `$whiteList`, `$dataColumnMap`
- Changed `Phalcon\Model::findFirst` to return `null` instead of `false` if no record was found
- Changed `Phalcon\Model::getRelated()` to return `null` for one to one relationships if no record was found

### Mvc\Model\Criteria

- Removed `addWhere`
- Removed `order`
- Removed `order` in favor of `orderBy`

### Mvc\Model\CriteriaInterface

- Added `distinct`, `leftJoin`, `innerJoin`, `rightJoin`, `groupBy`, `having`, `cache`, `getColumns`, `getGroupBy`, `getHaving`

### Mvc\Model\Manager

- `Load` no longer reuses already initialized models
- Removed `Phalcon\Model\Manager::registerNamespaceAlias()`
- Removed `Phalcon\Model\Manager::getNamespaceAlias()`
- Removed `Phalcon\Model\Manager::getNamespaceAliases()`
- The signature of `Phalcon\Mvc\Model\Manager::getRelationRecords()` has changed
- The signature of `Phalcon\Mvc\Model\Manager::getBelongsToRecords()` has changed
- The signature of `Phalcon\Mvc\Model\Manager::getHasOneRecords()` has changed
- The signature of `Phalcon\Mvc\Model\Manager::getHasManyRecords()` has changed

### Mvc\Model\ManagerInterface

- Added `isVisibleModelProperty`, `keepSnapshots`, `isKeepingSnapshots`, `useDynamicUpdate`, `isUsingDynamicUpdate`, `addHasManyToMany`, `existsHasManyToMany`, `getRelationRecords`, `getHasManyToMany`
- Removed `Phalcon\Model\ManagerInterface::getNamespaceAlias()`
- Removed `Phalcon\Model\ManagerInterface::registerNamespaceAlias()`

### Mvc\Model\MessageInterface

- Added `setModel`, `getModel`, `setCode`, `getCode`

### Mvc\Model\QueryInterface

- Added `getSingleResult`, `setBindParams`, `getBindParams`, `setBindTypes`, `setSharedLock`, `getBindTypes`, `getSql`

### Mvc\Model\Query\BuilderInterface

- Added `offset`

### Mvc\Model\Query\Builder

- Added bind support. The Query Builder has the same methods as `Phalcon\Mvc\Model\Query`; `getBindParams`, `setBindParams`, `getBindTypes` and `setBindTypes`.
- Changed `addFrom` to remove third parameter `$with`

### Mvc\Model\Query\BuilderInterface

- Added `distinct`, `getDistinct`, `forUpdate`, `offset`, `getOffset`

### Mvc\Model\RelationInterface

- Added `getParams`

### Mvc\Model\ResultsetInterface

- Added `setHydrateMode`, `getHydrateMode`, `getMessages`, `update`, `delete`, `filter`

### Mvc\Model\Transaction\ManagerInterface

- Added `setDbService`, `getDbService`, `setRollbackPendent`, `getRollbackPendent`

### Mvc\Model\Validator*

- Removed `Phalcon\Mvc\Model\Validator\*` in favor of `Phalcon\Validation\Validator\*`

### Mvc\ModelInterface

- Added `getModelsMetaData`

### Mvc\Router

- Removed `getRewriteUri()`. The URI needs to be passed in the `handle` method of the application object.

### Mvc\RouterInterface

- Added `attach`

### Mvc\Router\RouteInterface

- Added `convert` so that calling `add` will return an instance that has `convert` method

### Mvc\Router\RouteInterface

- Added response handler to `Phalcon\Mvc\Micro`, `Phalcon\Mvc\Micro::setResponseHandler`, to allow use of a custom response handler.

### Mvc\User

- Removed `Phalcon\Mvc\User\Component` - use `Phalcon\Di\Injectable` instead
- Removed `Phalcon\Mvc\User\Module` - use `Phalcon\Di\Injectable` instead
- Removed `Phalcon\Mvc\User\Plugin` - use `Phalcon\Di\Injectable` instead

### Mvc\View\Engine\Volt

The options for Volt have changed (the key names). Using the old syntax will produce a deprecation warning. The new options are:

- `always` - Always compile
- `extension` - Extension of files
- `separator` - Separator (used for the folders/routes)
- `stat` - Stat each file before trying to use it
- `path` - The path of the files
- `prefix` - The prefix of the files

* * *

## Paginator

- `getPaginate` now becomes `paginate`
- `$before` is removed and replaced with `$previous`
- `$total_pages` is removed since it contained the same information as `$last`
- Added `Phalcon\Paginator\RepositoryInterface` for repository the current state of `paginator` and also optional sets the aliases for properties repository

## Router

- Removed `getRewriteUri()`. The URI needs to be passed in the `handle` method of the application object.
- You can add `CONNECT`, `PURGE`, `TRACE` routes to the Router Group. They function the same as they do in the normal Router:

```php
use Phalcon\Mvc\Router\Group;

$group = new Group();

$group->addConnect(
    '/api',
    [
        'controller' => 'api',
        'action'     => 'connect',
    ]
);

$group->addPurge(
    '/api',
    [
        'controller' => 'api',
        'action'     => 'purge',
    ]
);

$group->addTrace(
    '/api',
    [
        'controller' => 'api',
        'action'     => 'trace',
    ]
);
```

* * *

## セキュリティ

- Removed `hasLibreSsl`
- Removed `getSslVersionNumber`
- Added `setPadding`
- Added a retainer for the current token to be used during the checks, so when `getToken` is called the token used for checks does not change

* * *

## リクエスト

### Http\Request

- Added `numFiles` returning `long` - the number of files present in the request
- Changed `hasFiles` to return `bool` - if the request has files or not

### Http\RequestInterface

- Added `numFiles` returning `int` - the number of files present in the request
- Changed `hasFiles` to return `bool` - if the request has files or not

* * *

## Session

> Status: **changes required**
> 
> Usage: [Session Documentation](session)
{: .alert .alert-info }

`Session` and `Session\Bag` no longer get loaded by default in `Phalcon\DI\FactoryDefault`. `Session` was refactored.

- Added `Phalcon\Session\Adapter\AbstractAdapter`
- Added `Phalcon\Session\Adapter\Noop`
- Added `Phalcon\Session\Adapter\Stream`
- Added `Phalcon\Session\Manager`
- Added `Phalcon\Session\ManagerInterface`
- Removed `Phalcon\Session\Adapter` - replaced by `Phalcon\Session\Adapter\AbstractAdapter`
- Removed `Phalcon\Session\AdapterInterface` - replaced by native `SessionHandlerInterface`
- Removed `Phalcon\Session\Adapter\Files` - replaced by `Phalcon\Session\Adapter\Stream`
- Removed `Phalcon\Session\Adapter\Memcache`
- Removed `Phalcon\Session\BagInterface`
- Removed `Phalcon\Session\Factory`

### Session\Adapter

Each adapter implements PHP's `SessionHandlerInterface`. Available adapters are:

- `Phalcon\Session\Adapter\AbstractAdapter`
- `Phalcon\Session\Adapter\Libmemcached`
- `Phalcon\Session\Adapter\Noop`
- `Phalcon\Session\Adapter\Redis`
- `Phalcon\Session\Adapter\Stream`

### Session\Manager

- Now is the single component that offers session manipulation by using adapters (see above). Each adapter implements PHP's `SessionHandlerInterface`
- Developers can add any adapter that implements `SessionHandlerInterface`

* * *

## タグ

- Added `renderTitle()` that renders the title enclosed in `<title>` tags.
- Changed `getTitle`. It returns only the text. It accepts `prepend`, `append` booleans to prepend or append the relevant text to the title.
- Changed `textArea` to use `htmlspecialchars` to prevent XSS injection.

* * *

## Text

> Status: **changes required**
> 
> Usage: [Str Documentation](helpers#str)
{: .alert .alert-info }

The `Phalcon\Text` component has been removed in favor of the `Phalcon\Helper\Str`. The functionality offered by `Phalcon\Text` in v3 is replicated and enhanced in the new class: `Phalcon\Helper\Str`.

* * *

## バリデーション

### Validation\Message

- Removed `Phalcon\Validation\Message` and `Phalcon\Mvc\Model\Message` in favor of `Phalcon\Messages\Message`
- Removed `Phalcon\Validation\MessageInterface` and `Phalcon\Mvc\Model\MessageInterface` in favor of `Phalcon\Messages\MessageInterface`
- Removed `Phalcon\Validation\Message\Group` in favor of `Phalcon\Messages\Messages`
- Validator messages have been moved inside each validator

### Validation\Validator

- Removed `isSetOption`

### Validation\Validator\Ip

- Added `Phalcon\Validation\Validator\Ip`, class used to validate ip address fields. It allows to validate a field selecting IPv4 or IPv6, allowing private or reserved ranges and empty values if necessary.

* * *

## Views

> Status: **changes required**
> 
> Usage: [View Documentation](views)
{: .alert .alert-info }

View caching along with the `viewCache` service have been removed from the framework because they were incompatible with the new Cache component. Developers can easily utilize a *view cache* from external services such as Varnish, Cloudflare etc. Additionally, developers can cache fragments by either using the `Phalcon\Mvc\View\Simple::render()` or the `Phalcon\Mvc\View::toString()`. Those two methods return the produced HTML that can be cached in the cache backend of your choice.

* * *

## Url

> Status: **changes required**
> 
> Usage: [Url Documentation](url)
{: .alert .alert-info }

The `Phalcon\Mvc\Url` component has been renamed to `Phalcon\Url`. The functionality remains the same.

## Cheat Sheet

### Acl

| 3.4.x                  | State      | 4.0.x                                  |
| ---------------------- | ---------- | -------------------------------------- |
| Phalcon\Acl           | Removed    |                                        |
| Phalcon\Acl\Adapter  | Renamed to | Phalcon\Acl\Adapter\AbstractAdapter |
| Phalcon\Acl\Resource | Renamed to | Phalcon\Acl\Component                |
|                        | New        | Phalcon\Acl\Enum                     |

### アノテーション

| 3.4.x                                 | State      | 4.0.x                                          |
| ------------------------------------- | ---------- | ---------------------------------------------- |
| Phalcon\Annotations\Adapter         | Renamed to | Phalcon\Annotations\Adapter\AbstractAdapter |
| Phalcon\Annotations\Adapter\Apc    | Removed    |                                                |
| Phalcon\Annotations\Adapter\Files  | Renamed to | Phalcon\Annotations\Adapter\Stream          |
| Phalcon\Annotations\Adapter\Xcache | Removed    |                                                |
| Phalcon\Annotations\Factory         | Renamed to | Phalcon\Annotations\AnnotationsFactory       |

### アプリケーション

| 3.4.x                | State      | 4.0.x                                     |
| -------------------- | ---------- | ----------------------------------------- |
| Phalcon\Application | Renamed to | Phalcon\Application\AbstractApplication |

### アセット

| 3.4.x                          | State      | 4.0.x                       |
| ------------------------------ | ---------- | --------------------------- |
| Phalcon\Assets\Resource      | Renamed to | Phalcon\Assets\Asset      |
| Phalcon\Assets\Resource\Css | Renamed to | Phalcon\Assets\Asset\Css |
| Phalcon\Assets\Resource\Js  | Renamed to | Phalcon\Assets\Asset\Js  |

### キャッシュ

| 3.4.x                                 | State      | 4.0.x                                               |
| ------------------------------------- | ---------- | --------------------------------------------------- |
| Phalcon\Cache\Backend\Apc          | Removed    |                                                     |
| Phalcon\Cache\Backend               | Renamed to | Phalcon\Cache                                      |
| Phalcon\Cache\Backend\Factory      | Renamed to | Phalcon\Cache\AdapterFactory                      |
| Phalcon\Cache\Backend\Apcu         | Renamed to | Phalcon\Cache\Adapter\Apcu                       |
| Phalcon\Cache\Backend\File         | Renamed to | Phalcon\Cache\Adapter\Stream                     |
| Phalcon\Cache\Backend\Libmemcached | Renamed to | Phalcon\Cache\Adapter\Libmemcached               |
| Phalcon\Cache\Backend\Memcache     | Removed    |                                                     |
| Phalcon\Cache\Backend\Memory       | Renamed to | Phalcon\Cache\Adapter\Memory                     |
| Phalcon\Cache\Backend\Mongo        | Removed    |                                                     |
| Phalcon\Cache\Backend\Redis        | Renamed to | Phalcon\Cache\Adapter\Redis                      |
|                                       | New        | Phalcon\Cache\CacheFactory                        |
| Phalcon\Cache\Backend\Xcache       | Removed    |                                                     |
| Phalcon\Cache\Exception             | Renamed to | Phalcon\Cache\Exception\Exception                |
|                                       | New        | Phalcon\Cache\Exception\InvalidArgumentException |
| Phalcon\Cache\Frontend\Base64      | Removed    |                                                     |
| Phalcon\Cache\Frontend\Data        | Removed    |                                                     |
| Phalcon\Cache\Frontend\Factory     | Removed    |                                                     |
| Phalcon\Cache\Frontend\Igbinary    | Removed    |                                                     |
| Phalcon\Cache\Frontend\Json        | Removed    |                                                     |
| Phalcon\Cache\Frontend\Msgpack     | Removed    |                                                     |
| Phalcon\Cache\Frontend\None        | Removed    |                                                     |
| Phalcon\Cache\Frontend\Output      | Removed    |                                                     |
| Phalcon\Cache\Multiple              | Removed    |                                                     |

### コレクション

| 3.4.x | State | 4.0.x                          |
| ----- | ----- | ------------------------------ |
|       | New   | Phalcon\Collection            |
|       | New   | Phalcon\Collection\Exception |
|       | New   | Phalcon\Collection\ReadOnly  |

### 設定

| 3.4.x                    | State      | 4.0.x                          |
| ------------------------ | ---------- | ------------------------------ |
| Phalcon\Config\Factory | Renamed to | Phalcon\Config\ConfigFactory |

### コンテナ

| 3.4.x | State | 4.0.x              |
| ----- | ----- | ------------------ |
|       | New   | Phalcon\Container |

### Db

| 3.4.x                              | State      | 4.0.x                                  |
| ---------------------------------- | ---------- | -------------------------------------- |
| Phalcon\Db                        | Renamed to | Phalcon\Db\AbstractDb                |
| Phalcon\Db\Adapter               | Renamed to | Phalcon\Db\Adapter\AbstractAdapter  |
| Phalcon\Db\Adapter\Pdo          | Renamed to | Phalcon\Db\Adapter\Pdo\AbstractPdo |
| Phalcon\Db\Adapter\Pdo\Factory | Renamed to | Phalcon\Db\Adapter\PdoFactory       |
|                                    | New        | Phalcon\Db\Enum                      |

### ディスパッチャー

| 3.4.x               | State      | 4.0.x                                   |
| ------------------- | ---------- | --------------------------------------- |
| Phalcon\Dispatcher | Renamed to | Phalcon\Dispatcher\AbstractDispatcher |
|                     | New        | Phalcon\Dispatcher\Exception          |

### Di

| 3.4.x | State | 4.0.x                                              |
| ----- | ----- | -------------------------------------------------- |
|       | New   | Phalcon\Di\AbstractInjectionAware                |
|       | New   | Phalcon\Di\Exception\ServiceResolutionException |

### Domain

| 3.4.x | State | 4.0.x                                    |
| ----- | ----- | ---------------------------------------- |
|       | New   | Phalcon\Domain\Payload\Payload        |
|       | New   | Phalcon\Domain\Payload\PayloadFactory |
|       | New   | Phalcon\Domain\Payload\Status         |

### Factory

| 3.4.x            | State      | 4.0.x                             |
| ---------------- | ---------- | --------------------------------- |
| Phalcon\Factory | Renamed to | Phalcon\Factory\AbstractFactory |

### Filter

| 3.4.x | State | 4.0.x                                  |
| ----- | ----- | -------------------------------------- |
|       | New   | Phalcon\Filter\FilterFactory         |
|       | New   | Phalcon\Filter\Sanitize\AbsInt      |
|       | New   | Phalcon\Filter\Sanitize\Alnum       |
|       | New   | Phalcon\Filter\Sanitize\Alpha       |
|       | New   | Phalcon\Filter\Sanitize\BoolVal     |
|       | New   | Phalcon\Filter\Sanitize\Email       |
|       | New   | Phalcon\Filter\Sanitize\FloatVal    |
|       | New   | Phalcon\Filter\Sanitize\IntVal      |
|       | New   | Phalcon\Filter\Sanitize\Lower       |
|       | New   | Phalcon\Filter\Sanitize\LowerFirst  |
|       | New   | Phalcon\Filter\Sanitize\Regex       |
|       | New   | Phalcon\Filter\Sanitize\Remove      |
|       | New   | Phalcon\Filter\Sanitize\Replace     |
|       | New   | Phalcon\Filter\Sanitize\Special     |
|       | New   | Phalcon\Filter\Sanitize\SpecialFull |
|       | New   | Phalcon\Filter\Sanitize\StringVal   |
|       | New   | Phalcon\Filter\Sanitize\Striptags   |
|       | New   | Phalcon\Filter\Sanitize\Trim        |
|       | New   | Phalcon\Filter\Sanitize\Upper       |
|       | New   | Phalcon\Filter\Sanitize\UpperFirst  |
|       | New   | Phalcon\Filter\Sanitize\UpperWords  |
|       | New   | Phalcon\Filter\Sanitize\Url         |

### Flash

| 3.4.x          | State      | 4.0.x                         |
| -------------- | ---------- | ----------------------------- |
| Phalcon\Flash | Renamed to | Phalcon\Flash\AbstractFlash |

### フォーム

| 3.4.x                   | State      | 4.0.x                                    |
| ----------------------- | ---------- | ---------------------------------------- |
| Phalcon\Forms\Element | Renamed to | Phalcon\Forms\Element\AbstractElement |

### Helper

| 3.4.x | State | 4.0.x                      |
| ----- | ----- | -------------------------- |
|       | New   | Phalcon\Helper\Arr       |
|       | New   | Phalcon\Helper\Exception |
|       | New   | Phalcon\Helper\Fs        |
|       | New   | Phalcon\Helper\Json      |
|       | New   | Phalcon\Helper\Number    |
|       | New   | Phalcon\Helper\Str       |

### Html

| 3.4.x | State | 4.0.x                                      |
| ----- | ----- | ------------------------------------------ |
|       | New   | Phalcon\Html\Attributes                  |
|       | New   | Phalcon\Html\Breadcrumbs                 |
|       | New   | Phalcon\Html\Exception                   |
|       | New   | Phalcon\Html\Helper\AbstractHelper      |
|       | New   | Phalcon\Html\Helper\Anchor              |
|       | New   | Phalcon\Html\Helper\AnchorRaw           |
|       | New   | Phalcon\Html\Helper\Body                |
|       | New   | Phalcon\Html\Helper\Button              |
|       | New   | Phalcon\Html\Helper\Close               |
|       | New   | Phalcon\Html\Helper\Element             |
|       | New   | Phalcon\Html\Helper\ElementRaw          |
|       | New   | Phalcon\Html\Helper\Form                |
|       | New   | Phalcon\Html\Helper\Img                 |
|       | New   | Phalcon\Html\Helper\Label               |
|       | New   | Phalcon\Html\Helper\TextArea            |
|       | New   | Phalcon\Html\Link\EvolvableLink         |
|       | New   | Phalcon\Html\Link\EvolvableLinkProvider |
|       | New   | Phalcon\Html\Link\Link                  |
|       | New   | Phalcon\Html\Link\LinkProvider          |
|       | New   | Phalcon\Html\Link\Serializer\Header    |
|       | New   | Phalcon\Html\TagFactory                  |

### Http

| 3.4.x | State | 4.0.x                                                       |
| ----- | ----- | ----------------------------------------------------------- |
|       | New   | Phalcon\Http\Message\AbstractCommon                      |
|       | New   | Phalcon\Http\Message\AbstractMessage                     |
|       | New   | Phalcon\Http\Message\AbstractRequest                     |
|       | New   | Phalcon\Http\Message\Exception\InvalidArgumentException |
|       | New   | Phalcon\Http\Message\Request                             |
|       | New   | Phalcon\Http\Message\RequestFactory                      |
|       | New   | Phalcon\Http\Message\Response                            |
|       | New   | Phalcon\Http\Message\ResponseFactory                     |
|       | New   | Phalcon\Http\Message\ServerRequest                       |
|       | New   | Phalcon\Http\Message\ServerRequestFactory                |
|       | New   | Phalcon\Http\Message\Stream                              |
|       | New   | Phalcon\Http\Message\StreamFactory                       |
|       | New   | Phalcon\Http\Message\Stream\Input                       |
|       | New   | Phalcon\Http\Message\Stream\Memory                      |
|       | New   | Phalcon\Http\Message\Stream\Temp                        |
|       | New   | Phalcon\Http\Message\UploadedFile                        |
|       | New   | Phalcon\Http\Message\UploadedFileFactory                 |
|       | New   | Phalcon\Http\Message\Uri                                 |
|       | New   | Phalcon\Http\Message\UriFactory                          |
|       | New   | Phalcon\Http\Server\AbstractMiddleware                   |
|       | New   | Phalcon\Http\Server\AbstractRequestHandler               |

### 画像

| 3.4.x                   | State      | 4.0.x                                    |
| ----------------------- | ---------- | ---------------------------------------- |
| Phalcon\Image          | Removed    |                                          |
| Phalcon\Image\Adapter | Renamed to | Phalcon\Image\Adapter\AbstractAdapter |
|                         | New        | Phalcon\Image\Enum                     |
| Phalcon\Image\Factory | Renamed to | Phalcon\Image\ImageFactory             |

### ログ

| 3.4.x                               | State      | 4.0.x                                         |
| ----------------------------------- | ---------- | --------------------------------------------- |
|                                     | New        | Phalcon\Logger\AdapterFactory               |
| Phalcon\Logger\Adapter            | Renamed to | Phalcon\Logger\Adapter\AbstractAdapter     |
| Phalcon\Logger\Adapter\Blackhole | Renamed to | Phalcon\Logger\Adapter\Noop                |
| Phalcon\Logger\Adapter\File      | Renamed to | Phalcon\Logger\Adapter\Stream              |
| Phalcon\Logger\Adapter\Firephp   | Removed    |                                               |
| Phalcon\Logger\Factory            | Renamed to | Phalcon\Logger\LoggerFactory                |
| Phalcon\Logger\Formatter          | Renamed to | Phalcon\Logger\Formatter\AbstractFormatter |
| Phalcon\Logger\Formatter\Firephp | Removed    |                                               |
| Phalcon\Logger\Formatter\Syslog  | Removed    |                                               |
| Phalcon\Logger\Multiple           | Removed    |                                               |

### Message (new in V4, Formerly Phalcon\Validation\Message in 3.4)

| 3.4.x | State | 4.0.x                        |
| ----- | ----- | ---------------------------- |
|       | New   | Phalcon\Messages\Exception |
|       | New   | Phalcon\Messages\Message   |
|       | New   | Phalcon\Messages\Messages  |

### Mvc

| 3.4.x                                             | State      | 4.0.x                                        |
| ------------------------------------------------- | ---------- | -------------------------------------------- |
| Phalcon\Mvc\Collection                          | Renamed to | Phalcon\Collection                          |
| Phalcon\Mvc\Collection\Behavior                | Removed    |                                              |
| Phalcon\Mvc\Collection\Behavior\SoftDelete    | Removed    |                                              |
| Phalcon\Mvc\Collection\Behavior\Timestampable | Removed    |                                              |
| Phalcon\Mvc\Collection\Document                | Removed    |                                              |
| Phalcon\Mvc\Collection\Exception               | Renamed to | Phalcon\Collection\Exception               |
| Phalcon\Mvc\Collection\Manager                 | Removed    |                                              |
|                                                   | New        | Phalcon\Collection\ReadOnly                |
| Phalcon\Mvc\Model\Message                      | Renamed to | Phalcon\Messages\Message                   |
| Phalcon\Mvc\Model\MetaData\Apc                | Removed    |                                              |
| Phalcon\Mvc\Model\MetaData\Files              | Renamed to | Phalcon\Mvc\Model\MetaData\Stream        |
| Phalcon\Mvc\Model\MetaData\Memcache           | Removed    |                                              |
| Phalcon\Mvc\Model\MetaData\Session            | Removed    |                                              |
| Phalcon\Mvc\Model\MetaData\Xcache             | Removed    |                                              |
| Phalcon\Mvc\Model\Validator                    | Renamed to | Phalcon\Validation\Validator               |
| Phalcon\Mvc\Model\Validator\Email             | Renamed to | Phalcon\Validation\Validator\Email        |
| Phalcon\Mvc\Model\Validator\Exclusionin       | Renamed to | Phalcon\Validation\Validator\ExclusionIn  |
| Phalcon\Mvc\Model\Validator\Inclusionin       | Renamed to | Phalcon\Validation\Validator\InclusionIn  |
| Phalcon\Mvc\Model\Validator\Ip                | Renamed to | Phalcon\Validation\Validator\Ip           |
| Phalcon\Mvc\Model\Validator\Numericality      | Renamed to | Phalcon\Validation\Validator\Numericality |
| Phalcon\Mvc\Model\Validator\PresenceOf        | Renamed to | Phalcon\Validation\Validator\PresenceOf   |
| Phalcon\Mvc\Model\Validator\Regex             | Renamed to | Phalcon\Validation\Validator\Regex        |
| Phalcon\Mvc\Model\Validator\StringLength      | Renamed to | Phalcon\Validation\Validator\StringLength |
| Phalcon\Mvc\Model\Validator\Uniqueness        | Renamed to | Phalcon\Validation\Validator\Uniqueness   |
| Phalcon\Mvc\Model\Validator\Url               | Renamed to | Phalcon\Validation\Validator\Url          |
| Phalcon\Mvc\Url                                 | Renamed to | Phalcon\Url                                 |
| Phalcon\Mvc\Url\Exception                      | Renamed to | Phalcon\Url\Exception                      |
| Phalcon\Mvc\User\Component                     | Renamed to | Phalcon\Di\Injectable                      |
| Phalcon\Mvc\User\Module                        | Renamed to | Phalcon\Di\Injectable                      |
| Phalcon\Mvc\User\Plugin                        | Renamed to | Phalcon\Di\Injectable                      |
| Phalcon\Mvc\View\Engine                        | Renamed to | Phalcon\Mvc\View\Engine\AbstractEngine   |

### Paginator

| 3.4.x                       | State      | 4.0.x                                        |
| --------------------------- | ---------- | -------------------------------------------- |
| Phalcon\Paginator\Adapter | Renamed to | Phalcon\Paginator\Adapter\AbstractAdapter |
| Phalcon\Paginator\Factory | Renamed to | Phalcon\Paginator\PaginatorFactory         |
|                             | New        | Phalcon\Paginator\Repository               |

### Queue

| 3.4.x                                | State   | 4.0.x |
| ------------------------------------ | ------- | ----- |
| Phalcon\Queue\Beanstalk            | Removed |       |
| Phalcon\Queue\Beanstalk\Exception | Removed |       |
| Phalcon\Queue\Beanstalk\Job       | Removed |       |

### Session

| 3.4.x                               | State      | 4.0.x                                      |
| ----------------------------------- | ---------- | ------------------------------------------ |
| Phalcon\Session\Adapter           | Renamed to | Phalcon\Session\Adapter\AbstractAdapter |
| Phalcon\Session\Adapter\Files    | Renamed to | Phalcon\Session\Adapter\Stream          |
|                                     | New        | Phalcon\Session\Adapter\Noop            |
| Phalcon\Session\Adapter\Memcache | Removed    |                                            |
| Phalcon\Session\Factory           | Renamed to | Phalcon\Session\Manager                  |

### Storage

| 3.4.x | State | 4.0.x                                            |
| ----- | ----- | ------------------------------------------------ |
|       | New   | Phalcon\Storage\AdapterFactory                 |
|       | New   | Phalcon\Storage\Adapter\AbstractAdapter       |
|       | New   | Phalcon\Storage\Adapter\Apcu                  |
|       | New   | Phalcon\Storage\Adapter\Libmemcached          |
|       | New   | Phalcon\Storage\Adapter\Memory                |
|       | New   | Phalcon\Storage\Adapter\Redis                 |
|       | New   | Phalcon\Storage\Adapter\Stream                |
|       | New   | Phalcon\Storage\Exception                      |
|       | New   | Phalcon\Storage\SerializerFactory              |
|       | New   | Phalcon\Storage\Serializer\AbstractSerializer |
|       | New   | Phalcon\Storage\Serializer\Base64             |
|       | New   | Phalcon\Storage\Serializer\Igbinary           |
|       | New   | Phalcon\Storage\Serializer\Json               |
|       | New   | Phalcon\Storage\Serializer\Msgpack            |
|       | New   | Phalcon\Storage\Serializer\None               |
|       | New   | Phalcon\Storage\Serializer\Php                |

### Helper

| 3.4.x                       | State      | 4.0.x                                        |
| --------------------------- | ---------- | -------------------------------------------- |
| Phalcon\Translate          | Removed    |                                              |
| Phalcon\Translate\Adapter | Renamed to | Phalcon\Translate\Adapter\AbstractAdapter |
|                             | New        | Phalcon\Translate\InterpolatorFactory      |
| Phalcon\Translate\Factory | Renamed to | Phalcon\Translate\TranslateFactory         |

### Url

| 3.4.x | State | 4.0.x                   |
| ----- | ----- | ----------------------- |
|       | New   | Phalcon\Url            |
|       | New   | Phalcon\Url\Exception |

### バリデーション

| 3.4.x                                        | State      | 4.0.x                                                   |
| -------------------------------------------- | ---------- | ------------------------------------------------------- |
| Phalcon\Validation\CombinedFieldsValidator | Renamed to | Phalcon\Validation\AbstractCombinedFieldsValidator    |
| Phalcon\Validation\Message                 | Renamed to | Phalcon\Messages\Message                              |
| Phalcon\Validation\Message\Group          | Renamed to | Phalcon\Messages\Messages                             |
| Phalcon\Validation\Validator               | Renamed to | Phalcon\Validation\AbstractValidator                  |
|                                              | New        | Phalcon\Validation\AbstractValidatorComposite         |
|                                              | New        | Phalcon\Validation\Exception                          |
|                                              | New        | Phalcon\Validation\ValidatorFactory                   |
|                                              | New        | Phalcon\Validation\Validator\File\AbstractFile      |
|                                              | New        | Phalcon\Validation\Validator\File\MimeType          |
|                                              | New        | Phalcon\Validation\Validator\File\Resolution\Equal |
|                                              | New        | Phalcon\Validation\Validator\File\Resolution\Max   |
|                                              | New        | Phalcon\Validation\Validator\File\Resolution\Min   |
|                                              | New        | Phalcon\Validation\Validator\File\Size\Equal       |
|                                              | New        | Phalcon\Validation\Validator\File\Size\Max         |
|                                              | New        | Phalcon\Validation\Validator\File\Size\Min         |
|                                              | New        | Phalcon\Validation\Validator\StringLength\Max       |
|                                              | New        | Phalcon\Validation\Validator\StringLength\Min       |