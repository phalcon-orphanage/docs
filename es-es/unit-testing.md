* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Controladores

Escribir pruebas adecuadas puede ayudar a escribir mejor software. Si ha configurado correctamente los casos de prueba, puede eliminar la mayoría de los errores funcionales y mantener mejor su software.

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

Un archivo de ayuda es necesario para arrancar la aplicación para ejecutar las pruebas. Hemos preparado un archivo de ejemplo. Coloque el archivo en su directorio `tests/` como `TestHelper.php`.

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

Modificar el archivo `phpunit.xml` para sus necesidades y guardarlo en la carpeta `tests`. Esto ejecutará las pruebas bajo el directorio `tests`.

<a name='sample'></a>

## Ejemplo de Test Unitario

Para ejecutar pruebas unitarias será necesario definirlas. El autocargador se asegurará que se carguen los archivos correctos, todo lo que necesitas hacer es crear los archivos y phpunit ejecutará las pruebas para usted.

Este ejemplo no contiene un archivo de configuración, pero la mayoría de los casos de prueba sí lo necesitan. Puede agregarlo a `DI` para obtener el archivo `UnitTestCase`.

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

Siempre es una buena idea separar las pruebas unitarias en espacios de nombres. Para esta prueba crearemos el espacio de nombres 'Test'. Así que cree un archivo denominado `tests\Test\UnitTest.php`:

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

Ahora puede empezar a construir sus pruebas unitarias. You can view a [good guide here](https://blog.stevensanderson.com/2009/08/24/writing-great-unit-tests-best-and-worst-practises/). Recomendamos leer la documentación de PHPUnit si no estás familiarizado con el mismo.