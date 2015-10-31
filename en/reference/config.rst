Reading Configurations
======================

:doc:`Phalcon\\Config <../api/Phalcon_Config>` is a component used to read configuration files of various formats (using adapters) into
PHP objects for use in an application.

File Adapters
-------------
The adapters available are:

+-----------+------------------------------------------------------------------------------------------------+
| File Type | Description                                                                                    |
+===========+================================================================================================+
| Ini       | Uses INI files to store settings. Internally the adapter uses the PHP function parse_ini_file. |
+-----------+------------------------------------------------------------------------------------------------+
| Array     | Uses PHP multidimensional arrays to store settings. This adapter offers the best performance.  |
+-----------+------------------------------------------------------------------------------------------------+

Native Arrays
-------------
The next example shows how to convert native arrays into :doc:`Phalcon\\Config <../api/Phalcon_Config>` objects. This option offers the best performance since no files are
read during this request.

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

If you want to better organize your project you can save the array in another file and then read it.

.. code-block:: php

    <?php

    use Phalcon\Config;

    require "config/config.php";
    $config = new Config($settings);

Reading INI Files
-----------------
Ini files are a common way to store settings. :doc:`Phalcon\\Config <../api/Phalcon_Config>` uses the optimized PHP function parse_ini_file to read these files. Files sections are parsed into sub-settings for easy access.

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

You can read the file as follows:

.. code-block:: php

    <?php

    use Phalcon\Config\Adapter\Ini as ConfigIni;

    $config = new ConfigIni("path/config.ini");

    echo $config->phalcon->controllersDir, "\n";
    echo $config->database->username, "\n";
    echo $config->models->metadata->adapter, "\n";

Merging Configurations
----------------------
:doc:`Phalcon\\Config <../api/Phalcon_Config>` can recursively merge the properties of one configuration object into another.
New properties are added and existing properties are updated.

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

The above code produces the following:

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

There are more adapters available for this components in the `Phalcon Incubator <https://github.com/phalcon/incubator>`_
