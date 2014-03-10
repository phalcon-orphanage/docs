%{unit-testing_93c36b818e7a033e49bcfca15cf4a457}%

============
%{unit-testing_913bdc0bf8890f572477f716921bce6f}%


%{unit-testing_a374e53efc365f0011a90be76a2011f1}%

--------------------------------
%{unit-testing_9ee5e794b8771e2e59d55108fc06a51c}%


.. code-block:: bash

  composer require phpunit/phpunit


%{unit-testing_cfb67edd8028fccf1890a9e61996576f}%

.. code-block:: json

  {
      "require-dev": {
          "phpunit/phpunit": "3.7.*"
      }
  }


%{unit-testing_7158fa84941c11d4c263ca6f70ec9b55}%

.. code-block:: bash

  pear config-set auto_discover 1
  pear install pear.phpunit.de/PHPUnit


%{unit-testing_01b882fdd393c5cf8f49db9c45d0c429}%

.. code-block:: bash

  app/
  public/
  tests/

%{unit-testing_5e798a26464742bf1b4d0853b3714cbb}%

%{unit-testing_2fbbf0b2ba6267b9e8972743c9ecb0de}%

-----------------------
%{unit-testing_542e5c5081d63b58ac3a10408c0a248f}%


.. code-block:: php

  <?php
  use Phalcon\DI,
      Phalcon\DI\FactoryDefault;

  ini_set('display_errors',1);
  error_reporting(E_ALL);

  define('ROOT_PATH', __DIR__);
  define('PATH_LIBRARY', __DIR__ . '/../app/library/');
  define('PATH_SERVICES', __DIR__ . '/../app/services/');
  define('PATH_RESOURCES', __DIR__ . '/../app/resources/');

  set_include_path(
      ROOT_PATH . PATH_SEPARATOR . get_include_path()
  );

  // {%unit-testing_00ac09769e1af2648931a185f1775955%}
  include __DIR__ . "/../vendor/autoload.php";

  // {%unit-testing_479a204750c7d5981daed72ca69a78a2%}
  // {%unit-testing_8f0283e06cded3c28aa083c40e16ad2b%}
  $loader = new \Phalcon\Loader();

  $loader->registerDirs(array(
      ROOT_PATH
  ));

  $loader->register();

  $di = new FactoryDefault();
  DI::reset();

  // {%unit-testing_14ae3487ceb261a5061f7a58b5b34bc3%}

  DI::setDefault($di);


%{unit-testing_1bc7cf965b5ce77251227ee6e93e3e42}%

%{unit-testing_8cfec838da9bf8556c3d57fd17a80857}%

%{unit-testing_9a6558d79099380d81048ef8b2584c86}%

.. code-block:: bash

  composer require phalcon/incubator


%{unit-testing_cfb67edd8028fccf1890a9e61996576f}%

.. code-block:: json

  {
      "require": {
          "phalcon/incubator": "dev-master"
      }
  }

%{unit-testing_f29e2c3667fd0cc18fcab99af326c9b5}%

%{unit-testing_f0e7d1800e89c826c992746b97d2f9ce}%

----------------
%{unit-testing_f54691d838d46e24cb3f8f16922dfef5}%


.. code-block:: xml

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

%{unit-testing_c5eced327019c69c1a195cef8ae7de44}%

%{unit-testing_103d5109169bc994b7d042bbb413abf5}%

%{unit-testing_2f3d3e7963ba338498e407db381b4865}%

----------------
%{unit-testing_2d9ec2e85445092d5f8854cdfc0e9927}%


%{unit-testing_88347cd5b1e7bc9a380a67423710c883}%

%{unit-testing_16fdcc6f360acf6eebaa9f05c3a97677}%

.. code-block:: php

  <?php
  use Phalcon\DI,
      \Phalcon\Test\UnitTestCase as PhalconTestCase;

  abstract class UnitTestCase extends PhalconTestCase {

      /**
       * @var \Voice\Cache
       */
      protected $_cache;

      /**
       * @var \Phalcon\Config
       */
      protected $_config;

      /**
       * @var bool
       */
      private $_loaded = false;

      public function setUp(Phalcon\DiInterface $di = NULL, Phalcon\Config $config = NULL) {

          // {%unit-testing_459c631d8fcd2d9dad5a04feb8db4a2a%}
          $di = DI::getDefault();

          // {%unit-testing_1b15f5a55e08aba69442e11350b90cf9%}

          parent::setUp($di);

          $this->_loaded = true;
      }

      /**
       * Check if the test case is setup properly
       * @throws \PHPUnit_Framework_IncompleteTestError;
       */
      public function __destruct() {
          if(!$this->_loaded) {
              throw new \PHPUnit_Framework_IncompleteTestError('Please run parent::setUp().');
          }
      }
  }

%{unit-testing_0bc81d8cc49b179612c2eb74ec6fa64b}%

.. code-block:: php

  <?php
  namespace Test;
  /**
   * Class UnitTest
   */
  class UnitTest extends \UnitTestCase {



      public function testTestCase() {

          $this->assertEquals('works',
              'works',
              'This is OK'
          );

          $this->assertEquals('works',
              'works1',
              'This wil fail'
          );


      }
  }


%{unit-testing_be4b3f760e54f265726e3bc674f4432a}%

.. code-block:: bash

  $ phpunit
  PHPUnit 3.7.23 by Sebastian Bergmann.

  Configuration read from /private/var/www/tests/phpunit.xml

  Time: 3 ms, Memory: 3.25Mb

  There was 1 failure:

  1) Test\UnitTest::testTestCase
  This wil fail
  Failed asserting that two strings are equal.
  --- Expected
  +++ Actual
  @@ @@
  -'works'
  +'works1'

  /private/var/www/tests/Test/UnitTest.php:25

  FAILURES!
  Tests: 1, Assertions: 2, Failures: 1.

%{unit-testing_bb89d76991e8b5db2aadbbe88424cbb9}%

