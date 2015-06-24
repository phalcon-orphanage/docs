Class **Phalcon\\Config\\Adapter\\Php**
=======================================

*extends* class :doc:`Phalcon\\Config <Phalcon_Config>`

*implements* Countable, ArrayAccess

Reads php files and converts them to Phalcon\\Config objects.  Given the next configuration file:  

.. code-block:: php

    <?php

    <?php
    return array(
     'database' => array(
         'adapter' => 'Mysql',
         'host' => 'localhost',
         'username' => 'scott',
         'password' => 'cheetah',
         'dbname' => 'test_db'
     ),
    
     phalcon' => array(
        'controllersDir' => '../app/controllers/',
        'modelsDir' => '../app/models/',
        'viewsDir' => '../app/views/'
    ));

  You can read it as follows:  

.. code-block:: php

    <?php

     $config = new Phalcon\Config\Adapter\Php("path/config.php");
     echo $config->phalcon->controllersDir;
     echo $config->database->username;



Methods
-------

public  **__construct** (*unknown* $filePath)

Phalcon\\Config\\Adapter\\Php constructor



public  **offsetExists** (*unknown* $index) inherited from Phalcon\\Config

Allows to check whether an attribute is defined using the array-syntax 

.. code-block:: php

    <?php

     var_dump(isset($config['database']));




public  **get** (*unknown* $index, [*unknown* $defaultValue]) inherited from Phalcon\\Config

Gets an attribute from the configuration, if the attribute isn't defined returns null If the value is exactly null or is not defined the default value will be used instead 

.. code-block:: php

    <?php

     echo $config->get('controllersDir', '../app/controllers/');




public  **offsetGet** (*unknown* $index) inherited from Phalcon\\Config

Gets an attribute using the array-syntax 

.. code-block:: php

    <?php

     print_r($config['database']);




public  **offsetSet** (*unknown* $index, *unknown* $value) inherited from Phalcon\\Config

Sets an attribute using the array-syntax 

.. code-block:: php

    <?php

     $config['database'] = array('type' => 'Sqlite');




public  **offsetUnset** (*unknown* $index) inherited from Phalcon\\Config

Unsets an attribute using the array-syntax 

.. code-block:: php

    <?php

     unset($config['database']);




public *this merged config*  **merge** (*unknown* $config) inherited from Phalcon\\Config

Merges a configuration into the current one 

.. code-block:: php

    <?php

     $appConfig = new \Phalcon\Config(array('database' => array('host' => 'localhost')));
     $globalConfig->merge($config2);




public  **toArray** () inherited from Phalcon\\Config

Converts recursively the object to an array 

.. code-block:: php

    <?php

    print_r($config->toArray());




public  **count** () inherited from Phalcon\\Config

Returns the count of properties set in the config 

.. code-block:: php

    <?php

     print count($config);

or 

.. code-block:: php

    <?php

     print $config->count();




public static  **__set_state** (*unknown* $data) inherited from Phalcon\\Config

Restores the state of a Phalcon\\Config object



private *Config merged config*  **_merge** (*unknown* $config, [*unknown* $instance]) inherited from Phalcon\\Config

Helper method for merge configs (forwarding nested config instance)



