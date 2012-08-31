Class **Phalcon\\Logger**
=========================

Phalcon\\Logger   Phalcon\\Logger is a component whose purpose is to create logs using  different backends via adapters, generating options, formats and filters  also implementing transactions.  

.. code-block:: php

    <?php

    
    $logger = new Phalcon\Logger\Adapter\File("app/logs/test.log");
    $logger->log("This is a message");
    $logger->log("This is an error", Phalcon\Logger::ERROR);
    $logger->error("This is another error");
    $logger->close();
     





Constants
---------

integer **SPECIAL**

integer **CUSTOM**

integer **DEBUG**

integer **INFO**

integer **NOTICE**

integer **WARNING**

integer **ERROR**

integer **ALERT**

integer **CRITICAL**

integer **EMERGENCE**

Methods
---------

**debug** (*string* **$message**)

**error** (*string* **$message**)

**info** (*string* **$message**)

**notice** (*string* **$message**)

**warning** (*string* **$message**)

**alert** (*string* **$message**)

**log** (*unknown* **$message**, *unknown* **$type**)

