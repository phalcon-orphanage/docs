Class **Phalcon\\Config\\Adapter\\Ini**
=======================================

*extends* :doc:`Phalcon\\Config <Phalcon_Config>`

<<<<<<< HEAD
Reads ini files and convert it to Phalcon\\Config objects. Given the next configuration file: 
=======
Reads ini files and convert it to Phalcon\\Config objects.  Given the next configuration file:  
>>>>>>> 0.7.0

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

<<<<<<< HEAD
You can read it as follows: 
=======
  You can read it as follows:  
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    $config = new Phalcon\Config\Adapter\Ini("path/config.ini");
    echo $config->phalcon->controllersDir;
    echo $config->database->username;



Methods
---------

<<<<<<< HEAD
public :doc:`Phalcon\\Config\\Adapter\\Ini <Phalcon_Config_Adapter_Ini>`  **__construct** (*string* $filePath)
=======
public  **__construct** (*string* $filePath)
>>>>>>> 0.7.0

Phalcon\\Config\\Adapter\\Ini constructor



<<<<<<< HEAD
=======
public static :doc:`Phalcon\\Config <Phalcon_Config>`  **__set_state** (*unknown* $data) inherited from Phalcon\\Config

Restores the state of a Phalcon\\Config object



>>>>>>> 0.7.0
