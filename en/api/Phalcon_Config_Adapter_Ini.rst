Class **Phalcon\\Config\\Adapter\\Ini**
=======================================

*extends* :doc:`Phalcon\\Config <Phalcon_Config>`

*implements* ArrayAccess

Reads ini files and convert it to Phalcon\\Config objects.  Given the next configuration file:  

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

public  **__construct** (*string* $filePath)

Phalcon\\Config\\Adapter\\Ini constructor



public *boolean*  **offsetExists** (*string* $index) inherited from Phalcon\\Config

Allows to check whether an attribute is defined using the array-syntax 

.. code-block:: php

    <?php

     var_dump(isset($config['database']));




public *mixed*  **get** (*string* $index, [*mixed* $defaultValue]) inherited from Phalcon\\Config

Gets an attribute from the configuration, if the attribute isn't defined returns null If the value is exactly null or is not defined the default value will be used instead 

.. code-block:: php

    <?php

     echo $config->get('controllersDir', '../app/controllers/');




public *string*  **offsetGet** (*string* $index) inherited from Phalcon\\Config

Gets an attribute using the array-syntax 

.. code-block:: php

    <?php

     print_r($config['database']);




public  **offsetSet** (*string* $index, *mixed* $value) inherited from Phalcon\\Config

Sets an attribute using the array-syntax 

.. code-block:: php

    <?php

     $config['database'] = array('type' => 'Sqlite');




public  **offsetUnset** (*string* $index) inherited from Phalcon\\Config

Unsets an attribute using the array-syntax 

.. code-block:: php

    <?php

     unset($config['database']);




public  **merge** (:doc:`Phalcon\\Config <Phalcon_Config>` $config) inherited from Phalcon\\Config

Merges a configuration into the current one 

.. code-block:: php

    <?php

    $appConfig = new Phalcon\Config(array('database' => array('host' => 'localhost')));
    $globalConfig->merge($config2);




public *array*  **toArray** () inherited from Phalcon\\Config

Converts recursively the object to an array 

.. code-block:: php

    <?php

    print_r($config->toArray());




public static :doc:`Phalcon\\Config <Phalcon_Config>`  **__set_state** (*array* $data) inherited from Phalcon\\Config

Restores the state of a Phalcon\\Config object



