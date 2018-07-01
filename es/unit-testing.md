<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Guía de Pruebas</a> 
      <ul>
        <li>
          <a href="#integration">Integrando PHPUnit con Phalcon</a>
        </li>
        <li>
          <a href="#unit-helper">El archivo de ayuda de PHPUnit</a>
        </li>
        <li>
          <a href="#phpunit-config">El archivo phpunit.xml</a>
        </li>
        <li>
          <a href="#sample">Ejemplo de Test Unitario</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Guía de Pruebas

Writing proper tests can assist in writing better software. If you set up proper test cases you can eliminate most functional bugs and better maintain your software.

<a name='integration'></a>

## Integrando PHPUnit con Phalcon

Si no tienes instalado PHPUnit, puedes hacerlo mediante el siguiente comando de composer:

```bash
composer require phpunit/phpunit:^5.0
```

o agregando manualmente al archivo `composer.json`:

```json
<br />{
    "require-dev": {
        "phpunit/phpunit": "^5.0"
    }
}
```

Una vez instalado PHPUnit, cree un directorio llamado `tests` en el directorio raíz del proyecto:

    app/
    public/
    tests/
    

A continuación, necesitamos un archivo de 'helper' (ayudante) para arrancar la aplicación para pruebas unitarias.

<a name='unit-helper'></a>

## El archivo de ayuda de PHPUnit

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

// Phalcon/incubator es requerido
include __DIR__ . "/../vendor/autoload.php";

// Utilice el autocargador de la aplicación para auto cargar las clases
// Carga automáticamente las dependencias encontradas en Composer
$loader = new Loader();

$loader->registerDirs(
    [
        ROOT_PATH,
    ]
);

$loader->register();

$di = new FactoryDefault();

Di::reset();

// Agregar cualquier otro servicio necesario en el DI

Di::setDefault($di);
```

Si usted necesita probar cualquiera de los componentes de su propia biblioteca, agregarlos al Autocargador o use el cargador automático de la aplicación principal.

Para ayudarlo a construir las Pruebas unitarias, hicimos algunas clases abstractas que puede usar para iniciar las Pruebas unitarias. Estos archivos existen en la [Incubadora de Phalcon](https://github.com/phalcon/incubator).

Puede usar la biblioteca de la incubadora al agregarla como una dependencia:

```bash
composer require phalcon/incubator
```

o agregando manualmente al archivo `composer.json`:

```json
{
    "require": {
        "phalcon/incubator": "^3.0"
    }
}
```

También puede clonar el repositorio utilizando el link anterior.

<a name='phpunit-config'></a>

## El archivo `phpunit.xml`

Ahora, cree un archivo `phpunit.xml` como el siguiente:

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

## Ejemplo de Test Unitario

To run any Unit Tests you need to define them. The autoloader will make sure the proper files are loaded so all you need to do is create the files and phpunit will run the tests for you.

This example does not contain a config file, most test cases however, do need one. You can add it to the `DI` to get the `UnitTestCase` file.

En primer lugar crear una prueba unitaria base llamada `UnitTestCase.php` en el directorio de `tests`:

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

        // Cargar todo servicio adicional que sea necesario durante el testeo
        $di = Di::getDefault();

        // Obtenga cualquier componente del DI aquí. Si tiene un config, debe pasarlo como parámetro

        $this->setDi($di);

        $this->_loaded = true;
    }

    /**
     * Comprobar si los casos de prueba se configuraron adecuadamente
     *
     * @throws \PHPUnit_Framework_IncompleteTestError;
     */
    public function __destruct()
    {
        if (!$this->_loaded) {
            throw new \PHPUnit_Framework_IncompleteTestError(
                "Por favor, ejecutar parent::setUp()."
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
 * Clase UnitTest
 */
class UnitTest extends \UnitTestCase
{
    public function testTestCase()
    {
        $this->assertEquals(
            "works",
            "works",
            "Esto esta OK"
        );

        $this->assertEquals(
            "works",
            "works1",
            "Esto fallará"
        );
    }
}
```

Ahora al ejecutar `phpunit` en su línea de comandos desde el directorio `tests` obtendrá el siguiente resultado:

```bash
$ phpunit
PHPUnit 3.7.23 by Sebastian Bergmann.

Configuration read from /var/www/tests/phpunit.xml

Time: 3 ms, Memory: 3.25Mb

There was 1 failure:

1) Test\UnitTest::testTestCase
Esto fallará
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

Ahora puede empezar a construir sus pruebas unitarias. Puede ver una [buena guía aquí](http://blog.stevensanderson.com/2009/08/24/writing-great-unit-tests-best-and-worst-practises/). Recomendamos leer la documentación de PHPUnit si no estás familiarizado con el mismo.