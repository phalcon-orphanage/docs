Unit testing
============
Writing proper tests can assist in writing better software. If you set up proper test cases you can elimitate most 
functional bugs and better maintain your software.

Integrating PHPunit with phalcon
--------------------------------
If you don't already have phpunit installed, you can do it by using the following composer command:

.. code-block:: bash

  composer require phpunit/phpunit


or by manually adding it to composer.json:

.. code-block:: json

  {
      "require-dev": {
          "phpunit/phpunit": "3.7.*"
      }
  }


Or if you don't have composer you can install phpunit via pear:

.. code-block:: bash

  pear config-set auto_discover 1
  pear install pear.phpunit.de/PHPUnit


Once phpunit is installed create directory called 'tests' in your root directory:

.. code-block:: bash

  app/
  public/
  tests/
  
Next, we need a 'helper' file to bootstrap the application for unit testing.

The PHPunit helper file
------------------------
A helper file is required to bootstrap the application for running the tests. We have prepared a sample file. Put the
file in your tests/ directory as TestHelper.php.

.. code-block:: php

  <?php
  use Phalcon\DI,
      Phalcon\DI\FactoryDefault;
  
  define('ROOT_PATH', __DIR__);
  define('PATH_LIBRARY', __DIR__ . '/../app/library/');
  define('PATH_SERVICES', __DIR__ . '/../app/services/');
  define('PATH_RESOURCES', __DIR__ . '/../app/resources/');
  
  error_reporting(E_ALL);
  set_include_path(
      ROOT_PATH . PATH_SEPARATOR . get_include_path()
  );
  
  $configFile = ROOT_PATH . '/../app/config/config.php';
  if(!is_readable($configFile)) {
      throw new PHPUnit_Framework_IncompleteTestError(sprintf('config %s not readable', $configFile));
  }
  
  $config = include $configFile;
  
  // use the application autoloader to autoload the classes
  include PATH_RESOURCES . 'loader.php';
  
  $di = new FactoryDefault();
  DI::reset();
  include PATH_RESOURCES . 'services.php';
  DI::setDefault($di);


PHPunit.xml file
-----------------
Now, create a phpunit file:

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
  
Modify the phpunit.xml to fit your needs and save it in tests/.

This will run any tests under the tests/ directory. 
