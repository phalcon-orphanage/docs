Class **Phalcon\\Config**
=========================

*implements* ArrayAccess

Methods
---------

public  **__construct** ([*array* $arrayConfig])

Phalcon\\Config constructor



public *boolean*  **offsetExists** (*string* $index)

Allows to check whether an attribute is defined using the array-syntax 

.. code-block:: php

    <?php

     var_dump(isset($config['database']));




public *mixed*  **get** (*string* $index, [*mixed* $defaultValue])

Gets an attribute from the configuration, if the attribute isn't defined returns null If the value is exactly null or is not defined the default value will be used instead 

.. code-block:: php

    <?php

     echo $config->get('controllersDir', '../app/controllers/');




public *string*  **offsetGet** (*string* $index)

Gets an attribute using the array-syntax 

.. code-block:: php

    <?php

     print_r($config['database']);




public  **offsetSet** (*string* $index, *mixed* $value)

Sets an attribute using the array-syntax 

.. code-block:: php

    <?php

     $config['database'] = array('type' => 'Sqlite');




public  **offsetUnset** (*string* $index)

Unsets an attribute using the array-syntax 

.. code-block:: php

    <?php

     unset($config['database']);




public  **merge** (:doc:`Phalcon\\Config <Phalcon_Config>` $config)

Merges a configuration into the current one 

.. code-block:: php

    <?php

    $appConfig = new Phalcon\Config(array('database' => array('host' => 'localhost')));
    $globalConfig->merge($config2);




public *array*  **toArray** ()

Converts recursively the object to an array 

.. code-block:: php

    <?php

    print_r($config->toArray());




public static :doc:`Phalcon\\Config <Phalcon_Config>`  **__set_state** (*array* $data)

Restores the state of a Phalcon\\Config object



