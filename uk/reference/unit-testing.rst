Unit testing
============

Writing proper tests can assist in writing better software. If you set up proper test cases you can eliminate most functional bugs and better maintain your software.

Integrating PHPunit with phalcon
--------------------------------
If you don't already have phpunit installed, you can do it by using the following composer command:

.. code-block:: bash

    composer require phpunit/phpunit


or by manually adding it to composer.json:

.. code-block:: json

    {
        "require-dev": {
            "phpunit/phpunit": "~4.5"
        }
    }

Once phpunit is installed create a directory called 'tests' in your root directory:

.. code-block:: bash

    app/
    public/
    tests/

Next, we need a 'helper' file to bootstrap the application for unit testing.

The PHPunit helper file
-----------------------
A helper file is required to bootstrap the application for running the tests. We have prepared a sample file. Put the file in your tests/ directory as TestHelper.php.

.. code-block:: php

    <?php

    use Phalcon\Di;
    use Phalcon\Di\FactoryDefault;

    ini_set('display_errors',1);
    error_reporting(E_ALL);

    define('ROOT_PATH', __DIR__);
    define('PATH_LIBRARY', __DIR__ . '/../app/library/');
    define('PATH_SERVICES', __DIR__ . '/../app/services/');
    define('PATH_RESOURCES', __DIR__ . '/../app/resources/');

    set_include_path(
        ROOT_PATH . PATH_SEPARATOR . get_include_path()
    );

    // Required for phalcon/incubator
    include __DIR__ . "/../vendor/autoload.php";

    // Use the application autoloader to autoload the classes
    // Autoload the dependencies found in composer
    $loader = new \Phalcon\Loader();

    $loader->registerDirs(
        array(
            ROOT_PATH
        )
    );

    $loader->register();

    $di = new FactoryDefault();
    Di::reset();

    // Add any needed services to the DI here

    Di::setDefault($di);

Should you need to test any components from your own library, add them to the autoloader or use the autoloader from your main application.

To help you build the unit tests, we made a few abstract classes you can use to bootstrap the unit tests themselves.
These files exist in the Phalcon incubator @ https://github.com/phalcon/incubator.

You can use the incubator library by adding it as a dependency:

.. code-block:: bash

    composer require phalcon/incubator


or by manually adding it to composer.json:

.. code-block:: json

    {
        "require": {
            "phalcon/incubator": "dev-master"
        }
    }

You can also clone the repository using the repo link above.

PHPunit.xml file
----------------
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

Sample unit test
----------------
To run any unit tests you need to define them. The autoloader will make sure the proper files are loaded so all you need to do is create the files and phpunit will run the tests for you.

This example does not contain a config file, most test cases however, do need one. You can add it to the DI to get the UnitTestCase file.

First create a base unit test called UnitTestCase.php in your /tests directory:

.. code-block:: php

    <?php

    use Phalcon\Di;
    use Phalcon\Test\UnitTestCase as PhalconTestCase;

    abstract class UnitTestCase extends PhalconTestCase
    {
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
                throw new \PHPUnit_Framework_IncompleteTestError('Please run parent::setUp().');
            }
        }
    }

It's always a good idea to separate your Unit tests in namespaces. For this test we will create the namespace 'Test'. So create a file called \tests\Test\UnitTest.php:

.. code-block:: php

    <?php

    namespace Test;

    /**
     * Class UnitTest
     */
    class UnitTest extends \UnitTestCase
    {
        public function testTestCase()
        {
            $this->assertEquals('works',
                'works',
                'This is OK'
            );

            $this->assertEquals('works',
                'works1',
                'This will fail'
            );
        }
    }

Now when you execute 'phpunit' in your command-line from the \tests directory you will get the following output:

.. code-block:: bash

    $ phpunit
    PHPUnit 3.7.23 by Sebastian Bergmann.

    Configuration read from /private/var/www/tests/phpunit.xml

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

    /private/var/www/tests/Test/UnitTest.php:25

    FAILURES!
    Tests: 1, Assertions: 2, Failures: 1.

Now you can start building your unit tests. You can view a good guide here (we also recommend reading the PHPunit documentation if you're not familiar with PHPunit):

http://blog.stevensanderson.com/2009/08/24/writing-great-unit-tests-best-and-worst-practises/
