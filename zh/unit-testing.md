<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">目录预览</a> 
      <ul>
        <li>
          <a href="#integration">Phalcon于PHPUnit结合</a>
        </li>
        <li>
          <a href="#unit-helper">PHPUnit"桥"文件</a>
        </li>
        <li>
          <a href="#phpunit-config">The phpunit.xml file</a>
        </li>
        <li>
          <a href="#sample">单元测试示例</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# 概述

Writing proper tests can assist in writing better software. If you set up proper test cases you can eliminate most functional bugs and better maintain your software.

<a name='integration'></a>

## Phalcon于PHPUnit结合

If you don't already have phpunit installed, you can do it by using the following composer command:

```bash
composer require phpunit/phpunit:^5.0
```

或者手动添加如下内容到`composer.json`：

```json
<br />{
    "require-dev": {
        "phpunit/phpunit": "^5.0"
    }
}
```

当PHPUnit安装成功后在根目录创建一个名为`tests`的文件：

    app/
    public/
    tests/
    

Next, we need a 'helper' file to bootstrap the application for unit testing.

<a name='unit-helper'></a>

## The PHPUnit helper file

A helper file is required to bootstrap the application for running the tests. We have prepared a sample file. Put the file in your `tests/` directory as `TestHelper.php`.

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

// Required for phalcon/incubator
include __DIR__ . "/../vendor/autoload.php";

// Use the application autoloader to autoload the classes
// Autoload the dependencies found in composer
$loader = new Loader();

$loader->registerDirs(
    [
        ROOT_PATH,
    ]
);

$loader->register();

$di = new FactoryDefault();

Di::reset();

// Add any needed services to the DI here

Di::setDefault($di);
```

Should you need to test any components from your own library, add them to the autoloader or use the autoloader from your main application.

为帮助您生成单元测试，需要创建几个抽象类，您可以使用来引导自己的单元测试。 这些文件在[Phalcon Incubator](https://github.com/phalcon/incubator)中。

你可以使用Incubator项目中库作为依赖添加。

```bash
composer require phalcon/incubator
```

或者手动添加如下内容到`composer.json`：

```json
{
    "require": {
        "phalcon/incubator": "^3.0"
    }
}
```

You can also clone the repository using the repo link above.

<a name='phpunit-config'></a>

## `phpunit.xml`文件

现在创建使用下面的内容创建`phpunit.xml`文件：

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

Modify the `phpunit.xml` to fit your needs and save it in `tests`. This will run any tests under the `tests` directory.

<a name='sample'></a>

## 单元测试示例

To run any Unit Tests you need to define them. The autoloader will make sure the proper files are loaded so all you need to do is create the files and phpunit will run the tests for you.

This example does not contain a config file, most test cases however, do need one. You can add it to the `DI` to get the `UnitTestCase` file.

首先创建一个基础的单元测试名为`UnitTestCase.php`在你的`tests`文件夹中：

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

        // 加载所有已添加的服务，它们可能会在测试过程中所需要
        $di = Di::getDefault();

        // 获取DI中所有的组建。 If you have a config, be sure to pass it to the parent

        $this->setDi($di);

        $this->_loaded = true;
    }

    /**
     * Check if the test case is setup properly
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

It's always a good idea to separate your Unit Tests in namespaces. For this test we will create the namespace 'Test'. So create a file called `tests\Test\UnitTest.php`:

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

Now when you execute `phpunit` in your command-line from the `tests` directory you will get the following output:

```bash
$ phpunit
PHPUnit 3.7.23 by Sebastian Bergmann.

Configuration read from /var/www/tests/phpunit.xml

Time: 3 ms, Memory: 3.25Mb

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

Now you can start building your Unit Tests. You can view a [good guide here](http://blog.stevensanderson.com/2009/08/24/writing-great-unit-tests-best-and-worst-practises/). We also recommend reading the PHPUnit documentation if you're not familiar with PHPUnit.