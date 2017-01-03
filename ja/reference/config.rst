設定の読み込み
======================

:doc:`Phalcon\\Config <../api/Phalcon_Config>` は、アプリケーション内で使用する様々なフォーマットの設定ファイルを
PHP オブジェクトに変換する際に使用するコンポーネントです。

配列
-------------
最初の例はネイティブの配列をどのように :doc:`Phalcon\\Config <../api/Phalcon_Config>` オブジェクトに変換しているのかを見せています。
この選択肢はリクエストの間に読み込むファイルがないので最高のパフォーマンスを提供します。

.. code-block:: php

    <?php

    use Phalcon\Config;

    $settings = [
        "database" => [
            "adapter"  => "Mysql",
            "host"     => "localhost",
            "username" => "scott",
            "password" => "cheetah",
            "dbname"   => "test_db"
        ],
         "app" => [
            "controllersDir" => "../app/controllers/",
            "modelsDir"      => "../app/models/",
            "viewsDir"       => "../app/views/"
        ],
        "mysetting" => "the-value"
    ];

    $config = new Config($settings);

    echo $config->app->controllersDir, "\n";
    echo $config->database->username, "\n";
    echo $config->mysetting, "\n";

プロジェクトをより体系化したい場合、配列を他のファイルに保存し、それから読み込むこともできます。

.. code-block:: php

    <?php

    use Phalcon\Config;

    require "config/config.php";

    $config = new Config($settings);

ファイル アダプタ
-----------------
有効なアダプタは下記の通りです:

+----------------------------------------------------------------------------+------------------------------------------------------------------------------------------------+
| クラス                                                                      | 説明                                                                                    |
+============================================================================+================================================================================================+
| :doc:`Phalcon\\Config\\Adapter\\Ini <../api/Phalcon_Config_Adapter_Ini>`   | 設定の保存形式に INI ファイルを使用する。内部でアダプタは PHP 関数の parse_ini_file を使用する。 |
+----------------------------------------------------------------------------+------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Config\\Adapter\\Json <../api/Phalcon_Config_Adapter_Json>` | 設定の保存形式に JSON ファイルを使用する。                                                             |
+----------------------------------------------------------------------------+------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Config\\Adapter\\Php <../api/Phalcon_Config_Adapter_Php>`   | 設定の保存形式に PHP の多次元配列を使用する。このアダプタは最高のパフォーマンスを提供する。                     |
+----------------------------------------------------------------------------+------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Config\\Adapter\\Yaml <../api/Phalcon_Config_Adapter_Yaml>` | 設定の保存形式に YAML ファイルを使用する。                                                             |
+----------------------------------------------------------------------------+------------------------------------------------------------------------------------------------+

INI ファイルの読み込み
---------------------
INI ファイルは設定を保存するための、よくある方法の一つです。:doc:`Phalcon\\Config <../api/Phalcon_Config>` はこれらのファイルを読む際、最適化された PHP の関数 :code:`parse_ini_file` を使用します。ファイルに記載したセクションはアクセスしやすいように階層付き設定へと変換します。

.. code-block:: ini

    [database]
    adapter  = Mysql
    host     = localhost
    username = scott
    password = cheetah
    dbname   = test_db

    [phalcon]
    controllersDir = "../app/controllers/"
    modelsDir      = "../app/models/"
    viewsDir       = "../app/views/"

    [models]
    metadata.adapter  = "Memory"

ファイルは次のようにして読み込むことができます:

.. code-block:: php

    <?php

    use Phalcon\Config\Adapter\Ini as ConfigIni;

    $config = new ConfigIni("path/config.ini");

    echo $config->phalcon->controllersDir, "\n";
    echo $config->database->username, "\n";
    echo $config->models->metadata->adapter, "\n";

設定のマージ
----------------------
:doc:`Phalcon\\Config <../api/Phalcon_Config>` は設定オブジェクトのプロパティを、他の設定オブジェクトへ再帰的にマージすることができます。
新しいプロパティは追加され、すでにあるプロパティは更新されます。

.. code-block:: php

    <?php

    use Phalcon\Config;

    $config = new Config(
        [
            "database" => [
                "host"   => "localhost",
                "dbname" => "test_db",
            ],
            "debug" => 1,
        ]
    );

    $config2 = new Config(
        [
            "database" => [
                "dbname"   => "production_db",
                "username" => "scott",
                "password" => "secret",
            ],
            "logging" => 1,
        ]
    );

    $config->merge($config2);

    print_r($config);

上記のコードは、次のようになります:

.. code-block:: html

    Phalcon\Config Object
    (
        [database] => Phalcon\Config Object
            (
                [host] => localhost
                [dbname]   => production_db
                [username] => scott
                [password] => secret
            )
        [debug] => 1
        [logging] => 1
    )

`Phalcon Incubator <https://github.com/phalcon/incubator>` にはこのコンポーネントのために利用できる複数のアダプタがあります。

構造の依存性を注入する
----------------------------------
:doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>` の内部で :doc:`Phalcon\\Config <../api/Phalcon_Config>` を使用することで、コントローラに構造の依存性を注入することができます。実現するには設定を呼びたいスクリプト内で次のようなコードを仕込みます。

.. code-block:: php

    <?php

    use Phalcon\Di\FactoryDefault;
    use Phalcon\Config;

    // DI の作成
    $di = new FactoryDefault();

    $di->set(
        "config",
        function () {
            $configData = require "config/config.php";

            return new Config($configData);
        }
    );

これで、次のコードのように `config` という名前を使って、コントローラ内から設定にアクセスできます:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class MyController extends Controller
    {
        private function getDatabaseName()
        {
            return $this->config->database->dbname;
        }
    }
