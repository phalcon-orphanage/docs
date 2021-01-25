- - -
layout: default language: 'en' version: '4.0' title: 'Unit Testing' keywords: 'unit testing, phpunit, phalcon'
- - -
# Pruebas Unitarias
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg) ![](/assets/images/level-intermediate.svg)

## Preámbulo

Writing proper tests can assist in writing better software. If you set up proper test cases you can eliminate most functional bugs and better maintain your software.

## Integrando PHPUnit con Phalcon

```bash
composer require --dev phpunit/phpunit:^9.0
```

o agregando manualmente al archivo `composer.json`:

```json
{
    "require-dev": {
        "phpunit/phpunit": "^9.0"
    }
}
```

Once PHPUnit is installed, create a directory called `tests` in project root directory with a subdirectory called `Unit`:

```
app/
src/
public/
tests/Unit/
```

### Configurar el espacio de nombres de prueba

In order to autoload our test directory, we must add our test namespace to composer. Add the below to composer and modify it to fit your needs.

```json
{
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests"
        }
    }
}
```

Now, create a `phpunit.xml` file as follows:

### El archivo `phpunit.xml`

Modify the `phpunit.xml` below to fit your needs and save it in your project root directory. This will run any tests under the `tests/Unit` directory.

```xml
<?xml version="1.0" encoding="UTF-8"?>

<phpunit backupGlobals="false"
         backupStaticAttributes="false"
         verbose="true"
         colors="true"
         convertErrorsToExceptions="true"
         convertNoticesToExceptions="true"
         convertWarningsToExceptions="true"
         processIsolation="false"
         stopOnFailure="false">

    <testsuite name="Phalcon - Unit Test">
        <directory>./tests/Unit</directory>
    </testsuite>
</phpunit>
```

### Phalcon Incubator Test

Phalcon provides a test library that provides few abstract classes you can use to bootstrap the Unit Tests themselves. These files exist in [Phalcon Incubator Test](https://github.com/phalcon/incubator-test) repository.

You can use the Incubator test library by adding it as a dependency:

```bash
composer require --dev phalcon/incubator-test:^v1.0.0-alpha.1
```

o agregando manualmente al archivo `composer.json`:

```json
{
    "require-dev": {
        "phalcon/incubator-test": "^v1.0.0-alpha.1"
    }
}
```

## Creando una prueba unitaria

It is always wise to autoload your classes using namespaces. The configuration below assumes that you are using PSR-4 to autoload your project classes via a composer configuration. Doing so, the autoloader will make sure the proper files are loaded so all you need to do is create the files and phpunit will run the tests for you.

This example does not contain a config file, as most cases you should be mocking your dependencies. If you happen to need one, you can add to the `DI` in the `AbstractUnitTest`.

### Prueba Unitaria Abstracta
First create a base Unit Test called `AbstractUnitTest.php` in your `tests/Unit` directory:

```php
<?php

declare(strict_types=1);

namespace Tests\Unit;

use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Phalcon\Incubator\Test\PHPUnit\UnitTestCase;
use PHPUnit\Framework\IncompleteTestError;

abstract class AbstractUnitTest extends UnitTestCase
{
    private bool $loaded = false;

    protected function setUp(): void
    {
        parent::setUp();

        $di = new FactoryDefault();

        Di::reset();
        Di::setDefault($di);

        $this->loaded = true;
    }

    public function __destruct()
    {
        if (!$this->loaded) {
            throw new IncompleteTestError(
                "Please run parent::setUp()."
            );
        }
    }
}
```

### Tu Primera Prueba

Create the test below and save it in your `tests/Unit` directory.

```php
<?php

declare(strict_types=1);

namespace Tests\Unit;

class UnitTest extends AbstractUnitTest
{
    public function testTestCase(): void
    {
        $this->assertEquals(
            "roman",
            "roman",
            "This will pass"
        );

        $this->assertEquals(
            "hope",
            "ava",
            "This will fail"
        );
    }
}
```

If you need to overload the `setUp` method, it is important you call the parent or Phalcon will not properly initialize.
```php
    protected function setUp(): void
    {
        parent::setUp();

        //some setup mocks
    }

```

### Ejecución de Pruebas Unitarias

When you execute `vendor/bin/phpunit` in your command-line, you will get the following output:

```bash
$ phpunit
PHPUnit 9.1.4 by Sebastian Bergmann and contributors.

Runtime:       PHP 7.4.5 with Xdebug 2.9.5
Configuration: /var/www//phpunit.xml


Time: 3 ms, Memory: 3.25Mb

There was 1 failure:

1) Test\Unit\UnitTest::testTestCase
This will fail
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
-'hope'
+'ava'

/var/www/tests/Unit/UnitTest.php:25

FAILURES!
Tests: 1, Assertions: 2, Failures: 1.
```

## Recursos
- [Documentación de PHPUnit](https://phpunit.de/documentation.html)
- [Comenzando con TDD en PHP](https://www.sitepoint.com/re-introducing-phpunit-getting-started-tdd-php/)
- [Escribir Grandes Pruebas Unitarias](https://blog.stevensanderson.com/2009/08/24/writing-great-unit-tests-best-and-worst-practises/)
- [Qué es *Mocking* en la Prueba Unitaria de PHP](https://www.clariontech.com/blog/what-is-mocking-in-php-unit-testing)
