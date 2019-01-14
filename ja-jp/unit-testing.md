* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Overview

適切なテストはより良いソフトウェアを作ります。適切なテストケースを設定すれば、最大限に機能的バグを退治でき、ソフトウェアをもっと良い状態に保てます。

<a name='integration'></a>

## PhalconとPHPUnitの統合

PHPUnit をインストールしていない場合、次のcomposerコマンドを実行してインストールすることができます。

```bash
composer require phpunit/phpunit:^5.0
```

または`composer.json`に手動で追加:

```json
<br />{
    "require-dev": {
        "phpunit/phpunit": "^5.0"
    }
}
```

PHPUnitをインストールすると、プロジェクトのルートディレクトリに`tests`というディレクトリが作成されます:

    app/
    public/
    tests/
    

次に、ユニットテストのためにアプリケーションをブートストラップするための 'ヘルパー' ファイルが必要です。

<a name='unit-helper'></a>

## PHPUnitのヘルパーファイル

テストを実行するためにアプリケーションをブートストラップするには、ヘルパーファイルが必要です。 サンプルファイルを用意しました。 ファイルを`tests/`ディレクトリに`TestHelper.php`として置いてください。

```php
<?php

use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;

ini_set("display_errors", 1);
error_reporting(E_ALL);

define("ROOT_PATH", __DIR__);

set_include_path(
    ROOT_PATH . PATH_SEPARATOR . get_include_path()
);

// phalcon/incubatorに必要
include __DIR__ . "/../vendor/autoload.php";

// アプリケーションオートローダーを使用してクラスを自動ロードする
// composer内の依存関係を自動読み込みする
$loader = new Loader();

$loader->registerDirs(
    [
        ROOT_PATH,
    ]
);

$loader->register();

$di = new FactoryDefault();

Di::reset();

// ここで必要なサービスを DI に追加します

Di::setDefault($di);
```

あなたのライブラリからコンポーネントをテストする必要がある場合は、それらをオートローダーに追加するか、メインアプリケーションのオートローダーを使用してください。

ユニットテストの構築に役立つように、ユニットテスト自体をブートストラップするために使用できる抽象クラスをいくつか作成しました。 これらのファイルは[Phalcon Incubator](https://github.com/phalcon/incubator)にあります。

Incubatorライブラリは依存関係として追加することで使用できます:

```bash
composer require phalcon/incubator
```

または`composer.json`に手動で追加:

```json
{
    "require": {
        "phalcon/incubator": "^3.0"
    }
}
```

上記のリポジトリリンクを使用してリポジトリを複製することもできます。

<a name='phpunit-config'></a>

## `phpunit.xml`ファイル

`phpunit.xml`ファイルを次のように作成します:

```xml
<?xml version="1.0" encoding="UTF-8"?>

<phpunit bootstrap="./TestHelper.php"
         backupGlobals="false"
         backupStaticAttributes="false"
         verbose="true"
         colors="false"
         convertErrorsToExceptions="true"
         convertNoticesToExceptions="true"
         convertWarningsToExceptions="true"
         processIsolation="false"
         stopOnFailure="false"
         syntaxCheck="true">

    <testsuite name="Phalcon - Testsuite">
        <directory>./</directory>
    </testsuite>
</phpunit>
```

ニーズに合わせて`phpunit.xml`を修正し、`tests`ディレクトリに保存します。 これにより、`tests`ディレクトリの下でテストが実行されます。

<a name='sample'></a>

## ユニットテストのサンプル

ユニットテストを実行するには、ユニットテストを定義する必要があります。 オートローダーは、適切なファイルがロードされていることを確認します。そのため、ファイルを作成するだけで、phpunitがテストを実行します。

この例は設定ファイルを含んでいませんが、ほとんどのテストケースは必要です。 `DI`に追加して`UnitTestCase`ファイルを取得できます。

最初に、`tests`ディレクトリに`UnitTestCase.php`というベースのユニットテストを作成します。

```php
<?php

use Phalcon\Di;
use Phalcon\Test\UnitTestCase as PhalconTestCase;

abstract class UnitTestCase extends PhalconTestCase
{
    /**
     * @var bool
     */
    private $_loaded = false;

    public function setUp()
    {
        parent::setUp();

        // テスト中に必要となるかもしれない追加のサービスをロードする
        $di = Di::getDefault();

        // ここでDIコンポーネントを取得。 設定がある場合、必ず親クラスに渡す。

        $this->setDi($di);

        $this->_loaded = true;
    }

    /**
     * テストケースが正しく設定されているかどうかを確認する
     *
     * @throws \PHPUnit_Framework_IncompleteTestError;
     */
    public function __destruct()
    {
        if (!$this->_loaded) {
            throw new \PHPUnit_Framework_IncompleteTestError(
                "Please run parent::setUp()."
            );
        }
    }
}
```

ユニットテストを名前空間で分離することは常に良い考えです。 このテストでは、名前空間 'Test'を作成します。 したがって、`tests\Test\UnitTest.php`というファイルを作成します。

```php
<?php

namespace Test;

/**
 * Class UnitTest
 */
class UnitTest extends \UnitTestCase
{
    public function testTestCase()
    {
        $this->assertEquals(
            "works",
            "works",
            "This is OK"
        );

        $this->assertEquals(
            "works",
            "works1",
            "This will fail"
        );
    }
}
```

`tests`ディレクトリ内で`phpunit`コマンドを実行すると、次のような出力が得られます:

```bash
$ phpunit
PHPUnit 3.7.23 by Sebastian Bergmann.

Configuration read from /var/www/tests/phpunit.xml

Time: 3 ms, Memory: 4.05Mb

There was 1 failure:

1) Test\UnitTest::testTestCase
This will fail
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
-'works'
+'works1'

/var/www/tests/Test/UnitTest.php:25

FAILURES!
Tests: 1, Assertions: 2, Failures: 1.
```

今すぐユニットテストの構築を開始できます。 You can view a [good guide here](https://blog.stevensanderson.com/2009/08/24/writing-great-unit-tests-best-and-worst-practises/). また、PHPUnitに精通していない場合は、PHPUnitのドキュメントを読むことをお勧めします。