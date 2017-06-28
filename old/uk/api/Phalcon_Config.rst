Class **Phalcon\\Config**
=========================

*implements* `ArrayAccess <http://php.net/manual/en/class.arrayaccess.php>`_, `Countable <http://php.net/manual/en/class.countable.php>`_

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/config.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Phalcon\\Config is designed to simplify the access to, and the use of, configuration data within applications.
It provides a nested object property based user interface for accessing this configuration data within
application code.

.. code-block:: php

    <?php

    $config = new \Phalcon\Config(
        [
            "database" => [
                "adapter"  => "Mysql",
                "host"     => "localhost",
                "username" => "scott",
                "password" => "cheetah",
                "dbname"   => "test_db",
            ],
            "phalcon" => [
                "controllersDir" => "../app/controllers/",
                "modelsDir"      => "../app/models/",
                "viewsDir"       => "../app/views/",
            ],
        ]
    );



Methods
-------

public  **__construct** ([*array* $arrayConfig])

Phalcon\\Config constructor



public  **offsetExists** (*mixed* $index)

Allows to check whether an attribute is defined using the array-syntax

.. code-block:: php

    <?php

    var_dump(
        isset($config["database"])
    );




public  **get** (*mixed* $index, [*mixed* $defaultValue])

Gets an attribute from the configuration, if the attribute isn't defined returns null
If the value is exactly null or is not defined the default value will be used instead

.. code-block:: php

    <?php

    echo $config->get("controllersDir", "../app/controllers/");




public  **offsetGet** (*mixed* $index)

Gets an attribute using the array-syntax

.. code-block:: php

    <?php

    print_r(
        $config["database"]
    );




public  **offsetSet** (*mixed* $index, *mixed* $value)

Sets an attribute using the array-syntax

.. code-block:: php

    <?php

    $config["database"] = [
        "type" => "Sqlite",
    ];




public  **offsetUnset** (*mixed* $index)

Unsets an attribute using the array-syntax

.. code-block:: php

    <?php

    unset($config["database"]);




public  **merge** (:doc:`Phalcon\\Config <Phalcon_Config>` $config)

Merges a configuration into the current one

.. code-block:: php

    <?php

    $appConfig = new \Phalcon\Config(
        [
            "database" => [
                "host" => "localhost",
            ],
        ]
    );

    $globalConfig->merge($appConfig);




public  **toArray** ()

Converts recursively the object to an array

.. code-block:: php

    <?php

    print_r(
        $config->toArray()
    );




public  **count** ()

Returns the count of properties set in the config

.. code-block:: php

    <?php

    print count($config);

or

.. code-block:: php

    <?php

    print $config->count();




public static  **__set_state** (*array* $data)

Restores the state of a Phalcon\\Config object



final protected *Config merged config* **_merge** (*Config* $config, [*mixed* $instance])

Helper method for merge configs (forwarding nested config instance)



