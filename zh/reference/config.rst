读取配置（Reading Configurations）
==================================

:doc:`Phalcon\\Config <../api/Phalcon_Config>` 是一个用于将各种格式的配置文件读取到PHP对象的组件（使用适配器）。

文件适配器（File Adapters）
---------------------------
可用的适配器有:

+-----------+---------------------------------------------------------------------------------------------------+
| 文件类型  | 解释                                                                                              |
+===========+===================================================================================================+
| Ini       | 使用INI文件来存储设置。内部适配器使用PHP函数 parse_ini_file。                                     |
+-----------+---------------------------------------------------------------------------------------------------+
| Array     | 使用PHP多维数组存储设置。这个适配器提供了最好的性能                                               |
+-----------+---------------------------------------------------------------------------------------------------+

原生数组（Native Arrays）
-------------------------
下面的例子展示如何将本地数组导入 :doc:`Phalcon\\Config <../api/Phalcon_Config>` 对象。此选项提供了最好的性能，因为在这个请求中没有读取文件。

.. code-block:: php

    <?php

    use Phalcon\Config;

    $settings = array(
        "database" => array(
            "adapter"  => "Mysql",
            "host"     => "localhost",
            "username" => "scott",
            "password" => "cheetah",
            "dbname"   => "test_db"
        ),
         "app" => array(
            "controllersDir" => "../app/controllers/",
            "modelsDir"      => "../app/models/",
            "viewsDir"       => "../app/views/"
        ),
        "mysetting" => "the-value"
    );

    $config = new Config($settings);

    echo $config->app->controllersDir, "\n";
    echo $config->database->username, "\n";
    echo $config->mysetting, "\n";

如果你想更好的组织你的项目，你可以在另一个文件保存数组，然后读入它。

.. code-block:: php

    <?php

    use Phalcon\Config;

    require "config/config.php";
    $config = new Config($settings);

读取 INI 文件（Reading INI Files）
----------------------------------
INI文件是存储设置的常用方法。 :doc:`Phalcon\\Config <../api/Phalcon_Config>` 采用优化的PHP函数parse_ini_file读取这些文件。为方便访问，文件部分解析成子设置。

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

你可以阅读如下所示的文件:

.. code-block:: php

    <?php

    use Phalcon\Config\Adapter\Ini as ConfigIni;

    $config = new ConfigIni("path/config.ini");

    echo $config->phalcon->controllersDir, "\n";
    echo $config->database->username, "\n";
    echo $config->models->metadata->adapter, "\n";

合并配置（Merging Configurations）
----------------------------------
:doc:`Phalcon\\Config <../api/Phalcon_Config>` 允许合并配置对象到另一个:

.. code-block:: php

    <?php

    use Phalcon\Config;

    $config = new Config(
        array(
            'database' => array(
                'host'   => 'localhost',
                'dbname' => 'test_db'
            ),
            'debug' => 1
        )
    );

    $config2 = new Config(
        array(
            'database' => array(
                'dbname'   => 'production_db',
                'username' => 'scott',
                'password' => 'secret'
            ),
            'logging' => 1
        )
    );

    $config->merge($config2);

    print_r($config);

上面的代码会产生以下内容:

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

有更多的适配器可用于这个组件： `Phalcon Incubator <https://github.com/phalcon/incubator>`_
