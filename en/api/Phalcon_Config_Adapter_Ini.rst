Class **Phalcon\\Config\\Adapter\\Ini**
=======================================

*extends* :doc:`Phalcon\\Config <Phalcon_Config>`

Reads ini files and convert it to Phalcon\\Config objects. Given the next configuration file: 

.. code-block:: ini

    <?php

    [database]
    adapter = Mysql
    host = localhost
    username = scott
    password = cheetah
    name = test_db
    
    [phalcon]
    controllersDir = "../app/controllers/"
    modelsDir = "../app/models/"
    viewsDir = "../app/views/"

You can read it as follows: 

.. code-block:: php

    <?php

    $config = new Phalcon\Config\Adapter\Ini("path/config.ini");
    echo $config->phalcon->controllersDir;
    echo $config->database->username;



Methods
---------

public :doc:`Phalcon\\Config\\Adapter\\Ini <Phalcon_Config_Adapter_Ini>`  **__construct** (*string* $filePath)

Phalcon\\Config\\Adapter\\Ini constructor



