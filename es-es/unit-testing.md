- - -
layout: default language: 'en' version: '4.0' title: 'Pruebas Unitarias' keywords: 'pruebas unitarias, phpunit, phalcon'
- - -
# Pruebas Unitarias
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg) ![](/assets/images/level-intermediate.svg)

## Preámbulo

Escribir pruebas adecuadas puede ayudar a escribir mejor software. Si configura correctamente los casos de prueba puede eliminar la mayoría de errores funcionales y mantener mejor su software.

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

Una vez que PHPUnit está instalado, cree un directorio llamado `tests` en el directorio raíz del proyecto con un subdirectorio llamado `Unit`:

```
app/
src/
public/
tests/Unit/
```

### Configurar el espacio de nombres de prueba

Para autocargar nuestro directorio de pruebas, debemos añadir nuestro espacio de nombres de prueba a composer. Añada lo siguiente a composer y modifíquelo según sus necesidades.

```json
{
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests"
        }
    }
}
```

Ahora, cree un fichero `phpunit.xml` como sigue:

### El archivo `phpunit.xml`

Modifique el siguiente `phpunit.xml` para cubrir sus necesidades y guárdelo en el directorio raíz de su proyecto. Esto ejecutará cualquier prueba bajo el directorio `tests/Unit`.

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

Phalcon proporciona una librería de pruebas que proporciona algunas clases abstractas que puede usar para arrancar las Pruebas Unitarias. Estos ficheros existen en el repositorio [Phalcon Incubator Test](https://github.com/phalcon/incubator-test).

Puede usar la librería de pruebas de Incubator añadiéndola como dependencia:

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

Siempre es aconsejable autocargar sus clases usando espacios de nombres. La configuración siguiente asume que está usando PSR-4 para autocargar las clases de su proyecto vía configuración de composer. Entonces, el autocargador se asegurará de que se carguen los ficheros apropiados, por lo que todo lo que necesita es crear los ficheros y phpunit ejecutará las pruebas por usted.

Este ejemplo no contiene un archivo de configuración, ya que la mayoría de los casos debería estar simulando sus dependencias. Si necesita uno, puede añadir al `DI` en el `AbstractUnitTest`.

### Prueba Unitaria Abstracta
Primero cree una Prueba Unitaria base llamada `AbstractUnitTest.php` en su directorio `tests/Unit`:

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

Cree la prueba siguiente y guárdela en su directorio `tests/Unit`.

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

Si necesita sobrecargar el método `setUp`, es importante llamar al padre o Phalcon no se inicializará correctamente.
```php
    protected function setUp(): void
    {
        parent::setUp();

        //some setup mocks
    }

```

### Ejecución de Pruebas Unitarias

Cuando ejecute `vendor/bin/phpunit` en su línea de comandos, obtendrá la siguiente salida:

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
