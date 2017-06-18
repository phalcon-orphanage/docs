Class **Phalcon\\Config\\Adapter\\Ini**
=======================================

*extends* class :doc:`Phalcon\\Config <Phalcon_Config>`

*implements* `Countable <http://php.net/manual/en/class.countable.php>`_, `ArrayAccess <http://php.net/manual/en/class.arrayaccess.php>`_

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/config/adapter/ini.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Reads ini files and converts them to Phalcon\\Config objects.

Given the next configuration file:

.. code-block:: ini

    <?php

    [database]
    adapter = Mysql
    host = localhost
    username = scott
    password = cheetah
    dbname = test_db

    [phalcon]
    controllersDir = "../app/controllers/"
    modelsDir = "../app/models/"
    viewsDir = "../app/views/"

You can read it as follows:

.. code-block:: php

    <?php

    $config = new \Phalcon\Config\Adapter\Ini("path/config.ini");

    echo $config->phalcon->controllersDir;
    echo $config->database->username;

PHP constants may also be parsed in the ini file, so if you define a constant
as an ini value before calling the constructor, the constant's value will be
integrated into the results. To use it this way you must specify the optional
second parameter as INI_SCANNER_NORMAL when calling the constructor:

.. code-block:: php

    <?php

    $config = new \Phalcon\Config\Adapter\Ini(
        "path/config-with-constants.ini",
        INI_SCANNER_NORMAL
    );



Methods
-------

public  **__construct** (*mixed* $filePath, [*mixed* $mode])

Phalcon\\Config\\Adapter\\Ini constructor



protected  **_parseIniString** (*mixed* $path, *mixed* $value)

Build multidimensional array from string

.. code-block:: php

    <?php

    $this->_parseIniString("path.hello.world", "value for last key");

    // result
    [
         "path" => [
             "hello" => [
                 "world" => "value for last key",
             ],
         ],
    ];




protected  **_cast** (*mixed* $ini)

We have to cast values manually because parse_ini_file() has a poor implementation.



public  **offsetExists** (*mixed* $index) inherited from :doc:`Phalcon\\Config <Phalcon_Config>`

Allows to check whether an attribute is defined using the array-syntax

.. code-block:: php

    <?php

    var_dump(
        isset($config["database"])
    );




public  **get** (*mixed* $index, [*mixed* $defaultValue]) inherited from :doc:`Phalcon\\Config <Phalcon_Config>`

Gets an attribute from the configuration, if the attribute isn't defined returns null
If the value is exactly null or is not defined the default value will be used instead

.. code-block:: php

    <?php

    echo $config->get("controllersDir", "../app/controllers/");




public  **offsetGet** (*mixed* $index) inherited from :doc:`Phalcon\\Config <Phalcon_Config>`

Gets an attribute using the array-syntax

.. code-block:: php

    <?php

    print_r(
        $config["database"]
    );




public  **offsetSet** (*mixed* $index, *mixed* $value) inherited from :doc:`Phalcon\\Config <Phalcon_Config>`

Sets an attribute using the array-syntax

.. code-block:: php

    <?php

    $config["database"] = [
        "type" => "Sqlite",
    ];




public  **offsetUnset** (*mixed* $index) inherited from :doc:`Phalcon\\Config <Phalcon_Config>`

Unsets an attribute using the array-syntax

.. code-block:: php

    <?php

    unset($config["database"]);




public  **merge** (:doc:`Phalcon\\Config <Phalcon_Config>` $config) inherited from :doc:`Phalcon\\Config <Phalcon_Config>`

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




public  **toArray** () inherited from :doc:`Phalcon\\Config <Phalcon_Config>`

Converts recursively the object to an array

.. code-block:: php

    <?php

    print_r(
        $config->toArray()
    );




public  **count** () inherited from :doc:`Phalcon\\Config <Phalcon_Config>`

Returns the count of properties set in the config

.. code-block:: php

    <?php

    print count($config);

or

.. code-block:: php

    <?php

    print $config->count();




public static  **__set_state** (*array* $data) inherited from :doc:`Phalcon\\Config <Phalcon_Config>`

Restores the state of a Phalcon\\Config object



final protected *Config merged config* **_merge** (*Config* $config, [*mixed* $instance]) inherited from :doc:`Phalcon\\Config <Phalcon_Config>`

Helper method for merge configs (forwarding nested config instance)



