Class **Phalcon\\Config\\Adapter\\Yaml**
========================================

*extends* class :doc:`Phalcon\\Config <Phalcon_Config>`

*implements* Countable, ArrayAccess

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/config/adapter/yaml.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Reads YAML files and converts them to Phalcon\\Config objects.  Given the following configuration file:  

.. code-block:: php

    <?php

     phalcon:
       baseuri:        /phalcon/
       controllersDir: !approot  /app/controllers/
     models:
       metadata: memory

  You can read it as follows:  

.. code-block:: php

    <?php

     define('APPROOT', dirname(__DIR__));
    
     $config = new Phalcon\Config\Adapter\Yaml("path/config.yaml", [
         '!approot' => function($value) {
             return APPROOT . $value;
         }
     ]);
    
     echo $config->phalcon->controllersDir;
     echo $config->phalcon->baseuri;
     echo $config->models->metadata;



Methods
-------

public  **__construct** (*mixed* $filePath, [*array* $callbacks])

Phalcon\\Config\\Adapter\\Yaml constructor



public  **offsetExists** (*mixed* $index) inherited from Phalcon\\Config

Allows to check whether an attribute is defined using the array-syntax 

.. code-block:: php

    <?php

     var_dump(isset($config['database']));




public  **get** (*mixed* $index, [*mixed* $defaultValue]) inherited from Phalcon\\Config

Gets an attribute from the configuration, if the attribute isn't defined returns null If the value is exactly null or is not defined the default value will be used instead 

.. code-block:: php

    <?php

     echo $config->get('controllersDir', '../app/controllers/');




public  **offsetGet** (*mixed* $index) inherited from Phalcon\\Config

Gets an attribute using the array-syntax 

.. code-block:: php

    <?php

     print_r($config['database']);




public  **offsetSet** (*mixed* $index, *mixed* $value) inherited from Phalcon\\Config

Sets an attribute using the array-syntax 

.. code-block:: php

    <?php

     $config['database'] = array('type' => 'Sqlite');




public  **offsetUnset** (*mixed* $index) inherited from Phalcon\\Config

Unsets an attribute using the array-syntax 

.. code-block:: php

    <?php

     unset($config['database']);




public  **merge** (:doc:`Phalcon\\Config <Phalcon_Config>` $config) inherited from Phalcon\\Config

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




public static  **__set_state** (*array* $data) inherited from Phalcon\\Config

Restores the state of a Phalcon\\Config object



final protected *Config merged config*  **_merge** (*Config* $config, [*mixed* $instance]) inherited from Phalcon\\Config

Helper method for merge configs (forwarding nested config instance)



