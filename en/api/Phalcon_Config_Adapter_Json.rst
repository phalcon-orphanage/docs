Class **Phalcon\\Config\\Adapter\\Json**
========================================

*extends* :doc:`Phalcon\\Config <Phalcon_Config>`

*implements* Countable, ArrayAccess

Reads JSON files and converts them to Phalcon\\Config objects.  Given the following configuration file:  

.. code-block:: php

    <?php

    {"phalcon":{"baseuri":"\/phalcon\/"},"models":{"metadata":"memory"}}

  You can read it as follows:  

.. code-block:: php

    <?php

    $config = new Phalcon\Config\Adapter\Json("path/config.json");
    echo $config->phalcon->baseuri;
    echo $config->models->metadata;



Methods
---------

public  **__construct** (*string* $filePath)

Phalcon\\Config\\Adapter\\Json constructor



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




public  **count** () inherited from Phalcon\\Config

...


public static :doc:`Phalcon\\Config <Phalcon_Config>`  **__set_state** (*array* $data) inherited from Phalcon\\Config

Restores the state of a Phalcon\\Config object



public  **__get** (*unknown* $index) inherited from Phalcon\\Config

...


public  **__set** (*unknown* $index, *unknown* $value) inherited from Phalcon\\Config

...


public  **__isset** (*unknown* $index) inherited from Phalcon\\Config

...


