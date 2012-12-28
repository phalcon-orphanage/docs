Reading Configuration
=====================
:doc:`Phalcon\\Config <../api/Phalcon_Config>` 使用相应的适配器读取配置文件，转换为面像对象的方式进行操作配置文件。

File Adapters
-------------
可用的适配器：

+-----------+---------------------------------------------------------------------------------------------------+
| File Type | Description                                                                                       |
+===========+===================================================================================================+
| Ini       | Uses INI files to store settings. Internally the adapter uses the PHP function parse_ini_file.    |
+-----------+---------------------------------------------------------------------------------------------------+
| Array     | Uses PHP multidimensional arrays to store settings. This adapter offers the best performance.     |
+-----------+---------------------------------------------------------------------------------------------------+

原生数组
-------------
下面的示例演示了如何把原生PHP数组转化为 Phalcon\\Config 对象。下面的示例提供了最佳性能，因为在此请求期间，未发生文件读取。

.. code-block:: php

    <?php

    $settings = array(
        "database" => array(
            "adapter"  => "Mysql",
            "host"     => "localhost",
            "username" => "scott",
            "password" => "cheetah",
            "name"     => "test_db",
        ),
         "app" => array(
            "controllersDir" => "../app/controllers/",
            "modelsDir"      => "../app/models/",
            "viewsDir"       => "../app/views/",
        ),
        "mysetting" => "the-value"
    );

    $config = new \Phalcon\Config($settings);

    echo $config->app->controllersDir, "\n";
    echo $config->database->username, "\n";
    echo $config->mysetting, "\n";

如果你想更好的组织你的项目结构，你可以把数组保存到一个单独的文件中，然后读取它。

.. code-block:: php

    <?php

    require "config/config.php";
    $config = new \Phalcon\Config($settings);

读取INI文件
-----------------
INI文件是一种常见的方式来存储设置。Phalcon\\Config 使用优化的PHP函数parse_ini_file读取这些文件。INI文件中的sections部分被解析成子设定，以方便使用。

.. code-block:: ini

    [database]
    adapter  = Mysql
    host     = localhost
    username = scott
    password = cheetah
    name     = test_db

    [phalcon]
    controllersDir = "../app/controllers/"
    modelsDir      = "../app/models/"
    viewsDir       = "../app/views/"

    [models]
    metadata.adapter  = "Memory"

你可以按以下方式读取配件文件：

.. code-block:: php

    <?php

    $config = new \Phalcon\Config\Adapter\Ini("path/config.ini");

    echo $config->phalcon->controllersDir, "\n";
    echo $config->database->username, "\n";
    echo $config->models->metadata->adapter, "\n";

