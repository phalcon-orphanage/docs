<div class='article-menu'>
  <ul>
    <li>
      <a href="#pangkalahatang-ideya">Pangkalahatang-ideya</a> <ul>
        <li>
          <a href="#integrasyon">Pagsasama ang PHPUnit sa Phalcon</a>
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

Kung kailangan mong subukan ang anumang bahagi mula sa iyong sariling aklatan, idagdag ito sa autoloader o gamitin ang autoloader mula sa iyong pangunahing aplikasyon.

Para matulungan kang bumuo ng Yunit Tests, gumawa kami ng mga abstrak na klase na maari mong gamitin upang ma bootstrap ang mga Yunit Tests. Ang mga kikil na ito ay makikita sa [Phalcon Incubator](https://github.com/phalcon/incubator).

Maari mong gamitin ang aklatan ng limliman sa pagdagdag nito bilang dependency:

```bash
ang kompositor ay nangangailangan ng phalcon/incubator
```

o mano-manong i-dagdag ito sa `conposer.json`:

```json
{
    "require":{
        "phalcon/incubator": "^3.2"
    }
}
```

Maari mo ring kopyahin ang bodiga gamit ang link na ito: https://github.com/phalcon/incubator.

<a name='phpunit-config'></a>

## Ang`phpunit.xml`file

Ngayon, lumikha ng `phpunit.xml` file katulad nito:

```xml
<?xml version="1.0" encoding=UTF-8"?>

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

Baguhin ang `phpunit.xml` para maangkop sa iyong kailangan at i-save ito sa `tests`. Ito ay magtatakbo ng mga pasulit ibaba sa `tests` na direktoryo.

<a name='sample'></a>

## Halimbawa Ng Yunit Test

Para magpatakbo ng anumang Yunit Tests kailangan mo silang bigyan ng kahulugan. Ang autoloader ay titiyakin na ang wastong mga files ay nailagay kaya ang kailangan mo lang gawin ay gawin ang mga files at ang phpunit ang magpapatakbo ng mga pagsusuri para sayo.

Ang halimbawa na ito ay hindi naglalaman ng config file, karamihan sa mga pagsusuri na kaso, kailangan ng isam Maari mo itong i-dagdag sa `DI` para makuha ang `UnitTestCase` file.

Lumikha muna ng takad na Yunit Test na tinatawag na `UnitTestCase.php` sa iyong `tests` direktoryo:

```php
<?php

gumamit ng Phalcon\Di;
gumamit ng Phalcon\Test\UnitTestCase bilang PhalconTestCase;

klase ng abstrak UnitTestCase ay pinapahaba ang PhalconTestCase
{
    /**
     * @var bool
     */
        private $_loaded=false;

    public function setUp()
    {
        parent::setUp();

        //mag load ng anumang mga serbisyo na kailngan habang nagsusuri
        $di = Di::getDefault();

        // Kumuha ng anumang DI na mga bahagi dito. Kung ikaw ay mayroong config, dapat siguraduhin na ipasa ito sa magulang

        $this->setDi($di);

        $this->_loaded = true;
    }

    /**
     * Suriin kung ang kaso ng pagsusuri ay na set-up ng maayos
     *
     * @throws \PHPUNIT_Framework_IncompleteTestError;
     */
    public function__destruct()
    {
        kung (!$this->_loaded) {
                        itapon ang bagong \PHPUnit_ Framework_IncompleteTestError(
                "Please run  parent::setUp()."
            );
        }
    }
}
```

Isang palaging magandang idea na ihiwalay ang iyong Yunit Tests sa puwang ng pampangalan. Para sa pagsusuri na ito tayo ay lilikha ng puwang ng pampangalan na 'Test'. Kaya lumikha ng file na tinatawag na `tests\Test\UnitTest.php`:

```php
<?php

namespace Test;

/**
 * ClassUnitTest
 */
ang klase na UnitTest ay pinapahaba ang  \UnitTestCase
{
    public function testTestCase()
    {
        $this->assertEquals(
            "works",
            "works1",
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

Ngayon kung iyong isasagawa ang `phpunit` sa iyong linya ng utos galing sa `tests` na direktoryo makukuha mo ang mga output na ito:

```bash
$ phpunit
PHPUnit 3.7.23. by Sebastian Bergmann.

Basa ng kompigurasyon galing sa /var/www/tests/phpunit.xml

Oras:3 ms, Memorya: 3.25Mb

Mayroong 1 pagkakamali:


1) Test\UnitTest::testTestCase
Ito ay mabibigo
Nabigo sa pagpapahayag na ang dalawang tali ay pantay-pantay.
--- Inaasahan
+++ Aktwal
@@@@
-'works'
+'works1'

/var/www/tests/Test/UnitTest.php:25

NABIGO!
Pagsusulit: 1, Ginigiit: 2, Pagkabigo: 1.
```

Ngayon maari ka nang magsimulang magtayo ng iyong mga Yunit Tests. Maari mong tingnan ang [mabuting gabay dito](http://blog.stevensanderson.com/2009/08/24/writing-great-unit-tests-best-and-worst-practises/). Inirerekumenda din namin na basahin ang PHPUnit na dokumento kung ikaw ay hindi pamilyar sa PHPUnit.