ユニットテスト
==============

適切なテストを書くことは、より良いソフトウェアを書く助けになります。適切なテストケースを組み立てれば、機能面のバグの多くを削減でき、より良いメンテナンスを行えるようになります。

PHPunitとphalconの統合
--------------------------------
PHPUnitをまだインストールしていないなら、以下のcomposerコマンドでインストールできます:

.. code-block:: bash

  composer require phpunit/phpunit:^5.0


あるいは、composer.json に以下の記述を追加します:

.. code-block:: json

    {
        "require-dev": {
            "phpunit/phpunit": "^5.0"
        }
    }

PHPUnitをインストールしたら、「tests」ディレクトリをルートディレクトリの直下に作成しましょう:

.. code-block:: bash

    app/
    public/
    tests/

次に、ユニットテストの前にアプリケーションを立ち上げるための「ヘルパー」ファイルが必要になります。

PHPunitヘルパーファイル
-----------------------
ヘルパーファイルは、テスト実行のためにアプリケーションを立ち上げます。以下のサンプルファイルを、tests/ ディレクトリに TestHelper.php として保存してください。

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

    // phalcon/incubator のために必要
    include __DIR__ . "/../vendor/autoload.php";

    // アプリケーションのオートローダを使用してクラスをオートロードする
    // composerの依存関係をオートロードする
    $loader = new Loader();

    $loader->registerDirs(
        [
            ROOT_PATH,
        ]
    );

    $loader->register();

    $di = new FactoryDefault();

    Di::reset();

    // 必要なサービスをDIに登録する

    Di::setDefault($di);

独自ライブラリのコンポーネントをテストするなら、それらをオートローダーに登録するか、アプリケーション本体のオートローダを使用してください。

ユニットテストの作成を助けるため、ユニットテスト自体を立ち上げる抽象クラスを用意しました。これらのファイルは https://github.com/phalcon/incubator にあるPhalcon incubatorの中にあります。

incubatorライブラリを使うには以下のcomposerコマンドで追加します:

.. code-block:: bash

    composer require phalcon/incubator


あるいは、composer.json に以下の記述を追加します:

.. code-block:: json

    {
        "require": {
            "phalcon/incubator": "^3.0"
        }
    }

あるいは、リポジトリを上のリンクからgitでcloneすることもできます。

PHPunit.xml ファイル
--------------------
次に、phpunitの設定ファイルを作成します:

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

phpunit.xml をお望みの設定に変更して、tests/ に保存します。

この設定では、tests/ ディレクトリ配下の全てのテストが実行されます。

ユニットテストのサンプル
------------------------
ユニットテストを実行するには、それらを定義する必要があります。オートローダが必要なファイルを読み込むので、必要なことはテストケースを作成することだけです。そうすれば、PHPUnitがテストを実行してくれます。

この例には設定ファイルが含まれていませんが、多くのテストケースでは設定ファイルの読み込みが必要になります。UnitTestCaseファイルでDIに追加することができます。

はじめに、UnitTestCase.php という名前のユニットテストのベースとなるクラスを、/tests ディレクトリの下に作りましょう:

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

            // テスト中に必要になる追加のサービスを読み込み
            $di = Di::getDefault();

            // ここで必要なDIコンポーネントを取得する。config があるなら、それを parent に渡すことを忘れずに

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

ユニットテストを名前空間で分割することは、良い考えです。このテストのために、「Test」という名前空間を作りましょう。ファイルは \tests\Test\UnitTest.php という名前になります:

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

いま、コマンドラインから \tests ディレクトリに入って「phpunit」コマンドを実行すると、以下の出力が得られます:

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

これで、ユニットテストを作り始めることができます。以下のリンク先に、優れたガイドがあります(PHPUnitに慣れていないなら、PHPUnitのドキュメントをあわせて読むことをおすすめします):

http://blog.stevensanderson.com/2009/08/24/writing-great-unit-tests-best-and-worst-practises/
