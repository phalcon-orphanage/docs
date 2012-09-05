Class **Phalcon\\Config**
=========================

Phalcon\\Config is designed to simplify the access to, and the use of, configuration data within applications. It provides a nested object property based user interface for accessing this configuration data within application code. 

.. code-block:: php

    <?php

     $config = new Phalcon\Config(array(
      "database" => array(
        "adapter" => "Mysql",
        "host" => "localhost",
        "username" => "scott",
        "password" => "cheetah",
        "name" => "test_db"
      ),
      "phalcon" => array(
        "controllersDir" => "../app/controllers/",
        "modelsDir" => "../app/models/",
        "viewsDir" => "../app/views/"
      )

));


Methods
---------

:doc:`Phalcon\\Config <Phalcon_Config>` public **__construct** (*array* $arrayConfig)

Phalcon\\Config constructor



