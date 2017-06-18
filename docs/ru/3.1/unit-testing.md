<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Overview</a> <ul>
        <li>
          <a href="#integration">Интеграция PHPUnit с Phalcon</a>
        </li>
        <li>
          <a href="#unit-helper">PHPUnit хелпер</a>
        </li>
        <li>
          <a href="#phpunit-config">Файл <code>phpunit.xml</code></a>
        </li>
        <li>
          <a href="#sample">Пример модульного теста</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Overview

Написание правильного теста может помочь в создании создании более качественного програмного обеспечения. Покрытие тестами надлежащих случаев помогает устранить большинство функциональных ошибок и лучше поддерживать программное обеспечение.

<a name='integration'></a>

## Интеграция PHPUnit с Phalcon

Если вы еще не установили PHPUnit, вы можете сделать это с помощью следующей команды:

```bash
composer require phpunit/phpunit:^5.0
```

или вручную добавить его в `composer.json`:

```json
<br />{
    "require-dev": {
        "phpunit/phpunit": "^5.0"
    }
}
```

После установки PHPUnit ​​создайте директорию `tests` в корне проекта:

    app/
    public/
    tests/
    

Далее, нам понадобится “хелпер” для подготовки приложения к модульному тестированию.

<a name='unit-helper'></a>

## The PHPUnit helper file

Хелпер необходим для подготовки приложения к запуску тестов. Мы подготовили образец файла. Поместите файл `TestHelper.php` в директорию `tests`.

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

// Необходим для phalcon/incubator
include __DIR__ . "/../vendor/autoload.php";

// Используем автозагрузчик приложений для автозагрузки классов.
$loader = new Loader();

$loader->registerDirs(
    [
        ROOT_PATH, 
    ]
);

$loader->register();

$di = new FactoryDefault();

Di::reset();

// Здесь можно добавить любые необходимые сервисы в контейнер зависимостей

Di::setDefault($di);
```

Если вам необходимо протестировать какой-либо компонент из вашей библиотеки компонентов, добавьте его в автозагрузчик или используйте автозагрузчик вашего основного приложения.

Для облегчения написания модульных тестов, мы создали несколько абстрактных классов, которые вы можете использовать для настройки самих тестов. Вы можете получить их из [Инкубатора](https://github.com/phalcon/incubator).

Вы можете использовать Инкубатор, добавив его в качестве зависимости:

```bash
composer require phalcon/incubator
```

или вручную, добавить его в `composer.json`:

```json
{
    "require": {
        "phalcon/incubator": "^3.2"
    }
}
```

Вы также можете склонировать репозиторий, используя ссылку: https://github.com/phalcon/incubator.

<a name='phpunit-config'></a>

## The `phpunit.xml` file

Теперь создайте файл `phpunit.xml` как показано ниже:

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

Измените `phpunit.xml` в соответствии с вашими потребностями и сохраните его в `tests`. Это будет запускать любые тесты из из директории `tests`.

<a name='sample'></a>

## Sample Unit Test

To run any Unit Tests you need to define them. The autoloader will make sure the proper files are loaded so all you need to do is create the files and phpunit will run the tests for you.

This example does not contain a config file, most test cases however, do need one. You can add it to the `DI` to get the `UnitTestCase` file.

First create a base Unit Test called `UnitTestCase.php` in your `tests` directory:

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

        // Load any additional services that might be required during testing
        $di = Di::getDefault();

        // Get any DI components here. If you have a config, be sure to pass it to the parent

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