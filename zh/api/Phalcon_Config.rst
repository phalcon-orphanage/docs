Class **Phalcon\\Config**
=========================

<<<<<<< HEAD
Phalcon\\Config is designed to simplify the access to, and the use of, configuration data within applications. It provides a nested object property based user interface for accessing this configuration data within application code. 
=======
Phalcon\\Config is designed to simplify the access to, and the use of, configuration data within applications. It provides a nested object property based user interface for accessing this configuration data within application code.  
>>>>>>> 0.7.0

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

<<<<<<< HEAD
public :doc:`Phalcon\\Config <Phalcon_Config>`  **__construct** (*array* $arrayConfig)
=======
public  **__construct** (*array* $arrayConfig)
>>>>>>> 0.7.0

Phalcon\\Config constructor



<<<<<<< HEAD
=======
public static :doc:`Phalcon\\Config <Phalcon_Config>`  **__set_state** (*unknown* $data)

Restores the state of a Phalcon\\Config object



>>>>>>> 0.7.0
