Class **Phalcon\\Config\\Adapter\\Ini**
=======================================

*extends* :doc:`Phalcon\\Config <Phalcon_Config>`

Phalcon\\Config\\Adapter\\Ini   Reads ini files and convert it to Phalcon\\Config objects.   Given the next configuration file:  

.. code-block:: php

    <?php

    
    $config = new Phalcon\Config\Adapter\Ini("path/config.ini")
    echo $config->phalcon->controllersDir;
    echo $config->database->username;
    



   You can read it as follows:  

.. code-block:: php

    <?php

    
    $config = new Phalcon\Config\Adapter\Ini("path/config.ini")
    echo $config->phalcon->controllersDir;
    echo $config->database->username;
    





Methods
---------

:doc:`Phalcon\\Config\\Adapter\\Ini <Phalcon_Config_Adapter_Ini>` **__construct** (*string* **$filePath**)

