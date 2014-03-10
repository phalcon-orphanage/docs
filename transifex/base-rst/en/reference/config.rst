%{config_7aace998d2b823d2bade087c56c195b2}%
======================
%{config_4cc78dc359d25e5a76b6d8e5d9e8602c|:doc:`Phalcon\\Config <../api/Phalcon_Config>`}%

%{config_3bb7a0e24926eb4b6474c7c719359e62}%
-------------
%{config_159270e976fea8c07aeb4890470109eb}%

+-----------+---------------------------------------------------------------------------------------------------+
| File Type | Description                                                                                       |
+===========+===================================================================================================+
| Ini       | Uses INI files to store settings. Internally the adapter uses the PHP function parse_ini_file.    |
+-----------+---------------------------------------------------------------------------------------------------+
| Array     | Uses PHP multidimensional arrays to store settings. This adapter offers the best performance.     |
+-----------+---------------------------------------------------------------------------------------------------+


%{config_bc1cde98089e26b0bef7655a83b83124}%
-------------
%{config_cdc52ab5db8bfb6f482dcf21c98b48ec}%

.. code-block:: php

    <?php

    $settings = array(
        "database" => array(
            "adapter"  => "Mysql",
            "host"     => "localhost",
            "username" => "scott",
            "password" => "cheetah",
            "dbname"     => "test_db",
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


%{config_837fe0ba814526983e312e1180d7c522}%

.. code-block:: php

    <?php

    require "config/config.php";
    $config = new \Phalcon\Config($settings);


%{config_7708d5b9f14191306a80322e64ab347c}%
-----------------
%{config_2dc5fd108360f45b49fcc5bf77d89296}%

.. code-block:: ini

    [database]
    adapter  = Mysql
    host     = localhost
    username = scott
    password = cheetah
    dbname     = test_db

    [phalcon]
    controllersDir = "../app/controllers/"
    modelsDir      = "../app/models/"
    viewsDir       = "../app/views/"

    [models]
    metadata.adapter  = "Memory"


%{config_2535c61c5ca2e6e27dcb5c184b42a894}%

.. code-block:: php

    <?php

    $config = new \Phalcon\Config\Adapter\Ini("path/config.ini");

    echo $config->phalcon->controllersDir, "\n";
    echo $config->database->username, "\n";
    echo $config->models->metadata->adapter, "\n";


%{config_b427b34340f6904f9bff330505fb4893}%
----------------------
%{config_97f80a55499548203fcc6d2e65086bd1}%

.. code-block:: php

    <?php

    $config = new \Phalcon\Config(array(
        'database' => array(
            'host' => 'localhost',
            'dbname' => 'test_db'
        ),
        'debug' => 1
    ));

    $config2 = new \Phalcon\Config(array(
        'database' => array(
            'username' => 'scott',
            'password' => 'secret',
        )
    ));

    $config->merge($config2);

    print_r($config);


%{config_fd2d8d7d95f347d4a8b7c8c188c606f1}%

.. code-block:: html

    Phalcon\Config Object
    (
        [database] => Phalcon\Config Object
            (
                [host] => localhost
                [dbname] => test_db
                [username] => scott
                [password] => secret
            )
        [debug] => 1
    )


