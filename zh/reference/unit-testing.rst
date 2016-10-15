单元测试（Unit testing）
========================

Writing proper tests can assist in writing better software. If you set up proper test cases you can eliminate most functional bugs and better maintain your software.

适当的测试有帮于更好的编写软件。如果你设置了适当的测试用例，可以消除大多数功能性的错误，并且更好地维护你的软件。

整合 PHPunit 到 phalcon（Integrating PHPunit with phalcon）
-----------------------------------------------------------
If you don't already have phpunit installed, you can do it by using the following composer command:

如果你还没有安装好 phpunit，可以使用以下 composer 命令：

.. code-block:: bash

    composer require phpunit/phpunit


or by manually adding it to composer.json:

或者手动添加 composer.json：

.. code-block:: json

    {
        "require-dev": {
            "phpunit/phpunit": "~4.5"
        }
    }

Once phpunit is installed create a directory called 'tests' in your root directory:

phpunit 安装后将会在你的根目录创建一个名为 'tests' 的目录：

.. code-block:: bash

    app/
    public/
    tests/

Next, we need a 'helper' file to bootstrap the application for unit testing.

接下来，我们需要用一个 'helper' 文件来引导单元测试程序。

PHPunit 辅助文件（The PHPunit helper file）
-------------------------------------------
A helper file is required to bootstrap the application for running the tests. We have prepared a sample file. Put the file in your tests/ directory as TestHelper.php.

需要使用 helper 文件来引导运行测试程序。我们预先准备好一个示例文件，将该文件放到 tests/ 目录下并命名为 TestHelper.php

.. code-block:: php

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

    // Required for phalcon/incubator
    include __DIR__ . "/../vendor/autoload.php";

    // Use the application autoloader to autoload the classes
    // Autoload the dependencies found in composer
    $loader = new Loader();

    $loader->registerDirs(
        [
            ROOT_PATH,
        ]
    );

    $loader->register();

    $di = new FactoryDefault();

    Di::reset();

    // Add any needed services to the DI here

    Di::setDefault($di);

Should you need to test any components from your own library, add them to the autoloader or use the autoloader from your main application.

你需要从自己的 library 类库中测试组件，将它们添加到 autoloader 加载器或在主程序中使用 autoloader 加载器。

To help you build the unit tests, we made a few abstract classes you can use to bootstrap the unit tests themselves.
These files exist in the Phalcon incubator @ https://github.com/phalcon/incubator.

为了更好地帮助你构建单元测试，我们写了一些抽象的类库，你可以使用这些抽象类来引导单元测试。
这些文件在 @ https://github.com/phalcon/incubator.

You can use the incubator library by adding it as a dependency:

你可以添加 incubator 依赖库：

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

PHPunit.xml 文件（PHPunit.xml file）
------------------------------------
Now, create a phpunit file:

现在，创建一个 phpunit 文件：

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

按照你的需求修改 phpunit.xml 然后保存到 tests/ 目录。

This will run any tests under the tests/ directory.

你将在 tests/ 目录运行所有测试。

简单的单元测试（Sample unit test）
----------------------------------
To run any unit tests you need to define them. The autoloader will make sure the proper files are loaded so all you need to do is create the files and phpunit will run the tests for you.

要运行任何单元测试，你要事先定义好。autoloader 加载器将确保正确的文件被加载进来，所以你需要做的是创建文件然后 phpunit 运行测试。

This example does not contain a config file, most test cases however, do need one. You can add it to the DI to get the UnitTestCase file.

该示例不包含配置文件，但大多数测试用例都需要配置文件，你可以将它添加到 DI 得到 UnitTestCase 文件。

First create a base unit test called UnitTestCase.php in your /tests directory:

首先在 /tests 目录创建一个 UnitTestCase.php 基本单元测试：

.. code-block:: php

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

It's always a good idea to separate your Unit tests in namespaces. For this test we will create the namespace 'Test'. So create a file called \tests\Test\UnitTest.php:

独立命名空间的单元测试是一个很好的主意，对于这个测试创建命名空间 'Test'，即创建一个文件名为 \tests\Test\UnitTest.php:

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

Now when you execute 'phpunit' in your command-line from the \tests directory you will get the following output:

你现在可以在命令行 \tests 目录执行 'phpunit' 得到以下输出：

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

现在，你可以开始构建单元测试了。你可以在这里查看一份很好的指南（如果你不熟悉PHPUnit，我们也推荐阅读PHPUnit文档）

http://blog.stevensanderson.com/2009/08/24/writing-great-unit-tests-best-and-worst-practises/
