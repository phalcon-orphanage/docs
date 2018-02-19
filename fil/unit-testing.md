<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Pangkalahatang-ideya</a> <ul>
        <li>
          <a href="#integration">Pagsasama ang PHPUnit sa Phalcon</a>
        </li>
        <li>
          <a href="#unit-helper">Ang PHPunit helper file</a>
        </li>
        <li>
          <a href="#phpunit-config">Ang kikil na <code>phpunit.xml</code>file</a>
        </li>
        <li>
          <a href="#sample">Halimbawa ng Yunit Test</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Pangkalahatang-ideya

Ang pagsulat ng tamang pagsusuri ay makatutulong sa pagsusulat ng mabutinhgsoftware. Kung ikaw ay bubuo ng angkop na mga test cases maaring mong tanggalin ang pinakagumagana na bugs at mapanatili ng mabuti ang iyong software.

<a name='integration'></a>

## Pagsamama ng PHPunit sa Phalcon

Kung ikaw ay wala pang PHPUnit na naka-install, maaring mong gamitin ang mga utos na ito:

```bash
kompositor ay kailangan ng phpunit/phpunit
```

o mano-manong idagdag ito sa `composer.json`:

```json
<br />{
    "require-dev":{
        "phpunit/phpunit":"5.*"
    }
}
```

Kapag ang PHPUnit ay na-install gumawa ng direktoryo na tinatawag na `tests` sa direktoryo ng ugat ng proyekto:

    app/
    public/
    tests/
    

Kasunod, kailangan natin ang 'katulong' na kikil para magsimula muli ang aplikasyon para sa yunit na pagsusuri.

<a name='unit-helper'></a>

## Ang PHPUnit helper file

Ang helper file ay kailangan para gumana muli ang aplikasyon para maipatakbo ang mga pagsusulit. Kami ay naghanda ng isang halimbawa. Ilagay ang file sa iyong `tests` direktoryo bilang `TestHelper.php`.

```php
<?php

gamitin ang Phalcon\Di;
gamitin ang Phalcon\Di\FactoryDefault;
gamitin ang Phalcon\Loader;

ini_set("display_errors",1);
error_reporting(E_ALL);

define("ROOT_PATH",__DIR__);

set_include_path(
    ROOT_PATH. PATH_SEPARATOR. get_include_path()
);

// Kailangan para sa phalcon/incubator
// at i-autoload ang mga dependencies na makikita sa kompositor
isama ang __DIR__. "/ ../vendor/autoload.php";

// Gamitin ang aplikasyon na autoloader para i-autoload ang mga klase
$loader = bagong Loader();

$loader->registerDirs(
     [
        ROOT_PATH,
    ]
);

$loader->register();

$di = bagong FactoryDefault();

Di::reset();

// Maglagay ng nga kailangan na serbisyo para sa DI dito

Di::setDefault($di);
```

Should you need to test any components from your own library, add them to the autoloader or use the autoloader from your main application.

To help you build the Unit Tests, we made a few abstract classes you can use to bootstrap the Unit Tests themselves. These files exist in the [Phalcon Incubator](https://github.com/phalcon/incubator).

You can use the Incubator library by adding it as a dependency:

```bash
composer require phalcon/incubator
```

or by manually adding it to `composer.json`:

```json
{
    "require": {
        "phalcon/incubator": "^3.2"
    }
}
```

You can also clone the repository using this link: https://github.com/phalcon/incubator.

<a name='phpunit-config'></a>

## The `phpunit.xml` file

Now, create a `phpunit.xml` file as follows:

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