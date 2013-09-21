Модульное тестирование (Unit test)
==================================
Написание качественных тестов может помочь в созданиекачественного программного обеспечения. Если вы используете модульное тестирование
вы можете избежать большое количество ошибок и упростить поддержку программного обеспечение.

Интеграция Phalcon с PHPUnit
----------------------------
Если вы еще не установили PHPUnit, вы можете сделать это с помощью следующей команды composer:

.. code-block:: bash

  composer require phpunit/phpunit


или вручную добавить его в composer.json:

.. code-block:: json

  {
      "require-dev": {
          "phpunit/phpunit": "3.7.*"
      }
  }


Или, если у вас нет composer можно установить с помощью pear PHPUnit:

.. code-block:: bash

  pear config-set auto_discover 1
  pear install pear.phpunit.de/PHPUnit


После установки PHPUnit, ​​создайте директорию tests' в корне проекта:

.. code-block:: bash

  app/
  public/
  tests/

Далее, нам понадобится файл "загрузчик" для подготовки приложения модульного тестирования.

Загрузчик PHPunit
-----------------
Файл загрузчик необходим для подготовки приложение к запуску тестов. Мы подготовили образец файла.
Поместите файл TestHelper.php в /tests.


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

  // required for phalcon/incubator
  include __DIR__ . "/../vendor/autoload.php";

  // use the application autoloader to autoload the classes
  // autoload the dependencies found in composer
  $loader = new \Phalcon\Loader();

  $loader->registerDirs(array(
      ROOT_PATH
  ));

  $loader->register();

  $di = new FactoryDefault();
  DI::reset();

  // add any needed services to the DI here

  DI::setDefault($di);


Если вам необходимо протестировать любой компонент из вашей библиотеки, добавьте их в автозагрузку,
или использовать загрузчик вашего основного приложения.

Чтобы помочь вам построить юнит-тесты, мы сделали несколько абстрактных классов, которые вы можете использовать для загрузки самих тестов.
Вы можете взять их в репозитарии инкубатора Phalcon @ https://github.com/phalcon/incubator.

Вы можете использовать инкубатор добавив его в зависимости composer:

.. code-block:: bash

  composer require phalcon/incubator


или вручную добавить его в composer.json:

.. code-block:: json

  {
      "require": {
          "phalcon/incubator": "dev-master"
      }
  }

Вы также можете клонировать репозитория, используя ссылку выше.

Файл PHPunit.xml
----------------
Теперь создайте phpunit файл:

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

Изменить phpunit.xml чтобы соответствовал вашим потребностям и сохраните его в tests/.

Пример юнит-теста
-----------------
Для работы с юнит-тестом необходимо его определить. Автозагрузчик сам будет загружать все созданные вами файлы и передавать из
PHPUnit для выполнения тестов.
так что вам нужно сделать, это создать файлы и PHPUnit будет запускать тесты для вас.

Этот пример не содержит конфигурационного файла, хотя в большинстве случаев без него не обойтись в тестах.
Вы можете добавить его в DI и получить его файле UnitTestCase.

Сначала создайте базовый файл для ваших юнть-тестов UnitTestCase.php в папке /tests:

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

      public function setUp() {

          // Load any additional services that might be required during testing
          $di = DI::getDefault();

          // get any DI components here, if you have a config, be sure to pass it to the parent

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

Хорошая идея, разделять юнит-тесты тесты в пространствах имен. Для этого теста мы создадим
пространство имен 'Test'. Создайте файл с названием \tests\Test\UnitTest.php:

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


После выполнения 'phpunit' в командной строке в каталоге \tests вы получите следующий результат:

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

Теперь вы можете начать писать собственные юнит-тесты. Здесь находится хорошее руководство (
Мы рекомендуем вам ознокомится с документацией PHPUnit, если вы ещё не знакомы с PHPUnit):

http://blog.stevensanderson.com/2009/08/24/writing-great-unit-tests-best-and-worst-practises/
