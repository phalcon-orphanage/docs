Class **Phalcon\\Config**
=========================

*implements* ArrayAccess, Countable

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/config.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Phalcon\\Config is designed to simplify the access to, and the use of, configuration data within applications. It provides a nested object property based user interface for accessing this configuration data within application code.  

.. code-block:: php

    <?php

    $config = new \Phalcon\Config(array(
    	"database" => array(
    		"adapter" => "Mysql",
    		"host" => "localhost",
    		"username" => "scott",
    		"password" => "cheetah",
    		"dbname" => "test_db"
    	),
    	"phalcon" => array(
    		"controllersDir" => "../app/controllers/",
    		"modelsDir" => "../app/models/",
    		"viewsDir" => "../app/views/"
    	)
     ));



Methods
-------

public  **__construct** ([*unknown* $arrayConfig])

Phalcon\\Config constructor



public  **offsetExists** (*unknown* $index)

Allows to check whether an attribute is defined using the array-syntax 

.. code-block:: php

    <?php

     var_dump(isset($config['database']));




public  **get** (*unknown* $index, [*unknown* $defaultValue])

Gets an attribute from the configuration, if the attribute isn't defined returns null If the value is exactly null or is not defined the default value will be used instead 

.. code-block:: php

    <?php

     echo $config->get('controllersDir', '../app/controllers/');




public  **offsetGet** (*unknown* $index)

Gets an attribute using the array-syntax 

.. code-block:: php

    <?php

     print_r($config['database']);




public  **offsetSet** (*unknown* $index, *unknown* $value)

Sets an attribute using the array-syntax 

.. code-block:: php

    <?php

     $config['database'] = array('type' => 'Sqlite');




public  **offsetUnset** (*unknown* $index)

Unsets an attribute using the array-syntax 

.. code-block:: php

    <?php

     unset($config['database']);




public  **merge** (*unknown* $config)

Merges a configuration into the current one 

.. code-block:: php

    <?php

     $appConfig = new \Phalcon\Config(array('database' => array('host' => 'localhost')));
     $globalConfig->merge($config2);




public  **toArray** ()

Converts recursively the object to an array 

.. code-block:: php

    <?php

    print_r($config->toArray());




public  **count** ()

Returns the count of properties set in the config 

.. code-block:: php

    <?php

     print count($config);

or 

.. code-block:: php

    <?php

     print $config->count();




public static  **__set_state** (*unknown* $data)

Restores the state of a Phalcon\\Config object



final protected *Config merged config*  **_merge** (*Config* $config, [*unknown* $instance])

Helper method for merge configs (forwarding nested config instance)



