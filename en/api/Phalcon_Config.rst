Class **Phalcon_Config**
========================

Phalcon_Config is designed to simplify the access to, and the use of, configuration data within applications. It provides an object with nested properties for accessing the configuration data within application code.   

.. code-block:: php

    <?php

    $config = new Phalcon_Config(
        array(
            "database" => array(
                "adapter"  => "Mysql",
                "host"     => "localhost",
                "username" => "scott",
                "password" => "cheetah",
                "name"     => "test_db",
            ),
            "phalcon" => array(
                "controllersDir" => "../app/controllers/",
                "modelsDir"      => "../app/models/",
                "viewsDir"       => "../app/views/",
            )
        )
    );

Methods
---------

**Phalcon\Config** **__construct** (array $arrayConfig)

Phalcon_Config constructor

