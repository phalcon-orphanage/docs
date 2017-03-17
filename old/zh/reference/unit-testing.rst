单元测试（Unit testing）
========================

适当的测试有帮于更好的编写软件。如果你设置了适当的测试用例，可以消除大多数功能性的错误，并且更好地维护你的软件。

整合 PHPunit 到 phalcon（Integrating PHPunit with phalcon）
-----------------------------------------------------------
如果你还没有安装好 phpunit，可以使用以下 composer 命令：

.. code-block:: bash

    composer require phpunit/phpunit:^5.0


或者手动添加 composer.json：

.. code-block:: json

    {
        "require-dev": {
            "phpunit/phpunit": "^5.0"
        }
    }

phpunit 安装后将会在你的根目录创建一个名为 'tests' 的目录：

.. code-block:: bash

    app/
    public/
    tests/

接下来，我们需要用一个 'helper' 文件来引导单元测试程序。

PHPunit 辅助文件（The PHPunit helper file）
-------------------------------------------
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

你需要从自己的 library 类库中测试组件，将它们添加到 autoloader 加载器或在主程序中使用 autoloader 加载器。

为了更好地帮助你构建单元测试，我们写了一些抽象的类库，你可以使用这些抽象类来引导单元测试。
这些文件在 @ https://github.com/phalcon/incubator.

你可以添加 incubator 依赖库：

.. code-block:: bash

    composer require phalcon/incubator


或手动添加到 composer.json:

.. code-block:: json

    {
        "require": {
            "phalcon/incubator": "^3.0"
        }
    }

你也可以使用链接克隆仓库。

PHPunit.xml 文件（PHPunit.xml file）
------------------------------------
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

按照你的需求修改 phpunit.xml 然后保存到 tests/ 目录。

你将在 tests/ 目录运行所有测试。

简单的单元测试（Sample unit test）
----------------------------------
要运行任何单元测试，你要事先定义好。autoloader 加载器将确保正确的文件被加载进来，所以你需要做的是创建文件然后 phpunit 运行测试。

该示例不包含配置文件，但大多数测试用例都需要配置文件，你可以将它添加到 DI 得到 UnitTestCase 文件。

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

现在，你可以开始构建单元测试了。你可以在这里查看一份很好的指南（如果你不熟悉PHPUnit，我们也推荐阅读PHPUnit文档）

http://blog.stevensanderson.com/2009/08/24/writing-great-unit-tests-best-and-worst-practises/
